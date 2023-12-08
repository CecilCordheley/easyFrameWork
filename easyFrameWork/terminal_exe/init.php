<?php
require_once "_class/_master/autoload.class.php";
Autoloader::register();
Autoloader::callRequires();
Router::Init();
echo "---Initalize template config.ini---\n";
$configName = readline("ConfigName : ");
readline_add_history($configName);
$masterPage = readline("-- master Page : ");
while(explode(".",$masterPage)[1]!="tpl"){
    $masterPage = readline("Not a *.tpl page \n-- master Page : ");
}
readline_add_history($masterPage);
$templateDirectory = readline("-- template Directory : ");
$StyleDirectory = readline("-- Style Directory : ");
$JSDirectory = readline("-- js Directory : ");
$imageDirectory = readline("-- image Directory : ");
print_r(readline_list_history());