<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

require '../vendor/autoload.php';




class MailerController extends AbstractController
{
    /**
     * @param string $token
     */
    public function sendEmailOnRegistration(string $token)
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $_ENV['MAILER_SERVER'];                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_ENV['MAILER_MAIL'];                     // SMTP username
            $mail->Password   = $_ENV['MAILER_PASSWORD'];                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($_ENV['MAILER_MAIL'], 'Pierre');
            $mail->addAddress($_ENV['MAILER_MAIL'], 'PierreRec');     // Add a recipient

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = "This is the HTML message body <b>in bold!</b> {$token}";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Email non envoyé. Mailer Error: {$mail->ErrorInfo} ; contactez un administrateur";
        }
        finally{
            return $this->render('inscription/accepte.html.twig');
        }
    }
}
