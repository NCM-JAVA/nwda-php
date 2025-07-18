<?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
//require_once "../securimage/securimage.php";
include("../includes/def_constant.inc.php");
//include('../design.php');
include("../includes/useAVclass.php");
$useAVclass = new useAVclass();
$useAVclass->connection();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass(); 
$useAVclass->connection(); // Calling class contructor
if($cmdsubmit)
{ 
$admin_email =content_desc($_POST['admin_email']);

		if($admin_email=="")
		{
			$errmsg ="Please entered correct email Id."."<br>";
		}
		elseif(trim($admin_email)!="")
		{
		$tableName_send="signup";
		$field_name="user_email";
		$sql="select * from ".$tableName_send." where ".$field_name."='".$admin_email."'";
 	   $rs=$conn->query($sql);
	   $result_rows=$rs->num_rows;
		if($result_rows >0){
			$checkuniqe = 0;
		}else{
			$checkuniqe = 1;

		}
		
		if($checkuniqe >0)
			{
				$errmsg=$errmsg."Sorry the email address you have entered is incorrect.  Please try again."."<br>";
			}
		}
		
		/* if($_POST['captcha_code']=="")
		{
			$errmsg .="Please enter correct code."."<br>";
		}
		else if($_POST['captcha_code']!="")
		{
			if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
				$errmsg.="Please enter correct captcha code."."<br>";
			}
		} */	

if($errmsg=="")
 {
$salt =rand(19999, 29999);
$salt1 =rand(31999, 59999);
$admin_email=content_desc($_POST['admin_email']);
$sql_admin_email = "SELECT * FROM signup WHERE user_email ='$admin_email'";
$res_admin_email = $conn->query($sql_admin_email);
$res_num_rows=$res_admin_email->num_rows;
$data=$res_admin_email->fetch_array();
@extract($data);

/* 
$userid=$salt.$id.$salt1;
$email_from = 'p.purohit@nic.in'; // Who the email is from 
$email_subject = "Password Notification"; // The Subject of the email
  $email_to=$user_email;
$headers = "From: ".$email_from."\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\n"; 
$email_message="<table width='100%'  border='0' cellspacing='0' cellpadding='0' align='left'>
<tr><td colspan='3' align='left' class='text_mail' >Dear  $user_name  ,</td></tr>
<tr><td colspan='3' class='text_mail'>&nbsp;</td></tr>
<tr> <td colspan='3' align='left' class='text_mail'>Please click on below link to reset your pasword:</td></tr>
<tr><td  colspan='3' class='text_mail'>&nbsp;</td></tr>
<tr><td width='40%'><table width='50%'  border='0' cellspacing='0' cellpadding='0' align='left'>
<tr><td width='10%' class='text_mail' align='left' >
<a href='$HomeURL/auth/reset_password.php?uid=$userid'> Reset your Password</a>
</td><td width='25%' align='left'>$admin_username </td></tr>
<tr><td class='text_mail' colspan='3'>&nbsp;</td></tr> </table></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td class='text_mail' colspan='3'align='left'>Regards,</td></tr>
<tr><td class='text_mail' colspan='3'align='left'>Department of Empowerment of Persons with Disabilities</td></tr>
</table>";	
$ok=@mail($email_to, $email_subject, $email_message, $headers);
 */

$dtime=date("Y-m-d H:i:s");
//$rest = substr($userid, -8,3);
/* $tableName_send="resetpass";
$tableFieldsName_send=array("username","passtime","uid");
$tableFieldsValues_send=array("$userid","$dtime","$id");
$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send); */

$sql = "INSERT INTO `resetpass`(`username`, `passtime`, `uid`) VALUES ('$userid','$dtime','$id')";
$sqli1 = $conn->query($sql);
$id = $conn->insert_id;


//$msg=FORGOT_PASSWD;
$_SESSION['sess_msg']=$msg;
header("location:forgetpassword.php");
exit();
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
	
	  <script type="text/javascript" language="javascript">
    function getPass()
    {
		
		var salt ='<?php print_r($_SESSION['salt']); ?>'; 
	
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var value = document.getElementById('<?php echo 'txtpassword'; ?>').value;
		if (value=='')
        {
           /* alert('Enter username and password');
            return false;*/
        }
        else
        {
            if (value.search(exp)==-1) 
            {
              
              //  return false;
            }
            if (value!='')
            {
				//alert(salt);
				//alert(hex_sha512(value)+salt);
				//alert(hex_sha512(hex_sha512(value)+salt));
                var hash=hex_sha512(hex_sha512(value)+salt);
                document.getElementById('<?php echo 'txtpassword'; ?>').value=hash;
				
            }


        }
    }



</script>
<script type="text/javascript">
		$(document).ready(function () {
		$('#txtusername').keypress(function(event){
		$('#msg-txtuser').html('Valid user Name')
		});
		$('#txtpassword').keypress(function(event){
	$('#msg-txtpass').html('Valid Password')
});
		 $('#code').keypress(function(event){
	$('#msg-txtcode').html('Valid Captcha code')
});
		});
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
							<li></li>
							<li>Forgot Password</li>
						</ul>
					</div>
      <div class="inner_right_container">
      <h1>Forgot Password</h1>
	 <form  name="forgot_pass" id="register-form" autocomplete="off" method="post" action="" >
<div class="frm_row">
<?php if($errmsg!=""){?>
						<div  id="msgerror" class="status error">
						<div class="closestatus" style="float: none;">
						<p class="closestatus" style="float: right;"><img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop"></p>
						<p><img alt="error" src="<?php echo $HomeURL;?>/images/error.png"> <span>Attention! <br /></span>
						
						<?php echo $errmsg; ?></p>
						</div>
						</div>
						<?php }?>
	<?php if($_SESSION['sess_msg']!=""){?> <label class="errors">
					<?php echo $_SESSION['sess_msg'];
							$_SESSION['sess_msg']=""; ?>
					</label>
				<div class="clear"></div>
					<p>
					<?php }
					
					?>
                        <span class="label1"><label for="admin_email">Email:<strong class="star">*</strong></label></span>
                        <span class="input1"><input name="admin_email"  value="<?php if(content_desc(htmlspecialchars($admin_email)!="")){ echo content_desc(htmlspecialchars($admin_email));}  ?>"  placeholder="Valid Email Id"  type="text" class="input_class" id="admin_email"  maxlength="80" autocomplete="off"/> </span>
            <div class="clear"></div>
          </div>
<script type='text/javascript'>
function refreshCaptcha(){
 
var img = document.images['captchaimg'];
img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<div class="frm_row">
<label for="code">Captcha:<span class="star">*</span></label>
  <img src="../content/captcha.php?rand=<?php echo rand();?>" id='captchaimg'>
	<a href='javascript:void();' onclick="refreshCaptcha();" style="color:red" >
		<img src="../securimage/images/refresh_icon-big.png" alt="Reload Image">
	</a>
<!--
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
<img id="siimage" align="left" style="padding-right: 5px; border:0; " src="../securimage/securimage_show.php" />
			
			<a tabindex="-1" style="border-style: none" href="javascript:void(0)" title="Refresh Image" onClick="document.getElementById('siimage').src = '../securimage/securimage_show.php?sid=' + Math.random(),ClearFields(); return false"><img src="../securimage/images/refresh_icon-big.png" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a>
			 <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="allowFullScreen" value="false" />
<param name="movie" value="../securimage/securimage_play.swf?audio=../securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="../securimage/securimage_play.swf?audio=securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>-->
</div>
                                             
                 
<div class="frm_row">
    <label class="n_text">Enter above characters being displayed in above image </label>
    <input name="captcha_code" type="text" id="captcha_code" maxlength="6" autocomplete="off" class="input_class"  value=""  placeholder="Please Enter the Captcha Code"/>
</div>                
                        
       
 
<div class="frm_row login">
    <span class="button_row login-page"> 
        <input type="submit" title="Submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button" onClick="return forgetpass('forgot_pass');"/>
        <input type="reset" class="button" name="cmdreset" title="Reset" value="Reset">
        <input type="button" name="Back" class="button" value="Back" onClick="javascript:location.href = 'index.php'" > 
   </span>
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
