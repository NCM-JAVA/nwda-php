<?php 
 include("../../includes/config.inc.php");
 include("../../includes/useAVclass.php");
 include("../../includes/functions.inc.php");
 include("../../includes/def_constant.inc.php");
 include_once 'ckeditor/ckeditor.php';
 include_once 'ckfinder/ckfinder.php';
//$aid=$_SESSION['org_deg'];
$aid=$_SESSION['orgdesignation'];
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
/*if(($role_map=='0') && ($user_id=='101'  or $user_id=='104'))
{
}
else
{
if($role_map >0)
   {
   }
   else { 
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;
   }
}*/
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

 $cid= $_POST['cid'];
$sid= $_POST['sid'];
//echo "hii"; die;
$newid=md5($cid.$sid);
if($cmdsubmit=='Update') 
{
	$designationId 	= trim($_POST['designationId']);
	$txtename 		= trim($_POST['txtename']);
	$txtpageurl 	= trim($_POST['txtpageurl']);
	$txtpageurl 	= str_replace('.php','', $txtpageurl);
	$url 			= seo_url($txtpageurl);
	$txtemail 		= trim($_POST['email']);
	$contact_no 	= trim($_POST['contact_no']);
	$txtroom 		= trim($_POST['roomno']);
	$txtcategory 	= trim($_POST['txtcategory']);
	$sortcontentdesc= trim($_POST['sortcontentdesc']);
	$txtcontentdesc	= trim(($_POST['txtcontentdesc']));
	$txtlanguage 	= trim($_POST['txtlanguage']);
	$txtstatus 		= trim($_POST['txtstatus']);
	$retirementdate	= trim($_POST['r_date']);
	$sta			= explode('-',$retirementdate);
	$r_date 		= $sta['2']."-".$sta['1']."-".$sta['0'];
	$user_status	= trim($_POST['user_status']);
	$parentId 		= trim($_POST['parentId']);

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
				if(trim($txtename)=="")
				{
					$errmsg .="Please enter Menu Name."."<br>";
				}
				 
				 
				if (trim($txtpageurl) == "") {
					$errmsg .= "Please enter Page Url." . "<br>";
				} elseif(!preg_match('/^[A-Za-z -_]+$/i', $txtpageurl)){
					$errmsg .= "Page Url should be Alphabats only." . "<br>";
				}
				
				if(trim($txtstatus)=="")
				{
					$errmsg .="Please Select Page Status."."<br>";
				}
		}
		else
		{
				
				if(trim($txtlanguage)=="")
				{
					$errmsg ="Please Select Language."."<br>";
				
	 			}
				if(trim($txtroom)!="")
				{
			 if(preg_match("/^[a-zA-Z0-9'-_() &amp;\"]{1,20}$/", trim($txtroom)) === 0)
			{
			$errmsg.="Room Number should be valid."."<br>";
			}
			}	

				if(trim($designationId)=="")
				{
					$errmsg .="Please Select Designation."."<br>";
				}
				if(trim($txtename)=="")
				{
					$errmsg .="Please Enter The Name."."<br>";
				}
			
				if (trim($txtpageurl) == "") {
					$errmsg .= "Please enter Page Url." . "<br>";
				} elseif(!preg_match('/^[A-Za-z -_]+$/i', $txtpageurl)){
					$errmsg .= "Page Url should be Alphabats only." . "<br>";
				}

				
				if((trim($sortcontentdesc) !="") && (preg_match("/^[a-zA-Z0-9 _.,:\"\']{5,175}+$/", $sortcontentdesc) === 0))
				{
					$errmsg .="Please enter Alphanumeric characters, Special Characters( _.,: ) that should be minimum 5 and maximum 175 in Sort Description."."<br>";
				}
				if(trim($txtstatus)=="")
				{
					$errmsg .="Please Select Status."."<br>";
				}

			if ($_FILES["txtuplode"]["tmp_name"] != "")
			{
				$tempfile=($_FILES["txtuplode"]["tmp_name"]);
				$imageinfo = ($_FILES["txtuplode"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				 $nsection=substr($section,0,8);

				 if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
				 {
					 $errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				 }else if ( $section != strip_tags($section) )
				 {
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				 }else{
					 //echo $section;die();
					$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

					$extarray = explode(".",$_FILES["txtuplode"]["name"]);
					if(count($extarray)>2)
					{
						$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
					}elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
					{
						$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
					}elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
					{}else{
						$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
					}
					if ($_FILES["txtuplode"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["txtuplode"]["size"] >=(1048576*5))
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}
			}



			if(trim($txtemail)!="")
				{
					if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $txtemail)){   
					$errmsg.="Please enter valid email Id."."<br>";
					}
				}
				
				
			if(trim($contact_no)!="")
				{
			 if(preg_match("/^[0-9]{8,12}$/", trim($contact_no)) === 0)
			{
			$errmsg.="Phone Number should be 8 to 12 digits."."<br>";
			}
			}	
		}
		if($errmsg == "")
		{
			
			$tableName_send="organizationchart";
			$whereclause="id='$cid'";
			// $check_status=check_status($user_id,$txtstatus,$module_id);
			
			// if($check_status >0){
				// $txtstatus;
			// }
	
			if ($_FILES["txtuplode"]["name"]!=""){
				
				$sql = "select img_uplode FROM organizationchart WHERE id=$cid";
				$rs = mysql_query($sql);
				$row=mysql_fetch_array($rs);
				$image_path = "../../upload/".$row['img_uplode'];
				unlink($image_path);

				$txtuplode=$_FILES['txtuplode']['name'];
				$uniq = uniqid("");
				$txtuplode=$uniq.$txtuplode;		
				$PATH="../../upload/profile";					
				$PATH=$PATH."/"; 
				$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
				$size=filesize($PATH.$txtuplode);
				$size=ceil($size/1024);
				$found="false";
				$txtuplode=addslashes($txtuplode); 
				//echo $txtuplode; 
				$old =array("img_uplode");
				$new =array("$txtuplode");
				$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	
			else{
				
				$whereclause="id='$cid'";
				$sql = "Select * from organizationchart where $whereclause";
				$rs  = $conn->query($sql);
				$res = $rs->fetch_array();
				$txtuplode=$res['img_uplode'];
			}
error_reporting(E_ALL);
ini_set('display_errors','1');

			// $old =array("language_id","designation","name","email","img_uplode","retiere_date", "phone", "short_desc","create_date", "approve_status","content","url","profile_status","level","room");
			// $new =array("$txtlanguage","$designationId","$txtename","$txtemail","$txtuplode","$r_date","$contact_no","$sortcontentdesc", "$createdate","$txtstatus","$txtcontentdesc","$url","$user_status","$parentId","$txtroom");
			// $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			$createdate = date("Y-m-d");
			$sql1 = "UPDATE `organizationchart` SET `language_id`='$txtlanguage',`designation`='$designationId',`name`='$txtename',`email`='$txtemail',`img_uplode`='$txtuplode',`retiere_date`='$r_date',`phone`='$contact_no',`short_desc`='$sortcontentdesc',`create_date`='$createdate',`approve_status`='$txtstatus',`content`='$txtcontentdesc',`url`='$url',`profile_status`='$user_status',`level`='$parentId',`room`='$txtroom' WHERE `id`=$cid";
			$result = $conn->query($sql1);
				
			$page_id=$cid;
			$action = "Update ";
			$date = date("Y-m-d h:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];

			// $tableName="audit_trail";
			// $tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			// $tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$module_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
			// $value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

			// $sql5 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$module_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
		//	$sql21 = $conn->query($sql5);

			$msg=CONTENTUPDATE;
			$_SESSION['content']=$msg;
			$_SESSION['token'] = "";
			$_SESSION['uniq'] = "";
			header("location:organization-chart.php");

		}
	}

if($aid!='' && $aid!='0')
{
	
	$edit_contrator ="select * from organizationchart where id='$editid' and designation='$aid' ";
}
else{
	$edit_contrator ="select * from organizationchart where id='$editid'";
}

$contrator_result = $conn->query($edit_contrator);
$res_rows=$contrator_result->num_rows;
if($res_rows==0)
{
	$msg = "Illegal Activities Found.";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:error.php");
	exit();
} 

$fetch_result=$contrator_result->fetch_array();
@extract($fetch_result);
$sta=explode('-',$retiere_date);
$details_publish_date=$sta['2']."-".$sta['1']."-".$sta['0'];

$txtcontentdesc=$content; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Organization Chart : <?php echo $sitename;?></title>
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
 window.onload = function(){
                            new JsDatePick({
                                useMode:2,
                                target:"r_date",
                                dateFormat:"%d-%m-%Y"
                            });
</script>
</head>
<body>
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
  <span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="organization-chart.php">Manage Organization Chart</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Edit Organization Profile</span>
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
					<h3 class="manageuser">Edit Organization Chart</h3>

			</div>	
				<div class="grid_view">
				<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return add_org('form1')">
 
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
							 <div class="frm_row"> <span class="label1">
								<label for="pagename">Parent Id :</label>
									<span class="star">*</span></span> <span class="input1">
									
									<?php
										$sqlquery= "SELECT `og`.* FROM `organizationchart` as `o` LEFT JOIN `org_setup` as `og` ON `og`.`deg_id`=`o`.`designation` WHERE `o`.`approve_status`='3' group by `designation`;";
										$rs = $conn->query($sqlquery);
										
									 ?>
									<select name="parentId" id="parentId">
									<option value="">Select</option>
									<?php while($result = $rs->fetch_array())
									{

									 ?>
									<option value="<?php echo $result['deg_id']; ?>"<?php if($result['deg_id']==$level) { echo  "selected='selected'"; }?>>
									<?php echo $result['designation']; ?>
									</option>
									<?php } ?>
									die;
									</select>
									</span>
											<div class="clear"></div>
										</div> 
          </div>
		
 <div class="frm_row"> <span class="label1">
                                                        <label>Designation:</label>
                                                        <span class="star">*</span></span>
														<span id="test">
														<select name="designationId" id="designationId"  autocomplete="off">
                                                            <option value=""> Select </option>
   <?php 
   if($aid!='' && $aid!='0') { 
    $sql = "select * from org_setup where deg_id='$aid'";
	} else {
	 $sql = "select * from org_setup"; 
	}
	$rss = $conn->query($sql);
							
    while ($row = $rss->fetch_array()) {
        ?>
   <option value="<?php echo $row['deg_id']; ?>" <?php if ($designation==$row['deg_id']) echo 'selected="selected"'; ?>><?php echo $row['designation']; ?></option>
    <?php
    } ?>
</select>
                                                    </span>
                                                    <div class="clear"></div>
          </div>
<div class="frm_row"> <span class="label1">
<label>Name:</label>
<span class="star">*</span></span> <span class="input1">
<input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php echo stripslashes($name);?>"/>

</span>
<div class="clear"></div>
</div>


                                                    <div class="frm_row"> <span class="label1">
                                                            <label>Page Url(In English):</label>
                                                            <span class="star">*</span></span> <span class="input1">
                                                                <input name="txtpageurl" autocomplete="off" type="text" class="input_class" id="txtpageurl" size="30"   value="<?php echo stripslashes(str_replace('.php', '', $fetch_result['url'])); ?>"/>

                                                        </span>
                                                        <div class="clear"></div>
                                                    </div>


<div class="frm_row"> <span class="label1">
<label for="txtuplode">Image Upload:</label>
</span> <span class="input1">
	<input type="file" autocomplete="off" name="txtuplode" id="txtuplode" />
	<?php //if($_GET[id]!=''){?>
			   <img src="../../upload/profile/<?php echo $img_uplode;?>" alt="<?php echo $img_uplode;?>" title="" align="center" width="80" height="90" />
				 <?php //} ?>
</span>
<div class="clear"></div>
</div>
<div class="frm_row"> <span class="label1">
<label>Email:</label>
<span class="star"></span></span> <span class="input1">
<input name="email" autocomplete="off" type="text" class="input_class" id="email" size="30"  />

</span>
<div class="clear"></div>
</div>
<div class="frm_row"> <span class="label1">
<label>Contact Number:</label>
<span class="star"></span></span> <span class="input1">
<input name="contact_no" autocomplete="off" type="text" class="input_class" id="contact_no" size="30"   value="<?php echo stripslashes($phone);?>"/>

</span>
<div class="clear"></div>
</div>

<div class="frm_row"> <span class="label1">
<label for="roomno">Room Number:</label>
<span class="star"></span></span> <span class="input1">
<input name="roomno" autocomplete="off" type="text" class="input_class" id="roomno" size="30"   value="<?php echo stripslashes($room);?>"/>

</span>
<div class="clear"></div>
</div>

<div class="frm_row"> <span class="label1">
        <label>Retirement Date::</label>
        <span class="star"></span></span> <span class="input1">
        <input type="text" name="r_date" id="r_date" autocomplete="off" 
        value="<?php echo $details_publish_date;?>"/>&nbsp; [dd-mm-yyyy]
        
        </span>
        <div class="clear"></div>
        </div> 
<div class="frm_row"> <span class="label1">	
<label>Short Description:</label>
 </span> <span class="input1">
<textarea id="sortcontentdesc" name="sortcontentdesc" cols="35" rows="2" placeholder="Enter Message"><?php echo stripslashes(html_entity_decode($short_desc));?></textarea> 	
<span id="chars">Maximum 175 characters</span>
</span>
<div class="clear"></div></div>
<div class="frm_row"> <span class="label1">
        <label>Description :</label>
        </span> <span class="input_fck">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($txtcontentdesc)));
		?>        </span>
        <div class="clear"></div>
        </div>
		<div class="frm_row"> <span class="label1">
              <label for="user_status">Profile Status:</label> <span class="star">*</span>
            </span> <span class="input1">
              <select name="user_status" id="user_status" autocomplete="off">
	<option value=""> Select </option>
<?php 
foreach($status as  $key => $value)
{
	?>
<option value="<?php echo $key; ?>"<?php if($key==$fetch_result['profile_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
                         </span>
              <div class="clear"></div>
            </div>
<?php  $con="select * from menu_publish where m_flag_id ='0'  and menu_positions	='1' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
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
	 <?php if($user_id =='101' || $user_id=='104' || $aid!='' && $aid!='0')
	{
	$sql="select * from content_state where state_status='1' and  state_id!=4";
	$rql=$conn->query($sql);
		while($row=$rql->fetch_array())
		{  
		?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
		<?php }
	}
	else if($user_id !='101' || $user_id!='104' || $aid!='' &&  $aid!='0')
	     {
			$qql="select * from content_state";
			$rss=$conn->query($qql);
		 while($row=$rss->fetch_array())
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
<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" /><input name="cid" type="hidden" value="<?php echo $id;?>" /><input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">&nbsp;<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />&nbsp;
<input type="button" class="button" value="Back" onClick="javascript:location.href = 'organization-chart.php';" />
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

