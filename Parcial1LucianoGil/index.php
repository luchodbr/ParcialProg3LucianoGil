<?php

require_once './usuario.php';
require_once './Materias.php';
require_once './Profesor.php';
require_once './Asginacion.php';



include 'vendor/autoload.php';


$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '';
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO']  : '';

$headers=getallheaders();
$mitoken = $headers["token"] ?? '';
$respuesta;

switch ($path) {
    case '/usuario':
        if($method == 'POST')
        {
            $email = $_POST['email'] ?? null;
            $clave = $_POST['clave'] ?? null;
            
            
            if ( isset($email) && isset($clave)) {
                
                 $Usuario = new Usuario($email, $clave);
                var_dump($Usuario->Save());
            }
            else{
                echo 'Faltan datos';
            }


        }
        else{
            echo 'error debe ser post';
        }
        break;
    
    case '/materia':
        if($method == 'POST')
        {
            $nombre = $_POST['nombre'] ?? null;
            $cuatrimestre = $_POST['cuatrimestre'] ?? null;
            $materia = new Materia($nombre,$cuatrimestre);
            echo $materia->guardarMateria($mitoken);
        } 
        else if ($method == 'GET'){
            echo Materia::listarMaterias($mitoken);
        }  
    break;
    case '/login':
        if($method == 'POST')
        {
            $email = $_POST['email'] ?? null;
            $clave = $_POST['clave'] ?? null;

             $mitoken = Usuario::login($email,$clave);
            if($mitoken){
                
                echo  'Su token es: '.$mitoken;
            }
            else{
                echo  'Verifique los datos';
            }
        }
        else{
            echo 'error debe ser post';
        }
    break;

    case '/profesor':
        if($method == 'POST'){

            $nombre = $_POST['nombre']??null;
            $legajo = $_POST['legajo']??null;
            $foto = $_FILES['imagen']??null;

                    $prof = new Profesor($nombre,$legajo,$foto);
                    echo  $prof->guardarProfesor($mitoken);

            
        }
        else if ($method == 'GET'){
            echo Profesor::listarProfesores($mitoken);
        }  
    break;
    case '/asignacion':
        if($method == 'POST'){
          
            $legajoProf = $_POST['legajo']??null;
            $idMateria = $_POST['id']??null;
            $turno = $_POST['turno']??null;

                    $prof = new Asignacion($legajoProf,$idMateria,$turno);
                    echo  $prof->guardarAsignacion($mitoken);

            
        }
        else if ($method == 'GET'){
            echo Asignacion::listarAsignacion($mitoken);
        }  
    break;



    default:
        echo 'metodo no soportado';
        break;
}