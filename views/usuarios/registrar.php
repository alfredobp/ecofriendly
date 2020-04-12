<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Registrar usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Introduzca los siguientes datos para registrarse:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-5'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true], ['class' => 'col-6']) ?>
    <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'apellidos')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'contrasena')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?= $form->field($model, 'direccion')->textInput() ?>
    <?= $form->field($model, 'localidad')->textInput() ?>
    <?= $form->field($model, 'fecha_nac')->label('Fecha de nacimiento')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Introduzca su fecha de nacimiento...', 'class' => 'col-6'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>
    <div class="form-group">
        <div class="offset-sm-2">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
