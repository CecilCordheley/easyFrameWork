<?php
require_once "_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT();
set_error_handler("myErrorHandler");
try{
$a=1/0;
}catch(errorHandler $e){
    $e->customFunction();
}catch(Throwable $e){
    echo $e->getMessage();
}