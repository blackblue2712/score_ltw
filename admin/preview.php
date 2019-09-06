<?php
    include_once("../define.php");
    $excelFiles = scandir("upload");
    
    unset($excelFiles[array_search(".", $excelFiles, true)]);
    unset($excelFiles[array_search("..", $excelFiles, true)]);

    $xhtml = "";
    foreach($excelFiles as $key => $value) {
        $url = './upload/'.$value;
        $path = PATH_UPLOAD_EXCEL . '/' . $value;

        $xhtml .= '<div id="'.$key.'"><a href="'.$url.'">'.$value.'</a>|<a href="javascript:previewEx(`'.$url.'`)">preview</a>|<a href="javascript:deleteEx(`'.$path.'`, `'.$key.'`)">delete</a></div>';
    }

    // delete file
    if(isset($_GET["role"]) && $_GET["role"] == "delete") {
        unlink($_GET["des"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview</title>
    <link rel="stylesheet" type="text/css" href="./asset/css/index.css">
</head>
<body>
    <?php
        echo $xhtml;
    ?>
    <div id="wrap-list"></div>
    <script src="./asset/js/xlsx.full.min.js"></script>
    <script type="text/javascript" src="./asset/js/preview.js"></script>
</body>
</html>