<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
class mailController{
    public function sendMail($subject, $body, $altBody, $mail_ = 'trianajuan970@gmail.com'){
        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 2;  // Sacar esta línea para no mostrar salida debug
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Host de conexión SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'pruebamailgprogramation@gmail.com';                 // Usuario SMTP
            $mail->Password = '12345678Abc.';                           // Password SMTP
            $mail->SMTPSecure = 'ssl';                            // Activar seguridad TLS
            $mail->Port = 465;                                    // Puerto SMTP
         
            $mail->setFrom('pruebamailgprogramation@gmail.com');		// Mail del remitente
            $mail->addAddress($mail_);     // Mail del destinatario
         
            $mail->isHTML(true);
            $mail->Subject = $subject;  // Asunto del mensaje
            $mail->Body    = $body;    // Contenido del mensaje (acepta HTML)
            $mail->AltBody = $altBody;    // Contenido del mensaje alternativo (texto plano)
         
            $mail->send();
            return json_encode(array('status' => 200, 'message' => 'El mensaje se envio correctamente.'));
        } catch (Exception $e) {
            return json_encode(array('status' => 501, 'message' => 'El mensaje no se ha podido enviar, error: '. $mail->ErrorInfo));
        }
    }
}