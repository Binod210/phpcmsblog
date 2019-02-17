<?php
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;

if(isset($_POST['AddCategory'])){
	$categoryName= $_POST['CategoryName'];
	if(empty($categoryName)){
		$_SESSION['Error']="Category name should be entered";
				header("Location:addCategory.php");
				exit();
	}
	else{
		$query = "select * from category where name='$categoryName'";
		$result = mysqli_query($conn, $query) or die(mysqli_errno($conn));
		if (mysqli_num_rows($result) >0){
			$_SESSION['Error']="Category already exists";
				header("Location:addCategory.php");
				exit();
			
		}
		else{
			$timestamp=time();
			$insertQuery = "insert into category(name, timestamp) values('$categoryName', '$timestamp')";
			$execute=mysqli_query($conn, $insertQuery);
			if($execute){
				$_SESSION['Success']="Category Added Successfully";
				header("Location:addCategory.php");
				exit();
			}
			else{
				$_SESSION['Error']=mysqli_errno($conn);
				header("Location:addCategory.php");
				exit();
			}
		}
		
	}
	
}

?>
<?php
$countUnreadrequest="select * from requestedpost where status='unread'";
$requestcountresult=mysqli_query($conn,$countUnreadrequest) or die(mysqli_errno($conn));
$r_count=mysqli_num_rows($requestcountresult);
$countpendingcomments="select * from comments where status='Pending'";
$pendingcountresult=mysqli_query($conn,$countpendingcomments) or die(mysqli_errno($conn));
$p_count=mysqli_num_rows($pendingcountresult);
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
<title>Admin Panel | Add Category</title>
</head>

<body>
<nav class="navbar navbar-default nav-bar-size" role="navigation">
<div class="container">
	<a href="index.php"><div class="navbar-brand"><img src="imgs/logo.jpg" width="50px" height="50px" style="margin-top: -15px;"></div>
	<div class="nav navbar-nav">
		<h4>P & E Studio</h4>
	</div>
	</a>
</div>
	
</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2" style="background: #DF4E50;">
			<h2><center>Admin Panel</center></h2>
			<ul class="nav nav-pills nav-stacked" id="SideBar">
				<li><a href="adminDashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
				<li><a href="addPost.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Post</a></li>	
				<li class="active"><a href="addCategory.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Category</a></li>
				<?php if($p_count>0){?>
					<li><a href="manageComments.php"><span class="glyphicon glyphicon-send"></span>&nbsp; Comment&nbsp;&nbsp;<i class="alert-success"><?php echo($p_count); ?></i></a></li>
				<?php }else{?>
					<li><a href="manageComments.php"><span class="glyphicon glyphicon-send"></span>&nbsp; Comment</a></li>
				<?php }?>
	
			<?php if($r_count>0){?>
				<li><a href="manageRequests.php"><span class="glyphicon glyphicon-question-sign"></span>&nbsp; Requests&nbsp;&nbsp;<i class="alert-success"><?php echo($r_count); ?></a></li>
					
				<?php }else{?>
					<li><a href="manageRequests.php"><span class="glyphicon glyphicon-question-sign"></span>&nbsp; Requests</a></li>
				<?php }?>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
			</ul>
		</div>
		<div class="col-sm-8"  id="formstyle">
		<?php echo(session_message());?>
			
			<form action="addCategory.php" method="post">
				<fieldset>
					<div class="form-group">
						<label for="categoryInput">Name:</label>
						<input class="form-control" type="text" id="categoryInput" name="CategoryName" placeholder="Enter Category name">
					</div>
					<input type="submit" class="btn btn-info" name="AddCategory" value="Add Category">
				</fieldset>
			</form>
			<br>
			<div>
				<table class="table-responsive table table-striped table-hover">
					<tr>
						<th>S.N.</th>
						<th>Name</th>
						<th>TimeStamp</th>
					</tr>
					<?php 
					$categoryQuery = "select * from category";
					$tableresult = mysqli_query($conn, $categoryQuery) or die(mysqli_errno($conn));
					$id=0;
					while($row=mysqli_fetch_array($tableresult)){
						$id+=1;
						$c_name=$row['name'];
						$c_stamp=$row['timestamp'];
						?>
						<tr>
							<td><?php echo($id); ?></td>
							<td><?php echo($c_name); ?></td>
							<td><?php 
				$datetime =strftime("%B-%d-%Y", $c_stamp);
				echo($datetime); ?></td>
						</tr>
						<?php
					}
					
					?>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>