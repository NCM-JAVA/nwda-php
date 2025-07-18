<?php
	ob_start();
	session_start();
	error_reporting(0);
	require_once "../includes/connection.php";
	require_once("../includes/frontconfig.inc.php");
	require_once "../includes/config.inc.php";
	require_once "../includes/functions.inc.php";
	 // require_once "../securimage/securimage.php";
	 // include('../design.php');
	include("../includes/useAVclass.php");
  
	$useAVclass = new useAVclass();
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
	if($_SESSION['admin_auto']!='')
	{	

		header("Location:profile.php");
		exit;	
	}elseif($cmdsubmit){
		
	 	$login = trim($_POST['txtusername']);
		$password = trim($_POST['txtpassword']);

		$_SESSION['sess_msg']=""; 
 
		if(($login=="") && ($password==""))
		{
			$msg="Please enter username and password."."<br>";
			$_SESSION['sess_msg'] .= $msg;
		} 
		if($_POST['captcha_code']=="")
		{
			$msg="Please enter code."."<br>";
			$_SESSION['sess_msg'] .= $msg;
		}
  
		if($login!="" && $password!="" && $_POST['captcha_code']!="")
		{

			// if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
				// $msg="Please enter correct image code";
				// $_SESSION['sess_msg'] = $msg;
			
				// header("Location: index.php");
				// exit;
			// }
			if($msg == '')
			{	
				$qry="SELECT * from signup where login_name='$login' "; 
				$result1 = $conn->query($qry);
				while($data = $result1->fetch_array())
				{
					@extract($data);
					$db_admin =$data['id'];
					$username =$data['login_name'];
					$user_name =$data['user_name'];
					$user_email =$data['user_email'];
					$db_pwd =$data['user_pass'];
					$category =$data['category'];
					
					 $newpwd=strtoupper(hash("sha512",$db_pwd.$salt));

					//if( $username==$login && $newpwd==$password)
					if( $username==$login)
					{
						
						session_regenerate_id(session_id());
						$admin_auto =$db_admin;
						$_SESSION['cookie_fullname']=$user_name;
						$_SESSION['cookie_email']=$user_email;
						$_SESSION['admin_auto'] = $admin_auto;
						$_SESSION['logintype'] = $user_type;
						$_SESSION['login_user'] =$username;
						$_SESSION['Temp']=$_SESSION['saltCookie'];
						setcookie("Temp",$_SESSION['saltCookie']);
						$_SESSION['IsAuthorized']=true;
						
						$_SESSION['Temptest']=$_SESSION['saltCookie'];
												
						$expire=0; 
						$path=''; 
						$domain='';
						$secure=false;
						$httponly=true;

						setcookie("Temp",$_SESSION['saltCookie'],$expire,$path,$domain,$secure,$httponly);
						$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
						session_write_close();
						$user_id=$_SESSION['admin_auto'];
						$page_id=mysql_insert_id();
						$action="Login";
						$model_id='Front Login';
						$categoryid='1'; //mol_content
						$date=date("Y-m-d h:i:s");
						$ip=$_SERVER['REMOTE_ADDR'];

						$sqlq = "INSERT INTO `audit_trail`(`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`) VALUES ('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
						

						if ($sqli1 = $conn->query($sqlq) === TRUE) {
							if($user_type == 1){
								header("location:discussion_forum.php");
								exit; 
							}else{
								if($category==1){
									header("location:information.php");
									exit;
								} else{
									header("location:profile.php");
									exit;
								}	
							}
							if($_SESSION['uri']!=''){
								$uri=explode('/',$_SESSION['uri']);
								$url=$uri['3'];
								header("location:$url");
								die('byyy');
								exit;
							}
						}
					}else{
					
						$msg="Please enter correct username and password.";
						$_SESSION['sess_msg'] = $msg;
					}
				}
			}
			else{
				echo "jiii"; die;
				$msg="Please enter username and password.";
				$_SESSION['sess_msg'] = $msg;
				header("Location: index.php");
				exit;
			}
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
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	<script src="<?php echo $HomeURL;?>/js/sha512.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript">
    function getPass()
    {
		
		var salt ="<?php echo $_SESSION['salt']; ?>"; 
	
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var value = document.getElementById('<?php echo "txtpassword"; ?>').value;
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
	
	<body id="fontSize">
			<header>
			<?php include("../content/top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="">
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
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a> >> </li>
							<li>Login</li>
						</ul>
					</div>
     <div class="inner_right_container">
      <h1>Login</h1>
<form name="loginform" id="register-form" action="" method="post" autocomplete="off">
<div class="frm_row">
	<?php if($_SESSION['sess_msg']!=""){?> <label class="errors">
					<?php echo $_SESSION['sess_msg'];
							$_SESSION['sess_msg']=""; ?>
					</label>
				<div class="clear"></div>
					<p>
					<?php }
					
					?>
                        <span class="label1">
                        <label for="txtusername">User login Id:<strong class="star">*</strong></label>
                        </span>
                       <input name="txtusername" autocomplete="off" type="text" id="txtusername" placeholder="Valid User Name"  value=""/>
                        <div class="clear"></div>
              </div>
                        
                        
                        
                        <div class="frm_row">
                        <span class="label1">
                        <label for="txtpassword">Password:<strong class="star">*</strong></label></span>
                     <input name="txtpassword" type="password" autocomplete="off" class="input_class" id="txtpassword" placeholder="Valid Password" value=""/>
                         <div class="clear"></div>
                        </div>

<script type='text/javascript'>
function refreshCaptcha(){
$("#book4").load(location.href + " #book4");
}
</script>

                        <div class="frm_row">
                               <label for="code">Captcha:<span class="star">*</span></label>
 <?php /* <img src="../content/captcha.php?rand=<?php echo rand();?>" id='captchaimg'> */?><span id="book4" class="captcha"><?php echo $_SESSION["captcha_code"]; ?></span>
  
	<a href='javascript:void();' onclick="refreshCaptcha();" style="color:red" >
		<img src="../securimage/images/refresh_icon-big.png" alt="Reload Image">
	</a>
					   <a href='javascript:void(0);' onclick="playAudio()" >
		<img src="../upload/audio_icon.png" alt="Audio Captcha" id="playAudio" >
	</a>
	<?php 		
$value = str_split($_SESSION["captcha_code"]);
		
		foreach($value as $val){
		//$fileName = $_GET['file'];
		$fileName = $val;
		$path = 'upload/audio/en/';
		$file = 'http://nwda.gov.in/'.$path.$fileName.'.wav';
		$final_results[] = $file;
		}
?>
<div class="audio-wrapper">
	<audio id="testAudio" src="<?php echo $final_results[0]; ?>"></audio>
</div>
</div>
                                             
                 
<div class="frm_row">
    <label class="n_text">Enter above characters being displayed in above image </label>
    <input name="captcha_code" type="text" id="captcha_code" maxlength="6" autocomplete="off" class="input_class"  value=""  placeholder="Please Enter the Captcha Code"/>
</div>                   
                    
<div class="frm_row">
    <span class="button_row">
                  <input type="submit" name="cmdsubmit" id="cmdsubmit" value="Login" class="button"  title="Login" onClick ="return getPass();"/> 
                 
    </span>
     <input type="reset" name="cmdreset" class="button" title="Reset" value="Reset">
    <span class="forget"><a href="forgetpassword.php" title="Forgot Password?">Forgot Password? </a> &nbsp; &nbsp;<a href="signup.php" title="Sign Up?">Sign Up?</a> </span>
</div>

  </form>
 </div>
</div> 
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("../content/footer.php");?>
		</footer>
<script>
var playlist= [
<?php foreach($value as $val){
	$fileName = $val;
	$path = 'upload/audio/en/';
	$file = 'http://nwda.gov.in/'.$path.$fileName.'.wav';
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
