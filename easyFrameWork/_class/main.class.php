<?php
    class Main{
        public static $Links=[
            ["href"=>"index.php","name"=>"Accueil"],
            ["href"=>"cours.php","name"=>"cours"],
            ["href"=>"quizz.php","name"=>"Quizz"]
        ];
        public static $meta=[
            ["name"=>"description","content"=>"test"]
        ];
        /**
         * Permet de modifier le contenu d'une balise Meta
         */
        public static function setMeta($name,$value){
            $b=false;
            $i=0;
            while($i<count(self::$meta) && !$b){
                $b=(self::$meta[$i]["name"]==$name);
                $i++;
            }
            if($b){
                self::$meta[$i]["content"]=$value;
            }
        }
    }
?>