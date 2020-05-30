<?php

/* @var $this yii\web\View */

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Resultados de la búsqueda: ' . $_GET['cadena'];
$this->params['breadcrumbs'][] = $this->title;
Icon::map($this);
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <?php if ($usuarios->totalCount > 0) : ?>
            <h3>Usuarios encontrados: <?= $usuarios->totalCount ?></h3>
            <div class="col-10 shadow-lg p-3 mb-5 bg-white rounded">
                <?= GridView::widget([
                    'dataProvider' => $usuarios,
                    'columns' => [
                        'username',
                        'nombre',

                        [
                            'class' => ActionColumn::class,
                            'controller' => 'usuarios',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
        <?php if ($feed->totalCount > 0) : ?>
            <?= !Auxiliar::esAdministrador() ? '<h3>Feeds compartidos por los usuarios a los que sigues:' . $feed->totalCount .  '</h3>' : '<h3> Feeds encontrados de la red #ecofriendly: ' . $feed->totalCount . '</h3>'  ?>
            <div class="col-10 shadow-lg p-3 mb-5 bg-white rounded">
                <?= GridView::widget([
                    'dataProvider' => $feed,
                    'columns' => [

                        [
                            'attribute' => 'contenido',
                            'label' => 'Contenido',
                            'value' => function ($dataProvider) {
                                return Html::a($dataProvider->contenido);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function ($dataProvider) {
                                return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Compartido por:',
                            'value' => function ($dataProvider) {
                                return $dataProvider->usuarios->nombre;
                            },
                            'format' => 'raw',
                        ],

                        [
                            'class' => ActionColumn::class,
                            'controller' => 'feeds',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
        <?php if ($retos->totalCount > 0) : ?>
            <h3>Retos encontrados: <?= $retos->totalCount ?></h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $retos,
                    'columns' => [
                        'titulo',

                        [
                            'class' => ActionColumn::class,
                            'controller' => 'acciones-retos',
                            'template' => '{verreto}',
                            'buttons' => [

                                'verreto' => function ($url, $model) {
                                    return \yii\helpers\Html::a(
                                        icon::show('fa fa-binoculars'),
                                        (new yii\grid\ActionColumn())->createUrl('acciones-retos/verreto', $model, $model['id'], 1),
                                        [
                                            'title' => Yii::t('yii', 'verreto'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]
                                    );
                                },
                            ]
                        ],
                    ],
                ]) ?>
            </div>

        <?php endif ?>

        <?php if ($hastag->totalCount > 0) : ?>
            <h3>#Hastag encontrados: <?= $hastag->totalCount ?></h3>
            <div class="col-10 shadow-lg p-3 mb-5 bg-white rounded">

                <?= GridView::widget([
                    'dataProvider' => $hastag,
                    'columns' => [

                        [
                            'attribute' => 'contenido',
                            'label' => 'Contenido',
                            'value' => function ($dataProvider) {
                                return Html::a($dataProvider->contenido);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'Compartido por:',
                            'value' => function ($dataProvider) {
                                return $dataProvider->usuarios->nombre;
                            },
                            'format' => 'raw',
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'controller' => 'feeds',
                            'template' => '{verhastag}',
                            'buttons' => [
                                'verhastag' => function ($url, $model, $key) {
                                    return Html::a(
                                        icon::show('fa fa-binoculars') . 'Ver #Hastag',
                                        (new yii\grid\ActionColumn())->createUrl('feeds/verhastag', $model, ['id' => $model['id'], 'cadena' => 'hola'], 1),
                                        [
                                            'class' => 'btn btn-sm btn-light',

                                        ]
                                    );
                                }
                            ],
                        ],
                    ],

                ]) ?>
            </div>
        <?php endif ?>
        <?php if (($feed->totalCount === 0) && ($usuarios->totalCount === 0) && ($retos->totalCount === 0) && ($hastag->totalCount === 0)) : ?>
            <h3>No se han encontrado resultados</h3>

        <?php endif ?>

        <?php echo Auxiliar::volverAtras() ?>
    </div>
</div>