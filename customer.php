<?php
	session_start();
	require_once('authenticate.php');

	$dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Customer Page</title>
		<!-- Bootstrap core CSS -->
    	<link href="http://54.200.197.190/bootstrap/css/bootstrap.css" rel="stylesheet">

    	<!-- Custom styles for this template -->
    	<link href="http://54.200.197.190/css/home.css" type="text/css" rel="stylesheet">
    	<link href="http://54.200.197.190/css/tableview.css" type="text/css" rel="stylesheet">
		<script src="http://www.cs.unc.edu/Courses/comp426-f13/jquery-1.10.2.js"></script>
		<script src="http://54.200.197.190/customer.js"></script>
		<style>#full_name {font-size:160%;}</style>
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
	          <a class="navbar-brand" href="/index.html">Healthy Bytes
	            <img alt="circle pic" class="circlepic" src="http://54.200.197.190/images/logo_small.png">
	          </a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
					<li><a href="/index.html">Home</a></li>
            		<li><a href="/view.php">Calendar View</a></li>
            		<li class="active"><a href="/customer.php">Table View</a></li>
            		<li><a href="/dietitian.php">Dietitians</a></li>
	          </ul>
	        </div><!-- /.nav-collapse -->
	      </div><!-- /.container -->
	    </div><!-- /.navbar -->
		<?php
			if(isset($_SERVER['PATH_INFO'])) {
				$path_components = explode('/', $_SERVER['PATH_INFO']);
				if ((count($path_components) >= 2) && ($path_components[1] != "")) {
					display_customer($path_components['1']);
				}
			}
			else {
				display_customer($_SESSION['username']);
			}
			function display_customer($username) {
		?>
	
		<table>
			<tbody>
				<tr>
					<td rowspan="2">
						<?php 
							$customer_info = pg_query("SELECT * FROM customers WHERE username = '".$username."'");
							$customer_array = pg_fetch_assoc($customer_info,0);
							print "<img class=\"profilepic\" src=\"" .$customer_array['profile_picture']. "\">"; ?>
					</td>
					<td colspan="4">
						<b id="full_name"><?php print $customer_array['full_name']; ?></b>
					</td>
				</tr>
				<tr>
					<td>Profile Type: <b><?php print ucwords($customer_array['type']); ?></b></td>
					<td>&nbsp;&nbsp;Sex: <b><?php print ucwords($customer_array['sex']); ?></b></td>
					<td>&nbsp;&nbsp;Weight: <b><?php print $customer_array['weight']; ?> lbs</b></td>
					<td>&nbsp;&nbsp;Height: <b><?php print $customer_array['height']; ?> in</b></td>
				</tr>
			</tbody>
		</table>

		<button onclick="edit()">Edit Your Profile</button><br>
		<br><button onclick="logout()">Logout</button><br><br>
		<?php
			$customer_query = pg_query("SELECT caption, url, entry_time, category, portion, calories, feel FROM entries WHERE customer_name = '".$customer_array['username']."' order by entry_time desc");
			print "<table class=\"food-table\">\n";
	        print "\t<tr class=\"food-table\">\n";
	        print "\t\t<th class=\"food-table\">Caption</th>\n";
	        print "\t\t<th class=\"food-table\">Food</th>\n";
	        print "\t\t<th class=\"food-table\">Time</th>\n";
	        print "\t\t<th class=\"food-table\">Food Type</th>\n";
	        print "\t\t<th class=\"food-table\">Portion Eaten</th>\n";
	        print "\t\t<th class=\"food-table\">Calories</th>\n";
	        print "\t\t<th class=\"food-table\">How I Felt</th>\n";
	        print "\t\t<th class=\"food-table\">Delete?</th>\n";
	        print "\t</tr>\n";
	        $row_id = 0;
	        while($entry = pg_fetch_array($customer_query, null, PGSQL_ASSOC)) {
	            print "\t<tr id =\"".$row_id."\" class=\"food-table\">\n";
	            $i = 1;
	            $date;
	            foreach($entry as $value) {
	                if (strpos($value,'jpg')!==false) {print "\t\t<td><img class=\"foodpic\" src=\"$value\"></td>\n"; $url = $value;}
	                else if ($i==3) {$date = $value; print "\t\t<td>$value</td>\n"; }
	                else if ($i==4) {
	                	print "\t\t<td class=\"food-table\"><select date=\"".$date."\" class=\"category\">
						    <option value=\"blank\"></option>
						  	<option ". (($value=='fruits')? ' selected ':'')."value=\"fruits\">Fruits</option>
						  	<option ". (($value=='vegetables')? ' selected ':'')."value=\"vegetables\">Vegetables</option>
						  	<option ". (($value=='dairy')? ' selected ':'')."value=\"dairy\">Dairy</option>
						  	<option ". (($value=='meat or protein')? ' selected ':'')."value=\"meat or protein\">Meat or Protein</option>
						  	<option ". (($value=='grains or starches')? ' selected ':'')."value=\"grains or starches\">Grains or Starches</option>
						  	<option ". (($value=='sweet snacks')? ' selected ':'')."value=\"sweet snacks\">Sweet Snacks</option>
						  	<option ". (($value=='salty snacks')? ' selected ':'')."value=\"salty snacks\">Salty Snacks</option>
						  	<option ". (($value=='hydration')? ' selected ':'')."value=\"hydration\">Hydration</option>
							</select></td>\n"; 
					}
					else if($i==5) {
						print "\t\t<td class=\"food-table\"><select date=\"".$date."\" class=\"portion\">
							<option value=\"blank\"></option>
							<option ". (($value=='less')? ' selected ':'')."value=\"less\">Less than Half</option>
							<option ". (($value=='half')? ' selected ':'')."value=\"half\">Half</option>
							<option ". (($value=='more')? ' selected ':'')."value=\"more\">More than half</option>
							<option ". (($value=='all')? ' selected ':'')."value=\"all\">All</option>
						</select></td>\n";
					}
					else if($i==6) {
						print "\t\t<td class=\"food-table\"><input type = \"text\" value = \"".$value."\"date=\"".$date."\" class=\"calories\"></td>";
					}
					else if($i==7) {
						print "\t\t<td class=\"food-table\"><select date=\"".$date."\" class=\"feel\">
							<option value=\"blank\"></option>
							<option ". (($value=='satisfied')? ' selected ':'')."value=\"satisfied\">Satisfied</option>
							<option ". (($value=='guilty')? ' selected ':'')."value=\"guilty\">Guilty</option>
							<option ". (($value=='sad')? ' selected ':'')."value=\"sad\">Sad</option>
							<option ". (($value=='happy')? ' selected ':'')."value=\"happy\">Happy</option>
						</select></td>\n";
						print "<td><button onclick=\"deleteRow(".$row_id.",'".$url."')\">Delete</button></td>";
					}
					else {print "\t\t<td class=\"food-table\">$value</td>\n"; }
					$i++;
	            }
	            print "\t</tr>\n";
	            $row_id++;
	        }
			print "</table>\n";
		}

		?>
	</body>
</html>
