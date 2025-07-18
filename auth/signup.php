<?php
ob_start();
session_start();
 require_once "../includes/connection.php"; 
 require_once("../includes/frontconfig.inc.php");
 require_once "../includes/functions.inc.php";
 //require_once "../securimage/securimage.php";
 include("../includes/def_constant.inc.php");
// include('../design.php');
 include("../includes/useAVclass.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
@extract($_POST);

if(isset($cmdsubmit))
{
		
$salt =rand(19999, 29999);
$salt1 =rand(31999, 59999);
	 $txtename 		= content_desc($_POST['txtename']);
	 $txtlog   		= content_desc($_POST['txtlog']);
	$txtnpwd  		= content_desc($_POST['txtnpwd']);
	 $txtemail 		= content_desc($_POST['txtemail']);
	 $txtphone 		= content_desc($_POST['txtphone']);
	 $address		= content_desc($_POST['address']); 
	$captcha_code 	= content_desc($_POST['captcha_code']);
	$errmsg="";        // Initializing the message to hold the error messages
	
	if(trim($txtlog)=="")
	{
		$errmsg .="Please enter User Login Id."."<br>";	
	}
	else if(trim($txtlog)!="")
	{
		$tableName_send="signup";
		$field_name="login_name";
		$sql         = "select * from " . $tableName_send . " where " . $field_name . "='" . $txtlog . "'";
		$result1 = $conn->query($sql);
		$checkuniqe = $result1->num_rows; 
		// if($checkuniqe >0)
		// {
			// $errmsg=$errmsg."User Login Id already exits."."<br>";
		// }
	}
 

	if(trim($txtename)=="")
	{
		$errmsg .="Please enter name."."<br>";
	}
	else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,50}+$/", $txtename) == 0)
	{
	$errmsg .= "Name should be alphabet ,that should be minimum 3 and maximum 50."."<br>";
	}
	if(trim($txtemail)=="")
	{
		$errmsg .="Please enter Email Id."."<br>";
	}
	elseif (!filter_var(trim($txtemail), FILTER_VALIDATE_EMAIL)) {
		$errmsg=$errmsg."Email Id should be like abc@xyz.com."."<br>";
	}
	elseif(trim($txtemail)!="")
	{
		$tableName_send="signup";
		$field_name="user_email";
		$sql1  = "select * from " . $tableName_send . " where " . $field_name . "='" . $txtemail . "'";
		$result2 = $conn->query($sql1);
		$checkuniqe1 = $result2->num_rows; 
		// if($checkuniqe1 >0)
			// {
				// $errmsg=$errmsg."User Email Id already exits."."<br>";
			// }
			
	}

	if(trim($address)=="")
	{
		$errmsg .="Please enter Address."."<br>";
	}
	else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,150}+$/", $address) == 0)
	{
	$errmsg .= "Address should be alphanumeric ,that should be minimum 3 and maximum 150."."<br>";
	}
	if(trim($txtphone)=="")
	{
		$errmsg .="Please enter mobile Number."."<br>";
	
	}
	elseif(!is_numeric(trim($txtphone)))
	{
		$errmsg .="Mobile Number should be numeric."."<br>";
	}
	else if(preg_match("/^[0-9]{8,12}$/", trim($txtphone)) === 0)
	{
	$errmsg.="Mobile Number should be 8 to 12 digits."."<br>";
	}

	if(trim($captcha_code)=="")
	{

		$errmsg .="Please enter Captcha Code."."<br>";
	
	}
	else if($_POST['captcha_code']!="")
	{
		if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
			$errmsg .="Please enter correct captcha code.";
		}

	}

	
	
	if($errmsg == '')
		{
			
		$npass = $txtnpwd; //it is encoded using javascript
		$date=date('Y-m-d'); 	
		
	
		/*  $tableName_send="signup";
		$tableFieldsName_send=array("`user_name`","`login_name`","`user_pass`","`user_email`","`user_phone`","`user_dob`","`user_status`","`create_login_date`","`last_login_date`","`address`","`category`","`user_type`");
		$tableFieldsValues_send=array("$txtename","$txtlog","$npass","$txtemail","$txtphone","$dob","1","$date","","$address","0","1");
		 $useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
		$id=mysql_insert_id(); */
		
	 //echo	$sqlq ="INSERT INTO `signup` (`user_name`, `login_name`, `user_pass`, `user_email`, `user_phone`, `user_dob`, `user_status`, `create_login_date`, `address`, `category`, `user_type`) VALUES ('$txtename','$txtlog','$npass','$txtemail','$txtphone','$dob','1','$date','','$address','0','1')";
	// echo	$sqli1 = $conn->query($sqlq);

 $run_sql="Insert into `signup` set `user_name`='$txtename' , `login_name`='$txtlog' , `user_pass`='$npass' , `user_email`='$txtemail' , `user_phone`='$txtphone' , `user_dob`='$dob' , `user_status`='1' , `create_login_date`='$date' , `address`='$address' , `category`='0' , `user_type`='1' ";	
		
		$sqli1 = $conn->query($run_sql);
		$id = $conn->insert_id;
		
		$sql_admin_email = "SELECT user_email,user_name FROM signup where id=$id ";
		$res_admin_email = $conn->query($sql_admin_email);;
		$res_num_rows 	 = $res_admin_email->num_rows;
		$data = $res_admin_email->fetch_array();
		@extract($data);
		$userid=$salt.$id.$salt1;
		$email_from = $user_email; // Who the email is from 
		$email_subject = "Password Notification"; // The Subject of the email
		$email_to= $txtemail;
	
		$eol = "\n";
		$headers  = "MIME-Version: 1.0".$eol;
		$headers .= "Content-Type: text/html; charset=UTF-8".$eol;
		$headers .= "From: ".$email_from."".$eol;
				
		$email_message.="<table width='100%'  border='0' cellspacing='0' cellpadding='0' align='left'>
		<tr><td colspan='3' align='left' class='text_mail' >Dear  $txtename,</td></tr>
		<tr><td colspan='3' class='text_mail'>&nbsp;</td></tr>
		<tr> <td colspan='3' align='left' class='text_mail'>Your control panel login details are as follows:</td></tr>
		<tr><td  colspan='3' class='text_mail'>&nbsp;</td></tr>
		<tr><td width='40%' colspan='3' >
		<table width='50%'  border='0' cellspacing='0' cellpadding='0' align='left'>
                <tr><td class='text_mail'>User Name : $txtlog</td></tr>
				<tr><td class='text_mail'>User Password : $txtnpwd</td></tr>
		<tr><td width='10%' class='text_mail' align='left' >
		<a href='$HomeURL/auth/reset_password.php?uid=$userid'> Reset your Password</a>
		</td><td width='25%' align='left'> </td></tr>
		<tr><td class='text_mail'>&nbsp;</td></tr> </table>
		</td></tr>
                  <tr><td  colspan='3'>&nbsp;</td></tr>
                <tr><td class='text_mail' colspan='3'align='left'>Regards,</td></tr>
		<tr><td class='text_mail' colspan='3'align='left'> NWDA </td></tr>
		</table>";	
			if(mail($email_to, $email_subject, $email_message, $headers))
			{
				$status=1;
			
			}
			else
			{
			
				$status=0;
			}

		$dtime=date("Y-m-d H:i:s");
		// $tableName_send="resetpass";
		// $tableFieldsName_send=array("username","passtime","uid");
		// $tableFieldsValues_send=array("$userid","$dtime","$id");
		// $useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
		
		$sql5 = "INSERT INTO `resetpass`(`username`, `passtime`, `uid`)VALUES('$userid','$dtime','$id')";
			$sql21 = $conn->query($sql5);
		
		$msg=SENDING_DETAILS;
	
		$_SESSION['sess_msg']=$msg;
	
		header("location:signup.php");
		exit;

		}
		
}
function getRandomWord($len = 6) {
    $word = array_merge(range('0', '9'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}	
$ranStr = getRandomWord();
$_SESSION["captcha_code"] = $ranStr;

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
		<script src="<?php echo $HomeURL;?>/js/sha512.js" type="text/javascript"></script>
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	
	  <script type="text/javascript" language="javascript">
    function getPass()
    {
		
		var salt ='<?php print_r($_SESSION['salt']); ?>'; 
	
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var value = document.getElementById('<?php echo 'txtnpwd'; ?>').value;
		if (value=='')
        {
            alert('Please enter password');
            return false;
        }
        else
        {

			if (value.search(exp)==-1) 
            { 
            	//  return false;
            }
            if (value!='')
            {


				if(!value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,}/))
				{
					alert("Password minimum lenght is 8 character and contain At least one upper case, At least one lower case, At least one digit and At least one special character.");
					return false;
				}
				//alert(salt);
				//alert(hex_sha512(value)+salt);
				//alert(hex_sha512(hex_sha512(value)+salt));
				
                //var hash=hex_sha512(hex_sha512(value)+salt);
				//var hash=btoa(value);
				var hash=hex_sha512(value);
                document.getElementById('<?php echo 'txtnpwd'; ?>').value=hash;
				
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
.captcha{
	font-size: 28px;
font-family: verdana;
font-weight: 600;
font-style: italic;
background-image: linear-gradient(to right top, #8fa8b4, #9bb4c0, #a6c0cd, #b2cdd9, #bed9e6);
color: #566663;
}
</style>

<script>
function ClearFields() {
     document.getElementById("captcha_code").value = "";

}
</script>
	
	</head>
	
	<body id="fontSize" onmousedown="return false" onselectstart="return false">
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
							<li>Sign Up</li>
						</ul>
					</div>
       <div class="inner_right_container">
      <h1>Sign Up</h1>
<form name="loginform" id="register-form" action="" method="POST" autocomplete="off">
             <?php if($errmsg!=""){?>
          <div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop"></p>
<p> <label><img alt="error" src="<?php echo $HomeURL;?>/images/error.png"> Attention! </label><br /><br /><?php echo $errmsg; ?></p>
</div>
</div>
          <?php }?>
<?php if($_SESSION['sess_msg']!=""){?>
  <div  id="msgerror" class="status">
<div class="closestatus">
<p> <label><?php echo $_SESSION['sess_msg'];
							$_SESSION['sess_msg']=""; ?></label></p>
</div>
</div>
<?php }
					
					?>
<div class="frm_row">
	 <span class="label"><label>
					
					</label></span>
					
				<div class="clear"></div>
					<p>
                        <span class="label1">
                        <label for="txtlog">User login Id:<strong class="star">*</strong></label>
                        </span>
					<input name="txtlog" autocomplete="off" type="text" class="input_class" id="txtlog" placeholder="Valid User Login Id"  value="<?php if(content_desc(htmlspecialchars($txtlog))!=""){ echo content_desc($txtlog);}?>" maxlength="50"/>
                        <div class="clear"></div>
                 </div>
                       
                    <div class="frm_row">
                        <span class="label1">
                        <label for="txtename">Password:<strong class="star">*</strong></label></span>
           <input name="txtnpwd" type="password" autocomplete="off" class="input_class" id="txtnpwd" placeholder="password" value="" maxlength="10"/>
                         <div class="clear"></div>
                        </div>    
                        
                        
                        <div class="frm_row">
                        <span class="label1">
                        <label for="txtename">Name:<strong class="star">*</strong></label></span>
           <input name="txtename" type="text" autocomplete="off" class="input_class custName" id="txtename" placeholder="Valid Name"  value="<?php if(content_desc($txtename)!=""){ echo content_desc(htmlspecialchars($txtename));}?>" maxlength="20"/>
                         <div class="clear"></div>
                        </div>
						<div class="frm_row">
                        <span class="label1">
                        <label for="txtemail">Email id:<strong class="star">*</strong></label></span>
       <input name="txtemail" type="text" autocomplete="off" class="input_class" id="txtemail" placeholder="Valid Email id"  value="<?php if(content_desc(htmlspecialchars($txtemail))!=""){ echo content_desc($txtemail);}?>" maxlength="50"/>
                         <div class="clear"></div>
                        </div>
						<div class="frm_row">
                        <span class="label1">
                        <label for="address">Address:<strong class="star">*</strong></label></span>
           <input name="address" type="text" autocomplete="off" class="input_class" id="address" placeholder="Valid Address"  value="<?php if(content_desc($address)!=""){ echo content_desc($address);}?>" maxlength="60"/>
                         <div class="clear"></div>
                        </div>
						<div class="frm_row">
                        <span class="label1">
                        <label for="txtphone">Mobile No:<strong class="star">*</strong></label></span>
                     <input name="txtphone" type="text" autocomplete="off" class="input_class" maxlength="12" id="txtphone"  value="<?php if(content_desc($txtphone)!=""){ echo content_desc($txtphone);}?>" placeholder="Valid Mobile No" maxlength="15"/>
                         <div class="clear"></div>
                        </div>

<script type='text/javascript'>
function refreshCaptcha(){
 
 var img = document.images['captchaimg'];
 img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
//$("#book4").load(location.href + " #book4");
}
$('#txtphone').keypress(function(event){

       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault(); //stop character from entering input
       }

});
$('.custName').keyup(function() {
    $(this).val($(this).val().replace(/[^\w\s]+/g, ''));
});
</script>
 <div class="frm_row">
                           <label for="code">Captcha:<span class="star">*</span></label>
                           <img src="../content/captcha.php?rand=<?php echo rand();?>" id='captchaimg'> 
						<?php /*   <span id="book4" class="captcha"><?php echo $_SESSION["captcha_code"]; ?></span> */?>
                           <a href='javascript:void();' onclick="refreshCaptcha();" style="color:black;" >
                           <img src="../assets/captcha/refresh_b.png" alt="Reload Image">
                           </a>
                           <a href='javascript:void(0);' onclick="playAudio()" >
                           <img src="<?php echo $HomeURL;?>/upload/audio_icon.png" alt="Audio Captcha" id="playAudio" alt="Play Audio">
                           </a>
                           <?php 		
                              $value = str_split($_SESSION["captcha_code"]);
                              		
                              		foreach($value as $val){
                              		//$fileName = $_GET['file'];
                              		$fileName = $val;
                              		$path = 'upload/audio/en/';
                              		$file = $HomeURL.'/'.$path.$fileName.'.wav';
                              		$final_results[] = $file;
                              		}
                              ?>
                           <source src="<?php echo $HomeURL;?>/upload/audio/en/kids-playing-1.wav" type="audio/wav">
                           <div class="audio-wrapper">
                              <audio id="testAudio" src="<?php echo $final_results[0]; ?>" type="audio/wav">
                              </audio>
                           </div>
                           <script>
                              var playlist= [
                              <?php foreach($value as $val){
                                 $fileName = $val;
                                 $path = 'upload/audio/en/';
                                 $file = $HomeURL.'/'.$path.$fileName.'.wav';
                                 echo '"'.$file.'",';
                                 }?>
                                
                              ];
                              var currentTrackIndex = 0;    
                              var delayBetweenTracks = 1000;
                              
                              document.getElementById("playAudio").addEventListener("click", function(){  
                                var audio = document.getElementById('testAudio');
                                if(this.className == 'is-playing'){
                                  this.className = "";
                                  this.innerHTML = "Play"
                                  audio.pause();
                                }else{
                                  this.className = "is-playing";
                                  this.innerHTML = "Pause";
                                  audio.play();
                                }
                              });
                              
                              document.getElementById("testAudio").addEventListener("ended",function(e) {
                                var audio = document.getElementById('testAudio');      
                                setTimeout(function() { 
                                  currentTrackIndex++;
                                  if (currentTrackIndex < playlist.length) { 
                                    audio.src = playlist[currentTrackIndex];
                                    audio.play();
                                  }
                                }, delayBetweenTracks);
                              });
                           </script>
                        </div>
                                             
                 
<div class="frm_row">
    <label class="n_text">Enter above characters being displayed in above image </label>
    <input name="captcha_code" type="text" id="captcha_code" maxlength="6" autocomplete="off" class="input_class"  value=""  placeholder="Please Enter the Captcha Code"/>
</div> 
                        

<div class="frm_row">
        <span class="button_row">
        <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" title="Submit" onclick="return getPass();"/> 
		<input class="button" type="reset" name="cmdreset" title="Reset" value="Reset"> 
		<input type="button" name="Back" class="button" value="Back" onClick="javascript:location.href = 'index.php'" >
        </span>
</div>

</form>
 </div>
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
