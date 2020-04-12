<?php

use Symfony\Component\VarDumper\VarDumper;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EcoRetosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eco Retos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eco-retos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Eco Retos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           
            'nombrereto',
            'categoria_id',
            // 'categoriasEcoretos.id',
            'usuarios.nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
