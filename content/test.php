<?php
ob_start();
error_reporting(0);
session_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
require_once "../securimage/securimage.php";
require "../phpmailer/PHPMailerAutoload.php"; 
$m_name = "Feedback";
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
if(isset($cmdsubmit))
{

	$txtename =content_desc(check_input($_POST['txtename']));
	$txtemail =content_desc(check_input($_POST['txtemail']));
	$txtphone =content_desc(check_input($_POST['txtphone']));
	$address =content_desc(check_input($_POST['address']));
	$txtcomment= content_desc(check_input($_POST['txtcomment']));

	//$feed_date=check_input($_POST['feed_date']);
	

	$errmsg="";        // Initializing the message to hold the error messages


	if(trim($txtename)=="")
	{
		$errmsg .="Please enter name."."<br>";
	}
	else if(preg_match("/^[aA-zZ][a-zA-Z ]{2,30}+$/", $txtename) == 0)
	{
	$errmsg .= "Name must be Alphabats that should be minimum 3 and maximum 30."."<br>";
	}
	
	if(trim($txtemail)=="")
	{
		$errmsg .="Please enter Email Id."."<br>";
	
	}
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $txtemail)){   
		$errmsg=$errmsg."Please enter valid email Id."."<br>";
	}
	
	if(trim($txtphone)=="")
	{
		$errmsg .="Please enter Phone Number."."<br>";
	
	}
	elseif(!is_numeric(trim($txtphone)))
	{
		$errmsg .="Phone number should be numeric."."<br>";
	}
	else if(preg_match("/^[0-9]{10,12}$/", trim($txtphone)) === 0)
	{
		$errmsg.="Phone Number should be minimun 10 digits."."<br>";
	}elseif($txtphone[0]<7)
	{
		$errmsg.="Phone Number should be valid."."<br>";
	}
	
	
	if(trim($txtcomment)=="")
	{
		$errmsg .="Please enter comments.<br>";
	}
	else if(preg_match("/^[aA-zZ0-9][a-zA-Z0-9 -.]{5,200}+$/", $txtcomment) == 0)
	{
	$errmsg .= "Please enter Alphanumeric Characters only, maximum 200."."<br>";
	}   
if($_POST['captcha_code']=="")
{
	$errmsg .="Please enter correct image code .<br>";
	
}


