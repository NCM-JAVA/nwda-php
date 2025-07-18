<?php ob_start();
require_once "../../includes/connection.php";
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
if($role_id < 0)
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
$role_id=$_SESSION['dbrole_id']; 

if(isset($cmdsubmit))
{
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);
  
$salt =rand(19999, 29999);
$salt1 =rand(31999, 59999);
	$txtename =content_desc($_POST['txtename']);
	$txtlog = content_desc($_POST['txtlog']);
	$txtemail =content_desc($_POST['txtemail']);
	$txtphone =content_desc($_POST['txtphone']);
	$dateofbirth= content_desc($_POST['dob']);
	//$designation=content_desc($_POST['designation']);
   if ($_POST['designation'] && !empty($_POST['designation'])) {
      $designation = content_desc($_POST['designation']);
    } else {
        $designation = 0;
    }
   
	$sta=explode('-',$dateofbirth);
	//$dob=$sta['0']."-".$sta['1']."-".$sta['2'];
   if (isset($sta['0'], $sta['1'], $sta['2']) && !empty($sta['0']) && !empty($sta['1']) && !empty($sta['2'])) {
      $dob = $sta['0'] . "-" . $sta['1'] . "-" . $sta['2'];
    } else {
        $dob = "0000-00-00";
    }
    
	$roleid = content_desc($_POST['RoleID']);
	$modulename=$_POST['modulename'];
	$txtlanguage =content_desc($_POST['txtlanguage']);
	$errmsg="";        // Initializing the message to hold the error messages
if(trim($txtlog)=="")
	{
		$errmsg ="Please enter User Id Name."."<br>";	
	}
	else if(preg_match("/^[I-X0-9a-zA-Z_]{6,30}$/", $txtlog) === 0)
 		{
	          $errmsg .= "Please enter Alphanumeric value that should be minimum 6 and maximum 30."."<br>";
		}
	else if(trim($txtlog)!="")
		{
		$tableName_send="admin_login";
		$field_name="login_name";
		//$checkuniqe=check_unique($txtlog,$field_name,$tableName_send);
		
		$sql         = "select * from " . $tableName_send . " where " . $field_name . "='" . $txtename . "'";
		$rs          = mysqlI_query($conn, $sql);
		$result_rows = mysqli_num_rows($rs);
		if ($result_rows > 0) {
			$checkuniqe = 1;
			
		} else {
			$checkuniqe = 0;
			
		}
		
		if($checkuniqe >0)
			{
				$errmsg=$errmsg."Someone already has that user name Try another"."<br>";
			}
		}
	if(trim($txtename)=="")
	{
		$errmsg .="Please enter name."."<br>";
	}
	else if(preg_match("/^[aA-zZ][a-zA-Z -]{3,30}+$/", $txtename) == 0)
	{
	$errmsg .= "Please enter only alphabets that should be minimum 3 and maximum 30."."<br>";
	}
	if(trim($txtemail)=="")
	{
		$errmsg .="Please enter Email Id."."<br>";
	}
	elseif(preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $txtemail)){   
		$errmsg=$errmsg."Please enter valid email Id."."<br>";
	}
			
	elseif(trim($txtemail)!="")
		{
		$tableName_send="admin_login";
		$field_name="user_email";
		//$checkuniqe=check_unique($txtemail,$field_name,$tableName_send);
		
		$sql         = "select * from " . $tableName_send . " where " . $field_name . "='" . $txtename . "'";
		$rs          = mysqli_query($conn, $sql);
		$result_rows = mysqli_num_rows($rs);
		if ($result_rows > 0) {
			$checkuniqe = 1;
			
		} else {
			$checkuniqe = 0;
			
		}
		
		if($checkuniqe >0)
			{
				$errmsg=$errmsg."User Email Id already exits."."<br>";
			}
			
		}

	if(trim($txtphone)=="")
	{
		$errmsg .="Please enter Phone Number."."<br>";
	
	}
	elseif(!is_numeric(trim($txtphone)))
	{
		$errmsg .="Phone Number should be numeric."."<br>";
	}
	else if(preg_match("/^[0-9]{8,12}$/", trim($txtphone)) === 0)
	{
	$errmsg.="Phone Number should be 8 to 12 digits."."<br>";
	}

	if($errmsg == '')
		{
		if($_SESSION['logtoken']!=$_POST['random'])
		{
		
	
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
		}
		else {
		$_COOKIE['Temp']="";
		$_SESSION['saltCookie']="";
		$_SESSION['Temptest']="";
		$saltCookie =uniqid(rand(59999, 199999));
		$_SESSION['saltCookie'] =$saltCookie;
		$_SESSION['Temptest']=$_SESSION['saltCookie'];
		setcookie("Temp",$_SESSION['saltCookie']);
		$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
	
	}


		$date=date('Y-m-d'); 	
		$defaultpass = "D9E6762DD1C8EAF6D61B3C6192FC408D4D6D5F1176D0C29169BC24E71C3F274AD27FCD5811B313D681F7E55EC02D73D499C95455B6B5BB503ACF574FBA8FFE85";//its 123456789
		$sql= "INSERT INTO `admin_login`(`user_name`, `login_name`, `user_pass`, `user_email`, `user_phone`, `user_dob`, `user_status`, `role_id`, `create_login_date`, `last_login_date`, `designation`, `user_type`, `orgdesignation`, `flag_id`) VALUES ('$txtename','$txtlog','$defaultpass','$txtemail','$txtphone','$dob','1','$RoleArray','$date','$date','$designation','$txttype','$designation', '0')"; //$org_designation
		$rs = $conn->query($sql);
		
		$id=$conn->insert_id;
		$sql_admin_email = "SELECT user_email,user_name FROM admin_login where id=$id ";
		$res_admin_email =mysqli_query($conn, $sql_admin_email);
		$res_num_rows=mysqli_num_rows($res_admin_email);
		$data=mysqli_fetch_array($res_admin_email);
		@extract($data); 
		$userid=$salt.$id.$salt1;


		$dtime=date("Y-m-d H:i:s");		 
		$sql1= "INSERT INTO `resetpass`(`username`, `passtime`, `uid`, `status`) VALUES ('$userid','$dtime','$id',0)";
		$rss = $conn->query($sql1);
		
		
		$msg=SENDING_DETAILS;
		$_SESSION['manage_user']=$msg;
		header("location:manage_user.php");
		exit;

		}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add user : <?php echo $sitename;?></title>
