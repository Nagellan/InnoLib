<?php // sending an email
    function send_email($login, $title, $body){ // function of sending an email
        require_once('phpmailer/PHPMailerAutoload.php');
        $mail = new PHPMailer;
        $mail->CharSet = 'utf-8';
        
        $mail->isSMTP();  // set mailer to use SMT
        $mail->Host = 'smtp.mail.ru'; // specify main and backup SMTP servers
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->Username = 'innolib@mail.ru'; // login from the mail from which letters will be sent
        $mail->Password = 'kukuruza228'; // password from the mail from which letters will be sent
        $mail->SMTPSecure = 'ssl';  
        $mail->Port = 465; // TCP port to connect
        
        $mail->setFrom('innolib@mail.ru'); // mail from which letters will be sent
        $mail->addAddress($login); // email of a user 
        $mail->isHTML(true); // set email format to HTML
        
        $mail->Subject = $title;
        $mail->Body    = $body;
        $mail->AltBody = '';
        
        $mail->send();
    }
?>