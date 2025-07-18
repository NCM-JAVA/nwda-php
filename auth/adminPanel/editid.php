<?php ob_start();
// @extract($_POST);
// @extract($_SESSION);
// error_reporting(0);

//$favoriteColor = isset($_POST["id"]) ? $_POST["id"] : "";
if(is_numeric($_POST["id"]))
{
 echo $val=$_POST["id"];
}else { echo $val=0; }


?>


