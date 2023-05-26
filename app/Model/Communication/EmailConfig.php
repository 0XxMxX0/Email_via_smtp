<?php

namespace App\Model\Communication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EmailConfig {

    private $error;

    public function getError(){
        return $this->error;
    }

    public function sendEmail($addresses, $subject,$body,$attachments = [], $ccs = [], $bccs = []){
       
        $this->error = '';
        try{

            $obMail = new PHPMailer;
            $obMail->isSMTP();
            $obMail->Host = getenv('SMTP_HOST');
            $obMail->SMTPAuth = true;
            $obMail->Username = getenv('SMTP_USER');
            $obMail->Password = getenv('SMTP_PASS');
            $obMail->SMTPSecure = getenv('SMTP_SECURE');
            $obMail->Port = getenv('SMTP_PORT');
            $obMail->CharSet = getenv('SMTP_CHARSET');

            $obMail->setFrom(getenv('SMTP_FROM_EMAIL'), getenv('SMTP_FROM_NAME'));

            $addresses = is_array($addresses) ? $addresses : [$addresses];
            foreach($addresses as $address){
                $obMail->addAddress($address);
            }
            
            $attachments = is_array($attachments) ? $attachments : [$attachments];
            foreach($attachments as $attachment){
                $obMail->addAttachment($attachment);
            }
            
            $ccs = is_array($ccs) ? $ccs : [$ccs];
            foreach($ccs as $cc){
                $obMail->addAttachment($cc);
            }

            $bccs = is_array($bccs) ? $bccs : [$bccs];
            foreach($bccs as $bcc){
                $obMail->addAttachment($bcc);
            }

            $obMail->isHTML(true);
            $obMail->Subject = $subject;
            $obMail->Body = $body;
            return $obMail->send();

        } catch(PHPMailerException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }
}