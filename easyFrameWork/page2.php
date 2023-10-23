<?php
require_once "_class/_master/autoload.class.php";
Autoloader::register();
Autoloader::callRequires();
Router::Init();
list(0 => $template, 1 => $vars) = easyFrameWork::createEasyTempate();
$vars=new EasyTemplate_variable();
$template->loop("mainMenu",Main::$Links);
$template->callTemplate("mainContent",Router::getTemplate());
include(Router::getCtrl());
Router::LoadStyles($template);
$template->loadDictionnary($vars);
$template->display();