<?php

/**
 * Description of EasyScript
 *
 * @author Sébastien DAMART
 */
class EasyTemplate {

    /**
     * Configuration
     * @var Array 
     */
    private $config;

    /**
     * poid en Bytes
     * @var int
     */
    private $size;

    /**
     * contenu courant
     * @var string 
     */
    private $content;

    /**
     * Dictionnaire 
     * @var Array 
     */
    private $dictionnary;

    /**
     * ensemble des évenements dans génération de la page
     * @var Array
     */
    private $events;

    /**
     * Instancie un nouveau template
     * @param string $configName Nom de la configuration (par défault :"config"
     */
    public function __construct($configName = "config") {
        $ini = parse_ini_file("include/config.ini", true);
        $this->config = $ini[$configName];
        $this->size = 0;
        $this->load();
        $this->events = Array();
    }

    /**
     * Remplace le contenu d'une boucle par une variable
     * @param string $key
     * @param string $value
     */
    public function ReplaceLoopAsVariable($key, $value) {
        $pattern = "\\{LOOP:$key\\}(.*?)\\{\\/LOOP\\}";
        $this->content = preg_replace("/$pattern/is", $value, $this->content);
    }

    /**
     * Permet de charger la configuration du template 
     */
    private function load() {
        $this->content = file_get_contents($this->config['templateDirectory'] . "/" . $this->config['masterPage']);
    }

    public function switchMaster($master_template) {
        $this->size = 0;
        $this->content = file_get_contents($this->config['templateDirectory'] . "/" . $master_template);
    }

    /**
     * 
     * @param OnPageGenerate $fnc
     */
    public function addEvent($fnc) {
        $this->events[] = $fnc;
    }

    /**
     * permet de charger plusieurs bibliothèque JS ou CSS
     * @param array $array esembles des librairies
     */
    public function libraries($array) {
        foreach ($array as $lib) {
            $this->loadScript($lib);
        }
    }

    /**
     * Charge un dictionnaire 
     * @param array $dictionnary 
     */
    public function loadDictionnary($dictionnary) {
        $this->dictionnary = $dictionnary;
    }

    /**
     * Retourne le tableau des variable présentes sur le template
     * @return Array 
     */
    public function getVariableArray() {
        $array = array();

        if (preg_match_all("/\\{var:(.*?)\\}/is", $this->content, $matches)) {
            $i = 0;

            foreach ($matches[1] as $m) {

                $tabName = explode(".", $m);
                if (count($tabName) > 1) {
                    $array['array'][$i]['key'] = $tabName[0] . "." . $tabName[1];
                    $v = $this->dictionnary->__get($tabName[0]);
                    // echo $v[$tabName[1]];
                    if (isset($v[$tabName[1]]))
                        $array['array'][$i]['value'] = htmlentities($v[$tabName[1]]);
                    else
                        $array['array'][$i]['value'] = "";
                } else {
                    $array['variable'][$i]['key'] = $m;
                    if (isset($this->dictionnary))
                        $array['variable'][$i]['value'] = htmlentities($this->dictionnary->__get($m));
                }
                $i++;
            }
        }
        $pattern = "\\{LOOP:(.*?)\\}.*?\\{\\/LOOP\\}";
        if (preg_match_all("/$pattern/is", $this->content, $matches)) {
            $i = 0;
            foreach ($matches[1] as $m) {
                $array['loop'][$i]['key'] = $m;
                if (isset($this->dictionnary))
                    $array['loop'][$i]['value'] = $this->dictionnary->__get($m);
                $i++;
            }
        }
        return $array;
    }

    /**
     * Remplace une variable du template par sa valeur
     * @param string $key nom de la variable à remplacer
     * @param string $value valeur assignée
     */
    private function replace($key, $value) {
        $this->content = str_replace("{var:$key}", $value, $this->content);
    }

    public function Variable($key, $value) {
        $this->content = str_replace("{var:$key}", $value, $this->content);
    }

    /**
     * permet de charger une implémentation JS
     * @param string $implement code à charger
     */
    public function addScript($implement) {
        $html = "<script type='text/javascript'>$implement</script>";
        $this->content = str_replace("</head>", "$html\n\t</head>", $this->content);
    }

    /**
     * permet d'ajouter une définition CSS
     * @param string $style
     */
    public function addStyle($style) {
        $html = "<style>$style</style>";
        $this->content = str_replace("</head>", "$html\n\t</head>", $this->content);
    }

    /**
     * permet de remplacer une variable du template par le contenu d'un fichier *.tpl
     * @param string $key nom de la variable
     * @param string $templateName nom du fichier *.tpl à charger
     */
    public function callTemplate($key, $templateName) {
        $handle = fopen($this->config['templateDirectory'] . "/$templateName", "r");
        $c = file_get_contents($this->config['templateDirectory'] . "/$templateName");
        $this->content = str_replace("{var:$key}", $c, $this->content);
        fclose($handle);
    }

