<?php

namespace app\controllers;

use app\models\Feeds;
use Yii;
use app\models\FeedsFavoritos;
use app\models\FeedsFavoritosSearch;
use app\models\Notificaciones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeedsFavoritosController implements the CRUD actions for FeedsFavoritos model.
 */
class FeedsFavoritosController extends Controller
{
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
     * Lists all FeedsFavoritos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedsFavoritosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeedsFavoritos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $notificacionLeida = Notificaciones::find()->where(['id_evento' => $id])->one();
        $notificacionLeida->leido = true;
        if ($notificacionLeida->validate()) {
            $notificacionLeida->update();
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FeedsFavoritos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeedsFavoritos();
        $model->usuario_id = Yii::$app->user->identity->id;
        $notificacion = new Notificaciones();

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $yaMeGusta = FeedsFavoritos::find()->where(['usuario_id' => Yii::$app->user->identity->id])
                ->andWhere(['feed_id' => $model->feed_id])->one();
            $model->save();
            if ($yaMeGusta == null) {
                $dueño = Feeds::find()->select('usuariosid')->where(['id' => $model->feed_id])->one();
                if ($dueño->usuariosid != Yii::$app->user->identity->id) {
                    $notificacion->usuario_id = $dueño->usuariosid;
                    $notificacion->seguidor_id = Yii::$app->user->identity->id;
                    $notificacion->leido = false;
                    $notificacion->tipo_notificacion_id = 2;
                    $notificacion->id_evento = $model->id;
                    $notificacion->save();
                }



                return $this->redirect(['site/index']);
            }

            Yii::$app->session->setFlash('error', 'Ya has hecho me gusta en este feed');
            return $this->redirect(['site/index']);
        }
        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }

    /**
     * Updates an existing FeedsFavoritos model.
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
     * Deletes an existing FeedsFavoritos model.
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

    /**
     * Finds the FeedsFavoritos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeedsFavoritos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeedsFavoritos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
