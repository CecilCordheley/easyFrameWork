<?php
class easyFrameWork
{
    private const ENC_KEY="1236ab";
    private const SECRET_IV= "aesd56";
    public const ENC = "encrypt";
    public const DEC = "decrypt";
    public const FILE_FORMAT_PHP=".php";
    public const FILE_FORMAT_TPL=".tpl";
    public const FILE_FORMAT_CTRL=".ctrl.php";
    public const FILE_FORMAT_CSS=".css";

    public static function getParams($configName,$path="include/config.ini"){
        $ini = parse_ini_file($path, true);
        return $ini[$configName];
    }
    public static function encrypt_decrypt($action, $string): string
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = self::ENC_KEY;
        $secret_iv = self::SECRET_IV;

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
    public static function INIT($uri="./_class/_master/",$path="include/router.json")
    {
        if(file_exists("$uri/autoload.class.php"))
            require_once "$uri/autoload.class.php";
        else{
            throw new Exception("$uri doesn't exists on the current context");
        }
        Autoloader::register();
        Autoloader::callRequires($uri);
        Router::Init($path);
    }
}
?>