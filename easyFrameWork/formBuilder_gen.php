<?php
require_once "_class/_master/autoload.class.php";
Autoloader::register();
Autoloader::callRequires();
Router::Init();
$pattern="\n<div class='compoment'>\n".
"\t<label for=\"[#ID#]\">[#label#]</label>\n".
"\t<input id=\"[#ID#]\" type=\"[#type#]\" name=\"[#name#]\" value=[#value#] [#required#]>\n".
"</div>";
$form = new FormBuilder("#?action=test", "POST",$pattern);
$form->addCompoment([
    "ID" => "nom",
    "type" => "text",
    "name" => "inputName",
    "value" => "valeur par défaut",
    "label" => "Ici le nom"
]);
echo htmlspecialchars(htmlentities($form->generate()));
