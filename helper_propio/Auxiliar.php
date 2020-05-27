<?php
/*
Conjunto de herramientas que permiten la reutilización de código.

*/

namespace app\helper_propio;

use app\models\AccionesRetos;
use app\models\Feeds;
use app\models\Ranking;
use app\models\RankingSearch;
use app\models\Usuarios;
use Github\Api\Enterprise\Stats;
use kartik\icons\Icon;
use PhpParser\Node\Stmt\Static_;
use Yii;
use yii\bootstrap4\Modal;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Dialog;

class Auxiliar
{
    /**
     * Función introduccion
     * Función que devuelve un texto introductorio para la primera vez que el usuario entra en la aplicación.
     * Cuando el usuario acepta se crea una cookie, para que no vuelva a salir el texto de ayuda.
     * @return $js
     */
    public static function introNovatos()
    {
        $urlCookie = Url::toRoute(['site/nuevos',  'respuesta' => 'aceptada'], $schema = true);

        $js =           Dialog::begin([
            'clientOptions' => [
                'modal' => true,
                'autoOpen' => true,
                'title' => 'Información para nuevos usuarios de #ecofriendly',
                'width' => '600px',
                'id' => 'prueba',
                'buttons' => [

                    ['text' => 'Aceptar', 'onclick' => 'window.location="' . $urlCookie . '"'],
                ],
            ],
        ]);
        echo    '<p> Bienvenido a la red social de ecofriendly, donde prodrás mejorar tu huella de carbono y ayudar a cuidar el planeta.

        ¿Por donde empezar?

            <a class="list-group-item list-group-item-action" href="#list-item-1"> 1. Agrega nuevos seguidores a tu red, para ver el contenido.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-2"> 2. Observa los ecoretos que se te ha otorgado y acepta el desafio.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-3"> 3. Comparte cualquier tema relacionado con la sostenibilidad y el planeta.</a>
            <a class="list-group-item list-group-item-action" href="#list-item-4">4. Recuerda que puedes ver tu progreso en cualquier momento desde el sidebar.</a>
        
    </p>
    <p class="card-text"><small class="text-muted"> El equipo de #Ecofriendly </small></p>';
        Dialog::end();
        return $js;
    }

