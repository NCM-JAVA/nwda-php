<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
require_once "../../securimage/securimage.php";

$useAVclass = new useAVclass();
$useAVclass->connection();

if ($_SESSION['salt'] == "")
{
	$salt =rand(59999, 199999);
	$salt1 =rand(59999, 199999);
	
	$_SESSION['salt']=$salt;
	$_SESSION['salt1']=$salt1;
	
}

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
$newid= check_input($_GET['uid']);

/*$sql="select passtime,uid,resetPassId,DATE_ADD(passtime, INTERVAL 1 DAY) AS incremtime  from mol_resetpass where username ='$newuserid' order by resetPassId desc  limit 0,1 ";
$rs=mysql_query($sql);
$data=mysql_fetch_array($rs);

@extract($data);
 $sql1="SELECT DATEDIFF(now(),`passtime`) as datedif from `mol_resetpass` WHERE `resetPassId`='$resetPassId'";
$rs1=mysql_query($sql1);
$data1=mysql_fetch_array($rs1);
@extract($data1);
*/
 $sql_reset = "SELECT status,username,passtime,uid FROM resetpass WHERE username ='$newuserid' and uid='$rest' ORDER BY resetPassId DESC Limit 0,1"; 
$reset_result=mysql_query($sql_reset);
 $numrow=mysql_num_rows($reset_result);
$line_reset=mysql_fetch_array($reset_result); 
@extract($line_reset);

 $sql="select resetPassId,username,status,passtime  from resetpass where username ='$username' order by resetPassId desc  limit 0,1 ";
$rs=mysql_query($sql);
$data=mysql_fetch_array($rs);
@extract($data);
$sql1="SELECT passtime,uid,resetPassId,DATE_ADD(passtime, INTERVAL 1 DAY) AS incremtime  from `resetpass` WHERE username ='$newid' and status !='1' order by resetPassId desc  limit 0,1 ";
$rs1=mysql_query($sql1);
$data1=mysql_fetch_array($rs1);
@extract($data1);
$curtime=date("Y-m-d H:i:s");
if($numrow ==0)
{
	header("location:error.php");
	exit;
}
if($curtime>$incremtime)
{
	header("location:error.php");
	exit;
}

 

if(isset($cmdsubmit))
{

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
	if($txtnpwd!=$txtcpwd)
	{
	$errmsg=$errmsg."Please enter same password.";
	$flag="NOTOK";
	}
	else
	{
	$img = new Securimage();
			$valid = $img->check($_POST['code']);
			
			if($valid == true) 
			{
			$date=date('Y-m-d');
			$tableName_send="admin_login";
			$whereclause = "id = '$rest'";
			$old = array("user_pass","last_login_date");
			$new =array("$txtnpwd","$date");
			$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);


			$tableName_send="resetpass";
			$whereclause = "username = '$newuserid'";
			$old = array("uid","status");
			$new =array("$rest","1");
			$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);
			$sql=mysql_query("DELETE FROM resetpass WHERE uid ='$rest' and status ='0'");
		
	$msg = ADMIN_PASSWORD;
	$_SESSION['sess_msg'] = $msg;
	header("location: notification.php");
	exit;
			}
			else
			{
				$errmsg.="Please enter correct image code.<br>";
		
			}
	//$txtnpwd = strtoupper(hash("sha512",$txtnpwd));
			

	}
 }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset Page:NWDA</title>
<script src="../../includes/sha512.js" type="text/javascript"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<link href="style/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/drop_down.js"></script>
<link href="style/jquery.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/demo.js"></script>







