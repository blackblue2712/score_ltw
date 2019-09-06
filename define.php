<?php

define("PATH_ROOT"              , dirname(__FILE__));
define("PATH_UPLOAD_EXCEL"      , PATH_ROOT . "/admin/upload");

define("URL_ROOT"              , "./");
define("URL_UPLOAD_EXCEL"      , URL_ROOT  . "/admin/upload");

// Define variable
define("DB_HOST"                , "localhost");
define("DB_USER"                , "root");
define("DB_PASSWORD"            , "");
define("DB_NAME"                , "score_ltw");



function randomString($length = 5) {
    $range = array_merge(range("a","z"), range("A","Z"), range(0,9));
    shuffle($range);
    $result = substr(implode("", $range), 0, $length);
    return $result;
}