<?php

// @extract($_GET);
// @extract($_POST);
// @extract($_SESSION);
// $sDBServer = "10.249.164.197"; 
// $sDBName = "nwdadb"; 
// $sDBUsername = "nwdausr"; 
// $sDBPassword = "Nwd@1234"; 
// $link=mysql_connect($sDBServer,$sDBUsername,$sDBPassword);
// if(!$link)
// {
	  // die ('Connectivity Problem : ' . mysql_error());
// }
// else
// {
// $db_selected = mysql_select_db($sDBName, $link);
// mysql_query("SET NAMES utf8");
// }

// $sDBServer = "10.249.164.196"; 
// $sDBName = "nwda_db"; 
// $sDBUsername = "mysql"; 
// $sDBPassword = "Mysql@123456789";
$sDBServer = "localhost"; 
$sDBName = "nwdadbb"; 
$sDBUsername = "root"; 
$sDBPassword = "";

/* $sDBServer = "10.249.164.196"; 
 $sDBName = "nwdadb"; 
 $sDBUsername = "nwdadba"; 
 $sDBPassword = "!@nwda12";  */


    
$conn = mysqli_connect($sDBServer, $sDBUsername, $sDBPassword, $sDBName);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} 
else
{
$db_selected = mysqli_select_db($conn, $sDBName);
$conn->set_charset("utf8");
}

?>


