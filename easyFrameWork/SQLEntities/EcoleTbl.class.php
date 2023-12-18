<?php
 class EcoleTbl{
    private $attr=["CP_ECOLE"=>'',"ID_ACADEMIE"=>'',"ID_ECOLE"=>'',"NOM_ECOLE"=>'',"VILLE_ECOLE"=>''];
    public function __set($name,$value){
      if (array_key_exists($name, $this->attr)) {
         $this->attr[$name]=$value;
     } else {
         throw new Exception("Propriété non définie : $name");
     }
    }
    public function getArray(){
      return $this->attr;
    }
    public function __get($name){
      if (array_key_exists($name, $this->attr)) {
         return $this->attr[$name];
     } else {
         throw new Exception("Propriété non définie : $name");
     }
    }
    public static function  add(SQLFactoryV2 $sqlF,EcoleTbl $item){
      $sqlF->addItem($item->getArray(),"ecole_tbl");
    }
    public static function  update(SQLFactoryV2 $sqlF,EcoleTbl $item){
      $sqlF->updateItem($item->getArray(),"ecole_tbl");
    }
    public static function  del(SQLFactoryV2 $sqlF,EcoleTbl $item){
      $sqlF->deleteItem($item->getArray(),"ecole_tbl");
    }
    public static function getEcoleTblBy($sqlF,$key,$value){
      $query=$sqlF->execQuery("SELECT * FROM ecole_tbl WHERE $key=$value");
      $return=[];
      foreach($query as $element){
      $entity=new EcoleTbl();
         $entity->CP_ECOLE=$element["CP_ECOLE"];
$entity->ID_ACADEMIE=$element["ID_ACADEMIE"];
$entity->ID_ECOLE=$element["ID_ECOLE"];
$entity->NOM_ECOLE=$element["NOM_ECOLE"];
$entity->VILLE_ECOLE=$element["VILLE_ECOLE"];
      $return[]=$entity;
      }
     return (count($return)>1)?$return:$return[0];
    }
 }