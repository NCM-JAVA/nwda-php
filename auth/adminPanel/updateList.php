<?php
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include("../../includes/pagination.php");
require_once("../../includes/ps_pagination.php");


@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();

$array	= $_POST['arrayorder'];

 if ($_POST['update'] == "update" && $_POST['tab']=="tender"){
	
	$count = 1;
	foreach ($array as $idval) {
		 $query = "UPDATE tender SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE tender_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
} 

if ($_POST['update'] == "update" && $_POST['tab']=="manage"){
	
	$count = 1;
	foreach ($array as $idval) {
		 $query = "UPDATE menu SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE menu_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
if ($_POST['update'] == "update" && $_POST['tab']=="annual_report"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE annual_report SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE annual_report_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysql_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
if ($_POST['update'] == "update" && $_POST['tab']=="banner"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE banner SET page_postion=".$count." WHERE approve_status='3' and b_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE banner_publish SET page_postion=".$count." WHERE approve_status='3' and publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}


if ($_POST['update'] == "update" && $_POST['tab']=="combine"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE combine SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE combine_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}


if ($_POST['update'] == "update" && $_POST['tab']=="important"){
	
	$count = 1;
	foreach ($array as $idval) {
		$query = "UPDATE important_link SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE important_link_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}

if ($_POST['update'] == "update" && $_POST['tab']=="photogallery"){
	
	$count = 1;
	foreach ($array as $idval) {
	$query = "UPDATE photogallery SET page_position=".$count." WHERE approve_status='3' and id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}

if ($_POST['update'] == "update" && $_POST['tab']=="feedback")
	{
	
	$count = 1;
	foreach ($array as $idval) {
	$query = "UPDATE feedback_form SET page_position=".$count." WHERE id= ".$idval;  
		mysqli_query($conn,$query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}
if ($_POST['update'] == "update" && $_POST['tab']=="update_org")
	{
	$count = 1;
	foreach ($array as $idval) {
	$query = "UPDATE organizationchart SET page_postion=".$count." WHERE id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}


if ($_POST['update'] == "update" && $_POST['tab']=="manage"){
	
	$count = 1;
	foreach ($array as $idval) {
		 $query = "UPDATE home_page SET page_postion=".$count." WHERE approve_status='3' and m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		 $query = "UPDATE menu_publish SET page_postion=".$count." WHERE approve_status='3' and m_publish_id= ".$idval; 
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}



if ($_POST['update'] == "update" && $_POST['tab']=="employee"){
	
	$count = 1;
	foreach ($array as $idval) {
	$query = "UPDATE employee SET page_postion=".$count." WHERE m_id= ".$idval;  
		mysqli_query($conn, $query) or die('Error, insert query failed');
		$count ++;	
	}
	echo 'All saved! refresh the page to see the changes';
}




?>

