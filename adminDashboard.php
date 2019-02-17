<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
if(isset($_GET['page'])){
	$page=$_GET['page'];
}
else{
	header("Location:adminDashboard.php?page=1");
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
<title>Admin Panel | Dashboard</title>
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
				<li class="active"><a href="adminDashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
				<li><a href="addPost.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Post</a></li>	
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
		
		<div class="col-sm-9">
		<?php echo(session_message());?>
		<?php 
			if($page<1){
				$startpoint=0;
			}else{
			$startpoint= ($page*4)-4;}
			$query = "select * from blogposts limit $startpoint,4";
			$result = mysqli_query($conn, $query) or  die(mysqli_errno($conn));
			while($row = mysqli_fetch_array($result)){
				
			
		?>
			<div class="postbox">
				Published by <?php echo($row['uploadby']); ?> at 
				<i><?php 
				$datetime =strftime("%B-%d-%Y", $row['timestamp']);
				echo($datetime); ?></i>
				<p> <img src="blogimages/<?php echo($row['image']); ?>" class="img-rounded" width="100px" height="100px" align="left" style="margin-right: 10px;">
				<b><?php echo($row['title']); ?></b><br>

			<?php
				if(strlen($row['description'])>200){
					echo(substr($row['description'],0,200)."...");
				}
				else{
					echo($row['description']);
				}
				 ?>
			</p>
		<a href="editPost.php?id=<?php echo($row['id']);?>"><button class="btn btn-success" style="margin: 10px">Edit</button></a>
		<a href="fullPost.php?id=<?php echo($row['id']);?>"><button class="btn btn-primary" style="margin: 10px">Live Preview</button></a>
		<a href="postDelete.php?id=<?php echo($row['id']);?>"><button class="btn btn-danger" style="margin: 10px">Delete</button></a>
			</div>
			<?php  } ?>
			
			<nav>
			<ul class="pagination">
			<?php
				if($page>1){?>
				<li><a href="adminDashboard.php".php?page=<?php echo($page-1);?>">&laquo;</a></li>
				<?php }
				?>
			<?php
			$countQuery = "Select * from blogposts";
			$result =mysqli_query($conn, $countQuery) or die(mysqli_errno($conn));
			$count = mysqli_num_rows($result);
			$pagecount=$count/4;
			$pagecount=ceil($pagecount);
			for($i=1;$i<=$pagecount;$i++){
				if($i==$page){?>
				<li class="active" ><a href="adminDashboard.php?page=<?php echo($i);?>"><?php echo($i);?></a></li>
			<?php }else{?>
					<li><a href="adminDashboard.php?page=<?php echo($i);?>"><?php echo($i);?></a></li>
				<?php }}
			?>
			<?php
				if($page<$pagecount){?>
				<li><a href="adminDashboard.php?page=<?php echo($page+1);?>">&raquo;</a></li>
				<?php }
				?>
			</ul>
			</nav>
		</div>
	</div>
</div>
</body>
</html>