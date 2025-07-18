<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass_1.php");
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
 
if(isset($cmdsubmit))
{

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

foreach ($_POST['mname'] as  $data)
	{
	$val .=$data.',';
	}

$salt =rand(19999, 29999);
$salt1 =rand(31999, 59999);
	$txtename 		= content_desc($_POST['txtename']);
	$txtlog 		= content_desc($_POST['txtlog']);
	$txtemail 		= content_desc($_POST['txtemail']);
	$txtphone 		= content_desc($_POST['txtphone']);
	$address		= content_desc($_POST['address']);
	$category		= content_desc($_POST['category']);
	$state			= content_desc($_POST['state']);
	$designation	= content_desc($_POST['designation']);
	$code			= content_desc($_POST['code']);
	$errmsg			= "";        // Initializing the message to hold the error messages
	
	if(trim($txtlog)==""){
		$errmsg ="Please enter User Id Name."."<br>";	
	}
	/*  else if(preg_match("/^[I-X0-9a-zA-Z_]{3,10}$/", $txtlog) === 0){
		$errmsg .= " User Id name must be from letters that should be minimum 4 and maximum 10."."<br>";
	} else if(trim($txtlog)!=""){
		$tableName_send="signup";
		$field_name="login_name";
		$checkuniqe=check_unique($txtlog,$field_name,$tableName_send);
		if($checkuniqe >0){
			$errmsg=$errmsg."User Login Name already exits."."<br>";
		}
	}*/
	if(trim($txtename)==""){
		$errmsg .="Please enter name."."<br>";
	}
	/* else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $txtename) == 0){
		$errmsg .= "Name must be from letters that should be minimum 3 and maximum 30."."<br>";
	} */
	if(trim($txtemail)==""){
		$errmsg .="Please enter Email Id."."<br>";
	}
	/* elseif(preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $txtemail)){   
		$errmsg=$errmsg."Please enter valid email Id."."<br>";
	} elseif(trim($txtemail)!=""){
		$tableName_send="signup";
		$field_name="user_email";
		$checkuniqe=check_unique($txtemail,$field_name,$tableName_send);
				
		if($checkuniqe >0){
			$errmsg=$errmsg."User Email Id already exits."."<br>";
		}	
	}*/
		
	if(trim($txtphone)==""){
		$errmsg .="Please enter mobile Number."."<br>";
	}
	elseif(!is_numeric(trim($txtphone))){
		$errmsg .="mobile Number should be numeric."."<br>";
	}
	/*else if(preg_match("/^[0-9]{8,12}$/", trim($txtphone)) === 0){
		$errmsg.="mobile Number should be 8 to 12 digits."."<br>";
	} */ 
	if($errmsg == ''){
		$date=date('Y-m-d');
		$defaultpass = "6A8EABB9447E2FD817035C282E2275D4FA21F91409DD4726EB071D35E645418192FEB3B5F0C60FF836345481BCF3739E3C728E91BD97AA191F92C148BE4BECAE";

		$insert_sql = "INSERT INTO `signup` (`user_name`, `login_name`, `user_pass`, `user_email`, `user_phone`, `user_status`, `create_login_date`, `last_login_date`, `address`, `category`, `designation`) VALUES ('$txtename', '$txtlog', '$defaultpass', '$txtemail', '$txtphone','1', '$date', NULL, NULL, NULL, '$designation')";
		$rss1 = $conn->query($insert_sql);

		$id=$conn->insert_id;
		
	
		$msg="Employee Added Successfully";
		$_SESSION['manage_user']=$msg;
		header("location:manage_front_user.php");
		exit;

	}
		
}


/* while (list ($key,$val) = @each ($mname)){  		
	$tableName_send="map_info";
	$tableFieldsName_send=array("page_id","info_id");
	$tableFieldsValues_send=array("$id","$val");
	$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
} */


/* 		$dtime=date("Y-m-d H:i:s");
$tableName_send="resetpass";
$tableFieldsName_send=array("username","passtime","uid");
$tableFieldsValues_send=array("$userid","$dtime","$id");
$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
$msg=SENDING_DETAILS; */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Employee : <?php echo $sitename; ?></title>
<link rel="SHORTCUT ICON" href="images/favicon.ico" />
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="js/jquery-1.11.2.js"></script>

