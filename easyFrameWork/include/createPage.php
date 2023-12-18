<?php
require_once "../_class/_master/autoload.class.php";
Autoloader::register();
Autoloader::callRequires();
Router::Init();
echo "-- Création d'une nouvelle page PHP";
$name = readline("PageName : ");
