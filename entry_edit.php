<?php
session_start();
require_once('authenticate.php');

$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if(isset($_POST['category'])) {
		$customer_update = pg_query("UPDATE entries SET category='".$_POST['category']."'  WHERE entry_time = '".$_POST['date']."'");
	}
	if(isset($_POST['portion'])) {
		$customer_update = pg_query("UPDATE entries SET portion='".$_POST['portion']."'  WHERE entry_time = '".$_POST['date']."'");
	}
	if(isset($_POST['calories'])) {
		$customer_update = pg_query("UPDATE entries SET calories='".$_POST['calories']."'  WHERE entry_time = '".$_POST['date']."'");
	}
	if(isset($_POST['feel'])) {
		$customer_update = pg_query("UPDATE entries SET feel='".$_POST['feel']."'  WHERE entry_time = '".$_POST['date']."'");
	} 
} else if (isset($_REQUEST['delete'])) {
	$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
	$customer_info = pg_query("DELETE FROM entries WHERE url = '".$_REQUEST['url']."'");
	header("Content-type: application/json");
	print(json_encode(true));
	exit();
    } 
?>