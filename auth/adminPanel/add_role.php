<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id=$_SESSION['dbrole_id']; 
if($_SESSION['admin_auto_id_sess']=='')
	{		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
if($role_id > 0)
{
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
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

if(isset($cmdsubmit))
{
foreach ($_POST['mname'] as  $data)
	{
	$val .=$data.',';
	}
	$module_id=rtrim($val,',');
	$salt =rand(19999, 29999);
	$salt1 =rand(31999, 59999);
	$modulename=$_POST['modulename'];

	$errmsg="";        // Initializing the message to hold the error messages
	if(trim($user_id)=="")
	{
		$errmsg .="Please select User Name."."<br>";
	}
	if(trim($roletype)=="")
	{
		$errmsg .="Please select User Type."."<br>";
	}

if($errmsg == '')
		{
		if($_SESSION['logtoken']!=$_POST['random'])
		{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
		}
		else {
		$_COOKIE['Temp']="";
		$_SESSION['saltCookie']="";
		$_SESSION['Temptest']="";
		$saltCookie =uniqid(rand(59999, 199999));
		$_SESSION['saltCookie'] =$saltCookie;
		$_SESSION['Temptest']=$_SESSION['saltCookie'];
		setcookie("Temp",$_SESSION['saltCookie']);
		$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
	
	}
		$tableName_send="admin_role";
				$tableFieldsName_send=array("user_id","module_id","role_status",'role_type');
				$tableFieldsValues_send=array("$user_id","$module_id","1","$roletype");
				$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
				$id=mysql_insert_id();
$tableName_send="admin_login";
$whereclause="id='$user_id'";
$old=array("role_id");
$new=array("$id");
$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);


	while (list ($key,$val) = @each ($mname)) 
	{  
		//echo $val."<br>";
				/*$draft=$_POST['mdraft'.$val];
				$approve=$_POST['mrepeal'.$val];
				$publishe=$_POST['mpublishe'.$val];
				$review=$_POST['mreview'.$val];
				$mpending=$_POST['mpending'.$val];
				$medit=$_POST['medit'.$val];
				$mdelete=$_POST['mdelete'.$val];*/
				
				$tableName_send="map_role";
				$tableFieldsName_send=array("role_id","module_id","user_id","role_type");
				$tableFieldsValues_send=array("$id","$val","$user_id","$roletype");
				$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
				
				
			
				
	}
	//print_r($mname); die();
	$msg=SENDING_DETAILS;
		$_SESSION['manage_user']=$msg;
		header("location:manage_role.php");
		exit;

		}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Role: <?php echo $sitename;?></title>
<link href="style/admin.css" rel="stylesheet" type="text/css">
 <style type="text/css">
    #register-form label.errors { width:100px;text-align:right;padding-left:243px;font-weight:bold;}
    #register-form label.errors, .output {color:#FB3A3A;font-weight:bold;}
  </style>
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
<script type="text/javascript" language="javascript">
function SetAllCheckBoxes(FormName, AreaID, CheckValue)
{
var objCheckBoxes = document.getElementById(AreaID).getElementsByTagName('input');
var countCheckBoxes = objCheckBoxes.length;
for(var i = 0; i < countCheckBoxes; i++)
objCheckBoxes[i].checked = CheckValue;
}
</script>
<script type = "text/javascript" >
      function burstCache() {
        if (!navigator.onLine) {
            document.body.innerHTML = 'Loading...';
            window.location = 'index.php';
        }
    }
</script><script>
var a=navigator.onLine;
if(a){
// alert('online');
}else{
alert('ofline');
window.location='index.php';
} </script>
<script type="text/javascript">
$(document).ready(function() {
 $('#cmdsubmit').on('click', function(e) {
	 
	 var user_id=document.getElementById('user_id');
     var roletype=document.getElementById('roletype');
	
	 if (user_id.value=="")
    {
     alert("Please Select Name");
     return false;
    }
    
     if (roletype.value=="")
    {
     alert("Please Select User type");
     return false;
    }
		
 var cnt = $("input[type='checkbox']:checked").length;
        if (cnt < 1) 
        {
            alert('Select at least 1 Checked Module');
            e.preventDefault();
        }
        
 });
});
</script>

</head>

<body>
<?php include('top_header.php'); ?>
<div id="container">

   <!-- Header start -->
 

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  
  
  
  <div class="main_con">
   <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_role.php">User Management</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass"><a href="manage_role.php">Manage Role</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Add Role</span>  </div>
<div class="clear"> </div>
</div>        
<div class="right_col1">      		
<?php if($errmsg!=""){?>
          <div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
</div>
</div>
          <?php }?>	
<div class="clear"></div>

     
        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser">Add Role</h3>
 </div>	
 
<form action=""  method="post" name="form1" id="register-form"  autocomplete="off" enctype="multipart/form-data" onsubmit="return add_role('form1')">
<p>&nbsp;</p>
 <?php
			$sql=mysql_query("Select * from admin_login where id!='101' and user_status='1'");
			?>
            <div class="frm_row"> <span class="label1">
              <label for="user_id">Name:</label>
              <span class="star">*</span></span> <span class="input1">
             <select name="user_id" id="user_id" autocomplete="off">
				<option value=""> Select </option>
				<?php 
				while($row=mysql_fetch_array($sql))
				{
				?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['user_name']; ?></option>
				<?php }?>
				</select>  </span>
              <div class="clear"></div>
            </div>
            
			 <?php
			$sql=mysql_query("Select * from role where role_status='1'");
			?>
            <div class="frm_row"> <span class="label1">
              <label for="roletype">User Type:</label>
              <span class="star">*</span></span> <span class="input1">
             <select name="roletype" id="roletype" autocomplete="off" >
				<option value=""> Select </option>
				<?php 
				while($row=mysql_fetch_array($sql))
				{
				?>
				<option value="<?php echo $row['role_id']; ?>"<?php if($roleid !=""){ echo "selected";} ?>><?php echo $row['role_name']; ?></option>
				<?php }?>
				</select>  </span>
              <div class="clear"></div>
            </div>
             <div class="grid_view" width="100%">
			  <div class="frm_row"> <span class="label1">
              <label>&nbsp;</label></span>
                 <div class="addrule_t">
			  <span class="input1">
           
<table width="100%" id="mainDiv" align="center" border="1" cellspacing="2" cellpadding="2" summary="" > 
				<tr>
						<th><input type="checkbox" onclick="SetAllCheckBoxes('form1','mainDiv',this.checked);" />Checked Module</th>
						<th>Modules</th>
						
						</tr>
				<?php
	$sql="SELECT * FROM `module` where module_language_id='1' and module_id!='10'   and module_status='Active' ORDER BY `mod_order_id` ASC ";
$rs=mysql_query($sql);
 $i=1;
 
while($row=mysql_fetch_array($rs))
{ 
	
	if($class=="odd")
{
	$class="even";
 }
else
{
	$class="odd";
}
	
	?>				<tr id="<?php echo $row['module_id']; ?>"  class="<?php echo $class;?>">
						
						<td><input type="checkbox" name="mname[]" value="<?php echo $row['module_id']; ?>"  id="fr<?php echo $i;?>" />
						</th>
						
						<td><label for="fr<?php echo $i;?>"><?php echo $row['module_name']; ?><label></th>
						
						</tr>
						<?php  $i++; }?>
				</table> </span></div>
				
				<div class="clear"></div>
				
               <div class="frm_row"> <span class="button_row"><input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Submit" />&nbsp;
				<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>"><input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" /> <input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_role.php';" />
                 </span>
              <div class="clear"></div>
            </div> 		
            </div>		
</form>

</div>
</div><!-- right col -->


    <div class="clear"></div>

					




<!-- Content Area end -->
  </div>  <!-- area div-->
  </div>  
<!-- main con-->

 

</div> <!-- Container div-->
   <!-- Footer start -->

                                                            <?php
                                                            include("footer.php");
                                                            ?>
                        <!-- Footer end -->
</body>
</html>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide");
});
</script>
	
<style>
.hide {display:none;}
</style>
