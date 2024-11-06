<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietario_id', $id);
        

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crearProyecto(Router $router){
        session_start();
        isAuth();

        $alertas= [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyecto($_POST);
            
            //validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)){
                //generar una url unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                //almacenar el creador del proyecto
                $proyecto->propietario_id = $_SESSION['id'];
                
                //guardar el proyecto
                $proyecto->guardar();
                header('Location: /proyecto?id='. $proyecto->url);

            }
        }

        
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        
        //revisar que la persona que visita el proyecto es quien la creo
        $token = $_GET['id'];

        if(!$token) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietario_id !== $_SESSION['id']){
            header('Location: /dashboard');
        }
        


        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        isAuth();
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }
}