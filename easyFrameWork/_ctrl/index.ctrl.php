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
//var_dump($sqlF->getStorageFnc());
$param=["container"=>"<div class='academieList'>[...]</div>",
"query"=>"SELECT NOM_ELEVE, PRENOM_ELEVE, NOM_ECOLE FROM eleve_tbl e1 LEFT JOIN ECOLE_TBL e2 ON e1.ID_ECOLE=e2.ID_ECOLE",
"callback"=>function($item,$previous,$defaultString){
    if($previous==null || $previous["NOM_ECOLE"]!=$item["NOM_ECOLE"])
        return "<h3>#NOM_ECOLE#</h3>$defaultString";
    else
        return $defaultString;
}];
$vars->str=easyFrameWork::getMicroTemplate("testTpl");
$vars->POP="test";
function test($a,$b):int{
    echo "$a/$b";
    return ($a+$b);
}
var_dump(easyFrameWork::testClassMethode(MaClass::class."::test",11,[]));
function pop():string{
    return "TEST";
}


//$template->_view("academie",$SQL2V,$param);
//$vars->academie=$SQL2V->generate(["query"=>"SELECT * FROM academie_tbl"]);
//if(!isset($_GET["action"]))
//$vars->userForm=$SQL2FROM->generate(["URI"=>"addEleve.html","METHOD"=>"POST","ASSOC_FIELDS"=>["ID_ECOLE"=>"NOM_ECOLE"],"table"=>"eleve_tbl","label"=>true,"ignoreFields"=>["ID_ELEVE"]]);