<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RetosUsuarios */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="retos-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idreto')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'fecha_aceptacion')->textInput() ?>

    <?= $form->field($model, 'fecha_culminacion')->textInput() ?>

    <?= $form->field($model, 'culminado')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
