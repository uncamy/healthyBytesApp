<?php
if(!isset($_COOKIE['session_id'])||$_COOKIE['session_id']!=md5($_SESSION['username']." ".$_SERVER['REMOTE_ADDR']." ".$_SESSION['authsalt'])) {
	header("Location: /dietitian_login.php");
    exit();
	}
?>