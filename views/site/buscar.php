<?php

/* @var $this yii\web\View */

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
            <h3>Usuarios encontrados: <?=$usuarios->totalCount?></h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $usuarios,
                    'columns' => [
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
            <h3>Feeds encontrados: <?=$feed->totalCount?></h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $feed,
                    'columns' => [
                        'contenido',
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'feeds',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
        <?php if (($feed->totalCount === 0) && ($usuarios->totalCount === 0)) : ?>
            <h3>No se han encontrado resultados</h3>

        <?php endif ?>


    </div>
</div>