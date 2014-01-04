<?php
	session_start();
	require_once('dietitian_authenticate.php');

	$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Dietitian Page</title>
		<script src="http://www.cs.unc.edu/Courses/comp426-f13/jquery-1.10.2.js"></script>
		<script src="dietitian.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    	<link rel="shortcut icon" href="images/logo_new.png">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">

	    <!-- Custom styles for this template -->
	    <link href="css/home.css" type="text/css" rel="stylesheet">
	    <link href="css/tableview.css" type="text/css" rel="stylesheet">

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
	            <img class="circlepic" src="images/logo_small.png">
	          </a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	            <li><a href="/">Home</a></li>
	            <li><a href="/view.php">Calendar View</a></li>
	            <li><a href="/customer.php">Table View</a></li>
	            <li class="active"><a href="/dietitian.php">Dietitians</a></li>
	          </ul>
	        </div><!-- /.nav-collapse -->
	      </div><!-- /.container -->
	    </div><!-- /.navbar -->

		<h1>Welcome, Dietitian!</h1>
		<br><button onclick="logout()">Logout</button>
		<h2>Please choose a patient:</h2>
		<table>
			<?php
				$customers = pg_query("select full_name, profile_picture, type, username from customers");
				while ($customer = pg_fetch_array($customers, null, PGSQL_ASSOC)) {
					print "\t<tr>\n";
					print "\t\t<td><a href=\"view.php/".$customer['username']."\"><img class=\"profilepic\" src=\"".$customer['profile_picture']."\"></a></td>\n";
					print "\t\t<td><a href=\"view.php/".$customer['username']."\">".$customer['full_name']."</a><br>".$customer['type']."</td>\n";
					print "\t</tr>\n";
				}
			?>
		</table>
	</body>
</html>