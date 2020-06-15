<?php

use app\helper_propio\Auxiliar;
use app\models\Usuarios;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="shadow-lg p-3 mb-5 bg-white rounded overflow-auto">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [

                [
                    // 'header' => 'Fecha de <br> Actualización',
                    'headerOptions' => ['class' => 'col_fix'],
                    'attribute' => 'Validación e-mail',

                    'value' => function ($dataProvider) {
                        return ($dataProvider->auth_key == null) ? 'Cuenta validada ' : 'Sin validar';
                    },
                ],
                'id',
                'username',
                // 'contrasena',


                'nombre',

                'apellidos',
                'email:email',
                [
                    'attribute' => 'imagen',
                    'contentOptions' => ['style' => 'text-align:center; width:290px; '],

                    'value' => function ($dataProvider) {
                        $option =  ['class' => ['img-contenedor'], 'style' => ['width' => '75px', 'height' => '55px']];
                        return Auxiliar::obtenerImagenSeguidor($dataProvider->id, $option);
                    },
                    'format' => 'raw',
                ],
                'rol',
                'direccion',
                'localidad',
                'fecha_nac',
                'estado',
                [
                    'attribute' => 'Última Conexión',
                    'value' => function ($dataProvider) {
                        return Yii::$app->formatter->asRelativeTime($dataProvider->ultima_conexion);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Fecha de alta',
                    'value' => function ($dataProvider) {
                        return Yii::$app->formatter->asRelativeTime($dataProvider->fecha_alta);
                    },
                    'format' => 'raw',
                ],
                'descripcion',
                //'token_acti',
                //'codigo_verificacion',


                [
                    'class' => 'yii\grid\ActionColumn',

                    'template' => '{viewnoajax}{delete}',
                    'buttons' => [
                        'viewnoajax' => function ($url, $model, $key) {
                            return Html::a(
                                Icon::show('fa fa-binoculars'),
                                (new yii\grid\ActionColumn())->createUrl('usuarios/viewnoajaxadmin', $model, ['id' => $model['id']], 1),
                                [
                                    'class' => 'btn btn-sm btn-light',

                                ]
                            );
                        }
                    ],


                ],


            ],
        ]); ?>
    </div>
    <?= Auxiliar::volverAtras() ?>
</div>