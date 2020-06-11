<?php

/* @var $this yii\web\View */

use moonland\tinymce\TinyMCE;
use app\helper_propio\Auxiliar;
use app\helper_propio\Consultas;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use app\helper_propio\GestionCookies as Helper_propioGestionCookies;
use app\helper_propio\Gridpropio;
use app\models\AccionesRetos;
use app\models\Comentarios;
use app\models\Ecoretos;
use app\models\Feeds;
use app\models\FeedsFavoritos;
use app\models\ObjetivosPersonales;
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
use yii\bootstrap4\Breadcrumbs;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\web\View as WebView;

Icon::map($this);
$this->title = 'Ecofriendly';
$this->params['breadcrumbs'][] = $this->title;




if (isset($_COOKIE['colorPanel']) || isset($_COOKIE['colorTexto']) || isset($_COOKIE['fuente']) || isset($_COOKIE['tamaño'])) {
    $this->registerJs(Helper_propioGestionCookies::cookiesEstilo());
}

$this->registerJs(Helper_propioGestionCookies::introduccion(), WebView::POS_READY);

if (!isset($_COOKIE['intro'])) {
    Auxiliar::introNovatos();
}

?>
<?php
$id = Yii::$app->user->identity->id;
$categoriaId = Yii::$app->user->identity->categoria_id;