if($_POST['captcha_code']!="")
{

//if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
if(empty($_POST['captcha_code']) != 0){  
		$errmsg .="Please enter correct image code.";// Captcha verification is incorrect.   
	}
}

	if($errmsg == '')
		{


		
			$create_date=date('Y-m-d'); 	
			$tableName_send="feedback_form";
			$tableFieldsName_send=array("name","email","phone","address","comments","create_date","module_id");
			$tableFieldsValues_send=array("$txtename","$txtemail","$txtphone","$address","$txtcomment","$create_date","7");
			$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
			$id=mysql_insert_id();

			



			$sql_admin=mysql_query("select * from admin_login where id='101'");
			$line_admin=mysql_fetch_assoc($sql_admin);
			@extract($line_admin);
		$feedback_date=date('F j, Y');

		$name=$txtename;
		$to= $txtemail;
		$from=$user_email;
		$subject = "User Feedback Notification"; // The Subject of the email
	
		$message1.="<table width='100%'  border='0' cellspacing='0' cellpadding='0' align='left'>
		<tr><td colspan='3' align='left' class='text_mail' >Dear&nbsp;".$name.",</td></tr>
		<tr><td colspan='3' align='left' class='text_mail' >&nbsp;</td></tr>
		<tr><td colspan='3' class='text_mail'>Thank you for sharing your feedback with us. We will follow up with you regarding your questions, concerns or comments as soon as possible.</td></tr>
		<tr><td colspan='3' class='text_mail'></td></tr>
		<tr><td width='40%' colspan='3' >&nbsp;</td></tr>
		<tr><td class='text_mail' colspan='3' align='left'>Warm Regards,</td></tr>
		<tr><td class='text_mail' colspan='3' align='left'>NWDA Web Admin</td></tr>
		<tr><td class='text_mail' colspan='3' align='left'><a href='#' target='_blank'></a> </td></tr>
		<tr><td class='text_mail' colspan='3' align='left'> </td></tr>
		</table>";
		

			$mail = new PHPMailer;
			$mail->SMTPDebug = 0;                                // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'relay.nic.in';  // Specify main and backup SMTP servers  164.100.14.95
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			// $mail->Username = 'akaltest8@gmail.com';                 // SMTP username
			// $mail->Password = 'test@1234'; 
			// $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                                    // TCP port to connect to
			$mail->From = 'ddadmn-nwda@gov.in';
			$mail->FromName = 'Director Admin';   
			$mail->addAddress($to, $name);   
			$mail->addAddress('jeetesh.askonline@gmail.com', 'Jeetesh'); 			
			// $mail->addAddress('jeetesh.akalinfosys@gmail.com', 'jeetesh');            
			$mail->WordWrap = 50;                                 // Set word wrap to 50 characters 
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message1; 

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				echo 'Message has been sent';
			}

		
		$email_to= $user_email;
		//$headers .= "Reply-To: donotreply@example.com".$eol;

		$email_subject = "Feedback"; // The Subject of the email
		$email_message.="
		<table width='98%' border='0' align='center' cellpadding='2' cellspacing='2' class='normaltext'>
        <tr>
			<td colspan='3' align='left' valign='top'>Dear Admin,</td>
        </tr>
		    <tr>
			<td colspan='3' align='left' valign='top'>&nbsp;</td>
        </tr>
        <tr>
			<td colspan='3' align='left' valign='top'>Please find below an enquiry submitted. </td>
        </tr>

		 <tr>
			<td colspan='3' align='left' valign='top'>&nbsp;</td>
        </tr>
         <tr>
			  <td width='30%' align='left' valign='top'><strong>Name</strong></td>
			  <td width='1%' align='left' valign='top'><strong>:</strong></td>
			  <td width='69%' align='left' valign='top'>$txtename </td>
        </tr>
        <tr>
			<td align='left' valign='top'><strong>Email</strong></td>
			<td align='left' valign='top'><strong>:</strong></td>
			<td align='left' valign='top'>$txtemail</td>
		</tr>

		<tr>
			<td align='left' valign='top'><strong>Phone Number</strong></td>
			<td align='left' valign='top'><strong>:</strong></td>
			<td align='left' valign='top'>$txtphone</td>
		</tr>

		<tr>
			<td align='left' valign='top'><strong>Address</strong></td>
			<td align='left' valign='top'><strong>:</strong></td>
			<td align='left' valign='top'>$address</td>
		</tr>
		<tr>
			<td align='left' valign='top'><strong>Comments</strong></td>
			<td align='left' valign='top'><strong>:</strong></td>
			<td align='left' valign='top'>$txtcomment</td>
		</tr>
		<tr>
			<td align='left' valign='top'><strong>Feedback Date</strong></td>
			<td align='left' valign='top'><strong>:</strong></td>
			<td align='left' valign='top'>$feedback_date</td>
		</tr>

		<tr>
			<td colspan='3' align='left' valign='top'>&nbsp;</td>
		</tr>

			<tr>
			<td colspan='3' align='left' valign='top'>Regards,</td>
			</tr>
			<tr>
			<td colspan='3' align='left' valign='top'>$txtename</td>
			</tr>

		</table>";	

			$mail1 = new PHPMailer;
			$mail1->SMTPDebug = 0;                                // Enable verbose debug output
			$mail1->isSMTP();                                      // Set mailer to use SMTP
			$mail1->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers  164.100.14.95
			$mail1->SMTPAuth = true;                               // Enable SMTP authentication
			$mail1->Username = 'akaltest8@gmail.com';                 // SMTP username
			$mail1->Password = 'test@1234'; 
			$mail1->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
			$mail1->Port = 465;                                    // TCP port to connect to
			$mail1->From = 'akaltest8@gmail.com';
			$mail1->FromName = 'Jeetesh';   
			$mail1->addAddress($to, $name);            
			$mail1->addAddress('jeetesh.akalinfosys@gmail.com', 'jeetesh');                        
			$mail1->addAddress('jeetesh.shakya@akalinfosys.com', 'jeetesh');                        
			$mail1->WordWrap = 50;                                 // Set word wrap to 50 characters 
			$mail1->isHTML(true);                                  // Set email format to HTML
			$mail1->Subject = $email_subject;
			$mail1->Body    = $email_message;

			if(!$mail1->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail1->ErrorInfo;
			} else {
				echo 'Message has been sent';
			}

//  mail to Admin Ends

		$msg=FEED_NOTIFICATION;
		$_SESSION['sess_feedmsg']=$msg;
		echo $_SESSION['sess_feedmsg'];
		header("location:feedback.php?succ=yes");
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



