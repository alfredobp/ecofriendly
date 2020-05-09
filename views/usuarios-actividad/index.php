<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios Actividads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuarios Actividad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usuario_id',
            'motivo',
            'fecha_suspenso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
