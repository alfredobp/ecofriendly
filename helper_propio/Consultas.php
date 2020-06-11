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

        return  Comentarios::obtenerComentarios($feeds);
    }
    public static function muestraComentarios($feeds)
    {
        return Comentarios::muestraComentarios($feeds);
    }
    public static function muestraRanking()
    {

        $arrModels = Ranking::dimeRanking();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrModels,
        ]);
        $dataProvider->pagination = ['pageSize' => 10];
        return Gridpropio::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'table-hover hourglass-start  
            ', 'style' => 'padding:50px, text-align:justify', 'encode' => false],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'Usuario',
                    'headerOptions' => ['style' => 'font-size:0.9vw;'],
                    'value' => function ($dataProvider) {

                        return  ucfirst($dataProvider->usuarios['nombre']);
                    },
                    'format' => 'raw',

                ],
                [

                    'headerOptions' => ['style' => 'font-size:0.9vw; '],
                    'attribute' => 'puntuacion',
                    'value' => function ($dataProvider) {

                        return $dataProvider->puntuacion .  ' ' . Icon::show('trophy');
                    },
                    'format' => 'raw',

                ],
            ],

        ]);
    }


    public static function estadisticas()
    {

        $cuentaFeeds = Feeds::find()->count();
        $puntosTotales = Ranking::puntosTotales();
        $usuariosRegistrados = Usuarios::find()->count() - 1;
        $retosSuperados = RetosUsuarios::find()->count();
        $numeroComentarios = Comentarios::find()->count();
        $puntuacionMedia = Yii::$app->formatter->asInteger(Ranking::puntuacionMedia());

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
        <p> La puntuacion media es de: $puntuacionMedia puntos.</p>
                <p> Se han conseguido: $puntosTotales puntos #ecofriendly </p>
        
                <p>Total usuarios registrados: $usuariosRegistrados</p>

EOT;
        return $var;
    }

    public static function numeroMeGustan($feeds)
    {
        $meGusta = FeedsFavoritos::numeroMeGustan($feeds);
        return $meGusta;
    }
    public static function usuariosRegistrados()
    {
        $optionsBarraUsuarios = ['class' => ['img-contenedor'], 'style' => ['width' => '60px', 'height' => '60px']];
        $usuarios2 = new Usuarios;
        $usuarios = $usuarios2->usuariosRegistrados(Yii::$app->user->identity->id);
        for ($i = 0; $i < sizeof($usuarios); $i++) {
            echo '<ul class="list-group">'
                . '<li class="list-group-item btn-light col-12" style="margin:1px">' . Auxiliar::obtenerImagenSeguidor($usuarios[$i]->id, $optionsBarraUsuarios);
            echo Html::button(ucfirst($usuarios[$i]->nombre), ['value' => Url::to(['usuarios/view', 'id' =>  $usuarios[$i]->id]), 'class' => 'btn modalButton2 btn-xl active', 'id' => 'modalButton2']);
            echo Html::hiddenInput('seguidor_id', $usuarios[$i]->id);
            echo '</li> </ul>';
        }
    }
    public static function gestionFeeds()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Feeds::feedsPropios()
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);
        //paginacion de 10 feeds por página
        $dataProvider->pagination = ['pageSize' => 10];

        return $dataProvider;
    }
}