?>
<div class="container-fluid">
    <div class="loader"></div>
    <div class="row ">
        <aside class="col-3 col-lg-3 order-1 order-lg-0 d-none d-md-block">


            <?php $options = ['class' => ['img-contenedor mx-auto d-block'], 'style' => ['width' => '128px', 'height' => '128px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>
            <div class=" col-3 col-md-2 sombra intro2">

                <?= Auxiliar::obtenerImagenUsuario($id, $options); ?>

                <hr>
                <h2> <?= ucfirst(Yii::$app->user->identity->nombre) ?> </h2>
                <br>
                <h5><?= Icon::show('comments') ?>: "<span id="estado"></span>"
                    <?php

                    echo Html::button(Icon::show('edit'), ['value' => Url::to('/index.php?r=usuarios%2Fupdateestado'), 'class' => 'btn modalButton3 btn-xs active col-1', 'id' => 'modalButton3']);
                    ?>
                </h5>
                <?php
                Auxiliar::ventanaModal('Modifique su estado', 3);
                ?>
                <?php

                echo GoogleAnalytics::widget([
                    'id' => 'TRACKING_ID',
                    'domain' => 'TRACKING_DOMAIN',
                    'noscript' => 'Analytics cannot be run on this browser since Javascript is not enabled.'
                ]); ?>
                <h4 class="intro2"> ECOpuntuación <span id='puntos' class="badge"></span> </h4>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <br>
            <div class="sombra">


                <h4 class="text-center">Tu progreso:</h4>
                <br>
                <h6>Has publicado: </strong> <?= Auxiliar::cuantosFeeds($id) ?> Feeds</h6>
                <br>
                <h6> Has superado: <?= Auxiliar::cuantosRetos($id) ?> Retos </h6>
                <br>
                <h6> Tu nivel: <span class="badge badge-info"> <?= Auxiliar::nivel($id)->cat_nombre ?> </span></h6>
                <br>
                <h6>Te faltan <strong> <?= Auxiliar::puntosRestantes($id, $categoriaId) ?></strong> puntos para el siguiente nivel</h6>
                <br>
                <h6>Has conseguido: <?= Auxiliar::puntosConseguidos($id) == null ? ' 0' : Auxiliar::puntosConseguidos($id) ?> puntos</h6>
            </div>
            <br>
            <br>

            <div class="sombra">
                <h4 class="text-center">Retos propuestos:</h4>
                <br>

                <p class="text-justify"> En función de su puntuación el sistema le propone los siguientes retos:</p>
                <div style="overflow-y: scroll; width:100%; height: 370px;">
                    <?php
                    echo Gridpropio::widget([
                        'dataProvider' => Auxiliar::dataProvider($categoriaId),
                        'options' => ['class' => 'table-hover hourglass-start  
                ', 'style' => 'padding:50px, text-align:justify', 'encode' => false],

                        'columns' => [
                            [
                                'attribute' => 'Reto',
                                'value' => function ($dataProvider) {

                                    return Html::button($dataProvider->titulo, ['value' => Url::to(['acciones-retos/view', 'id' => $dataProvider->id]), 'class' => 'col-12 btn modalButton4 btn-md active', 'id' => 'modalButton4']);
                                },
                                'format' => 'raw',

                            ],


                        ],

                    ]);

                    Auxiliar::ventanaModal('Sus retos', 4);

                    $dataProvider = new ActiveDataProvider([

                        'query' => RetosUsuarios::find()->joinWith('idreto0')->where(['usuario_id' => $id])

                    ]);

                    ?>
                </div>
            </div>
            <div class="sombra">
                <h4 class="text-center">Retos aceptados:</h4>
                <br>

                <?php
                $dataProvider->pagination = ['pageSize' => 5];

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'col-12'],
                    'columns' => [
                        [
                            'attribute' => 'Titulo',
                            'value' => function ($dataProvider) {
                                return  Html::button($dataProvider->idreto0['titulo'], [
                                    'value' => Url::to(['/retos-usuarios/view', 'idreto' =>
                                    $dataProvider->idreto0['id'], 'usuario_id' =>  Yii::$app->user->identity->id]),
                                    'class' => 'col-12 btn modalButton5 btn-md active', 'id' => 'modalButton5'
                                ]);
                            },
                            'format' => 'raw',

                        ],

                        [
                            'attribute' => 'Estado',

                            'value' => function ($dataProvider) {

                                return $dataProvider->culminado == true ? Icon::show('check') : Icon::show('clock');
                            },
                            'format' => 'raw',

                        ],

                    ],


                ]);
                Auxiliar::ventanaModal('Retos aceptados', 5);
                ?>
            </div>

            <div class="sombra">
                <h4 class="text-center">Objetivos Personales:</h4>
                <br>
                <div class="paper" style="overflow-y: scroll; width:100%; height: 150px;">

                    <?= Auxiliar::objetivosPersonales($id); ?>
                </div>
                <?= Html::button('Añadir Objetivo', ['value' => Url::to('/index.php?r=objetivos-personales%2Fcreate'), 'class' => ' btn btn-success modalButton6 mt-3 btn-xl', 'id' => 'modalButton6']); ?>
                <br>
                <?= Html::a(Icon::show('edit') . '<em>editar</em>', Url::to('/index.php?r=objetivos-personales%2Findex')); ?>

                <?php Auxiliar::ventanaModal('Sus Objetivos', 6); ?>
            </div>
            <br>
            <div class="sombra">

                <h5 class="text-center">Comparte contenido en otras redes:</h5>
                <br>
                <?php echo TwitterPlugin::widget([]); ?>
                <?php echo FacebookPlugin::widget(['type' => FacebookPlugin::SHARE, 'settings' => ['size' => 'small', 'layout' => 'button_count', 'mobile_iframe' => 'false']]); ?>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
            <br>
        </aside>
        <main class=" col-md-9 col-lg-6">
            <article>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> Compartir contenido

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
                        <a class="nav-link d-none d-sm-block" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                            Compartir contenido E.avanzado <?= Icon::show('desktop') ?>

                        </a>
                    </li>

                </ul>
            </article>
            <article class="tab-content" id="myTabContent">

                <section class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="home-tab">
                    <?php
                    $form = ActiveForm::begin([
                        'action' => ['feeds/create'],
                        'method' => 'post',
                        'enableAjaxValidation' => true,
                        'options' =>   [
                            'enableClientValidation' => true,
                            'enableAjaxValidation' => true,
                            'validateOnSubmit' => true,
                            'validateOnChange' => true,
                            'validateOnType' => false,
                            'errorCssClass' => 'has-error',
                            'successCssClass' => 'has-success',
                            'afterValidate' => 'js:function(form, data, hasError){}'
                        ]
                    ]);

                    ?>
                    <?= $form->field($model, 'contenido')->label(false)->widget(TinyMCE::className(), [
                        'toogle' => [
                            'active' => true,
                            'show' => true,
                            'toggle' => ['label' => 'Editor Avanzado', 'options' => ['class' => 'btn btn-default']],
                            'unToggle' => ['label' => 'Editor Simple', 'options' => ['class' => 'btn btn-default']],
                            'tinyStart' => false,
                        ]
                    ]); ?>
                    <?= $form->field($model, 'imagen')->label('Subir Imagen a Ecofrienly')->fileInput() ?>
                    <?= HelpersHtml::submitButton('Publicar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    <?php ActiveForm::end(); ?>
                </section>
                <section class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                        <div class="card-header">
                            <b>Comparte lo que quieras</b>
                        </div>
                        <div class="card-block">
                            <div class="tab-pane active ml-3 mt-3 mr-1" id="home" role="tabpanel">

                                <?php
                                $form = ActiveForm::begin([
                                    'action' => ['feeds/create'],
                                    'method' => 'post',
                                    'options' =>   [
                                        'enctype' => 'multipart/form-data',
                                        'enableClientValidation' => true,
                                        'enableAjaxValidation' => false,
                                        'validateOnSubmit' => true,
                                        'validateOnChange' => false,
                                        'validateOnType' => false,
                                        'errorCssClass' => 'has-error',
                                        'successCssClass' => 'has-success',
                                        'afterValidate' => 'js:function(form, data, hasError){}'
                                    ]
                                ]);
                                ?>
                                <?= $form->field($model, 'contenido')->label(false)->textarea(['rows' => '4']) ?>
                                <?= $form->field($model, 'imagen')->label('Subir Imagen a Ecofrienly')->fileInput() ?>
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
                <br>
            </article>
            <hr>
            </hr>
            <?php $i = 0 ?>
            <?php foreach ($feeds as $feeds) :
            ?>
                <article>
                    <section class="card feed">


                        <div class="card-block">

                            <div class="row mt-3">
                                <div class="col-2 ">
                                    <?php $options = ['class' => ['img-fluid rounded'], 'style' => ['width' => '100px', 'border-radius' => '30px']]; ?>

                                    <h4 class="card-title"><?= Auxiliar::obtenerImagenSeguidor($feeds['usuariosid'], $options) ?> </h4>
                                </div>
                                <div class="col-8">
                                    <h3> <?= ucfirst($feeds['nombre']) ?> </h3>
                                    <h5 id="estadoFeed"><?= Icon::show('comment-dots') .  ($feeds['estado']) ?> </h5>

                                </div>
                            </div>
                            <hr>
                            <div class="col-12">

                                <?php $options = ['class' => ['img-contenedor img-fluid max-width: 100% height: auto mx-auto d-block'], 'style' => ['margin' => '12px']]; ?>

                                <p class="card-text"><?= $feeds['contenido'] ?><?= $feeds['usuariosid'] == Yii::$app->user->identity->id ? '' . Html::a(' ' . Icon::show('edit'), Url::to(['/feeds/update',  'id' => $feeds['id']]), ['data-method' => 'POST', 'data-params' => [
                                                                                    'id' => $feeds['id']

                                                                                ]]) : '' ?>
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
                            <div class="row">
                                <!-- Gestión de los me gusta -->
                                <?php

                                $meGusta = Consultas::numeroMeGustan($feeds['id']) ?>

                                <div class="col">

                                    <?= Auxiliar::yaMeGusta($feeds['id'], $id) == null ?  Html::a(
                                        $meGusta->count() == 0 ? Icon::show(' fa-thumbs-up') . 'Me gusta' . '<a class="text-primary" data-toggle="collapse" href="#collapseExampleMe' .  $i . '"> </a>' : Icon::show(' fa-thumbs-up') . 'Me gusta' . '<a class="text-primary" data-toggle="collapse" href="#collapseExampleMe' .  $i . '"> ' . $meGusta->count()  . '</a>',
                                        Url::to(['/feeds-favoritos/create']),
                                        [
                                            'data' => [
                                                'method' => 'post',
                                                'params' => ['feed_id' => $feeds['id']], // <- extra level
                                            ],
                                        ]
                                    ) : Html::a(Icon::show(' fa-thumbs-down') . 'ya no me gusta' . '<a class="text-primary" data-toggle="collapse" href="#collapseExampleMe' .  $i . '"> ' . $meGusta->count()  . '</a>', Url::to(['/feeds-favoritos/delete', 'id' => $feeds['id']]), [

                                        'data' => [
                                            'method' => 'post',
                                            'params' => ['id' => $feeds['id']], // <- extra level
                                        ],
                                    ])
                                    ?>


                                </div>


                                <!-- Me gusta -->


                                <div class="collapse" id="collapseExampleMe<?= $i ?>">

                                    <div class="divider"></div>
                                    <div class="row">
                                        <div class="col-12" style="overflow-y: scroll; max-height: 150px;">

                                            <?php $meGusta = FeedsFavoritos::find()->where(['feed_id' => $feeds['id']])->orderBy('created_at DESC')->all() ?>
                                            <?php foreach ($meGusta as $meGusta) : ?>
                                                <?= Auxiliar::obtenerImagenSeguidor($meGusta['usuario_id'], $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '35px']])
                                                    . Usuarios::find()->where(['id' => $meGusta['usuario_id']])->one()->nombre  . '<br>' ?>
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

                                <!-- Gestión de los comentarios -->
                                <div class="col">

                                    <a style="text-decoration:none;" class="text-primary" data-toggle="collapse" href="#collapseExample<?= $i ?>" aria-expanded="false" aria-controls="collapseExample"><i class="bi bi-chat-dots-fill" aria-hidden="true"></i> <?= Icon::show('comment-dots') ?>Comentarios <small class="text-muted"><?= Consultas::comentarios($feeds['id'])->count() > 0 ? Consultas::comentarios($feeds['id'])->count() : '' ?></small></a>

                                </div>

                            </div>
                            <div class="collapse" id="collapseExample<?= $i ?>">
                                <br>

                                <div class="divider"></div>
                                <br>
                                <div class="row">
                                    <div class="col-2">
                                        <!-- FOTO DEL USUARIO QUE ESCRIBE -->
                                        <?php $options = ['class' => ['img-fluid rounded'], 'style' => ['width' => '40px', 'border-radius' => '0px']]; ?>
                                        <?= Auxiliar::obtenerImagenSeguidor($id, $options) ?>

                                    </div>
                                    <div class="col-10">

                                        <?php
                                        // $model = Feeds::find()->one();
                                        $form = ActiveForm::begin([
                                            'action' => ['comentarios/create'],
                                            'method' => 'post',
                                            'options' =>   ['enctype' => 'multipart/form-data'],
                                        ]); ?>

                                        <?= $form->field($comentarios2, 'contenido')->textarea(['rows' => 2])->label('Escribe tu comentario') ?>
                                        <?= $form->field($comentarios2, 'comentarios_id')->hiddenInput(['value' => $feeds['id']])->label(false) ?>

                                        <?= Html::submitButton('Comentar', ['class' => 'btn btn-outline-primary btn-sm float-right', 'name' => 'contact-button']) ?>
                                        <br>
                                        <?php ActiveForm::end(); ?>


                                        <!-- <a class="text-left" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-smile-o fa-2x" aria-hidden="true"></i></a> -->
                                        <div class="col-12" style="overflow-y: scroll; max-height: 600px;">
                                            <?php foreach (Consultas::muestraComentarios($feeds['id']) as $comentarios) : ?>


                                                <div class="col-10 border-bottom">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <?= Auxiliar::obtenerImagenSeguidor($comentarios['usuario_id'], $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '35px', 'margin-right' => '12px']]) ?>

                                                        </div>
                                                        <div class="col-10">
                                                            <p><?= $comentarios['contenido'] ?>
                                                                <br>
                                                                Publicado por: <?= Usuarios::find()->where(['id' => $comentarios['usuario_id']])->one()->nombre ?> <?= Html::encode(Yii::$app->formatter->asRelativeTime($comentarios['created_at'])) ?></p>
                                                            <?= $feeds['usuariosid'] === Yii::$app->user->identity->id ? Html::a(
                                                                Icon::show('trash-alt') . 'Borrar Comentario',
                                                                Url::to(['/comentarios/delete', 'id' => $comentarios['id']]),
                                                                [
                                                                    'data' => [
                                                                        'confirm' => '¿Esta seguro de querer borrar este Comentario?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]
                                                            ) : '' ?>
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
        <aside class=" col-3 d-none d-lg-block col-lg-3 order-0 order-lg-1">
            <div class="col-12 sombra">
                <p class="h5 text-success text-center"><strong>TOP participantes #ecofriendly</strong> </p>
                <?= Consultas::muestraRanking(); ?>
            </div>
            <br>
            <div class="col-12 sombra">
                <div class="col">
                    <h5 class="card-title h5  text-center"> <span class="glyphicon glyphicon-plus "></span> <strong> Encuentra a más usuarios </strong></h5>
                    <p class="card-text">Encuentra personas afines y comparte experiencias ecofriendly.</p>
                    <div class="" style="overflow-x:hidden; overflow-y: scroll; width:100%; height: 300px;">

                        <?php $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '60px', 'height' => '60px', 'margin-right' => '2px', 'margin-left' => '2px'], 'href' => 'www.google.es'];
                        for ($i = 0; $i < sizeof($usuarios); $i++) {
                            echo '<ul class="list-group">'
                                . '<li class="list-group-item btn-light col-12" style="margin:4px">' . Auxiliar::obtenerImagenSeguidor($usuarios[$i]->id, $optionsBarraUsuarios);
                            echo Html::button(ucfirst($usuarios[$i]->nombre), ['value' => Url::to('/index.php?r=usuarios%2Fview&id=' . $usuarios[$i]->id), 'class' => 'btn modalButton2 btn-lg active', 'id' => 'modalButton2']);
                            echo Html::hiddenInput('seguidor_id', $usuarios[$i]->id);
                            echo '</li> </ul>';
                        }
                        Auxiliar::ventanaModal('Perfil de usuario', 2, 'lg');
                        ?>
                    </div>
                    <br>
                    <div>

                        <?= Html::beginForm(['/usuarios/buscar'], 'get')
                            . Html::textInput(
                                'cadena',
                                '',
                                ['placeholder' => 'Buscar #AmigoEcofriendly', 'required' => 'true', 'class' => 'col-12 form-control']
                            )
                            . '<br>'
                            . Html::submitButton(
                                'Buscar amigos',
                                ['class' => 'btn btn-success nav-link mt-3 ']
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
                </div>
                <div class="divider"></div>

            </div>
            <br>

            <div class="col-12 sombraBis">

                <h4 class="card-title h5  text-center "> <strong> Tu red de amigos: </strong></h4>
                <p class="col-12">
                    <div style="overflow-x:hidden; overflow-y:scroll; width:90%; height: 270px;">
                        <?php

                        //muestra la red de amigos del usuario y permite mediante un boton dejar de seguir al usuario, ocultando los feeds del panel central, pues ya no es seguidor.
                        if (sizeof($seguidores) == 0) {
                            echo 'Actualmente no sigue a ningun usuario de la red <strong>#Ecofriendly</strong> ';
                        } else {


                            for ($i = 0; $i < sizeof($seguidores); $i++) {
                                echo   '<ul class="list-group">';
                                echo Html::beginForm(['seguidores/delete', 'id' => $seguidores[$i]->id], 'post')
                                    . '<li class="list-group-item col-12" style= "margin:4px">' . Auxiliar::obtenerImagenSeguidor($seguidores[$i]->seguidor_id, $optionsBarraUsuarios);
                                echo Html::button(Html::encode(ucfirst(Usuarios::find()->select('nombre')->where(['id' => $seguidores[$i]->seguidor_id])->one()->nombre)), ['value' => Url::to(['/usuarios/view', 'id' => $seguidores[$i]->seguidor_id]), 'class' => 'btn modalButton2 btn-lg active', 'id' => 'modalButton2']);

                                // . Html::submitButton(
                                //     '<span class="glyphicon glyphicon-minus"></span>',
                                //     ['class' => 'btn btn-danger btn-sm ml-0'],
                                // );
                                echo Html::hiddenInput('id', $seguidores[$i]->id);
                                echo '</li></ul>' . Html::endForm();
                            }
                        }
                        ?>
                        <br>
                    </div>
                    <div class="divider"></div>
                </p>
                <button class="irArriba"> <?= Icon::show('level-up-alt') ?><em>Ir arriba</em></button>
            </div>
    </div>
    </aside>
</div>