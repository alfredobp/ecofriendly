<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use cybercog\yii\googleanalytics\widgets\GATracking;
use kartik\dialog\Dialog;
use kartik\dialog\DialogAsset;
use yii\jui\Dialog as JuiDialog;

DialogAsset::register($this);

$urlCookie = Url::toRoute(['site/cookie',  'respuesta' => 'aceptada'], $schema = true);

$js = <<<EOT
    $( function() {
        krajeeDialogCust1.confirm("Utilizamos cookies para mejorar su experiencia de usuario. Por favor, acepte nuestra politica de cookies.", function (result) {
          
            result?window.location="$urlCookie":window.location="https://duckduckgo.com/";
          
        });
    });
    
EOT;
if (!isset($_COOKIE['politicaCookies'])) {

    $this->registerJs($js);
}

echo Dialog::widget([

    'libName' => 'krajeeDialogCust1',
    'options' => [
        'draggable' => false,
        'closable' => false,
        'size' => Dialog::SIZE_SMALL,
        'type' => Dialog::TYPE_WARNING,
        'title' => 'Politica de cookies de #ecofriendly',
        'message' => 'Utilizamos cookies para mejorar su experiencia de usuario. Por favor, acepte nuestra politica de cookies.',
        'btnOKClass' => 'btn-primary',
        'btnOKLabel' =>  'Aceptar',
        'btnCancelClass' => 'btn-light',
        'btnCancelLabel' =>  'Cancelar',

    ],
]);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('Ecofriendly.es') ?></title>
    <?= GATracking::widget([
        'trackingId' => 'UA-162197120-1',
    ]) ?>
    <?php $this->head() ?>
</head>

<body>
    <?php
    $this->beginBody();
    if (isset(Yii::$app->user->identity)) {

    ?> <div class="wrap">
            <header>
                <br>
                <br>
                <br>
                <?php

                NavBar::begin([
                    'brandLabel' => 'Ecofriendly <small> en busca de la sostenibilidad</small>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-dark sticky bg-dark navbar-expand-md fixed-top',

                    ],
                    'collapseOptions' => [
                        'class' => 'justify-content-end',
                    ],
                ]);


                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav-left d-none d-sm-none d-xl-block'],
                    'items' => [
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
                $options = ['class' => ['img-fluid d-none d-sm-none d-xl-block'], 'style' => ['width' => '5rem', 'height' => '4rem', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav'],
                    'items' => [
                        Yii::$app->user->isGuest ? '' : file_exists(Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg')) ? Html::img('/img/' . Yii::$app->user->identity->id . '.jpg', $options) : '',
                        [
                            'label' => 'Inicio', 'icon' => 'home',
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
                        ['label' => 'Área de usuario', 'url' => ['/usuarios/update']],
                        ['label' => 'Mensajes', 'url' => ['/usuarios/mensajes']],
                        ['label' => 'Notificaciones', 'url' => ['/']],
                        Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : ('<li class="nav-item">'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->nombre . ')',
                                ['class' => 'btn btn-dark nav-link logout']
                            )
                            . Html::endForm()
                            . '</li>')
                    ],
                ]);

                NavBar::end();
                ?>
            </header>
            <main>
                <div class="container">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </main>
        </div>
        <footer class="footer">
            <div class="container" itemscope itemtype="http://schema.org/Organization">
                <!-- Microdatos en el footer -->
                <span itemprop="brand">&copy; Ecofriendly.es <?= date('Y') ?> </span>
                <br>
                <span itemprop="address"> Avenida de Huelva s/n , Sanlúcar de Barrameda </span>
                <br>
                <span itemprop="email"> Email de contacto: ecofriendlyrrss@gmail.com </span>

                <p class="float-right"><?= Yii::powered() ?></p>

            </div>
        </footer>

        <?php $this->endBody() ?>
    <?php } else {


    ?>

        <main class="h-100">
            <div class="wrap">
                <div class="container-fluid">

                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </main>
        <footer class="d-none d-lg-block d-xl-block">
            <div class="container" itemscope itemtype="http://schema.org/Organization">

                <span itemprop="brand">&copy; Ecofriendly.es <?= date('Y') ?> </span>
                <br>
                <small itemprop="address"> Avenida de Huelva s/n , Sanlúcar de Barrameda </small>

                <small itemprop="email"> Email de contacto: ecofriendlyrrss@gmail.com </small>

                <p class="float-right"><?= Yii::powered() ?></p>

            </div>
        </footer>
        </div>

    <?php $this->endBody();
    } ?>
</body>

</html>
<?php $this->endPage() ?>