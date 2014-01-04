<?php
date_default_timezone_set('EST');

if($_GET) print $_GET['hub_challenge'];

$file = "/var/www/html/dir/json.html";
$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
fwrite($handle,file_get_contents('php://input'));
$notification = json_decode(file_get_contents('php://input'));

$result = json_decode(file_get_contents('https://api.instagram.com/v1/tags/healthybytes/media/recent/?client_id=b67a5543c0ae4f3287a82e5078f47ae0'));
$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");

for($i=0;$i<count($notification);$i++) {
	$caption = $result->data[$i]->caption->text;
	$image_url = $result->data[$i]->images->standard_resolution->url;
	$customer = $result->data[$i]->user->username;
	$created_time = date('d M Y h:i:s a e',  $result->data[$i]->created_time);
	print $caption."\n";
	print $image_url."\n";
	print $customer."\n";
	print $created_time."\n";
	$query = "INSERT INTO entries (caption, url, customer_name, entry_time) values ('$caption','$image_url', '$customer', '$created_time')";
	pg_query($query) or die('Query failed: ' . pg_last_error());

}

print_r($data);
 ?>
