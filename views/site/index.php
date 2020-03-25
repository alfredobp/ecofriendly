<?php

/* @var $this yii\web\View */

use app\models\Feeds;
use app\models\Seguidores;
use kartik\rating\StarRating;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap\Html;
use kartik\widgets\Spinner;
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;

$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>


<div class="container-fluid">


    <div class="row ">
        <div class="col-3">
            <?php $options = ['style' => ['width' => '150px', 'height' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>

            <?= Html::img('/img/' . Yii::$app->user->identity->id . '.jpg', $options) ?>
            <hr>
            <h2> <?= Yii::$app->user->identity->nombre ?> </h2>
            <br>
            <h5>Estado: "<?= $datos['estado'] ?>"
            </h5>

            <h4> ECOpuntuación <span id='puntos' class="badge"><?= $puntos['puntuacion'] ?></span> </h4>

            <?php
            $script = <<<JS
            $(function(){
            sliderPuntuacion();

            });
            function sliderPuntuacion() {
            var puntuacion = $("#puntos")[0].innerHTML; 
                
                if (puntuacion<20) {
                    $('#puntos').addClass("badge-danger");
                    $('.progress-bar').css("width",puntuacion+'%').addClass("bg-danger");
                }else if(puntuacion>20&&puntuacion<60){
                    $('#puntos').addClass("badge-warning");
                    $('.progress-bar').css("width",puntuacion+'%').addClass("bg-warning");
                }
                else if(puntuacion>60){
                    $('#puntos').addClass("badge-success");
                    $('.progress-bar').css("width", puntuacion+'%').addClass("bg-success");
                }
                
            }
            JS;

            $this->registerJs($script);

            ?>
            <?php
            //    echo Editable::widget([
            //     'name' => 'notes',
            //     'asPopover' => true,
            //     'displayValue' => 'more...',
            //     'inputType' => Editable::INPUT_TEXTAREA,
            //     'value' => "Raw denim you...",
            //     'header' => 'Notes',
            //     'submitOnEnter' => false,
            //     'size' => 'lg',
            //     'options' => ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Enter notes...']
            // ]);

            ?>
            </p>
            </h2>
            <h5>Retos Propuestos</h5>
            <p> En función de su puntuación se le ha otorgado los siguientes retos:</p>
            <ul>
                <?php for ($i = 0; $i <  sizeof($retos); $i++) {
                    echo '<li> <a href="index.php?r=ecoretos/view&id=' . $retos[$i]->id . '">'  . $retos[$i]->descripcion . '</a> ' .  '<span class="badge badge-primary">   ' . $retos[$i]->puntaje  .
                        '</span></h1>' . '</li>';
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
            <!-- <div class="progress">
                <div class="progress-bar"></div>
            </div> -->
            <br>
            <br>
            <h5>Comparte contenido en otras redes:</h5>
            <a href="https://twitter.com/intent/tweet?button_hashtag=ecofriendly&ref_src=twsrc%5Etfw" class="twitter-hashtag-button" data-show-count="false">Tweet #ecoFriendly</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>

        <div class="col-6">
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



                        <?= $form->field($model, 'contenido')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'imagen')->fileInput() ?>


                        <?= Html::submitButton('Publicar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>


                        <?php ActiveForm::end(); ?>


                    </div>
                    <div class="divider"></div>
                    <br>
                    <!-- <a class="text-left" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a> -->


                </div>

                <div class="card-footer text-muted collapse" id="collapseExample">

                    <br>

                </div>
            </div>
            <br>


            <?php for ($i = 0; $i <  sizeof($feeds); $i++) {
            ?>
                <div class="card">

                    <div class="card-block">
                        <h4 class="card-title"><img src=<?= '/img/' . Yii::$app->user->identity->id . '.jpg' ?> class="img-fluid rounded" alt="Responsive image rounded" style="width:80px;"> <?= Yii::$app->user->identity->nombre ?></h4>
                        <p class="card-text"><?= $feeds[$i]->contenido ?></p>
                        <p class="card-text"><small class="text-muted">Publicado: <?= $feeds[$i]->created_at  ?></small></p>
                    </div>
                    <img class="card-img-bottom"> <img src=<?= '/img/'  . $feeds[$i]->id  . 'feed' .  '.jpg' ?> width="400px">

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
                <br>
                <br>
            <?php } ?> <div class="card">

                <div class="card-block">
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
                    <h3 class="card-title">Encuentra a mas usuarios</h3>
                    <p class="card-text">Lleva tu pagina a mas personas en nuestra plataforma mediante nuestro servicio de promoción.
                        <div class="list-group col-12 ">

                            <?php $optionsBarraUsuarios = ['style' => ['width' => '100px', 'height' => '60px', 'margin-right' => '2px', 'margin-left' => '2px']]; ?>


                            <?php

                            for ($i = 0; $i < sizeof($usuarios); $i++) {
                                echo Html::beginForm(['seguidores/create'], 'post')
                                    . '<div>' .  Html::img('/img/' . $usuarios[$i]->id . '.jpg', $optionsBarraUsuarios) . 'Usuario: ' . $usuarios[$i]->nombre . '</button>' . '<br>';
                                echo   Html::hiddenInput('id', $usuarios[$i]->id);
                                echo Html::submitButton(
                                    'Seguir',
                                    ['class' => 'btn btn-success btn-sm'],
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
                    <h3 class="card-title">Tu red de amigos:</h3>
                    <p class="card-text">
                        <div class="list-group col-12 ">
                            <?php
                            $optionsBarraUsuarios = ['style' => ['width' => '80px']];
                            for ($i = 0; $i < sizeof($seguidores); $i++) {
                                echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post');
                                echo   Html::img('/img/' . $seguidores[$i]->seguidor_id . '.jpg', $optionsBarraUsuarios) . 'Usuario: ' . '</button>' . '<br>';
                                echo   Html::hiddenInput('id', $seguidores[$i]->id);

                                echo Html::submitButton(
                                    'Dejar de seguir',
                                    ['class' => 'btn btn-danger btn-sm float-center'],
                                    ['style' => ['margin' => '100px']],
                                );
                                echo    Html::endForm();
                                echo '<p>';
                            }
                            ?>
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