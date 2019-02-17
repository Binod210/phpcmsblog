<?php 
require_once("include/connection.php");
global $conn;

if(isset($_GET['page'])){
	$page=$_GET['page'];
}
else{
	header("Location:Index.php?page=1");
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
	<form action="Index.php?page=1" class="navbar-form navbar-right" method="post">
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
		<?php
			
			if($page<1){
				$startpoint=0;
			}else{
			$startpoint= ($page*4)-4;}
			if(isset($_POST['BtnSearch'])){
				$searchparameter=$_POST['search'];
				$query = "select * from blogposts where title like '%$searchparameter%' or category like '%$searchparameter%' or description like '%$searchparameter%' or tags like '%$searchparameter%'";
			}
			elseif(isset($_GET['category'])){
				$categoryparameter=$_GET['category'];
				$query = "select * from blogposts where category ='$categoryparameter' limit $startpoint,4";
			}else{
			$query = "select * from blogposts limit $startpoint,4";
				}
			$result = mysqli_query($conn,$query) or die(mysqli_errno($conn));
			while($row = mysqli_fetch_array($result)){
				
			
			
			?>
			<div class="posts">
				<p style="margin-left: 10px; margin-right: 10px; margin-top: 5px;">
					<img src="blogimages/<?php echo($row['image']);?>" align="left" class="img-rounded" height="120px" width="120px" style="margin-right: 10px; margin-top: 5px;">
					<b><?php echo($row['title']); ?></b><br>
					<i><?php 
				$datetime =strftime("%B-%d-%Y", $row['timestamp']);
				echo($datetime); ?></i> &nbsp;<span class="glyphicon glyphicon-send"></span>&nbsp;<?php echo($row['category']);?><br>
					<i><b>By</b> <?php echo($row['uploadby']); ?></i><br>
					<?php
				if(strlen($row['description'])>500){
					echo(substr($row['description'],0,500)."...");
				}
				else{
					echo($row['description']);
				}
				 ?>
				 <a href="fullPost.php?id=<?php echo($row['id']);?>" class="btn btn-primary">Read More</a>
				</p>
			</div>
			<?php } ?>
			<?php if(!(isset($_POST['BtnSearch']))){?>
			<nav>
			<ul class="pagination">
			<?php
				if($page>1){
				if(isset($_GET['category'])){ ?>
					<li><a href="Index.php?page=<?php echo($page-1);?>&category=<?php echo($categoryparameter);?>">&laquo;</a></li>
				<?php }else{?>
				<li><a href="Index.php?page=<?php echo($page-1);?>">&laquo;</a></li>
				<?php }}
				?>
			<?php
			if(isset($_GET['category'])){
				$categoryparameter =$_GET['category'];
				$countQuery = "Select * from blogposts where category = '$categoryparameter'";
			}
			else{
			$countQuery = "Select * from blogposts";
			}
			$result =mysqli_query($conn, $countQuery) or die(mysqli_errno($conn));
			$count = mysqli_num_rows($result);
			$pagecount=$count/4;
			$pagecount=ceil($pagecount);
			for($i=1;$i<=$pagecount;$i++){
				if($i==$page){
			
				if(isset($_GET['category'])){ ?>
					<li class="active"><a href="Index.php?page=<?php echo($i);?>&category=<?php echo($categoryparameter);?>"><?php echo($i);?></a></li>
				<?php }else{?>
				<li class="active"><a href="Index.php?page=<?php echo($i);?>"><?php echo($i);?></a></li>
				<?php }
				?>
				
			<?php }else{?>
					<?php if(isset($_GET['category'])){ ?>
					<li><a href="Index.php?page=<?php echo($i);?>&category=<?php echo($categoryparameter);?>"><?php echo($i);?></a></li>
				<?php }else{?>
				<li><a href="Index.php?page=<?php echo($i);?>"><?php echo($i);?></a></li>
				<?php }
				?>
				<?php }}
			?>
			
				<?php
				if($page<$pagecount){
				if(isset($_GET['category'])){ ?>
					<li><a href="Index.php?page=<?php echo($page+1);?>&category=<?php echo($categoryparameter);?>">&raquo;</a></li>
				<?php }else{?>
				<li><a href="Index.php?page=<?php echo($page+1);?>">&raquo;</a></li>
				<?php }}
				?>
			</ul>
			</nav>
			<?php }  ?>
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