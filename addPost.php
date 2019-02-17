<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;

if(isset($_POST['Submit'])){
	$title=mysqli_real_escape_string($conn,$_POST['postTitle']);
	$tags=mysqli_real_escape_string($conn,$_POST['postTags']);
	$category=mysqli_real_escape_string($conn,$_POST['postCategory']);
	$desc=mysqli_real_escape_string($conn,$_POST['postDesc']);
	$image="";
	$timestamp=time();
	if(empty($title) | empty($tags) | empty($desc)){
		$_SESSION['Error']="All fields are mandatory!";
				header("Location:addPost.php");
				exit();
	}
	else{
		if($_FILES['postImage']['name']==""){
			$image="default";
		}
		else{
			$image=$timestamp.'_'.rand(100,999).'.'.end(explode(".",$_FILES['postImage']['name']));
			$path ="blogimages/".basename($image);
			move_uploaded_file($_FILES['postImage']['tmp_name'],$path);
		
		}
		
		$addPostQuery="insert into blogposts(title,category, description,image, tags, timestamp,uploadby) values('$title','$category','$desc','$image','$tags','$timestamp','Admin')";
		$r=mysqli_query($conn,$addPostQuery);
		if($r){
			$_SESSION['Success']="Post Added Successfully";
				header("Location:addPost.php");
				exit();
			
			
		}
		else{
			$_SESSION['Error']=mysqli_error($conn);
				header("Location:addPost.php");
				exit();
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
<title>Admin Panel | Add Post</title>
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
				<li class="active"><a href="addPost.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Post</a></li>	
				<li><a href="addCategory.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Category</a></li>
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
		<div class="col-sm-1"><br></div>
		
		<div class="col-sm-8">
		<?php echo(session_message());?>
		<div style="background: #DDA5DB; padding: 10px;" >
			<h1><center>Add Post</center></h1>
			
			<form action="addPost.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<div class="form-group">
					<label for="postTitle">Title</label>
					<input type="text" name="postTitle" id="postTitle" placeholder="Enter Title..." class="form-control">
				</div>
				<div class="form-group">
					<label for="postTags">Tags</label>
					<input type="text" name="postTags" id="postTags" placeholder="Enter Tags...." class="form-control">
				</div>
				<div class="form-group">
					<label for="postCategory">Category</label>
					<select class="form-control" id="postCategory" name="postCategory">
						<?php
						$categoryQuery="select * from category order by name asc";
						$result = mysqli_query($conn, $categoryQuery) or die(mysqli_errno($conn));
						while($row=mysqli_fetch_array($result)){
							?>
							<option><?php echo($row['name']); ?> </option>
						<?php }
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="postDesc">Description</label>
					<textarea class="form-control" name="postDesc" id="postDesc" placeholder="Enter Description"></textarea>
				</div>
				<div class="form-group">
					<label for="postImage">Image</label>
					<input type="file" name="postImage" id="postIage"  class="form-control">
				</div>
				<input type="submit" class="btn btn-block btn-primary" value="Add Post" name="Submit">
			</fieldset>
				
			</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>