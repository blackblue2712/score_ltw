<?php
    include("define.php");
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if(!$link) die("Can not connect to server!");
    $link->query("SET NAMES 'utf8'");
	$link->query("SET CHARACTER SET 'utf8'");
    // echo "connect succses";