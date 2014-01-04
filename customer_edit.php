<?php
session_start();
require_once('authenticate.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
	$customer_update = pg_query("UPDATE customers SET type='".$_POST['type']."',sex='".$_POST['sex']."', weight='".$_POST['weight']."', height='".$_POST['height']."'  WHERE username = '".$_SESSION['username']."'");
	$customer_info = pg_query("SELECT * FROM customers WHERE username = '".$_SESSION['username']."'");
	if(!$customer_update) {
		header("HTTP/1.0 400 Bad Request");
      	print("Missing title");
      	exit();
	}
	$customer_array = pg_fetch_assoc($customer_info,0);
	header("Content-type: application/json");
	print json_encode($customer_array);
} else if($_SERVER['REQUEST_METHOD'] == "GET") {
	$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
	$customer_info = pg_query("SELECT * FROM customers WHERE username = '".$_SESSION['username']."'");
	$customer_array = pg_fetch_assoc($customer_info,0);
	header("Content-type: application/json");
	print json_encode($customer_array);
}

?>