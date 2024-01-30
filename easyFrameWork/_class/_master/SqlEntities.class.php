<?php
abstract class SqlEntities
{
    public static $DIRECTORY = "./SQLEntities";
    /**
     * Remplace les %field% par le nom de la colonne
     * @param array $table
     * @param string $pattern
     */
    private static function replaceCallBack($table, $pattern)
    {
        return array_reduce($table, function ($carry, $field) use ($pattern) {
            $str = $pattern;
            $str = str_replace("%field%", $field["NAME"], $str);
            $carry[] = $str;
            return $carry;
        }, []);
    }
    /**
     * Retourne l'array de la SQLEntities
     * @param array $array
     * @param callable|null $callBack
     * @return array
     */
    public static function getArrayEntities(array $array,callable $callBack=null)
    {
        if ($array[0]!=null) {
            return array_reduce($array, function ($carry, $el) use($callBack) {
                if($callBack!=null){
                    $item=$el;
                    $carry=call_user_func_array($callBack,array(&$carry,$item));
                }else
                    $carry[] = $el->getArray();
                return $carry;
            }, []);
        }else{
            return [];
        }
    }
    /**
     * Génére la class SQLEntities
     * @param SQLFactoryV2 $sqlF
     * @param string $table
     */
    public static function generateEntity(SQLFactoryV2 $sqlF, $table)
    {
        $content = file_get_contents(self::$DIRECTORY . "/EntityModel");
        $className = easyFrameWork::toCamelCase($table);
        $columns = $sqlF->getColumns($table);
        $pattern = "\"%field%\"=>''";
        $attrs = self::replaceCallBack($columns, $pattern);

        $pattern = "\$entity->%field%=\$element[\"%field%\"];";
        $affect = self::replaceCallBack($columns, $pattern);

        $content = str_replace("[%className%]", $className, $content);
        $content = str_replace("[%table%]", $table, $content);
        $content = str_replace("[%attr%]", implode(",", $attrs), $content);
        $content = str_replace("[%affect%]", implode("\n", $affect), $content);

        if (file_put_contents(self::$DIRECTORY . "/$className.class.php", $content)) {
            echo ">Class $table [$className] - genérée";
        }
    }
    /**
     * Charge la classe SQLEntitie de la table passée en paramètre
     * @param string $table
     */
    public static function LoadEntity($table)
    {
        $filename = easyFrameWork::toCamelCase($table);
        require_once self::$DIRECTORY . "/$filename.class.php";
    }
}
