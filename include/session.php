<?php
session_start();

function session_message(){
	if(isset($_SESSION['Success'])){
		$output = "<div class=\"alert alert-success fade in\">";
		$output.=htmlentities($_SESSION['Success']);
		$output.="</div>";
		$_SESSION['Success']=null;
		return($output);
	}
	if(isset($_SESSION['Error'])){
		$output = "<div class=\"alert alert-danger fade in\">";
		$output.=htmlentities($_SESSION['Error']);
		$output.="</div>";
		$_SESSION['Error']=null;
		return($output);
		
	}
}

?>