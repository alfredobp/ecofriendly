<?php

use app\helper_propio\Auxiliar;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feeds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feeds-index">

    <h1>Listados de <?= Html::encode($this->title) ?> publicados en la red #Ecofriendly</h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="overflow-auto">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                'usuarios.nombre',

                [
                    'label' => 'Contenido',
                    'attribute' => 'contenido',
                    'contentOptions'=>['style'=>'text-align:center; width:0px; '],
                    'value' => function ($dataProvider) {
                        return  $dataProvider->contenido;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Ruta Imagen',
                    'contentOptions'=>['style'=>'text-align:center; width:190px; '],
                    'attribute' => 'imagen',
                    'value' => function ($dataProvider) {
                        $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '100px', 'height' => '100px']];
                        return $dataProvider->imagen == null ? '------------' : Auxiliar::ObtenerImagenFeed($dataProvider->imagen, $optionsBarraUsuarios);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Fecha publicación',
                    'value' => function ($dataProvider) {
                        return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                    },
                    'format' => 'raw',
                ],
                [

                    'attribute' => 'Fecha actualización',
                    'value' => function ($dataProvider) {

                        return $dataProvider->updated_at == null ? 'No modificado' :  Yii::$app->formatter->asRelativeTime($dataProvider->updated_at);
                    },
                    'format' => 'raw',
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
    <?= Auxiliar::volverAtras() ?>
</div>