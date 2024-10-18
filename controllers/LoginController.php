<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
//CONTROLADOR DE LOGIN---------------------------------
    public static function login (Router $router){
        $alertas= [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);

            $alertas= $usuario->validarLogin();

            if(empty($alertas)){
                //verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                if(!$usuario || !$usuario->confirmado){
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }else{
                    //el usuario existe
                    if(password_verify($_POST['password'], $usuario->password)){
                        //iniciar sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //redireccionar
                        header('Location: /dashboard');
                    }else{
                        Usuario::setAlerta('error', 'Contraseña incorrecta');
                    }
                }
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);

        
    }

//SALIDA DE SESION----------------------
    public static function logout (){
        session_start();
        $_SESSION = [];
        header('Location: /');
        
    }

//CONTROLADOR CREAR CUENTAS --------------------------
    public static function crear (Router $router){
        $alertas = [];
        $usuario = new Usuario;


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();


            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
            
                if($existeUsuario){
                    Usuario::setAlerta('error', 'El usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                }else{

                    //hashear el password
                    $usuario->hashPassword();

                    //eliminar password 2
                    unset($usuario->password2);

                    //generar el token
                    $usuario->generarToken();

                    //usuario confirmado

                    //crear un nuevo usuario
                    $resultado = $usuario->guardar();

                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();


                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            }
            
            
            
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

//CONTROLADOR DE FORMULARIO DE OLVIDE MI CONTRASEÑA ------------------------
    public static function olvide (Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();


            if(empty($alertas)){
                //buscar el usuario y generar un nuevo token para enviarle instrucciones
                $usuario = Usuario::where('email', $usuario->email);
                if($usuario && $usuario->confirmado === "1"){
                    //encontro el user
                    //generar nuevo token
                    $usuario->generarToken();
                    unset($usuario->password2);

                    //actualizar usuario
                    $usuario->guardar();

                    //enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email ');
                    

                    
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    
                }
                
            }
        }

        $alertas = Usuario::getAlertas();

        

        $router->render('auth/olvide',[
            'titulo' => 'Olvide el password',
            'alertas' => $alertas
        ]);
        
    }

//CONTROLADOR PARA REESTABLECER LA CONTRASEÑA
    public static function reestablecer (Router $router){
        $token = s($_GET['token']);
        $mostrar = true;
        if(!$token) header ('Location: /');

        //identificar el usuarii
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $mostrar = false;
        }
        
        $alertas = Usuario::getAlertas();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //añadir el nuevo password
            $usuario->sincronizar($_POST);

            //validar el password
            $alertas = $usuario->validarPassword();
            if(empty($alertas)){
                //hashear el nuevo password
                $usuario->hashPassword();
                //eliminar el token
                $usuario->token = '';
                //guardar el usuario en la db
                $resultado = $usuario->guardar();
                //redireccionar
                if($resultado){
                    header('Location: /');
                }

                
            }
            
        }

        $router->render('auth/reestablecer',[
            'titulo' => 'Reestablecer',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);

        
    }

    public static function mensaje (Router $router){

        $router->render('auth/mensaje',[
            'titulo' => 'Cuenta creada con exito'
        ]);

        
    }

    public static function confirmar (Router $router){
        $token = s($_GET['token']);
        $alertas = [];
        
        if(!$token) header('Location: /');

        //encontrar al usuario con este token

        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)){
            //no se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token no valido');
        }else{
            //confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            //guardar en la base de datos
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();



        $router->render('auth/confirmar',[
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);

        
    }
}