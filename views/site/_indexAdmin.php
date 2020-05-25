<?php

/* @var $this yii\web\View */

use moonland\tinymce\TinyMCE;
use app\helper_propio\Auxiliar;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use app\helper_propio\GestionCookies as Helper_propioGestionCookies;
use app\helper_propio\Gridpropio;

use app\models\Comentarios;

use app\models\Feeds;
use app\models\FeedsFavoritos;
use app\models\Ranking;
use app\models\RetosUsuarios;
use app\models\Usuarios;

use kartik\social\FacebookPlugin;
use kartik\social\TwitterPlugin;
use kartik\social\GoogleAnalytics;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

use yii\widgets\ActiveForm;
use yii\helpers\Html as HelpersHtml;

use kartik\icons\Icon;

use yii\data\ArrayDataProvider;

use yii\web\View as WebView;
use yii\widgets\ListView;

Icon::map($this);
$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/indexAdmin.css');



if (isset($_COOKIE['colorPanel']) || isset($_COOKIE['colorTexto']) || isset($_COOKIE['fuente']) || isset($_COOKIE['tamaño'])) {
    $this->registerJs(Helper_propioGestionCookies::cookiesEstilo());
}

$this->registerJs(Helper_propioGestionCookies::introduccion(), WebView::POS_READY);

?>


