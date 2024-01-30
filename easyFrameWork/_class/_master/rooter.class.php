<?php
/**
 * Permet de gérer les informations de routing
 */
class Router
{
    private static $path;
    private static $pageName;
    private static $ROUTER_INFO;
    /**
     * Initialise le router
     * @param string $path
     */
    public static function INIT($path = "include/router.json")
    {
        $page = explode("/", $_SERVER['PHP_SELF']);
        self::$path = $path;
        self::$pageName = $page[count($page) - 1];
        self::$ROUTER_INFO = json_decode(file_get_contents($path), true);
    }
    /**
     * Ajoute une occurence de le fichier router
     * @param string $name
     * @param array $infos
     */
    public static function addRouterInfo($name, $infos)
    {
        self::$ROUTER_INFO[$name] = $infos;
        //var_dump(self::$ROUTER_INFO);
        $a = json_encode(self::$ROUTER_INFO, true);
        file_put_contents(self::$path, $a);
        self::createCtrl_file($infos["ctrl"]);
        self::createTplt_file($infos["template"]);
        self::createCSS_file($infos["style"]);
    }
    /**
     * Créer le fichier css
     * @param array $a
     */
    private static function createCSS_file($a)
    {
        array_walk($a, function ($item) {
            if (!file_exists("../_css/$item"))
                file_put_contents("../_css/$item", "/**Ici le contenu CSS de la page");
        });

    }
    /**
     * Créer le fichier contrôleur
     * @param string $filename
     */
    private static function createCtrl_file($filename)
    {
        if (!file_exists("../_ctrl/$filename"))
            file_put_contents("../_ctrl/$filename", "<?php \n//ici le code PHP de la page\n#\$template pour gérer le moteur\n#\$vars pour gérer les variables {var:???}\n");
    }
    /**
     * Créer le fichier template
     * @param string $filename
     */
    private static function createTplt_file($filename)
    {
        if (!file_exists("../_template/$filename"))
            file_put_contents("../_template/$filename", "<!--ICI LE TEMPLATE SPECIFIQUE DE VOTRE PAGE-->");
    }
    /**
     * Retourne le fichier contrôleur de la page
     * @return string
     */
    public static function getCtrl()
    {
        return "_ctrl/" . self::$ROUTER_INFO[self::$pageName]["ctrl"] ?? false;

    }
    /**
     * Retourne le répetoire de view sql de la page
     * @return string
     */
    public static function getView(): string
    {
        return self::$ROUTER_INFO[self::$pageName]["view"] ?? false;
    }
    /**
     * Retourne le fichier template de la page
     * @return string
     */
    private static function getTemplate()
    {
        return self::$ROUTER_INFO[self::$pageName]["template"] ?? false;
    }
    /**
     * paramètre le template principal de la page
     * @param easyTemplate $tpl
     * @param string $name
     */
    public static function setMainTemplate(&$tpl, $name)
    {
        $tpl->callTemplate($name, Router::getTemplate());
    }
    /**
     * Charge les fichiers de style
     * @param EasyTemplate $tpl
     */
    public static function LoadStyles(&$tpl)
    {
        $a = self::$ROUTER_INFO[self::$pageName]["style"] ?? "no";
        if ($a == "no")
            return;
        array_walk($a, function ($item) use (&$tpl) {
            $tpl->loadScript($item);
        });
    }
}
?>