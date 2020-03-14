<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>



    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => ['wrapper' => 'col-sm-8'],
        ],
    ]); ?>
    <div class="container-fluid">

        <div class=" container2">

            <h1>EcoFriendly:<p><em> en busca de la sostenibilidad</em></h1>

            <div class="container-fluid">
                <div class="d-flex justify-content-center h-100">
                    <div class="card col-6">
                        <div class="card-header">
                            <h3>Inicio de sesión</h3>

                        </div>
                        <div class="card-body">

                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <div class="form-group">
                                <div class="offset-sm-2">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row align-items-center remember">
                            <?= $form->field($model, 'rememberMe')->checkbox() ?>


                        </div> -->
                        <br>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center links">
                                ¿Todavía sin cuenta?<a href="index.php?r=usuarios%2Fregistrar">Date de alta</a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="index.php?r=usuarios%2Frecoverpass">¿Olvídaste tu contraseña?</a>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bird-container bird-container--one">
                <div class="bird bird--one"></div>
            </div>

            <div class="bird-container bird-container--two">
                <div class="bird bird--two"></div>
            </div>

            <div class="bird-container bird-container--three">
                <div class="bird bird--three"></div>
            </div>

            <div class="bird-container bird-container--four">
                <div class="bird bird--four"></div>
            </div>

        </div>





    </div>

    <?php

    /* @var $this yii\web\View */
