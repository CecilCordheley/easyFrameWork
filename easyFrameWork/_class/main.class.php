<?php
/**
 * Ensemble des fonctions communes au projet
 */
abstract class Main{
    public static $links=[
        [
            "href"=>"index.php",
            "pageName"=>"Acceuil"
        ],[
            "href"=>"ecole.php",
            "pageName"=>"Ecoles"
        ],[
            "href"=>"formBuilder_exemple.php",
            "pageName"=>"FormBuilder"
        ],[
            "href"=>"error.php",
            "pageName"=>"une erreur"
        ]
    ];
   
    public const KEY="123@ijk";
}