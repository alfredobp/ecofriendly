<?php

use app\models\MensajesPrivados;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MensajesPrivadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensajes Privados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-privados-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mensajes Privados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php
    $dataProvider = new ActiveDataProvider([

        'query' => MensajesPrivados::find()->where(['receptor_id' => Yii::$app->user->identity->id])

    ]);

    ?>

    <h3>Mensajes Recibidos</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,


        'columns' => [
            // 'id',
            // 'emisor.nombre',
            [
                'attribute' => 'Recibido de:',
                'value' => function ($dataProvider) {
                    return ucfirst($dataProvider->emisor->username);
                },
                'format' => 'raw',
            ],
            // 'receptor.nombre',
            // 'emisor_id',
            // 'receptor_id',
            'asunto',
            'contenido',
            //'seen:boolean',
            // 'created_at',
            [
                'attribute' => 'Recibido:',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },
                'format' => 'raw',
            ],
            //'visto_dat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php
    $dataProvider = new ActiveDataProvider([

        'query' => MensajesPrivados::find()->where(['emisor_id' => Yii::$app->user->identity->id])
    ]);
    ?>
    <br>
    <br>
    <br>
    <h3>Mensajes enviados</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            // 'id',
            // 'emisor.nombre',

            [
                'attribute' => 'Destinatario:',
                'value' => function ($dataProvider) {
                    return ucfirst($dataProvider->receptor->username);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Enviado:',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },
                'format' => 'raw',
            ],
            // 'emisor_id',
            // 'receptor_id',
            'asunto',
            'contenido',
            //'seen:boolean',
            // 'created_at',
            //'visto_dat',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>