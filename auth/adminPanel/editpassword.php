<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
$useAVclass = new useAVclass();
$useAVclass->connection();

if ($_SESSION['salt'] == "")
{
	$salt =rand(59999, 199999);
	$salt1 =rand(59999, 199999);
	$salt2 =rand(59999, 199999);
	$_SESSION['salt' ]=$salt;
	$_SESSION['salt1' ]=$salt1;
	$_SESSION['salt2' ]=$salt2;
}
if($_SESSION['admin_auto_id_sess']=='')
{		
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
	exit;	
}
//echo "<pre>"; print_r($_SERVER);
$uid=$_SESSION['admin_auto_id_sess'];
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$sql = "select user_pass,last_userpwd1,last_userpwd2,last_userpwd3,last_userpwd4 from admin_login where id='$admin_auto_id_sess'";
$result=$conn->query($sql);
$num = $result->num_rows;
if($line=$result->fetch_array()){
@extract($line);
}
if($cmdsubmit == "Update")
{
$sql="Select user_pass,last_userpwd1,last_userpwd2,last_userpwd3,last_userpwd4 from admin_login where id='$uid'";
$result = $conn->query($sql);
$numrow = $result->num_rows;
$line_reset=$result->fetch_array(); 
@extract($line_reset);

 $txtpwd= clean($_POST['txtpwd']);
$txtnpwd= clean($_POST['txtnpwd']);
$txtcpwd = clean($_POST['txtcpwd']);
$convertpwd = strtoupper($txtpwd);
//$convertpwd = strtoupper(hash("sha512",$convertpwd));
if(trim($txtpwd)=="")
{
	$errmsg ="Please enter Old Password."."<br>";
	
}
if(trim($txtnpwd)=="")
{
	$errmsg.="Please enter New Password."."<br>";
	
}
if($txtpwd==$txtnpwd)
{
$errmsg.="Please enter new password  should not be same as old password.";
$flag="NOTOK";   //setting the flag to error flag.
}
/*else if(preg_match("/^[0-9a-zA-Z_]{6,}$/", $txtnpwd) === 0)
  {
  $errmsg.="New Password minimum lenght is 6 character and contain only digits, letters and underscore."."<br>";
  }*/
  

if(trim($txtcpwd)=="")
{
	$errmsg .="Please enter Confirm Password."."<br>";

}
/*else if(preg_match("/^[0-9a-zA-Z_]{6,}$/", $txtcpwd) === 0)
{    
	$errmsg.="Confirm Password minimum lenght is 6 character and contain only digits, letters and underscore."."<br>";
}
*/
if($convertpwd==$user_pass)
{
	
}
else { 
	$errmsg .="Please enter the correct old password."."<br>";
}


if($user_pass==$txtnpwd || $last_userpwd1==$txtnpwd  || $last_userpwd2==$txtnpwd || $last_userpwd3==$txtnpwd  || $last_userpwd4==$txtnpwd)
{
		$errmsg=$errmsg."Please specify a different password from previous four passwords.";
}


if($txtnpwd!=$txtcpwd)
{
$errmsg.="Password mismatch! Please enter the same password."."<br>";
}
else
	{
	
	if($_SESSION['logtoken']!=$_POST['random'])
		{
		
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:page.php");
		exit();
		}
	
			//$txtnpwd = strtoupper(hash("sha512",$txtnpwd));
			$tableName_send="admin_login";
			$whereclause = "id = '$uid'";
            $old = array("user_pass","last_userpwd1","last_userpwd2","last_userpwd3","last_userpwd4");
            $new =array("$txtnpwd","$txtpwd","$last_userpwd1","$last_userpwd2","$last_userpwd3");
			$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);
			
			$sql1 = "UPDATE `admin_login` SET `user_pass`='$txtnpwd',`last_userpwd1`='$txtpwd',`last_userpwd2`='$last_userpwd1',`last_userpwd3`='$last_userpwd2',`last_userpwd4`='$last_userpwd3' WHERE id = '$uid'";
			$sqli11 = $conn->query($sql1);
			
			$user_login_id=$_SESSION['admin_auto_id_sess'];
			$page_id=$val;
			$action="Update Password admin";
			$categoryid='0';//super admin
			$date=date("Y-m-d h:i:s");
			$ip=$_SERVER['REMOTE_ADDR'];
			$tableName="audit_trail";
			$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address");
			$tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$categoryid","$date","$ip");
			$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
			
			$sql = "INSERT INTO `audit_trail` (`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`)VALUES ('$user_login_id','$page_id','$url','$action','$categoryid','$date','$ip')";
			$sqli1 = $conn->query($sql);


	$msg = ADMIN_PASSWORD;
	$_SESSION['edit_prof'] = $msg;
                header('Refresh: 5; URL='.$adminURL.'/logout.php?random='. $_SESSION['logtoken']);
	//header("location: logout.php?random=". $_SESSION['logtoken']);        
	//exit;
	
 }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Password : <?php echo $sitename;?></title>
<link rel="SHORTCUT ICON" href="images/favicon.ico" />
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script src="js/sha512.js" type="text/javascript"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->


