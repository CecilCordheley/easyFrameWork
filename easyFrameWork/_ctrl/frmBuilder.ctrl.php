<?php
#$template pour le template
#$vars pour les variables à remplacer
if (Query::hasPostValues()) {
    $vars->formTest = Query::get("test_name");
} else {
    $pattenr="\n<div class='compoment'>\n".
    "\t<label for=\"[#ID#]\">[#label#]</label>\n".
    "\t<input  id=\"[#ID#]\" type=\"[#type#]\" name=\"[#name#]\" value=[#value#]>\n".
    "</div>";
    $form = new FormBuilder(Server::GetSelF() . "?action=test", "POST",$pattenr);
    $form->addCompoment([
        "ID" => "test",
        "type" => "text",
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
    $vars->formTest = $form->generate();
}