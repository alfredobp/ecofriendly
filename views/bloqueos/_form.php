<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bloqueos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="bloqueos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuariosid')->textInput() ?>

    <?= $form->field($model, 'bloqueadosid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
