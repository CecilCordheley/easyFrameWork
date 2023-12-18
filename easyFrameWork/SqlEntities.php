<?php
session_start();

require_once "_class/_master/easyFrameWork.class.php";
/* Initialise le FrameWork et ses dépendances */
easyFrameWork::INIT();
$sqlF=new SQLFactoryV2();
//SqlEntities::generateEntity($sqlF,"ecole_tbl");
SqlEntities::LoadEntity("eleve_tbl");
SqlEntities::LoadEntity("ecole_tbl");
$eleve=new EleveTbl();
$eleve->NOM_ELEVE="ROLAND";
$eleve->PRENOM_ELEVE="CHABER";
$eleve->DATE_NAISSANCE="2006-12-18";
$eleve->ID_ECOLE="1";
//EleveTbl::add($sqlF,$eleve);
//var_dump($e);
$e=EleveTbl::getEleveTblBy($sqlF,"ID_ELEVE","1");
$ecole=$e->getEcole($sqlF);
easyFrameWork::Debug($ecole);