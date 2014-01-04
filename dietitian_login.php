<?php
session_start();
if(isset($_COOKIE['session_id']) or $_COOKIE['session_id']==md5($_SESSION['username']." ".$_SERVER['REMOTE_ADDR']." ".$_SESSION['authsalt'])) {
	header("Location: /dietitian.php");
    exit();
	}

if(isset($_GET['code'])) {	
	$url = "https://api.instagram.com/oauth/access_token";
	$post_params = array (
		"client_id"=>"54727895fca64a7e877e9dc197c0ec29",
		"client_secret"=>"f2dd121893c24d8291795bd82e10d7c3",
		"grant_type"=>"authorization_code",
		"redirect_uri"=>"http://54.200.197.190/dietitian_login.php",
		"code"=>$_GET['code']
	);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = json_decode(curl_exec($ch));
	curl_close($ch);

	if(isset($response->access_token)) {
		$_SESSION['username'] = $response->user->username;
		$_SESSION['authsalt'] = time();
		$auth_cookie_val = md5($_SESSION['username']." ".$_SERVER['REMOTE_ADDR']." ".$_SESSION['authsalt']);
		setcookie('session_id',$auth_cookie_val, 0, '/', '54.200.197.190',false);
		$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
		$new_dietitian_query = pg_query("INSERT INTO dietitians (username, full_name, profile_picture) values ('".$response->user->username."','".$response->user->full_name."','".$response->user->profile_picture."')");
		if(!$new_dietitian_query) {$new_dietitian_query = pg_query("update dietitians set username = '".$response->user->username."', full_name = '".$response->user->full_name."', profile_picture = '".$response->user->profile_picture."' where username = '".$response->user->username."'");} 
		header("Location: /dietitian.php");
		exit();
	}

	else { 
		header("Location: /dietitian_login.php");
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Healthy Bytes!</title>
	 <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/home.css" type="text/css" rel="stylesheet">
</head>
<body>
	<a href="https://instagram.com/oauth/authorize/?client_id=54727895fca64a7e877e9dc197c0ec29&redirect_uri=http://54.200.197.190/dietitian_login.php&response_type=code"><h3>Sign-in with Instagram!</h3></a>
	<br><br>
</body>
</html>