<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController{
    public static function index(){

    }

    public static function crear(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();

            $proyecto_id= $_POST['proyecto_id'];
            
            $proyecto = Proyecto::where('url', $proyecto_id);

            if(!$proyecto || $proyecto->propietario_id !== $_SESSION['id']){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'hubo un error'
                ];

                echo json_encode($respuesta);
                return;
                
            }

            //dok
            
            $tarea = new Tarea($_POST);
            $tarea->proyecto_id = $proyecto->id;
            $resultado = $tarea->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea creada correctamente'
            ];

            echo json_encode($respuesta);


            
            
        }
    }

    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        }
    }
}