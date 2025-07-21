<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!$correo || empty($mensaje)) {
        echo "❌ Por favor, completa los campos correctamente.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'paulalexisbarahonafigueroa@gmail.com';   // TU CORREO
        $mail->Password   = 'qhug jyvu lofd wxdh';         // CLAVE DE APLICACIÓN
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Quién lo envía y a quién va
        $mail->setFrom('paulalexisbarahonafigueroa@gmail.com', 'Landing Web');
        $mail->addAddress('paulalexisbarahonafigueroa@gmail.com', 'Tú'); // SIEMPRE AL MISMO CORREO

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde tu landing page';
        $mail->Body = "
            <strong>Correo del visitante:</strong> {$correo}<br>
            <strong>Mensaje:</strong><br>" . nl2br($mensaje) . "
        ";

        $mail->send();

        header("Location: index.php?msg=enviado");
        exit;
    } catch (Exception $e) {
        echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}
