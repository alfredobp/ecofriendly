<?php

use app\helper_propio\Auxiliar;
use app\models\Usuarios;
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

    <p>
        <?= Html::a('Create Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            // 'contrasena',

            [
                // 'header' => 'Fecha de <br> Actualización',
                'attribute' => 'Validación e-mail',

                'value' => function ($dataProvider) {
                    return ($dataProvider->auth_key == null) ? 'Cuenta validada ' : 'Sin validar';
                },
            ],

            'nombre',

            'apellidos',
            'email:email',
            [
                'attribute' => 'imagen',
                'value' => function ($dataProvider) {
                    return Auxiliar::obtenerImagenUsuario($dataProvider->url_avatar);
                },
                'format' => 'raw',
            ],
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
            'ecoRetos.categoria_id',




            //'token_acti',
            //'codigo_verificacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>