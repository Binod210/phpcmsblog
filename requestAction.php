<?php

require_once("include/connection.php");
require_once("include/session.php");
require_once("include/checkfunction.php");
confirm_login();
global $conn;
$id=$_GET['id'];
$action=$_GET['action'];

if($action=='read'){
	$query="update requestedpost set status = 'read' where id ='$id'";
}
elseif($action=='unread'){
	$query="update requestedpost set status = 'unread' where id ='$id'";
}

$execute=mysqli_query($conn, $query);
if($execute){
	$_SESSION['Success']="Request Status Change Successfully";
	header("Location:manageRequests.php");
	exit();
}
else{
	$_SESSION['Success']=mysqli_error($conn);
	header("Location:manageRequests.php");
	exit();
}?>