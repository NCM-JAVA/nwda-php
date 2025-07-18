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
	else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $txtename) == 0)
	{
	$errmsg .= "Name must be from letters that should be minimum 3 and maximum 30."."<br>";
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
	if(!is_numeric(trim($txtphone)))
	{
		$errmsg .="Phone number should be numeric."."<br>";
	}
	else if(preg_match("/^[0-9]{10,12}$/", trim($txtphone)) === 0)
	{
	$errmsg.="Phone Number should be less then to 10 digits."."<br>";
	}
	
	
	if(trim($txtcomment)=="")
	{
		$errmsg .="Please enter comments.<br>";
	}
	else if(preg_match("/^[aA-zZ0-9][a-zA-Z0-9 -.]{5,200}+$/", $txtcomment) == 0)

	{
	$errmsg .= "Please enter Alphanumeric Characters only, maximum 200."."<br>";
	}   
if($_POST['code']=="")
{
	$errmsg .="Please enter correct image code .<br>";
	
}


if($_POST['code']!="")
{

			$img = new Securimage();
			$valid = $img->check($_POST['code']);
			
			if($valid == true) 
			{
			
			}
			else
			{
				$errmsg .="Please enter correct image code.";
				//$_SESSION['sess_msg'] = $msg;
		
			}
}

//echo $errmsg ;

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
		<tr><td class='text_mail' colspan='3' align='left'>ICAR Web Admin</td></tr>
		<tr><td class='text_mail' colspan='3' align='left'><a href='#' target='_blank'></a> </td></tr>
		<tr><td class='text_mail' colspan='3' align='left'> </td></tr>
		</table>";
$eol = "\n";
//$message  = get_HTML_email_with_valid_formatting();
$headers  = "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: text/html; charset=UTF-8".$eol;
echo $headers .= "From: ".$from."".$eol;
//$headers .= "Reply-To: donotreply@example.com".$eol;
mail($to, $subject, $message1, $headers);


		// $email_from = $to; // Who the email is from 
	
		$email_subject = "Feedback"; // The Subject of the email
		echo $email_to= $user_email;
		$headers  = "MIME-Version: 1.0".$eol;
		$headers .= "Content-Type: text/html; charset=UTF-8".$eol;
		echo $headers .= "From: ".$to."".$eol;
		//$headers .= "Reply-To: donotreply@example.com".$eol;


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


		//$ok=@mail($email_to, $email_subject, $email_message, $headers);
		mail($email_to, $email_subject, $email_subject, $headers);

//  mail to Admin Ends

		$msg=FEED_NOTIFICATION;
		$_SESSION['sess_feedmsg']=$msg;
		echo $_SESSION['sess_feedmsg'];
		header("location:feedback.php?succ=yes");
		exit;

		}
}
?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>National Water Development Agency</title>
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
	<script type="text/javascript" src="<?php echo $HomeURL?>/assets/js/validatejs.js"></script> 
	</head>
	<script type="text/javascript">
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
		
     document.getElementById("code").value = "";

}
</script>
<script type="text/javascript">
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
	<body id="fontSize">
			<header>
			<?php include("top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("header.php");?>
		</div>	
		</nav>
	<section>
		
			
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Feedback</li>
						</ul>
					</div>
              <div class="container-fluid">
		<div class="row">
			 <?php //include("mainmenu.php");?>
			<div class="col-sm-12 inner-main-contant">
                   <h2>Search </h2>
					 <?php $qtext=content_desc($_GET['q']); ?>


<form  action="<?php echo $HomeURL;?>/content/search.php" id="cse-search-box" name="searchform" onSubmit=" if(this.q.value == '' || this.q.value.length < 1) { alert('Please enter a Search Keyword'); return false; }else {return gsearch('searchform')}">
<input type="hidden" value="013280925726808751639:prx_1_bgpve" name="cx">
<input type="hidden" value="FORID:10" name="cof">
<input type="hidden" value="UTF-8" name="ie" />
<div class="form-group">
<label for="qq">Enter your keywords</label>
<input type="text"  autocomplete="off"  id="qq" class="form-control" name="q" value="<?php echo content_desc(htmlspecialchars(htmlentities($qtext)));?>"  />
</div>
<input type="image" alt="Search" id="cmdsubmit"   class="top-search btn btn-success" title="Search" />


</form>

<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=en"></script>
<div id="cse-search-results" style="padding-left:10px; height:auto"></div>

<script>
(function() {
var cx = '013280925726808751639:prx_1_bgpve';
var gcse = document.createElement('script');
gcse.type = 'text/javascript';
gcse.async = true;
gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
'//cse.google.com/cse.js?cx=' + cx;
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(gcse, s);
})();
</script>
<gcse:searchresults-only></gcse:searchresults-only>

<script>
 $(function(){
	$('#qq').keyup(function()
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
</script>
				
	     
		
            </div>
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
	
	</body>
	
</html>
