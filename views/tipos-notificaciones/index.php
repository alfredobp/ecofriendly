<?php

use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TiposNotificacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-notificaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear nuevo tipo de Notificación', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'col-10 shadow-lg p-3 mb-5 bg-white rounded'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'tipo',

            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{update}{delete}',

            ],
        ],
    ]); ?>


</div>