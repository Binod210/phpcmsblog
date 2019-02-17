<?php
require_once('include/connection.php');
global $conn;
 if(isset($_POST['Submit'])){
	 $name=mysqli_real_escape_string($conn,$_POST['name']);
	 $email=mysqli_real_escape_string($conn,$_POST['email']);
	 $about=mysqli_real_escape_string($conn,$_POST['about']);
	 $timestamp=time();
	 
	 if(empty($name)|empty($email)|empty($about) ){
		 header('Location:index.php');
	 }
	 else{
		 $query = "insert into requestedpost(name,email, about, timestamp, status) values('$name','$email','$about','$timestamp','unread')";
		 if( mysqli_query($conn,$query)){
			 header('Location:index.php');
		 }
		 else{
			 header('Location:index.php');
		 }
	 }
 }

?>