function audio() {
		$value = str_split($_SESSION["captcha_code"]);
		
		foreach($value as $val){
		//$fileName = $_GET['file'];
		$fileName = $val;
		$path = 'upload/audio/en/';
		$file = 'nwda.gov.in/'.$path.$fileName.'.wav';

		//var audio = new Audio($file);
		//audio.play();
		echo "<script>
			 var audio = new Audio(".$file.");
			 audio.play();
			 alert('You have Logout successfully and see you next time.');
			 window.location='AdminLogin.php';
			</script>";
		
	}
		
}


?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Feedback: National Water Development Agency</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="Feedback">
		<meta name="description" content="User response on various works of NWDA">
		<meta name="keywords" content="ILR Feedback, User feedback">
		
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
	<style>

.captcha{
	font-size: 28px;
font-family: verdana;
font-weight: 600;
font-style: italic;
background-image: linear-gradient(to right top, #8fa8b4, #9bb4c0, #a6c0cd, #b2cdd9, #bed9e6);
color: #566663;
}
</style>
	</head>

	<body id="fontSize">
	<script>
   jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");

 jQuery.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
 });


(function($,W,D)
{
	//alert("fffff");
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#feedback-form").validate({
				
                rules: {
                  
					 txtemail: {
						required: true,
						email: true
						},
					txtphone: {
								required: true,
								number: true,
								minlength: 10
						},
					
					txtcomment: "required",
					code: "required"
						
                    
					
                },
                messages: {
                  txtename: "Please Enter Name that should be alphabet",
					txtemail: "Please  Enter Valid Email Id like abc@xyz.com ",
					 txtphone: "Please Enter Contact Number that should be 10 to 12 digits",
					 address: "Address should be alphanumeric",
					txtcomment: "Please Enter Comment",
                  	 code: "Please enter correct Captcha code"
					  
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
		
     document.getElementById("captcha_code").value = "";

}
</script>
<script>
function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
	      {
		  alert("Please enter numbers only");
              return false;
		  }
		else
		  {
              return true;
		  }
    }  



</script>

	
	
			<header>
			<?php include("top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle">
				</div>
		<nav>
		<div class="container">
			<?php include("header.php");?>
		</div>	
		</nav>
	<section>
		
			
			<div class="container"  id="skipCont">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Feedback</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
					</div>
					
						<h2>Feedback</h2>
                     <form action="feedback.php"  method="post" name="form1" id="feedback-form"   autocomplete="off">
					<?php if($errmsg!=""){?>
						<div  id="msgerror" class="status error">
							<div class="closestatus" style="float: none;">
								<p class="closestatus" style="float: right;">
									<img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop">
								</p>
								<p class="error1" >
									<label>
										<img alt="error" src="<?php echo $HomeURL;?>/images/error.png"> Attention! 
										<br />
										<?php echo $errmsg; ?>
									</label>
								</p>
							</div>
						</div>
						
						
						<?php }
						else if($_SESSION['sess_msg']!=''){?>
							<div  id="msgclose" class="status success">
								<div class="closestatus" style="float: none;">
									<p class="closestatus" style="float: right;">
										<img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop">
									</p>
									<p>
										<img alt="Attention" src="<?php echo $HomeURL?>/images/approve.png" class="margintop"> 
										<span>Attention! </span>
										<?php echo $_SESSION['sess_msg'];
										$_SESSION['sess_msg']=""; ?>
									</p>
								</div>
							</div>
							<?php	} ?>
					<?php if($_REQUEST['succ']=="yes"){?>
					<div align="left"><font color="green"><h3>Feedback added Successfully</h3></font></div>
					<?php } ?>
				<div class="form-group">
				  <label for="txtename" >Name:<span class="star">*</span></label>
				  <input type="text" class="form-control" name="txtename" id="txtename" value="<?php if(content_desc(htmlspecialchars($txtename))!=""){ echo content_desc(htmlspecialchars($txtename));}?>" placeholder="Enter Name">
				</div>
				<div class="form-group">
				  <label for="txtemail">Email:<span class="star">*</span></label>
				  <input type="text" class="form-control" name="txtemail" id="txtemail" value="<?php if(content_desc(htmlspecialchars($txtemail))!=""){ echo content_desc(htmlspecialchars($txtemail));}?>" placeholder="Enter Email">
				</div>
				<div class="form-group">
				  <label for="txtphone">Contact No:<span class="star">*</span></label>
				  <input type="text" class="form-control" onkeypress="return isNumber(event);" name="txtphone" maxlength="10" id="txtphone" value="<?php if(content_desc(htmlspecialchars($txtphone))!=""){ echo content_desc(htmlspecialchars($txtphone));}?>" placeholder="Contact Number">
				</div>
				
				<div class="form-group">
				  <label for="address">Address:<span class="star">*</span></label>
				  <input type="text" class="form-control" name="address" id="address" value="<?php if(content_desc(htmlspecialchars($address)!="")){ echo content_desc(htmlspecialchars($address));} ?>" placeholder="Enter Address">
				</div>
				
				<div class="form-group">
				  <label for="comment">Comment:<span class="star">*</span></label>
				  <span class="pull-left">
				 <textarea rows="5" cols="25" class="form-control"  name="txtcomment" id="comment" placeholder='Comment' style="width: 299px;" onkeyup="countChar(this)"><?php if(stripslashes(content_desc(htmlspecialchars($txtcomment!="")))){ echo content_desc(stripcslashes($txtcomment));} ?></textarea>
				 <span id="charNum"></span>
				  </span>
				  </div>
				  
  
<script>
function countChar(val) {
        var len = val.value.length;
        if (len >= 500) {
          val.value = val.value.substring(0, 500);
        } else {
          $('#charNum').text((500 - len)+' Characters are left.');
        }
};
</script>
<script type='text/javascript'>
function refreshCaptcha(){
  $("#book4").load(location.href + " #book4");
var img = document.images['captchaimg'];
img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}


</script>
				
				<div class="form-group">						
  <label for="captcha_code">Captcha :<span class="star">*</span></label>
   <?php /* <img src="../content/captcha.php?rand=<?php echo rand();?>" id='captchaimg'> */?><span id="book4" class="captcha"><?php echo $_SESSION["captcha_code"]; ?></span>
	<a href='javascript:void();' onclick="refreshCaptcha();" style="color:red" >
		<img src="../securimage/images/refresh_icon-big.png" alt="Reload Image">
	</a>
	<a href='javascript:void(0);' onclick="playAudio()" style="color:red" >
		<img src="../upload/audio_icon.png" alt="Audio Captcha" id="playAudio">
	</a>

<?php 		
$value = str_split($_SESSION["captcha_code"]);
		
		foreach($value as $val){
		//$fileName = $_GET['file'];
		$fileName = $val;
		$path = 'upload/audio/en/';
		$file = 'https://nwda.gov.in/'.$path.$fileName.'.wav';
		$final_results[] = $file;
		}
?>
<source src="https://nwda.gov.in/upload/audio/en/kids-playing-1.wav" type="audio/wav">

<div class="audio-wrapper">
	<audio id="testAudio" src="<?php echo $final_results[0]; ?>" type="audio/wav">
	</audio>
</div>


<script>
var playlist= [
<?php foreach($value as $val){
	$fileName = $val;
	$path = 'upload/audio/en/';
	$file = 'https://nwda.gov.in/'.$path.$fileName.'.wav';
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

<div class="form-group">
    <label class="n_text">Enter above characters being displayed in above image </label>
    <input name="captcha_code" type="text" id="captcha_code" placeholder='Captcha Code' class="form-control" maxlength="6" autocomplete="off"/>
	<input type="hidden" name="session" value="<?php echo $_SESSION["captcha_code"]; ?>"/>
</div>
			
				
				<div class="form-group">
     <span class="button_row"><input name="cmdsubmit" type="submit" class="btn btn-success" id="cmdsubmit" title="Submit" value="Submit" />
     <input name="cmdreset" type="reset" class="btn btn-success" id="cmdreset" value="Reset" /></span>
</div>
			</form>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
<script>
   $(function(){
	$('#txtename').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });

    $(function(){
	$('#txtemail').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!#$%^*_|+=?;'<>\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });
 
    $(function(){
	$('#address').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });
 
     $(function(){
	$('#subject').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });
 
      $(function(){
	$('#comment').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });
 
 function validatePhone(txtPhone) {

    var a = document.getElementById(txtPhone).value;

    var filter = /^[0-9-+]+$/;

    if (filter.test(a)) {

        return true;

    }

    else {
 
        return false;

    }

}​
 
</script>
	<a href="javascript:" id="return-to-top"><img src="../images/top-arrow.png" title="Go to Top" alt="Go to Top"></a>
    <script >
    // ===== Scroll to Top ==== 
    $(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
    $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
    scrollTop : 0                       // Scroll to top of body
    }, 500);
    });
    </script>


<script>
$('#msgerror').bind('click',function(){
	$('#msgerror').hide();
});
</script>

	</body>
	
</html>
