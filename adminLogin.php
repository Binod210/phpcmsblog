<?php 
require_once("include/connection.php");
require_once("include/session.php");
global $conn;
if(isset($_POST['Login'])){
	$username=mysqli_real_escape_string($conn,$_POST['username']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
	if(empty($username) | empty($password)){
		$_SESSION['Error']="Username and Password must be filled";
		header("Location:adminLogin.php");
		exit();
	}
	else{
		$query = "select * from admin where username ='$username' and password='$password'";
		$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
		if(mysqli_num_rows($result)>0){
			$_SESSION['Success']="Welcome Back $username";
			$_SESSION['user']=$username;
			header("Location:adminDashboard.php?page=1");
			
		exit();
			
		}
		else{
			$_SESSION['Error']="Wrong Username and Password";
		header("Location:adminLogin.php");
		exit();
		}
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" type="text/css" href="css/admin.css">
<title>Admin Panel | Dashboard</title>
</head>

<body>
<nav class="navbar navbar-default nav-bar-size" role="navigation">
<div class="container">
	<a href="Index.php"><div class="navbar-brand"><img src="imgs/logo.jpg" width="50px" height="50px" style="margin-top: -15px;"></div>
	<div class="nav navbar-nav">
		<h4>P & E Studio</h4>
	</div>
	</a>
</div>
	
</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4">
		<?php echo(session_message());?>
		<h2>Admin Login</h2>
			<form action="adminLogin.php" method="post">
				<fieldset>
					<div class="form-group">
					<label for="username">Username</label>
					<div class="input-group input-group-lg">
					<span class="input-group-addon text-primary">
						<span class="glyphicon glyphicon-user"></span>
					</span>
					<input type="text" class="form-control" name="username" id="username" placeholder="Username">
					</div>
					</div>
					<div class="form-group">
					<label for="password">Password</label>
					<div class="input-group input-group-lg">
					<span class="input-group-addon text-primary">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						</div>
					</div>
					<input type="submit" class="btn btn-primary" name="Login" value="Login">
				</fieldset>
			</form>
		</div>
	</div>
</div>
</body>
</html>