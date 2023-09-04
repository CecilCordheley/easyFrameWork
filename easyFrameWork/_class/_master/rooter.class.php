<?php
    class Router{
        private static $pageName;
        private static $ROUTER_INFO;
        public static function INIT(){
            $page=explode("/",$_SERVER['PHP_SELF']);
            self::$pageName = $page[count($page)-1];
            self::$ROUTER_INFO=json_decode(file_get_contents("include/router.json"),true);
        }
        public static function getCtrl(){
        
            return "_ctrl/".self::$ROUTER_INFO[self::$pageName]["ctrl"];
        }
        public static function getTemplate(){
           return self::$ROUTER_INFO[self::$pageName]["template"];
        }
        /**
         * @param EasyTemplate $tpl
         */
        public static function LoadStyles(&$tpl){
            $a=self::$ROUTER_INFO[self::$pageName]["style"];
            array_walk($a,function($item) use (&$tpl){
                $tpl->loadScript($item);
            });
        }
    }
?>