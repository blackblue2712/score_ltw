<?php

define("PATH_ROOT"              , dirname(__FILE__));
define("PATH_UPLOAD"            , PATH_ROOT . "/" . "public");
define("PATH_UPLOAD_USER"       , PATH_UPLOAD . "/" . "user");
define("PATH_UPLOAD_PRODUCT"    , PATH_UPLOAD . "/" . "product");

define("URL_ROOT"              , "./");
define("URL_UPLOAD"            , URL_ROOT  . "public");
define("URL_UPLOAD_USER"       , URL_UPLOAD . "/" . "user");
define("URL_UPLOAD_PRODUCT"    , URL_UPLOAD . "/" . "product");

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