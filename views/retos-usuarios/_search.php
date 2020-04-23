<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuariosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="retos-usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idreto') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'fecha_aceptacion') ?>

    <?= $form->field($model, 'fecha_culminacion') ?>

    <?php // echo $form->field($model, 'culminado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