<link rel="SHORTCUT ICON" href="images/favicon.ico" />
<link href="style/admin.css" rel="stylesheet" type="text/css">
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="js/jsDatePick.js"></script>
<script language="JavaScript" src="js/validation.js"></script>
<script type="text/javascript">    dropdown('nav', 'hover', 1);</script>
 <style type="text/css">
    .label {width:100px;text-align:right;float:left;padding-right:10px;font-weight:bold;}
    #register-form label.error, .output {color:#FB3A3A;font-weight:bold;}
  </style>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dob",
			dateFormat:"%d-%m-%Y"
		});
		
	};

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



function addevent(id) {
	if(id=='2')
		{ 	document.getElementById('txtuser').style.display = 'block';
			
		}
	
		else 
		{	
		document.getElementById('txtuser').style.display = 'none';
		
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
			<span class="submenuclass"><a href="manage_user.php">User Management</a></span>
			<span class="submenuclass">>> </span>
			 <span class="submenuclass"><a href="welcome.php">Manage User</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add User</span>
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
      	<div class="clear"></div>
     
        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser">Add User</h3>
 

			
			
			

 </div>		
<div class="clear"></div>
 <p>&nbsp;</p>

            <form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return add_user('form1')" id="register-form" novalidate="novalidate">
           
                    <div class="frm_row"> <span class="label1">
<label for="texcat">User Type :</label>
<span class="star">*</span></span> <span class="input1">
<select name="txttype" id="txttype" autocomplete="off" onChange="addevent(this.value)"   ><!-- onChange="addevent(this.value) -->
<option value="">Select</option>
<?php 
foreach($user_type as $key=>$value)
{
?>
<option value="<?php echo $key; ?>" <?php if($key==$txttype){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
?>
</select></span>
<div class="clear"></div>
</div>

                    <div class="frm_row"> <span class="label1">
                    <label for="txtlog">User Id:</label>
                    <span class="star">*</span></span> <span class="input1">
                    <input name="txtlog" type="text" class="input_class" id="txtlog" size="30" value="<?php if(htmlspecialchars($txtlog!="")){ echo htmlspecialchars($txtlog);} ?>" autocomplete = "off" placeholder="User Id" required/>
                    </span>
                    <div class="clear"></div>
                    </div>
                <div class="frm_row"> <span class="label1">
              <label for="txtename">Name:</label>
              <span class="star">*</span></span> <span class="input1">
             <input name="txtename"  type="text" class="input_class" id="txtename" size="30" value="<?php if(htmlspecialchars(content_desc($txtename!=""))) { echo htmlspecialchars($txtename);} ?>" autocomplete = "off" placeholder="Name" required/>	  </span>
              <div class="clear"></div>
            </div>
            
            <div class="frm_row"> <span class="label1">
              <label for="txtemail">Email:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="txtemail" type="text" class="input_class" id="txtemail" size="30" value="<?php if($txtemail!=""){ echo $txtemail;} ?>" autocomplete = "off" placeholder="xyz@gmail.com" required />
              </span>
              <div class="clear"></div>
            </div>
             <!--<div class="frm_row"> <span class="label1">
			 
              <label for="designation">Designation:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="designation" type="text" class="input_class" id="designation" size="30" value="<?php if($designation!=""){ echo  htmlentities($designation);} ?>" autocomplete = "off" placeholder="Designation" required/>
              </span>
              <div class="clear"></div>-->
            
			<div id="txtuser"  <?php if($txtuser=='2') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>

            <div class="frm_row"> <span class="label1">
									<label for="org_designation">Designation :</label>
									<span class="star">*</span></span> <span class="input1">
									<?php 
									$sqlquery=mysqli_query($conn, "Select * from org_setup where approve_status='3' order by deg_id ASC"); ?>
                                                                        

									<select name="org_designation" id="org_designation">
									<option value="">Select</option>
									<?php while($result=mysqli_fetch_array($sqlquery))
									{
									 ?>
									<option value="<?php echo $result['deg_id'];?>"<?php if($result['deg_id']==$designationId) { echo  "selected='selected'"; } else {
									} ?>><?php echo $result['designation']; ?></option>
									<?php } ?>
									</select>
									</span>
											<div class="clear"></div>
										</div>
										</div>
            <div class="frm_row"> <span class="label1">
              <label for="txtphone">Phone Number:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="txtphone" type="text" class="input_class" size="13" id="txtphone" maxlength="12"
			  value="<?php if($txtphone!=""){ echo $txtphone;} ?>" autocomplete = "off" onkeypress="return isNumberKey(event)" placeholder="XXXXXXXX" required/>
               </span>
              <div class="clear"></div>
            </div>
			 <!--<div class="frm_row"> <span class="label1">
				<label for="dob">Date of Birth:</label>
				<span class="star">*</span></span> <span class="input1">
				<input type="text" name="dob" id="dob"  value="<?php if($dob!=""){ echo $dob;} ?>" readonly="readonly"  onKeyPress="return isNumberKey(event)"  autocomplete="off"placeholder="DD-MM-YYYY" required/><span class="date">[dd-mm-yyyy]</span>
				
				</span>
				<div class="clear"></div>
				</div>-->
			   <div class="frm_row"> <span class="button_row">
                 <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Submit" />
                <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
             <input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_user.php';" />
             
              </span>
              <div class="clear"></div>
            </div>
            </form>

</div>

<!-- right col -->


    <div class="clear"></div>




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
	
<script>
  $(function(){
    $("#txtphone").keyup(function(e){
        if($(this).val()==0){
			$(this).val('');
		} else {
           $(this).val(formatNumber($(this).val()));
		}
    });
  });

</script>	
	
<style>
.hide {display:none;}
</style>

