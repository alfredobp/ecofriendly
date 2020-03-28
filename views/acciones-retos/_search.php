<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="acciones-retos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'cat_id') ?>

    <?= $form->field($model, 'puntaje') ?>

    <?php // echo $form->field($model, 'fecha_aceptacion') ?>

    <?php // echo $form->field($model, 'fecha_culminacion') ?>

    <?php // echo $form->field($model, 'aceptado')->checkbox() ?>

    <?php // echo $form->field($model, 'culminado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
