<?php
    session_start();
    include_once("../define.php");
    if(isset($_SESSION["user"])) {

    } else {
        header("location: ./signin.php");
    }

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
    <title>Sheet</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/style.css">
    <link rel="stylesheet" type="text/css" href="./asset/css/index.css">
</head>
<body>
    <div class="wrapper">
        
        <div class="box-form" style="width: 500">
            <div id="wrap-bar">
                <div id="process-bar">
                    
                </div>
            </div>
            <h2>Import file excel to db</h2>
            <form action="process.php" method="POST" enctype="multipart/form-data" id="main-form">
                <div class="inputBox">
                    <!-- <label for="password">File</label> -->
                    <input type="file" name="fileEx" id="fileEx">
                </div>
                <div class="form-group">
                    <label for="gender" class="title">Type</label>
                    <label style="color: #fff"><input type="radio" name="type" value="insertAll" checked="checked"> Insert in one query</label>
                    <label style="color: #fff"><input type="radio" name="type" value="insertSequence"> Insert in for loop</label>
                    <label style="color: #fff"><input type="radio" name="type" value="update"> Update</label>
                </div>
                <div style="margin-top: 20px; display: flex; align-items: center">
                    <input type="submit" name="btnSubmit" value="Submit" style="margin-right: 10px" id="submit-form" onclick="onSubmitForm()"/>
                    <input type="reset" name="" value="Reset"/>
                    <a style="flex-grow: 1; text-align: right; z-index: 9999; color: blue" id="signmeout" href="#">Sign me out</a>
                </div>
            </form>
        </div>
        
    </div>
    <div id="preview-area">
        <?php echo $xhtml?>
        <div id="wrap-list"></div>
    </div>
    <script src="./asset/js/xlsx.full.min.js"></script>
    <script src="./asset/js/index.js"></script>
    <script src="./asset/js/preview.js"></script>
</body>
</html>