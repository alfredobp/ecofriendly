<?php

use app\helper_propio\Auxiliar;
use app\models\Feeds;
use app\models\RetosUsuarios;
use app\models\Seguidores;
use app\models\Usuarios;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seguimientos de Usuarios De #ecofriendly';
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
                [
                    'attribute' => 'Nombre completo',
                    'value' => function ($dataProvider) {

                        return $dataProvider->nombre . ' ' . $dataProvider->apellidos;
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Nivel',
                    'value' => function ($dataProvider) {

                        if ($dataProvider->categoria['cat_nombre'] == 'Principiante') {
                            return '<span class="badge badge-danger"> Principiante</span>';
                        } elseif ($dataProvider->categoria['cat_nombre'] == 'Intermedio') {
                            return '<span class="badge badge-warning"> Intermedio</span>';
                        } elseif ($dataProvider->categoria['cat_nombre'] == 'Avanzado') {
                            return '<span class="badge badge-succes"> Avanzado</span>';
                        } else {
                            return 'Categoría no definida';
                        }
                    },
                    'format' => 'raw',
                ],
                'ranking.puntuacion',
                [
                    'attribute' => 'Puntos conseguidos',
                    'value' => function ($dataProvider) {
                        return Auxiliar::puntosConseguidos($dataProvider->id);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Feeds compartidos',
                    'value' => function ($dataProvider) {
                        $feeds = Feeds::find()->where(['usuariosid' => $dataProvider->id]);
                  
                        $cuantos = $feeds->count();

                        if ($cuantos != 0) {

                            return $cuantos;
                        } else {
                            return 'Todavía no ha publicado nada ';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'R. aceptados',
                    'value' => function ($dataProvider) {
                        $retos = RetosUsuarios::find()->where(['usuario_id' => $dataProvider->id]);
                        $cuantosSeguidores = $retos;
                        if ($cuantosSeguidores->count() != 0) {

                            return $cuantosSeguidores->count();
                        } else {
                            return '0';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'R. superados',
                    'value' => function ($dataProvider) {
                        $retos = RetosUsuarios::find()->select('culminado')->where(['usuario_id' => $dataProvider->id])->andWhere(['culminado' => true]);
                        $cuantosSeguidores = $retos;
                        if ($cuantosSeguidores->count() != 0) {

                            return $cuantosSeguidores->count();
                        } else {
                            return 'No ha superado ningún reto ';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Nº seguidores',
                    'value' => function ($dataProvider) {
                        $seguidores = Seguidores::find()->where(['seguidor_id' => $dataProvider->id]);
                        $cuantosSeguidores = $seguidores->count();
                        if ($cuantosSeguidores != 0) {
                            return $cuantosSeguidores;
                        } else {
                            return '0 ';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Nº Seguimientos',
                    'value' => function ($dataProvider) {
                        $seguimientos = Seguidores::find()->where(['usuario_id' => $dataProvider->id]);
                        $cuantos = $seguimientos->count();
                        if ($cuantos != 0) {
                            return $cuantos;
                        } else {
                            return '0 ';
                        }
                    },
                    'format' => 'raw',
                ],
            ],
        ]); ?>

    </div>
    <?= Auxiliar::volverAtras() ?>
</div>