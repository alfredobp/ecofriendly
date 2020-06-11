<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjetivosPersonalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objetivos Personales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objetivos-personales-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'usuario_id',
            'objetivo',
            [

                'attribute' => 'created_at',
                'label'=>'Creado:',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>