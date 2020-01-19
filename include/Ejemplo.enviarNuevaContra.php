<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception; 
    
    /* Exception class. */
    require 'PHP MAILER\PHPMailer-master\src\Exception.php';
    
    /* The main PHPMailer class. */
    require 'PHP MAILER\PHPMailer-master\src\PHPMailer.php';
    
    /* SMTP class, needed if you want to use SMTP. */
    require 'PHP MAILER\PHPMailer-master\src\SMTP.php';

    $mail = new PHPMailer(TRUE);

    try {
    $mail->setFrom("email origen", "Administrador Web");
    $mail->addAddress($correo, 'Sr. usuario');
    $mail->Subject = "Generador de claves";
    $mail->Body = "Su nueva contraseña: $contra";
     
    /* SMTP parameters. */
    /* Tells PHPMailer to use SMTP. */
    $mail->isSMTP();
    
    /* SMTP server address. */
    $mail->Host = 'smtp.gmail.com';
    
    /* Use SMTP authentication. */
    $mail->SMTPAuth = TRUE;
    
    /* Set the encryption system. */
    $mail->SMTPSecure = 'tls';
   // $mail->SMTPDebug = 2; 
    
    /* SMTP authentication username. */
    $mail->Username = "email origen";
    
    /* PASSWORDS */
    $mail->Password = "password email origen";
    
    /*
    Hay que habilitar el uso de aplicaciones menos seguras
    https://myaccount.google.com/u/0/lesssecureapps?pli=1
    */
    /* configurar puerto SMTP */
    $mail->Port = 587;
    
    /* Enviar email */
    $mail->send();
    //el mensaje se ha enviado correctamente
    $_SESSION['mensaje1'] = "Nueva contraseña generada correctamente";
    $_SESSION['mensaje2'] = "En unos momentos recibirá su nueva clave por correo.";
    //cifro la clave generada para hacer update
    $contra = md5($contra);
    $consulta2 = "UPDATE usuario SET contra = '" . $contra . "' WHERE nombreUsuario = '" . $nombreUsuario . "' AND correo = '" . $correo . "'"; 
    mysqli_query($mysqli, $consulta2);
    
    //vuelta a login
    redireccion('iniciarSesion.php');
    }
    catch (Exception $e)
    {
        //el mensaje no se ha enviado correctamente
        $_SESSION["mensaje1"] = "No se ha podido enviar el mensaje con su nueva clave";
        $_SESSION["mensaje2"] = "Puede volver a intentarlo en unos minutos.";
        mysqli_close($mysqli);
        //Da error, volver a intentar
        echo $e->errorMessage();
        echo $e->getMessage();
        redireccion('iniciarSesion.php');
    }