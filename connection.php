<?php
// connect to database
// for local host
$servername="localhost" ;
$DBusername="root";
$DBpassword="";
$DB="nursing_guardian";



$con = mysqli_connect($servername,$DBusername,$DBpassword) or die("Unable to connect");

mysqli_select_db($con,$DB);