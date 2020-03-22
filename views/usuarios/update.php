<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonDropdown;
use yii\bootstrap\Button as BootstrapButton;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-actualizar">
    <h3>Bienvenido a su perfil personal de ecofriendly: <?= Yii::$app->user->identity->username ?></h3>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="col-6">


            <?php $url = Url::to(['usuarios/view', 'id' => Yii::$app->user->identity->id]); ?>
            <?php
            //Comprueba que existe la imagen
            $file =  Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg');
            $exists = file_exists($file);
            $imagenUsuario = Url::to('@web/img/' . $model->id . '.jpg');
            $urlImagenBasica = Url::to('@web/img/basica.jpg');
         
            if (!$exists) {
                $imagenUsuario = $urlImagenBasica;
            }
            ?>

            <div class="col-4"><a href='<?= $url ?>'></a> <img class='img-fluid rounded-circle' src="<?= $imagenUsuario ?>" width=250px alt=" avatar"></div>



            <!-- <div class="col-4"><a href='<?= $url ?>'></a> <img class='img-fluid rounded-circle' src="<?= Url::to('@web/img/' . $model->id . '.jpg') ?>" width=250px alt=" un coche"></div> -->


            <p>Puede modificar sus datos a continuación:</p>
        </div>
    </div>


    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
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

    <?= Button::widget([

        'label' => 'Eliminar cuenta',


        'options' => ['class' => 'btn-danger grid-button', 'data-confirm' => '¿Estas seguro de borrar tu cuenta de usuario?', 'href' => Url::to(['usuarios/delete', 'id' => $model->id])],

    ]); ?>

    <?= Html::a('<span class="btn-label">Subir imagen avatar</span>', ['imagen', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
</div>