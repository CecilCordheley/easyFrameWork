<?php
/**
 * FrameWork Principal
 */
abstract class easyFrameWork
{
    public const HASH_ALGO = [
        "MD2" => "md2",
        "MD4" => "md4",
        "MD5" => "md5",
        "SHA1" => "sha1",
        "SHA256" => "sha256",
        "SHA384" => "sha384",
        "SHA512" => "sha512",
        "RIPEMD128" => "ripemd128",
        "RIPEMD160" => "ripemd160",
        "RIPEMD256" => "ripemd256",
        "RIPEMD320" => "ripemd320",
        "WHIRLPOOL" => "whirlpool",
        "TIGER128,3" => "tiger128,3",
        "TIGER160,3" => "tiger160,3",
        "TIGER192,3" => "tiger192,3",
        "TIGER128,4" => "tiger128,4",
        "TIGER160,4" => "tiger160,4",
        "TIGER192,4" => "tiger192,4",
        "SNEFRU" => "snefru",
        "GOST" => "gost",
        "ADLER32" => "adler32",
        "CRC32" => "crc32",
        "CRC32B" => "crc32b",
        "HAVAL128,3" => "haval128,3",
        "HAVAL160,3" => "haval160,3",
        "HAVAL192,3" => "haval192,3",
        "HAVAL224,3" => "haval224,3",
        "HAVAL256,3" => "haval256,3",
        "HAVAL128,4" => "haval128,4",
        "HAVAL160,4" => "haval160,4",
        "HAVAL192,4" => "haval192,4",
        "HAVAL224,4" => "haval224,4",
        "HAVAL256,4" => "haval256,4",
        "HAVAL128,5" => "haval128,5",
        "HAVAL160,5" => "haval160,5",
        "HAVAL192,5" => "haval192,5",
        "HAVAL224,5" => "haval224,5",
        "HAVAL256,5" => "haval256,5"
    ];
    /**
     * permet de transformer une chaine de caractères en CamelCase
     * @param string $input
     * @return string
     */
    public static function toCamelCase($input)
    {
        return preg_replace_callback('/(?:^|_)([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $input);
    }
    /**
     * récupère les paramètres du fichier *ini du projet
     * @param string $configName
     * @param string $path
     * @return array
     */
    public static function getParams($configName, $path = "include/config.ini")
    {
        $ini = parse_ini_file($path, true);
        return $ini[$configName];
    }
    /**
     * Hash une chaîne de caractères et crypte si une clef passe en paramètre 
     * @param string $str
     * @param string $key 
     * @param string $algo
     * @return string
     */
    public static function hashString($str, $key = "", $algo = "sha256")
    {
        $return = hash($algo, $str);
        if ($key != "") {
            return self::encrypt($return, $key);
        } else
            return $return;
    }
    /**
     * Crypte une chaine de caractères
     * @param string $plainData
     * @param string $key
     * @return string
     */
    public static function encrypt($plainData, $key)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $encryption_iv = '1234567891011121';
        $encryption = openssl_encrypt(
            $plainData,
            $ciphering,
            $key,
            0,
            $encryption_iv
        );
        return $encryption;
    }

     /**
     * Decrypte une chaine de caractères
     * @param string $content
     * @param string $key
     * @return string
     */
    public static function decrypt($content, $key)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $encryption_iv = '1234567891011121';
        $encryption = openssl_decrypt(
            $content,
            $ciphering,
            $key,
            0,
            $encryption_iv
        );
        return $encryption;
    }
    /**
     * Debug une variable et arrête le script courant
     * @param mixed $var
     */
    public static function Debug($var)
    {
        var_dump($var);
        exit;
    }
    /**
     * Initialize les paramètres 
     * @param string $uri
     * @param string $path
     * @param bool $error
     */
    public static function INIT($uri = "./_class/_master/", $path = "include/router.json", $error = true)
    {
        ini_set('display_errors', 1);
        $pathParams = str_replace("router.json", "config.ini", $path);
        date_default_timezone_set(self::getParams("config", $pathParams)["TimeZone"]);
        if (file_exists("$uri/autoload.class.php"))
            require_once "$uri/autoload.class.php";
        else {
            throw new Exception("$uri doesn't exists on the current context");
        }
        Autoloader::register();
        Autoloader::callRequires($uri);
        Router::Init($path);

        if ($error) {
            function CreateErrorHandler()
            {
                $errorMsg = file_get_contents("include/error_model.html");
                $error = new ErrorHandler;
                $error->attach(new LogFile("./include/myerror.txt"));
                $error->attach(new Message());
                $error->attach(new Notifier($errorMsg));
                set_error_handler(array($error, 'error'));
                //  restore_error_handler();
                if (easyFrameWork::getParams("config")["FalalError"])
                    register_shutdown_function(ErrorHandler::class . '::errorFatal');
            }
            CreateErrorHandler();
        }
    }
}
