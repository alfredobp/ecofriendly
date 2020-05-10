<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedsFavoritosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feeds Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feeds-favoritos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Feeds Favoritos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'feed_id',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
