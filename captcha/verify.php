<?php
    session_start();
    if($_SESSION["code"] == $_GET["code"]) {
        $a["message"] = "success";
    } else {
        $a["message"] = "fail";
    }

    echo json_encode($a);