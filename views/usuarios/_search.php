<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'contrasena') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'apellidos') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fecha_nac') ?>

    <?php // echo $form->field($model, 'token_acti') ?>

    <?php // echo $form->field($model, 'codigo_verificacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
