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
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Bienvenido a su perfil personal de ecofriendly: <?= Yii::$app->user->identity->username ?></h3>
    <p>Puede modificar sus datos a continuación:</p>

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


        'options' => ['class' => 'btn-danger grid-button', 'data-confirm' => '¿Estas seguro de borrar tu cuenta de usuario?', 'href' => Url::to(['usuarios/delete', 'id'=> $model->id])],

    ]); ?>
</div>