<script type="text/javascript" language="javascript">
    function getPass()
    {
		
	
		var salt ="<?php echo $_SESSION['salt']; ?>"; 
		var salt1 ="<?php print_r($_SESSION['salt1']); ?>"; 
		var salt2 ="<?php print_r($_SESSION['salt2']); ?>"; 
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var txtpwd = document.getElementById('<?php echo "txtpwd"; ?>').value;
		var txtnpwd = document.getElementById('<?php echo "txtnpwd"; ?>').value;
		var txtcpwd = document.getElementById('<?php echo "txtcpwd"; ?>').value;
     
	  
		if (txtpwd=='')
        {
            alert('Please Enter old password');
            return false;
        }
		if (txtpwd==txtnpwd)
        {
            alert('Please new password should not be same as old password');
            return false;
        }
		else if (txtnpwd=='') 
        {
            alert('Please enter new password');
            return false;
        }

		else if (txtcpwd=='') 
        {
            alert('New Password and Confirm Password should be same');
            return false;
        }
	
	
		 else
        {  
		
		if (txtnpwd.search(exp)==-1) 
            {
				alert('Password must be 8 characters long, contain at least 1 number, at least 1 lower case letter and  at least 1 upper case letter.');
					 return false;

            }
			if (txtcpwd.search(exp)==-1) 
            {
					 alert('Password must be 8 character long and include at least one special character.');
					 return false;

            }

            if ((txtpwd!='') && (txtnpwd!='') & (txtcpwd!='') )
            {
         
				var hash=hex_sha512(txtpwd);
				var hash1=hex_sha512(txtnpwd);
				var hash2=hex_sha512(txtcpwd);
				
                 document.getElementById('<?php echo "txtpwd"; ?>').value=hash;
				document.getElementById('<?php echo "txtnpwd"; ?>').value=hash1;
				document.getElementById('<?php echo "txtcpwd"; ?>').value=hash2;
				
            }


        }
    }
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
  <!--<div id="toolbar-box">
        <div class="m">
          <div class="pagetitle">
            <div class="pagetitle_passimg"></div>
            <div class="pagetitle_heading">
              <h2>Change Password</h2>
            </div>
          </div>
          <div id="toolbar" class="toolbar-list">
            <ul>
				
				<li><a href="editpassword.php" title="Change Password"><span class="icon-28-changepass"></span>Change Password</a></li>
              <li class="divider"> </li>
              <li><span class="icon-28-edit"></span><a href="editProfile.php" title="Manage Profile" >Edit Profile</a></li>
              <li class="divider"> </li>
                          <li><a href="logout.php?random=<?php echo $_SESSION['logtoken'];?>" title="Logout"><span class="icon-28-logout"></span>Logout</a></li> </ul>
          </div>
          <div class="clear"></div>
        </div>
      </div>-->
  <div class="main_con">
      <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Change Password</span>
  </div>
<div class="clear"> </div>
</div>    
      
      <div class="content-content">
	  
	  <div class="right_col1">
			<?php
				if($_SESSION['edit_prof']!=''){?>
				<div  id="msgclose" class="status success">
				<div class="closestatus" style="float: none;">
				<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
				<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['edit_prof'];
				$_SESSION['edit_prof']=""; ?>.</p>
				</div>
				</div>
				<?php } ?>

				 <?php if($errmsg!=""){?>
				<div  id="msgerror" class="status error">
				<div class="closestatus" style="float: none;">
				<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
				<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
				</div>
				</div>
				<?php }?>
             <div class="grid_view">
 <form id="changepass" name="changepass" method="post" action="" autocomplete="off" onSubmit="return changepassword('changepass');"> 
 
 
 <div class="cpanel-password">
                     <div class="cpanel-right_heading"><h3 class="editprofile">Change Password</h3>  </div>
	
              <div class="frm_row"> <span class="label1">
              <label for="txtpwd">Enter Old Password: </label><span class="star">*</span>
              </span><span class="input1">
              <input name="txtpwd" type="password" class="input_class" id="txtpwd" maxlength="512"  value="" size="40" autocomplete="off" />
                   </span>
              <div class="clear"></div>
            </div>
            <div class="frm_row"> <span class="label1">
              <label for="txtnpwd">Enter New Password:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="txtnpwd" type="password" class="input_class" id="txtnpwd" maxlength="512" size="40" autocomplete="off" />
			  <br />
			 <span class="password_help">"Tip:Password must be 8 characters long, contain at least 1 number, at least 1 lower case letter and at least 1 upper case letter."</span>
              </span>
              <div class="clear"></div>
            </div>
 <div class="frm_row"> <span class="label1">
              <label for="txtcpwd">Confirm Password:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="txtcpwd" type="password" class="input_class" id="txtcpwd" maxlength="512" size="40" autocomplete="off" />
              </span>
              <div class="clear"></div>
            </div>
         <div class="frm_row"> <span class="button_row">
         <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" onClick ="return getPass();"/>
             <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
             <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
             <input type="button" class="button" value="Back" onClick="javascript:location.href = 'welcome.php';" />
              </span>
              <div class="clear"></div>
            </div>
</form>
 </div>
          <!--<div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->
          <div class="clear"></div>
        </div>

</div><!-- right col -->


    <div class="clear"></div>





  </div>  <!-- main con-->

 

</div> <!-- Container div-->
 <!-- Footer start -->
         <?php include("footer.php"); ?>
  <!-- Footer end -->

<script type="text/javascript">
jQuery(".closestatus").click(function() {
jQuery("#msgclose").addClass("hide");
});
</script>
<script type="text/javascript">
jQuery(".closestatus").click(function() {
jQuery("#msgerror").addClass("hide");
});
</script>
	
<style>
.hide {display:none;}
</style>


</body>
</html>
