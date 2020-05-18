<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\helper_propio\Auxiliar;
use app\helper_propio\EstilosAppUsuario;
use app\helper_propio\GestionCookies;
use app\models\Bloqueos;
use app\models\Feeds;
use app\models\Seguidores;
use app\models\Usuarios;
use Github\Api\GitData\Blobs;
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

<head>

    <style>
        /* Inserto css para controlar los aspectos de esa sección de página */
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #f5f5f5;
            padding-left: 10px !important;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0px;
            width: 35%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #ffffff;
        }
    </style>

</head>
<?php
if (isset($_COOKIE['colorPanel']) || isset($_COOKIE['colorTexto']) || isset($_COOKIE['fuente']) || isset($_COOKIE['tamaño'])) {
    $this->registerJs(EstilosAppUsuario::cookiesEstiloSeleccionado());
}
$url4 = Url::to(['usuarios/guardacookie']);
$url5 = Url::to(['usuarios/obtenercookie']);
$js = <<<EOT


function cambiarColorYGuardaCookie(){
    var color = $("#pickerColor").val();
    var tamanyo= $('#slider').val();
    var colorFondo=$('#pickerColor3').val();
    console.log($('#slider').val());
    var fuente=$('select[name=colorTexto]').val();
    var colorTexto=$("#pickerColor2").val();
    console.log(tamanyo);
    
        $.ajax({
            url: '$url4',
            data: {
                color:color, 
                colorTexto: colorTexto, 
                tamaño:tamanyo, 
                fuente:fuente, 
                colorFondo: colorFondo
            },
            success: function(data){
                console.log('ok');
            }
        });
}


$(document).ready(function(){
    
             $('#preferencias').click(function(){
            $("body").hide();
            cambiarColorYGuardaCookie();
         
        });
        $('#slider').change(function(){

      console.log($('#slider').val());
  });
    $("select[name=colorTexto]").change(function(){
    var color=$('select[name=colorTexto]').val();
    console.log(color);
        });
});
EOT;
$this->registerJs($js);
?>
<nav>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Perfil usuario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Actividad</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Red de contactos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Preferencias</a>
        </li>
    </ul>
