<?php
    session_start();
    include("define.php");

    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    $conf = "";
    $picture = 'https://res.cloudinary.com/ddrw0yq95/image/upload/v1565673576/qbay0vl6qylmg6lkxp8g.jpg';
    if(isset($_SESSION["user"])) {
        $id = $_SESSION["user"]["id"];
        $username = $_SESSION["user"]["username"];
        $picture = $_SESSION["user"]["picture"];
        $gender = $_SESSION["user"]["gender"];
        $career = $_SESSION["user"]["career"];
        $hobbies = $_SESSION["user"]["hobbies"];
        if($picture != "") {
            $picture = URL_UPLOAD_USER . "/" . $picture;
        } else {
            $picture = 'https://res.cloudinary.com/ddrw0yq95/image/upload/v1565673576/qbay0vl6qylmg6lkxp8g.jpg';
        }

        $str_hobbies = '';
        if($hobbies != "") {
            $arr_hobbies = explode("-", $hobbies);
            foreach($arr_hobbies as $value) {
                $str_hobbies .= " - " . $value;
            }
		}
		
		if(isset($_SESSION["config"])) {
			$bg = $_SESSION["config"]["backgroundColor"];
			$sz = $_SESSION["config"]["fontSize"];
			$cl = $_SESSION["config"]["color"];
			$conf = '<script type="text/javascript">
						document.querySelector("section.body").style.backgroundColor = "#'.$bg.'";
						document.querySelector("section.body").style.color = "#'.$cl.'";
						document.querySelector("section.body").style.fontSize = "'.$sz.'px";
				</script>';
		}
		
    } else {
        // header("location: ./signin.php");
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
	<title>Score</title>
	<link rel="stylesheet" type="text/css" href="./asset/css/home.css">
</head>
<body>
	<div id="wrapper">
		<div class="container-fluid">
			<div class="header">
					<div class="nav-wrap">
						<div>
							<a class="brand" href="#">Liars</a>
						</div>	
						<div>
							<a class="nav-item" href="#">Home</a>
						</div>
						<!-- <div>
							<a class="nav-item" href="#about">About</a>
						</div>
						<div>
							<a class="nav-item" href="#product">Product</a>
						</div>
						<div>
							<a class="nav-item" href="#exercise">Exercise</a>
						</div>
						<div>
							<a class="nav-item has-child" href="#more">More &darr;</a>
						</div> -->
					</div>
				<div class="container"></div>
			</div>

			<div class="body">
				<div class="container">
					<div class="row">
						<!-- <section class="top">
							<div class="cover-photo">
								<div class="avatar">
									<a href=<?php echo $picture?> target="_blank"><img src=<?php echo $picture?> alt="avt" class="img-sm img-circle img-avatar"></a>
									<label class="mine-name"><?php echo "Dang Huu Nghia"?></label>
								</div>
							</div>
						</section> -->
						<section class="body">

                            <div id="product" class="box-model" style="padding-top: 40px;">
								<div class="model-header">
									<h2 style="color: darkcyan;">Product</h2>
								</div>
								<div class="model-body">
									<div class="model-body-left">
										<div class="tab">
											<label>
												<input type="checkbox" name="overview" style="display: none">Overview
											</label>
										</div>
									</div>
									<div class="model-body-right">
										<div id="list">
											<h3>List products <input style="margin-left: 20px" type="text" placeholder="Type to find ..." oninput="ajaxFind(value)"></h3>
											<div id="wrap-table">
												<!-- AJAX LOADED -->
											</div>
                                        </div>
                                    </div>
								</div>
                            </div>


                        </section>
					</div>
				</div>
			</div>

			<div class="footer" style="text-align: center;">
				Liars &copy; 2019	
				<div id="scrollTop" class="hide">
					<span title="top" style='font-size:50px; cursor: pointer;' onclick="javascript:scrollToTop()">&#8634;</span>
				</div>
			</div>

        </div>

        <div id="setting">
            <span onclick="changeUI()" id="setting-icon"><img id="setting-pic" src="./icon/cog-solid.svg"></span>
            <div class="btn-st close">
                <span onclick="alert(`Comming soon`)" id="signout" title="Signout"><img src="./icon/power-off-solid.svg"></span>
			</div>
			<div class="btn-st close" style="top: 47px;left: -47px;">
                <span onclick="alert(`Comming soon`)" id="adjust" title="Adjust"><img src="./icon/adjust-solid.svg"></span>
			</div>
			<div class="btn-st close" style="top: 0px;left: -61px;">
                <span onclick="alert(`Comming soon`)" id="notify" title="Notify"><img src="./icon/bell-solid.svg"></span>
            </div>
        </div>
	</div>
	<div id="notifi">
		<?php echo $mess?>
	</div>
	<div id="popup">
	</div>
    <?php echo $conf ?>
    <script src="./asset/js/home.js"></script>
</body>
</html>