    public static function obtenerImagenUsuario($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '25px', 'height' => '35px']])
    {

        $id1 = Usuarios::find()->where(['id' => $id])->one();

        $id1['url_avatar'] != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' .  $id1['url_avatar'], $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenSeguidor($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '45px', 'height' => '65px', 'margin-right' => '12px', 'margin-left' => '12px']])
    {
        $id1 = Usuarios::find()->where(['id' => $id])->one();
        $id1['url_avatar'] != null ? $imagenUsuario = Html::img(Yii::getAlias('@uploads') . '/' .  $id1['url_avatar'], $options) :  $imagenUsuario = Html::img('@web/img/basica.jpg', $options);
        return $imagenUsuario;
    }
    public static function obtenerImagenFeed($id, $options = ['class' => ['img-contenedor'], 'style' => ['width' => '150px', 'margin-right' => '12px', 'margin-left' => '12px', 'border-radius' => '30px']])
    {
        $id != null ? $imagenFeed = Html::img(Yii::getAlias('@uploads') . '/' . $id, $options) : $imagenFeed = '';
        return $imagenFeed;
    }


    public static function ventanaModal($title, $id, $size = 'md')
    {
        $ventana =
            Modal::begin([
                'title' =>  $title . ':',
                'id' => 'modal' . $id,
                'size' => 'modal-' . $size,
            ]);
        echo '<div id="modalContent' . $id . '"></div>';

        Modal::end();

        return $ventana;
    }
    public static function puntosRestantes($id, $categoriaId)
    {
        $puntos = Ranking::find()->where(['usuariosid' => $id])->one();

        if ($categoriaId == 1) {
            return 30 - $puntos->puntuacion;
        } elseif ($categoriaId == 2) {
            return 60 - $puntos->puntuacion;
        } elseif ($categoriaId == 3) {
            return 100 - $puntos->puntuacion;
        }
    }
    public static function enviarEmailAusentes()
    {
        $usuariosAusentes = Usuarios::find()->asArray()->all();
        $dif2 = date('Y-m-d H:i:s');
        foreach ($usuariosAusentes as $key => $value) {
            //Calcula la diferencia entre la ultima conexión de los usuarios  y la fecha actual.
            if ($value['ultima_conexion'] != null) {
                $start_ts = strtotime($value['ultima_conexion']);
                $end_ts = strtotime(date('Y-m-d H:i:s'));
                $diferenciaTiempo = $end_ts - $start_ts;
                //redondeo el tiempo transcurrido para obtener el número de días que han transcurrido.
                $diferenciaTiempoDias = round($diferenciaTiempo / 86400);

                //Si ha pasado 7 dias o más desde la última conexión se envia un correo a todos los usuarios.
                if ($diferenciaTiempoDias >= 7) {
                    $nivel = Usuarios::find()->joinWith('categoria')->where(['usuarios.id' => $value['id']])->one();
                    $puntos = Usuarios::find()->joinWith('ranking')->where(['usuarios.id' => $value['id']])->one();
                    $nFeeds = Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
                        ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
                        ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
                        ->Where([
                            'seguidores.usuario_id' => $value['id'],
                        ])
                        ->andWhere('feeds.created_at>usuarios.ultima_conexion')
                        ->count();

                    $subject = 'Ultimas Novedades de la red de Ecofriendly';
                    $body = 'Estimado usuario: ' . $value['nombre'];
                    $body .= ' Desde el equipo de <strong> #ecofriendly</strong> queremos informarle sobre las últimas novedades de la red: <br> <ul>';
                    $body .= ' <li>Se han compartido:' . $nFeeds . '</li>';
                    $body .= '<li>Tu nivel es: ' . $nivel->categoria->cat_nombre . '</li>';
                    $body .= '<li>Te faltan: ' . $puntos->ranking->puntuacion . ' para subir de categoría</li> </ul>';
                    $body .= '<br> <p> Atte. El equipo de ecofrienfly';
                    Yii::$app->mailer->compose()
                        ->setTo($value['email'])
                        ->setFrom([Yii::$app->params['adminEmail']])
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();
                }
            }
        }
    }
    public static function areaAdminConf()
    {


        $feed = Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
            ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
            ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
            ->orderBy('feeds.created_at desc')
            ->asArray()->all();

        return $feed;
    }
    public static function areaAdminConfII()
    {
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => Feeds::find()->select(['usuarios.*', 'seguidores.*', 'feeds.*'])
                ->leftJoin('seguidores', 'seguidores.seguidor_id=feeds.usuariosid')
                ->leftJoin('usuarios', 'usuarios.id=feeds.usuariosid')
                ->count(),
        ]);
        return $pagination;
    }
    public static function puntosConseguidos($id)
    {


        return AccionesRetos::find()->joinWith('retosUsuarios r')->where(['r.usuario_id' => $id])->andWhere(['r.culminado' => true])->sum('puntaje');
    }
    /**
     * Función que permite al usuario volver atras mediante un botón
     * Devuelve un boton con la ruta al sitio del que proviene el usuario
     * @return function
     */
    public static function volverAtras()
    {
        return '<br> <hr>' . yii\helpers\Html::a('<h4>' . Icon::show('arrow-alt-circle-left') . 'Volver atrás </h4>', Yii::$app->request->referrer);
    }
    /**
     * Undocumented function
     * Devuelve true si el usuario tiene ese rol o false si no es usuario admin
     * @return boolean
     */
    public static function esAdministrador()
    {
        return Yii::$app->user->identity->rol == 'superadministrador' ? true : false;
    }
}
