<?php
	$page = array(
					"main"	=>	"Main Page"
				);

	foreach($page as $x => $tag) {
	    if(isset($_GET['action']) && $_GET['action'] == $x){
			$title = $tag;
	    }elseif(isset($_GET['module']) && $_GET['module'] == $x){
			$title = $tag;
	    }elseif(isset($_SESSION['acc_idproj']) && isset($_GET['module']) != $x){
			$title = "Dashboard";
		}elseif(!isset($_SESSION['acc_idproj'])){
			$title = "Login Page";
		}
	}
?>