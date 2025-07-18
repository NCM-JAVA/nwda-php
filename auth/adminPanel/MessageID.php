<?php ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
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

$sql= "SELECT MessageID,Message,Author,DATE_FORMAT(CreationDate, '%b %d %Y %h:%i %p') AS mydatestring,m_status,Email FROM messagelist WHERE 1 and MessageID='$page_id'"; 
$res = $conn->query($sql);
$rows=$res->fetch_array();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

</head>

<body>

<table width="90%" border="0" align="center" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">

	<tr>
		<td colspan="3" class="heading">Message Details</td>
	</tr>

	<tr>
		<td colspan="3" >
		
		<table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" >
		
		<tr>	<td colspan="3" >&nbsp;</td>	</tr>

	<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong>Comment </strong></td>
		<td>:</td>
		<td  class="label1"><?php echo stripslashes($rows['Message']);?>
		</td>
	</tr>
		<!--tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">Post Date </span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes($rows['mydatestring']);?> </td>
	</tr>
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">User Status </span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes(active($rows['m_status']));?> </td>
	</tr-->
	<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong>  Name</strong></td>
		<td>:</td>
		<td  class="label1"><?php echo stripslashes($rows['Author']);?>
		</td>
	</tr>
	
	
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Email Address </span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <?php echo stripslashes($rows['Email']);?> </td>
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
