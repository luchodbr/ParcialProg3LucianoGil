<?php

class Datos{

    public $archivo;


    public static function guardar($archivo,$objeto){
        //leemos
        $arrayVacio = array();
        $arrayArchivo = Datos::leer($archivo)??$arrayVacio;
     
        array_push($arrayArchivo,$objeto);
        //escribimos
        $file=fopen($archivo,'w');
        $rta = fwrite($file,serialize($arrayArchivo));
        fclose($file);
        return $rta;
    }

    public static function actualizarTodo($array,$archivo){
        $file=fopen($archivo,'w+');
        $rta = fwrite($file,serialize($array));
        fclose($file);
        return $rta;
    }

    public static function leer($archivo){
        if(file_exists($archivo) && filesize($archivo) > 0){ //Por si no existe o está vacío 
            $file = fopen($archivo, 'r');

            $arrayString = fgets($file);

            $retorno = unserialize($arrayString);

            fclose($file);

            return $retorno;
        }
        return null;
    }




    public static function guardarJSON($datos, $actualizar = false ){
        $archivo = 'pizza.json';
        if(!$actualizar){
            $arrayJSON = Datos::leerJSON($archivo)??array();
            array_push($arrayJSON, $datos);
            $datos = $arrayJSON;       
        }
        $file = fopen($archivo, 'w+');
        $rta = fwrite($file, json_encode($datos));
        fclose($file);
        return $rta;

    }

    public static function leerJSON(){
        $archivo = './pizza.json';
        if(file_exists($archivo) && filesize($archivo) > 0){
            $file = fopen($archivo, 'r');

            $arrayString = fread($file, filesize($archivo));

            $arrayJSON = json_decode($arrayString, true);

            fclose($file);

            return $arrayJSON;
        }
        return null;
    }
}