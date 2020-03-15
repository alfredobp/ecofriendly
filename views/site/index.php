<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap\Html;

$this->title = 'EcoFriendly';
?>
<div class="container-fluid">



    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <nav class="navbar fixed-top navbar-toggleable-md navbar-light bg-faded navbar-inverse bg-primary">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">EcoFriendly</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="form-inline my-2 my-lg-0 dropdown">
                        <input class="form-control mr-sm-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="text" placeholder="Buscar en ecofriendly">
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">Vew More</a>
                        </div>
                    </form>
                    <ul class="navbar-nav navbar-toggler-right">
                        <img src='/img/<?=Yii::$app->user->identity->id?>.jpg' width="34px">
                        <li class="nav-item">
                            <a class="nav-link" href="/usuarios/update"> <?= Yii::$app->user->identity->nombre ?> |<span class="sr-only img-tmn">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">INICIO <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i><span class="badge badge-pill badge-danger">1</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-comment" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe" aria-hidden="true"></i> |
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/faqs">FAQs</a>
                                <a class="dropdown-item" href="/version">Licencia</a>

                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/usuarios/update">Configuración</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Registro de Actividad</a>
                                <a class="dropdown-item" href="site/Logout">Salir</a>
                                <?php
                                NavBar::begin([]);
                                echo Nav::widget([
                                    'options' => ['class' => 'navbar-nav'],
                                    'items' => [
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
                                NavBar::end(); ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
        <div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum ab quod reiciendis, ad tempore nemo ex temporibus, velit dolorem maiores corrupti porro suscipit amet possimus enim nesciunt dolore veritatis ut.</p>
        </div>