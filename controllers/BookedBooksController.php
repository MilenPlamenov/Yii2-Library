<?php

namespace app\controllers;

use app\models\BookedBooks;
use app\models\BookedBooksSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookedBooksController implements the CRUD actions for BookedBooks model.
 */
class BookedBooksController extends Controller
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
                    'only' => ['create', 'view', 'index', 'add-to-cart'],
                    'rules' => [
                        [
                            'actions' => ['create', 'view', 'index', 'update'],
                            'allow' => true,
                            'roles' => ['@'], // @ for auth users ? for guest users
                        ],
                        [
                            'actions' => ['add-to-cart'],
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
                        'add-to-cart' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all BookedBooks models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookedBooksSearch();
        if (!Yii::$app->user->identity->isAdminOrLibrarian()) {
            $searchModel->user_id = Yii::$app->user->identity->id;
        } else {
            if (isset($_SESSION['selected_user'])) {
                $searchModel->user_id = $_SESSION['selected_user'];
            } else {
                throw new BadRequestHttpException('Please select user first !');
            }
        }
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BookedBooks model.
     * @param int $id Booking ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BookedBooks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BookedBooks();
        $model->user_id = Yii::$app->user->identity->id;
        $model->book_id = Yii::$app->request->get('id');
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->amount > 0 && $model->book->available_books >= $model->amount) {
                    $model->book->available_books -= $model->amount;
                    $model->book->save();
                    $model->save();
                    Yii::$app->session->setFlash('success', $model->book->title .
                        ' booked successfully.Make sure you visit the library till one day to take your books :)');

                    return $this->redirect(['book/index']);
                } else {
                    Yii::$app->session->setFlash('error', "Invalid data!");
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookedBooks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Booking ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user->id == Yii::$app->user->identity->id or Yii::$app->user->identity->isAdminOrLibrarian()) {
            $oldAmount = $model->amount;

            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->book->available_books += $oldAmount;
                if ($model->book->available_books - $model->amount >= 0 && $model->amount > 0) {
                    $model->book->available_books -= $model->amount;
                    $model->save();
                    $model->book->save();
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', "Invalid data!");
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        throw new ForbiddenHttpException('You are not able to perform this action!');
    }

    /**
     * Deletes an existing BookedBooks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Booking ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if ($model->user->id == Yii::$app->user->identity->id or Yii::$app->user->identity->isAdminOrLibrarian()) {

            $model->book->available_books += $model->amount;
            $model->book->save();
            $model->delete();

            return $this->redirect(['index']);
        }
        throw new ForbiddenHttpException('You dont have permission to perform this action!');
    }

    public function actionAddToCart() {
        if ($this->request->isPost) {
            $user = User::find()->where(['id' => $_SESSION['selected_user']]);
            $booked_books = BookedBooks::find()
                ->where(['user_id' => $_SESSION['selected_user']])
                ->andWhere(['ordered' => 0])->all();
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            foreach ($booked_books as $key => $value){
                $items = [];
                $items += ['book_id' => $value['attributes']['book_id']];
                $items += ['amount' => $value['attributes']['amount']];
                $items += ['booked_books_id' => $value['attributes']['id']];
                $value->ordered = 1;
                $value->save();
                $_SESSION['cart'][$_SESSION['selected_user']][] = $items;
            }
            return $this->redirect(Url::toRoute(['user/cart']));

        }
    }

    /**
     * Finds the BookedBooks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Booking ID
     * @return BookedBooks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookedBooks::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
