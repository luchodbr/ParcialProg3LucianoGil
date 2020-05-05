<?php

    class Asignacion{

        public $legajoProf;
        public $idMateria;
        public $turno;

        public function __construct($legajoProf,$idMateria,$turno){
            $this->legajoProf=$legajoProf;
            $this->idMateria=$idMateria;
            $this->turno=$turno;
        } 
     
        
        public function guardarAsignacion($token){
            $token = Autenticar::validarToken($token);
            $encontro = false;
            $encontroMat = false;
            if($token){
               
                    $Asignacion = Datos::leer('Asignaciones.xxx');
                    $profesores = Datos::leer('profesores.xxx');
                    $materias = Datos::leer('materia.xxx');
                if(isset($Asignacion) )
                {
                 
                    foreach ($profesores as  $value)
                     {
                        if($this->legajoProf == $value->legajo)
                        {
                            $encontro = true;
                        }
                    }
                    foreach ($materias as  $value)
                     {
                        if($this->idMateria == $value->id)
                        {
                            $encontroMat = true;
                        }
                    }
                    if(!$encontro || !$encontroMat)
                    {
                        return "no existe ese legajo o id Materia";
                    }
    
                        foreach ($Asignacion as $value) 
                        {
                            if($value->legajoProf === $this->legajoProf && $value->idMateria === $this->idMateria && $value->turno === $this->turno)
                            {
                                return "Ya esta registrado esta Asignacion";
                            }
                        }
                    }
                   
                    Datos::guardar('Asignaciones.xxx',$this);
                    return 'Asignacion guardado';
                }
            return 'token inválido';
        }

        public static function listarAsignacion($token){
            $asignaciones = Datos::leer('Asignaciones.xxx');
            $profesores = Datos::leer('profesores.xxx');
            $materias = Datos::leer('materia.xxx');
            $token = Autenticar::validarToken($token);
            $return ='';

            if($token){
                if(isset($profesores) && isset($asignaciones) && isset($materias)){
                    foreach($profesores as $profesor){
                        foreach($asignaciones as $asignacion){
                            if($profesor->legajo == $asignacion->legajoProf ){
        
                                $return  = $return.'Nombre :'.$profesor->nombre;
                                $return = $return."Las materias que dicta son: ".PHP_EOL;
                                foreach($materias as $materia){
                                    if($asignacion->idMateria == $materia->id){
                                        
                                        $return = $return.$materia->nombre.PHP_EOL;
                                        $return = $return.'el turno de la materia:'.$asignacion->turno.PHP_EOL;
                                    }
                                }
                            }
                        }
                    }
                    return $return;
                }




            }
        }
    }