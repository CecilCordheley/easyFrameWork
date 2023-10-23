<?php
$index_array = [
    [
        "val" => "test 1"
    ],
    [
        "val" => "test 2"
    ]
];
$template->loop("maboucle", $index_array);
$_SESSION["test"]="Ma variable";