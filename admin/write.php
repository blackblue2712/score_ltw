<?php
    include_once("../connect.php");

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $json = json_decode($_POST["json"]);
    $type = $_POST["type"];

    $id = "";
    $name = "";
    $gender = "";
    $score = "";
    $arr_mess  = [];

    if($type == "insertAll") {
        $query = "INSERT INTO group_5 (id, `name`, gender, score) VALUES";
        foreach($json as $key => $value) {
            $name       = isset($value->name) ? $value->name : "";
            $id         = isset($value->id) ? $value->id : "" ;
            $gender     = isset($value->gender) ? $value->gender : "";
            $score      = isset($value->score) ? $value->score : 0;
            if($key+1 == count($json)) {
                $query .= " ('".$id."', '".$name."', '".$gender."', '".$score."')";
            } else {
                $query .= " ('".$id."', '".$name."', '".$gender."', '".$score."'), ";
            }   
        }
        // echo $query;
        if(mysqli_query($link, $query)) {
            $arr_mess["done"]  = count($json);
            $arr_mess["fail"]  = 0;
            echo json_encode($arr_mess);
        } else {
            $arr_mess["fail"]  = count($json);
            $arr_mess["done"]  = 0;
            echo json_encode($arr_mess);
        }
    } else if($type == "insertSequence") {
        $done = 0;
        $fail = 0;
        foreach($json as $key => $value) {
            $name       = isset($value->name) ? $value->name : "";
            $id         = isset($value->id) ? $value->id : "" ;
            $gender     = isset($value->gender) ? $value->gender : "";
            $score      = isset($value->score) ? $value->score : 0;
            $query = "INSERT INTO group_5 VALUES ('".$id."', '".$name."', '".$gender."', '".$score."')";

            if(mysqli_query($link, $query)) {
                $done++;
            } else {
                $fail++;
            }
        }
        $arr_mess["done"] = $done;
        $arr_mess["fail"] = $fail;
        echo json_encode($arr_mess);
    } else if ($type == "update") {
        $done = 0;
        $fail = 0;
        foreach($json as $key => $value) {
            $name       = isset($value->name) ? $value->name : "";
            $id         = isset($value->id) ? $value->id : "" ;
            $gender     = isset($value->gender) ? $value->gender : "";
            $score      = isset($value->score) ? $value->score : 0;
            $query = "UPDATE group_5 SET `score`='".$score."' WHERE id='".$id."'";

            if(mysqli_query($link, $query)) {
                $done++;
            } else {
                $fail++;
            }
        }
        $arr_mess["done"] = $done;
        $arr_mess["fail"] = $fail;
        echo json_encode($arr_mess);
    }

    


    // echo $query;

    