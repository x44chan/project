<?php
	include '../config/conf.php';
	if(!isset($_GET['module'])){
		echo '<script type = "text/javascript">window.location.replace("/project/");</script>';
	}
	session_start();
?>
