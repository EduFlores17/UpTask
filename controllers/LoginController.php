<?php

namespace Controllers;

use MVC\Router;

class LoginController{
//CONTROLADOR DE LOGIN---------------------------------
    public static function login (Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion'
        ]);

        
    }

//SALIDA DE SESION----------------------
    public static function logout (){
        echo "desde logout";
        
    }

//CONTROLADOR CREAR CUENTAS --------------------------
    public static function crear (Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }

        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta'
        ]);
    }

//CONTROLADOR DE FORMULARIO DE OLVIDE MI CONTRASEÑA ------------------------
    public static function olvide (Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }

        $router->render('auth/olvide',[
            'titulo' => 'Olvide el password'
        ]);
        
    }

//CONTROLADOR PARA REESTABLECER LA CONTRASEÑA
    public static function reestablecer (Router $router){
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        }

        $router->render('auth/reestablecer',[
            'titulo' => 'Reestablecer'
        ]);

        
    }

    public static function mensaje (Router $router){

        $router->render('auth/mensaje',[
            'titulo' => 'Cuenta creada con exito'
        ]);

        
    }

    public static function confirmar (Router $router){
        $router->render('auth/confirmar',[
            'titulo' => 'Confirma tu cuenta UpTask'
        ]);

        
    }
}