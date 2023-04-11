<?php
    if($peticionAjax){
        require_once "../config/SERVER.php"; //Si hay una peticion, proviene de los archivos que estan en la carpeta "ajax" por lo tanto hay que volver para atras 2 veces
    }else{
        require_once "./config/SERVER.php"; //Si no hay una peticion, proviene de afuera de la carpeta "ajax" por lo tanto hay que volver para atras 1 vez.
    }


    class mainModel {

        /****Funcion para conectar a la BD ****/
        protected static function conectar(){
            $conexion = new PDO(SGBD,USER,PASS);
            $conexion->exec("SET CHARACTER SET utf8"); // Para enviar y recibir "ñ" y otros caracteres
            return $conexion;
        }



        /****Funcion ejecutar consultas simples ****/
        protected static function ejecutar_consulta_simlpe($consulta){
            $sql=self::conectar()->prepare($consulta); //el self es como el "this" para ejecutar una funcion de la misma clase.
            $sql->execute();
            return $sql;
        }



        /****Funciones para encriptar y desencriptar cadenas ****/
        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

        /****Funcion para generar codigos aleatorios ****/
        protected static function generar_codigo_aleatorio($letra,$longitud,$numero){
            for($i=1; $i<=$longitud; $i++){
                $aleatorio=rand(0,9);
                $letra.=$aleatorio;
            }
            return $letra."-".$numero;
        }

        /****Funcion para limpíar cadenas ****/
        protected static function limpiar_cadena($cadena){
            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);
            $cadena=str_ireplace("<script>","", $cadena);
            $cadena=str_ireplace("</script>","", $cadena);
            $cadena=str_ireplace("<script> src","", $cadena);
            $cadena=str_ireplace("<script> type=","", $cadena);
            $cadena=str_ireplace("SELECT * FROM","", $cadena);
            $cadena=str_ireplace("DELETE * FROM","", $cadena);
            $cadena=str_ireplace("INSERT INTO * FROM","", $cadena);
            $cadena=str_ireplace("DROP TABLE","", $cadena);
            $cadena=str_ireplace("DROP DATABASE","", $cadena);
            $cadena=str_ireplace("TRUNCATE TABLE","", $cadena);
            $cadena=str_ireplace("SHOW TABLES","", $cadena);
            $cadena=str_ireplace("SHOW DATABASES","", $cadena);
            $cadena=str_ireplace("<?php","", $cadena);
            $cadena=str_ireplace("?>","", $cadena);
            $cadena=str_ireplace("--","", $cadena);
            $cadena=str_ireplace(">","", $cadena);
            $cadena=str_ireplace("<","", $cadena);
            $cadena=str_ireplace("[","", $cadena);
            $cadena=str_ireplace("]","", $cadena);
            $cadena=str_ireplace("^","", $cadena);
            $cadena=str_ireplace("==","", $cadena);
            $cadena=str_ireplace(";","", $cadena);
            $cadena=str_ireplace("::","", $cadena);
            $cadena=stripslashes($cadena);
            $cadena=trim($cadena);
            return $cadena;
        }

        /****Funcion verificar datos ****/
        protected static function verificar_datos($filtro,$cadena){
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            }else{
                return true;
            }
        }

        /****Funcion verificar fechas ****/
        protected static function verificar_fecha($fecha){
            $valores=explode('-',$fecha);
            if(count($valores)==3 && checkdate($valores[1],$valores[2],$valores[0])){
                return false;
            }else{
                return true;
            }
        }
    }