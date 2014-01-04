<?php
session_start();
if(isset($_COOKIE['session_id']) or $_COOKIE['session_id']==md5($_SESSION['username']." ".$_SERVER['REMOTE_ADDR']." ".$_SESSION['authsalt'])) {
	header("Location: /customer.php");
    exit();
	}

if(isset($_GET['code'])) {	
	$url = "https://api.instagram.com/oauth/access_token";
	$post_params = array (
		"client_id"=>"b67a5543c0ae4f3287a82e5078f47ae0",
		"client_secret"=>"3efb9193b7e049aa9b910c2773d1294c",
		"grant_type"=>"authorization_code",
		"redirect_uri"=>"http://54.200.197.190/login.php",
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
		$new_customer_query = pg_query("INSERT INTO customers (username, full_name, profile_picture) values ('".$response->user->username."','".$response->user->full_name."','".$response->user->profile_picture."')");
		if(!$new_customer_query) {$new_customer_query = pg_query("update customers set username = '".$response->user->username."', full_name = '".$response->user->full_name."', profile_picture = '".$response->user->profile_picture."' where username = '".$response->user->username."'");} 
		header("Location: /customer.php");
		exit();
	}

	else { 
		header("Location: /login.php");
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
    <div class="navbar navbar-inverse" id="bar" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Healthy Bytes
            <img alt="circle pic" class="circlepic" src="images/logo_small.png">
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/index.html">Home</a></li>
            <li><a href="/view.php">Calendar View</a></li>
            <li><a href="/customer.php">Table View</a></li>
            <li><a href="/dietitian.php">Dietitians</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <a href="https://instagram.com/oauth/authorize/?client_id=b67a5543c0ae4f3287a82e5078f47ae0&amp;redirect_uri=http://54.200.197.190/login.php&amp;response_type=code"><h3>Sign-in with Instagram!</h3></a>
    <br>
    <br>
</body>
</html>