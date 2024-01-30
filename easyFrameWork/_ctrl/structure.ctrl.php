<?php
//ici le code PHP de la page
#$template pour gérer le moteur
#$vars pour gérer les variables {var:???}
function isDir($dir){
    return count(explode(".",$dir))==0;
}
$a = array_reduce(scandir("../easyFrameWork"), function ($c, $item) {
    if (is_dir($item)  && $item != ".." && $item != ".")
        $c[] = ["NOM" => $item];
    return $c;
}, []);
$template->loop("structures", $a);
