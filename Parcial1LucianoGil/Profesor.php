<?php

require_once './datos.php';
require_once './Autenticar.php';
 class Profesor{

    public $nombre;
    public $legajo;
    public $foto;

    public function __construct($nombre,$legajo,$foto){
        $this->nombre=$nombre;
        $this->legajo=$legajo;
        $this->foto=$foto;
    }

    public function guardarProfesor($token){
        $token = Autenticar::validarToken($token);
        if($token){
           
                $profesores = Datos::leer('profesores.xxx');
                if(isset($profesores))
                {

                    foreach ($profesores as $value) 
                    {
                        if($value->legajo === $this->legajo)
                        {
                            return "Ya esta registrado este profesor";
                        }
                    }
                }
                if($this->foto){
                     $this->guardarImagenprofesores($this->foto['tmp_name'], $this->foto['name']);
                }
                Datos::guardar('profesores.xxx',$this);
                return 'Profesor guardado';
            }
        return 'token inválido';
    }

   
    public function guardarImagenprofesores($path, $nombre)
    {
        $folder = "imagenes/";
        $pathImg = $folder . time() . '-' . $nombre;
         move_uploaded_file($path, $folder.time().'-'.$nombre);   
     }

     public static function listarProfesores($token){
        $arrayVacio = array();
        $profesores = Datos::leer("profesores.xxx")??$arrayVacio;
        $token = Autenticar::validarToken($token);
        $return = '';
        if($token)
        {
            foreach ($profesores as $key) {
                $return  = $return.'Nombre: '.$key->nombre.PHP_EOL;
                $return = $return.'legajo: '.$key->legajo.PHP_EOL;
            }
            return $return;
        }
        return "token invalido";
    }
}
