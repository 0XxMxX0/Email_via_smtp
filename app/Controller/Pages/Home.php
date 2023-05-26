<?php

namespace App\Controller\Pages;
session_start();
use \App\Utils\View;

class Home extends Page{

    public static function getHome(){
        
        if(isset($_SESSION['menssage_bar'])){

            if($_SESSION['menssage_bar']['display'] != 'none' && (time() - $_SESSION['menssage_bar']['time'])/60 > 0.01){
                session_destroy();
                header('Location: index.php');
            }
        }

        if(isset($_POST['btn-send'])){

            if($_POST['address'] != '' AND $_POST['messageTitle'] != '' AND  $_POST['message'] != ''){
                
                if($_FILES['file']['error'] != 4){
                    
                    $count = 0;
                    while($count < count($_FILES['file']['name'])){
                        
                        $extensionsAllowed = array('png','jpg','pdf');
                        $extension = pathinfo($_FILES['file']['name'][$count], PATHINFO_EXTENSION);
                        if(in_array($extension, $extensionsAllowed)){
                            $folder = __DIR__.'/../../Resources/archives/';
                            $fileTemp = $_FILES['file']['tmp_name'][$count];
                            
                            if(move_uploaded_file($fileTemp, $folder.$_FILES['file']['name'][$count])){
                                $SendFile[] = $folder.$_FILES['file']['name'][$count];
                            } else {
                                $_SESSION['menssage_bar']  = ['message' => 'Arquivo não enviado!', 'type' => 'danger', 'display' => 'block', 'time' => time()];
                            }
                        } else {
                            $_SESSION['menssage_bar']  = ['message' => 'Formato de arquivo não permitido!', 'type' => 'warning', 'display' => 'block', 'time' => time()];
                        }
                        $count++;
                    } 

                } else {
                    $SendFile = [];
                }
                include 'app/Model/Communication/Send.php'; 
            } else {
                $_SESSION['menssage_bar']  = ['message' => 'Os campos não podem esta vazios!', 'type' => 'warning', 'display' => 'block', 'time' => time()];
            }
            header('Location: index.php');
        }

        function getSessionMenssageBar($key, $dafault = ''){
            return isset($_SESSION['menssage_bar'][$key]) ? $_SESSION['menssage_bar'][$key] : $dafault;
        }

        $content = View::render('pages/home',[
            'message' => getSessionMenssageBar('message'),
            'message-type' => getSessionMenssageBar('type'),
            'display' => getSessionMenssageBar('display', 'none')
        ]);
        return parent::getPage('Home', $content);
    }
}