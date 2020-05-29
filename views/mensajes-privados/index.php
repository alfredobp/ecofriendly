<?php

use app\helper_propio\Auxiliar;
use app\models\MensajesPrivados;
use kartik\icons\Icon;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MensajesPrivadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Icon::map($this);

$this->title = 'Mensajes Privados';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$script = <<<JS
$(function(){
    var checks = $("tr:contains('Pendiente de lectura')"); // Obtengo todos los checkbox 
checks.css("background","#F78181");
});
JS;

$this->registerJs($script); // Registro el script javascript en el view 
?>
<div class="mensajes-privados-index col-8">

    <h1><?= Html::encode('Mensajes #ecofriendly   ') ?> <?= Html::a('Enviar nuevo mensaje', ['create'], ['class' => 'btn btn-success']) ?></h1>

    <p>

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

    <h3>Mensajes recibidos</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'shadow-lg p-3 mb-5 bg-white rounded'
        ],

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
            // 'contenido',
            //'seen:boolean',
            // 'created_at',
            [
                'attribute' => 'Recibido:',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'Mensaje leido:',

                'contentOptions' => ['class' => 'target'],


                'value' => function ($dataProvider) {
                    if ($dataProvider->visto_dat != null) {
                        return 'Si';
                    } else {
                        return 'Pendiente de lectura';
                    }
                },
                'format' => 'raw',
            ],

            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{responder}{view}{delete}',

                'buttons' => [

                    'view' => function ($url, $model) {

                        return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', $url, [

                            'title' => Yii::t('yii', 'Ver Mensaje'),

                        ]);
                    },
                    'responder' => function ($url, $model) {

                        return Html::a(Icon::show('reply'), $url, [

                            'title' => Yii::t('yii', 'Responder'),

                        ]);
                    }

                ]



            ],

            // ['class' => 'yii\grid\ActionColumn'],
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
        'options' => ['class' => 'shadow-lg p-3 mb-5 bg-white rounded'],

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

            // 'emisor_id',
            // 'receptor_id',
            'asunto',
            'contenido',
            [
                'attribute' => 'Enviado:',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asRelativeTime($dataProvider->created_at);
                },
                'format' => 'raw',
            ],
            //'seen:boolean',
            // 'created_at',
            //'visto_dat',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    <?php echo Auxiliar::volverAtras() ?>

</div>