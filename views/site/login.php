<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\label\LabelInPlace;

?>

<div class="login">

    <div class="wrap h-100">

        <header class="bg-success py-5">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-lg-12">
                        <h1 class="display-4 text-white mt-5 mb-2"> #Ecofriendly: En Busca de la sostenibilidad</h1>
                        <p class="lead mb-5 text-gray-50">Primera red social que te ayuda a ser más sostenible mediante simples pero efectivos retos.</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="container">

            <div class="row">
                <div class="col-md-8 mb-5">
                    <h2>Que hacemos</h2>
                    <hr>
                    <p>Ecofriendly es una red social, totalmente, gratuita, que mediante una valoración prvia de tus habitos de consumo, te da una ecopuntuación y no unos retos que te harán mejorar en nuestra escala de sostenibilidad.</p>
                    <p>Simple pero efectivo. Mediante nuestra estrategia de <b>Gamificación </b> te proponemos retos con una determinada puntuación que te ayuda a cambair tu hábitos y ser más sostenible en tu día a día. </p>
                    <a class="btn btn-primary btn-lg" href="index.php?r=usuarios%2Fregistrar">Registro&raquo;</a>
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
                    <h2>Iniciar sesión</h2>
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



                        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>

                    </div>


                    <em><a href="index.php?r=usuarios%2Fregistrar"> ¿Todavía sin cuenta?</a></em>
                    <br>
                    <em><a href="index.php?r=usuarios%2Frecoverpass"> ¿Olvídaste tu contraseña?</a></em>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid" src="img/interno/hands-600497_1920.jpg" alt="">
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
                            <p class="card-text">Con nuestra estrategia de gamificación a medida que vas avanzando te diviertes, y sobre todo aprendes a ser más sostenible.</p>
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
            <!-- /.row -->

        </div>
    </div>
</div>


</main>



<br>
<br>
<?php

    /* @var $this yii\web\View */
