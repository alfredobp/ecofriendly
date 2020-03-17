<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('Ecofriendly.es') ?></title>
    <?php $this->head() ?>
</head>

<body>

    $this->beginBody();
    if (isset(Yii::$app->user->identity)) {

    ?> <div class="wrap">
            <?php

            NavBar::begin([
                'brandLabel' => 'Ecofriendly <small> en busca de la sostenibilidad</em>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-dark bg-dark navbar-expand-md fixed-top',

                ],
                'collapseOptions' => [
                    'class' => 'justify-content-end',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav-left'],
                'items' => [

                    Html::textInput('q', '', ['placeholder' => 'Buscar en Ecofriendly']),

                ],
            ]);
            $options = ['style' => ['width' => '50px', 'height' => '50px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    Yii::$app->user->isGuest ? '' : Html::img('/img/' . Yii::$app->user->identity->id . '.jpg', $options),
                    ['label' => 'Inicio', 'url' => ['/site/index']],
                    ['label' => 'Área de usuario', 'url' => ['/usuarios/update']],
                    ['label' => 'Mensajes', 'url' => ['/usuarios/update']],
                    ['label' => 'Notificaciones', 'url' => ['/taller']],
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

            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>

        </div>

        <footer class="footer">
            <div class="container">
                <p class="float-left">&copy; Ecofriendly.es <?= date('Y') ?></p>

                <p class="float-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    <?php  } else {

    ?> <div class="container-fluid">
          
        
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="float-left">&copy; Ecofriendly.es <?= date('Y') ?></p>

                <p class="float-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

    <?php $this->endBody();
    } ?>
</body>

</html>
<?php $this->endPage() ?>