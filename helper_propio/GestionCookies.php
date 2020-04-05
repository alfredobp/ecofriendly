<?php


namespace app\helper_propio;

use Yii;
use yii\helpers\Url;

class GestionCookies
{
    /**
     * Función introduccion
     * Función que devuelve un texto introductorio para la primera vez que el usuario entra en la aplicación.
     * Cuando el usuario acepta se crea una cookie, para que no vuelva a salir el texto de ayuda.
     * @return $js
     */
    public static function introduccion()
    {
        $url5 = Url::to(['usuarios/obtenercookie']);
        $url4 = Url::to(['usuarios/guardacookie']);
        $url1 = Url::to(['usuarios/estado']);
        $url2 = Url::to(['usuarios/puntos']);
        $id = Yii::$app->user->id;
        $js = <<<EOT
            $( function() {
            $(".loader").fadeOut("slow");
            obtenerEstado();
            obtenerPuntuacion();
            });
            function sliderPuntuacion() {
                var puntuacion = $("#puntos")[0].innerHTML; 
                if (puntuacion<=20) {
                    $('#puntos').addClass("badge-danger");
                    //si la puntuación crece se aumenta el tamaño en función de la variable puntuación y se añade una
                    // para darle color según una clase css predefinida.
                    $('.progress-bar').css("width", puntuacion+'%').addClass("bg-danger");
                }else if(puntuacion>20&&puntuacion<60){
                    $('#puntos').addClass("badge-warning");
                    $('.progress-bar').css("width", puntuacion +'%').addClass("bg-warning");
                }
                else if(puntuacion>60){
                    $('#puntos').addClass("badge-success");
                    $('.progress-bar').css("width", puntuacion+'%').addClass("bg-success");
                }
            }

            function obtenerCookieColorFondo(){
                    $.ajax({
                        url: '$url5',
                        data:{cookie:'colorPanel'},
                        success: function(data){
                           console.log(data);
                           $(".feed").css('background-color', data);
                        }
                    });
            }
            function obtenerCookieColorTexto(){
                    $.ajax({
                        url: '$url5',
                        data:{cookie:'colorTexto'},
                        success: function(data){
                        // console.log(data);
                        $(".feed").css('color', data);
                        }
                    });
            }
            function obtenerCookieFuente(){
                    $.ajax({
                       url: '$url5',
                       data:{cookie:'fuente'},
                       success: function(data){
                            console.log(data);
                            $(".feed").css('font-family', data);
                            }
                        });
                    }
            function obtenerCookieTamañoFuente(){
                    $.ajax({
                        url: '$url5',
                        data:{cookie:'tamaño'},
                        success: function(data){
                             console.log(data);
                             $(".feed").css('font-size', data);
                             }
                        });
                    }

            function obtenerEstado(){
                    $.ajax({
                        url: '$url1',
                        data: { id: '$id'},
                        success: function(data){
                             console.log(data);
                             $("#estado").html(data);
                            }
                        });
                    }
 
            function obtenerPuntuacion(){
                    $.ajax({
                        url: '$url2',
                        data: { id: '$id'},
                        success: function(data){
                             console.log(data);
                             $("#puntos").html(data);
                             var puntuacion = $("#puntos")[0].innerHTML; 

                            if (puntuacion<=20) {
                                $('#puntos').addClass("badge-danger");
                                //si la puntuación crece se aumenta el tamaño en función de la variable puntuación y se añade una
                                // para darle color según una clase css predefinida.
                                $('.progress-bar').css("width", data+'%').addClass("bg-danger");
                            }else if(puntuacion>20&&puntuacion<60){
                                $('#puntos').addClass("badge-warning");
                                $('.progress-bar').css("width", data +'%').addClass("bg-warning");
                            }
                            else if(puntuacion>60){
                                $('#puntos').addClass("badge-success");
                                $('.progress-bar').css("width", data+'%').addClass("bg-success");
                            }
                         }
                     });
                        }

            EOT;
        return $js;
    }
    /**
     * Cookies Estilo
     *Retorna las cookies de estilo, si el usuario decida personalizar aspectos de estilos de la aplicación.
     * @return $jsEstilo
     */
    public static function cookiesEstilo()
    {
        $url5 = Url::to(['usuarios/obtenercookie']);
        $jsEstilo = <<<EOT
            $( function() {
             obtenerCookieColorFondo();
             obtenerCookieColorTexto();
             obtenerCookieFuente();
             obtenerCookieTamañoFuente();
            });
                function obtenerCookieColorFondo(){
                    $.ajax({
                        url: '$url5',
                        data:{cookie:'colorPanel'},
                        success: function(data){
                            console.log(data);
                                $(".feed").css('background-color', data);  
                        }
                    });
            }

            function obtenerCookieColorTexto(){
                        $.ajax({
                            url: '$url5',
                            data:{cookie:'colorTexto'},
                            success: function(data){
                                console.log(data);
                                $(".feed").css('color', data);
                            }
                        });
                }
            
                function obtenerCookieFuente(){
                            $.ajax({
                                url: '$url5',
                                data:{cookie:'fuente'},
                                success: function(data){
                                    console.log(data);
                                        $(".feed").css('font-family', data);
                                }
                            });
                            }
                function obtenerCookieTamañoFuente(){
                                $.ajax({
                                    url: '$url5',
                                    data:{cookie:'tamaño'},
                                    success: function(data){
                                        console.log(data);
                                            $(".feed").css('font-size', data);
                                    }
                                });
                                }
                
        EOT;
        return $jsEstilo;
    }
}
