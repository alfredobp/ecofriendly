<?php

/* @var $this yii\web\View */

use kartik\rating\StarRating;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap\Html;
use kartik\widgets\Spinner;

$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'EcoFriendly'; ?>
<div class="container-fluid">
    <div>
        <br>
        <br>
        <br>
        <br>

    </div>
    <div class="row">
        <div class="col-3">
            <?php $options = ['style' => ['width' => '150px', 'height' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>

            <?= Html::img('/img/' . Yii::$app->user->identity->id . '.jpg', $options) ?>

            <h2> <?= Yii::$app->user->identity->nombre ?> </h2>
            <h4>Estado:<h6><?=$estado['estado']?><h6></h4>
            <h4>ECOpuntuación:<h6><?=$estado['nombre']?><h6>
            </h4>
            <h5>Retos Propuestos</h5>
            <ul>
                <li>Coger menos la bicicleta</li>
                <li>Correr mas</li>
                <li>No comer alimentos procesados</li>
                <li>Colaborar en acciones de voluntariado</li>
                <li>Compartir coche</li>
            </ul>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">

                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><i class="fa fa-commenting" aria-hidden="true"></i></a>

                </div>
                <div class="card-block">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home" role="tabpanel">
                            <textarea class="form-control border-0 sinborde" id="exampleTextarea" rows="3" placeholder="Compartir contenido" style="resize: none;"></textarea>
                        </div>

                    </div>
                    <div class="divider"></div>
                    <br>
                    <a class="text-left" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-outline-primary btn-sm float-right">Publicar</button>
                </div>
                <div class="card-footer text-muted collapse" id="collapseExample">

                    <br>
                    <div class="row">
                        <div class="col-2"><a href="#"><img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/2.2.0/2/svg/1f911.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                        <div class="col-2">
                            <a href="#"><img src="https://s.w.org/images/core/emoji/2/svg/1f601.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                        </div>
                       
                    </div>

                </div>

            </div>
            <br>

            <div class="card">
                <div class="card-block">
                    <h4 class="card-title"><img src="https://www.institutomedios.com/wp-content/themes/institutomedios/img/logo.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"> Sara Miles</h4>
                    <p class="card-text">Un dia en el pico naiguata.</p>
                    <p class="card-text"><small class="text-muted">Subio una foto hace 3 mins</small></p>
                </div>
                <img class="card-img-bottom" src="http://www.climbingvenezuela.com/sites/default/files/styles/bigwig_940x460/public/bigwig/ascenso_pico_naiguata_02_0.jpg?itok=mAq5kzme" alt="Card image cap">

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col"><a href="#" class="text-primary" style="text-decoration:none;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Me Gusta <small class="text-muted">12</small></a></div>
                        <div class="col"><a style="text-decoration:none;" class="text-muted" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-comment-o" aria-hidden="true"></i> Comentar <small class="text-muted">2</small></a>
                        </div>
                        <div class="col dropup">
                            <a href="#" class="dropdown-toggle text-muted" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none;"><i class="fa fa-share-square-o" aria-hidden="true"></i> Compartir</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Compartir Publico</a>
                                <a class="dropdown-item" href="#" id="a" data-toggle="modal" data-target="#exampleModal">Compartir</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="a1" data-toggle="modal" data-target="#exampleModal">Compartir con Amigos</a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample1">
                        <br>
                        <div class="divider"></div>
                        <br>
                        <div class="row">
                            <div class="col-2">
                                <img src="http://www.paraface.org/wp-content/uploads/2014/10/subir-Fotos-para-perfil-de-facebook.jpg" class="img-fluid rounded" alt="Responsive image rounded" style="width:90px;">
                            </div>
                            <div class="col-10">
                                <textarea class="form-control border-0 sinborde2" id="exampleTextarea" rows="3" placeholder="Comentar Foto" style="resize: none;"></textarea>
                                <br>
                                <a class="text-left" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a>
                                <button type="button" class="btn btn-outline-primary btn-sm float-right">Comentar</button>
                            </div>
                        </div>
                        <div class="text-muted collapse" id="collapseExample3">
                            <br>
                            <div class="row">
                                <div class="col-2"><a href="#"><img src="https://www.emoji.co.uk/files/emoji-one/smileys-people-emoji-one/1300-face-with-open-mouth-and-cold-sweat.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                <div class="col-2">
                                    <a href="#"><img src="https://emoji-38d7.kxcdn.com/emojione/twitter-facebook-share/1f912.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                                </div>
                               
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-2"><a href="#"><img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/2.2.0/2/svg/1f911.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                <div class="col-2">
                                    <a href="#"><img src="https://s.w.org/images/core/emoji/2/svg/1f601.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                                </div>
                                <div class="col-2"><a href="#"><img src="https://s.w.org/images/core/emoji/2.2.1/svg/1f913.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                <div class="col-2"><a href="#"><img src="https://s.w.org/images/core/emoji/2/svg/1f61d.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                <div class="col-2"><a href="#"><img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/2.2.0/2/svg/1f607.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                <div class="col-2"><a href="#"><img src="https://s0.wp.com/wp-content/mu-plugins/wpcom-smileys/twemoji/2/svg/1f632.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                            </div>

                        </div>
                        <br>
                        <div class="divider"></div>
                        <br>
                        <div class="media">
                            <img class="d-flex mr-3" src="http://www.paraface.org/wp-content/uploads/2014/10/subir-Fotos-para-perfil-de-facebook.jpg" alt="Generic placeholder image" style="width:50px;">
                            <div class="media-body">
                                <h5 class="mt-0">Joi</h5>
                                Perfect <img src="https://www.emoji.co.uk/files/emoji-one/smileys-people-emoji-one/1268-kissing-face-with-closed-eyes.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:30px;">

                                <div class="media mt-3">
                                    <img src="http://institutomedios.com/wp-content/uploads/2015/01/perfil_de_ana_beatriz_barros_wallpaper-35255.jpg" class="d-flex mr-3" alt="Responsive image rounded" style="width:50px;">
                                    <div class="media-body">
                                        <h5 class="mt-0">Sara Miles</h5>
                                        Gracias
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
            <div class="card-block">
                <h4 class="card-title"><img src="https://www.institutomedios.com/wp-content/themes/institutomedios/img/logo.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"> Sara Miles</h4>
                <p class="card-text">Un dia en el pico naiguata.</p>
                <p class="card-text"><small class="text-muted">Subio una foto hace 3 mins</small></p>
            </div>
            <img class="card-img-bottom" src="http://www.climbingvenezuela.com/sites/default/files/styles/bigwig_940x460/public/bigwig/ascenso_pico_naiguata_02_0.jpg?itok=mAq5kzme" alt="Card image cap">

            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col"><a href="#" class="text-primary" style="text-decoration:none;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Me Gusta <small class="text-muted">12</small></a></div>
                    <div class="col"><a style="text-decoration:none;" class="text-muted" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-comment-o" aria-hidden="true"></i> Comentar <small class="text-muted">2</small></a>
                    </div>
                    <div class="col dropup">
                        <a href="#" class="dropdown-toggle text-muted" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none;"><i class="fa fa-share-square-o" aria-hidden="true"></i> Compartir</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Compartir Publico</a>
                            <a class="dropdown-item" href="#" id="a" data-toggle="modal" data-target="#exampleModal">Compartir</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" id="a1" data-toggle="modal" data-target="#exampleModal">Compartir con Amigos</a>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapseExample1">
                    <br>
                    <div class="divider"></div>
                    <br>
                    <div class="row">
                        <div class="col-2">
                            <img src="http://www.paraface.org/wp-content/uploads/2014/10/subir-Fotos-para-perfil-de-facebook.jpg" class="img-fluid rounded" alt="Responsive image rounded" style="width:90px;">
                        </div>
                        <div class="col-10">
                            <textarea class="form-control border-0 sinborde2" id="exampleTextarea" rows="3" placeholder="Comentar Foto" style="resize: none;"></textarea>
                            <br>
                            <a class="text-left" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-outline-primary btn-sm float-right">Comentar</button>
                        </div>
                    </div>
                    <div class="text-muted collapse" id="collapseExample3">
                        <br>
                        <div class="row">
                            <div class="col-2"><a href="#"><img src="https://www.emoji.co.uk/files/emoji-one/smileys-people-emoji-one/1300-face-with-open-mouth-and-cold-sweat.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                            <div class="col-2">
                                <a href="#"><img src="https://emoji-38d7.kxcdn.com/emojione/twitter-facebook-share/1f912.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                            </div>
                           
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-2"><a href="#"><img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/2.2.0/2/svg/1f911.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                            <div class="col-2">
                                <a href="#"><img src="https://s.w.org/images/core/emoji/2/svg/1f601.svg" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="divider"></div>
                    <br>
                    <div class="media">
                        <img class="d-flex mr-3" src="http://www.paraface.org/wp-content/uploads/2014/10/subir-Fotos-para-perfil-de-facebook.jpg" alt="Generic placeholder image" style="width:50px;">
                        <div class="media-body">
                            <h5 class="mt-0">Joi</h5>
                            Perfect <img src="https://www.emoji.co.uk/files/emoji-one/smileys-people-emoji-one/1268-kissing-face-with-closed-eyes.png" class="img-fluid rounded" alt="Responsive image rounded" style="width:30px;">

                            <div class="media mt-3">
                                <img src="http://institutomedios.com/wp-content/uploads/2015/01/perfil_de_ana_beatriz_barros_wallpaper-35255.jpg" class="d-flex mr-3" alt="Responsive image rounded" style="width:50px;">
                                <div class="media-body">
                                    <h5 class="mt-0">Sara Miles</h5>
                                    Gracias
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-inverse">
                <div class="card-block">
                    <h3 class="card-title">Encuentra a mas usuarios</h3>
                    <p class="card-text">Lleva tu pagina a mas personas en nuestra plataforma mediante nuestro servicio de promoción.</p>
                    <a href="#" class="btn btn-primary">Contratar</a>
                </div>
            </div>
            <br>
        </div>

    </div>
</div>


</body>

</html>