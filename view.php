<?php
  session_start();
  require_once('authenticate.php');

  $dbconn =  pg_connect("host=healthybytes.cwy4vi0q7lmp.us-east-1.rds.amazonaws.com port=5432 dbname=healthybytesdb user=healthybytes password=abcd1234");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="/images/logo_new.png">
    <style>#full_name {font-size:160%;}</style>
    <title>Healthy Bytes</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/home.css" type="text/css" rel="stylesheet">
    <link href="/css/view.css" type="text/css" rel="stylesheet">
    <link href="/css/scrollable.css" type="text/css" rel="stylesheet">
    <script>
    function logout() {
      document.cookie = 'session_id' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT';
      var frame = document.createElement("iframe");
      frame.src = 'http://instagram.com/accounts/logout/';
      frame.onload = function() {
          location.reload();
      };
      document.body.appendChild(frame);
    }
</script>

  </head>

  <body>
<!-- See http://www.smoothdivscroll.com/multipleAutoscrollers.html -->
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
            <img class="circlepic" src="/images/logo_small.png">
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
	     <li><a href="/index.html">Home</a></li>
            <li class="active"><a href="/view.html">Calendar View</a></li>
            <li><a href="/customer.php">Table View</a></li>
            <li><a href="/dietitian.php">Dietitians</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">
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
        $customer_info = pg_query("SELECT * FROM customers WHERE username = '".$username."'");
        $customer_array = pg_fetch_assoc($customer_info,0);
        print "<img class=\"profilepic\" src=\"" .$customer_array['profile_picture']. "\">"; ?>
       <b id="full_name"><?php print $customer_array['full_name']; ?></b><br>
      <br><button onclick="logout()">Log out</button><br><br>
      </div>
      <div class="parent">
        <div>Breakfast (12 AM to 10 AM): </div> 
        <div id="SunBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=0 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="MonBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=1 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="TueBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=2 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="WedBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=3 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="ThuBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=4 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="FriBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=5 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="SatBF" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=6 and date_part('hour',entry_time)>=0 and date_part('hour',entry_time)<10");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>
      </div>

      <div class="parent">
        <div>Lunch (10 AM to 5 PM): </div> 
        <div id="SunLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=0 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="MonLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=1 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="TueLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=2 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="WedLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=3 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="ThuLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=4 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="FriLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=5 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="SatLun" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=6 and date_part('hour',entry_time)>=10 and date_part('hour',entry_time)<17");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>
      </div>

      <div class="parent">
        <div>Dinner (5 PM to 12 AM): </div> 
        <div id="SunDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=0 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="MonDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=1 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="TueDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=2 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="WedDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=3 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="ThuDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=4 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="FriDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=5 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          }?>
        </div>

        <div id="SatDin" class="makeMeScrollable col-lg-1">
          <?php
            $entries_query = pg_query("SELECT url FROM entries WHERE customer_name = '".$username."' and extract(dow from entry_time)=6 and date_part('hour',entry_time)>=17 and date_part('hour',entry_time)<=23");
            $entries_array = pg_fetch_all($entries_query);
            if(!$entries_array) {
                  print "<img src=\"/images/no_image.png\" alt=\"No Image\" width=\"128\">"; }
            else { foreach($entries_array as $row) {
                  print "<img width=\"128\" class=\"foodpic\" alt=\"Food Pic\" src=\"".$row['url']."\">\n";}
          } }?>
        </div>
      </div>

      </div>

      <div class="parent">
        <div>Weekday</div> 
        <div id="Sunday" class="col-lg-1">Sunday</div>

        <div id="Monday" class="col-lg-1">Monday</div>

        <div id="Tuesday" class="col-lg-1">Tuesday</div>

        <div id="Wednesday" class="col-lg-1">Wednesday</div>

        <div id="Thursday" class="col-lg-1">Thursday</div>

        <div id="Friday" class="col-lg-1">Friday</div>

        <div id="Saturday" class="col-lg-1">Saturday</div>
      </div>



      <!-- Site footer -->

    </div> <!-- /container -->
    <div class="footer">
      <p>&copy; Healthy Bytes 2013</p>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  <!-- jQuery library - Please load it from Google API's -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

  <!-- jQuery UI (Custom Download containing only Widget and Effects Core)
       You can make your own at: http://jqueryui.com/download -->
  <script src="/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
  
  <!-- Latest version (3.1.4) of jQuery Mouse Wheel by Brandon Aaron
       You will find it here: https://github.com/brandonaaron/jquery-mousewheel -->
  <script src="/js/jquery.mousewheel.min.js" type="text/javascript"></script>

  <!-- jQuery Kinectic (1.8.2) used for touch scrolling -->
  <!-- https://github.com/davetayls/jquery.kinetic/ -->
  <script src="/js/jquery.kinetic.min.js" type="text/javascript"></script>

  <!-- Smooth Div Scroll 1.3 minified-->
  <script src="/js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
  <script src="/js/scrollable.js" type="text/javascript"></script>
  </body>
</html>
