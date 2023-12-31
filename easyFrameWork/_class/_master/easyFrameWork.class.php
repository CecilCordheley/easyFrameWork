<?php
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
     * permet d'appelé un template
     * @param string $name nom du microtemplate
     * @param string $path chemin d'accès du fichier des microtemplate
     */
    public static function getMicroTemplate($name, $path = "include/microtpl.json")
    {
        $json = json_decode(file_get_contents($path), true);

        if (gettype($json[$name]) == "array") {
            return implode($json[$name]);
        } else
            return $json[$name];
    }
    /**
     * format une chaine de caractère en camel Case
     * @param string $input chaine a transformée
     * @return string
     */
    public static function toCamelCase($input)
    {
        return preg_replace_callback('/(?:^|_)([a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $input);
    }
    public static function testClassMethode($fnc,$result,$args){
        $arr = [];
        $arr["Expected"]=$result;
        $reflection = new ReflectionMethod($fnc);
        $start = microtime(true);
        $return = call_user_func_array($fnc, $args);
        $end = microtime(true);
        $time = ($end - $start);
        if ($reflection->hasReturnType()) {
            $arr["Result"]=$return;
            if ($return === $result) {
                $arr["Test"] = "OK";
            } else
                $arr["Test"] = "KO";

        }
        $arr["execTime"] = $time;
        $arr["file"] = $reflection->getFileName();
        $arr["name"] = $reflection->getName();
        return $arr;
    }
    public static function testFnc($fnc, $result, $args)
    {
        $arr = [];
        $arr["Expected"]=$result;
        $reflection = new ReflectionFunction($fnc);
        $start = microtime(true);
        $return = call_user_func_array($fnc, $args);
        $end = microtime(true);
        $time = ($end - $start);
        if ($reflection->hasReturnType()) {
            $arr["Result"]=$return;
            if ($return === $result) {
                $arr["Test"] = "OK";
            } else
                $arr["Test"] = "KO";

        }
        $arr["execTime"] = $time;
        $arr["file"] = $reflection->getFileName();
        $arr["name"] = $reflection->getName();
        return $arr;
    }
    public static function getParams($configName, $path = "include/config.ini")
    {
        $ini = parse_ini_file($path, true);
        return $ini[$configName];
    }
    public static function hashString($str, $key = "", $algo = "sha256")
    {
        $return = hash($algo, $str);
        if ($key != "") {
            return self::encrypt($return, $key);
        } else
            return $return;
    }
    public static function encrypt($plainData, $key)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $encryption_iv = '1234567891011121';
        $encryption = openssl_encrypt($plainData, $ciphering,
            $key, 0, $encryption_iv);
        return $encryption;
    }

    //For decryption we would use:
    public static function decrypt($content, $key)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $encryption_iv = '1234567891011121';
        $encryption = openssl_decrypt($content, $ciphering,
            $key, 0, $encryption_iv);
        return $encryption;
    }
    public static function Debug($var)
    {
        var_dump($var);
        exit;
    }
    public static function INIT($uri = "./_class/_master/", $path = "include/router.json")
    {
        ini_set('display_errors', 1);
        date_default_timezone_set(self::getParams("config")["TimeZone"]);
        if (file_exists("$uri/autoload.class.php"))
            require_once "$uri/autoload.class.php";
        else {
            throw new Exception("$uri doesn't exists on the current context");
        }
        Autoloader::register();
        Autoloader::callRequires($uri);
        Router::Init($path);


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
?>