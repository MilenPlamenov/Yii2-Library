<?php

namespace app\controllers;

use app\models\TakenBooks;
use app\models\TakenBooksSearch;
use DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TakenBooksController implements the CRUD actions for TakenBooks model.
 */
class TakenBooksController extends Controller
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
                    'only' => ['create', 'view', 'index', 'update', 'return'],
                    'rules' => [
                        [
                            'actions' => ['create', 'view', 'update', 'return'],
                            'allow' => true,
                            'roles' => ['@'], // @ for auth users ? for guest users
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdminOrLibrarian();
                            },
                        ],
                        [
                            'actions' => ['view', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],

                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'create' => ['POST'],
                        'return' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TakenBooks models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TakenBooksSearch();
        if (!Yii::$app->user->identity->isAdminOrLibrarian()) {
            $searchModel->user_id = Yii::$app->user->identity->id;
        }
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TakenBooks model.
     * @param int $taking_id Taking ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($taking_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($taking_id),
        ]);
    }

    public function actionReturn($taking_id) {
        $model = $this->findModel($taking_id);
        $model->returned = 1;
        $model->returned_date = date('Y-m-d H:i:s');
        $model->book->available_books += $model->amount;
        if ($model->book->save() && $model->save()) {
            return $this->redirect(['taken-books/index']);
        } else {
            throw new BadRequestHttpException('Something went wrong');
        }
    }

    /**
     * Creates a new TakenBooks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TakenBooks();
        $model->booked_books_id = Yii::$app->request->get('id');

        $model->bookedBooks->ordered = true;

        $model->user_id = $model->bookedBooks->user_id;
        $model->book_id = $model->bookedBooks->book_id;
        $model->amount = $model->bookedBooks->amount;
        if ($model->save() && $model->bookedBooks->save()) {
            return $this->redirect(['index']);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TakenBooks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $taking_id Taking ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($taking_id)
    {
        $model = $this->findModel($taking_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'taking_id' => $model->taking_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TakenBooks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $taking_id Taking ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($taking_id)
    {
        $this->findModel($taking_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TakenBooks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $taking_id Taking ID
     * @return TakenBooks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($taking_id)
    {
        if (($model = TakenBooks::findOne(['taking_id' => $taking_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
