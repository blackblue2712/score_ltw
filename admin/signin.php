<?php
    session_start();
    include_once("../connect.php");
    
    if(isset($_SESSION["user"])) {
        header("location: ./home.php");
    }

    $mess = "";
    if(isset($_SESSION["message"])) {
        $mess = '<div id=show-message class="show-mess">
                    <div class="wrap-mess">
                        <div class="mess">
                            <p class="'.$_SESSION["message"]["type"].'">'.$_SESSION["message"]["content"].'</p>
                        </div>
                        <div class="close-mess" onclick="closeBox()">X</div>
                    </div>
                </div>';

        unset($_SESSION['message']);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Form</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/style.css">
</head>
<body> 
<div class="wrapper">
    <div class="box-form" style="width: 500">
        <h2>Signin</h2>
        <form name="login-form" id="login-form" action="./controllers/user/signin.php" method="POST" enctype="multipart/form-data">
            <div class="inputBox">
                <input type="text" name="username" id="username" required/>
                <label for="name">Username</label>
            </div>
            <div class="inputBox">
                <input type="password" name="password" id="password" required/>
                <label for="password">Password</label>
            </div>
            <div style="margin-top: 20px; display: flex; align-items: center">
                <input type="submit" name="btnSubmit" value="Submit" style="margin-right: 10px" id="submit-form"/>
                <input type="reset" name="" value="Reset"/>
                <a style="flex-grow: 1; text-align: right; z-index: 9999; color: blue" href="./index.php">Register</a>
            </div>
        </form>
    </div>
</div>

<?php echo $mess?>

<!-- <p>Đặng Hữu Nghĩa - B1706729</p> -->
<script src="./asset/js/signin.js" type="text/javascript"></script>
</body>
</html>