<div class="container-fluid">
    <div class="loader"></div>
    <div class="row ">
        <aside class="col-3 col-lg-3 order-1 order-lg-0 d-none d-md-block">

            <?php
            $id = Yii::$app->user->identity->id;
            $categoriaId = Yii::$app->user->identity->categoria_id;

            ?>
            <!-- <hr>
            <h2> <?= ucfirst(Yii::$app->user->identity->nombre) ?> </h2> -->

            <?php
            Auxiliar::ventanaModal('Modifique su estado', 3);
            ?>
            <?php

            echo GoogleAnalytics::widget([
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
                'noscript' => 'Analytics cannot be run on this browser since Javascript is not enabled.'
            ]); ?>

            <?php $puntuacionMedia = Ranking::find()->average('puntuacion'); ?>

            <div class="sombra">
                <h5 class="text-info text-center"><strong>Datos generales #ecofriendly</strong></h5>
                <div class="divider mb-3"></div>
                La puntuación media de los usuarios de #ecofriendly es de: <span class="badge badge-secondary"> <?= Yii::$app->formatter->asInteger($puntuacionMedia) ?> </span> puntos.
                <br>
                <br>
                <p>Se han publicado <strong> <?= $cuentaFeeds = Feeds::find()->count(); ?> </strong> Feeds</p>
                <br>
                <p>Se han realizado <?= Comentarios::find()->count() ?> comentarios</p>
                <br>
                <p>Los usuarios han superado: <?= RetosUsuarios::find()->count() ?> Retos #ecofriendly</p>
                <br>
                <?php $puntosTotales =  Ranking::find()->sum('puntuacion'); ?>

                <p> Se han conseguido: <?= $puntosTotales ?> puntos #ecofriendly </p>
                <p>Total usuarios registrados: <?= Usuarios::find()->count() - 1 ?></p>

            </div>
            <br>
            <br>
            <div class="sombra">

                <h5>Comparte contenido:</h5>
                <br>
                <?php echo TwitterPlugin::widget([]); ?>
                <?php echo FacebookPlugin::widget(['type' => FacebookPlugin::SHARE, 'settings' => ['size' => 'small', 'layout' => 'button_count', 'mobile_iframe' => 'false']]); ?>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
            <br>
        </aside>
        <main class=" col-md-9 col-lg-6">
            <h1 class="text-center shadow p-3 mb-3 bg-white rounded">Actividad en #ecofriendly </h1>
            <hr>
            </hr>
            <?php $i = 0 ?>
            <?php foreach ($feeds as $feeds) :
            ?>
                <article>
                    <section class="card feed">


                        <div class="card-block">
                            <?php $options = ['class' => ['img-fluid rounded'], 'style' => ['width' => '100px', 'border-radius' => '30px']]; ?>
                            <div class="row">
                                <div class="col-2 ">

                                    <h4 class="card-title"><?= Auxiliar::obtenerImagenusuario($feeds['usuariosid'], $options) ?> </h4>
                                </div>
                                <div class="col-8">
                                    <h3> <?= ucfirst($feeds['nombre']) ?> </h3>
                                    <h5 id="estadoFeed"><?= Icon::show('comment-dots') .  ($feeds['estado']) ?> </h5>

                                </div>
                            </div>
                            <hr>
                            <div class="col-12">

                                <?php $options = ['class' => ['img-contenedor img-fluid max-width: 100% height: auto mx-auto d-block'], 'style' => ['margin' => '12px']]; ?>
                                <p class="card-text"><?= $feeds['contenido'] ?><?= $feeds['usuariosid'] == Yii::$app->user->identity->id ? '' . Html::a(' ' . Icon::show('edit'), Url::to(['/feeds/update', 'id' => $feeds['id']])) : '' ?>
                                    <?= $feeds['usuario_id'] != Yii::$app->user->identity->id ? '' . Html::a(
                                        ' ' . Icon::show('trash-alt'),
                                        Url::to(['/feeds/delete', 'id' => $feeds['id']]),
                                        [

                                            'data' => [
                                                'confirm' => '¿Esta seguro de querer borrar este feed?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    ) : '' ?></p>
                                <?= Auxiliar::obtenerImagenFeed($feeds['imagen'], $options) ?>

                                <p class="card-text"><small class="text-muted">Publicado: <?= Html::encode(Yii::$app->formatter->asRelativeTime($feeds['created_at']))  ?></small></p>
                            </div>
                        </div>


                        <?php $options = ['class' => ['img-contenedor'], 'style' => ['width' => '500px', 'margin' => '12px']]; ?>
                        <div class="card-footer text-muted">
                            <div class="card-footer text-muted">
                                <div class="row">
                                    <!-- Gestión de los me gusta -->
                                    <?php

                                    $meGusta = FeedsFavoritos::find()->where(['feed_id' => $feeds['id']]);
                                    ?>

                                    <div class="col">



                                        <a class="text-primary" data-toggle="collapse" href="#collapseExampleMe<?= $i ?>"> nº de me gustas: <?= $meGusta->count() ?> </a>
                                        <!-- 
                                        <?= Html::a(
                                            Icon::show(' fa-thumbs-up') . 'Me gusta' . '<a class="text-primary" data-toggle="collapse" href="#collapseExampleMe' .  $i . '"> ' . $meGusta->count()  . '</a>',
                                            Url::to(['/feeds-favoritos/create'])
                                        ); ?> -->


                                    </div>


                                    <!-- Me gusta -->


                                    <div class="collapse" id="collapseExampleMe<?= $i ?>">

                                        <div class="divider"></div>
                                        <div class="row">
                                            <div class="col-12">

                                                <?php $meGusta = FeedsFavoritos::find()->where(['feed_id' => $feeds['id']])->orderBy('created_at DESC')->all() ?>
                                                <?php foreach ($meGusta as $meGusta) : ?>
                                                    <?= Auxiliar::obtenerImagenSeguidor($meGusta['usuario_id'], $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '35px']])
                                                        . Usuarios::find()->where(['id' => $meGusta['usuario_id']])->one()->nombre  . '<br> <br>' ?>
                                                    <br>
                                                    <div class="divider"></div>
                                                <?php
                                                endforeach; ?>
                                            </div>
                                            <br>
                                            <div class="divider"></div>
                                        </div>
                                    </div>


                                    <!-- Fin Me Gusta -->


                                    <?php $comentar = $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds['id']]);

                                    ?>

                                    <!-- Gestión de los comentarios -->
                                    <div class="col"><a style="text-decoration:none;" class="text-primary" data-toggle="collapse" href="#collapseExample<?= $i ?>" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-chat-dots-fill" aria-hidden="true"></i> <?= Icon::show('comment-dots') ?>Comentarios <small class="text-muted"><?= $comentar->count() > 0 ? $comentar->count() : '' ?></small></a>
                                    </div>

                                </div>
                                <div class="collapse" id="collapseExample<?= $i ?>">
                                    <br>

                                    <div class="divider"></div>
                                    <br>
                                    <div class="row">
                                        <div class="col-2">
                                            <!-- FOTO DEL USUARIO QUE ESCRIBE -->

                                        </div>
                                        <div class="col-10">


                                            <!-- <a class="text-left" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a> -->
                                            <?php $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds['id']])->orderBy('created_at DESC')->all() ?>

                                            <?php foreach ($comentarios as $comentarios) : ?>


                                                <div class="col-10 border-bottom">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <?= Auxiliar::obtenerImagenSeguidor($comentarios['usuario_id'], $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '35px', 'margin-right' => '12px']]) ?>

                                                        </div>
                                                        <div class="col-10">
                                                            <p><?= $comentarios['contenido'] ?>
                                                                <br>
                                                                Publicado por: <?= Usuarios::find()->where(['id' => $comentarios['usuario_id']])->one()->nombre ?> <?= Html::encode(Yii::$app->formatter->asRelativeTime($comentarios['created_at'])) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endforeach; ?>
                                        </div>

                                        <br>
                                        <div class="divider"></div>

                                        <br>

                                    </div>
                                </div>
                    </section>
                    <br>
                    <br>
                    <?php $i++ ?>
                <?php
            endforeach; ?>
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </article>

        </main>
        <aside class="d-none d-lg-block col-lg-3 order-0 order-lg-1">


            <div class="sombra">

                <p class="h5 text-success text-center"><strong>TOP mejores #ecofriendly</strong> </p>


                <?php

                $arrModels = Ranking::find()->joinWith('usuarios')->where(['!=', 'rol', 'superadministrador'])->limit(10)->all();
                $dataProvider = new ArrayDataProvider(['allModels' => $arrModels,  'sort' => [
                    'attributes' => ['puntuacion'],
                ],]);

                echo Gridpropio::widget([
                    'dataProvider' => $dataProvider,
                    'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify', 'encode' => false],

                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'usuarios.nombre',

                        [
                            'attribute' => 'puntuacion',
                            'value' => function ($dataProvider) {

                                return $dataProvider->puntuacion .  ' ' . Icon::show('trophy');
                            },
                            'format' => 'raw',

                        ],
                    ],

                ]);



                ?>
                <br>
            </div>
            <div class="card card-inverse">
                <div class="card-block sombraBis">
                    <h5 class="card-title"> Usuarios Registrados</h5>


                    <div class="col-12" style="overflow-y: scroll; height: 350px;">

                        <?php $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '60px', 'height' => '60px']];
                        $usuarios = Usuarios::find()->where(['!=', 'rol', 'superadministrador'])->all();
                        for ($i = 0; $i < sizeof($usuarios); $i++) {
                            echo '<ul class="list-group">'
                                . '<li class="list-group-item btn-light col-12" style="margin:1px">' . Auxiliar::obtenerImagenUsuario($usuarios[$i]->id, $optionsBarraUsuarios);
                            echo Html::button(ucfirst($usuarios[$i]->nombre), ['value' => Url::to('/index.php?r=usuarios%2Fview&id=' . $usuarios[$i]->id), 'class' => 'btn modalButton2 btn-xl active', 'id' => 'modalButton2']);
                            echo Html::hiddenInput('seguidor_id', $usuarios[$i]->id);
                            echo '</li> </ul>';
                        }
                        Auxiliar::ventanaModal('Perfil de usuario', 2);


                        ?>
                    </div>
                    <br>
                    <?= Html::beginForm(['/usuarios/buscar'], 'get')
                        . Html::textInput(
                            'cadena',
                            '',
                            ['placeholder' => 'Buscar #AmigoEcofriendly', 'required' => 'true'],
                            ['class' => 'form-control col-10']
                        )
                        . '<br>'
                        . Html::submitButton(
                            'Buscar amigos',
                            ['class' => 'btn btn-success nav-link mt-3 col-10 ']
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

                    <br>
                </div>
                <div class="divider"></div>
            </div>
    </div>
    <br>
    <div class="card card-inverse">
        <div class="card-block">


        </div>
    </div>


    </aside>
</div>
</body>

</html>