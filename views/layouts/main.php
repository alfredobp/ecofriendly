<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\helper_propio\GestionCookies as Helper_propioGestionCookies;
use yii\helpers\Url;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\helper_propio\Auxiliar;
use cybercog\yii\googleanalytics\widgets\GATracking;
use kartik\dialog\Dialog;
use kartik\dialog\DialogAsset;
use kartik\icons\Icon;

Icon::map($this);

DialogAsset::register($this);

$this->registerJsFile('https://cdn.jsdelivr.net/npm/pselect.js@4.0.1/dist/pselect.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
if (!isset($_COOKIE['politicaCookies'])) {
    $this->registerJs(Helper_propioGestionCookies::privacidad());
}

echo Helper_propioGestionCookies::dialogCookies();
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('Ecofriendly.es') ?></title>
    <?= GATracking::widget([
        'trackingId' => 'UA-162197120-1',
    ]) ?>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody(); ?>
    <?php if (isset(Yii::$app->user->identity)) {
    ?>
        <br>
        <div class="wrap">

            <?php

            NavBar::begin([
                'brandLabel' => '<span class="badge badge-secondary">Ecofriendly </span><h6>En Búsca de la sostenibilidad</h6>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-dark sticky bg-dark navbar-expand-md fixed-top',

                ],
                'collapseOptions' => [
                    'class' => 'justify-content-end',
                ],
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav-left pr-3 d-sm-none d-xl-block'],
                'items' => [
                    '<li>' .
                        Html::beginForm(['/site/buscar'], 'get')
                        . Html::textInput(
                            'cadena',
                            '',
                            ['placeholder' => 'Buscar #Ecofriendly'],
                            ['class' => 'form-control']
                        )
                        . Html::submitButton(
                            '',
                            ['class' => 'btn btn-dark nav-link ']
                        )
                        . Html::endForm()

                ],
            ]);
            ?>

            <?php
            $usuario = Yii::$app->user->identity->rol;
            // $options = ['class' => ['img-fluid d-none d-sm-none d-xl-block'], 'style' => ['width' => '5rem', 'height' => '4rem', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];
            $options = ['class' => 'navbar-nav d-none d-xl-block ', 'style' => ['width' => '4rem', 'border-radius' => '30px']];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    Auxiliar::obtenerImagenUsuario(Yii::$app->user->identity->url_avatar, $options),
                    [
                        'label' => Icon::show('home') . 'Inicio',
                        'options' => [
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'tooltip',
                            'title' => 'Inicio de la página',
                            'class' => 'myTooltipClass'
                        ],
                        'url' => ['/site/index'],
                        'data-toggle' => 'tooltip',
                        'title' => 'Control Panel',
                    ],
                    $usuario == 'superadministrador'  ?  '' :
                        ['label' => Icon::show('wrench') . 'Área de usuario', 'url' => ['/usuarios/update']],
                    ['label' => Icon::show('bell') . 'Notificaciones', 'url' => ['/']],
                    ['label' => Icon::show('mail-bulk') . 'Mensajes', 'url' => ['/usuarios/mensajes']],
                    $usuario == 'superadministrador'  ?  '' : ['label' => Icon::show('question'), 'url' => ['/site/faqs']],



                    $usuario == 'superadministrador'  ?   ([
                        'label' => Icon::show('users-cog') . '<span class="badge badge-secondary">Modo Administrador</span>',
                        'items' => [
                            ['label' => 'Gestión Usuarios', 'url' => ['usuarios/index', 'id' => Yii::$app->user->identity->id]],
                            ['label' => 'Actividad en la red', 'url' => ['/feeds/index']],
                            ['label' => 'Ecoretos', 'url' => ['/acciones-retos/index']],
                            ['label' => 'Ranking', 'url' => ['/ranking/index']],


                        ],
                    ])

                        : '',
                    Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : ('<li class="nav-item">'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            '<span class="glyphicon glyphicon-off"></span>' . 'Logout (' . Yii::$app->user->identity->nombre . ')',
                            ['class' => 'btn btn-dark nav-link logout']
                        )
                        . Html::endForm()
                        . '</li>')
                ],
                'encodeLabels' => false

            ]);

            NavBar::end();
            ?>

            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>

        </div>
        <footer class="footer">
            <div class="container" itemscope itemtype="http://schema.org/Organization">
                <!-- Microdatos en el footer -->

                <span itemprop="brand">&copy; Ecofriendly.es <?= date('Y') ?> </span>
                <br>
                <span itemprop="address"> Avenida de Huelva s/n , Sanlúcar de Barrameda </span>

                <span itemprop="email"> Email de contacto: ecofriendlyrrss@gmail.com </span>

                <p class="float-right"><?= Yii::powered() ?></p>

            </div>
        </footer>

        <?php $this->endBody() ?>
    <?php } else {    ?>

        <main class="h-100">
            <div class="wrap">
                <div class="container-fluid">

                    <?= Alert::widget() ?>
                    <?= $content ?>
                    <footer class="footer">
    
                        <!-- Microdatos en el footer -->
    
                        <span itemprop="brand">&copy; Ecofriendly.es <?= date('Y') ?> </span>
                        <br>
                        <span itemprop="address"> Avenida de Huelva s/n , Sanlúcar de Barrameda </span>
    
                        <span itemprop="email"> Email de contacto: ecofriendlyrrss@gmail.com </span>
    
                        <p class="float-right"><?= Yii::powered() ?></p>
    
    
                    </footer>
                </div>
            </div>
        </main>


    <?php $this->endBody();
    } ?>
</body>

</html>
<?php $this->endPage() ?>