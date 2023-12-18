<?php
   abstract class SqlEntities{
    private static function replaceCallBack($table,$pattern){
       return array_reduce($table,function($carry,$field) use($pattern){
            $str=$pattern;
            $str=str_replace("%field%",$field["NAME"],$str);
            $carry[]=$str;
            return $carry;
        },[]);
    }
    /**
     * @param SQLFactoryV2 $sqF
     */
    public static function generateEntity(SQLFactoryV2 $sqlF,$table){
        $content=file_get_contents("./SQLEntities/EntityModel");
        $className=easyFrameWork::toCamelCase($table);
        $columns=$sqlF->getColumns($table);
        $pattern="\"%field%\"=>''";
        $attrs=self::replaceCallBack($columns,$pattern);

        $pattern="\$entity->%field%=\$element[\"%field%\"];";
        $affect=self::replaceCallBack($columns,$pattern);

        $content=str_replace("[%className%]",$className,$content);
        $content=str_replace("[%table%]",$table,$content);
        $content=str_replace("[%attr%]",implode(",",$attrs),$content);
        $content=str_replace("[%affect%]",implode("\n",$affect),$content);

        if(file_put_contents("./SQLEntities/$className.class.php",$content)){
            echo ">Class $table [$className] - genérée";
        }
    }
    public static function LoadEntity($table){
        $filename=easyFrameWork::toCamelCase($table);
        require_once "./SQLEntities/$filename.class.php";
    }
   }