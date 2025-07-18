<?php ob_start();
 include("../../includes/config.inc.php");
 require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
 include_once 'ckfinder/ckfinder.php';
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
 $role_id=$_SESSION['dbrole_id']; 
$user_id=$_SESSION['admin_auto_id_sess'];
$module_id='Manage Organization Chart';
$root_adminid=$_SESSION['root_adminid'];
//$role_map = role_permission($user_id,$module_id);
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
	if($role_map['medit'] !='ED' && $user_id !='101')
   {
		/*session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id); */
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
   }
if($_SESSION['saltCookie']!=$_COOKIE['Temp'])
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
if(!is_numeric(trim($editid)))
	{
		/*session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);*/
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
	}
$cid= trim($_POST['cid']);
$sid= trim($_POST['sid']);
$newid=md5($cid.$sid);
if($cmdsubmit=='Update') 
{
	$designation = trim($_POST['designation']);
	$txtcategory = trim($_POST['txtcategory']);
	$txtlanguage = trim($_POST['txtlanguage']);
	$txtstatus   = trim($_POST['txtstatus']);
	$createdate  = date('Y-m-d');
	if($txtstatus =="")
	{
	 $txtstatus='1';
	}
	$cid= trim($_POST['cid']);
	$update=date('Y-m-d h:i:s');
	$flag_id=0;
	$flag="OK";   // This is the flag and we set it to OK
	$errmsg="";        // Initializing the message to hold the error messages
if(trim($txtlanguage)=="")
{
$errmsg ="Please Select Language."."<br>";
}

if($txtlanguage=='2')
{
		
		
	 if (trim($txtlanguage) == "") {
            $errmsg = "Please Select Language." . "<br>";
        }
        
		 
		if(trim($designation)=="")
		{
		$errmsg .="Please enter designation."."<br>";
		}
		

     
        if (trim($txtstatus) == "") {
            $errmsg .="Please Select Page Status." . "<br>";
        }
 }
 else
  {
			if (trim($txtlanguage) == "") {
			$errmsg = "Please Select Language." . "<br>";
			}
			
			
			if(trim($designation)=="")
			{
			$errmsg .="Please enter designation."."<br>";
			}
			else if(preg_match("/^[a-zA-Z0-9'-_() &amp;\"]{2,100}+$/", $designation) == 0)
			{
			$errmsg .= "designation must be from letters that should be minimum 3 and maximum 100."."<br>";
			}
			
			
			if (trim($txtstatus) == "") {
			$errmsg .="Please Select Page Status." . "<br>";
			}
}
if($errmsg == "")
{
	$tableName_send="org_setup";
	$whereclause="deg_id='$cid'";
	
			// $check_status=check_status($user_id,$txtstatus,$module_id);
			// if($check_status >0)
			// {
			// $txtstatus;
			// }
			

/* $old =array("language_id","designation","category_id","create_date", "approve_status");
$new =array("$txtlanguage","$designation","$txtcategory","$update","$txtstatus");
$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
 */
$sql1 = "UPDATE `org_setup` SET `language_id`='$txtlanguage',`designation`='$designation',`category_id`='$txtcategory',`create_date`='$update',`approve_status`='$txtstatus' WHERE `deg_id`=$cid";
$result = $conn->query($sql1);

$page_id=$cid;



/* $tableName="audit_trail";
$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
 */
$sql5 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
			$sql21 = $conn->query($sql5);


$msg=CONTENTUPDATE;
$_SESSION['content']=$msg;
$_SESSION['token'] = "";
$_SESSION['uniq'] = "";
header("location:designation.php");

}
}

$edit_contrator ="select * from org_setup where deg_id='$editid'";
$contrator_result = $conn->query($edit_contrator);
$res_rows = $contrator_result->num_rows;
$fetch_result= $contrator_result->fetch_array();
@extract($fetch_result);
// $txtcontentdesc = $content; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Designation : DDA</title>
  <script type="text/javascript" src="js/jsDatePick.js"></script>
        <link href="style/admin.css" rel="stylesheet" type="text/css">
        <link href="style/dropdown.css" rel="stylesheet" type="text/css">
         <link href="style/jquery.css" rel="stylesheet" type="text/css">
          <link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
           <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
           <script language="JavaScript" src="js/validation.js"></script>
			<script type="text/javascript" src="js/jquery-latest.js"></script>
			<script src="js/jquery.tinylimiter.js"></script>
			<script>
