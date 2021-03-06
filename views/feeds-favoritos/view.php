<?php

use app\helper_propio\Auxiliar;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FeedsFavoritos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notificaciones', 'url' => ['notificaciones/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="feeds-favoritos-view">

    <h1><?= Html::encode('Ver me gusta') ?></h1>

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'usuario.nombre',
     
            [

                'attribute' => 'feed.contenido',
                'label'=>'Hizo me gusta en:',
                'value' => function ($dataProvider) {
                    return $dataProvider->feed->contenido;
                },

            ],
            [

                'attribute' => 'created_at',
                'label'=>'¿Cuando le dio a me gusta?',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },

            ],
        ],
    ]) ?>
    <?= Auxiliar::volverAtras() ?>
</div>