<?php
/**
 * Classe principal pour les liens et les fonctions communes au projet
 */
abstract class Main{
    public static $links=[
        [
            "href"=>"index.php",
            "pageName"=>"Accueil"
        ],[
            "href"=>"showClasse.php",
            "pageName"=>"Voir les classes"
        ],[
            "href"=>"formBuilder_exemple.php",
            "pageName"=>"FormBuilder"
        ],[
            "href"=>"error.php",
            "pageName"=>"une erreur"
        ],[
            "href"=>"sqlEntities.php",
            "pageName"=>"SQL Entities"
        ]
    ];

    public const KEY="123@ijk";
}