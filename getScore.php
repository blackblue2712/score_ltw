<?php
    include("connect.php");
    $arr_mess = [];
    $query = "";

    if(isset($_GET["role"]) && $_GET["role"] == "getall") {
        $query = "SELECT * FROM group_5";
    } else if(isset($_GET["role"]) && $_GET["role"] == "getQuery") {
        $patt = '/[\-\'\"\\/\,\.\*\<\>]/';
        
        $q = preg_replace($patt, "", $_GET['q']);

       $query = "SELECT * FROM group_5 WHERE id LIKE '%".$q."%'";
    } else {
        return;
    }

    
    $result = mysqli_query($link, $query);
    if($result->num_rows > 0) {
        $i = 0;
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[$i]["id"] = $row["id"];
            $data[$i]["name"] = $row["name"];
            $data[$i]["gender"] = $row["gender"];
            $data[$i]["score"] = $row["score"];
            $i++;
        }

        echo json_encode($data);
    } else {
        $arr_mess["message"] = "Empty record";
        echo json_encode($arr_mess);
    }
