<?php
    $data = file_get_contents("https://htql.ctu.edu.vn/htql/login.php");

    $patt = '#id="module-thongbao".*<ul class="thongbao">(.*)</td#imsU';

    preg_match($patt, $data, $match);

    $pattLink = '#<li><a href="(.*)".*target.*#imsU';
    $pattContent = '#<li><a href=".*>(.*)</a></li>#imsU';


    preg_match_all($pattLink, $match[1], $links);
    preg_match_all($pattContent, $match[1], $contents);


    $dataArr = [];
    for($i = 0; $i < 12; $i++ ) {
        $dataArr[$i]["links"]    = trim($links[1][$i]);
        $dataArr[$i]["contents"] = trim($contents[1][$i]);
    }

    $xhtml = '<ul class="notify">';
    foreach($dataArr as $key => $value) {
        $xhtml .= '<li><a href="'.$value["links"].'">'.$value["contents"].'</li>';
    }

    $xhtml .= '</ul>';

    // echo $xhtml;

    echo json_encode($dataArr);