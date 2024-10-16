<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'linemx.tap@gmail.com';
        $mail->Password = 'mlzexcqdioqhzesx';
        $mail->SMTPSecure ='tls';

        //configurar el contenido del email
        $mail->setFrom('linemx.tap@gmail.com', 'Admin LineMx');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta'; 

        //setHTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong> Hola ". $this->nombre . "</strong> Has creado a tu cuenta en UpTask,
        solo deberás confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p> Presiona aquí  <a href='http://localhost:3000/confirmar?token=". $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p> Si tu no solicitaste este cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail ->Body = $contenido;

        //ENVIAR EL EMAIL
        $mail->send();
    }

    public function enviarInstrucciones(){
        //crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'linemx.tap@gmail.com';
        $mail->Password = 'mlzexcqdioqhzesx';
        $mail->SMTPSecure ='tls';

        //configurar el contenido del email
        $mail->setFrom('linemx.tap@gmail.com', 'Admin LineMx');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu contraseña'; 

        //setHTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong> Hola ". $this->nombre . "</strong> Reestablece a tu cuenta en UpTask,
        solo deberás continuar presionando el siguiente enlace</p>";
        $contenido .= "<p> Presiona aquí  <a href='http://localhost:3000/reestablecer?token=". $this->token . "'>Reestablecer cuenta</a></p>";
        $contenido .= "<p> Si tu no solicitaste este cuenta, puedes ignorar el mensaje </p>";
        $contenido .= "</html>";

        $mail ->Body = $contenido;

        //ENVIAR EL EMAIL
        $mail->send();
    }
}