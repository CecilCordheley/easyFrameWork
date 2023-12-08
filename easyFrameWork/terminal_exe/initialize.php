<?php
echo "INITIALIZE DIRECTORIES";
$i = 0;
$dirs = ["_template2", "_js2", "_css2", "_ctrl2"];
$css = "";
$js = "";
$master = file_get_contents("masterPage");
while ($i < count($dirs)) {
    passthru('cls');
    echo "\ncreate [" . $dirs[$i] . "] directory";
    if (!mkdir("../" . $dirs[$i], 0777, true)) {
        die('Failed to create directories...');
    }
    if ($i == 0) {
        
        echo "\nY a t-il un fichier CSS de base ? [Y-N]";
        $rep = readline();
        if ($rep == "Y") {
            echo "\nNom du fichier CSS ? : ";
            $css = readline();
        }
        echo "\nY a t-il un fichier JS de base ? [Y-N]";
        $rep = readline();
        if ($rep == "Y") {
            echo "\nNom du fichier JS ? : ";
            $js = readline();
        }


        
    }
    if ($i == 1) {
        if ($js != "") {
            echo "\nPut $js in " . $dirs[$i];
            file_put_contents('../' .  $dirs[$i] . '/' . $js, "//Votre fichier JS de base");
            $master = str_replace("[MAINJS]", "<script src=\"./" .  $dirs[$i] . "/$js\"></script>", $master);
        } else {
            $master = str_replace("[MAINJS]", "", $master);
        }
    }
    if ($i == 2) {
        if ($css != "") {
            echo "\nPut $css in " . $dirs[$i];
            file_put_contents('../' . $dirs[$i] . '/' . $css, "\/* Votre fichier CSS de base *\/");
            $master = str_replace("[MAINCSS]", "<link rel=\"stylesheet\" href=\"./" . $dirs[$i] . "/$css\">", $master);
        } else {
            $master = str_replace("[MAINCSS]", "", $master);
        }
    }
    $i++;
    sleep(1);
}
file_put_contents('../' . $dirs[0] . '/master.tpl', $master);
echo " - END OF FIRST INIT";
readline_clear_history();
echo "- INITIALIZE ";