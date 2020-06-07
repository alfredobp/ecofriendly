<?php


use app\helper_propio\Auxiliar;
use app\models\AccionesRetos;
use kartik\icons\Icon;
use PhpParser\Node\Expr\New_;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RetosUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Retos Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retos-usuarios-index">

    <h1><?= Html::encode('Retos aceptados por el usuario') ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php $model2 = new AccionesRetos(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [

            'idreto0.titulo',
            [
                // 'header' => 'Fecha de <br> Actualización',
                'attribute' => 'created_at',
                'label' => 'Fecha Aceptación',

                'value' => function ($dataProvider) {
                    return  Yii::$app->formatter->asRelativeTime($dataProvider->fecha_aceptacion);
                },
            ],

            'culminado:boolean',

            [
                'class' => ActionColumn::class,
                'controller' => 'retos-usuarios',
                'template' => '{finalizar}{declinar}',
                'buttons' => [


                    'finalizar' => function ($url, $model) {
                        return \yii\helpers\Html::a(
                            Icon::show('check'),
                            (new yii\grid\ActionColumn())->createUrl('retos-usuarios/finalizar', $model, ['idreto' => $model->id, 'usuario_id' => Yii::$app->user->identity->id], 1),
                            [
                                'title' => Yii::t('yii', 'Anotar Reto como superado'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'data-confirm' => '¿Has superado este reto superando todas las prescripciones?'
                            ]
                        );
                    },
                    'declinar' => function ($url, $model) {
                        return \yii\helpers\Html::a(
                            Icon::show('minus-circle'),
                            (new yii\grid\ActionColumn())->createUrl('retos-usuarios/declinar', $model, ['idreto' => $model->idreto, 'usuario_id' => Yii::$app->user->identity->id], 1),
                            [
                                'title' => Yii::t('yii', 'Declinar Reto'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'data-confirm' => '¿Estas seguro de declinar este reto?'
                            ]
                        );
                    },
                ],
            ],

        ],
    ]); ?>



</div>