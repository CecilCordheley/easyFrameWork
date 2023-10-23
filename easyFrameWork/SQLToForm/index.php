<?php
require_once "../_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT("../_class/_master", "../include/router.json");
$ini=easyFrameWork::getParams("BDD","../include/config.ini");
//$PDO = new PDO('mysql:host='.$ini["host"].';dbname='.$ini["bdd"], $ini["user"], $ini["mdp"]);
$sqlF=new SQLFactoryV2(null,"../include/config.ini");
$SQL2V=new SqlToView($sqlF);
$param=[];
$param["query"]="SELECT COUNT(*) as compte, NOM_ACADEMIE FROM ecole_tbl e INNER JOIN academie_tbl a ON a.ID_ACADEMIE=e.ID_ACADEMIE_ACADEMIE_TBL GROUP BY NOM_ACADEMIE";
$param["view"]="<li>#compte# / #NOM_ACADEMIE#</li>";
$param["container"]="<ul>[...]</<ul>";
echo $SQL2V->generate($param);
