<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\helper_propio\Auxiliar;
use app\helper_propio\Consultas;
use app\helper_propio\EstilosAppUsuario;
use app\helper_propio\Gridpropio;
use app\models\AccionesRetos;
use app\models\Bloqueos;
use app\models\Ecoretos;
use app\models\Feeds;
use app\models\RetosUsuarios;
use app\models\Seguidores;
use app\models\Usuarios;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Button;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = $this->title;
?>

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
            <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Progreso</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact" aria-selected="false">Preferencias</a>
        </li>
    </ul>
</nav>
<article class="tab-content" id="myTabContent">
    <section class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <h3>Bienvenido a su perfil personal de ecofriendly: </h3>
        <br>
        <?php $url = Url::to(['usuarios/view', 'id' => Yii::$app->user->identity->id]); ?>

        <h3 class="ml-5"> <?= ucfirst(Yii::$app->user->identity->nombre) ?></h3>
        <?php $options = ['class' => ['img-contenedor d-none d-sm-block mb-3'], 'style' => ['width' => '200px', 'height' => '200px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '25px']]; ?>
        <?= Auxiliar::obtenerImagenUsuario(Yii::$app->user->identity->id, $options) ?>


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
        $dataProvider = $feeds;

        Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table table-hover table-borderless overflow-auto text-cennter', 'style' => 'padding:0px, text-align:justify'],

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
                        $options = ['class' => 'mx-auto d-block', 'style' => ['margin' => 0, 'width' => '40%', 'margin-right' => '12px', 'margin-left' => '12px']];

                        return Html::a(Auxiliar::obtenerImagenFeed($dataProvider->imagen, $options));
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'contenido',
                    'value' => function ($dataProvider) {
                        $options = ['class' => 'mx-auto d-block', 'style' => ['margin' => 0, 'width' => '40%', 'margin-right' => '12px', 'margin-left' => '12px']];

                        return Html::a($dataProvider->contenido);
                    },
                    'format' => 'raw',
                ],

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
            if (sizeof($seguidores) > 0) {
                for ($i = 0; $i < sizeof($seguidores); $i++) {
                    $nombreUsuario = Usuarios::findOne($seguidores[$i]->usuario_id);
                    $bloqueados = Bloqueos::find()->where(['usuariosid' => Yii::$app->user->identity->id])->andWhere(['bloqueadosid' => $seguidores[$i]->usuario_id]);
                    if ($bloqueados->count() > 1) {
                        echo '<h3> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $seguidores[$i]->usuario_id]) . '> <span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre)  . '</span> </a>' .  'Usuario bloqueado</h3>';
                    } else {
                        $model = new Bloqueos();
                        $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => ['bloqueos/create'],
                            'enableClientValidation' => true
                        ]);
                        $options = ['class' => ['img-contenedor d-none d-sm-block mb-3'], 'style' => ['width' => '100px', 'height' => '100px', 'border-radius' => '25px']];

                        echo Auxiliar::obtenerImagenSeguidor($seguidores[$i]->usuario_id, $options);
                        echo '<h3> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $seguidores[$i]->usuario_id]) . '> <span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre) . '</span> </a>';
                        echo Html::submitButton(
                            '<span class="glyphicon glyphicon-ban-circle"></span> Bloquear usuario',
                            ['class' => 'btn btn-danger btn-sm ml-2'],
                        );

            ?>
                        <?= $form->field($model, 'usuariosid')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                        <?= $form->field($model, 'bloqueadosid')->hiddenInput(['value' => $seguidores[$i]->usuario_id])->label(false) ?>



            <?php ActiveForm::end();
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
                if (sizeof($amigos) > 0) {
                    for ($i = 0; $i < sizeof($amigos); $i++) {
                        $nombreUsuario = Usuarios::findOne($amigos[$i]->seguidor_id);
                        echo Html::beginForm(['seguidores/delete', 'id' => $amigos[$i]->id], 'post') . '<br>';
                        echo Html::hiddenInput('id', $amigos[$i]->id);
                        $options = ['class' => ['img-contenedor d-none d-sm-block mb-3'], 'style' => ['width' => '100px', 'height' => '100px', 'border-radius' => '25px']];

                        echo Auxiliar::obtenerImagenSeguidor($amigos[$i]->seguidor_id, $options)
                         . '<h3> <a href=' . Url::to(['usuarios/viewnoajax', 'id' => $amigos[$i]->seguidor_id]) . '> <span class="badge badge-secondary"> ' . ucfirst($nombreUsuario->nombre) . '</span> </a>';
                     
                        echo Html::submitButton(
                            '<span class="glyphicon glyphicon-minus"></span> Dejar de seguir',
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

                        foreach ($bloqueados as $bloqueadosnombre) {
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

    <section class="tab-pane fade" id="contact3" role="tabpanel" aria-labelledby="contact2-tab">

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
    <section class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">

        <h3 class="lead"> <?= Icon::show('leaf') ?>Tu progreso <strong> #ecofriendly </strong></h3>
        <br>
        <br>
        <h4 class="ml-5"> Has superado: <?= RetosUsuarios::find()->where(['usuario_id' => Yii::$app->user->identity->id])->andWhere(['culminado' => true])->count() ?> Retos </h4>
        <br>
        <h4 class="ml-5"> Actualmente estas en el nivel:
            <?php $nivel = Ecoretos::find()->where(['categoria_id' => Yii::$app->user->identity->categoria_id])
                ->one(); ?>

            <?php if ($nivel != null) {
                echo '<span class="badge badge-info">' . $nivel->cat_nombre  . '</span>';
            } else {
                echo 'Todavía no tienes un nivel asignado';
            }        ?>
        </h4>
        <br>
        <h4 class="ml-5">Te faltan <strong> <?= Auxiliar::puntosRestantes(Yii::$app->user->identity->id, Yii::$app->user->identity->categoria_id) ?></strong> puntos para el siguiente nivel</h3>
            <br>
            <h4 class="ml-5">Has conseguido: <?= Auxiliar::puntosConseguidos(Yii::$app->user->identity->id) == null ? ' 0' : Auxiliar::puntosConseguidos(Yii::$app->user->identity->id) ?>
                puntos desde que te diste de alta el: <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->fecha_alta) ?></h4>

            <br>

            <br>

            <h3 class="lead"> <?= Icon::show('clipboard-list') ?> Recuerda que el sistema te ha asignado los siguientes retos:</h3>

            <?php

            $arrModels = AccionesRetos::find()->joinWith('retosUsuarios r')->where(['cat_id' => Yii::$app->user->identity->categoria_id])->Where(['r.id' => null])->limit(10)->all();

            $dataProvider = new ArrayDataProvider(['allModels' => $arrModels,  'sort' => [
                'attributes' => ['id'],
            ],]);
            $dataProvider = $retosUsuarios;
            echo Gridpropio::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => ' xs-col-12 table-hover',
                    'encode' => false
                ],

                'columns' => [
                    [
                        'attribute' => 'Reto',
                        'value' => function ($dataProvider) {

                            return Html::a($dataProvider->titulo, Url::to('/index.php?r=acciones-retos%2Fverreto&id=' . $dataProvider->id));
                        },
                        'format' => 'raw',
                    ],
                ],

            ]);
            ?>
            </fieldset>
    </section>
    <?= Auxiliar::volverAtras() ?>
    </div>