<?php

namespace app\controllers;

use app\models\BookedBooksSearch;
use app\models\TakenBooks;
use app\models\TakenBooksSearch;
use app\models\User;
use app\models\UserSearch;
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
                    'only' => ['update', 'delete', 'index', 'add-live-record'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'index', 'add-live-record'],
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

    public function actionAddLiveRecord($user_id) {
        $model = new TakenBooks();

        $model->user_id = $user_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->amount = Yii::$app->request->post()['TakenBooks']['amount'];
                $model->book_id = Yii::$app->request->post()['TakenBooks']['book_id'];
                if ($model->amount > 0 && $model->book->available_books >= $model->amount) {
                    $model->book->available_books -= $model->amount;
                    if ($model->book->save() && $model->save()) {
                        Yii::$app->session->setFlash('success', 'Successfully ordered ' . $model->book->title
                            . ' amount of ' . $model->amount);
                        return $this->redirect(['add-live-record', 'user_id' => $model->user_id]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Invalid data!');
                    $model->loadDefaultValues();
                }
            }
        }
        return $this->render('add-live-record', [
            'model' => $model,
            ]);

    }

    public function actionCurrentlyTakenBooks($id) {
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

    protected function hashNewPassword($model) {
        $hash = Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
        $model->password = $hash;
    }

    public function actionChangePassword($id) {
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
