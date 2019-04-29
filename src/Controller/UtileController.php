<?php
/**
 * Created by PhpStorm.
 * User: amine
 * Date: 06/04/2019
 * Time: 08:04
 */

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UtileController
{

    public static function saveImage($dir = "Public/Images", $data)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                return false;
            }

            $data = base64_decode($data);

            if ($data === false) {
                return false;
            }
        } else {
            return false;
        }

        $name = uniqid('', true);
        $path = "$dir/$name.$type";

        $saved = file_put_contents($path, $data);

        return array("saved" => ($saved != false), "path" => $path);

    }


    public static function sendMail($fullName, $to, $subject="", $content)
    {

        $mail = new PHPMailer(true);

        try {

            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = 'mail.sawemli.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'admin@sawemli.com';                     // SMTP username
            $mail->Password = 'Admin_sawem123';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
//            $mail->From = "admin@sawemli.com";
//            $mail->FromName = "Sawemli";
            $mail->setFrom('admin@sawemli.com', 'Sawemli');
            $mail->addAddress($to, $fullName);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $content;
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}