<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\helper_propio\Auxiliar;
use app\helper_propio\GestionCookies;
use app\models\Bloqueos;
use app\models\Feeds;
use app\models\ObjetivosPersonales;
use app\models\RetosUsuarios;
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
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#inicio" role="tab" aria-controls="contact" aria-selected="false">Perfil de usuario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Actividad en la red</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false">Contactosexit</a>
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
                <!-- <h5><span class="badge badge-light"> Seguidor </span></h5> -->
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

            <h4>Últimos feeds publicados en la red #ecofriendly:</h4>
            <br>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => Feeds::find()
                    ->where(['usuariosid' => $model->id]),
            ]);

            $dataProvider->setSort([
                'defaultOrder' => ['created_at' => SORT_DESC],
            ]);

            $dataProvider->pagination = ['pageSize' => 5];
            $options = ['style' => ['width' => '20px', 'margin-right' => '0px', 'margin-left' => '0px', 'border-radius' => '0px']];

            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify'],

                'columns' => [
                    [

                        'attribute' => 'created_at',
                        'value' => function ($dataProvider) {
                            return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                        },

                    ],
                    [
                        'attribute' => 'Contenido',
                        'value' => function ($dataProvider) {
                            $options = ['style' => ['width' => '60px', 'margin-right' => '0px', 'margin-left' => '0px', 'border-radius' => '0px']];
                            return Auxiliar::obtenerImagenFeed($dataProvider->imagen, $options);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'Contenido',
                        'value' => function ($dataProvider) {
                            
                            return $dataProvider->contenido;
                        },
                        'format' => 'raw',
                    ],
                

                ],

            ]);

            Pjax::end();
            ?>
            <h4>Retos aceptados:</h4>
            <br>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => RetosUsuarios::find()
                    ->joinWith('idreto0')
                    ->where(['usuario_id' => $model->id]),
            ]);

            $dataProvider->setSort([
                'defaultOrder' => ['fecha_aceptacion' => SORT_DESC],
            ]);

            $dataProvider->pagination = ['pageSize' => 5];
            $options = ['style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];

            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify'],

                'columns' => [
                    [
                        'attribute' => 'Reto',
                        'value' => function ($dataProvider) {
                            return $dataProvider->idreto0->titulo;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => '¿Finalizado?',
                        'value' => function ($dataProvider) {
                            return $dataProvider->culminado;
                        },
                        'format' => 'boolean',
                    ],

                ],

            ]);

            Pjax::end();
            ?>
             <h4>Obejtivos Personales:</h4>
            <br>
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => ObjetivosPersonales::find()
                    ->joinWith('usuario')
                    ->where(['usuario_id' => $model->id]),
            ]);

            $dataProvider->setSort([
                'defaultOrder' => ['fecha_aceptacion' => SORT_DESC],
            ]);

            $dataProvider->pagination = ['pageSize' => 5];
            $options = ['style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];

            Pjax::begin();
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify'],

                'columns' => [
                    [
                        'attribute' => 'Objetivo',
                        'value' => function ($dataProvider) {
                            return $dataProvider->objetivo;
                        },
                        'format' => 'raw',
                    ],
                   

                ],

            ]);

            Pjax::end();
            ?>
        </p>
    </section>
    <section class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">
        <fieldset class="col-md-12">

            <legend>Seguidores: </legend>
            <?php
            $seguidores =  Seguidores::find()->where(['seguidor_id' => Yii::$app->user->identity->id])->all();
            if (sizeof($seguidores) > 0) {
                for ($i = 0; $i < sizeof($seguidores); $i++) {
                    $nombreUsuario = Usuarios::findOne($seguidores[$i]->usuario_id);
                    $bloqueados = Bloqueos::find()->where(['usuariosid' => Yii::$app->user->identity->id])->andWhere(['bloqueadosid' => $seguidores[$i]->usuario_id]);
                    if ($bloqueados->count() > 1) {
                        echo '<h5> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $seguidores[$i]->usuario_id]) . '> <span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre)  . '</span> </a>' .  'Usuario bloqueado</h5>';
                    } else {
                        echo '<h5> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $seguidores[$i]->usuario_id]) . '> <span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre)  . '</span> </a>';
                        echo Html::a(
                            'Bloquear usuario',
                            Url::to(['/bloqueos/create', 'usuariosid' => Yii::$app->user->identity->id]),
                            [
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'usuariosid' => Yii::$app->user->identity->id,
                                        'bloqueadosid' => $seguidores[$i]->usuario_id
                                    ],

                                ],
                                'class' => ['btn btn-danger btn-xs']
                            ]

                        );
                    }
                }
            } else {
                echo 'Actualmente no tiene seguidores';
            }
            ?>
        </fieldset>

        <br>
        <br>
        <div class="clearfix"></div>
        <div class="panel-body">
            <fieldset class="col-md-12">
                <legend>Siguiendo a:</legend>
                <?php
                $amigos = Seguidores::find()->where(['usuario_id' => $model->id])->all();
                if (sizeof($amigos) > 0) {
                    for ($i = 0; $i < sizeof($amigos); $i++) {
                        $nombreUsuario = Usuarios::findOne($amigos[$i]->seguidor_id);
                        echo Html::beginForm(['seguidores/delete', 'id' => $amigos[$i]->id], 'post') . '<br>';
                        echo Html::hiddenInput('id', $amigos[$i]->id);
                        echo '<h3> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $amigos[$i]->seguidor_id]) . '></a><span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre)  . '</span>';
                        echo Html::submitButton(
                            '<span class="glyphicon glyphicon-minus"></span>',
                            ['class' => 'btn btn-danger btn-sm ml-2'],
                        );
                        echo Html::endForm();
                    }
                } else {
                    echo 'Actualmente no sigue a ningún usuario #Ecofriendly';
                }
                ?>

                <div class="panel panel-default">
                    <div class="panel-body">

                    </div>
                </div>

            </fieldset>
        </div>

    </section>

    </div>