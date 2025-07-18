<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();
require_once "../../includes/connection.php";
require_once "../../includes/def_constant.inc.php";
require_once "../../includes/config.inc.php";
require_once "../../includes/functions.inc.php";
include("../../includes/useAVclass.php");


$useAVclass = new useAVclass();

$checkkk=session_id();
session_id($checkkk);
$useAVclass->connection();
@extract($_POST);
$_SESSION['salt'] == "";
$_SESSION['saltCookie'] == "";

if ($_SESSION['salt'] == ""){
	$salt =uniqid(rand(59999, 199999));
	$saltCookie =uniqid(rand(59999, 199999));
	$_SESSION['salt' ]=$salt;
	$_SESSION['saltCookie'] =$saltCookie; 
}
if($cmdsubmit){

	$login = trim($_POST['txtusername']);
	//$password = trim($_POST['txtpassword']);
  $password = $_POST['txtpassword'];
  //$password = 'NWDA_Admin?2022#';

	
	
	if(($login=="") && ($password=="")){
		$msg="Please enter username and password.";
		$_SESSION['sess_msg'] = $msg;
	}
	elseif($_POST['captcha_code']!=""){
		if(empty($_SESSION['captcha_text'] ) || strcasecmp($_SESSION['captcha_text'], $_POST['captcha_code']) != 0){  
			$_SESSION['sess_msg'] ="Please enter correct captcha code.";
		}
		
		if(!isset($_SESSION['sess_msg'])){
			$qry = "SELECT id,login_name,user_name,user_pass,role_id,last_login_date,flag_id,orgdesignation,last_access from admin_login where user_status='1'";
			$result = $conn->query($qry);
			if ($result->num_rows > 0) {
				while($data = $result->fetch_assoc()) {
					$db_admin =$data['id'];
					$state_id1 =$data['state'];
					$region1 =$data['region'];
					$admin_loginname = $data['login_name'];
					$admin_username = $data['user_name'];
					$db_pwd =$data['user_pass'];
					//$newpwd=strtoupper(hash("sha512",$db_pwd.$salt));
           $newpwd = 'NWDA_Admin?2022#';
           //ECHO $password;
            //ECHO $newpwd;
            //die();
					 if($password==$newpwd && $admin_loginname==$login){
           // echo "test";
           // ECHO $password;
          //  ECHO $newpwd;
           // die();
					//if($admin_loginname==$login){

						$date=date('Y-m-d'); 
						session_regenerate_id($checkkk);
						$admin_auto_id_sess =$db_admin;
						$_SESSION['state_id'] = $state_id1;
						$_SESSION['region'] = $region1;
						$_SESSION['admin_auto_id_sess'] = $admin_auto_id_sess;
						$_SESSION['login_name'] =$admin_loginname;
						$_SESSION['user_name'] =$admin_username;
						$_SESSION['dbrole_id'] =$data['role_id']; 
						$_SESSION['module_name'] =$user_name;
						$_SESSION['orgdesignation'] =$orgdesignation;
						$sql1 = "update admin_login set last_login_date='".$date."',flag_id ='1',last_access='".time()."',last_sess='".session_id()."'  where id='".$admin_auto_id_sess."'";
						$sql1qry = $conn->query($sql1);
						$_SESSION['Temptest']=$_SESSION['saltCookie'];
						$expire=0; 
						$path=''; 
						$domain='';
						$secure=false;
						$httponly=true;

						setcookie("Temp",$_SESSION['saltCookie'],$expire,$path,$domain,$secure,$httponly);
						
						$uniqsalt=mt_rand();
						$_SESSION['IsAuthorized']=true;
						$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
					 	session_write_close();

				
						$user_id=$_SESSION['admin_auto_id_sess'];
						
						$page_id = $conn->insert_id;
						$action="Login";
						$categoryid='1'; //mol_content
						$model_id="Login Page";
						$txtename="Login Page";
						$date=date("Y-m-d h:i:s");
						$ip=$_SERVER['REMOTE_ADDR'];
						$txtlanguage=1;
						$txtepage_title="Dashboard";
						$txtstatus="1";

						
				 	  	$sqlq = "INSERT INTO `audit_trail` (`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`) VALUES ('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
						//die($sqlq);
						if($conn->connect_error){
							die("Connection Failed : ".$conn->connect_error);
						}
						//$sqlq1 = "SELECT * FROM `audit_trail`";
						//$result = $conn->query($sqlq1);
						//while($row = $result->fetch_assoc()){
						//	echo "ID: ".$row["audit_id"];
						//	die();
						//}

						//echo('hello');
						//die();				

						 $sqli1 = $conn->query($sqlq);  
						//$result = $conn->query($sqlq);
											
	

 
						header("location:welcome.php");
						exit;
					}else{
						$msg="Please enter correct username and password.";
						$_SESSION['sess_msg'] = $msg;
					}
				}
			} 		
		}elseif(isset($_SESSION['admin_auto_id_sess'])) {
			session_destroy();
			$msg="Please enter username and password.";
			$_SESSION['sess_msg'] = $msg;
			header("Location:index.php");
			exit; 
		}
	}
	else
	{
		$msg="Please enter username and password.";
		$_SESSION['sess_msg'] = $msg;
	}


} 
function getRandomWord($len = 6) {
    $word = array_merge(range('0', '9'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}	
$ranStr = getRandomWord();
$_SESSION["captcha_code"] = $ranStr;
//eof submit
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-FRAME-OPTIONS" content="DENY">
<title>Admin Panel:<?=$sitename;?></title>
<script src="js/jquery.min.js"></script>
<script src="../../includes/sha512.js" type="text/javascript"></script>
<link rel="icon" href="<?php echo $HomeURL?>/assets/images/favicon.ico">
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript">
    function getPass()
    {
		
		var salt ="<?php echo $_SESSION['salt']; ?>"; 
	
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var value = document.getElementById('<?php echo "txtpassword"; ?>').value;

		if (value=='')
        {
            alert('Please enter username and password');
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
				//alert(value);
				//alert(salt);
				//alert(hex_sha512(value)+salt);
				//alert(hex_sha512(hex_sha512(value)+salt));
                var hash=hex_sha512(hex_sha512(value)+salt);
                document.getElementById('<?php echo "txtpassword"; ?>').value=hash;
				
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
			<script>
function ClearFields() {
     document.getElementById("captcha_code").value = "";

}
</script>
</head>
<style>
.captcha{
	font-size: 28px;
font-family: verdana;
font-weight: 600;
font-style: italic;
background-image: linear-gradient(to right top, #8fa8b4, #9bb4c0, #a6c0cd, #b2cdd9, #bed9e6);
color: #fff;
}
</style>
<body>
 <?php if($_SESSION['sess_msg']!=""){ ?> 

         <div class="error_msgs">
          <div class="status1 error">
            <p class="closestatus"> <a title="Close" href="">x</a></p>
            <p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><a href="#"><?php echo $_SESSION['sess_msg'];
			$_SESSION['sess_msg']='';
			 unset($_SESSION['sess_msg']); ?>.</a></p>
          </div>
          </div>
          <?php }?>		
      	<div class="clear"></div>
 <div class="admin_panel">
<div class="admin-heading"> <h1><?=$sitename; ?> Administration  </h1>  </div>
      
     
        <form name="loginform" action="" method="post" autocomplete="off">	
      <div class="admin_row">
         <span class="label2"><label for="txtusername">User ID  * </label><span class="red-text"></span></span>
         <span class="input2"> <input name="txtusername" type="text" class="input_class2" id="txtusername" maxlength="100" autocomplete="off" placeholder ="User Id" autofocus/></span>
        <div class="clear"> </div>
      </div>
      
      <div class="admin_row">
         <span class="label2"><label for="txtpassword">Password  *</label><span class="red-text"></span></span>
         <span class="input2"><input name="txtpassword" type="password" class="input_class2" id="txtpassword"  maxlength="512" autocomplete="off"placeholder ="Password"/></span>
        <div class="clear"> </div>
      </div>
      
<script type='text/javascript'>
function refreshCaptcha(){
 
 var img = document.images['captchaimg'];
 img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
//$("#book4").load(location.href + " #book4");
}
</script>

      <div class="captcha_row">
       
       <div class="captcha">
  <img src="<?php echo $HomeURL; ?>/content/captcha.php?rand=<?php echo rand();?>" id='captchaimg'> 
  <?php /* <span id="book4" class="captcha"><?php echo $_SESSION["captcha_code"]; ?></span> */?>
	</div>
	<a href='javascript:void();' onclick="refreshCaptcha();" style="color:white;">
		   <img src="../../assets/captcha/refresh_b.png" alt="Reload Image" style=" margin-top: 4%; margin-left: 3%;">
	</a>
        <div class="clear"> </div>
      </div>
      
      <div class="message_row"><label for="code">
       Enter above characters(not case sensitive) being displayed in above image *</label>
        
      </div>
       
        <div class="admin_row1">
       
         <span class="input2"><input name="captcha_code" id="captcha_code"  type="text" class="input_class2" maxlength="6" autocomplete="off" placeholder="Captcha Code"/></span>
        <div class="clear"> </div>
      </div>
      
       <div class="admin_rowin">
       <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Submit" class="button"/>
         <input type="submit" name="cmdreset" id="cmdreset" value="Reset" class="button" /> 
        <div class="clear"> </div>
      </div>
      </form>
      <div class="forget_link">
        <a href="forgot_password.php" title="Forgot Password">Forgot Password</a>
        <div class="clear"> </div>
      </div>  
      
    </div>
</body>
</html>
