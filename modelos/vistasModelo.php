<?php

    class vistasModelo{
        /*------------------- Modelo para obtener las vistas ------------------ */

        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca=["home","client-list","client-new","client-search","client-update",
            "company","home","item-list","item-new","item-search","item-update",
            "reservation-list","reservation-new","reservation-pending","reservation-reservation",
            "reservation-search","reservation-updated","user-list","user-new","user-search",
            "user-update"];    //Este array contiene las "palabras" reservas para las vistas en la URL
            if(in_array($vistas,$listaBlanca)){ 
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){    //Con el comando is file, verificamos si existe el archivo vista correspondiente. Las VISTAS deben ser creadas asi con "-view" por que asi lo defini aca.
                    $contenido="./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="login" || $vistas=="index"){
                $contenido="login";
            }else{
                $contenido="404";
            }
            return $contenido;
        }

    }