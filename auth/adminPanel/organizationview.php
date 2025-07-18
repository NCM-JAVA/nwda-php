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
$sql= "SELECT * FROM organizationchart WHERE 1 and id='$page_id'"; 
$res=mysqli_query($conn, $sql);
$rows=mysqli_fetch_array($res);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/popadmin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/tabcontent.js"></script> 

<script type="text/javascript">
<!--

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>

<body>

<table>

	<tr>
		<td colspan="3" >
		
		<table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" >
		
		<tr>	<td colspan="3" >&nbsp;</td>	</tr>

	<tr>
		<td  align="left" class="label2" valign="top" width="35%"><strong>Name</strong></td>
		<td>:</td>
		<td  ><?php echo stripslashes($rows['name']);?>
		</td>
	</tr>
	<?php if($rows['email']!='') { ?>
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">Email </span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes($rows['email']);?> </td>
	</tr>
	<?php } ?>
	<?php if($rows['phone']!='') { ?>
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">Phone</span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"><?php echo stripslashes($rows['phone']);?>  </td>
	</tr>
	<?php } if($rows['sort_desc']!='') { ?>
	<tr>
		<td align="left" valign="top" class="content_page"><strong><span class="label2">Short Description</span></strong></td><td>:</td>
		<td  align="justify" class="label1"> <p><?php echo stripslashes(html_entity_decode($rows['short_desc']));?></p> </td>
	</tr>
	<?php } if($rows['content']!='') { ?>
	<tr>
		<td align="left"  class="content_page" ><strong><span class="label2">Description</span></strong></td><td>:</td>
		<td align="justify" class="label1"> <p><?php echo stripslashes(html_entity_decode($rows['content']));?> </p></td>
	</tr>
	<?php } ?>
		<tr>
		<td align="left"  class="content_page" valign="top"><strong><span class="label2">Designation</span></strong></td><td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes(func_org_designation($rows['designation']));?> </td>
	</tr>
		
	<tr>
		<td align="left" valign="top" class="content_page" ><strong><span class="label2">Status</span></strong></td>
		<td>:</td>
		<td align="justify" class="label1"> <?php echo stripslashes(active($rows['profile_status']));?> </td>
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
