<?php
//ici le code PHP de la page
#$template pour gérer le moteur
#$vars pour gérer les variables {var:???}
$files1 = array_reduce([
    "Main",
    "Autoloader",
    "easyFrameWork",
    "EasyTemplate_variable",
    "EasyTemplate",
    "ErrorHandler",
    "LogFile",
    "Notifier",
    "Message", "Server", "Request",
    "Query", "sessionVar", "Router",
    "SQLFactoryV2", "SqlToElement", "SqlToForm",
    "SQLtoView", "FormBuilder", "SqlEntities"
], function ($carry, $item) {
    $carry[]["className"] = $item;
    return $carry;
}, []);
$template->loop("classList", $files1);
if (isset($_GET["className"])) {
    $vars->className=$_GET["className"];
    $vars->title=" classe ".$_GET["className"];
    $oReflectionClass = new ReflectionClass($_GET["className"]);
    $i = 0;
    $pattern = '/\/\*\*\s*\n\s*\*\s*(.*?)\n\s*\*\//s';
    $comment=$oReflectionClass->getDocComment();
    preg_match($pattern, $comment, $matches);

    $vars->descClass= isset($matches[1]) ? trim($matches[1]) : '';

    $methods = array_reduce($oReflectionClass->getMethods(), function ($carry, $el) use (&$i) {
        $constructor = new ReflectionMethod($_GET["className"], $el->name);
        $carry[$i]["name"] = $el->name;
        $comment = $constructor->getDocComment();
        //Description
        $re = '/\*(.*?)\*/mis';
        preg_match_all($re, $comment, $matches, PREG_SET_ORDER, 0);
        if (isset($matches[1])) {
      //      var_dump($matches[1]);
            $carry[$i]["desc"] = str_replace("{","&#123;",$matches[1][1]);
        } else
            $carry[$i]["desc"] = "";
            $re="/\@param ([a-zA-Z]*) (.*?)$/mi";
            $params="";
            preg_match_all($re, $constructor->getDocComment(), $matches, PREG_SET_ORDER, 0);
            if(count($matches)){
                $a=[];
                foreach($matches as $m){
                //    easyFrameWork::Debug($m);
                    $a[]="<li><strong>".$m[1]."</strong> ".$m[2]."</li>";
                }
                $params="<ul>".implode($a)."</ul>";
            }
            $carry[$i]["params"] = $params;
        $carry[$i]["index"] = $i;
        $i++;
        return $carry;
    }, []);
    // easyFrameWork::Debug($methods);
    $template->addScript("window.onload=function(){

    }");
    $template->loop("method", $methods);
}