<script type="text/javascript" language="javascript">
    function getPass()
    { 
	
		var salt ='<?php print_r($_SESSION[salt]); ?>'; 
		var salt1 ='<?php print_r($_SESSION[salt1]); ?>'; 
		
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,10})/;
       


		var txtnpwd = document.changepass.txtnpwd.value;
		var txtcpwd = document.changepass.txtcpwd.value;
		var code = document.changepass.code.value;


		 if(txtnpwd =="") 
        {
            alert('Please enter new password');
            return false;
        }

		else if(txtcpwd=="") 
        {
            alert('Please re-enter new password');
            return false;
        }
		else if(code=="") 
		{
		alert('Please enter image code');
		return false;
		}
	 else
        {
            if(txtnpwd.search(exp)==-1) 
            {
					 alert('Password must 8 character long, include at least one special character.');
					 return false;

            }
			if (txtcpwd.search(exp)==-1) 
            {
					 alert('Password must 8 character long, include at least one special character.');
					 return false;

            }


            if ((txtnpwd!='') && (txtcpwd!='') )
            {
				
				
				var hash=hex_sha512(txtnpwd);
				var hash1=hex_sha512(txtcpwd);
			    document.getElementById('<?php echo txtnpwd; ?>').value=hash;
				document.getElementById('<?php echo txtcpwd; ?>').value=hash1;
			
				
            }


        }
    }
</script>
</head>
<body>
<?php //include('top_header.php'); ?>
 
 <div id="container1">
  
  
  <?php if($errmsg!=""){?>
 <div class="error_msgs">
<div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?>.</p>
</div>
</div>
</div>
<?php }?>

       <?php
		if($_SESSION['sess_msg']!=''){?>
          <div class="status1 success">
            <p class="closestatus"> <a title="Close" href="">x</a></p>
            <p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><a href="#"><?php echo $_SESSION['sess_msg'];
			 $_SESSION['sess_msg']=""; ?></a>.</p>
          </div>
          <?php
		}
		?>


      	  <div class="admin_panel">
<div class="admin-heading"><h1>Reset Password</h1>  </div>

         <form id="changepass" name="changepass" method="post" action="" autocomplete="off">
      <div class="admin_row_fp">
         <span class="label2">Enter New Password <span class="red-text">*</span></span>
         <span class="input2"> <input name="txtnpwd"  type="password" class="input_class2" id="txtnpwd"  maxlength="512" autocomplete="off"/> </span><br/>
		   <div class="reset_msg1">Password must contain at least  8 characters long, must contain at least 1 number, at least 1 lower case letter, and at least 1 upper case letter.</div>
        <div class="clear"> </div>
      </div>

     	<div class="clear"></div>
        
      <div class="admin_row_fp">
         <span class="label2">Enter Re-Enter Password <span class="red-text">*</span></span>
         <span class="input2"> <input name="txtcpwd"  type="password" class="input_class2" id="txtcpwd"  maxlength="512" autocomplete="off"/> </span><br/>
		   <div class="reset_msg1">Password must contain at least  8 characters long, must contain at least 1 number, at least 1 lower case letter, and at least 1 upper case letter.</div>
        <div class="clear"> </div>
      </div>



      <div class="captcha_row">
       
       <div class="captcha"><div style="width: 258px; float: left; height: 70px">
						<img id="siimage" align="left" style="padding-right: 5px; border: 0" src="../../securimage/securimage_show.php?sid=<?php echo md5(time()) ?>" />

						<a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '../../securimage/securimage_show.php?sid=' + Math.random(); return false"><img src="../../securimage/images/refresh_icon-big.png" alt="Reload Image" border="0" onclick="this.blur()" align="bottom" /></a>
						</div></div>
        <div class="clear"> </div>
      </div>
      
      <div class="message_row">
       Enter above characters being displayed in above image
        
      </div>
      
        <div class="admin_row1_fp">
       
         <span class="input2"><input name="code"  type="text" class="input_class2" maxlength="6" autocomplete="off"/></span>
        <div class="clear"> </div>
      </div>
      
			<div class="admin_row1_fp1">
			<input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button" onClick ="return getPass();"/> 
			<input type="submit" name="cmdreset" id="cmdreset" value="Reset" class="button" />
			<div class="clear"> </div>
      </div>
      </form>
     <div class="forget_link_rp">
        <a href="index.php" title="return to Index page">Back</a>
        <div class="clear"> </div>
      </div> 
      
    </div>

  </div>
  <div class="footer"></div>
</div>

</body>
</html>

