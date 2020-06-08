<?php

/* @var $this yii\web\View */

use app\helper_propio\Auxiliar;
use kartik\icons\Icon;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Resultados de la búsqueda: ' . $_GET['cadena'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <?php if ($usuarios->totalCount > 0) : ?>
            <h3>Usuarios encontrados: <?= $usuarios->totalCount ?></h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $usuarios,
                    'columns' => [
                        'nombre',
                        'localidad',
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'usuarios',
                            'template' => '{viewnoajax}',
                            'buttons' => [
                                'viewnoajax' => function ($url, $model, $key) {
                                    return Html::a(
                                        Icon::show('fa fa-binoculars') . 'Ver usuario',
                                        (new yii\grid\ActionColumn())->createUrl('usuarios/viewnoajax', $model, ['id' => $model['id']], 1),
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

        <?php if ($usuarios->totalCount === 0) : ?>
            <h3>No se han encontrado resultados</h3>

        <?php endif ?>


    </div>
    <?php echo Auxiliar::volverAtras() ?>
</div>