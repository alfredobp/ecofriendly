<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccionesRetos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="acciones-retos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat_id')->textInput() ?>

    <?= $form->field($model, 'puntaje')->textInput() ?>

    <?= $form->field($model, 'fecha_aceptacion')->textInput() ?>

    <?= $form->field($model, 'fecha_culminacion')->textInput() ?>

    <?= $form->field($model, 'aceptado')->checkbox() ?>

    <?= $form->field($model, 'culminado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>