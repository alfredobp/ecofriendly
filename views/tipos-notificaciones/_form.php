<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TiposNotificaciones */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="tipos-notificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>\n\n    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>