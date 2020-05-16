<?php

namespace app\helper_propio;

use yii\helpers\Url;

class EstilosAppUsuario
{
    /**
     * Función que permite obtener los valores de personalización mediante consulta ajax a una función
     * obteniendo el valor de las cookies creadas a tal efecto.
     */
    public static function cookiesEstiloSeleccionado()
    {
        $url5 = Url::to(['usuarios/obtenercookie']);
        $jsEstilo = <<<EOT
            $( function() {
             obtenerCookieColorFondo();
             obtenerCookieColorTexto();
             obtenerCookieFuente();
             obtenerCookieTamañoFuente();
             obtenerCookieColorFondoBody();
            });
                function obtenerCookieColorFondo(){
                    $.ajax({
                        url: '$url5',
                        data:{cookie:'colorPanel'},
                        success: function(data){
                            $("#pickerColor").val(data);
                        }
                    });
            }
            function obtenerCookieColorTexto(){
                        $.ajax({
                            url: '$url5',
                            data:{cookie:'colorTexto'},
                            success: function(data){
                                
                                $("#pickerColor2").val(data);
                            }
                        });
                }
            function obtenerCookieFuente(){
                            $.ajax({
                                url: '$url5',
                                data:{cookie:'fuente'},
                                success: function(data){
                                    $("#fuente").val(data);
                                     
                                }
                            });
                            }
                function obtenerCookieTamañoFuente(){
                                $.ajax({
                                    url: '$url5',
                                    data:{cookie:'tamaño'},
                                    success: function(data){
                                   
                                        $("#slider").val(data.substring(0,2));
                                    }
                                });
                                }
                                function obtenerCookieColorFondoBody(){
                                    $.ajax({
                                        url: '$url5',
                                        data:{cookie:'colorFondo'},
                                        success: function(data){                                              
                                                $("#pickerColor3").val(data);
                                        }
                                    });
                                    }
                
        EOT;
        return $jsEstilo;
    }
}
