<?php
session_start();
require_once "_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT();
/* Initialise le moteur de template et son dictionnaire */
$template = new easyTemplate();
$vars = new EasyTemplate_variable();

Router::setMainTemplate($template, "mainContent"); // <-- charge le contenu spe de la page
include(Router::getCtrl());//<-- controle "la partie code" de la page 
Router::LoadStyles($template);
$template->loadDictionnary($vars);
$template->display();
