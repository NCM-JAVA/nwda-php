<?php 
	ob_start();
	include("../../includes/config.inc.php");
	include("../../includes/useAVclass.php");
	include("../../includes/functions.inc.php");
	include("../../includes/def_constant.inc.php");
	@extract($_GET);
	@extract($_POST);
	@extract($_SESSION);
	$useAVclass = new useAVclass();
	$useAVclass->connection();
	$role_id=$_SESSION['dbrole_id'];  
	if($_SESSION['admin_auto_id_sess']==''){		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
	if($role_id > 0){
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}	

	if($_SESSION['saltCookie'] !=$_COOKIE['Temp']){
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}


	if(isset($cmdsubmit)){


		$txtename 		= content_desc($_POST['txtename']);
		$txtemail 		= content_desc($_POST['txtemail']);
		$txtphone 		= content_desc($_POST['txtphone']);
		$address 		= content_desc($_POST['address']);
		$user_status	= content_desc($_POST['user_status']);
		$category		= content_desc($_POST['category']);
		//$modulename=$_POST['modulename'];
		$errmsg="";        // Initializing the message to hold the error messages

		if(trim($txtename)==""){
			$errmsg .="Please enter Name."."<br>";
		}
		/* else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $txtename) == 0){
			$errmsg .= "Name must be from letters that should be minimum 3 and maximum 30."."<br>";
		} */
		if(trim($txtemail)==""){
			$errmsg .="Please enter Email Id."."<br>";
		}
		/* elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $txtemail)){   
			$errmsg=$errmsg."Please enter valid email Id."."<br>";
		}elseif(trim($txtemail)!=""){
			$tableName_send="signup";
			$field_name="user_email";
			$field_id="id";
			$id=$cid;
			$checkuniqe=edit_check_unique($tableName_send,$field_name,$txtemail,$field_id,$id);
			if($checkuniqe >0){
				$errmsg=$errmsg."User Email Id already exits."."<br>";
			}	
		} else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $address) == 0){
			$errmsg .= "Address must be from letters that should be minimum 3 and maximum 30."."<br>";
		} */
		if(trim($txtphone)==""){
			$errmsg .="Please enter Phone Number."."<br>";
		}
		/* elseif(!is_numeric(trim($txtphone))){
			$errmsg .="Phone Number should be numeric."."<br>";
		} */
		/* else if(preg_match("/^[0-9]{8,12}$/", trim($txtphone)) === 0){
			$errmsg.="Phone Number should be 8 to 12 digits."."<br>";
		} */
	
		if($errmsg == ''){
			if($_SESSION['logtoken']!=$_POST['random']){
				$msg = "Login to Access Admin Panel";
				$_SESSION['sess_msg'] = $msg ;
				header("Location:error.php");
				exit();
			}else {
				$_COOKIE['Temp']="";
				$_SESSION['saltCookie']="";
				$_SESSION['Temptest']="";
				$saltCookie =uniqid(rand(59999, 199999));
				$_SESSION['saltCookie'] =$saltCookie;
				$_SESSION['Temptest']=$_SESSION['saltCookie'];
				setcookie("Temp",$_SESSION['saltCookie']);
				$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
			}

			/* if($user_status=='1'){	
				$salt =rand(19999, 29999);
				$salt1 =rand(31999, 59999);
				$sql_admin_email = "SELECT user_email,user_name,user_status FROM signup where id=$cid ";
				$res_admin_email =mysqli_query($conn, $sql_admin_email);
				$res_num_rows=mysqli_num_rows($res_admin_email);
				$data=mysqli_fetch_array($res_admin_email);
				echo "hiii"; die;
			} */
				
/* 			$tableName_send="signup";
			$whereclause="id='$cid'";
			$old=array("user_name","user_email","user_phone","user_status","address","category","state_id","designation");
			$new=array("$txtename","$txtemail","$txtphone","$user_status","$address","$category","$state","$designation");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */

		
		  	 $sql1 = "UPDATE `signup` SET `user_name` = '$txtename', `user_email` = '$txtemail', `user_phone` = '$txtphone',`user_status` = '$user_status',`designation` = '$designation' WHERE `id`='$cid'";
		
			$rsq = $conn->query($sql1);

			$user_login_id=$cid;
			$page_id=$cid;
			$action="update creater mod aprove";
			$url =substr(strrchr($_SERVER['PHP_SELF'], "/"), 1);
			$categoryid='0';//super admin
			$date=date("Y-m-d h:i:s");
			$ip=$_SERVER['REMOTE_ADDR'];
			$auditsql = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`) VALUES ('$user_login_id','$page_id','$url','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title')";
			$rss = $conn->query($auditsql);	

			//$msg=SENDING_DETAILSE;
			$msg="Employee Details Updated";
			$_SESSION['manage_user']=$msg;
			header("location:manage_front_user.php");
			exit;
		}
	}

	if(!is_numeric(trim($editid))){
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
	}
	$edit="select * from signup where id='$editid'";
	$result = mysqli_query($conn, $edit);
	$res_rows=mysqli_num_rows($result); 
	$fetch_result=mysqli_fetch_array($result);
	@extract($fetch_result);

	/* if($mname !=""){
	$sql=mysqli_query($conn, "Delete from map_info where page_id='$cid'");
	while (list ($key,$val) = @each ($mname)){
	$tableName_send="map_info";
	$tableFieldsName_send=array("page_id","info_id");
	$tableFieldsValues_send=array("$cid","$val");
	$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
	}
	} */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Edit Employee: <?php echo $sitename; ?></title>
		<link rel="SHORTCUT ICON" href="images/favicon.ico" />
		<link href="style/admin.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
		<script type="text/javascript">    dropdown('nav', 'hover', 1);</script>
		<script type="text/javascript">
			function isNumberKey(evt){
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57)){
					return false;
				}else{
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
			if(a){}else{
				alert('offline');
				window.location='index.php';
			} 
		</script>
		<script type="text/javascript">
			jQuery.validator.addMethod("alphanumeric", function(value, element) {
				return this.optional(element) || /^\w+$/i.test(value);
			}, "Letters, numbers, and underscores only please");
			(function($,W,D){
				var JQUERY4U = {};
				JQUERY4U.UTIL ={   
					setupFormValidation: function(){
						$("#register-form").validate({
							rules: {
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
			<?php include_once('main_menu.php');  ?>
			<div class="main_con">
				<div class="admin-breadcrum">
					<div class="breadcrum">
						<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
						<span class="submenuclass">>> </span> 
						<span class="submenuclass"><a href="manage_front_user.php">Manage Employee Management</a></span>
						<span class="submenuclass">>> </span>
						<span class="submenuclass">Edit Employee</span>
					</div>
					<div class="clear"> </div>
				</div>    
				<div class="right_col1">
					<?php if($errmsg!=""){?>
					<div  id="msgerror" class="status error">
						<div class="closestatus" style="float: none;">
							<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
							<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
						</div>
					</div>
					<?php }?>
					<div class="addmenu"> 
						<div class="internalpage_heading">
							<h3 class="manageuser">Edit User</h3>
						</div>		
						<div class="clear"></div>
						<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" id="register-form" onsubmit="return edit_user('form1')">
							<div class="frm_row"> <span class="label1">
								<label>User Id :</label>
								</span><span class="label2"><?php echo $fetch_result['login_name'];?></span>
								<div class="clear"></div>
							</div>     
							
							<div class="frm_row"> <span class="label1">
								<label for="txtename">Name:</label>
								<span class="star">*</span></span> <span class="input1">
								<input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30" value="<?php echo $fetch_result['user_name'];?>"/></span>
								<div class="clear"></div>
							</div>
		
							<div class="frm_row"> <span class="label1">
								<label for="txtemail">Email:</label>
								<span class="star">*</span></span> <span class="input1">
								<input name="txtemail" autocomplete="off" type="text" class="input_class" id="txtemail" size="30" value="<?php echo $fetch_result['user_email'];?>"/></span>
								<div class="clear"></div>
							</div>

							<div class="frm_row">
								<span class="label1">
								<label for="txtemail">Designation:<strong class="star">*</strong></label></span>
								<input name="designation" type="text" autocomplete="off" class="input_class" id="txtemail" placeholder="Valid Email id"  value="<?php echo $fetch_result['designation'];?>"/>
								<div class="clear"></div>
							</div>




							<div class="grid_view" width="100%">
								<div class="frm_row"> <span class="label1">
									<label for="txtphone">Mobile Number:</label>
									<span class="star">*</span></span> <span class="input1">
									<input name="txtphone" autocomplete="off" type="text" class="input_class" id="txtphone" maxlength="12" size="13" value="<?php echo $fetch_result['user_phone'];?>" onkeypress="return isNumberKey(event)"/>
									</span>
									<div class="clear"></div>
								</div>

			   
								<div class="frm_row"> 
									<span class="label1"><label for="user_status">User Status:</label></span> <span class="input1">
									<select name="user_status" id="user_status" autocomplete="off">
										<option value=""> Select </option>
										<?php  foreach($status as  $key => $value) { ?>
										<option value="<?php echo $key; ?>"<?php if($key==$fetch_result['user_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
										<?php } ?>
									</select>
									</span>
									<div class="clear"></div>
								</div>
								<div class="frm_row"> 
									<span class="button_row"> 
										<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" />&nbsp;
										<input name="cmdreset" type="submit" class="button" id="cmdreset" value="Reset" />&nbsp <input name="cid" type="hidden" value="<?php echo $fetch_result['id'];?>"/><input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">&nbsp;<input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_front_user.php';" />
									</span>
									<div class="clear"></div>
								</div>
							</div><!-- right col -->
						</form>
						<div class="clear"></div>
					</div>  <!-- area div-->
				</div>  <!-- main con-->
				<?php include("footer.inc.php");  ?>
			</div> <!-- Container div-->
		</div> <!-- Container div-->
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

