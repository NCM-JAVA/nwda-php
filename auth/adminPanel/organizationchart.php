<?php ob_start();
include("../../includes/config.inc.php");
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
$model_id= "9";
$role_map=role_permission($user_id,$role_id,$model_id);
$role_id_page=role_permission_page($user_id,$role_id,$model_id);
if($_SESSION['admin_auto_id_sess']=='')
	{	
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
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

if($_SESSION['lname']=='English')
{
$lan='1';
}
else if($_SESSION['lname']=='Hindi')
{
$lan='2';
}

if($role_id_page==0)
{
$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
}
if(isset($cmdsubmit) && $_GET['editid']=='')
{
$txtcategory = check_input($_POST['txtcategory']);
$ename= check_input($_POST['ename']);
$hname= check_input($_POST['hname']);
/*$email= check_input($_POST['email']);
$contact_no= check_input($_POST['contact_no']);*/
$eshort_desc=content_desc(check_input($_POST['eshort_desc']));
$hshort_desc=content_desc(check_input($_POST['hshort_desc']));
//$fax= check_input($_POST['fax']);
$eaddress=content_desc(check_input($_POST['eaddress']));
$haddress=content_desc(check_input($_POST['haddress']));

$txtstatus=check_input($_POST['txtstatus']);
$createdate=date('Y-m-d');
$errmsg="";  

		if(trim($txtcategory)=="")
		{
			$errmsg .="Please Select Designation Name."."<br>";
		}
		if(trim($ename)=="")
		{
		$errmsg .="Please enter (English) Name."."<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\']{3,100}$/i", $ename) === 0)
		{
		$errmsg .= "Banner Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 3 and maximum 100."."<br>";
		}
		/*if(trim($hename)=="")
		{
		$errmsg .="Please enter (Hindi) Name."."<br>";
		}*/
	/*	if(trim($email)=="")
		{
			$errmsg .="Please enter valid email Id."."<br>";
		
		}
		if(trim($email)!="")
		{
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){   
			$errmsg.="Please enter valid email Id."."<br>";
			}
		}
		/*if(trim($contact_no)!="")
		{
			if(preg_match("/^[0-9]{7,12}$/", trim($contact_no)) === 0)
			{
			$errmsg.="Contact Number should be 7 to 12 digits."."<br>";
			}
		}*/
		/*if(trim($fax)!="")
		{
			if(preg_match("/^[0-9]{8,12}$/", trim($fax)) === 0)
			{
			$errmsg.="Contact Number should be 8 to 12 digits."."<br>";
			}
		}
*/
	/*	if (trim($esortcontentdesc) == "") {
		$errmsg .="Please Enter The English Short Description." . "<br>";
		}
		*/
		if(trim($txtstatus)=="")
		{
		$errmsg .="Please Select Page Status."."<br>";
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
		
			$check_status=check_status($user_id,$role_id,$txtstatus,$model_id);
			if($check_status >0)
			{
			$txtstatus;
			}
			else
			{
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
			}
$tableName_send="organization_chart";
$tableFieldsName_old=array("designation","ename","hname","email","phone","eshort_desc","create_date","approve_status","hshort_desc","fax","eaddress","haddress");
$tableFieldsValues_send=array("$txtcategory","$ename","$hname","$email","$contact_no","$eshort_desc","$createdate","$txtstatus","$hshort_desc","$fax","$eaddress","$haddress");
$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
$page_id=mysql_insert_id();
	$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id=mysql_insert_id();
		$action="Insert";
		$categoryid='1'; 
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
$msg=INSERT;
$_SESSION['content']=$msg;
header("location:organization_setup.php");
exit;	
}	
}
if(isset($cmdsubmit) && $_GET['editid']!='')
{
$cid=$_GET['editid'];
$txtcategory = check_input($_POST['txtcategory']);
$ename= check_input($_POST['ename']);
$hname= check_input($_POST['hname']);
/*$email= check_input($_POST['email']);
$contact_no= check_input($_POST['contact_no']);*/
$eshort_desc=content_desc(check_input($_POST['eshort_desc']));
$hshort_desc=content_desc(check_input($_POST['hshort_desc']));
//$fax= check_input($_POST['fax']);
$eaddress=content_desc(check_input($_POST['eaddress']));
$haddress=content_desc(check_input($_POST['haddress']));
$txtstatus=check_input($_POST['txtstatus']);
$updatedate=date('Y-m-d');
$errmsg="";        // Initializing the message to hold the error messages

	if(trim($txtcategory)=="")
		{
			$errmsg .="Please Select Designation Name."."<br>";
		}
		if(trim($ename)=="")
		{
		$errmsg .="Please enter (English) Name."."<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\']{3,100}$/i", $ename) === 0)
		{
		$errmsg .= "Banner Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 3 and maximum 100."."<br>";
		}
		/*if(trim($hename)=="")
		{
		$errmsg .="Please enter (Hindi) Name."."<br>";
		}*/
		/*if(trim($email)=="")
		{
			$errmsg .="Please enter valid email Id."."<br>";
		
		}
		if(trim($email)!="")
		{
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){   
			$errmsg.="Please enter valid email Id."."<br>";
			}
		}
		if(trim($contact_no)!="")
		/*{
			if(preg_match("/^[0-9]{8,12}$/", trim($contact_no)) === 0)
			{
			$errmsg.="Contact Number should be 8 to 12 digits."."<br>";
			}
		}
		
		if (trim($esortcontentdesc) == "") {
		$errmsg .="Please Enter The English Short Description." . "<br>";
		}*/
		
		if(trim($txtstatus)=="")
		{
		$errmsg .="Please Select Page Status."."<br>";
		}
