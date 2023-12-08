<?php
var_dump($argv);
if (strpos($argv[1], ' ') !== false){
  $argw = explode(" ", $argv[1]);
  array_unshift($argw, $argv[2]);
  $argv = $argw;
}
var_dump($argv);
parse_str(implode('&', array_slice($argv, 1)), $_GET);
var_dump($_GET);