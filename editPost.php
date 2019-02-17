<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
$id =$_GET['id'];

if(isset($_POST['Submit'])){
	$title=mysqli_real_escape_string($conn,$_POST['postTitle']);
	$tags=mysqli_real_escape_string($conn,$_POST['postTags']);
	$category=mysqli_real_escape_string($conn,$_POST['postCategory']);
	$desc=mysqli_real_escape_string($conn,$_POST['postDesc']);
	
	
		
		$timestamp=time();
		$addPostQuery="update blogposts set title='$title',tags='$tags',category='$category',description = '$desc' where id='$id'";
		$r=mysqli_query($conn,$addPostQuery);
		if($r){
			$_SESSION['Error']="Post Added Successfully";
				
			header("Location:adminDashboard.php?page=1");
			exit();
		}
		else{
			$_SESSION['Error']=mysqli_error($conn);
				
			header("Location:adminDashboard.php?page=1");
			exit();
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
<title>Admin Panel | Edit Post</title>
</head>

<body>

<nav class="navbar navbar-default nav-bar-size" role="navigation">
<div class="container">
	<div class="navbar-brand"><a href="#"><img src="imgs/logo.jpg" width="50px" height="50px" style="margin-top: -15px;"></a></div>
	<div class="nav navbar-nav">
		<h4>P & E Studio</h4>
	</div>
</div>
	
</nav>
<div class="container-fluid">
	<div class="row">
	<div class="col-sm-2" style="background: #DF4E50;">
			<h2><center>Admin Panel</center></h2>
			<ul class="nav nav-pills nav-stacked" id="SideBar">
				<li><a href="adminDashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
				<li class="active"><a href="addPost.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Post</a></li>	
				<li><a href="addCategory.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Category</a></li>
				<li><a href="manageComments.php"><span class="glyphicon glyphicon-send"></span>&nbsp; Comment</a></li>
				<li><a href="manageRequests.php"><span class="glyphicon glyphicon-question-sign"></span>&nbsp; Requests</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
			</ul>
		</div>
		<div class="col-sm-1"><br></div>
		
		<div class="col-sm-8">
		<?php echo(session_message());?>
		<?php
			$findquery = "select * from blogposts where id = '$id'";
			$find_result = mysqli_query($conn, $findquery) or die(mysqli_error($conn));
			while($row=mysqli_fetch_array($find_result)){
				$findTitle= $row['title'];
				$findTags= $row['tags'];
				$findCategory= $row['category'];
				$findDescription= $row['description'];
			}
			?>
		<div style="background: #DDA5DB; padding: 10px;" >
			<h1><center>Edit Post</center></h1>
			
			<form action="editPost.php?id=<?php echo($id);?>" method="post">
			<fieldset>
				<div class="form-group">
					<label for="postTitle">Title</label>
					<input type="text" name="postTitle" id="postTitle" value="<?php echo($findTitle);?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="postTags">Tags</label>
					<input type="text" name="postTags" id="postTags" value="<?php echo($findTags);?>" class="form-control">
				</div>
				<div class="form-group">
					<label for="postCategory">Category</label>
					<select class="form-control" id="postCategory" name="postCategory">
						<?php
						$categoryQuery="select * from category order by name asc";
						$result = mysqli_query($conn, $categoryQuery) or die(mysqli_errno($conn));
						while($row=mysqli_fetch_array($result)){
							if($row['name']==$findCategory){ ?>
								<option selected><?php echo($row['name']); ?> </option>
							<?php }else{
							?>
							<option><?php echo($row['name']); ?> </option>
						<?php }}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="postDesc">Description</label>
					<textarea class="form-control" name="postDesc" id="postDesc"><?php echo($findDescription);?></textarea>
				</div>
				<input type="submit" class="btn btn-block btn-primary" value="Edit Post" name="Submit">
			</fieldset>
				
			</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>