<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cuentas de usuarios suspendidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Bloquear cuenta usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options'=>[
            'class'=>'shadow-lg p-3 mb-5 bg-white rounded',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'usuario.nombre',
            // 'usuario_id',
            'motivo',
            [
                'attribute' => 'Fecha Suspensión de la cuenta',
                'contentOptions'=>['style'=>'text-align:center; width:290px; '],

                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->fecha_suspenso);
                },
                'format' => 'raw',
            ],
  
            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{update}{delete}',

            ],
        ],
    ]); ?>


</div>