$(document).ready( function() {
	var elem = $("#chars");
	$("#sortcontentdesc").limiter(175, elem);
});
</script>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
<script type="text/javascript">
  window.onload = function(){
                            new JsDatePick({
                                useMode:2,
                                target:"startdate",
                                dateFormat:"%d-%m-%Y"
                            });
                            new JsDatePick({
                                useMode:2,
                                target:"expairydate",
                                dateFormat:"%d-%m-%Y"
                            });
                        };

function getPage(id) {

    //generate the parameter for the php script
    var data = 'language=' + id;
    $.ajax({
        url: "primarylink.php",  
        type: "POST", 
        data: data,     
        cache: false,
        success: function (html) {  
         
            //hide the progress bar
            $('#loading').hide();   
             
            //add the content retrieved from ajax and put it in the #content div
            $('#content1').html(html);
             
            //display the body with fadeIn transition
            $('#content1').fadeIn('slow');       
        }       
    });
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
<?php include('top_header.php'); ?>
<div id="container">

 <!-- Header start -->
  

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->

  <div class="main_con">
              

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
 <h3 class="manageuser">Edit Designation </h3>

 </div>	
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return edit_designation('form1')">
 
<div class="frm_row"> <span class="label1">
                                                        <label>Page Language :</label>
                                                        <span class="star">*</span></span>
														 <span class="input1">
							 <select name="txtlanguage" id="txtlanguage" autocomplete="off"  >
							<option value="">Select</option>
							<?php 
							foreach($language as $key=>$value)
							{
								?>
							<option value="<?php echo $key; ?>" <?php if($key==$language_id){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
							<?php }
							 ?>
							</select>
													   </span>
                                                    <div class="clear"></div>
                                                    <div class="loading"></div>
            </div>
			
		
<div class="frm_row"> <span class="label1">
<label>Designation:</label>
<span class="star">*</span></span> <span class="input1">
<input name="designation" autocomplete="off" type="text" class="input_class" id="designation" size="30"   value="<?php echo stripslashes($designation);?>"/>

</span>
<div class="clear"></div>
</div>


<?php $con="select * from menu_publish where m_flag_id ='0'  and menu_positions	='1' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
$sql=$conn->query($con);
$counter=$sql->num_rows;

$footercon="select * from menu_publish where m_flag_id ='0'  and menu_positions	='3' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
$footersql=$conn->query($footercon);
$footercounter=$footersql->num_rows;
$footercounter;
?>
           <div class="frm_row"> <span class="label1">
              <label>Page Status:</label>
              <span class="star">*</span></span> <span class="input1">
              <select name="txtstatus" id="txtstatus" autocomplete="off" onchange="divcomment(this.value)">
	<option value=""> Select </option>
	 <?php if($user_id =='101')
	{
	$sql="select * from content_state where state_status='1' and  state_id!=4";
$rs = $conn->query($sql);
		while($row = $rs->fetch_array())
		{  
		?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
		<?php }
	}
	else if($user_id !='101' )
	     {
		 $sql1="select * from content_state";
		$rss = $conn->query($sql);
		 while($row=$sql1->fetch_array())
		{  
			if($row['state_short']==$role_map['draft']){
			?>
			<option value="<?php echo $row['state_id'];?>"<?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			if($row['state_short']==$role_map['mapprove']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			if($row['state_short']==$role_map['publish']){
			?>
			<option value="<?php echo $row['state_id'];?>"<?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			
		
		}
		 }
 ?>
	</select>
                                       </span>
              <div class="clear"></div>
            </div>


<div class="clear"></div>
<div class="frm_row"> 
<span class="button_row">   
<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" /><input name="cid" type="hidden" value="<?php echo $deg_id;?>" /><input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">&nbsp;<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />&nbsp;
<input type="button" class="button" value="Back" onClick="javascript:location.href = 'designation.php';" />
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
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
	
<style>
.hide {display:none;}
</style>

