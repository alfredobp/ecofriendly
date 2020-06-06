<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\label\LabelInPlace;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;
use yii\web\View;

?>

<div class="login">

    <div class="wrap h-100 col-lg-12 col-xs-6">

        <header class="bg-success py-5 col-lg-12 col-xs-6">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-lg-12 col-xs-6">
                        <h1 class="display-4 text-white mt-5 mb-2 col-12 col-xs-2"> #Ecofriendly: En Busca de la sostenibilidad</h1>
                        <p class="lead mb-5 text-gray-50">Primera red social que te ayuda a ser más sostenible mediante simples pero efectivos retos.</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">

            <div class="row">
                <div class="col-md-8 mb-5">
                    <h3>Que hacemos</h3>
                    <hr>
                    <p>Ecofriendly es una red social, totalmente, gratuita, que mediante una valoración previa de tus habitos de consumo, te da una ecopuntuación y no unos retos que te harán mejorar en nuestra escala de sostenibilidad.</p>
                    <p>Simple pero efectivo. Mediante nuestra estrategia de <strong>Gamificación </strong> te proponemos retos con una determinada puntuación que te ayuda a cambair tu hábitos y ser más sostenible en tu día a día. </p>

                    <?= Html::button('Registro&raquo;', ['value' => Url::to('/index.php?r=usuarios%2Fregistrar'), 'class' => 'btn btn-primary modalButton4 btn-lg intro2 ', 'id' => 'modalButton4']); ?>
                    <br>

                    <?php
                    Auxiliar::ventanaModal('Registro en #ecofriendly', 4, 'md');
                    ?>
                    <br>
                    <div class="alert alert-info alert-info" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        ¿Tienes dudas sobre <strong>#Ecofriendly</strong>? Visita nuestra <a href="/index.php?r=site%2Ffaqs"> Área de FAQs</a> y resuelve tus dudas. También puedes mandarnos un <a href="index.php?r=site%2Fcontactar">correo.</a>
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

                <div class="col-md-4 mb-5">
                    <h3>Iniciar sesión</h3>
                    <hr>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',

                        'fieldConfig' => [
                            'horizontalCssClasses' => ['wrapper' => 'col-12'],

                        ],
                    ]); ?>

                    <div class="form-group">

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Usuario') ?>
                    </div>

                    <div class="form-group">

                        <?= $form->field($model, 'password')->passwordInput()->label('Contraseña') ?>

                    </div>

                    <div class="form-group">



                        <?= Html::submitButton(' <strong>Entrar</strong>', ['class' => 'btn btn-primary w-100 ', 'name' => 'login-button']) ?>

                    </div>
                    <em><?= Html::button(Icon::show('user-plus') . '<small>Unirse a #EcoFriendly</small>', ['value' => Url::to('/index.php?r=usuarios%2Fregistrar'), 'class' => ' btn btn-primary  modalButton4 ', 'id' => 'modalButton5']); ?></em>

                    <?php
                    Auxiliar::ventanaModal('Registro en #ecofriendly', 7, 'md');
                    ?>
                    <br>

                    <em><a href="index.php?r=usuarios%2Frecoverpass"> ¿Olvídaste tu contraseña?</a></em>
                    <!-- Solo funciona en local -->
                    <!-- <div class="mt-3">
                        Accede con Facebook: <?= AuthChoice::widget(['baseAuthUrl' => ['site/auth']]) ?>

                    </div> -->

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid" src="/img/interno/hands-600497_1920.jpg" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Porque nuestro planeta lo necesita</h4>
                            <p class="card-text">Con nuestro actual ritmo de vida, necesitamos 1,7 planetas, acabandose nuestra cuota sobre el mes de agosto.</p>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid" src="/img/interno/chess-1215079_1920.jpg" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Aprender jugando</h4>
                            <p class="card-text">Con nuestra estrategia de gamificación a medida que vas avanzando te diviertes, y sobre todo aprendes a ser más sostenible cambiando tus hábitos de vida.</p>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid" src="/img/interno/social-media-1795578_1920.jpg" alt="">
                        <div class="card-body">
                            <h4 class="card-title">Comparte con los demás</h4>
                            <p class="card-text">Ecofriendly es mucho más, puedes compartir experiencias con otros usuarios, aprender de otros. Porque la colaboración es clave para salvar nuestro planeta.</p>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
            <p class="fraseDestacada text-center">La primera ley de la ecología es que todo está relacionado con todo lo demás. —Barry Commoner.</p>
            <!-- /.row -->

        </div>
    </div>
</div>



<?php

    /* @var $this yii\web\View */
