<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObjetivosPersonales */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="objetivos-personales-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'usuario_id')->textInput() ?> -->

    <?= $form->field($model, 'objetivo')->textInput() ?>

    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
