<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\helper_propio\Auxiliar;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contacta con nosotros';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="Contacta con nosotros">

    <div class="container">


        <div class="site-contact">
            <h1><?= Html::encode($this->title) ?></h1>
            <br>

            <?php if (Yii::$app->session->hasFlash('Formulario enviado')) : ?>

                <div class="alert alert-success">
                    Gracias por su mensaje.
                </div>


            <?php else : ?>

                <p>
                    Si tiene alguna duda sobre #ecofriendly por favor rellene el siguiente formulario de contacto.
                </p>

                <div class="row">
                    <div class="col-xl-8">

                        <?php $form = ActiveForm::begin([
                            'id' => 'contact-form',
                            'layout' => 'horizontal',
                            'fieldConfig' => [
                                'horizontalCssClasses' => ['label' => 'col-sm-2'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Nombre:') ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'subject')->label('Asunto:') ?>

                        <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('Cuerpo del mensaje:') ?>

                        <?= $form->field($model, 'verifyCode')->label('Código Verificación:')->widget(Captcha::className(), [
                            'imageOptions' => ['class' => 'col-sm-3', 'style' => 'padding: 0'],
                            'options' => ['class' => 'form-control col-sm-7', 'style' => 'display: inline'],
                        ]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Enviar correo', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>

            <?php endif; ?>
        </div>


        <?php echo Auxiliar::volverAtras() ?>
    </div>

</div>
</div>
<br>

</div>