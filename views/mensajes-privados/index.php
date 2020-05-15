<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MensajesPrivadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes Privados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-privados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mensajes Privados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'emisor.nombre',
            'receptor.nombre',
            // 'emisor_id',
            // 'receptor_id',
            'asunto',
            'contenido',
            //'seen:boolean',
            'created_at',
            //'visto_dat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
