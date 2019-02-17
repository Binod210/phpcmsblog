<?php
require_once("include/session.php");

$_SESSION['user']=null;
session_destroy();
session_start();
$_SESSION['Success']="You are now Loged Out!";
header("Location:adminLogin.php");
exit();

?>