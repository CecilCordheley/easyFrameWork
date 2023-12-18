<?php
#$template pour le template
#$vars pour les variables à remplacer
if (Query::hasPostValues()) {
    $vars->formTest = Query::get("test_name");
} else {
    $pattern="\n<div class='compoment'>\n".
    "\t<label for=\"[#ID#]\">[#label#]</label>\n".
    "\t<input  id=\"[#ID#]\" type=\"[#type#]\" name=\"[#name#]\" value=[#value#] [#required#]>\n".
    "</div>";
    $form = new FormBuilder(Server::GetSelF() . "?action=test", "POST",$pattern);
    $form->addCompoment([
        "ID" => "test",
        "type" => "text",
        'required'=>true,
        "className"=>"testClass",
        "name" => "test_name",
        "label"=>"Ici le nom"
    ])
    ->addCompoment([
        "ID"=>"checOne",
        "type"=>"checkbox",
        'name'=>"choice1",
        "value"=>"val1",
        "label"=>"choix N°1"
    ])
    
    ->addCompoment([
        "ID"=>"checkTwo",
        "type"=>"checkbox",
        'name'=>"choice1",
        "value"=>"val2" ,
        "label"=>"choix N°2"
    ])->addCompoment([
        "ID"=>"testSelect",
        "type"=>"select",
        "className"=>"classSelect",
        "name"=>"selectExemple",
        "label"=>"test Select",
        "multiple"=>true,
        "data"=>[
            [
                "val"=>0,
                "label"=>"option 1"
            ], [
                "val"=>1,
                "label"=>"option 2"
            ], [
                "val"=>2,
                "label"=>"option 3"
            ]
        ]
    ]);
    $vars->formTest = $form->generate(["submit"=>"<div><button class='submit'>Enregistrer</button></div>","reset"=>""]);
}