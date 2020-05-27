<?php

use Codeception\Step\Skip;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feeds */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="feeds-form shadow p-3 mb-5 bg-white rounded">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'contenido')->textInput([
        'maxlength' => true,

        'value' => Yii::$app->formatter->asHtml($model->contenido)
    ]) ?>

    <?= $form->field($model, 'created_at')->textInput([
        'value' => Yii::$app->formatter->asRelativeTime($model->created_at), 'readonly' => true
    ]) ?>


    <?= $form->field($model, 'imagen')->fileInput([
        'value' => $model->imagen,
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save') . 'Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>