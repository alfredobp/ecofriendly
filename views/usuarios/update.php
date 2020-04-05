<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

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

<head>

    <style>
        /* Inserto css para controlar los aspectos de esa sección de página */
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
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
$url4 = Url::to(['usuarios/guardacookie']);
$url5 = Url::to(['usuarios/obtenercookie']);
$js = <<<EOT


function cambiarColorYGuardaCookie(){
    var color = $("#pickerColor").val();
    var tamanyo= $('#slider').val();
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
                fuente:fuente
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
        <h3>Bienvenido a su perfil personal de ecofriendly: <?= Yii::$app->user->identity->username ?></h3>
        <br>
        <?php $url = Url::to(['usuarios/view', 'id' => Yii::$app->user->identity->id]); ?>
        <?php
        //Comprueba que existe la imagen
        $file = Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg');
        $exists = file_exists($file);
        $imagenUsuario = Url::to('@web/img/' . $model->id . '.jpg');
        $urlImagenBasica = Url::to('@web/img/basica.jpg');

        if (!$exists) {
            $imagenUsuario = $urlImagenBasica;
        }
        ?>

        <div class="col-4"><a href='<?= $url ?>'></a> <img class='img-fluid rounded-circle' src="<?= $imagenUsuario ?>" width=250px alt=" avatar"></div>

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
        <?= $form->field($model, 'estado')->textInput(['type' => 'text']) ?>
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

        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => Feeds::find()
                ->where(['usuariosid' => Yii::$app->user->identity->id]),
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);
        $dataProvider->pagination = ['pageSize' => 10];

        Pjax::begin();
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => 'Ultimas publicaciones realizadas:',
            'itemView' => '_actividadUsuarios',
        ]);

        Pjax::end();
        ?>
    </section>

    <section class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <fieldset class="col-md-12">

            <legend>Seguidores: </legend>
            <?php
            $seguidores = Seguidores::find()->all();
            if (sizeof($seguidores) > 1) {
                for ($i = 0; $i < sizeof($seguidores); $i++) {
                    echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post') . '<br>';
                    echo Html::hiddenInput('id', $seguidores[$i]->id);
                    echo Html::submitButton(
                        '<span class="glyphicon glyphicon-minus"></span>',
                        ['class' => 'btn btn-danger btn-sm ml-2'],
                    );
                    echo Html::endForm();
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

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Siguien content...</p>
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
                        <p>...</p>
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
                <input type="color" id="pickerColor">
            </p>
            <br>
            <p> Tamaño de texto:
                <input id="slider" type="range" min="6" max="20" value="15">
            </p>

            <p>
                Fuente de texto:
                <select name="colorTexto">
                    <option value="Times New Roman" selected>Times New Roman</option>
                    <option value="Arial" selected>Arial</option>
                    <option value="Comic Sans">Comic Sans</option>
                </select>
            </p>
            <p>Color del texto de los feeds:
                <input type="color" id="pickerColor2">
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