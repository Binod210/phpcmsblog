<?php 
function Login(){
	if(isset($_SESSION['user'])){
		return true;
	}
}
function confirm_login(){
	if(!Login()){
		$_SESSION['Error']="Login Required!";
		header("Location:adminLogin.php");
		exit();
	}
}
?>