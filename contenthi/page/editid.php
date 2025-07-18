<?php 
ob_start();
session_start();
error_reporting(0);
include('../design.php');
echo $_POST["id"];
?>

