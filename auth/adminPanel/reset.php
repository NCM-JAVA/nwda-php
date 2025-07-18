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

if ($uid=="")
{

	$msg = ADMIN_NOENTRY;
	$_SESSION['sess_msg'] = $msg;
	header("location:notification.php");
	exit;
}


$newuserid=$uid;
$rest = substr($newuserid, -8,3);


$sql="select passtime,uid,resetPassId,DATE_ADD(passtime, INTERVAL 1 DAY) AS incremtime  from resetpass where username ='$newuserid' order by resetPassId desc  limit 0,1 ";

$rs=mysql_query($sql);
$data=mysql_fetch_array($rs);

@extract($data);
 $sql1="SELECT DATEDIFF(now(),`passtime`) as datedif from `resetpass` WHERE `resetPassId`='$resetPassId'";
$rs1=mysql_query($sql1);
$data1=mysql_fetch_array($rs1);
@extract($data1);


//echo $datedif;

//SELECT CONCAT( DAYOFYEAR( passtime ) - DAYOFYEAR( NOW( ) ) , ' days ', DATE_FORMAT( ADDTIME( "2000-00-00 00:00:00", SEC_TO_TIME( TIME_TO_SEC( passtime ) - TIME_TO_SEC( NOW( ) ) ) ) , '%k hours and %i minutes' ) ) AS time FROM resetpass
 

if(isset($cmdsubmit))
{
echo $datedif;
$txtpwd= check_input($_POST['txtpwd']);
$txtnpwd= check_input($_POST['txtnpwd']);
$txtcpwd = check_input($_POST['txtcpwd']);



if(trim($txtnpwd)=="")
{
	$errmsg ="Please enter New Password.";
	$flag="NOTOK";   //setting the flag to error flag.
}

elseif(strlen($txtnpwd) <=5)
{    
	$errmsg=$errmsg."New Password minimum lenght is 6 character.";
	$flag="NOTOK";   //setting the flag to error flag.
}

elseif(strlen($txtcpwd) <=5)
{    
	$errmsg=$errmsg."Confirm Password minimum lenght is 6 character.";
	$flag="NOTOK";   //setting the flag to error flag.
}
elseif($datedif >1)
{ 
	$errmsg ="Please request Forgot Password."."<a href='$HomeURL/adminPanel/forgot_password.php' TARGET='_blank'> Forget Password</a>";
	$flag="NOTOK";   //setting the flag to error flag.
	
}
elseif(trim($txtcpwd)=="")
{
	$errmsg ="Please enter Confirm Password.";
	$flag="NOTOK";   //setting the flag to error flag.
	
}

else
{
	$convertpwd = strtoupper(hash("sha512",$txtpwd));

	
	if($txtnpwd!=$txtcpwd)
	{


	$errmsg=$errmsg."Please enter same password.";
	$flag="NOTOK";
		
	}
	else
	{
    
	$txtnpwd = strtoupper(hash("sha512",$txtnpwd));
			
			$tableName_send="admin_login";
			$whereclause = "id = '$uid'";
			$old = array("user_pass");
			$new =array("$txtnpwd");
			$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);


			$tableName_send="resetpass";
			$whereclause = "username = '$newuserid'";
			$old = array("uid","status");
			$new =array("$rest","1");
			$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);
		
		
	$msg = ADMIN_PASSWORD;
	$_SESSION['sess_msg'] = $msg;
	//header("location: notification.php");
	//exit;
	}
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Admin Section</title>
<style type="text/css">
<!--

-->
</style>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script language="JavaScript" src="includes/validate.js"></script>
<script language="JavaScript" src="js/over.js"></script>
<script language="JavaScript" src="mm_menu.js"></script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('images/manage_content_1.jpg','images/manage_ebrochure_1.jpg','images/manage_picture_gallery_1.jpg','images/logout_1.jpg')">


<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0" id="maintable2">
	<?php include('header.inc.php');?>
	<tr>
	<td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
	
	<tr>
	<td colspan="2" bgcolor="#FFFFFF">


<table width="100%" border="0"  border="0" >
<tr>
<td align="left" valign="top">

	
</td>

<td align="right"  bgcolor="#FFFFFF" >

		<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			<td width="12" valign="top"><img src="images/left_top.jpg" width="12" alt="welcome" /></td>
			<td width="714" background="images/top_table.jpg">&nbsp;</td>
			<td width="12" align="right" valign="top"><img src="images/right_top.jpg" width="12" alt="welcome" /></td>
			</tr>
			<tr>
			<td colspan="3" valign="top" background="images/table_lbg.jpg">

<form id="changepass" name="changepass" method="post" action="" onSubmit="return changepassword('changepass');">

<table width="90%" border="0" align="center" cellpadding="3" cellspacing="3">
<tr>
<td colspan="2" >

<table width="70%" border="0" align="center" cellpadding="2" cellspacing="2">

<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
  <tr>
    <td colspan="2" align="center" class="redBold">
	<?php if($errmsg!=""){?>
	<b>Please correct the following error:</b><br />
	<ul><li>
	<?php echo $errmsg; ?>
	</li></ul>
	<?php }?>
	</td>
  </tr>

<tr>
<td colspan="2" align="center" class="redBold">&nbsp;
<?php
if($_SESSION['sess_msg']!=''){
print $_SESSION['sess_msg'];
$_SESSION['sess_msg']="";
}?>
</td>
</tr>


<tr>
<td align="right" class="normaltext">Enter New Password <span class="redtext">*</span>:</td>
<td align="left"><input name="txtnpwd" type="password" class="formstyle2" id="txtnpwd" maxlength="512" size="40" AUTOCOMPLETE=OFF/></td>
</tr>

<tr>
<td align="right" class="normaltext">Enter Confirm Password <span class="redtext">*</span>:</td>
<td align="left"><input name="txtcpwd" type="password" class="formstyle2" id="txtcpwd" maxlength="512" size="40" AUTOCOMPLETE=OFF/></td>
</tr>

<tr>
<td align="left" class="normaltext">&nbsp;</td>
<td align="center"  valign="middle" >
<input type="submit" name="cmdsubmit" value="Update" class="button1">&nbsp;
</td>
</tr>


<tr><td colspan="2" height="70px">&nbsp;</td></tr>



</table>

</td>
</tr>
</table>





				</form>
			</td>
			</tr>
			<tr>
			<td align="left" valign="top"><img src="images/left_bottom.jpg" width="12" height="20" alt="welcome" /></td>
			<td background="images/lower_bg.jpg">&nbsp;</td>
			<td align="right" valign="top"><img src="images/right_bottom.jpg" width="12" height="20" alt="welcome" /></td>
			</tr>
		</table>

	</td>
	</tr>
</table>

</td>
</tr>

<tr>
<td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
</tr>

<?php include('footer.inc.php');?>
</table> </td></tr>


</table>
</body>
</html>