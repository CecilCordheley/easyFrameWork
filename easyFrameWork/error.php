<?php
require_once "_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT();
$b=MaClass();
//echo $b;
$fatals=ErrorHandler::getFatalError();
var_dump(explode('\n',$fatals));