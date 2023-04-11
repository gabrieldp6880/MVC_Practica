<?php
    //Comentarios para entender: El Controlador recibe las peticiones Http y a partir de eso, va y recurre a los modelos correspondientes que contienen los datos.
    //Incluir el modelo
    require_once "./modelos/vistasModelo.php";

    class vistasControlador extends vistasModelo{

        /*------------------- Controlador para obtener plantilla ------------------ */
        public function obtener_plantilla_controlador(){
            return require_once "./vistas/plantilla.php";
        }

        /*------------------- Controlador para obtener las vistas ------------------ */
        public function obtener_vistas_controlador (){
            if(isset($_GET['views'])){   //Aca veo si viene en la URL el parametro "views" (elegi esa palabra en el archivo htaccess, por lo tanto tiene que ser la misma)
                $ruta=explode("/",$_GET['views']);   //Parseo y obtengo la vista en cuestion
                $respuesta=vistasModelo::obtener_vistas_modelo($ruta[0]);
            }else{
                $respuesta="login"; //Si No viene nada en la URL, muestra por defecto la pantalla de login
            }
            return $respuesta;
        }



    }