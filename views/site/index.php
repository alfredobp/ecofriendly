<?php

/* @var $this yii\web\View */

use app\helper_propio\Auxiliar;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use app\helper_propio\GestionCookies as Helper_propioGestionCookies;
use app\helper_propio\Gridpropio;
use app\models\Feeds;
use app\models\Ranking;
use kartik\grid\GridView as GridGridView;
use kartik\grid\GridViewAsset;
use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use kartik\social\GoogleAnalytics;
use Symfony\Component\OptionsResolver\Options;
use yii\bootstrap4\Html as Bootstrap4Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use yii\bootstrap4\Nav;
use yii\widgets\ActiveForm;
use yii\helpers\Html as HelpersHtml;
use yii\jui\Dialog;
use kartik\icons\Icon;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

Icon::map($this);
$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(Helper_propioGestionCookies::introduccion());

if (isset($_COOKIE['colorPanel']) || isset($_COOKIE['colorTexto']) || isset($_COOKIE['fuente']) || isset($_COOKIE['tamaño'])) {
    $this->registerJs(Helper_propioGestionCookies::cookiesEstilo());
}
?>
<div class="container-fluid">
    <div class="loader"></div>
    <div class="row ">
        <aside class="col-3 col-lg-3 order-1 order-lg-0 d-none d-md-block">


            <?php $options = ['class' => ['img-contenedor'], 'style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>

            <?= Auxiliar::obtenerImagenUsuario(Yii::$app->user->identity->url_avatar, $options); ?>
            <hr>
            <h2> <?= ucfirst(Yii::$app->user->identity->nombre) ?> </h2>
            <br>
            <h5>Estado: "<span id="estado"></span>"
                <?php

                echo Html::button(Icon::show('edit'), ['value' => Url::to('/index.php?r=usuarios%2Fupdateestado'), 'class' => 'btn modalButton3 btn-lg active', 'id' => 'modalButton3']);
                ?>
            </h5>
            <?php
            Modal::begin([
                'title' => '<h3>Modifique su estado</h3>',
                'id' => 'modal3',
                'size' => 'modal-xs',
            ]);
            echo '<div id="modalContent3"></div>';

            Modal::end();
            ?>
            <?php

            echo GoogleAnalytics::widget([
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
                'noscript' => 'Analytics cannot be run on this browser since Javascript is not enabled.'
            ]); ?>
            <h4> ECOpuntuación <span id='puntos' class="badge"></span> </h4>

            <?php
            //Jquery Script que interactura con el DOM del proyecto: Modificando el color de la barra de progreso
            // y eliminando la entrada de introducción si el usuario ya dispone de feeds y sigue a otros usuarios.

            if (!isset($_COOKIE['intro'])) {
                Auxiliar::introNovatos();
            }

            ?>
            </button>
            <p> En función de su puntuación se le ha otorgado los siguientes retos:</p>
            <ul>
                <?php
                for ($i = 0; $i <  sizeof($retosListado); $i++) {
                    echo '<li> <a href="index.php?r=acciones-retos%2Fview&id=' . $retosListado[$i]->id . '"><h6">'  .  $retosListado[$i]->descripcion  .
                        '</h6><a/></li>';
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
            <p class="h5"><strong>TOP de mejores participantes #ecofriendly</strong> </p>


            <?php
            $sql = 'select * from ranking limit 3';
            $arrModels = Ranking::find()->limit(1)->all();
            $dataProvider = new ArrayDataProvider(['allModels' => $arrModels]);


            // $dataProvider->setSort([
            //     'defaultOrder' => ['puntuacion' => SORT_ASC],
            // ]);

            $dataProvider->pagination = ['pageSize' => 1];
            $options = ['style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];
            $dataProvider->pagination = ['pageSize' => 10];
            $options = ['style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']];


            echo Gridpropio::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify'],

                'columns' => [

                    'usuarios.nombre',
                    'puntuacion',
                ],

            ]);



            ?>

            <h5>Comparte contenido en otras redes:</h5>
            <?php echo TwitterPlugin::widget([]); ?>
            <?php echo FacebookPlugin::widget(['type' => FacebookPlugin::SHARE, 'settings' => ['size' => 'small', 'layout' => 'button_count', 'mobile_iframe' => 'false']]); ?>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </aside>
        <main class=" col-md-9 col-lg-6">
            <article>
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
            </article>
            <article class="tab-content" id="myTabContent">
                <section class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                <?= $form->field($model, 'imagen')->fileInput() ?>
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
                </section>
                <section class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php
                    $form = ActiveForm::begin([
                        'action' => ['feeds/imagen2'],
                        'method' => 'post',
                        'options' =>   ['enctype' => 'multipart/form-data'],
                    ]); ?>
                    <?= $form->field($model, 'imagen')->fileInput() ?>
                    <br>
                    <?= HelpersHtml::submitButton('Subir Imagen', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    <?php ActiveForm::end(); ?>
                </section>
                <br>
            </article>
            <hr>
            </hr>

            <?php foreach ($feeds as $feeds) :
            ?>
                <article>
                    <section class="card feed">


                        <div class="card-block">
                            <?php $options = ['class' => ['img-fluid rounded'], 'style' => ['width' => '100px', 'border-radius' => '30px']]; ?>
                            <h4 class="card-title"><?= Auxiliar::obtenerImagenusuario($feeds['url_avatar'], $options) ?> <?= ucfirst($feeds['nombre']) ?> </h4>
                            <p class="card-text"><?= Html::encode($feeds['contenido']) ?><?= $feeds['id'] == Yii::$app->user->identity->id ? '' . Html::a(' ' . Icon::show('edit'), Url::to(['/feeds/update', 'id' => $feeds['identificador']])) : '' ?>
                                <?= $feeds['id'] == Yii::$app->user->identity->id ? '' . Html::a(
                                    ' ' . Icon::show('trash-alt'),
                                    Url::to(['/feeds/delete', 'id' => $feeds['identificador']]),
                                    [

                                        'data' => [
                                            'confirm' => '¿Esta seguro de querer borrar este feed?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) : '' ?></p>

                            <p class="card-text"><small class="text-muted">Publicado: <?= Html::encode(Yii::$app->formatter->asRelativeTime($feeds['created_at']))  ?></small></p>
                        </div>

                        <?php $options = ['class' => ['img-contenedor'], 'style' => ['width' => '500px', 'margin' => '12px']]; ?>
                        <?= Auxiliar::obtenerImagenFeed($feeds['imagen'], $options) ?>
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
                                        <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                        <div class="col-2">
                                            <a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a>
                                        </div>
                                        <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                        <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                        <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                        <div class="col-2"><a href="#"><img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:50px;"></a></div>
                                    </div>

                                </div>
                                <br>
                                <div class="divider"></div>
                                <br>
                                <div class="media">
                                    <img class="d-flex mr-3" src="" alt="Generic placeholder image" style="width:50px;">
                                    <div class="media-body">
                                        <h5 class="mt-0">usuario</h5>
                                        Comentario de ejemplo <img src="" class="img-fluid rounded" alt="Responsive image rounded" style="width:30px;">

                                        <div class="media mt-3">
                                            <img src="" class="d-flex mr-3" alt="Responsive image rounded" style="width:50px;">
                                            <div class="media-body">
                                                <h5 class="mt-0">usuario 2</h5>
                                                Gracias
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <br>
                    <br>
                <?php
            endforeach; ?>
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </article>

        </main>
        <aside class="d-none d-lg-block col-lg-3 order-0 order-lg-1">
            <div class="card card-inverse">
                <div class="card-block">
                    <h4 class="card-title"> <span class="glyphicon glyphicon-plus "></span> Encuentra a más usuarios</h4>
                    <p class="card-text">Encuentra personas afines y comparte experiencias ecofriendly.</p>

                    <div class="col-12">

                        <?php $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '60px', 'height' => '60px', 'margin-right' => '2px', 'margin-left' => '2px'], 'href' => 'www.google.es'];

                        for ($i = 0; $i < sizeof($usuarios); $i++) {
                            echo '<ul class="list-group">'
                                . '<li class="list-group-item btn-light col-12" style="margin:4px">' . Auxiliar::obtenerImagenUsuario($usuarios[$i]->url_avatar, $optionsBarraUsuarios);
                            echo Html::button(ucfirst($usuarios[$i]->nombre), ['value' => Url::to('/index.php?r=usuarios%2Fview&id=' . $usuarios[$i]->id), 'class' => 'btn modalButton2 btn-lg active', 'id' => 'modalButton2']);
                            echo Html::hiddenInput('seguidor_id', $usuarios[$i]->id);
                            echo '</li> </ul>';
                        }

                        Modal::begin([
                            'title' => '<h3>Perfil de usuario</h3>',
                            'id' => 'modal2',
                            'size' => 'modal-md',
                        ]);
                        echo '<div id="modalContent2"></div>';

                        Modal::end();
                        ?>
                        <br>
                        <?= Html::beginForm(['/usuarios/buscar'], 'get')
                            . Html::textInput(
                                'cadena',
                                '',
                                ['placeholder' => 'Buscar #Ecofriendly', 'required' => 'true'],
                                ['class' => 'form-control']
                            )
                            . Html::submitButton(
                                'Buscar amigos',
                                ['class' => 'btn btn-success nav-link ']
                            )
                            . Html::endForm();




                        Modal::begin([
                            'title' => '<h3>Usuarios encontrados</h3>',
                            'id' => 'modal3',
                            'size' => 'modal-md',
                        ]);
                        echo '<div id="modalContent3"></div>';

                        Modal::end();
                        ?>

                    </div>
                    <div class="divider"></div>
                </div>
            </div>
            <br>
            <div class="card card-inverse">
                <div class="card-block">
                    <h4 class="card-title">Tu red de amigos:</h4>
                    <p class="card-text">
                        <div class="    col-12 ">
                            <?php
                            //muestra la red de amigos del usuario y permite mediante un boton dejar de seguir al usuario, ocultando los feeds del panel central, pues ya no es seguidor.
                            for ($i = 0; $i < sizeof($seguidores); $i++) {
                                echo   '<ul class="list-group">';
                                echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post')
                                    . '<li class="list-group-item col-12" style= "margin:4px">' . Auxiliar::obtenerImagenSeguidor($seguidores[$i]->seguidor_id, $optionsBarraUsuarios);
                                echo Html::hiddenInput('id', $seguidores[$i]->id);
                                echo Html::submitButton(
                                    '<span class="glyphicon glyphicon-minus"></span>',
                                    ['class' => 'btn btn-danger btn-sm ml-2'],
                                );
                                echo '</li></ul>' . Html::endForm();
                            }
                            ?>
                            <br>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam rem, eaque amet aperiam ex esse voluptatum fugiat doloribus laboriosam at delectus? Sapiente error hic fuga voluptate cupiditate omnis iure corrupti.

                            </p>
                        </div>
                    </p>
                    <a href="#" class="btn btn-primary">Invitar a más amigos</a>
                </div>
            </div>

        </aside>
    </div>
    </body>

    </html>