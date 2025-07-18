<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
if(isset($_POST['id']))
{
$id=$_POST['id'];
$query="SELECT `age`,`percentage` FROM `post_mst` where 	post_id=$id";
$res=mysql_query($query);
$data = mysql_fetch_array($res);
$as_on=date('Y/m/d', strtotime($data['age']));
echo json_encode(array("age_on"=>$as_on, "percent"=>$data['percentage']));
}
?>