</nav>
<article class="tab-content" id="myTabContent">
    <section class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3>Bienvenido a su perfil personal de ecofriendly: <?= ucfirst(Yii::$app->user->identity->username) ?></h3>
        <br>
        <?php $url = Url::to(['usuarios/view', 'id' => Yii::$app->user->identity->id]); ?>


        <?php $options = ['class' => ['img-contenedor'], 'style' => ['width' => 'auto', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>
        <?= Auxiliar::obtenerImagenUsuario($model->id, $options) ?>


        <p>Puede modificar sus datos a continuación:</p>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'method' => 'post',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
            ],
        ]); ?>

        <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'direccion')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'apellidos')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
        <!-- permite ajustar el estado de un usuario -->
        <?= $form->field($model, 'estado')->textInput(['type' => 'text']) ?>
        <?= $form->field($model, 'descripcion')->textInput(['type' => 'text']) ?>
        <!-- <?= $form->field($model, 'contrasena')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?> -->



        <div class="form-group">
            <div class="offset-sm-2">
                <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <br>
        <?= Button::widget([

            'label' => 'Eliminar cuenta',

            'options' => ['class' => 'btn-danger grid-button', 'data-confirm' => '¿Estas seguro de borrar tu cuenta de usuario?', 'href' => Url::to(['usuarios/delete', 'id' => $model->id])],

        ]); ?>

        <?= Html::a('<span class="btn-label">Subir imagen avatar</span>', ['imagen', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </section>
    <br>
    <section class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h4>En esta área podrá gestionar todos los feeds publicados en la red #ecofriendly:</h4>
        <br>
        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => Feeds::find()
                ->where(['usuariosid' => Yii::$app->user->identity->id]),
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);
        //paginacion de 10 feeds por página
        $dataProvider->pagination = ['pageSize' => 10];
        $options = ['style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];

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
                    'attribute' => 'imagen',
                    'value' => function ($dataProvider) {
                        return Auxiliar::obtenerImagenFeed($dataProvider->imagen);
                    },
                    'format' => 'raw',
                ],
                'contenido',


                [
                    // 'header' => 'Fecha de <br> Actualización',
                    'attribute' => 'updated_at',

                    'value' => function ($dataProvider) {
                        return ($dataProvider->updated_at == null) ? '---- ' : Yii::$app->formatter->asRelativeTime($dataProvider->updated_at);
                    },
                ],


                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {portada}',
                    'controller' => 'feeds',
                ],
            ],

        ]);

        Pjax::end();
        ?>
    </section>

    <section class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
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

                        $model = new Bloqueos();
                        $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => ['bloqueos/create'],
                            'enableClientValidation' => true
                        ]); ?>

                        <?= $form->field($model, 'usuariosid')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                        <?= $form->field($model, 'bloqueadosid')->hiddenInput(['value' => $seguidores[$i]->usuario_id])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Bloquear usuario', ['class' => 'btn btn-danger']) ?>
                        </div>

            <?php ActiveForm::end();
                        // echo Html::a(
                        //     'Bloquear Usuario',
                        //     Url::to(['/bloqueos/create']),
                        //     [
                        //         'data' => [
                        //             'method' => 'post',
                        //             'params' => [
                        //                 'usuariosid' => Yii::$app->user->identity->id,
                        //                 'bloqueadosid' => $seguidores[$i]->usuario_id
                        //             ],

                        //         ],
                        //         'class' => ['btn btn-danger btn-xs']
                        //     ]
                        // );
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
                $amigos = Seguidores::find()->where(['usuario_id' => Yii::$app->user->identity->id])->all();
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
                    echo 'Actualmente no sigues a ningún usuario de la red #Ecofriendly';
                }
                ?>

                <div class="panel panel-default">
                    <div class="panel-body">

                    </div>
                </div>

            </fieldset>
        </div>

        <br>
        <br>
        <div class="clearfix"></div>
        <div class="panel-body">
            <fieldset class="col-md-12">
                <legend>Usuarios Bloqueados:</legend>
                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php $bloqueados = Bloqueos::find()->where(['usuariosid' => Yii::$app->user->identity->id])->asArray()->all(); ?>
                        <?php
                        // var_dump($bloqueados->nombre);

                        foreach ($bloqueados as $bloqueadosnombre) {
                            // var_dump($bloqueados);
                            $usuarios = Usuarios::find()->where(['id' => $bloqueadosnombre['bloqueadosid']])->asArray()->one();
                            echo '<h3> <span class="badge badge-secondary">' . $usuarios['nombre'] . '</span></h3>';

                            ActiveForm::begin();
                            echo Html::a(
                                'Desbloquear usuario',
                                Url::to([
                                    '/bloqueos/delete', 'id' => $bloqueadosnombre['id'], 'usuarioid' => Yii::$app->user->identity->id,
                                    'seguidorid' => $bloqueadosnombre['bloqueadosid']
                                ]),
                                [
                                    'data' => [
                                        'method' => 'post',
                                        'params' => [
                                            'id' => Yii::$app->user->identity->id,
                                            'usuarioid' => Yii::$app->user->identity->id,
                                            'seguidorid' => $bloqueadosnombre['bloqueadosid']
                                        ],

                                    ],
                                    'class' => ['btn btn-danger btn-xs']
                                ]
                            );
                            ActiveForm::end();
                        }



                        ?>



                    </div>
                </div>

            </fieldset>
        </div>
    </section>

    <section class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">

        <h4> En esta sección puede realizar modificaciones de configuración: </h4>
        <br>
        <fieldset>
            <legend>Modifique los estilos de la aplicación:</legend>
            <p>Color de fondo de los feeds:
                <input type="color" value=#FFFFFF id="pickerColor">
            </p>
            <br>
            <p> Tamaño de texto:
                <input id="slider" type="range" min="6" max="20" value="15">
            </p>

            <p>
                Fuente de texto:
                <select name="colorTexto" id="fuente">
                    <option value="Times New Roman" selected>Times New Roman</option>
                    <option value="Arial" selected>Arial</option>
                    <option value="Comic Sans">Comic Sans</option>
                </select>
            </p>
            <p>Color del texto de los feeds:
                <input type="color" value="#000000" id="pickerColor2">
            </p>
            <p>Color del Fondo de la aplicación:
                <input type="color" value="#FFFFFF" id="pickerColor3">
            </p>
            <br>
            <button id="preferencias" class="btn btn-success">Aplicar estilo</button>
            <?= Button::widget([

                'label' => ' Restaurar estilos predefinidos',

                'options' => ['class' => 'btn-danger grid-button', 'data-confirm' => '¿Estas seguro de aplicar los estilos por defecto?', 'href' => Url::to(['usuarios/borrarestilos'])],

            ]); ?>
        </fieldset>
        </body>

        </html>

    </section>

    </div>