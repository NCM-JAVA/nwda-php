<?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../includes/useAVclass.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
@extract($_POST);
if($_SESSION['admin_auto']=='')
	{		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
$sql = "select * from signup where id ='$admin_auto'";
$result = mysql_query($sql);
$line = mysql_fetch_array($result);
$name=$line['user_name'];
$email=$line['user_email'];
if(isset($cmdsubmit))
{
$request_type = check_input($_POST['request_type']);
$topic_name = check_input($_POST['topic_name']);
$sortcontentdesc= check_input($_POST['sortcontentdesc']);
$createdate=date('Y-m-d h:i:s');
if(trim($request_type)=="")
		{
			$errmsg .="Please Select request type."."<br>";
		}
		if(trim($topic_name)=="")
		{
			$errmsg .="Please Enter topic name."."<br>";
		}
		if(trim($sortcontentdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
	if($errmsg == '')
	{
	if(trim($request_type)=="1"){
			$tableName_send="encyclopedia_threadlist";
			$tableFieldsName_old=array("Title","short_des","Author","Email","Posts","CreationDate");
			$tableFieldsValues_send=array("$topic_name","$sortcontentdesc","$txtename","$email","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
			$id=mysql_insert_id();
			$tableName_send="encyclopedia_messagelist";
			$tableFieldsName_old=array("Message","Author","Email","ThreadID","flag_id","m_status","CreationDate");
			$tableFieldsValues_send=array("$sortcontentdesc","","$email","$id","0","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
	}
	if(trim($request_type)=="2"){
			$tableName_send="communities_threadlist";
			$tableFieldsName_old=array("Title","short_des","Author","Email","Posts","CreationDate");
			$tableFieldsValues_send=array("$topic_name","$sortcontentdesc","$name","$email","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
			$id=mysql_insert_id();
			$tableName_send="communities_messagelist";
			$tableFieldsName_old=array("Message","Author","Email","ThreadID","flag_id","m_status","CreationDate");
			$tableFieldsValues_send=array("$sortcontentdesc","","$email","$id","0","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
	}
	if(trim($request_type)=="3"){
			$tableName_send="threadlist";
			$tableFieldsName_old=array("Title","short_des","Author","Email","Posts","CreationDate");
			$tableFieldsValues_send=array("$topic_name","$sortcontentdesc","$txtename","$email","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
			$id=mysql_insert_id();
			$tableName_send="messagelist";
			$tableFieldsName_old=array("Message","Author","Email","ThreadID","flag_id","m_status","CreationDate");
			$tableFieldsValues_send=array("$sortcontentdesc","","$email","$id","0","1","$createdate");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
	}
	$msg='Request topic has been sucssfully Sent to Admin';
$_SESSION['sess_msg']=$msg;
header("location:request_topic.php");
exit;	
	}
}
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request Topic :: Department of Disability Affairs</title>
<link rel="SHORTCUT ICON" href="<?php echo $HomeURL;?>/images/favicon.ico" />
<meta name="keywords" content="Request Topic " />
<meta name="description" content="Request Topic" />
<!--This is main stylesheet -->
<link href="<?php echo $HomeURL;?>/style/style.css" rel="stylesheet" type="text/css" /> <link href="<?php echo $HomeCss;?>style/page-background.css" rel="stylesheet" type="text/css"> <link href="<?php echo $HomeURL;?>/style/responsive.css" rel="stylesheet" type="text/css" /> <link href="<?php echo $HomeCss;?>style/page-responsive.css" rel="stylesheet" type="text/css"> 
<!--This is for mobile menu -->
<!--for dropdownmenu -->
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/access.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/dropdown.js"></script>

<script type="text/javascript">
      // initialise plugins
      jQuery(function () {
          dropdown('nav', 'hover', 1);
      });
</script>

<script>

    $(document).ready(function () {

        var i = false;

        $('.menu-icon').click(function () {

            $('.drop-down').stop(true, false).slideToggle(200);

        });

    });

</script>
<!--End -->
			<style>
#register-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align: left;
    width: 220px;
}
</style>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery-1.11.2.js"></script>
<script language="JavaScript" src="<?php echo $HomeURL; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {   setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    request_type: "required",
					topic_name: "required",
					sortcontentdesc: "required"
					
                },
                messages: {
					request_type: "Please  Select Request Type",
					topic_name: "Please  Enter Valid Topic Name",
					sortcontentdesc: "Please Enter Valid Short Description"
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

<body>

<!--Accessibility-->
<!--Accessibility-->
 <?php include('../content/accessbility-menu.php'); ?>
<!--Header-->


<!--Home page content-->
<!--Home page content-->
<div class="bottom-shadow">
<section>
  
<div class="menu-icon">
<div class="bar"> </div>
<div class="bar"> </div>
<div class="bar"> </div>
</div>
            

            
<div id="mcontent">
<nav class="drop-down tk-museo-sans">
    	   <?php include('../content/navigation.php'); ?>

    </nav>
  </div>  

    <div id="nav-banner-bottom">
     <?php include('../content/navigation-second.php'); ?>
    </div>
    <div class="clear"> </div>
    <div id="content-section">
      
      <div id="right-part-inner-page">
      <div id="about-us-buttons">
      <h2><a href="<?php echo $HomeURL;?>" title="Home">Home</a> >> Request Topic</h2>
      </div>
	    <?php include('menu.php');?>
      <div class="about-us-heading">
      <h2> Request Topic</h2>
     <div class="request-topic"> 
<form name="loginform" id="register-form" action="" method="post" autocomplete="off">
             <?php if($errmsg!=""){?>
          <div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p><label class="errors">Attention! <br /><?php echo $errmsg; ?></label></p>
</div>
</div>
          <?php }?>

<div class="frm_row">
	<?php if($_SESSION['sess_msg']!=""){?> <span class="label"><label>
					<?php echo $_SESSION['sess_msg'];
							$_SESSION['sess_msg']=""; ?>
					</label></span>
				<div class="clear"></div>
					<p>
					<?php }
					
					?>
             
                        <div class="clear"></div>
              </div>
                        
                        
                        
                        <div class="frm_row"> <span class="label1">
<label for="request_type">Request Type :</label>
<span class="star">*</span></span>
<select name="request_type" id="request_type" autocomplete="off" onChange="addevent(this.value)" >
<option value="">Select</option>
<?php 
foreach($request as $key=>$value)
{
	?>
<option value="<?php echo $key; ?>" <?php if($key==$request_type){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
<div class="clear"></div>
</div>
						<div class="frm_row">
                        <span class="label1">
                        <label for="topic_name">Topic Name:<strong class="star">*</strong></label></span>
       <input name="topic_name" type="text" autocomplete="off" class="input_class" id="topic_name" placeholder="Valid Topic Name"  value="<?php if($topic_name!=""){ echo stripslashes(html_entity_decode($topic_name));} ?>"/>
                         <div class="clear"></div>
                        </div>
						<div class="frm_row"> <span class="label1">
              <label for="sortcontentdesc">Short Description: </label>
              <span class="star">*</span></span>
              <textarea rows="16" cols="50" name="sortcontentdesc" autocomplete="off"  id="sortcontentdesc" onKeyUp="Javascript:charactersRemaining(this.form.sortcontentdesc, 1001, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1001, this.form.sortcontentdesc);" onKeyPress="Javascript:charactersRemaining(this.form.sortcontentdesc, 1001, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1001, this.form.sortcontentdesc);" onMouseOut="Javascript:charactersRemaining(this.form.sortcontentdesc, 1001, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1001, this.form.sortcontentdesc);" tabindex="1" ><?php  echo stripslashes(html_entity_decode($sortcontentdesc)); ?>
</textarea> <label style="float:right; margin-right:30px;" class="free" for="textarea_field">
		<script type="text/javascript">
			document.write("&nbsp;&nbsp;&nbsp;<input type='text' name='msg_left' id='msg_left' style='text-align:right;' size='3' value='1001' readonly='readonly' /> left of 1001 characters maximum.");
		</script>
		<noscript>(text limited to 1001 characters)</noscript>
		</label>
            
              <div class="clear"></div>
          
            </div>
						 <div class="frm_row">
                        <span class="button_row">
                      <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" title="Submit"/> <input type="reset" name="cmdreset" title="Reset" value="Reset">
                       </span>
					       <div class="clear"> </div> 
</div>
                        </form>
<div class="clear"> </div>
 </div>
<div class="clear"> </div>
</div>
</div>
<aside id="left-nav-inner-pages">
        <div>
<div id="main-points-section-inner-page"><?php if($_SESSION['admin_auto'] !=''){ include('left_menu_inner.php'); }?><?php include('../content/left_menu_inner.php');?></div>
 <div id="social-icons-inner-page"><?php include('../content/soical_media.php');?></div>
 
        </div>
      </aside> 
      <div class="clear"> </div>
    </div>
  </section>
</div>

<!--footer Section -->
<footer> 
<?php include('../content/footer.php');?>
</footer>
</body>
</html>
<script type="text/javascript">
<!--
	// This is just one validation technique, with frm parameter being the submitted form
	// function to validate the submitted form's textarea field
	function validate_textarea (frm)  
	{
		var result = false; // assume the worst
		frm.textarea_field.className=""; // sets display field style to be normal (could be a specific class)

		if (frm.textarea_field.value.length == 0) {
			// show error
			alert ("You must enter some text (10 characters minimum)!");
		} else if (frm.textarea_field.value.length < 10) {
			// show error
			alert ("You must enter atleast 10 characters!");
		} else {
			// OK
			result = true;
		}

		if (!result) {
			// focus in and highlight input field
			frm.textarea_field.className="err"; // assumes 'err' style class defined
			frm.textarea_field.focus();
		} else {
			alert ("Text entered:\n\n"+frm.textarea_field.value);
			frm.textarea_field.blur();
			frm.textarea_validate.blur();
		}

		return result;
	}

	function charactersRemaining(input, max, out) {
		if (input.value.length <= max) {
			out.value = (max - input.value.length);
		}
		else {
			out.value = 0;
		}
		//alert("charactersRemaining("+input.value+","+max+","+out.value+")");
	}

	function characterLimit(input, max) {
		if(input.value.length > max){
			// set field's value equal to first N characters.
			input.value = input.value.substring(0, max);
			//  move cursor out of form element to stop overwrite of the first character"
			input.blur();
			alert("No more text can be entered");
		}
	}
//-->
</script>