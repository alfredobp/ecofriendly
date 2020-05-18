<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notificaciones */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="notificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'usuario_id')->textInput() ?>\n\n    <?= $form->field($model, 'seguidor_id')->textInput() ?>\n\n    <?= $form->field($model, 'leido')->checkbox() ?>\n\n    <?= $form->field($model, 'tipo_notificacion_id')->textInput() ?>\n\n    <?= $form->field($model, 'created_at')->textInput() ?>\n\n    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>