<?php
        //https://www.espai.es/blog/2022/06/phpmailer-ya-no-envia-correos-a-traves-de-gmail/
        //https://codigosdeprogramacion.com/2022/04/05/enviar-correo-electronico-con-phpmailer/

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;

        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/SMTP.php';


    class Correo{        

        static function enviarCorreo($correo, $id){    

            try {
                $mail = new PHPMailer();
                //Configuración del servidor
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;             //Habilitar los mensajes de depuración
                $mail->isSMTP();                                   //Enviar usando SMTP
                $mail->Host       = 'smtp.gmail.com';            //Configurar el servidor SMTP
                $mail->SMTPAuth   = true;                          //Habilitar autenticación SMTP
                $mail->Username   = 'auxiliardaw2@gmail.com';            //Nombre de usuario SMTP
                $mail->Password   = 'yjiivqqdpwuiisev';                      //Contraseña SMTP
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Habilitar el cifrado TLS
                $mail->Port       = 465;                           //Puerto TCP al que conectarse; use 587 si configuró `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Emisor
                $mail->setFrom('auxiliardaw2@gmail.com', 'Fernando Aranzabe');
            
                //Destinatarios
                $mail->addAddress($correo, 'Miriam Usuario Destino');     //Añadir un destinatario, el nombre es opcional
            
                //Destinatarios opcionales
                // $mail->addReplyTo('info@example.com', 'Information');  //Responder a
                // $mail->addCC('cc@example.com');                        //Copia pública
                // $mail->addBCC('bcc@example.com');                      //Copia oculta
            
                //Archivos adjuntos
                // $mail->addAttachment('files/comunicado.pdf', 'Comunicado');         //Agregar archivos adjuntos, nombre opcional
            
                //Nombre opcional
                $mail->isHTML(true);                         //Establecer el formato de correo electrónico en HTMl
                $mail->Subject = 'Asunto';             
                $mail->Body    = '¡Bienvenido jugador. Pulse el siguiente <a href="http://127.0.0.1:8090/verificar/'.$id.'">link</a> para verificar tu cuenta';
                $mail->AltBody = 'Este es el cuerpo en texto sin formato para clientes de correo que no son HTML';
            
                $mail->send();    //Enviar correo eletrónico
            } catch (Exception $e) {
            }
        }
    }
?>