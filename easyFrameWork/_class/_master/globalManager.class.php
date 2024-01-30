<?php
/**
 * Interface définissant les fonctions de base de la gestion des variables
 */
interface GlobalManager
{
    public static function getAll();
    public static function get($key);
}
/**
 * Regroupe l'ensemble des variable $_SERVER
 */
class Server implements GlobalManager
{
/**
 * Retourne toutes les variables server
 * @return array
 */
    public static function getAll()
    {
        return $_SERVER;
    }
    /**
     * retourne la valeur de la variable server passée en paramètre
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return $_SERVER[$key] ?? null;
    }
    /**
     * Retourne le nom du fichier du script en cours d'exécution, par rapport à la racine web
     * @return string
     */
    public static function GetSelf()
    {
        return self::get("PHP_SELF");
    }
    /**
     * Retourne Contient le nom du script courant.  
     * @return string
     */
    public static function GetScriptName()
    {
        return self::get("SCRIPT_NAME");
    }
    /**
     * Retourne le chemin absolu vers le fichier contenant le script en cours d'exécution.
     * @return string
     */
    public static function GetScriptFilename()
    {
        return self::get("SCRIPT_FILENAME");
    }
    /**
     * Retourne Chemin dans le système de fichiers (pas le document-root) jusqu'au script courant
     */
    public static function GetPath()
    {
        return self::get("PATH_TRANSLATED");
    }
    /**
     * Retourne la racine sous laquelle le script courant est exécuté
     * @return string
     */
    public static function GetRoot()
    {
        return self::get("DOCUMENT_ROOT");
    }
    /**
     * Retourne le timestamp du début de la requête (microseconde)
     * @return float
     */
    public static function GetRequestFloatTime()
    {
        return self::get("REQUEST_TIME_FLOAT");
    }
    /**
     * Retourne le répertoire Racine du ScriptName
     */
    public static function GetRacine()
    {
        return explode('/', self::GetScriptName())[1];
    }
    public static function GetRequestTime()
    {
        return self::get("REQUEST_TIME");
    }
}
/**
 * Permet de gérer les variables $_GET
 */
class Request implements GlobalManager
{
    /**
     * Retourne la variable GET associé à la clé
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        return $_GET[$key] ?? null;
    }
    /**
     * Retourne toutes les variables GET
     * @return mixed
     */
    public static function getAll()
    {
        return $_GET ?? null;
    }
    /**
     * Paramètre une variable GET
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $_GET[$key] = $value;
    }
}
/**
 * Permet de gérer les variable $_POST
 */
class Query implements GlobalManager
{
    /**
     * Retourne l'ensemble des variables $_POST
     * @return array
     */
    public static function getAll()
    {
        return ["date" => date("Y-m-d"),
            "values" => $_POST];
    }
    /**
     * Indique si des variables
     * @return bool
     */
    public static function hasPostValues()
    {
        return count($_POST) ?? false;
    }
    /**
     * retourne une variable POST
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        $type = ["string", "array"];
        if (in_array(gettype($key), $type)) {
            if (gettype($key) == "string")
                return $_POST[$key] ?? null;
            else if (gettype($key) == "array") {
                return $_POST[$key[0]][$key[1]];
            }
        } else
            throw new Exception("\$key not a valid type should be array or string type " . gettype($key) . " given");
    }
}
/**
 * Permet de gérer les variables $_SESSION lesquelles sont définie soit comme public soit comme privée(cryptée)
 */
class sessionVar implements GlobalManager
{
    public static function getAll()
    {
        return $_SESSION ?? null;
    }
    public static function get($key): mixed
    {
        if (gettype($key) != "array") {
            throw new Exception("\$key must be an associate array with 'context' key and 'name' key");
        }
        $context = $key["context"];
        $_key = $key["name"];
        return $_SESSION[$context][$_key] ?? null;
    }
    public static function setPublic($key, $value)
    {
        if (!isset($_SESION["public"])) {
            $_SESSION['public'] = [];
        }
        $_SESSION['public'][$key] = $value;
    }
    public static function getPrivate($key)
    {
        if (!isset($_SESION["private"][$key])) {
            return easyFrameWork::decrypt($_SESSION['private'][$key], session_id());
        } else
            return null;
    }
    public static function setPrivate($key, $value)
    {
        if (!isset($_SESION["private"])) {
            $_SESSION['private'] = [];
        }
        $_SESSION['private'][$key] = easyFrameWork::encrypt($value, session_id());
    }
}