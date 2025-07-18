<?php
ob_start();
session_start();
 require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
//require_once "../securimage/securimage.php";
include("../includes/def_constant.inc.php");
//include('../design.php');
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
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

	//$msg = ADMIN_NOENTRY;
	$_SESSION['sess_msg'] = $msg;
//	header("location:notification.php");
//	exit;
}
 $newuserid=$uid;
 $rest = substr($newuserid, -8,3);

$newid= $_GET['uid'];
$sql_reset = "SELECT status,username,passtime,uid FROM resetpass WHERE username ='$newuserid' and uid='$rest'  ORDER BY resetPassId DESC Limit 0,1"; 
$reset_result=$conn->query($sql_reset);
 $numrow=$reset_result->num_rows;
$line_reset=$reset_result->fetch_array(); 

//@extract($line_reset);
 $sql="select resetPassId,username,status,passtime  from resetpass where username ='$username' order by resetPassId desc  limit 0,1 ";
$rs=$conn->query($sql);
$data=$rs->fetch_array();


//@extract($data);
$sql1="SELECT passtime,uid,resetPassId,DATE_ADD(passtime, INTERVAL 1 DAY) AS incremtime  from `resetpass` WHERE username ='$newid' and status !='1' order by resetPassId desc  limit 0,1 ";
$rs1=$conn->query($sql1);
$data1=$rs1->fetch_array();
//@extract($data1);

$curtime=date("Y-m-d H:i:s");
if($numrow ==0)
{
	//header("location:error.php");
	//exit;
}
if($curtime>$incremtime)
{
	//header("location:error.php");
	//exit;
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
			$tableName_send="signup";
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
	header("location: index.php");
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
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>NWDA</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
	
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	
 	<script src="<?php echo $HomeURL;?>/js/sha512.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
    function getPass()
    { 
	
	//alert(salt);
		var salt ='<?php print_r($_SESSION['salt']); ?>'; 
		var salt1 ='<?php print_r($_SESSION['salt1']); ?>'; 
		
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
				//alert(hash);
				var hash1=hex_sha512(txtcpwd);
			    document.getElementById('<?php echo 'txtnpwd'; ?>').value=hash;
				document.getElementById('<?php echo 'txtcpwd'; ?>').value=hash1;
			
				
            }


        }
    }
</script>
<script>
function ClearFields() {
     document.getElementById("code").value = "";

}
</script>
			<style>
#register-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align:right;
}
</style>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL; ?>/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    txtusername: "required",
                    txtpassword: "required",
					code: "required"
					
                },
                messages: {
                    txtusername: "Please Enter Valid User Name",
                  	 txtpassword: "Please  Enter Valid Password",
					 code: "Please Enter Valid Captcha Code. Code is not case sensitive"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<script>
function ClearFields() {
     document.getElementById("code").value = "";

}
</script>

	</head>
	
	<body id="fontSize">
			<header>
			<?php include("../content/top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("../content/header.php");?>
		</div>	
		</nav>
	<section>
		
			
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("../content/leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Reset Password</li>
						</ul>
					</div>
         <div class="inner_right_container">
      <h1>Reset Password</h1>
	 	 <form id="changepass" name="changepass" method="post" action="" autocomplete="off">
<div class="frm_row">
	<?php if($_SESSION['sess_msg']!=""){?> <span class="label"><label>
					<?php echo $_SESSION['sess_msg'];
							$_SESSION['sess_msg']=""; ?>
					</label></span>
				<div class="clear"></div>
					<p>
					<?php }
					
					?>
                        <span class="label1"><label for="txtnpwd">Enter New Password :<strong class="text3">*</strong></label></span>
                        <span class="input1"> <input name="txtnpwd"  type="password" class="input_class2" id="txtnpwd"  maxlength="512" autocomplete="off"/> </span>
                        <div class="clear"></div>
                        </div>
                        
                        
                        
                        <div class="frm_row">
                        <span class="label1">
                        <label for="txtcpwd">Enter Re-Enter Password :<strong class="text3">*</strong></label></span>
                        <span class="input1">
                      <input name="txtcpwd"  type="password" class="input_class2" id="txtcpwd"  maxlength="512" autocomplete="off"/></span>
                         <div class="clear"></div>
                        </div>
                        
<div class="frm_row">
<label for="code">Captcha:<span class="star">*</span></label>
<img src="../securimage/securimage_show.php?sid=<?php echo md5(time()) ?>" id="siimage" alt="image" style="padding-right: 5px; float:left;"/>
<div style="width: 40px; float: left;">
<a onClick="document.getElementById('siimage').src = '../securimage/securimage_show.php?sid=' + Math.random(), return false" title="Refresh Image" href="#" style="border-style: none" tabindex="-1" ><img onClick="this.blur(), ClearFields();" alt="Reload Image" src="../securimage/images/refresh_icon-big.png" /></a>
                              </div>
<object width="19" height="19" id="SecurImage_as3" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"  >
<param name="allowScriptAccess" value="sameDomain" />
<param name="allowFullScreen" value="false" />
<param name="movie" value="../securimage/securimage_play.swf?audio=../securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed width="19" height="19" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowFullScreen="false" allowScriptAccess="sameDomain" name="SecurImage_as3"  bgcolor="#ffffff" quality="high" src="../securimage/securimage_play.swf?audio=../securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
</object>
</div>
                                             
                 
<div class="frm_row">
    <label class="n_text">Enter above characters being displayed in above image </label>
    <input name="code" type="text" id="code" maxlength="6" autocomplete="off" class="input_class"  value=""  placeholder="Please Enter the Captcha Code"/>
</div> 
                        
<div class="frm_row">

     <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button" onClick ="return getPass();"/> 
	 <input type="submit" name="cmdreset" id="cmdreset" value="Reset" class="button" />

</div>

</form>
 </div>
</div> 
		</section>
	<footer>
			<?php include("../content/footer.php");?>
		</footer>
	
	<script type="text/javascript">
function editlist(id) {
var menuId = id;
var request = $.ajax({
url: "editid.php",
type: "POST",
data: {id : menuId},
dataType: "html"
});
request.done(function(msg) {
window.location.href = msg;
});
request.fail(function(jqXHR, textStatus) {
alert( "Request failed: " + textStatus );
});
 
}
</script>
	</body>
	
</html>
