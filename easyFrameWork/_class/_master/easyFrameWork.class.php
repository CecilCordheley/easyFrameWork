<?php
class easyFrameWork
{
    private static $ENCRYPT_BLOCK_SIZE = 200;

    //Block size for decryption block cipher
    private static $DECRYPT_BLOCK_SIZE = 256;

    public static function getParams($configName, $path = "include/config.ini")
    {
        $ini = parse_ini_file($path, true);
        return $ini[$configName];
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
    public static function INIT($uri = "./_class/_master/", $path = "include/router.json")
    {
        if (file_exists("$uri/autoload.class.php"))
            require_once "$uri/autoload.class.php";
        else {
            throw new Exception("$uri doesn't exists on the current context");
        }
        Autoloader::register();
        Autoloader::callRequires($uri);
        Router::Init($path);
    }
}
?>