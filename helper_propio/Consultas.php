<?php
/*
Conjunto de herramientas que permiten realizar consultas a la base de datos.

*/

namespace app\helper_propio;

use app\models\Comentarios;
use app\models\Feeds;
use app\models\FeedsFavoritos;
use app\models\Ranking;
use app\models\RetosUsuarios;
use app\models\Usuarios;
use kartik\grid\GridView;
use kartik\icons\Icon;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

class Consultas
{

    public static function comentarios($feeds)
    {
        $comentar = $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds]);
        return $comentar;
    }
    public static function muestraComentarios($feeds)
    {
        $comentarios = Comentarios::find()->where(['comentarios_id' => $feeds])->orderBy('created_at DESC')->all();
        return $comentarios;
    }
    public static function muestraRanking()
    {

        $arrModels = Ranking::find()->joinWith('usuarios')->where(['!=', 'rol', 'superadministrador'])->orderBy('puntuacion DESC')->limit(10)->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrModels,
        ]);

        return Gridpropio::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table table-hover table-borderless mb-6', 'style' => 'padding:50px, text-align:justify', 'encode' => false],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'Usuario',
                    'value' => function ($dataProvider) {

                        return  ucfirst($dataProvider->usuarios['nombre']);
                    },
                    'format' => 'raw',

                ],
                [
                    'attribute' => 'puntuacion',
                    'value' => function ($dataProvider) {

                        return $dataProvider->puntuacion .  ' ' . Icon::show('trophy');
                    },
                    'format' => 'raw',

                ],
            ],

        ]);
    }
    public static function puntuacionMedia()
    {
        $puntuacionMedia = Ranking::find()->average('puntuacion');
        return $puntuacionMedia;
    }

    public static function estadisticas()
    {

        $cuentaFeeds = Feeds::find()->count();
        $puntosTotales =  Ranking::find()->sum('puntuacion');
        $usuariosRegistrados = Usuarios::find()->count() - 1;
        $retosSuperados = RetosUsuarios::find()->count();
        $numeroComentarios = Comentarios::find()->count();
        $puntuacionMedia = Yii::$app->formatter->asInteger(Consultas::puntuacionMedia());

        $var = <<<EOT
        La puntuación media de los usuarios de #ecofriendly es de: <span class="badge badge-secondary"> $puntuacionMedia </span> puntos.

        <br>
        <br>
        <p>Se han publicado <strong>  $cuentaFeeds </strong> Feeds</p>
        <br>
        <p>Se han realizado $numeroComentarios comentarios</p>
        <br>
        <p>Los usuarios han superado: $retosSuperados Retos #ecofriendly</p>
        <br>
                <p> Se han conseguido: $puntosTotales puntos #ecofriendly </p>
        <p>Total usuarios registrados: $usuariosRegistrados</p>
EOT;
        return $var;
    }

    public static function numeroMeGustan($feeds)
    {
        $meGusta = FeedsFavoritos::find()->where(['feed_id' => $feeds]);
        return $meGusta;
    }
    public static function usuariosRegistrados()
    {
        $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '60px', 'height' => '60px']];
        $usuarios = Usuarios::find()->where(['!=', 'rol', 'superadministrador'])->all();
        for ($i = 0; $i < sizeof($usuarios); $i++) {
            echo '<ul class="list-group">'
                . '<li class="list-group-item btn-light col-12" style="margin:1px">' . Auxiliar::obtenerImagenUsuario($usuarios[$i]->id, $optionsBarraUsuarios);
            echo Html::button(ucfirst($usuarios[$i]->nombre), ['value' => Url::to(['usuarios/view', 'id' =>  $usuarios[$i]->id]), 'class' => 'btn modalButton2 btn-xl active', 'id' => 'modalButton2']);
            echo Html::hiddenInput('seguidor_id', $usuarios[$i]->id);
            echo '</li> </ul>';
        }
    }
    public static function gestionFeeds()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Feeds::find()
                ->where(['usuariosid' => Yii::$app->user->identity->id]),
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);
        //paginacion de 10 feeds por página
        $dataProvider->pagination = ['pageSize' => 10];

        return $dataProvider;
    }
}
