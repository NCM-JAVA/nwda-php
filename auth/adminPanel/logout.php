<script>
document.cookie = "";
</script>
<?php 
require_once "../../includes/connection.php";
require_once("../../includes/useAVclass.php");
require_once("../../includes/functions.inc.php");
require_once("../../includes/config.inc.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
@extract($_POST);
@extract($_GET);
$newrandom=$_GET['random'];
$test=$_SESSION['Temptest'];

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if($_SESSION['logtoken']!=$newrandom){
		session_destroy();
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:error.php");
}elseif($_COOKIE['Temp']==$test && $_SESSION['logtoken']==$newrandom){      

	$user_id=$_SESSION['admin_auto_id_sess'];
	$page_id=$conn->insert_id;
	$action="Logout";
	$model_id='Logout User';
	$txtename = 'Logout Page';
	$categoryid='1'; //mol_content
	$date=date("Y-m-d h:i:s");
	$ip=$_SERVER['REMOTE_ADDR'];
	
	//$sql51 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
	//$sql21 = $conn->query($sql51);
	$user_login_id=$_SESSION['admin_auto_id_sess'];
	
	mysqli_query($conn, "update admin_login set flag_id='0' where id='".$user_login_id."'");	
	$action="Logout";
	$role_id=$_SESSION['dbrole_id'];
	$date=date("Y-m-d h:i:s");
	$ip=$_SERVER['REMOTE_ADDR'];
	$login_id='0';

	$msg = "You have successfully logged out.";
	$_SESSION['sess_msg'] = $msg;
	session_regenerate_id();
	session_write_close();
  
	$_SESSION = array(); 
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");
	header("location:index.php");
	exit(); 
}else{
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");
	header("location:index.php");
}
 
?>