    private function replaceCondition() {
        $pattern = "\\{\\:IF (.*?)(=|!)(.*?)\\}(.*?)\\{\\:\\/IF\\}";
        if (preg_match_all("/$pattern/is", $this->content, $matches)) {
            //var_dump($matches);
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = "";
                // var_dump($matches);
                switch ($matches[2][$i]) {
                    case "=" :
                        $replace = ($matches[1][$i] == $matches[3][$i]) ? $matches[4][$i] : "";
                        break;
                    case "!":
                        $replace = ($matches[1][$i] != $matches[3][$i]) ? $matches[4][$i] : "";
                        break;
                }
                $this->content = str_replace($matches[0][$i], $replace, $this->content);
            }
        }
    }

    public function addMeta($meta) {
        $this->content = str_replace("</head>", "$meta\n</head>", $this->content);
    }

    public function loadExternalScript($script) {
        $mime = explode(".", $script);
        $_m = $mime[count($mime) - 1];

        $html = "<script type=\"text/javascript\" src=\"$script\"></script>";

        $this->content = str_replace("</head>", "$html\n</head>", $this->content);
    }

    /**
     * permet de charger un script *.js ou *.css sur le template
     * @param string $script nom du fichier *.js ou *.css
     * @throws Exception 
     */
    public function loadScript($script, $begining = false) {
        $mime = explode(".", $script);
        $_m = $mime[count($mime) - 1];
        $html = "";
        switch ($_m) {
            case "js": {
                    if (file_exists($this->config['JSDirectory'] . "/$script")) {
                        $html = "<script type=\"text/javascript\" src=\"" . $this->config['JSDirectory'] . "/$script\"></script>";
                        $this->size+=filesize($this->config['JSDirectory'] . "/$script");
                    } else
                        throw new Exception("$script n'existe pas dans le context actuel");
                    break;
                }
            case "css": {
                    if (file_exists($this->config['StyleDirectory'] . "/$script")) {
                        $html = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $this->config['StyleDirectory'] . "/$script\"/>";

                        $this->size+=filesize($this->config['StyleDirectory'] . "/$script");
                    } else
                        throw new Exception("$script n'existe pas dans le context actuel");
                    break;
                }
            default :
                echo "pop";
        }
        if ($begining) {
            $this->content = str_replace("</title>", "</title>\n\t$html", $this->content);
        } else
            $this->content = str_replace("</head>", "$html\n</head>", $this->content);
    }

    /**
     * Affiche la page et effectue les remplacement nécéssaires
     * @throws Exception 
     */
    public function display($display_constante = true) {
        if ($this->dictionnary) {
            $array = $this->getVariableArray();

            if (isset($array["variable"]))
                foreach ($array['variable'] as $variable) {

                    $this->replace($variable['key'], html_entity_decode($variable['value']));
                }
            if (isset($array['array'])) {
                foreach ($array['array'] as $variable) {
                    // echo $variable['key'];
                    $this->replace($variable['key'], html_entity_decode($variable['value']));
                }
            }
            if (isset($array["loop"])) {
                foreach ($array['loop'] as $variable) {
                    if ($variable['value'])
                        $this->loop($variable['key'], $variable['value']);
                }
            }
            $this->replaceGetVariable();
            $this->replaceUNICODE();
            if (isset($_SESSION))
                $this->replaceSessionVariable();
            $this->content = str_replace("{:image}", $this->config["imageDirectory"], $this->content);
            $this->content = preg_replace("/\{:SESSION name=\"(\w+)\"}/is", "", $this->content);
            $this->replaceCondition();
            if ($display_constante)
                $this->replaceConstante();
            $this->size+=strlen($this->content);
            $this->addsize();
            $s = $this->size * 0.125;
            $this->content = str_replace("{:size}", round(($s / 1000), 2), $this->content);
            //  $this->content=str_replace("{:now}",date("Y-m-d"),$this->content);
            // $this->content=preg_replace("/\\{\:IF (.*?)\\}(.*?)\\{\:\\/IF\\}/is","",$this->content);
            echo $this->content;
        } else
            throw new Exception("Vous n'avez pas charg&eacute; de dictionnaire de variables");
    }

    /**
     * Remplace l'ensemble des variable de session par leur valeur
     */
    private function replaceSessionVariable() {
        if (preg_match_all("/\{:SESSION name=\"(\w+)\"}/is", $this->content, $matches)) {
            foreach ($matches[1] as $m) {
                $this->content = str_replace("{:SESSION name=\"$m\"}", (isset($_SESSION[$m])) ? $_SESSION[$m] : "", $this->content);
            }
        }
    }

    private function addsize() {
        if (preg_match_all("/\<img.*?src=[\'|\"](.*?)[\'|\"].*?\>/is", $this->content, $matches)) {
            foreach ($matches[1] as $m) {
                if (file_exists($m))
                    $this->size += filesize($m);
            }
        }
    }

    /**
     * Remplace par le caractère unicode qui correspond
     */
    private function replaceUNICODE() {
        if (preg_match_all("/\{:UNICODE:(\w+)}/is", $this->content, $matches)) {
            foreach ($matches[1] as $m) {
                switch ($m) {
                    case "sharp":
                        $this->content = str_replace("{:UNICODE:sharp}", "#", $this->content);
                        break;
                    case "pipe":
                        $this->content = str_replace("{:UNICODE:pipe}", "|", $this->content);
                        break;
                }
            }
        }
    }

    private function replaceGetVariable() {
        if (preg_match_all("/\{:GET name=\"(\w+)\"}/is", $this->content, $matches)) {
            foreach ($matches[1] as $m) {
                $this->content = str_replace("{:GET name=\"$m\"}", (isset($_GET[$m])) ? $_GET[$m] : "", $this->content);
            }
        }
    }

 /**
     * permet d'effectuer le remplacement d'une boucle (LOOP)
     * @param string $key nom de la boucle sur le tempalte
     * @param array $array tableau à deux dimension
     * @param bool $UTF8Encode spécifie l'encode UTF8 (oui/non)
     */
    public function loop($key, $array,$UTF8Encode=false) {
        $pattern = "\\{LOOP:$key\\}(.*?)\\{\\/LOOP\\}";
        if (preg_match_all("/$pattern/is", $this->content, $matches)) {
            $html = "";
            $i=0;
            foreach ($array as $lines) {
                $html.=$matches[1][0];
                foreach ($lines as $key => $value) {
                    $html = str_replace("{~index~}", $i, $html);
                    if (gettype($value) != "array")
                        if($UTF8Encode)
                            $html = str_replace("{#$key#}", utf8_encode ($value), $html);
                        else
                            $html = str_replace("{#$key#}", $value, $html);
                }
                $i++;
            }
            $this->content = str_replace($matches[0][0], $html, $this->content);
        }
    }

    /**
     * vérifie les droit de l'utilisateur
     * @param int $key
     */
    public function DROIT($key) {
        $pattern = "\\{\:DROIT ID=$key\\}(.*?)\\{\:\\/DROIT\\}";
        if (preg_match_all("/$pattern/is", $this->content, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = $matches[1][$i];

                $this->content = str_replace($matches[0][$i], $replace, $this->content);
            }
        }
    }

    /**
     * créer une page HTML
     * @param string $pageName Nom de la page
     */
    public function Page($pageName) {
        if ($this->dictionnary) {
            $array = $this->getVariableArray();

            if (isset($array["variable"]))
                foreach ($array['variable'] as $variable) {

                    $this->replace($variable['key'], html_entity_decode($variable['value']));
                }
            if (isset($array['array'])) {
                foreach ($array['array'] as $variable) {
                    // echo $variable['key'];
                    $this->replace($variable['key'], html_entity_decode($variable['value']));
                }
            }
            if (isset($array["loop"])) {
                foreach ($array['loop'] as $variable) {
                    if ($variable['value'])
                        $this->loop($variable['key'], $variable['value']);
                }
            }
            $this->replaceGetVariable();
            $this->replaceUNICODE();
            if (isset($_SESSION))
                $this->replaceSessionVariable();
            $this->content = str_replace("{:image}", $this->config["imageDirectory"], $this->content);
            //  $this->content=str_replace("{:now}",date("Y-m-d"),$this->content);
            $this->content = preg_replace("/\{:SESSION name=\"(\w+)\"}/is", "", $this->content);
            $this->replaceCondition();
            $html = $this->content;
            foreach ($this->events as $event) {
                //echo "GO TO TRIGGER";
                $html = $event->trigger($html);
            }
            $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $html = str_replace("</body>", "<div class='container'>$url exporter le " . date("Y m d") . "</div>\n</body>", $html);
            file_put_contents("_tmp/$pageName", $html);
        } else {
            throw new Exception("Pas de dictionnaire chargé");
        }
    }

    public function replaceConstante() {
        if (isset($this->config["constantFile"])) {
            $const_array = parse_ini_file($this->config["constantFile"]);
            foreach ($const_array as $cKey => $cValue) {
                $this->content = preg_replace("/\{:CONSTANTE name=*\"$cKey*\"}/is", $cValue, $this->content);
            }
        }
    }

    /**
     * Efface les variables inutilisées ainsi que les commentaires 
     */
    public function clear() {


        $this->content = preg_replace("/\{comment\:(.*?)\}/is", "", $this->content);
        $this->content = preg_replace("/\\{LOOP:.*?\\}(.*?)\\{\\/LOOP\\}/is", "", $this->content);
        $pattern = "\\{\:DROIT ID=[0-9]\\}(.*?)\\{\:\\/DROIT\\}";
        $this->content = preg_replace("/\\{\:DROIT ID=[0-9]\\}(.*?)\\{\:\\/DROIT\\}/is", "", $this->content);
        // 
    }

}

abstract class OnPageGenerate {

    public function trigger($html) {
        
    }

}

?>
