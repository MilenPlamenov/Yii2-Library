<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookedBooksSearch;
use app\models\TakenBooks;
use app\models\TakenBooksSearch;
use app\models\User;
use app\models\UserSearch;
use Codeception\Constraint\Page;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['update', 'delete', 'index', 'add-live-record', 'cart', 'remove-from-cart', 'setup-add-live-record', 'clear'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'index', 'add-live-record', 'cart', 'remove-from-cart', 'setup-add-live-record', 'clear'],
                            'allow' => true,
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdminOrLibrarian();
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'remove-from-cart' => ['POST'],
                        'add-amount' => ['POST'],
                        'remove-amount' => ['POST'],
                        'setup-add-live-record' => ['POST'],
                        'clear' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionRemoveFromCart($user_id, $item_id)
    {
        if ($this->request->isPost) {
            $item = $_SESSION['cart'][$user_id][$item_id];
            unset($_SESSION['cart'][$user_id][$item_id]);

            if (!count($_SESSION['cart'][$user_id])) {
                unset($_SESSION['cart'][$user_id]);
                unset($_SESSION['selected_user']);
            }

            return $this->renderAjax('_buttons', [
                'user_id' => $user_id,
                'book_and_amount_array' => $item,
                'index' => $item_id,
            ]);

        }
    }


    public function actionAddAmount($user_id, $item_id)
    {
        if ($this->request->isPost) {
            $item = $_SESSION['cart'][$user_id][$item_id];
            $book = Book::find()->where(['id' => $item['book_id']])->one();

            if ($book->available_books >= $item['amount'] + 1) {
                $item['amount'] += 1;
                $_SESSION['cart'][$user_id][$item_id] = $item;
                // here !!
            } else {
                Yii::$app->session->setFlash('error', 'Amount overflow');
            }
            return $this->renderAjax('_buttons', [
                'user_id' => $user_id,
                'book_and_amount_array' => $item,
                'index' => $item_id,
            ]);
        }
    }

    public function actionRemoveAmount($user_id, $item_id)
    {
        if ($this->request->isPost) {
            $item = $_SESSION['cart'][$user_id][$item_id];
            if ($item['amount'] - 1 <= 0) {
                $item['amount'] = 1;
            } else {
                $item['amount'] -= 1;
                $_SESSION['cart'][$user_id][$item_id] = $item;
            }
            return $this->renderAjax('_buttons', [
                'user_id' => $user_id,
                'book_and_amount_array' => $item,
                'index' => $item_id,
            ]);
        }
    }


    public function actionClear() {
        if ($this->request->isPost) {
            unset($_SESSION['cart'][$_SESSION['selected_user']]);
            unset($_SESSION['selected_user']);
            return $this->redirect('index');

        }
    }

    public function actionSetupAddLiveRecord($user_id) {
        if ($this->request->isPost) {
            if (!isset($_SESSION['selected_user']) or empty($_SESSION['selected_user'])) {
                $_SESSION['selected_user'] = $user_id;
                $_SESSION['cart'][$user_id] = [];
            } else {
                throw new BadRequestHttpException('Already selected user');
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['book/index']));
        }
    }

    public function actionAddLiveRecord($book_id)
    {
        $user = User::find()->where(['id' => $_SESSION['selected_user']])->one();
        $items = [];
        if ($this->request->isPost) {
            $book = Book::find()->where(['id' => $book_id])->one();
            if ($book) {
                $amount = Yii::$app->request->post()['User']['amount'];
                if ($amount > 0 && $book->available_books >= $amount) {
                    $items += Yii::$app->request->post()['User'];
                    $items += ['book_id' => $book_id];
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    $_SESSION['cart'][$_SESSION['selected_user']][] = $items;
                    return 1;
                } else {
//                    Yii::$app->session->setFlash('error', 'Amount overflow!');
                    return 0;
                }
            } else {
//                Yii::$app->session->setFlash('error', 'Book with this ID does not exist!');
                return 0;
            }


        }
        return $this->renderAjax('add-live-record', [
            'user' => $user,
        ]);
    }

    public function actionCart()
    {
        if ($this->request->isPost) {
            if (isset($_SESSION['cart'])) {

                foreach ($_SESSION['cart'] as $key => $items) {
                    foreach ($items as $idx => $value) {
                        $model = new TakenBooks();
                        $model->book_id = $value['book_id'];
                        $model->user_id = $key;

                        if ($model->book->available_books >= $value['amount']) {
                            if (isset($value['booked_books_id'])) {
                                $model->booked_books_id = $value['booked_books_id'];
                            }

                            $model->book->available_books -= $value['amount'];
                            $model->amount = $value['amount'];

                            if ($model->book->save() && $model->save()) {
                                Yii::$app->session->setFlash('success', 'Successfully ordered ' . $model->book->title
                                    . ' amount of ' . $model->amount);
                                unset($_SESSION['cart'][$key][$idx]);
                                if (!count($_SESSION['cart'][$key])) {
                                    unset($_SESSION['cart'][$key]);
                                    unset($_SESSION['selected_user']);
                                }

                                $this->redirect('index');
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Amount overflow!!');
                            $this->redirect('cart');
                        }
                    }
                }
            }
        }
        return $this->render('cart');
    }

    public function actionCurrentlyTakenBooks($id)
    {
        $user = $this->findModel($id);
        $searchModel = new TakenBooksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $user->id, 0);

        return $this->render('currently-taken-books', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => $user,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new BookedBooksSearch();
        $searchModel->user_id = $model->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function hashNewPassword($model)
    {
        $hash = Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
        $model->password = $hash;
    }

    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validatePassword($model->old_password)) {
                $this->hashNewPassword($model);
                $model->save();
                Yii::$app->session->setFlash('success', "Password set successfully!");

                return $this->redirect(['book/index']);
            } else {
                Yii::$app->session->setFlash('error', "Incorrect password!");
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
