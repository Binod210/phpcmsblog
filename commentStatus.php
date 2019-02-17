<?php 
require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
$id=$_GET['id'];
$action=$_GET['action'];
if($action=='approve'){
	$query="update comments set status = 'Approved' where id ='$id'";
}
elseif($action=='disapprove'){
	$query="update comments set status = 'Disapproved' where id ='$id'";
}
$execute=mysqli_query($conn, $query);
if($execute){
	$_SESSION['Success']="Comment Status Change Successfully";
	header("Location:manageComments.php");
	exit();
}
else{
	$_SESSION['Success']=mysqli_error($conn);
	header("Location:manageComments.php");
	exit();
}
?>