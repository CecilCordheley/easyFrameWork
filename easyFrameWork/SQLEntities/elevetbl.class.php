<?php
class EleveTbl
{
    private $attr = ["DATE_NAISSANCE" => '', "ID_ECOLE" => '', "ID_ELEVE" => '', "NOM_ELEVE" => '', "PRENOM_ELEVE" => ''];
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->attr)) {
            $this->attr[$name] = $value;
        } else {
            throw new Exception("Propriété non définie : $name");
        }
    }
    public function getArray()
    {
        return $this->attr;
    }
    public function __get($name)
    {
        if (array_key_exists($name, $this->attr)) {
            return $this->attr[$name];
        } else {
            throw new Exception("Propriété non définie : $name");
        }
    }
    public function getEcole($sqlF){
       return EcoleTbl::getEcoleTblBy($sqlF,"ID_ECOLE",$this->ID_ECOLE);
    }
    public static function add(SQLFactoryV2 $sqlF, EleveTbl $item)
    {
        $sqlF->addItem($item->getArray(), "eleve_tbl");
    }
    public static function update(SQLFactoryV2 $sqlF, EleveTbl $item)
    {
        $sqlF->updateItem($item->getArray(), "eleve_tbl");
    }
    public static function del(SQLFactoryV2 $sqlF, EleveTbl $item)
    {
        $sqlF->deleteItem($item->getArray(), "eleve_tbl");
    }
    public static function getEleveTblBy($sqlF, $key, $value)
    {
        $query = $sqlF->execQuery("SELECT * FROM eleve_tbl WHERE $key=$value");
        $return = [];
        foreach ($query as $element) {
            $entity = new EleveTbl();
            $entity->DATE_NAISSANCE = $element["DATE_NAISSANCE"];
            $entity->ID_ECOLE = $element["ID_ECOLE"];
            $entity->ID_ELEVE = $element["ID_ELEVE"];
            $entity->NOM_ELEVE = $element["NOM_ELEVE"];
            $entity->PRENOM_ELEVE = $element["PRENOM_ELEVE"];
            $return[] = $entity;
        }
        return (count($return) > 1) ? $return : $return[0];
    }
}