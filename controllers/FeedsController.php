<?php

namespace app\controllers;

use Yii;
use app\models\Feeds;
use app\models\FeedsSearch;
use app\models\ImagenForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

require '../helper_propio/AdministradorAWS3c.php';
/**
 * FeedsController implements the CRUD actions for Feeds model.
 */
class FeedsController extends Controller
{

    public $imagen;
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
                        'allow' => true,
                        'actions' => ['index'],
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
     * Permite ver a un feed asociado con un hastag.
     *
     * @return void
     */

    public function actionVerhastag($id, $cadena = '')
    {
        return $this->render('_viewHastag', [
            'model' => $this->findModel($id),
            'cadena' => $cadena
        ]);
    }
        /**
     * Crea un feed con los datos introducidos y/o la imagen subida por el usuario.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feeds();
        $model->usuariosid = Yii::$app->user->id;
        // $model->created_at = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($_FILES)) {
                $model->imagen = $_FILES['Feeds']['name']['imagen'];
            }
            $model->save();
            if (!empty($_FILES['Feeds']['name']['imagen'])) {
                uploadImagenFeed($model);
            }
            return $this->goHome();
        }


        return $this->goBack();
    }
    /**
     * Si el usuario solo quiere subir una foto sin comentario alguno
     *
     * @return void
     */

    public function actionImagen()
    {
        $model = new ImagenForm();


        if (Yii::$app->request->isPost) {
            $model->imagen = UploadedFile::getInstance($model, 'imagen');
            if ($model->upload('feed')) {
                return $this->redirect('index');
            }
        }

        return $this->render('imagen', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date('Y-m-d H:i:s');
        if (Yii::$app->user->identity->id!=$model->usuariosid) {
            return $this->redirect('index');
        }
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_FILES['Feeds']['name']['imagen'])) {

                uploadImagenFeed($model);

                $model->imagen = $_FILES['Feeds']['name']['imagen'];
            }
            if ($model->save()) {
                return $this->redirect(['site/index']);
            }
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

        return $this->goHome();
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
