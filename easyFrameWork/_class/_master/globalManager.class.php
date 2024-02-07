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
 * Récupère les informations relatives au Server
 */
class ServerInfo
{
    private $serverData;

    public function __construct(array $serverData)
    {
        $this->serverData = $serverData;
    }

    public function getServerData($key)
    {
        return $this->serverData[$key] ?? null;
    }

    public function getSelf()
    {
        return $this->getServerData("PHP_SELF");
    }

    public function getScriptName()
    {
        return $this->getServerData("SCRIPT_NAME");
    }

    public function getScriptFilename()
    {
        return $this->getServerData("SCRIPT_FILENAME");
    }

    public function getPath()
    {
        return $this->getServerData("PATH_TRANSLATED");
    }

    public function getRoot()
    {
        return $this->getServerData("DOCUMENT_ROOT");
    }

    public function getRequestFloatTime()
    {
        return $this->getServerData("REQUEST_TIME_FLOAT");
    }

    public function getRacine()
    {
        return explode('/', $this->getScriptName())[1] ?? null;
    }

    public function getRequestTime()
    {
        return $this->getServerData("REQUEST_TIME");
    }

    public function getIpAddress()
    {
        return $this->getServerData("REMOTE_ADDR") ?? $this->getServerData("SERVER_ADDR");
    }
}

/**
 * Regroupe l'ensemble des variable $_SERVER
 * @deprecated version
 */
class Server implements GlobalManager
{
    /**
     * Retourne toutes les variables server
     * @return array
     */
    public static function getAll(): array
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
class Request
{
    private $getData;

    public function __construct()
    {
        $this->getData = $_GET;
    }

    public function getAll(): array
    {
        return $this->getData ?? null;
    }

    public function hasGetValues(): bool
    {
        return !empty($this->getData);
    }

    public function get($key)
    {
        if (is_string($key) && array_key_exists($key, $this->getData)) {
            return $this->getData[$key];
        } elseif (is_array($key) && count($key) == 2 && isset($this->getData[$key[0]][$key[1]])) {
            return $this->getData[$key[0]][$key[1]];
        } else {
            throw new InvalidArgumentException("Invalid key provided.");
        }
    }
}
/**
 * Permet de gérer les variable $_POST
 */
class Query
{
    private $postData;

    public function __construct()
    {
        $this->postData = $_POST;
    }

    public function getAll(): array
    {
        return [
            "date" => date("Y-m-d"),
            "values" => $this->postData
        ];
    }

    public function hasPostValues(): bool
    {
        return !empty($this->postData);
    }

    public function get($key)
    {
        if (is_string($key) && array_key_exists($key, $this->postData)) {
            return $this->postData[$key];
        } elseif (is_array($key) && count($key) == 2 && isset($this->postData[$key[0]][$key[1]])) {
            return $this->postData[$key[0]][$key[1]];
        } else {
            throw new InvalidArgumentException("Invalid key provided.");
        }
    }
}

class Session
{
}
/**
 * Permet de gérer les variables $_SESSION lesquelles sont définie soit comme public soit comme privée(cryptée)
 * @deprecated version
 */
class SessionVar implements GlobalManager
{
    public static function getAll()
    {
        return $_SESSION ?? null;
    }

    public static function get($key): mixed
    {
        if (!is_array($key) || !array_key_exists('context', $key) || !array_key_exists('name', $key)) {
            throw new Exception("\$key must be an associative array with 'context' and 'name' keys");
        }

        $context = $key["context"];
        $_key = $key["name"];

        return $_SESSION[$context][$_key] ?? null;
    }

    public static function setPublic($key, $value)
    {
        if (!isset($_SESSION["public"])) {
            $_SESSION['public'] = [];
        }

        $_SESSION['public'][$key] = $value;
    }

    public static function getPrivate($key)
    {
        if (isset($_SESSION["private"][$key])) {
            return easyFrameWork::decrypt($_SESSION['private'][$key], session_id());
        } else {
            return null;
        }
    }

    public static function setPrivate($key, $value)
    {
        if (!isset($_SESSION["private"])) {
            $_SESSION['private'] = [];
        }

        $_SESSION['private'][$key] = easyFrameWork::encrypt($value, session_id());
    }
}
class CookieManager
{
    public static function getAll()
    {
        return $_COOKIE ?? null;
    }

    public static function get($key): mixed
    {
        return $_COOKIE[$key] ?? null;
    }

    public static function set($key, $value, $expiration = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        setcookie($key, $value, $expiration, $path, $domain, $secure, $httponly);
    }
}

class SessionManager
{
    const PRIVATE_CONTEXT = "private";
    const PUBLIC_CONTEXT = "public";
    public static function getId(): string
    {
        return session_id() ?? null;
    }
    public static function getAll(): array
    {
        return $_SESSION ?? null;
    }
    public static function delete(string $key, string $context = self::PUBLIC_CONTEXT): void
    {
        if (isset($_SESSION[$context][$key])) {
            unset($_SESSION[$context][$key]);
        } else
            throw new Exception("$key doesn't exist in $context context");
    }
    public static function sessionExist(): bool
    {
        return session_id() != null;
    }
    public static function clean(): void
    {
        if (self::sessionExist())
            session_destroy();
    }
    public static function get(string $key, string $context = self::PUBLIC_CONTEXT): mixed
    {
        if (self::sessionExist())
            return $_SESSION[$context][$key] ?? null;
        else
            throw new Exception("Pas de session activée");
    }
    private static function setPrivate($key, $value): void
    {
        if (!isset($_SESSION["private"])) {
            $_SESSION['private'] = [];
        }

        $_SESSION['private'][$key] = easyFrameWork::encrypt($value, session_id());
    }
    private static function setPublic($key, $value): void
    {
        if (!isset($_SESSION["public"])) {
            $_SESSION['public'] = [];
        }

        $_SESSION['public'][$key] = $value;
    }
    public static function set($key, $value, $context = self::PUBLIC_CONTEXT): void
    {
        if ($context == self::PRIVATE_CONTEXT) {
            self::setPrivate($key, $value);
        } else {
            self::setPublic($key, $value);
        }
    }
}
