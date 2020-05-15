<?php

namespace app\controllers;

use Yii;
use app\models\MensajesPrivados;
use app\models\MensajesPrivadosSearch;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensajesPrivadosController implements the CRUD actions for MensajesPrivados model.
 */
class MensajesPrivadosController extends Controller
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
     * Lists all MensajesPrivados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MensajesPrivadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = MensajesPrivados::find()->where(['emisor_id' => Yii::$app->user->identity->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MensajesPrivados model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = MensajesPrivados::find()->where(['id' => $id])->one();
        //Si el usuario que visualizar el mensaje es el receptor del mismo
        //se pone como viste y se le añade la fecha de visualización
        if ($model->receptor_id === Yii::$app->user->identity->id) {
            $model->visto_dat = date('Y-m-d H:i:s');
            $model->seen = true;
            $model->save();
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Responder
     * Función que responde a mensaje previamente enviado al usuario
     * Se conserva el asunto, añadiendo el prefijo Re: para indicar que corresponde a un mensaje de respuesta.
     * @param [type] $id
     * @return void
     */
    public function actionResponder($id)
    {

        $model = MensajesPrivados::find()->where(['id' => $id])->one();

        $nuevoMensaje = new MensajesPrivados();
        $nuevoMensaje->emisor_id = Yii::$app->user->identity->id;
        $nuevoMensaje->receptor_id = $model->emisor_id;
        $nuevoMensaje->asunto = 'Re:' . $model->asunto;
        if ($nuevoMensaje->load(Yii::$app->request->post()) && $nuevoMensaje->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('_responder', [
            'model' => $nuevoMensaje,
        ]);
    }
    /**
     * Creates a new MensajesPrivados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MensajesPrivados();
        $model->emisor_id = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mensaje enviado correctamente.');
            return $this->redirect(['site/index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'usuarios' => Usuarios::participantes(),
        ]);
    }

    /**
     * Updates an existing MensajesPrivados model.
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
     * Deletes an existing MensajesPrivados model.
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
     * Finds the MensajesPrivados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MensajesPrivados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MensajesPrivados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
