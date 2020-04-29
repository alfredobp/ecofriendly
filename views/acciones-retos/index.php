<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccionesRetosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acciones Retos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acciones-retos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Acciones Retos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="overflow-auto">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
          
            'id',
            'titulo',
            'descripcion',
            'cat_id',
            'puntaje',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
