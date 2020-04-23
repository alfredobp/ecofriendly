<?php

namespace app\controllers;

use app\models\AccionesRetos;
use app\models\Ranking;
use Yii;
use app\models\RetosUsuarios;
use app\models\RetosUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RetosUsuariosController implements the CRUD actions for RetosUsuarios model.
 */
class RetosUsuariosController extends Controller
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
     * Lists all RetosUsuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RetosUsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RetosUsuarios model.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idreto, $usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($idreto, $usuario_id),
        ]);
    }

    /**
     * Creates a new RetosUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idreto, $usuario_id)
    {

        $model = new RetosUsuarios();
        $model->idreto = $idreto;
        $model->usuario_id = $usuario_id;
        $model->fecha_aceptacion = date('Y-m-d H:i:s');


        if ($model->validate()) {
            $model->save();
            return $this->goHome();
        } else {
            Yii::$app->session->setFlash('error', 'Ya ha aceptado este reto.');
            return $this->goBack();
        }
    }

    /**
     * Updates an existing RetosUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idreto, $usuario_id)
    {
        $model = $this->findModel($idreto, $usuario_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idreto' => $model->idreto, 'usuario_id' => $model->usuario_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionFinalizar($idreto, $usuario_id)
    {
        $model = $this->findModel($idreto, $usuario_id);
        $puntaje = AccionesRetos::find()->select('puntaje')->where(['id' => 1])->one();
        var_dump($puntaje->puntaje);
     

        if ($model->save() && $model->culminado == false) {

            $model->culminado = true;
            $model->fecha_culminacion = date('Y-m-d H:i:s');
            $model->save();
            $puntuacion = Ranking::find()->where(['usuariosid' => Yii::$app->user->identity->id])->one();
            $puntuacion->puntuacion = $puntuacion->puntuacion + $puntaje->puntaje;
            $puntuacion->save();

            Yii::$app->session->setFlash('success', 'Su puntuación ha mejorado.');
            return $this->redirect(['site/index', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('error', 'El reto ya ha sido terminado.');
            return $this->redirect(['site/index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RetosUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idreto, $usuario_id)
    {
        $this->findModel($idreto, $usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RetosUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idreto
     * @param integer $usuario_id
     * @return RetosUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idreto, $usuario_id)
    {
        if (($model = RetosUsuarios::findOne(['idreto' => $idreto, 'usuario_id' => $usuario_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
