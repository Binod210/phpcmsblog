<?php
require_once("include/connection.php");
global $conn;
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$query = "select * from blogposts where id='$id'";
	$result = mysqli_query($conn,$query) or die(mysqli_errno($conn));
	while($row=mysqli_fetch_array($result)){
		$title = $row['title'];
		$tags = $row['tags'];
		$image = $row['image'];
		$desc = $row['description'];
		$postedby = $row['uploadby'];
		$timestamp = $row['timestamp'];
	}
}else{
	header("Location:Index.php");
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
 <link rel="stylesheet" href="css/frontStyle.css">
<title>P & E Studio</title>
</head>

<body>
<nav class="navbar navbar-default nav-bar-size" role="navigation">
<div class="container">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
	<span class="sr-only">Toggle</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>
	<a href="Index.php"><div class="navbar-brand"><img src="imgs/logo.jpg" width="50px" height="50px" style="margin-top: -15px;"></div>
	<div class="nav navbar-nav">
		<h4>P & E Studio</h4>
	</div></a>
	<div class="collapse navbar-collapse" id="menu">
	<ul class="nav navbar-nav" style="margin-left: 20px;">
	<li class="active"><a href="Index.php">Home</a></li>
	<li><a href="#">Category</a></li>
	<li><a href="#">About Us</a></li>
	<li><a href="#">Other</a></li>
		
	</ul>
	<form action="Index.php" class="navbar-form navbar-right">
		<div class="form-group">
			<input class="form-control" type="text" name="search" placeholder="Search">
		
		</div>
		<input type="submit" class="btn btn-success" name="BtnSearch" value="Search">
	</form>
	</div>
</div>
	
</nav>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8">
			
			<div class="posts">
			<div style="margin: 10px">
				<H3><?php echo($title);?></H3>
				<h6>Published by <b><?php echo($postedby);?></b> at <i> <?php 
				$datetime =strftime("%B-%d-%Y", $timestamp);
				echo($datetime); ?></i></h6>
				<center> <img src="blogimages/<?php echo($image);?>" class="img-responsive img-thumbnail" style="margin: 5px 0;"></center>
				<p><?php echo($desc);?></p>
				
				
				</div>
			</div>
			<div class="commentArea" style="margin-top: 10px;">
			<div class="comments">
			<?php 
				$commentQuery= "select * from comments where pid='$id' and status ='Approved'";
				$comment_result=mysqli_query($conn,$commentQuery) or die(mysqli_error($conn));
				$count = mysqli_num_rows($comment_result);
				
				?>
				<div class="commentHead">
					<h2>Comments(<?php echo($count);?>)</h2>
					<?php
					while($comment = mysqli_fetch_array($comment_result)){?>
						<div class="comment" style="box-shadow: 0 4px 8px 0 rgba(100,50,200,0.6); padding: 10px; margin-bottom: 10px">
							<b>By <?php echo($comment['name']);?></b><br>
							<i><?php $datetime =strftime("%B-%d-%Y", $comment['timestamp']); echo($datetime); ?></i>
							<p><?php echo($comment['comments']);?></p>
						</div>
					<?php }
					?>
				</div>
				</div>
				<hr>
				<div class="col-sm-2"></div>
				<div class="col-sm-5">
					<center><h3>Leave a Comment</h3></center>
					<form action="postComment.php?pid=<?php echo($id); ?>" method="post">
						<fieldset>
							<div class="form-group">
					
								<label for="Name">Name</label>
								<input type="text" class="form-control" id="Name" name="name" placeholder="Name">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="comment">Comment</label>
								<textarea class="form-control" id="comment" name ="comment" placeholder="Comment.."></textarea>
							</div>
							<input type="submit" class="btn btn-success" name="Submit" value="Submit">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h2 class="panel-title">Category</h2>
				</div>
				<div class="panel-body">
				<?php
					$categoryquery = "select * from category";
					$categoryResult = mysqli_query($conn,$categoryquery) or die(mysqli_errno($conn));
					while($category=mysqli_fetch_array($categoryResult)){?>
					<ul class="nav nav-pills">
						<li><a href="Index.php?page=1&category=<?php echo($category['name']); ?>"><?php echo($category['name']);?></a></li>
					</ul>
					<?php }
					?>
					
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 class="panel-title">Recent Posts</h2>
				</div>
				<div class="panel-body">
				<?php
					$postQuery = "select * from blogposts order by timestamp desc limit 0,5";
					$postResult = mysqli_query($conn,$postQuery) or die(mysqli_errno($conn));
					while($posts=mysqli_fetch_array($postResult)){?>
					<ul class="nav nav-pills">
						<li><a href="fullPost.php?id=<?php echo($posts['id']);?>"><?php echo($posts['title']);?></a></li>
					</ul>
					<?php }
					?>
					
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Request for Post</h2>
				</div>
				<div class="panel-body">
					<form method="post" action="requestpost.php">
						<fieldset>
							<div class="form-group">
								<label for="name">Name</label>
								<input class="form-control" name="name" id="name" type="text" placeholder="Name">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input class="form-control" name="email" id="email" type="email" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="about">About</label>
								<textarea class="form-control" name="about" id="about" type="text" placeholder="What you want to request"></textarea>
							</div>
							<input type="submit" class="btn btn-primary" name="Submit" value="Submit">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		</div>
		
		</div>
</body>
</html>