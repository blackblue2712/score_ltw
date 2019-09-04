<?php

    $arr_mes = [];

    // echo "<pre>";
    // print_r($_SERVER);
    // echo "</pre>";

    $referer = $_SERVER["HTTP_REFERER"];

    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $fileName = $_FILES["file"]["tmp_name"];
        $randDomString = time();
        $des = dirname(__FILE__) . "/upload/" . $randDomString . $_FILES["file"]["name"];
        if(move_uploaded_file($fileName, $des)) {
            $arr_mes["message"] = "Upload successfully";
            $arr_mes["des_file"] = $referer . "upload/" . $randDomString . $_FILES["file"]["name"];
            echo json_encode($arr_mes);
        } else {
            $arr_mes["message"] = "Upload fail";
            echo json_encode($arr_mes);
        }
    }