<?php

    include 'PHPMailer.php';
    include 'Exception.php';
    include 'SMTP.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    function posti($emailTo,$msg,$subject) {
        if (file_exists('../../../tunnukset.php')) include('../../tunnukset.php');
    
        $emailFrom = "omniakurssi@gmail.com";
        $emailFromName = "Ohjelmointikurssi";
        $emailToName = "";
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->SMTPSecure = 'tls'; 
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->setFrom($emailFrom, $emailFromName);
        $mail->addAddress($emailTo, $emailToName);
        $mail->Subject = $subject;
        $mail->msgHTML($msg); 
        $mail->AltBody = 'HTML messaging not supported';
    
        if(!@$mail->send()) {
             $tulos = false;
        } else {
    
             $tulos = true;
        }
        return $tulos;
    }