<!DOCTYPE html>
<html>
<head>
 	<title>Healthy Bytes</title>
        <meta charset="UTF-8"/>
	<style>table,tr,td,th {border: 1px solid black;}
		img {width:150px;}		
</style>
</head>
<body>
<h1 style="font-family:cursive; font-size:40px; color: green;"> Welcome to Healthy Bytes</h1> 
<h2 style="font-family:cursive; font-size:30px; color: green;"> Please Choose a Customer: </h2> <br>
<?php
$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");

// Performing SQL query
$query = 'SELECT * FROM entries';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
$customers = pg_query("select customer_name from entries group by customer_name order by count(*) desc");
$customer_id =0;
while ($customer = pg_fetch_array($customers, null, PGSQL_ASSOC)) {
	$file = "/var/www/html/dir/$customer_id.html";
	$handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
	fwrite($handle,"<!DOCTYPE html>\n
<html>\n
<head><title>Customer $customer_id</title><style>table,tr,td,th {border: 1px solid black;}
                img {width:150px;}
		table {position:absolute; top:150px; left:20px;}
</style></head>\n
<body>\n");
	fwrite($handle,"<table>\n");
	fwrite($handle,"\t<tr>\n");
		fwrite($handle, "\t\t<th>Caption</th>\n");
		fwrite($handle, "\t\t<th>Food</th>\n");
		fwrite($handle, "\t\t<th>Customer</th>\n");
		fwrite($handle, "\t\t<th>Time</th>\n");
	fwrite($handle, "\t</tr>\n");
	foreach($customer as $customer_name) {
		$customer_query = pg_query("SELECT * FROM entries WHERE customer_name = '$customer_name'");
		while($entry = pg_fetch_array($customer_query, null, PGSQL_ASSOC)) {
			fwrite($handle, "\t<tr>\n");
			foreach($entry as $value) {
				if (strpos($value,'jpg')!==false) {fwrite($handle, "\t\t<td><img src=\"$value\"></td>\n");}
     else {fwrite($handle,"\t\t<td>$value</td>\n"); };
			}
			fwrite($handle, "\t</tr>\n");
		}
		
}
fwrite($handle, "</table>\n<br><h2 style=\"font-family:cursive; font-size:30px; color: green;\">$customer_name's Daily Diet</h2>");
print "<a style = \"font-size: 20px; color:orange\" href=\"dir/$customer_id.html\">$customer_name</a><br>";
$customer_id++;} ?>
<p style="color:steelblue; font-size:20px; font-family:calibri;">To use this service, start pictures of your meals on <a href="http://instagram.com">Instagram</a> using the hashtag #healthybytes.</p> 
</body>
</html>
