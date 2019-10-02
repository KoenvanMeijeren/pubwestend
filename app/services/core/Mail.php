<?php


namespace App\services\core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\services\Settings;

class Mail
{
    /**
     * Send a new mail.
     *
     * @param string $email
     * @param string $name
     * @param string $subject
     * @param string $htmlBody
     * @param string $altBody
     * @return bool
     */
    public static function send(string $email, string $name, string $subject, string $htmlBody, string $altBody)
    {
        $mail = new PHPMailer(true);
        try {
            // server settings
            if (Config::get('mailDebug') === true) {
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host = Config::get('mailHost');
                $mail->SMTPAuth = true;
                $mail->Username = Config::get('mailUsername');
                $mail->Password = Config::get('mailPassword');
                $mail->SMTPSecure = 'tls';
                $mail->Port = Config::get('mailPort');
            }

            //Recipients
            $mail->setFrom(Settings::get('companyEmail'), Settings::get('companyName'));
            $mail->addAddress($email, $name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $altBody;

            $mail->send();

            return true;
        } catch (Exception $e) {
            Log::exception('Mailer error: ' . $mail->ErrorInfo);

            return false;
        }
    }
}