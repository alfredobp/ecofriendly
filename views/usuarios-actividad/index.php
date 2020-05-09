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
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'usuario.nombre',
            // 'usuario_id',
            'motivo',
            [
                'attribute' => 'Fecha Suspensión de la cuenta',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->fecha_suspenso);
                },
                'format' => 'raw',
            ],
  
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
