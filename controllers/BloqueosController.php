<?php

namespace app\controllers;

use app\helper_propio\Auxiliar;
use Yii;
use app\models\Bloqueos;
use app\models\BloqueosSearch;
use app\models\Seguidores;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BloqueosController implements the CRUD actions for Bloqueos model.
 */
class BloqueosController extends Controller
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
                'only' => ['update', 'index'],
                'rules' => [
                    [
                        
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rules, $action) {
                            return Auxiliar::esAdministrador();
                        },
                    ],


                ],
            ]
        ];
    }

    /**
     * Lists all Bloqueos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BloqueosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bloqueos model.
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
     * Crea un nuevo registro en la tabla bloqueos
     * Borra al usuario de la tabal seguidores para que el usuario bloqueado no pueda observar la actividad del
     * usuario.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bloqueos();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $estaBloqueado = Bloqueos::find()
                ->where(['usuariosid' => Yii::$app->user->identity->id])
                ->andWhere(['bloqueadosid' => $model->bloqueadosid])
                ->one();

            $eliminado = Seguidores::find()
                ->where(['usuario_id' => $model->bloqueadosid])
                ->andWhere(['seguidor_id' => Yii::$app->user->identity->id])->one();

            if ($estaBloqueado != null) {
                return $this->goBack();
            }
            $eliminado->delete();
            $model->save(false);
            return $this->redirect('site/index');
        } else {
            Yii::$app->session->setFlash('Error', 'El usuario  ya ha sido bloqueado');
            return $this->goHome();
        }
    }

    /**
     * Updates an existing Bloqueos model.
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
     * Borrar el bloqueo de la tabla
     * Y crea de nuevo el registro en la tabla de seguimientos.
     * @param integer $id $usuarioid $seguidorid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $seguidorid, $usuarioid)
    {

        $this->findModel($id)->delete();
        $seguidor = new Seguidores();
        $seguidor->usuario_id = $seguidorid;
        $seguidor->seguidor_id = $usuarioid;
        if ($seguidor->save()) {
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Finds the Bloqueos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bloqueos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bloqueos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
