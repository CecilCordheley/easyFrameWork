<?php
/**
 * permet de gérer les variable du moteur de template
 * @author Cecil Cordheley
 */
class EasyTemplate_variable {
    /**
     *
     * @var array
     */
    private $array;
    /**
     * Instancie le dictionnaire de variable
     */
    public function __construct(){
        $this->array=array();
    }
   /**
    * Magic method to set variables
    * @param string $name
    * @param mixed $value
    */
    public function __set($name,$value){
        $this->array['var'][$name]=$value;
    }
  /**
   * Magic method to get variable value
   * @param string $key
   */
    public function __get($key){
        if(isset($this->array['var'][$key])){
            return $this->array['var'][$key];
        }else
            return null;
    }
}
/**
 * N'est plus implémenté
 */
class EasyTemplate_subtemplate{
    /**
     *
     * @var array
     */
    private $array;
    
    public function __construct(){
        $this->array=array();
    }
   
    public function __set($name,$value){
        $this->array['stpl'][$name]=$value;
    }
    public function __get($key){
        if(isset($this->array['stpl'][$key])){
            return $this->array['stpl'][$key];
        }else
            return null;
    }
}
?>
