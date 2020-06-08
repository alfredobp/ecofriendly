<?php

use app\helper_propio\Auxiliar;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Feeds */

$this->title = $model->contenido;
// $this->params['breadcrumbs'][] = ['label' => 'Feeds', 'url' => ['index']];
// $this->params['breadcrumbs'][] ='';
\yii\web\YiiAsset::register($this);
?>
<div class="feeds-view">

    <h1><?= 'Feed: ' . Yii::$app->formatter->asHtml($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro de borrar este feed?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'usuariosid',
            [
                'attribute' => 'contenido',
                'value' => function ($dataProvider) {
                    $options = ['class' => 'mx-auto d-block', 'style' => ['margin' => 0, 'width' => '40%', 'margin-right' => '12px', 'margin-left' => '12px']];

                    return Html::a($dataProvider->contenido);
                },
                'format' => 'raw',
            ],
            [
                // 'header' => 'Fecha de <br> Actualización',
                'attribute' => 'created_at',

                'value' => function ($dataProvider) {
                    return (Yii::$app->formatter->asRelativeTime($dataProvider->created_at));
                },
            ],
            [
                // 'header' => 'Fecha de <br> Actualización',
                'attribute' => 'updated_at',

                'value' => function ($dataProvider) {
                    return ($dataProvider->updated_at == null) ? '---- ' : Yii::$app->formatter->asRelativeTime($dataProvider->updated_at);
                },
            ],
            [
                'attribute' => 'imagen',
                'value' => function ($dataProvider) {
                    $options = ['class' => 'mx-auto d-block', 'style' => ['margin' => 0, 'width' => '40%', 'margin-right' => '12px', 'margin-left' => '12px']];

                    return Html::a(Auxiliar::obtenerImagenFeed($dataProvider->imagen, $options));
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>
    <!-- <?php $options = ['class' => ['img-contenedor d-none d-sm-block'], 'style' => ['margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']]; ?>

    <?= Auxiliar::obtenerImagenFeed($model->imagen, $options) ?>
    <?= Html::img(Yii::getAlias('@uploads') . '/' . $model->imagen) ?> -->

    <?=Auxiliar::volverAtras()?>
</div>