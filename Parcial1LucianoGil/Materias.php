<?php

 class Materia{

    public $nombre;
    public $cuatrimestre;
    public $id;

    public function __construct($nombre,$cuatrimestre){
        $this->nombre=$nombre;
        $this->cuatrimestre=$cuatrimestre;
        $this->id = 1;
        
    }



    public function guardarMateria($token){
            $arrayVacio = array();
            $arrayJSON = Datos::leer("materia.xxx")??$arrayVacio;
            $token = Autenticar::validarToken($token);
        if($token){
            if($arrayJSON != $arrayVacio)
            {
                foreach ($arrayJSON as $value) {
                    if($value->nombre == $this->nombre)
                    {
                        return "Ya esta registrado este id";
                    }
                }
                $this->id =end($arrayJSON)->id+1;
            }

          Datos::guardar("materia.xxx",$this);
          return "Se ha Registrado la materia";
        }
        return "token no valido";
    }

    public static function listarMaterias($token){
        $arrayVacio = array();
        $materias = Datos::leer("materia.xxx")??$arrayVacio;
        $token = Autenticar::validarToken($token);
        $return = '';
        if($token)
        {
            foreach ($materias as $key) {
                $return  = $return.'Nombre: '.$key->nombre.PHP_EOL;
                $return = $return.'cuatrimestre: '.$key->cuatrimestre.PHP_EOL;
                $return = $return.'id: '.$key->id.PHP_EOL;
            }
            return $return;
        }
        return "token invalido";
    }

    



 }