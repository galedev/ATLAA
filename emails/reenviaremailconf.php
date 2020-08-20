<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_POST['remail']) && !empty($_POST['remail']))
{
    $mail = new PHPMailer(false);
    $email = addslashes($_POST['remail']);
    $msg = "
            <!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Plataforma ATLAA de RPG de mesa!</title>
            </head>
            <body>
                <table align='center'>
                    <h3>Esse e-mail foi enviado para que você faça a ativação de seu cadastro, se você não solicitou, favor desconsiderar esse e-mail!</h3>
                    <a href='https://rpg.gale.net.br/emails/confiramarcadastro.php?email=".$email."&status=1' target='_blank' rel='noopener noreferrer'>Confirmar cadastro</a>
                </table>
            </body>
            </html>
    ";
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'mail.gale.net.br';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'noreplay@gale.net.br';                     // SMTP username
        $mail->Password   = 'abcd1234';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged. PHPMailer::ENCRYPTION_STARTTLS
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        //Recipients
        $mail->setFrom('noreplay@gale.net.br', 'PLataforma ATLAA de RPG');
        $mail->addAddress($email);
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = '[ATLAA] - Registro realizado com sucesso! - Ative sua conta';
        $mail->Body    = $msg;
        $mail->AltBody = $msg;
        if ($mail->send()) {
            echo "<div class='alert alert-success'>Verifique seu e-mail!";
        } else {
            echo "<div class='alert alert-danger'>E-mail Invalido!";
        }
    } catch (Exception $e) {
        echo "Email não enviado. Erro do Mailer: {$mail->ErrorInfo}";
    }

}
else {
    echo "<div class='alert alert-danger'>E-mail não encontrado!";
}