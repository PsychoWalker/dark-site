<?php
require_once __DIR__ . '/PHPMailer/PHPMailerAutoload.php';

function custom_mail($to, $subject, $message, $addh = "", $addp = "")
{

    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsHTML(false);
        //$mail->SMTPDebug  = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $mail->IsSMTP();
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->Host = "relay.webdev-test.ru";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Username = "sitev5@relay.webdev-test.ru";
        $mail->Password = "4r2w3e1qA";
        $mail->SetFrom('sitev5@relay.webdev-test.ru', 'sitev5');
        $mail->AddAddress($to);
        $mail->Body = $message;
        $mail->Subject = $subject;
        $arr = explode("\n", $addh);
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $arrr = explode(":", $value);
                $addh = $mail->HeaderLine($arrr[0], $arrr[1]);
                if ($arrr[0] == 'Content-Type') $mail->ContentType = $arrr[1];
            }
        }
        $status = $mail->Send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $status;
}

