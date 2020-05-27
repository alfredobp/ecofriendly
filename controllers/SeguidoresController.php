<?php

namespace app\controllers;

use app\models\Bloqueos;
use app\models\Notificaciones;
use Yii;
use app\models\Seguidores;
use app\models\SeguidoresSearch;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use function Matrix\identity;

/**
 * SeguidoresController implements the CRUD actions for Seguidores model.
 */
class SeguidoresController extends Controller
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Yii::$app->user->identity->rol === 'superadministrador';
                        },
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Seguidores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeguidoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seguidores model.
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
            # code...
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Seguidores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $seguidor = new Seguidores();
        $seguidor->usuario_id = Yii::$app->user->identity->id;
        $notificacion = new Notificaciones();
        if ($seguidor->load(Yii::$app->request->post(), '') && $seguidor->validate()) {
            $id = $seguidor->seguidor_id;

            $esSeguidor = Seguidores::find()->where(['seguidor_id' => $id])->andWhere(['usuario_id' => Yii::$app->user->identity->id])->one();

            if ($esSeguidor == null) {
                $estaBloqueado = Bloqueos::find()->where(['bloqueadosid' => Yii::$app->user->identity->id])->andWhere(['usuariosid' => $id])->one();

                //Se comprueba si el usuario se encuentra en situación de bloqueo.
                if ($estaBloqueado != null) {
                    Yii::$app->session->setFlash('error', 'Este usuario te ha bloqueado');
                    return $this->goBack();
                }
                $seguidor->save();
                $notificacion->usuario_id = $id;
                $notificacion->seguidor_id = Yii::$app->user->identity->id;
                $notificacion->leido = false;
                $notificacion->tipo_notificacion_id = 3;
                $notificacion->id_evento = $seguidor->id;
                if ($notificacion->validate()) {
                    $notificacion->save();
                }
                $seguidor->save();
                Yii::$app->session->setFlash('success', 'Ahora eres amigo');
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Ya sigues a este usuario');
                return $this->goHome();
            }
        }
    }


    /**
     * Updates an existing Seguidores model.
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
     * Deletes an existing Seguidores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Has dejado de seguir a este usuario');
        return $this->goHome();
    }

    /**
     * Finds the Seguidores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seguidores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seguidores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
