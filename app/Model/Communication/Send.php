<?php

namespace App\Model\Communication;
require __DIR__.'/../../../bootstrap/app.php'; 
use \App\Model\Communication\EmailConfig;

$address = $_POST['address'];
$subject = $_POST['messageTitle'];
$body = $_POST['message'];
$attachment = $SendFile;

$obEmail = new EmailConfig;
$status = $obEmail->sendEmail($address,$subject,$body,$attachment);

$_SESSION['menssage_bar'] = ['message' => $status ? 'Mensagem enviada com sucesso' : '', 
                             'type' => $status ? 'success' : 'danger', 
                             'display' => $status ? 'block' : 'none', time()];