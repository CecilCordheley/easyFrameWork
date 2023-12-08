<?php
/**
 * Permet de générer des composant formulaire <form></form>
 */
class FormBuilder
{
    /**
     * @var $compoment ensemble des composant du formulaire
     */
    private array $compoment;
    private string $action;
    private string $method;
    private string $pattern;
    public function __construct($action, $method, $pattern = "")
    {
        $this->compoment = [];
        $this->action = $action;
        $this->method = $method;
        $this->pattern = $pattern ?? null;
    }
    public function addCompoment($param)
    {
        $this->compoment[$param["ID"]] = [
            "multiple"=>$param["multiple"]??false,
            "name" => $param["name"],
            "type" => $param["type"],
            "value" => $param["value"] ?? null,
            "label" => $param["label"] ?? $param["ID"],
            "data" => $param["data"] ?? null
        ];
        return $this;
    }
    public function generate()
    {
        $return = "<form action=[#action#] method=[#methode#]>[...]</form>";
        $return = str_replace("[#action#]", $this->action, $return);
        $return = str_replace("[#methode#]", $this->method, $return);
        $p = $this->pattern ?? "<label for=\"[#ID#]\">[#label#]</label><input  id=\"[#ID#]\" type=\"[#type#]\" name=\"[#name#]\" value=[#value#]>";
        array_walk($this->compoment, function ($item, $key) use (&$return, $p) {
            // var_dump($item);
            $compoment = $p . "\n\t";
            if ($item["type"] == "select") {
                $re = '/\<input.*?\>/m';
                //   $compoment = '<input type=[#type#]>';
                $subst = "<select name=[#name#] id=[#ID#] [#multiple#]>[#data#]</select>";
                $compoment = preg_replace($re, $subst, $compoment);
                
                    $m=($item["multiple"])?"multiple=".$item["multiple"]:"";
                $compoment = str_replace("[#multiple#]", $m, $compoment);
                foreach ($item['data'] as $data) {
                    $compoment = str_replace("[#data#]", "<option value=\"" . $data["val"] . "\">" . $data["label"] . "</option>[#data#]", $compoment);
                }
                $compoment = str_replace("[#data#]", "", $compoment);
            } else {
                $compoment = str_replace("[#value#]", $item["value"] ?? "", $compoment);
                $compoment = str_replace("[#type#]", $item["type"], $compoment);
            }
            $compoment = str_replace("[#label#]", $item["label"], $compoment);
            $compoment = str_replace("[#name#]", $item["name"], $compoment);

            $compoment = str_replace("[#ID#]", $key, $compoment);
            $return = str_replace("[...]", " $compoment [...]\n", $return);
        });
        $return = str_replace("[...]", "", $return);
        return $return;
    }
}