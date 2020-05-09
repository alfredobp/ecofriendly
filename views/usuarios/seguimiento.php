<?php

use app\helper_propio\Auxiliar;
use app\models\Feeds;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-seguimientos">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="overflow-auto">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,


            'columns' => [

                'username',
                // 'contrasena',
                'nombre',
                'apellidos',


                'ranking.puntuacion',

                // [
                //     'attribute' => 'Nº de retos aceptados',
                //     'value' => function ($dataProvider) {
                //         return $dataProvider['feeds'];
                //     },
                //     'format' => 'raw',
                // ],
                // [
                //     'attribute' => 'Nº de retos cumplidos',
                //     'value' => function ($dataProvider) {
                //         return $dataProvider['feeds'];
                //     },
                //     'format' => 'raw',
                // ],
                [
                    'attribute' => 'Feeds compartidos',
                    'value' => function ($dataProvider) {
                        $feeds = Feeds::find()->where(['usuariosid' => $dataProvider->id]);
                        // var_dump($feeds);
                        $cuantos = $feeds->count();

                        if ($cuantos != 0) {

                            return $cuantos;
                        } else {
                            return 'Todavía no ha publicado nada ';
                        }
                    },
                    'format' => 'raw',
                ],
                // [
                //     'attribute' => 'Nº de seguidores',
                //     'value' => function ($dataProvider) {
                //         return $dataProvider['feeds'];
                //     },
                //     'format' => 'raw',
                // ],
                [
                    'attribute' => 'Nº Seguimientos',
                    'value' => function ($dataProvider) {
                        $feeds = Seguidores::find()->where(['usuario_id' => $dataProvider->id]);
                        // var_dump($feeds);
                        $cuantos = $feeds->count();

                        if ($cuantos != 0) {

                            return $cuantos;
                        } else {
                            return 'No sigue a nadie ';
                        }
                    },
                    'format' => 'raw',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',

                    'template' => '{view}{delete}',

                    'buttons' => [

                        'view' => function ($url, $model) {

                            return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', $url, [

                                'title' => Yii::t('yii', 'Create'),

                            ]);
                        }

                    ]

                ],


            ],
        ]); ?>

    </div>
</div>