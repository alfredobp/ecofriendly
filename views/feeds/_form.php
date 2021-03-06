<?php

use app\helper_propio\Auxiliar;
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
        <?php $options = ['class' => ['img-contenedor'], 'style' => ['width' => '500px', 'margin' => '12px']]; ?>
    <p><?=Auxiliar::ObtenerImagenFeed($model->imagen, $options) ?></p>

    <p> Publicaste este feed: <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>


    <!-- <?= $form->field($model, 'imagen')->fileInput([
                'value' => $model->imagen,
            ]) ?> -->
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save') . 'Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>