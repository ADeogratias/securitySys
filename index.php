<?php 
include('config.php');
include('server.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Log In</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <!-- FontAwesome Styles-->
    <link href="adminsmartsec/assets/css/font-awesome.css" rel="stylesheet" />
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/smart-sec.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="server.php">
					<span class="login100-form-title">
						Smart Security User Login
					</span>
					<?php include('adminsmartsec/errors.php'); 
						if(isset($_SESSION["error"])){
							$error = $_SESSION["error"];
							echo "<span style= color:red>$error</span> ";
						}
					?>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@bk.rw">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="login_user">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>