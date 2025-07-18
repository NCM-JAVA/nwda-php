<?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include("../includes/def_constant.inc.php");
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
$sql = "select * from signup where id ='$admin_auto'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($line = mysqli_fetch_assoc($result)) {
    @extract($line);
}
if (isset($cmdsubmit)) {
	//$txtemail = addslashes(htmlspecialchars($txtemail));

	$u_name = trim($_POST['u_name']); 
	$u_phone = trim($_POST['u_phone']);
	 $u_address = trim($_POST['u_address']); 
    $errmsg = "";      
	  if (trim($u_name) == "") {
        $errmsg = "Please enter user Name"."<br>";;
        }
		else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,29}+$/", $u_name) == 0)
		{
		$errmsg .= "User Name must be from letters that should be minimum 3 and maximum 30."."<br>";
		}

		if(trim($u_phone)=="")
		{
		$errmsg .="Please enter Phone Number."."<br>";
		
		}
		else if(preg_match("/^[0-9]{10,12}$/", trim($u_phone)) === 0)
		{
		$errmsg.="Phone Number should be 10 to 12 digits."."<br>";
		}
	 if(trim($u_address) =="")
	{
		$errmsg.="Please enter Address."."<br>";
		
		/* if(preg_match("/^[aA-zZ0-9][a-zA-Z0-9 -,]{4,149}+$/", $u_address) == 0)
		{
			$errmsg .= "Comment must be from letters that should be minimum 5 and maximum 150 character ."."<br>";
		} */
	} 

    if ($errmsg == '') {
/*         $tableName_send = "signup";
        $whereclause = "id = '$cid'";
        $old = array("user_name","user_phone","address");
        $new = array("$u_name","$u_phone","$u_address");
      $val = $useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);  */
	  
		 $sql1 = "UPDATE `signup` SET `user_name`='$u_name',`user_phone`='$u_phone',`address`='$u_address' WHERE id = '$cid'"; 
		$rs = $conn->query($sql1);
	  
	  
	  
        $user_login_id = $_SESSION['admin_auto'];
        $page_id = $val;
        $url = substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1);
	
        $action = "Update employee profile";
        $categoryid = '0'; //super admin
        $date = date("Y-m-d h:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
/*         $tableName = "audit_trail";
        $tableFieldsName_send = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title");
        $tableFieldsValues_send = array("$user_login_id", "$page_id", "$url", "$action", "$model_id", "$date", "$ip", "$txtlanguage", "$txtepage_title");
        $value = $useAVclass->insertQuery($tableName, $tableFieldsName_send, $tableFieldsValues_send); */


		$tablesql3 = "INSERT INTO `audit_trail`(`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`)VALUES('$user_login_id','$page_id','$url','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title')";
				$rss = $conn->query($tablesql3);

        $msg = 'Profile Updated Successfully';
        $_SESSION['edit_prof'] = $msg;
        header("location: profile.php");
        exit;
    }
}

?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Edit Profile:NWDA</title>
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
	
	
<script>

    $(document).ready(function () {

        var i = false;

        $('.menu-icon').click(function () {

            $('.drop-down').stop(true, false).slideToggle(200);

        });

    });

</script>
<!--End -->
   
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
	#msgerror label{
	color: #FB3A3A;
	display: inline-block;
	margin: 0px;;
	padding: 0px;
	text-align: left;
	}
</style>

<script language="JavaScript" src="<?php echo $HomeURL; ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript">
 jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");

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
					   u_name: {
									required: true,
									alphanumeric: true						
						},
						u_phone: {
							required: true,
							number: true,
							minlength: 10
						},
						u_address: {
							required: true						
						}
					
                },
                messages: {
					u_name: "Please enter alphanumeric character or Name cannot contain Special Characters",
					u_phone: "Please Enter Valid Mobile No",
					u_address: "Please enter alphanumeric character or Address  cannot contain Special Characters"
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
							<li>Edit Profile</li>
						</ul>
					</div>
            
      <div class="inner_right_container">
	<?php  //include('menu.php');?>
      <h1>Edit Profile</h1>
	  </div>
<?php 
	 //include('menu.php');
 $edit="select user_name,user_email,user_phone,address from signup where id='$admin_auto'";
$result = mysqli_query($conn, $edit);
$res_rows=mysqli_num_rows($result);
$fetch_result=mysqli_fetch_array($result);
@extract($fetch_result);

?>
<?php if ($_SESSION['edit_prof'] != '') { ?>
                                            <div  id="msgclose" class="status success">
                                                <div class="closestatus" style="float: none;">
                                                   
                                                    <p><span>Attention! </span><?php echo $_SESSION['edit_prof'];
$_SESSION['edit_prof'] = "";?>
</p>
                                                </div>
                                            </div>
<?php } ?>
<form id="register-form" name="form1" autocomplete="off" method="post" action="">
						
						<div class="frm_row">
						<span class="label1">
						<label for="u_name">User Login Id:</label>
						</span>
						<strong><?php echo $login_name; ?></strong>
						<div class="clear"></div>
						</div>

						<div class="frm_row">
						<span class="label1">
						<label for="txtemail">Email:</label>
						</span>
						<strong><?php echo $user_email; ?></strong>
						<div class="clear"></div>
						</div>

						<div class="frm_row">
						<span class="label1"><label for="u_name">Name:</label></span>
						<span class="input1"><input name="u_name" type="text" class="input_class" id="u_name" value="<?php echo $user_name; ?>" /></span>
						<div class="clear"></div>
						</div>

						<div class="frm_row">
						<span class="label1">
						<label for="u_phone">Mobile:</label></span><span class="input1">
						<input name="u_phone" type="text" class="input_class" id="u_phone" maxlength="12" value="<?php echo $user_phone; ?>" />
						</span>
						<div class="clear"></div>
						</div>
						
						<div class="frm_row">
						<span class="label1">
						<label for="u_address">Address:</label>
						</span><span class="input1">
						<input name="u_address" type="text" class="input_class" id="u_address" value="<?php echo $address; ?>" />
						</span>
						<div class="clear"></div>
						</div>
						<div class="captcha_row">
                          <div class="clear"></div>
    </div>             
						
                                                <div class="frm_row"> <span class="button_row">
                                                        <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" title="Update" />
                                                        <input name="cid" type="hidden" value="<?php echo $id; ?>"/>
                                                        <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken']; ?>">
                                                            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" title="Reset"/>
                                                            <input type="button" class="button" value="Back"  title="Back"onClick="javascript:location.href = 'profile.php';" />
                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
                                            </form>
											</div>
    </div> 

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
