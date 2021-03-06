<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrarForm */

use app\helper_propio\Auxiliar;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Reseteo de password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-resetpass h-100">
    <div class="container">

        <div class="mt-5 shadow p-3 mb-3 bg-white">

            <h1><?= Html::encode($this->title) ?></h1>
            <p>Introduzca los siguientes datos para resetear su contraseña de acceso:</p>

            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'horizontalCssClasses' => ['wrapper' => 'col-md-6 col-12'],
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
        <?php echo Auxiliar::volverAtras() ?>
    </div>
</div>