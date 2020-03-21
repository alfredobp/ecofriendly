<?php

namespace app\controllers;

use Yii;
use app\models\Feeds;
use app\models\FeedsSearch;
use app\models\ImagenForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FeedsController implements the CRUD actions for Feeds model.
 */
class FeedsController extends Controller
{

    public $contenido;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Feeds models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feeds model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Feeds model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feeds();
        $model2 = new ImagenForm();
        $contenido = $_POST['contenido'];
        //CAMBIAR
        if (true) {
            $model2->imagen = UploadedFile::getInstance($model, 'imagen');
            $feed = new Feeds();
            $feed->usuariosid = Yii::$app->user->identity->id;
            $feed->contenido = $contenido;
            $feed->created_at = date('Y-m-d H:i:s');
            $feed->save();
            return $this->redirect(['site/index', 'id' => $model->id]);
        }
    }

    /**
     * Updates an existing Feeds model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Feeds model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionImagen($id)
    {
        $model = new ImagenForm();

        if (Yii::$app->request->isPost) {
            $model->imagen = UploadedFile::getInstance($model, 'imagen');
            if ($model->upload($id)) {
                return $this->redirect('index');
            }
        }

        return $this->render('imagen', [
            'model' => $model,
        ]);
    }
    /**
     * Finds the Feeds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feeds the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feeds::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
