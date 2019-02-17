<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
$id = $_GET['id'];
$query = "delete from blogposts where id = $id";
$result=mysqli_query($conn,$query);
if($result){
	$r_c="delete from comments where pid ='$id'";
	$exectued=mysqli_query($conn,$r_c);
	if($exectued){
		$_SESSION['Success']="Post Deleted successfully";
		header('Location:adminDashboard.php?page=1');
		exit();
	}
	else{
		echo(mysqli_error($conn));
		$_SESSION['Error']=mysqli_error($conn);
		header('Location:adminDashboard.php?page=1');
		exit();
	}
}
else{
	$_SESSION['Error']=mysqli_error($conn);
		header('Location:adminDashboard.php?page=1');
		exit();
}


?>