<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookedBooks;
use app\models\BookSearch;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
                    'only' => ['update', 'delete', 'create', 'view'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'create'],
                            'allow' => true,
                            'roles' => ['@'], // @ for auth users ? for guest users
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdminOrLibrarian();
                            }
                        ],
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['@'],
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
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function uploadPhoto($model, $attr) {
        $model->save();
        $image = UploadedFile::getInstance($model, $attr);
        if ($image) {
            $imgName = $attr[0] . $model->isbn . '.' . $image->getExtension();
            $image->saveAs(Yii::getAlias('@bookImgPath') . '/' .$imgName);
            $model->$attr = $imgName;
            $model->save();
        }
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $this->uploadPhoto($model, 'front_photo');
                $this->uploadPhoto($model, 'rear_photo');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $front_img = $model->front_photo;
        $rear_img = $model->rear_photo;
        if ($this->request->isPost && $model->load($this->request->post())) {
            $this->uploadPhoto($model, 'front_photo');
            $this->uploadPhoto($model, 'rear_photo');
            if (!$model->front_photo) {
                $model->front_photo = $front_img;
            }
            if (!$model->rear_photo) {
                $model->rear_photo = $rear_img;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        unlink(Yii::getAlias('@bookImgPath') . '/'. $model->front_photo);
        unlink(Yii::getAlias('@bookImgPath') . '/'. $model->rear_photo);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
