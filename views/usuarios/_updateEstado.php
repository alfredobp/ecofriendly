<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Actualizar estado';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shadow p-3 mb-5 bg-white rounded">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'method' => 'post',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-12'],
        ],
    ]); ?>


    <?= $form->field($model, 'estado')->label('Estoy:')->textarea(['type' => 'text']) ?>




    <div class="form-group">
        <div class="offset-sm-2">
            <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


</div>