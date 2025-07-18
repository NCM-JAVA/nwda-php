<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
$id=$_POST['send'];
$postid=$_POST['post'];
$query="SELECT `catage`,`catfee` FROM `post_qualificationage` WHERE `catid`='$id' and `post_id`='$postid'";
$res=mysql_query($query);
$data = mysql_fetch_array($res, MYSQL_ASSOC);
echo json_encode(array("age"=>$data['catage'], "fee"=>$data['catfee']));
?>