<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Reseteo de password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-resetpass h-100">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Introduzca los siguientes datos para resetear su contraseña de acceso:</p>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-6'],
        ],
    ]);
    ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'contrasena')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'verification_code')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'recover')->input('hidden')->label(false) ?>

    <?= Html::submitButton('Reestablecer contraseña', ['class' => 'btn btn-primary']) ?>

    <?php $form->end() ?>
    <br>
</div>