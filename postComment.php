<?php
require_once("include/connection.php");
global $conn;
$id = $_GET['pid'];
if(isset($_POST['Submit'])){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$comment = mysqli_real_escape_string($conn, $_POST['comment']);
	$timestamp = time();
	
	$query="insert into comments (pid,name,email, timestamp, comments,status) values('$id','$name','$email','$timestamp','$comment','Pending')";
	$executed=mysqli_query($conn,$query);
	if($executed){
		header("Location:fullPost.php?id=$id");
	}else{
		echo(mysqli_error($conn));
	}
}


?>