if($errmsg == '')
	{
		if($_SESSION['logtoken']!=$_POST['random'])
		{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
		}
			$check_status=check_status($user_id,$role_id,$txtstatus,$model_id);
			if($check_status >0)
			{
		 $txtstatus; 
			}
			else
			{
		
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
			}
 
			$tableName_send="organization_chart";
			$whereclause="id='$cid'";
			$old=array("designation","ename","hname","email","phone","eshort_desc","update_date","approve_status","hshort_desc","fax","eaddress","haddress");
			$new=array("$txtcategory","$ename","$hname","$email","$contact_no","$eshort_desc","$updatedate","$txtstatus","$hshort_desc","$fax","$eaddress","$haddress");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
$user_login_id=$_SESSION['admin_auto_id_sess'];
$page_id=$cid;
$action="Update";
$categoryid='3';
$date=date("Y-m-d h:i:s");
$ip=$_SERVER['REMOTE_ADDR'];
$tableName="audit_trail";
$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title");
$tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title");
$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
$msg=UPDATE;
$_SESSION['content']=$msg;
$_SESSION['token'] = "";
$_SESSION['uniq'] ="";
header("location:organization_setup.php");
exit;
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Organization Setup add/update: National Water Development Agency Administration</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">

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
			<span class="submenuclass"><a href="organization_setup.php" title="Manage Organization Setup">Manage Organization Setup</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add/Update Organization Setup</span>
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
 <h3 class="manageuser">Add/Update Organization Setup</h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	if($_GET['editid']!='')
	{
		$rq = mysql_query("select * from organization_chart where id='".$_GET['editid']."'");
		//echo "select * from category where c_id='".$_GET['id']."'";
		$rr = mysql_fetch_array($rq);
				//print_r($rr);
		}
		
	
?>   
<div class="frm_row"> <span class="label1">
<label for="txtcategory">Designation Name :</label>
<span class="star">*</span></span> <span class="input1">
					<?php 
						$CatgorySql=mysql_query("Select * from org_designation where c_status='1' order by c_id asc");
						//echo "Select * from category where c_type!='5' order by c_id asc";
						$CategoryNum = mysql_num_rows($CatgorySql);
					?>
					<select name="txtcategory" id="txtcategory" autocomplete="off"  >
					<option  value="">Select</option>
					<?php 
							while($CategoryNum =mysql_fetch_array($CatgorySql))
							{
						?>
					<option value="<?php echo $CategoryNum['c_id'];?>"<?php if($CategoryNum['c_id']==$rr['designation']) echo 'selected="selected"';?>><?php echo $CategoryNum['c_name']; ?></option>
					<?php } 
					 ?>
					 </option>
					</select></span>
<div class="clear"></div>
</div>
	<div class="frm_row"> <span class="label1">
	<label for="ename"> Name (English) :</label>
	<span class="star">*</span></span> <span class="input1">
	<input name="ename" autocomplete="off" type="text" class="input_class" id="ename" size="30"   value="<?php echo stripslashes($rr['ename']);?>"/>
	</span>
	<div class="clear"></div>
	</div>
	<div class="frm_row"> <span class="label1">
	<label for="hname"> Name (Hindi) :</label>
	</span> <span class="input1">
	<input type="text" name="hname" autocomplete="off" id="hname" class="input_class"  value="<?php if(htmlspecialchars($rr['hname']!="")){ echo htmlspecialchars($rr['hname']);} ?>" />
	</span>
	<div class="clear"></div>
	</div>
			
<!--		<div class="frm_row"> <span class="label1">
	<label for="email"> Email :</label>
	<span class="star"></span></span> <span class="input1">
	<input name="email" autocomplete="off" type="text" class="input_class" id="email" size="30"   value="<?php echo stripslashes($rr['email']);?>"/>
	</span>
	<div class="clear"></div>
	</div>	
            <div class="frm_row"> <span class="label1">
<label for="contact_no">Contact Number:</label>
<span class="star"></span></span> <span class="input1">
<input name="contact_no" autocomplete="off" type="text" class="input_class" id="contact_no" size="30" maxlength="12"  onKeyPress="return isNumberKey(event)"  value="<?php echo stripslashes($rr['phone']);?>"/>

</span>
<div class="clear"></div>
</div>
<div class="frm_row"> <span class="label1">
<label for="fax">Fax Number:</label>
<span class="star"></span></span> <span class="input1">
<input name="fax" autocomplete="off" type="text" class="input_class" id="fax" size="30" maxlength="12"  onKeyPress="return isNumberKey(event)"  value="<?php echo stripslashes($rr['fax']);?>"/>

</span>
<div class="clear"></div>
</div>-->

<div class="frm_row"> <span class="label1">
        <label for="eaddress">Address (English) :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('eaddress',stripslashes(html_entity_decode($rr['eaddress'])));
		?>        </span>
        <div class="clear"></div>
        </div>

<div class="frm_row"> <span class="label1">
        <label for="eaddress">Address (Hindi) :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('haddress',stripslashes(html_entity_decode($rr['haddress'])));
		?>        </span>
        <div class="clear"></div>
        </div>

<div class="frm_row"> <span class="label1">
        <label for="esortcontentdesc">Allocation(English) :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('eshort_desc',stripslashes(html_entity_decode($rr['eshort_desc'])));
		?>        </span>
        <div class="clear"></div>
        </div>
		<div class="frm_row"> <span class="label1">
        <label for="eaddress"> Allocation(Hindi) :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('hshort_desc',stripslashes(html_entity_decode($rr['hshort_desc'])));
		?>        </span>
        <div class="clear"></div>
        </div>


				
          <div class="frm_row"> 
			<span class="label1">
			<label for="txtstatus">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
			<option value=""> Select </option>
			<?php 
			if($user_id =='101')
			{
			$sql=mysql_query("select * from content_state where state_status=1");
			
			while($row=mysql_fetch_array($sql))
			{ 
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			}
			else if($user_id !='101' )
			{
			$sql=mysql_query("select * from content_state");
			
			while($row=mysql_fetch_array($sql))
			{  
			if($row['state_short']==$role_map['draft']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			if($row['state_short']==$role_map['mapprove']){
			?>
                <option value="<?php echo $row['state_id'];?>"><?php echo $row['state_name']; ?></option>
                <?php }
			if($row['state_short']==$role_map['publish']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
		
			
			}
			} ?>
			</select>
			</span>
			<div class="clear"></div>
			</div>
			<div class="clear"></div>

            <div class="frm_row"> <span class="button_row">
            <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="<?php if($_GET['editid']!='') { echo 'Update';} else { echo'Submit';}?>" />&nbsp;
			<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
			<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='organization_setup.php';" />
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


</div> <!-- Container div-->
<!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
</body>
</html>
<script type="text/javascript">
<!--
	// This is just one validation technique, with frm parameter being the submitted form
	// function to validate the submitted form's textarea field
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
	// function to validate the submitted form's textarea field
	function echaractersRemaining(input, max, out) {
		if (input.value.length <= max) {
			out.value = (max - input.value.length);
		}
		else {
			out.value = 0;
		}
		//alert("charactersRemaining("+input.value+","+max+","+out.value+")");
	}

	function echaracterLimit(input, max) {
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
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
	
<style>
.hide {display:none;}
</style>
