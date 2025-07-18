<?php 

require_once "../includes/connection.php";
require_once("../includes/useAVclass.php");
require_once("../includes/functions.inc.php");
require_once("../includes/config.inc.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
@extract($_POST);
@extract($_GET);

$newrandom=$_GET['random'];
$test=$_SESSION['Temptest'];

if($_SESSION['admin_auto'] == ''){
		$_SESSION['IsAuthorized'] = false;
		$msg = "Login to Access Employee Corner";
		$_SESSION['sess_msg'] = $msg;
		header("Location:index.php");
	exit;
}
   

		$user_login_id=$_SESSION['admin_auto'];
		$action="Logout";
		$role_id=$_SESSION['dbrole_id'];
		$model_id='Front Logout';
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		/* $tableName="audit_trail";
		$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title");
		$tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title");
		$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
		 */
		$sql ="INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`) VALUES ('$user_login_id','$page_id','$url','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title')";
		$rs = $conn->query($sql); 
		

		$msg = "You have successfully logged out.";
	
		$_SESSION['sess_msg'] = $msg;
		
		session_unset();
		session_destroy();
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false );
		header("Pragma: no-cache"); 
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("location:index.php");
		exit(); 
 
 
?>
