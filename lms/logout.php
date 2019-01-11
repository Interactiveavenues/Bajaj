<?php ob_start();
	session_start();
	session_destroy();
	include 'config/config.php';
	header('Location:'.MYWEBSITE);

?>