<?php ob_start();
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
 $role_id=$_SESSION['dbrole_id']; 
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

 $sql= "Select id,name,email,phone,comments,review_comment,review_date from onlinequery_form where id='$page_id' ";
$res=mysql_query($sql);
$data=mysql_fetch_assoc($res);
@extract($data);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Online Query: <?php echo $sitename; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">

	<tr>
		<td colspan="3" class="heading">Online Query Details</td>
	</tr>

	<tr>
		<td colspan="3" >
		
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" >
		
		<tr>	<td colspan="3" >&nbsp;</td>	</tr>

	<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong>  Name</strong></td>
		<td>:</td>
		<td  class="label1"><?php echo stripslashes($name);?>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">E-Mail </span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes($email);?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">Phone</span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo $phone;?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Comments </span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo stripslashes($comments);?> </td>
	</tr>
	<?php
		if($review_comment!='')
		{
	?>
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Admin Comment</span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo stripslashes($review_comment);?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Review Date</span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo $review_date;?> </td>
	</tr>
	<?php }?>
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
