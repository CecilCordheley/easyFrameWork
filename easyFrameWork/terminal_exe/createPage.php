<?php
/*Utiliser ce fichier via un terminal PHP */
require_once "../_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT("../_class/_master", "../include/router.json");
Router::Init("../include/router.json");

echo "-- Création d'une nouvelle page PHP ainsi que les dépendances\n";
$name = readline("Nom de la page *.php: ");
do{
    echo "-- Le nom de la page ne peut être null\n";
    $name = readline("Nom de la page *.php: ");
}while($name=="");
$tpltName = readline("Template principal de la page *.tpl: ");
$ctrl = readline("fichier controle *ctrl.php : ");
$addStyle = readline("Ajouter un fichier CSS 1 -OUI 0- NON : ");
$styleA = [];
do {
    $style = readline("fichier CSS *.css: ");

    $styleA[] = $style;
    $addStyle = readline("Ajouter un fichier CSS 1 -OUI 0- NON : ");
} while ($addStyle == "1");
$content = file_get_contents("modele_page");
$a = [];
$a["template"] = $tpltName;
$a["ctrl"] = $ctrl;
$a["style"] = $styleA;
Router::addRouterInfo($name, $a);

file_put_contents("../$name", $content);