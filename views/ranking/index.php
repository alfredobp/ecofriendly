<?php

use app\helper_propio\Auxiliar;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RankingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ranking de usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ranking-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>En este apartado se contemplan el ranking de todos los usuarios registrados en la red #ecofriendly</p>
    <br>
    <!-- <p>
        <?= Html::a('Create Ranking', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 


    $dataProvider->setSort([
        'defaultOrder' => ['puntuacion' => SORT_DESC],
    ]);
    ?>
    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'usuarios.nombre',
            [
                'attribute' => 'imagen',
                'value' => function ($dataProvider) {
                    return Auxiliar::obtenerImagenSeguidor($dataProvider->usuariosid, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '65px', 'height' => '65px', 'margin-auto' => '0px']]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Última Conexión',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->usuarios->ultima_conexion);
                },
                'format' => 'raw',
            ],

            'puntuacion',


            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    <?= Auxiliar::volverAtras() ?>
</div>