<?php ob_start();
 include("../../includes/config.inc.php");
  require_once "../../includes/connection.php";
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
/*if($role_id !="0")
{
session_unset($admin_auto_id_sess);
session_unset($login_name);
session_unset($dbrole_id);
$msg = "Login to Access Admin Panel";
$_SESSION['sess_msg'] = $msg ;
header("Location:error.php");
exit();	
}
*/

if(isset($cmdsubmit))
{
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);

	foreach ($_POST['mname'] as  $data)
	{
	$val .=$data.',';
	}
	$module_id=rtrim($val,',');

	$salt =rand(19999, 29999);
	$salt1 =rand(31999, 59999);
	$txtename =check_input($_POST['txtename']);
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
		$whereclause="role_id='$cid'";
			$old=array("user_id","module_id","role_status",'role_type');
				$new=array("$user_id","$module_id","1","$roletype");
		$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
		$sql= "UPDATE ".$tablename. " SET ".$changedvalues." WHERE ".$whereclause; 

		if($mname !="")
	    {
			$sql=mysql_query("Delete from map_role where role_id='$cid'");
				while (list ($key,$val) = @each ($mname))
				{
				
				$tableName_send="map_role";
				$tableFieldsName_send=array("role_id","module_id","user_id","role_type");
				$tableFieldsValues_send=array("$cid","$val","$user_id","$roletype");
				$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
	
			}
		}
   
$msg=SENDING_ROLE;
$_SESSION['manage_user']=$msg;
header("location:manage_role.php");
exit;
}
}

 if(!is_numeric(trim($editid)))
	{
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
	}

 $edit="select * from admin_role where role_id ='$editid'"; 
  $result = $conn->query($edit);
 $res_rows= $result->num_rows;
$fetch_result= $result->fetch_array();

$role_module= $fetch_result['module_id'];


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Role: <?php echo $sitename;?></title>

<link href="style/admin.css" rel="stylesheet" type="text/css">
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

  <div class="clear"></div>

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
 
  <div class="main_con">
       

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
<p>&nbsp;</p>

        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser">Edit Role</h3>

 </div>	
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return edit_role('form1')">
             <?php

			$sql1="Select * from admin_login where id!='101'";
			$result1 = $conn->query($sql1);
			?>
            <div class="frm_row"> 
            <span class="label1">
              <label for="user_id">Name:</label>
              <span class="star">*</span></span> <span class="input1">
             <select name="user_id" id="user_id" autocomplete="off">
				<option value=""> Select </option>
				<?php 
				while($row1 = $result1->fetch_array())
				{
			
				?>
				<option value="<?php echo $row1['id']; ?>"<?php if ($row1['id']==$fetch_result['user_id']) echo 'selected="selected"';?>><?php echo $row1['user_name']; ?></option>
				<?php }?>
				</select>  </span>
              <div class="clear"></div>
            </div>
			
						 <?php

			$sql2="Select * from role where role_status='1'";
			$result2 = $conn->query($sql2);
			?>
            <div class="frm_row"> <span class="label1">
              <label for="roletype">User Type:</label>
              <span class="star">*</span></span> <span class="input1">
             <select name="roletype" id="roletype" autocomplete="off" >
				<option value=""> Select </option>
				<?php 
				while($row = $result2->fetch_array())
				{
				?>
				<option value="<?php echo $row['role_id']; ?>"<?php if($fetch_result['role_type']==$row['role_id']){ echo "selected";} ?>><?php echo $row['role_name']; ?></option>
				<?php }?>
				</select>  </span>
              <div class="clear"></div>
            </div>


                        <div class="grid_view" width="100%">
			  <div class="frm_row"> <span class="label1">
              <label>&nbsp;</label></span>
			   <div class="addrule_t">
			  <span class="input1">
<table width="100%" id="mainDiv" align="center" border="1" cellspacing="2" cellpadding="2" summary="">
				<tr>
						<th><input type="checkbox" onclick="SetAllCheckBoxes('form1','mainDiv',this.checked);" /></th>
						
						<th>Modules</th>
			
				</tr>
				<?php
			$sql3="SELECT * FROM `module` where module_language_id='1'  and module_status='Active' ORDER BY `mod_order_id` ASC ";
			$result3 = $conn->query($sql3);
			 $i=1;
while($row = $result3->fetch_array())
{ 
$mid=$row['module_id'];
	$sql4="SELECT * FROM `map_role` where module_id=$mid and role_id='$editid'";
	$result4 = $conn->query($sql4);
	$row1 = $result4->fetch_array();
?>	<tr id="<?php echo $row['module_id']; ?>"><th><input type="checkbox" id="fr<?php echo $i;?>"  name="mname[]" value="<?php echo $row['module_id']; ?>"<?php if($row['module_id']==$row1['module_id']){ echo "checked";}?> /></th>
						
						<td><label for="fr<?php echo $i;?>">
<?php echo $row['module_name']; ?><label>
								
</td>
<?php  $i++;} ?>
			</table> </span></div>
				
				<div class="clear"></div>
           <div class="frm_row"> <span class="button_row">
             <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" />
              <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>"/>
			  <input name="cid" type="hidden" value="<?php echo $fetch_result['role_id']; ?>"/><input name="cmdreset" type="submit" class="button" id="cmdreset" value="Reset" /> <input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_role.php';" />
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
  </div>  <!-- main con-->

  <!-- Footer start -->
  
  <?php 
  
			include("footer.inc.php");
    ?>
  <!-- Footer end -->

</div> <!-- Container div-->
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
