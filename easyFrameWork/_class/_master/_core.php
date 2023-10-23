<?php
function getFileDocBlock($file)
{
   $pattern="/\/\*\*(.*?)\*\/\npublic function (.*?)/ims";
   if(preg_match_all($pattern, file_get_contents($file), $matches)){
    var_dump($matches);
   }
}