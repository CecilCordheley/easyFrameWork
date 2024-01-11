<?php
//ici le code PHP de la page
#$template pour gérer le moteur
#$vars pour gérer les variables {var:???}
$files1 = array_reduce([
    "Main",
    "Autoloader",
    "easyFrameWork",
    "EasyTemplate_variable",
    "EasyTemplate_subtemplate",
    "EasyTemplate",
    "ErrorHandler",
    "LogFile",
    "Notifier",
    "Message", "Server", "Request", 
    "Query", "sessionVar", "Router",
    "SQLFactoryV2","SqlToElement","SqlToForm",
    "SQLtoView","FormBuilder","SqlEntities"
], function ($carry, $item) {
    $carry[]["className"] = $item;
    return $carry;
}, []);
$template->loop("classList", $files1);
if(isset($_GET["className"])){
    $oReflectionClass = new ReflectionClass($_GET["className"]);
    easyFrameWork::Debug($oReflectionClass->getDocComment());
}
