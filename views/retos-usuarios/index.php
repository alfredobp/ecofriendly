<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RetosUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Retos Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retos-usuarios-index">

    <h1><?= Html::encode('Retos aceptados por el usuario') ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
 
        'columns' => [
   
            'idreto0.titulo',
            [
                // 'header' => 'Fecha de <br> Actualización',
                'attribute' => 'created_at',
                'label'=>'Fecha Aceptación',

                'value' => function ($dataProvider) {
                    return  Yii::$app->formatter->asRelativeTime($dataProvider->fecha_aceptacion);
                },
            ],

            'culminado:boolean',

   
        ],
    ]); ?>


</div>