<script type="text/javascript">    dropdown('nav', 'hover', 1);</script>


<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
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
<script type = "text/javascript" >
      function burstCache() {
        if (!navigator.onLine) {
            document.body.innerHTML = 'Loading...';
            window.location = 'index.php';
        }
    }
</script>
<script>
var a=navigator.onLine;
if(a){
// alert('online');
}else{
alert('offline');
window.location='index.php';
} 
</script>

<script type="text/javascript">
jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");


(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {   setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
                    txtlog:{
						required: true,
						alphanumeric: true
						},
                    txtename:  {
						required: true,
						alphanumeric: true
						},
					 txtemail: {
						required: true,
						email: true
						},
						address: "required",
						txtphone: {
						required: true,
						number: true,
							minlength: 12
						}
					
                },
                messages: {
					txtlog: "Please enter alphanumeric character or  User login Id cannot contain Special Characters",
					txtename: "Please enter alphanumeric character or  Name cannot contain Special Characters",
					txtemail: "Please  Enter Valid Email Id",
					address: "Please  Enter Valid Address",
					txtphone: "Please  Enter Valid Mobile No"
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

</head>
<body>
<?php include('top_header.php'); ?>
<div id="container">

 <!-- Header start -->
  

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  
  
  <div class="main_con">
     <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_front_user.php">User Management</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Add Employee</span>
  </div>
<div class="clear"> </div>
</div>      


	<div class="right_col1">
                	<div class="clear"></div>
     
        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser">Add Employee</h3>
 </div>		
<div class="clear"></div>
 <p>&nbsp;</p>

    
           <form name="loginform" id="register-form" action="" method="post" autocomplete="off">
             <?php if($errmsg!=""){?>
          <div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
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
                        <span class="label1">
                        <label for="txtlog">User login Id:<strong class="star">*</strong></label>
                        </span>
					<input name="txtlog" autocomplete="off" type="text" class="input_class" id="txtlog" placeholder="Valid User Login Id"  value="<?php if($txtlog!=""){ echo $txtlog;} ?>"/>
                        <div class="clear"></div>
              </div>
                        
                        
                        
                        <div class="frm_row">
                        <span class="label1">
                        <label for="txtename">Name:<strong class="star">*</strong></label></span>
           <input name="txtename" type="text" autocomplete="off" class="input_class" id="txtename" placeholder="Valid Name"  value="<?php if($txtename!=""){ echo $txtename;} ?>"/>
                         <div class="clear"></div>
                        </div>
						<div class="frm_row">
                        <span class="label1">
                        <label for="txtemail">Email id:<strong class="star">*</strong></label></span>
       <input name="txtemail" type="text" autocomplete="off" class="input_class" id="txtemail" placeholder="Valid Email id"  value="<?php if($txtemail!=""){ echo $txtemail;} ?>"/>
                         <div class="clear"></div>
                        </div>


                        <div class="frm_row">
                        <span class="label1">
                        <label for="txtemail">Designation:<strong class="star">*</strong></label></span>
       <input name="designation" type="text" autocomplete="off" class="input_class" id="txtemail" placeholder="Designation"  value="<?php if($designation!=""){ echo $designation;} ?>"/>
                         <div class="clear"></div>
                        </div>



                      




<div class="grid_view" width="100%">
		
              	
				<div class="clear"></div>


						<div class="frm_row">
                        <span class="label1">
                        <label for="txtphone">Mobile No:<strong class="star">*</strong></label></span>
                     <input name="txtphone" type="text" autocomplete="off" class="input_class" maxlength="12" id="txtphone" onKeyPress="return isNumberKey(event)"  value="<?php if($txtphone!=""){ echo $txtphone;} ?>" placeholder="Valid Mobile No"/>
                         <div class="clear"></div>
                        </div>
 
                        <div class="login">
                      <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button title="Submit"/> <input type="reset" name="cmdreset" title="Reset" class="button value="Reset">
					  &nbsp;<input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_front_user.php';" />
                       
     <div class="clear"> </div> 
</div>
    
         
</div>
                        </form> 

<!-- right col -->







<!-- Content Area end -->





 
  </div>  <!-- main con-->

   

</div> <!-- Container div-->

 <!-- Footer start -->

<?php include("footer.php"); ?>
                            <!-- Footer end -->
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

