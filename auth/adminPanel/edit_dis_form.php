<?php 
	ob_start();
	include("../../includes/config.inc.php");
	require_once "../../includes/connection.php";
	include("../../includes/useAVclass.php");
	include("../../includes/functions.inc.php");
	include("../../includes/def_constant.inc.php");
	include_once 'ckeditor/ckeditor.php';
	include_once 'ckfinder/ckfinder.php';
	include ('pdf2text.php');
	$useAVclass = new useAVclass();
	$useAVclass->connection();
	$role_id=$_SESSION['dbrole_id'];
	$user_id=$_SESSION['admin_auto_id_sess'];
	$model_id= "12";

// $role_map=role_permission($user_id,$role_id,$model_id);
// $role_id_page=role_permission_page($user_id,$role_id,$model_id);

	$sql         = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
    $rs          = $conn->query($sql);
    $role_module = $rs->fetch_array();

    $module_id   = $role_module['module_id'];
    if ($module_id == 'ALL') {
        $role_id_page = 1;
    }else{
        $cms  			= array($model_id);
        $exploded   	= explode(',', $module_id);
        $module_id_cms 	= array_intersect($exploded, $cms);
        if (count($module_id_cms) > 0) {
            $role_id_page = 1;
        } else {
            $role_id_page = 0;
        }
    }

	if($_SESSION['admin_auto_id_sess']==''){	
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
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


	if($_SESSION['lname']=='English'){
		$lan='1';
	}
	else if($_SESSION['lname']=='Hindi'){
		$lan='2';
	}
	if($role_id_page==0){
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}

	if(isset($_POST['Submit_g']) && $_GET['editid']!=''){
		if($_SESSION['logtoken']!=$_POST['random']){	
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
			$user_status=trim($_POST['user_status']);
			$txtename= trim($sortcontentdesc);
			if(trim($txtename)==""){
				$errmsg .="Please Enter Message."."<br>";
			}
			if(trim($user_status)==""){
				$errmsg .="Please Select Status."."<br>";
			}
			if($errmsg ==""){
				$sql1 = "update messagelist set Message='$txtename',m_status='$user_status' where MessageID='$editid'";
				$rs1 = $conn->query($sql1);
				
				$result = "select ThreadID from messagelist where MessageID='$editid'";
				$Rs2 = $conn->query($result);
				$queryResult = $Rs2->fetch_array();
				
				$result1 = "select count(*) as activemsg_count from messagelist WHERE ThreadID ='".$queryResult['ThreadID']."' and m_status = 1";
				$rs3 = $conn->query($result1);
				$queryRs = $rs3->fetch_array();
				
				$sql2 = "UPDATE threadlist set Posts='".$queryRs['activemsg_count']."' WHERE ThreadID = ".$queryResult['ThreadID']."";
				$rs4 = $conn->query($sql2);
				
				$_SESSION['SESS_MSG']=UPDATE;
				header("Location: manage_discussion.php");
				exit;
			}
		}			
	}


	if($_GET['deleteid']!=''){
		if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($deleteid)))){
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
		}else{
			$_COOKIE['Temp']="";
			$_SESSION['saltCookie']="";
			$_SESSION['Temptest']="";
			$saltCookie =uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] =$saltCookie;
			$_SESSION['Temptest']=$_SESSION['saltCookie'];
			setcookie("Temp",$_SESSION['saltCookie']);
			$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
		}
	
		$result = "select ThreadID from messagelist where MessageID='$deleteid'";
		$sql = $conn->query($result);
		$queryResult = $sql->fetch_array();
		
		$sql1 = "delete from messagelist where MessageID='$deleteid'";
		$rs = $conn->query($sql1);
		
		$result1 = "select count(*) as activemsg_count from messagelist WHERE ThreadID ='".$queryResult['ThreadID']."' and m_status = 1";
		$rs5 = $conn->query($result1);
		$queryRs = $rs5->fetch_array();
		
		$sql2 = "UPDATE threadlist set Posts='".$queryRs['activemsg_count']."' WHERE ThreadID = ".$queryResult['ThreadID']."";
		$rq = $conn->query($sql2);
			
		$_SESSION['SESS_MSG'] = DELETE;
		header("Location:manage_discussion.php");
		exit;
	}
 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Discussion Forum: DDA</title>
