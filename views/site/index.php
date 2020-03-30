<?php

/* @var $this yii\web\View */

use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use kartik\social\GoogleAnalytics;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html as Bootstrap4Html;
use yii\helpers\Html as HelpersHtml;
use yii\jui\Dialog;

$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <style>
        body {
            padding: 10px;

        }

        #exTab1 .tab-content {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }

        #exTab2 h3 {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }

        /* remove border radius for the tab */

        #exTab1 .nav-pills>li>a {
            border-radius: 0;
        }

        /* change border radius for the tab , apply corners on top*/

        #exTab3 .nav-pills>li>a {
            border-radius: 4px 4px 0 0;
        }

        #exTab3 .tab-content {
            color: white;
            background-color: #428bca;
            padding: 5px 15px;
        }
    </style>
</head>
<div class="container-fluid">
    <div class="row ">
        <div class="col-3">
            <?php $options = ['style' => ['width' => '150px', 'height' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>
            <?php
            file_exists(Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg')) ?  $imagenUsuario = Url::to('@web/img/' . Yii::$app->user->identity->id . '.jpg') : $imagenUsuario = Url::to('@web/img/basica.jpg');
            ?>
            <?= Bootstrap4Html::img($imagenUsuario, $options) ?>
            <hr>
            <h2> <?= Yii::$app->user->identity->nombre ?> </h2>
            <br>
            <h5>Estado: "<?= $datos['estado'] ?>"</h5>
            <?php

            echo GoogleAnalytics::widget([
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
                'noscript' => 'Analytics cannot be run on this browser since Javascript is not enabled.'
            ]); ?>
            <h4> ECOpuntuación <span id='puntos' class="badge"><?= $puntos['puntuacion'] ?></span> </h4>
            <?php
            $script = <<<JS
            $(function(){
                sliderPuntuacion();
                eliminarIntro();
                              });
                function sliderPuntuacion() {
                    var puntuacion = $("#puntos")[0].innerHTML; 
                    
                    if (puntuacion<=20) {
                        $('#puntos').addClass("badge-danger");
                        $('.progress-bar').css("width", puntuacion+'%').addClass("bg-danger");
                    }else if(puntuacion>20&&puntuacion<60){
                        $('#puntos').addClass("badge-warning");
                        $('.progress-bar').css("width", puntuacion +'%').addClass("bg-warning");
                    }
                    else if(puntuacion>60){
                        $('#puntos').addClass("badge-success");
                        $('.progress-bar').css("width", puntuacion+'%').addClass("bg-success");
                    }
                }
                    
                 function eliminarIntro() {
                        var numeros=$('.feed').toArray().length;
                        if(numeros>0){
                             $('.intro').empty();
                                             }                   
                }
            JS;

            $this->registerJs($script);

            ?>
            <h5>Retos Propuestos</h5>
            <?php

            Dialog::begin([
                'clientOptions' => [
                    'modal' => true,
                    'title' => 'Información para nuevos usuarios de #ecofriendly',
                    'width' => '600px',
                ],
            ]);
            echo    '<p> Bienvenido a la red social de ecofriendly, donde prodrás mejorar tu huella de carbono y ayudar a cuidar el planeta.

            ¿Por donde empezar?

                <a class="list-group-item list-group-item-action" href="#list-item-1"> 1. Agrega nuevos seguidores a tu red, para ver el contenido.</a>
                <a class="list-group-item list-group-item-action" href="#list-item-2"> 2. Observa los ecoretos que se te ha otorgado y acepta el desafio.</a>
                <a class="list-group-item list-group-item-action" href="#list-item-3"> 3. Comparte cualquier tema relacionado con la sostenibilidad y el planeta.</a>
                <a class="list-group-item list-group-item-action" href="#list-item-4">4. Recuerda que puedes ver tu progreso en cualquier momento desde el sidebar.</a>
            
        </p>
        <p class="card-text"><small class="text-muted"> El equipo de #Ecofriendly </small></p>';
            Dialog::end();
            ?>
            <p> En función de su puntuación se le ha otorgado los siguientes retos:</p>
            <ul>


                <?php


                for ($i = 0; $i <  sizeof($retosListado); $i++) {

                    echo '<li> <a href="index.php?r=acciones-retos%2Fview&id=' . $retosListado[$i]->id . '"><span class="badge badge-primary">'  .  $retosListado[$i]->descripcion  .
                        '</span><a/></li>';
                }

                ?>
            </ul>
            <br>
            <br>
            <h5>Tu progreso:</h5>
            <p id='feed'>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deleniti, suscipit velit. Maxime reprehenderit nisi repellendus asperiores nesciunt? Vel quos, eos itaque ad est iste rem deserunt saepe explicabo vero praesentium.</p>
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <br>
            <br>
            <h5>Comparte contenido en otras redes:</h5>
            <?php echo TwitterPlugin::widget([]); ?>
            <?php echo FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' => ['size'=>'small', 'layout'=>'button_count', 'mobile_iframe'=>'false']]);?>
            
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>

        <div class="col-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Compartir estado

                        <svg class="bi bi-chat-quote" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 01.287.801 10.97 10.97 0 01-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 01.71-.074A8.06 8.06 0 008 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 01-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 00.244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 01-2.347-.306c-.52.263-1.639.742-3.468 1.105z" clip-rule="evenodd" />
                            <path d="M7.468 7.667c0 .92-.776 1.666-1.734 1.666S4 8.587 4 7.667C4 6.747 4.776 6 5.734 6s1.734.746 1.734 1.667z" />
                            <path fill-rule="evenodd" d="M6.157 6.936a.438.438 0 01-.56.293.413.413 0 01-.274-.527c.08-.23.23-.44.477-.546a.891.891 0 01.698.014c.387.16.72.545.923.997.428.948.393 2.377-.942 3.706a.446.446 0 01-.612.01.405.405 0 01-.011-.59c1.093-1.087 1.058-2.158.77-2.794-.152-.336-.354-.514-.47-.563zm-.035-.012h-.001.001z" clip-rule="evenodd" />
                            <path d="M11.803 7.667c0 .92-.776 1.666-1.734 1.666-.957 0-1.734-.746-1.734-1.666 0-.92.777-1.667 1.734-1.667.958 0 1.734.746 1.734 1.667z" />
                            <path fill-rule="evenodd" d="M10.492 6.936a.438.438 0 01-.56.293.413.413 0 01-.274-.527c.08-.23.23-.44.477-.546a.891.891 0 01.698.014c.387.16.72.545.924.997.428.948.392 2.377-.942 3.706a.446.446 0 01-.613.01.405.405 0 01-.011-.59c1.093-1.087 1.058-2.158.77-2.794-.152-.336-.354-.514-.469-.563zm-.034-.012h-.002.002z" clip-rule="evenodd" />
                        </svg>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                        Compartir imagen
                        <svg class="bi bi-card-image" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd" />
                            <path d="M10.648 7.646a.5.5 0 01.577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 01.63-.062l2.66 1.773 3.71-3.71z" />
                            <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                    <div class="card">
                        <div class="card-header">
                            <b>Comparte lo que quieras</b>
                        </div>
                        <div class="card-block">

                            <div class="tab-pane active" id="home" role="tabpanel">

                                <?php
                                $form = ActiveForm::begin([
                                    'action' => ['feeds/create'],
                                    'method' => 'post',
                                    'options' =>   ['enctype' => 'multipart/form-data'],
                                ]); ?>
                                <?= $form->field($model, 'contenido')->textarea(['rows' => 4])->label('') ?>
                                <!-- <?= $form->field($model, 'imagen')->fileInput() ?> -->
                                <?= HelpersHtml::submitButton('Publicar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                <?php ActiveForm::end(); ?>
                            </div>

                            <br>
                        </div>

                        <div class="card-footer text-muted collapse" id="collapseExample">
                            <br>
                        </div>
                    </div>
                    <br>


                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <?php
                    $form = ActiveForm::begin([
                        'action' => ['feeds/imagen'],
                        'method' => 'post',
                        'options' =>   ['enctype' => 'multipart/form-data'],
                    ]); ?>
                    <br>
                    <?= HelpersHtml::submitButton('Subir Imagen', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <br>
            </div>
            <hr>
            </hr>
            <?php foreach ($feeds as $feeds) :
            ?>
                <?php file_exists(Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg')) ?  $imagenFeed = Url::to('@web/img/' . $feeds->id . 'feed' . '.jpg') : '';
                ?>
                <div class="card feed">

                    <div class="card-block">
                        <h4 class="card-title"><img src=<?= '/img/' . $feeds->usuariosid . '.jpg' ?> class="img-fluid rounded" alt="Responsive image rounded" style="width:80px;"> <?= $feeds->usuariosid  ?></h4>
                        <p class="card-text"><?= Html::encode($feeds->contenido) ?></p>
                        <p class="card-text"><small class="text-muted">Publicado: <?= Html::encode(Yii::$app->formatter->asRelativeTime($feeds->created_at))  ?></small></p>
                    </div>

                    <?= file_exists(Url::to('@app/web/img/' . $feeds->id . 'feed.jpg')) ? '<img  class=" img-fluid mr-md-3 mb-3 ml-3 mt-1" src="/img/' . $feeds->id  . 'feed.jpg" width=auto padding=20px>' :  '' ?>
                    <div class="card-footer text-muted">
                        <div class="row">

                            <div class="col"><a href="#" class="text-primary" style="text-decoration:none;"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span id="estrella" class='glyphicon glyphicon-heart' aria-hidden='true'></span> Me Gusta <small class="text-muted">12</small></a></div>
                            <div class="col"><a style="text-decoration:none;" class="text-muted" data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-comment-o" aria-hidden="true"></i> Comentar <small class="text-muted">2</small></a>
                            </div>
                            <div class="col dropup">
                                <a href="#" class="dropdown-toggle text-muted" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none;"><i class="fa fa-share-square-o" aria-hidden="true"></i> Compartir</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" id="a" data-toggle="modal" data-target="#exampleModal">Compartir</a>
                                    <a class="dropdown-item" href="#" id="a1" data-toggle="modal" data-target="#exampleModal">Compartir con Amigos</a>
                                    <a class="dropdown-item" href="#">Compartir Publico</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample1">
                            <br>
                            <div class="divider"></div>
                            <br>
                            <div class="row">
                                <div class="col-2">
                                    <img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:90px;">
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
                                    <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                    <div class="col-2">
                                        <a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
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
                <br>
                <br>
            <?php endforeach; ?>
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
            <div class="card">
                <div class="card-block intro">
                    <h4 class="card-title"> #ecofriendly</h4>
                    <p class="card-text"> Bienvenido a la red social de ecofriendly, donde prodrás mejorar tu huella de carbono y ayudar a cuidar el planeta.

                        ¿Por donde empezar?


                        <div id="list-example" class="col-10 ml-center list-group p-3">
                            <a class="list-group-item list-group-item-action" href="#list-item-1"> 1. Agrega nuevos seguidores a tu red, para ver el contenido.</a>
                            <a class="list-group-item list-group-item-action" href="#list-item-2"> 2. Observa los ecoretos que se te ha otorgado y acepta el desafio.</a>
                            <a class="list-group-item list-group-item-action" href="#list-item-3"> 3. Comparte cualquier tema relacionado con la sostenibilidad y el planeta.</a>
                            <a class="list-group-item list-group-item-action" href="#list-item-4">4. Recuerda que puedes ver tu progreso en cualquier momento desde el sidebar.</a>
                        </div>
                    </p>
                    <p class="card-text"><small class="text-muted"> El equipo de #Ecofriendly </small></p>
                </div>
            </div>
            <br>
            <br>
        </div>
        <div class="col-3">
            <div class="card card-inverse">
                <div class="card-block">
                    <h4 class="card-title"> <span class="glyphicon glyphicon-plus "></span> Encuentra a más usuarios</h4>
                    <p class="card-text">Lleva tu pagina a mas personas en nuestra plataforma mediante nuestro servicio de promoción.
                        <div class="list-group col-12 ">

                            <?php $optionsBarraUsuarios = ['style' => ['width' => '60px', 'height' => '60px', 'margin-right' => '2px', 'margin-left' => '2px']];

                            for ($i = 0; $i < sizeof($usuarios); $i++) {
                                file_exists(Url::to('@app/web/img/' . $usuarios[$i]->id . '.jpg')) ?  $imagenUsuario = Url::to('@web/img/' . $usuarios[$i]->id . '.jpg') : $imagenUsuario = Url::to('@web/img/basica.jpg');

                                echo Html::beginForm(['seguidores/create'], 'post')
                                    . '<div style= "margin-left:10px">' .  Html::img($imagenUsuario, $optionsBarraUsuarios) . 'Usuario: ' . $usuarios[$i]->nombre;
                                echo   Html::hiddenInput('id', $usuarios[$i]->id);
                                echo Html::submitButton(
                                    '<span class="glyphicon glyphicon-plus btn-xs "></span>',
                                    ['class' => 'btn btn-success btn-sm ml-2'],
                                );
                                echo  '</div>' . Html::endForm();
                            }
                            ?>
                        </div>
                    </p>
                    <a href="#" class="btn btn-primary">Invitar a más amigos</a>
                </div>
            </div>
            <br>
            <div class="card card-inverse">
                <div class="card-block">
                    <h4 class="card-title">Tu red de amigos:</h4>
                    <p class="card-text">
                        <div class="list-group col-12 ">
                            <?php
                            $file =  Url::to('@app/web/img/' . Yii::$app->user->identity->id . '.jpg');
                            $exists = file_exists($file);
                            $imagenUsuario = Url::to('@web/img/' . Yii::$app->user->identity->id . '.jpg');
                            $urlImagenBasica = Url::to('@web/img/basica.jpg');
                            if (!$exists) {
                                $imagenUsuario = $urlImagenBasica;
                            }

                            for ($i = 0; $i < sizeof($seguidores); $i++) {
                                file_exists(Url::to('@app/web/img/' . $usuarios[$i]->id . '.jpg')) ?  $imagenUsuario = Url::to('@web/img/' . $usuarios[$i]->id . '.jpg') : $imagenUsuario = Url::to('@web/img/basica.jpg');

                                echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post')
                                    . '<div style= "margin-left:10px">' . Html::img($imagenUsuario, $optionsBarraUsuarios) . 'Usuario: ';
                                echo Html::hiddenInput('id', $seguidores[$i]->id);
                                echo Html::submitButton(
                                    '<span class="glyphicon glyphicon-minus"></span>',
                                    ['class' => 'btn btn-danger btn-sm ml-2'],
                                );
                                echo    Html::endForm();
                            }
                            ?>
                            <br>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam rem, eaque amet aperiam ex esse voluptatum fugiat doloribus laboriosam at delectus? Sapiente error hic fuga voluptate cupiditate omnis iure corrupti.
                        </div>
                    </p>
                    <a href="#" class="btn btn-primary">Invitar a más amigos</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>