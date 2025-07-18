<?php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);

 $sDBServer = "10.249.164.196"; 
 $sDBName = "nwdadb"; 
 $sDBUsername = "nwdadba"; 
 $sDBPassword = "!@nwda12"; 
 $link=mysqli_connect($sDBServer,$sDBUsername,$sDBPassword);
 if(!$link)
 {
echo "connection falied";
	   die ('Connectivity Problem : ' . mysqli_error());
 }
 else
 {
echo "connected successfully";
 $db_selected = mysql_select_db($sDBName, $link);
 mysql_query("SET NAMES utf8");
 }

?>