<!-- admin css  -->
<link href="style/admin.css" rel="stylesheet" type="text/css">
<!-- Ckeditor js  -->
<!-- start Calender js and css  -->


<!-- end  Calender js and css  -->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

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

  

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  

  
  <div class="main_con">
  <div class="admin-breadcrum">
<div class="breadcrum">
  <span class="submenuclass"><a href="welcome.php" title="Dashboard">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_discussion.php" title="Manage Discussion Forum">Manage Discussion Forum</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Update Discussion Forum</span>
	</div>
<div class="clear"> </div>
</div>  
       
<div class="right_col1">
          
		  <div class="clear"></div>
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
 <h3 class="manageuser">Update Discussion Forum</h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
		 <form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	if($_GET['editid']!='')
	{
		$rq = "select * from messagelist where MessageID='".$_GET['editid']."'";
		$rs = $conn->query($rq);
		$rr = $rs->fetch_array();
		//print_R($rr);
		}
?>   
<div class="frm_row"> <span class="label1">
              <label for="sortcontentdesc">Short Description: </label>
              <span class="star">*</span></span> <span class="input1">
              <textarea rows="16" cols="65" name="sortcontentdesc" autocomplete="off"  id="sortcontentdesc" onkeyup="Javascript:charactersRemaining(this.form.sortcontentdesc, 1000, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1000, this.form.sortcontentdesc);" onkeypress="Javascript:charactersRemaining(this.form.sortcontentdesc, 1000, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1000, this.form.sortcontentdesc);" onmouseout="Javascript:charactersRemaining(this.form.sortcontentdesc, 1000, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 1000, this.form.sortcontentdesc);" tabindex="1" ><?php echo html_entity_decode($rr['Message']);?>
</textarea> <label style="float:right; margin-right:30px;" class="free" for="textarea_field">
		<script type="text/javascript">
			document.write("&nbsp;&nbsp;&nbsp;<input type='text' name='msg_left' id='msg_left' style='text-align:right;' size='3' value='1000' readonly='readonly' /> left of 1000 characters maximum.");
		</script>
		<noscript>(text limited to 1000 characters)</noscript>
		</label>
              </span>
              <div class="clear"></div>
          
            </div>
	
          <div class="frm_row"> 
			<span class="label1">
			<label for="user_status">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="user_status" id="user_status" autocomplete="off">
	<option value=""> Select </option>
<?php 
$status = array('0'=>'Inactive','1'=>'Active',);
foreach($status as  $key => $value)
{
	?>
<option value="<?php echo $key; ?>"<?php if($key==$rr['m_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
			</span>
			<div class="clear"></div>
			</div>
			<div class="clear"></div>

            <div class="frm_row"> <span class="button_row">
			<input name="Submit_g" type="submit" class="button" id="cmdsubmit" value="Submit" />
            
            
            <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
             <input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_discussion.php';" />	
         </span>
              <div class="clear"></div>
            </div>

</form>
		 


</div>
</div>

</div><!-- right col -->
    <div class="clear"></div>
<!-- Content Area end -->
  </div>  <!-- area div-->
  </div>  <!-- main con-->

  <!-- Footer start -->
  
  <?php 
  
			include("footer.inc.php");
    ?>
  <!-- Footer end -->

</div> <!-- Container div-->
</body>
</html>
<!--left of 1000 characters maximum-->
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
<script type="text/javascript" src="js/jquery-ui.js"></script>
<!--message display error and hide-->
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
	
<style>
.hide {display:none;}
</style>