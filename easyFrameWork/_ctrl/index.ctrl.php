<?php
/*Ici les controle en PHP de la page */
$sqlF=new SQLFactoryV2();
if(sessionVar::get(["context"=>"private","name"=>"test"])){
    sessionVar::setPrivate("test","toto");
}else{
    sessionVar::setPrivate("test","titi");
}
$msg="test";
if(Query::hasPostValues())
    var_dump(Query::getAll());
$crypt=easyFrameWork::encrypt($msg,"123456");
$vars->msgCrypt=$crypt;
$vars->msgEncryp=easyFrameWork::decrypt($crypt,"123456");
$SQL2FROM=new SqlToForm($sqlF);
$SQL2V=new SQLtoView($sqlF,Router::getView()."/displayAcademi.view");
$index_array = [
    [
        "val" => "test 1"
    ],
    [
        "val" => "test 2"
    ]
];
$personne=[
    ["nom"=>"Enstein","prenom"=>"Albert"],
    ["nom"=>"Eluard","prenom"=>"Paul"],
    ["nom"=>"Poisson","prenom"=>"Reinette"],
    ["nom"=>"Ari","prenom"=>"Mata"]
    ];
    $template->loop("personne",$personne);
//var_dump($sqlF->getStorageFnc());
$param=["container"=>"<div class='academieList'>[...]</div>",
"query"=>"SELECT COUNT(ID_ECOLE) as NBECOLE, NOM_ACADEMIE FROM academie_tbl a LEFT JOIN ECOLE_TBL e ON a.ID_ACADEMIE=e.ID_ACADEMIE GROUP BY e.ID_ACADEMIE"];
$template->_view("academie",$SQL2V,$param);
//$vars->academie=$SQL2V->generate(["query"=>"SELECT * FROM academie_tbl"]);
//if(!isset($_GET["action"]))
//$vars->userForm=$SQL2FROM->generate(["URI"=>"addEleve.html","METHOD"=>"POST","ASSOC_FIELDS"=>["ID_ECOLE"=>"NOM_ECOLE"],"table"=>"eleve_tbl","label"=>true,"ignoreFields"=>["ID_ELEVE"]]);