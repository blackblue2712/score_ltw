<?
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://elcit.ctu.edu.vn/course/view.php?id=3570',
        CURLOPT_USERAGENT => 'Crawl',
        // CURLOPT_POST => 1,
        CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
        // CURLOPT_POSTFIELDS => http_build_query(array(
        //     'email' => 'sydney@fife',
        //     'password' => 'pistol'
        // )),
        CURLOPT_HTTPHEADER => [
            "Cookie: MoodleSession=v9ea3s5jfd135cici23q5qtoc7"
        ]
    ));
    $res = curl_exec($curl);

    // echo $res;

    $patt1 = '#id="section-1".*>(.*)id="section-2".*"#imsU';
    preg_match($patt1, $res, $match);
    // $patt2 = '#<p><span.*><.*>(.*)<.*#';
    // preg_match_all($patt2, $match[1], $sectionAnnouncement);

    // echo "<pre>";
    // print_r($sectionAnnouncement);
    // echo "</pre>";

    // echo $match[1];

    curl_close($curl);

    echo json_encode($match[1]);