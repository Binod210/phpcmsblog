<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
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
<title>Admin Panel | Manage Comments</title>
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
		
		<div class="col-sm-2" style="background: #DF4E50;">
			<h2><center>Admin Panel</center></h2>
			<ul class="nav nav-pills nav-stacked" id="SideBar">
				<li><a href="adminDashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a></li>
				<li><a href="addPost.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Post</a></li>	
				<li><a href="addCategory.php"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp; Add Category</a></li>
				<?php if($p_count>0){?>
					<li><a href="manageComments.php"><span class="glyphicon glyphicon-send"></span>&nbsp; Comment&nbsp;&nbsp;<i class="alert-success"><?php echo($p_count); ?></i></a></li>
				<?php }else{?>
					<li><a href="manageComments.php"><span class="glyphicon glyphicon-send"></span>&nbsp; Comment</a></li>
<?php }?>
	
			<?php if($r_count>0){?>
				<li class="active"><a href="manageRequests.php"><span class="glyphicon glyphicon-question-sign"></span>&nbsp; Requests&nbsp;&nbsp;<i class="alert-success"><?php echo($r_count); ?></a></li>
					
				<?php }else{?>
					<li class="active"><a href="manageRequests.php"><span class="glyphicon glyphicon-question-sign"></span>&nbsp; Requests</a></li>
<?php }?>
			
				
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
			</ul>
		</div>
		<div class="col-sm-9">
		<?php echo(session_message());?>
		<div><h4>Unread Request</h4>
		<?php 
			$query = "select * from requestedpost where status ='unread'";
			$result =mysqli_query($conn, $query);
			while($requests=mysqli_fetch_array($result)){
			?>
			<div class="postbox">
				<div style="margin-top: 10px; margin-left: 10px;">
					<b><?php echo($requests['status']);?></b><br>
					<b>Post by <?php echo($requests['name']);?>(<i><?php echo($requests['email']);?></i>)</b><br>
					<i><?php $datetime =strftime("%B-%d-%Y", $requests['timestamp']);
				echo($datetime);?></i><br>
					<p><?php echo($requests['about']);?></p>
					<?php if ($requests['status']=='unread'){ ?>
					<a href="requestAction.php?id=<?php echo($requests['id']);?>&action=read"><button class="btn btn-success">Mark as Read</button></a>
					<?php } elseif($requests['status']=='read'){?>
					<a href="requestAction.php?id=<?php echo($requests['id']);?>&action=unread"><button class="btn btn-danger">Mark as Unread</button></a>
					<?php }?>
					
				</div>
			</div>
			<?php }?>
			</div>
			<div><h4>Read Request</h4>
		<?php 
			$query = "select * from requestedpost where status ='read'";
			$result =mysqli_query($conn, $query);
			while($requests=mysqli_fetch_array($result)){
			?>
			<div class="postbox">
				<div style="margin-top: 10px; margin-left: 10px;">
					<b><?php echo($requests['status']);?></b><br>
					<b>Post by <?php echo($requests['name']);?>(<i><?php echo($requests['email']);?></i>)</b><br>
					<i><?php $datetime =strftime("%B-%d-%Y", $requests['timestamp']);
				echo($datetime);?></i><br>
					<p><?php echo($requests['about']);?></p>
					<?php if ($requests['status']=='unread'){ ?>
					<a href="requestAction.php?id=<?php echo($requests['id']);?>&action=read"><button class="btn btn-success">Mark as Read</button></a>
					<?php } elseif($requests['status']=='read'){?>
					<a href="requestAction.php?id=<?php echo($requests['id']);?>&action=unread"><button class="btn btn-danger">Mark as Unread</button></a>
					<?php }?>
					
				</div>
			</div>
			<?php }?>
			</div>
		</div>
	</div></div>
</body>
</html>