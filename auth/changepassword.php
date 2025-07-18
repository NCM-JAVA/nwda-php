<?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include("../includes/def_constant.inc.php");
include('../design.php');
include("../includes/useAVclass.php");
$useAVclass = new useAVclass();
$useAVclass->connection(); 
@extract($_POST);
$_SESSION['salt'] == "";
$_SESSION['saltCookie'] == "";


	if ($_SESSION['admin_auto'] == '') {
		session_unset($_SESSION['admin_auto']);
		session_unset($_SESSION['logintype']);
		session_unset($_SESSION['login_user']);
		session_unset($_SESSION['cookie_email']);
		session_unset($_SESSION['cookie_fullname']);
		$_SESSION['IsAuthorized'] = false;
		$msg = "Login to Access Employee Corner";
		$_SESSION['sess_msg'] = $msg;
		header("Location:index.php");
		exit;
	}
		
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
	$uid=$_SESSION['admin_auto'];

	if(!is_numeric($uid))
	{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit();
	}

	if($cmdsubmit == "Update")
	{
		$txtpwd= trim(strtoupper($_POST['txtpwd']));
		$txtnpwd= trim(strtoupper($_POST['txtnpwd']));
		$txtcpwd= trim(strtoupper($_POST['txtcpwd']));

		$sql="Select user_pass,last_userpwd1,last_userpwd2,last_userpwd3,last_userpwd4 from signup where id='$uid'";
		$result=mysqli_query($conn, $sql);
		$numrow=mysqli_num_rows($result);
		$line_reset=mysqli_fetch_array($result); 
		@extract($line_reset);

		$convertpwd = strtoupper($txtpwd);
		if(trim($txtpwd)==""){
			$errmsg ="Please enter Old Password."."<br>";
		}

		if(trim($txtnpwd)==""){
			$errmsg.="Please enter New Password."."<br>";
		}
		if(trim($txtcpwd)==""){
			$errmsg .="Please enter Confirm Password."."<br>";
		}elseif($convertpwd!=$user_pass){
				$errmsg.="Please enter the correct old password.";
		}elseif($txtnpwd!=$txtcpwd){
				$errmsg.="Password mismatch! Please enter the same Confirm Password as New password.";
		}elseif($user_pass==$txtnpwd || $last_userpwd1==$txtnpwd  || $last_userpwd2==$txtnpwd || $last_userpwd3==$txtnpwd || $last_userpwd4==$txtnpwd){
				$errmsg=$errmsg."Please specify a different password from previous four passwords.";
		}
		if($errmsg==""){
			if($_SESSION['logtoken']!=$_POST['random']){
				session_unset($admin_auto_id_sess);
				session_unset($login_name);
				session_unset($dbrole_id);
				$msg = "Login to Access Admin Panel";
				$_SESSION['sess_msg'] = $msg ;
				header("Location:index.php");
				exit();
			}
			
			$sql1 = "UPDATE `signup` SET `user_pass`='$txtnpwd',`last_userpwd1`='$txtpwd',`last_userpwd2`='$last_userpwd1',`last_userpwd3`='$last_userpwd2',`last_userpwd4`='$last_userpwd3' WHERE id = '$uid'";
			$rs = $conn->query($sql1);
			
			
			$user_login_id=$_SESSION['admin_auto'];
			$page_id=$val;
			$msg = "Your Password has been Update Successfully";
			$_SESSION['edit_prof'] = $msg;
			header("location: profile.php");
			exit;
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
		<script src="<?php echo $HomeURL;?>/js/sha512.js" type="text/javascript"></script>
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>


<style>
#register-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align: left;
    width: 220px;
}
	#msgerror label{
	color: #FB3A3A;
	display: inline-block;
	margin: 0px;;
	padding: 0px;
	text-align: left;
	}
</style>
		
<script type="text/javascript" language="javascript">
function getPass(){
	var salt ='<?php print_r($_SESSION['salt']); ?>'; 
	var salt1 ='<?php print_r($_SESSION['salt1']); ?>'; 
	var salt2 ='<?php print_r($_SESSION['salt2']); ?>'; 
	var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
	var txtpwd = document.getElementById('txtpwd').value;
	var txtnpwd = document.getElementById('txtnpwd').value;
	var txtcpwd = document.getElementById('txtcpwd').value;
     
	if (txtpwd==''){
		alert('Please Enter old password');
		return false;
	}
	else if (txtnpwd==''){
		alert('Please enter new password');
		return false;
	}
	else if(!txtnpwd.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,}/)){
		alert("New Password minimum lenght is 8 character and contain At least one upper case, At least one lower case, At least one digit and At least one special character.");
		return false;
	}
	else if (txtcpwd==''){
		alert('Please enter Confirm password');
		return false;
	}
	else if(!txtcpwd.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&])[A-Za-z\d$@#!%*?&]{8,}/)){
		alert("Confirm Password minimum lenght is 8 character and contain At least one upper case, At least one lower case, At least one digit and At least one special character.");
		return false;
	}
	else if(txtnpwd != txtcpwd){
		alert("Password mismatch! Please enter the same Confirm Password as New password.");
		return false;
	}
	else{
		if ((txtpwd!='') && (txtnpwd!='') & (txtcpwd!='')){
			var hash=hex_sha512(txtpwd);
			var hash1=hex_sha512(txtnpwd);
			var hash2=hex_sha512(txtcpwd);
			document.getElementById('txtpwd').value=hash;
			document.getElementById('txtnpwd').value=hash1;
			document.getElementById('txtcpwd').value=hash2;
		}
	}
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
						
							<?php include("user_menu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a></li>
							<li></li>
							<li>Change Password</li>
						</ul>
					</div>
            
     <div class="inner_right_container">
	<?php  //include('menu.php');?>
	  	 <h2>Change Password</h2>
	<form id="register-form" name="changepass" method="post" action="" autocomplete="off"> 
 <?php if($errmsg!=""){?>
						<div  id="msgerror" class="status error">
						<div class="closestatus" style="float: none;">
						<p class="closestatus" style="float: right;"><img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop"></p>
						<p><img alt="error" src="<?php echo $HomeURL;?>/images/error.png"> <span>Attention! <br /></span>
						
						<?php echo $errmsg; ?></p>
						</div>
						</div>
						<?php }?>
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
			<!-- <span class="password_help">[Password must be 8 characters long, contains one digit, a lower case letter , one upper case letter and a special character.Example:Super@123]</span>-->
              </span>
              <div class="clear"></div>
            </div>
 <div class="frm_row"> <span class="label1">
              <label for="txtcpwd">Enter Confirm Password:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="txtcpwd" type="password" class="input_class" id="txtcpwd" maxlength="512" size="40" autocomplete="off" />
              </span>
              <div class="clear"></div>
            </div>
			<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" title="Update" onClick ="return getPass();"/>
             	<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
             <input name="cmdreset" type="submit" class="button" id="cmdreset" value="Reset" title="Reset" />
             <input type="submit" class="button" value="Back" title="Back" onClick="javascript:location.href = 'profile.php';" />
              </span>
              <div class="clear"></div>
            </div>

</form>
	  


   </section>

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
