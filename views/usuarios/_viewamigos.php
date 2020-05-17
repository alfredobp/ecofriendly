<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\helper_propio\Auxiliar;
use app\helper_propio\GestionCookies;
use app\models\Bloqueos;
use app\models\Feeds;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\base\Model;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonDropdown;
use yii\bootstrap4\Tabs;
use yii\bootstrap\Button as BootstrapButton;
use yii\bootstrap\Tabs as BootstrapTabs;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\grid\GridView;
use yii\helpers\Funcionalidades;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = $this->title;
?>


<nav>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="contact" aria-selected="true">Perfil usuario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#inicio" role="tab" aria-controls="contact" aria-selected="false">Actividad en la red</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Actividad en la red</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false">Contactos en común</a>
        </li>
    </ul>
</nav>
<article class="tab-content" id="myTabContent">


    <section class="tab-pane fade show active" id="inicio" role="tabpanel" aria-labelledby="home-tab">


        <div class="usuarios-view">

            <!-- <h1><?= Html::encode($this->title) ?></h1> -->
            <div class="col-12 center-block">
                <?php
                $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '160px', 'height' => '160px', 'margin-right' => '2px', 'margin-left' => '2px'], 'href' => 'www.google.es'];

                $seguidor_id = $model->id;



                echo Auxiliar::obtenerImagenUsuario($model->id, $optionsBarraUsuarios);

                ?>

                <p>


                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' =>  [

                        // 'id',
                        'username',
                        // 'contrasena',
                        // 'auth_key',
                        [
                            'attribute' => 'Nombre completo',
                            'value' => function ($dataProvider) {
                                return $dataProvider->nombre . ' ' . $dataProvider->apellidos;
                            },
                            'format' => 'raw',
                        ],
                        'localidad',
                        'ranking.puntuacion',


                        [
                            'attribute' => 'Categoría',
                            'value' => function ($dataProvider) {

                                if ($dataProvider->categoria['cat_nombre'] === 'Principante') {
                                    return '<h5><span class="badge badge-danger">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                                } elseif ($dataProvider->categoria['cat_nombre'] === 'Intermedio') {
                                    return '<h5><span class="badge badge-warning">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                                } elseif ($dataProvider->categoria['cat_nombre'] === 'Avanzado') {
                                    return '<h5><span class="badge badge-success">' . $dataProvider->categoria['cat_nombre'] . '</span></h5>';
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Descripción',
                            'value' => function ($dataProvider) {
                                if ($dataProvider->descripcion == null) {

                                    return  '-----------';
                                }
                                return $dataProvider->descripcion;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Edad',
                            'value' => function ($dataProvider) {

                                $fecha = time() - strtotime($dataProvider->fecha_nac);

                                $edad = floor($fecha / 31556926);
                                return  $edad . ' años';
                            },
                            'format' => 'raw',
                        ],
                        // 'email:email',
                        // 'direccion',
                        'estado',
                        // 'fecha_nac',
                        // 'token_acti',
                        // 'codigo_verificacion',
                    ],
                    'options' => ['class' => 'table table table-hover table-md col-12  ']
                ]) ?>
            </div>

            <?php
            $siguiendo = Seguidores::find()
                ->where(['usuario_id' => Yii::$app->user->identity->id])
                ->andWhere(['seguidor_id' => $model->id])
                ->one();


            $model2 = Seguidores::find()->where(['seguidor_id' => $model->id])->one();
            if ($siguiendo != null) {
                echo Html::a('Dejar de seguir a usuario', ['seguidores/delete', 'id' => $model2->id], [
                    'class' => 'btn btn-danger',
                    'controller' => 'seguidores',
                    'data' => [
                        'confirm' => '¿Desea dejar de seguir a este usuario?',
                        'method' => 'post',
                    ],
                ]);
                echo '    ';
                echo Html::a('Enviar mensaje', ['mensajes-privados/create', 'receptor_id' => $model2->seguidor_id], [
                    'class' => 'btn btn-success ml-5',
                    'controller' => 'mensajesPrivados',
                    'data' => [

                        'method' => 'post',
                    ],
                ]);
            } else {

                echo Html::a(

                    'Añadir como amigo',
                    ['site/index'],
                    [
                        'onclick' => "$.ajax({
    
                        url: '" . Url::to(['seguidores/create']) . "',
                        type: 'POST',
                        data: 'seguidor_id=$model->id',
                         })",
                        'class' => 'btn btn-success'
                    ],
                    ['class' => 'btn btn-success'],
                );
            }

            ?>

        </div>

    </section>
    <section class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <p>

            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla quam hic, a beatae consectetur ipsum, nihil fuga pariatur ratione, neque quibusdam sequi aliquid doloribus odit vitae explicabo dolorum saepe vel.

        </p>
    </section>
    <section class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">

        <h4> Actividad del usuario: </h4>
        <br>


    </section>

    </div>