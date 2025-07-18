<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
require_once "../../securimage/securimage.php";
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass(); 
$useAVclass->connection(); // Calling class contructor

if($cmdsubmit)
{ 
		
		if($admin_email=="")
		{
			$errmsg ="Please enter correct email Id."."<br>";
		}
		if($txtlog=="")
		{
			$errmsg .="Please enter correct user Id/date of birth."."<br>";
		}
		if($_POST['code']=='') {
		$errmsg .="Please enter captcha code."."<br>";
		}

		if($_POST['code']!="")
		{
		
		$img = new Securimage();
		$valid = $img->check($_POST['code']);
		if($valid === true) 
		{
		
		}
		else
		{
		$errmsg.="Please enter correct code."."<br>";
		}
		}	

if($errmsg=="")
 {
$salt =rand(19999, 29999);
$salt1 =rand(31999, 59999);
$res_admin_userid = mysql_num_rows(mysql_query("SELECT * FROM admin_login WHERE login_name='$txtlog'"))."<br>";
if($res_admin_userid==0)
{

$sta=split('-',$txtlog);
$txtdate=$sta['2']."-".$sta['1']."-".$sta['0'];
}
 $res_num_date =mysql_num_rows(mysql_query("SELECT * FROM admin_login WHERE user_dob='$txtdate'"));
$sql_admin_email = "SELECT * FROM admin_login WHERE user_email ='$admin_email'";
$res_admin_email =mysql_query($sql_admin_email);
$res_num_rows=mysql_num_rows($res_admin_email);
$data=mysql_fetch_array($res_admin_email);
@extract($data);

$userid=$salt.$id.$salt1;
if($res_num_rows==0)
{
$msg = "Sorry the email address you have entered is incorrect.  Please try again.";
$errmsg.=$msg;
}
else if($res_num_date==0 && $res_admin_userid==0 )
{
$msg = "Sorry the user id/date of birth you have entered is incorrect.  Please try again.";
$errmsg.=$msg;
}

else{

/*mail code starts here*/

$email_from = 'mohammad.sajid@netcreativemind.co.in'; // Who the email is from 
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
<a href='$HomeURL/auth/adminPanel/reset_password.php?uid=$userid'> Reset your Password</a>
</td><td width='25%' align='left'>$admin_username </td></tr>
<tr><td class='text_mail' colspan='3'>&nbsp;</td></tr> </table></td></tr>
<tr><td colspan='3'>&nbsp;</td></tr>
<tr><td class='text_mail' colspan='3'align='left'>Regards,</td></tr>
<tr><td class='text_mail' colspan='3'align='left'>Disability</td></tr>
</table>";	

$ok=@mail($email_to, $email_subject, $email_message, $headers);
$dtime=date("Y-m-d H:i:s");
//$rest = substr($userid, -8,3);
$tableName_send="resetpass";
$tableFieldsName_send=array("username","passtime","uid");
$tableFieldsValues_send=array("$userid","$dtime","$id");
$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);

$msg=FORGOT_PASSWD;
$_SESSION['sess_msg']=$msg;
header("location:forgot_password.php");
exit();
}
}

}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forget Password:National Water Development Agency</title>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script>
    $('input[placeholder]').placeholder();
</script>


<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#loginform").validate({
                rules: {
							admin_email: {
							required: true,
							email: true
						}
                  ,
                    txtlog: "required",
					code: "required"
					
                },
                messages: {
                    admin_email: "Please Enter Valid Email Id",
                  	 txtlog: "Please  Enter Valid User Id or Date of birth DD-MM-YYYY",
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
<style>
    body {font-family: arial, sans-serif;}
        input {padding:4px; width:225px; font-family: arial, sans-serif; font-size: 12px;}
          .placeholder {color: #aaa;}
    </style>
</head>
<body>
<?php //include('top_header.php'); ?>

  <?php if($errmsg!=""){?>
         <div class="error_msgs">
          <div class="status1 error">
            <p class="closestatus"> <a title="Close" href="">x</a></p>
            <p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><a href="#"><?php echo $errmsg; ?></a></p>
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
      	<div class="clear"></div>
 <div class="admin_panel">
<div class="admin-heading"> <h1>Forgot Password</h1>  </div>
   <form id="loginform" name="loginform"  autocomplete="off" method="post" action="" >
      <div class="admin_row_fp">
         <span class="label2"><label for="admin_email">Email  *</label><span class="red-text"></span></span>
         <span class="input2"><input name="admin_email" placeholder="Valid Email Id"  type="text" class="input_class2" id="admin_email"  maxlength="80" autocomplete="off" autofocus/> </span>
        <div class="clear"> </div>
      </div>
	   <div class="admin_row_fp">
         <span class="label2"><label for="txtlog">User ID / Date of Birth *</label><span class="red-text"></span></span>
         <span class="input2"> <input name="txtlog" placeholder="Valid User Id or Date of birth DD-MM-YYYY"  type="text" class="input_class2" id="txtlog"  maxlength="80" autocomplete="off"/> </span>
        <div class="clear"> </div>
      </div>
      
	
      <div class="captcha_row">
       
       <div class="captcha"><div style="width: 258px; float: left; height: 70px">
						<img id="siimage" align="left" style="padding-right: 5px; border: 0" src="../../securimage/securimage_show.php?sid=<?php echo md5(time()) ?>" />

						<a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '../../securimage/securimage_show.php?sid=' + Math.random(),ClearFields(); return false"><img src="../../securimage/images/refresh_icon-big.png" alt="Reload Image" border="0" onclick="this.blur()" align="bottom" /></a>
						 <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="allowFullScreen" value="false" />
<param name="movie" value="../../securimage/securimage_play.swf?audio=../../securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="../../securimage/securimage_play.swf?audio=../../securimage/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
						</div></div>
        <div class="clear"> </div>
      </div>
      
      <div class="message_row">
       <label for="code">Enter above characters being displayed in above image * </label>
      </div>
      
        <div class="admin_row1_fp">
       
         <span class="input2"><input name="code" id="code" placeholder="Please Enter the Code" type="text" class="input_class2" maxlength="6" autocomplete="off"/></span>
        <div class="clear"> </div>
      </div>
      
       <div class="admin_row1_fp1">
       <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button"/>
        <input type="reset" name="cmdreset" id="cmdreset" value="Reset" class="button" /> 
        <div class="clear"> </div>
      </div>
      </form>
     <div class="forget_link">
        <a href="index.php" title="return to Index page">Back</a>
        <div class="clear"> </div>
      </div> 
      
    </div>
	
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgclose").addClass("hide");
});
</script>
	
<style>
.hide {display:none;}
</style>



</body>
</html>
