<?php
require_once "../_class/_master/easyFrameWork.class.php";
easyFrameWork::INIT("../_class/_master", "../include/router.json");
Router::Init("../include/router.json");

function replaceDescription($el)
{
    $re = '/\@description ([a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)/m';
    if (preg_match_all($re,  $el, $m, PREG_PATTERN_ORDER)) {
        //   var_dump($m[1][0]);

        $str = "<div class='desc'><b>Description</b> : " . $m[1][0] . "</div>";
    } else
        $str = "";
    echo $str;
}
function getReturnValue($el)
{
    $re = '/\@return ([a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)/m';
    if (preg_match_all($re,  $el, $m, PREG_PATTERN_ORDER)) {
        //   var_dump($m[1][0]);

        $str = "<div class='return'><b>Retour</b> : " . $m[1][0] . "</div>";
    } else
        $str = "";
    echo $str;
}
function replaceException($el)
{
    $re = '/\@throws ([a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)/m';
    if (preg_match_all($re,  $el, $m, PREG_PATTERN_ORDER)) {
        //   var_dump($m[1][0]);

        $str = "<div class='Exception'><b>Exception</b> : " . $m[1][0] . "</div>";
    } else
        $str = "";
    echo $str;
}
function getParams($el)
{
    $pattern2 = "/\@param ([a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)/m";
    $str="";
    if (preg_match_all($pattern2,  $el, $m)) {
        $r = "";
        foreach ($m[1] as $item) {
            $a=explode(" ",$item);
            $type="<span class='type'>".$a[0]."</span>";
            $name="<span class='name'>".$a[1]."</span>";
            $desc=substr($item, (strlen($a[0])+strlen($a[1])+2));
            $desc_="<span class='desc'>$desc</span>";
            $r .= "<div class='param'><b>Paramètres : </b>$type $name $desc_</div>";
        }
        $str = $r;
    } else
        $str = "";
    echo $str;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Calibri;
        }
        .type{
            color:#55E;
            font-weight: bold;
        }
        .methode {
            display: flex;
            flex-direction: column;
            width: 475px;
            margin: 5px;

        }

        .classe_desc {
            margin-top: 25px;
        }

        .classe_desc p {
            font-size: 15pt;
            margin: 15px;
        }

        h1 {
            background: #55E;
        }

        h2 {
            margin: 5px;
            border-bottom: 1px solid #55E;
        }

        .desc {
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    $files = ["easyFrameWork", "Server", "Query", "Request", 'sessionVar'];
    foreach ($files as $f) {
    ?>
        <div class='classe_desc'>
            <h1><?php echo $f ?></h1>
        <?php
        $rc = new ReflectionClass($f);
        $desc = $rc->getDocComment();
        $desc = str_replace("/**", "", $desc);
        $desc = str_replace("*", "", $desc);
        $desc = str_replace("/", "", $desc);
        echo "<p>$desc</p>";
        $methods = $rc->getMethods();
        array_walk($methods, function ($item) use ($rc) {

            $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
            $stat = ($rc->getMethod($item->name)->isStatic()) ? "STATIC :: " : "";
            echo "<div class='methode'><h2>$stat" . $item->name . "</h2>";

            $comment_string = $rc->getMethod($item->name)->getdoccomment();
            preg_match_all($pattern, $comment_string, $matches, PREG_PATTERN_ORDER);
            $doc = $matches[0];
            foreach ($doc as $el) {

                replaceDescription($el);
                getParams($el);
                replaceException($el);
                getReturnValue($el);
            }
            echo "</div>";
        });
        echo "</div>";
    }
        ?>

</body>

</html>