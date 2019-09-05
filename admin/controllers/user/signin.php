<?php
    session_start();
    include_once("../../../connect.php");

    $arr_mess = [];

    if(isset($_POST["username"])) {
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $query = "SELECT * FROM user WHERE username='".$username."' AND `password`='".$password."' ";
    
        $result = mysqli_query($link, $query);
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["user"]["username"] = $user["username"];
            $_SESSION["user"]["id"] = $user["id"];
            $_SESSION["user"]["picture"] = $user["picture"];
            $arr_mess["message"] = "success";
        } else {
            $arr_mess["message"] = "Username or password are not match";
        }
        echo json_encode($arr_mess);
    } else {
        header("location: ../../signin.php");
    }