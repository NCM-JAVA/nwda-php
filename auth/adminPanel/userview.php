<?php ob_start();
require_once "../../includes/connection.php";
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");

$useAVclass = new useAVclass();
$useAVclass->connection();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);

if($_SESSION['admin_auto_id_sess']=='')
{		
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
	exit;	
}

if($_SESSION['saltCookie'] !=$_COOKIE['Temp'])
{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
}
 
/*if($role_id =="0")
{
}
else
{
session_unset($admin_auto_id_sess);
session_unset($login_name);
session_unset($dbrole_id);
$msg = "Login to Access Admin Panel";
$_SESSION['sess_msg'] = $msg ;
header("Location:error.php");
exit();	
}*/

//echo $sql= "Select admin_login.*, role.role_name from admin_login inner join role on admin_login.role_id=role.role_id where admin_login.id='$page_id'";
$sql= "Select * from admin_login where id='$page_id'";

$res=mysqli_query($conn, $sql);
$data=$res->fetch_assoc();
@extract($data);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Menu View Page:National Water Development Agency</title>
<link href="style/popadmin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "Show Password";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "Hide Password";
	}
} 

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>
<?php //include('top_header.php'); ?>

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">

	<tr>
		<td colspan="3" class="heading">User Details</td>
	</tr>

	<tr>
		<td colspan="3" >
		
		<table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" >
		
		<tr>	<td colspan="3" >&nbsp;</td>	</tr>

<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong> User Id</strong></td>
		<td>:</td>
		<td  class="label1"><?php echo stripslashes($login_name);?>
		</td>
	</tr>
	<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong> User Name</strong></td>
		<td>:</td>
		<td  class="label1"><?php echo stripslashes($user_name);?>
		</td>
	</tr>
		<tr>
		<td align="left"  class="content_page" valign="top"><strong><span class="label2">Phone Number</span></strong></td><td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes($user_phone);?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Email Address </span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo stripslashes($user_email);?> </td>
	</tr>

	
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Registration Date  </span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo date("d-m-Y", strtotime($create_login_date));?></td>
	</tr>
	
	<!--<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Last login Date   </span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo date("d-m-Y", strtotime($last_login_date)); ?> </td>
	</tr>-->
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">User Status </span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes(active($user_status));?> </td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="3" align="center">
		<table border="0" cellpadding="2" cellspacing="2">
		<tr><td >
		<input type="button" class="button" value="Close" onclick="MM_callJS('window.close();')" >
		</td></tr>
		</table>
		</td>
	</tr>

</table>
</tr>

	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
</table>

</body>
</html>
