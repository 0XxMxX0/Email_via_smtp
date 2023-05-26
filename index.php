<?php
// Includindo o arquivo App.php que esta dentro da pasta Bootstrap;
// Ele será responsavel por exibir as dependencias mais usadas.
require __DIR__.'/bootstrap/app.php'; 
use \App\Controller\Pages\Home;

echo Home::getHome();