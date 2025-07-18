<?php
@extract($_GET);
@extract($_POST);
@extract($_SESSION);

$link=mysql_connect("disabilityaffairgovDB","disabilityaffair","G9#Y8rL^4J");
if(!$link)
{
	  die ('Connectivity Problem : ' . mysql_error());
}
else
{
$db_selected = mysql_select_db('disabilityaffair', $link);
mysql_query("SET NAMES utf8");
}
?>


