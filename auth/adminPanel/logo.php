<?php 
ob_start();
include("../../includes/config.inc.php");
include("../../includes/connection.php");
include("../../includes/functions.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
require_once("../../includes/ps_pagination.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$role_id=$_SESSION['dbrole_id']; 
$model_id='Manage Logo';
$user_id=$_SESSION['admin_auto_id_sess'];
//$state_id=state_id($user_id);
//$role_map=role_permission($user_id,$model_id);
if($_SESSION['admin_auto_id_sess']=='')
	{		
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

if(($role_map['draft'] !='DR' || $role_map['medit'] !='ED') && $user_id !='101')
{
$msg = "Login to Access Admin Panel";
$_SESSION['sess_msg'] = $msg ;
header("Location:error.php");
exit;	
}
if(isset($_POST['Submit_g']) && $_GET['id']=='')
		{
		
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

		$txtlanguage= trim(str_replace("'", '', $_POST['txtlanguage']));
		$txtuplode = trim(str_replace("'", '', $_POST['txtuplode']));
		$txtcontentdesc= trim(str_replace("'", '', $_POST['txtcontentdesc']));	
		$a_status1=trim(str_replace("'", '', $_POST['a_status1']));
		$txtename1= trim(str_replace("'", '', $txtename1));
		$lurl= trim(str_replace("'", '', $_POST['lurl']));
		$r_url=seo_url($txtename1);
   //14-02-2025
   $state_id = $_POST['a_status1'];

		if($txtlanguage=='2'){}
		else {
			if (trim($txtlanguage) == "") {
				$errmsg .= "Please Select Language." . "<br>";
			}
					
			if (trim($txtename1) == "") {
				$errmsg .= "Please Enter Title." . "<br>";
			}
			else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\'/']{3,50}$/i", $txtename1) === 0){
				$errmsg .= "Language Name must be from letters that should be minimum 3 and maximum 50."."<br>";
			}
		
			if (trim($a_status1) == "") {
				$errmsg .= "Please select page status." . "<br>";
			}	
		}
		if(trim($lurl)==""){
			$errmsg .="Please enter url ."."<br>";
		}
						
		if(trim($txtcontentdesc)==""){
			$errmsg .="Please enter content description."."<br>";
		}
		
		if($_FILES["txtuplode"]["tmp_name"]==""){
			$errmsg .= "Please upload file."."<br>";
		}
		elseif ($_FILES["txtuplode"]["tmp_name"]!="")
		{
			$tempfile=($_FILES["txtuplode"]["tmp_name"]);
			$imageinfo = ($_FILES["txtuplode"]["type"]);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) ){
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) ){
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
				 //echo $section;die();
				$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

				$extarray = explode(".",$_FILES["txtuplode"]["name"]);
				if(count($extarray)>2)
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && 	$imageinfo['mime'] != 'image/png' && isset($imageinfo)){
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
				{}else{
					$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
				}
				if ($_FILES["txtuplode"]["size"] < 1){
					$errmsg .= "Image Size is too less.<br>";
				}
				if ($_FILES["txtuplode"]["size"] >=(1048576*5)){
					$errmsg .= IMAGE_SIZE_LIMIT."<br>";
				}
			}
		}
		
		if($errmsg==''){ 
			if($_SESSION['logtoken']!=$_POST['random']){
				//session_unset($admin_auto_id_sess);
				//session_unset($login_name);
				//session_unset($dbrole_id);
        session_unset();
        
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
	
	
			if ($_FILES["txtuplode"]["tmp_name"]!="")
			{
				$max_upload_width = 700;
				$max_upload_height = 500;

				if ($_FILES["txtuplode"]["size"] < (1048576*5)){
					if($_FILES["txtuplode"]["type"] == "image/jpeg" || $_FILES["txtuplode"]["type"] == "image/pjpeg"){	
						$image_source = imagecreatefromjpeg($_FILES["txtuplode"]["tmp_name"]);
					}		
					// if uploaded image was GIF
					if($_FILES["txtuplode"]["type"] == "image/gif"){	
						$image_source = imagecreatefromgif($_FILES["txtuplode"]["tmp_name"]);
					}	
					// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
					// if uploaded image was BMP
					if($_FILES["txtuplode"]["type"] == "image/bmp"){	
						$image_source = imagecreatefromwbmp($_FILES["txtuplode"]["tmp_name"]);
					}			
					// if uploaded image was PNG
					if($_FILES["txtuplode"]["type"] == "image/png"){
						$image_source = imagecreatefrompng($_FILES["txtuplode"]["tmp_name"]);
					}

					$filename1=$_FILES['txtuplode']['name'];
					//echo $filename1; 
					$uniq = uniqid("");
					$filename1=$filename1;
					$PATH="../../upload/logo/";

					if(!is_dir($PATH)){  
					mkdir($PATH,0777);
					}
					$PATH=$PATH."/";

					$remote_file = $PATH.$filename1;
					$test=imagejpeg($image_source,$remote_file,100);
					$size=filesize($PATH.$filename1);
					$size=ceil($size/1024);
					$found="false";

					/* list($image_width, $image_height) = getimagesize($remote_file);
					if($image_width>$max_upload_width || $image_height >$max_upload_height)
					{
						$proportions = $image_width/$image_height;
						if($image_width>$image_height){

							$new_width = $max_upload_width;
							$new_height = $max_upload_height;
						}		
						else{
							$new_width = $max_upload_width;
							$new_height = $max_upload_height;
						}		
						$new_image = imagecreatetruecolor($new_width , $new_height);
						$image_source = imagecreatefromjpeg($remote_file);

						imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
						imagejpeg($new_image,$remote_file,100);

						imagedestroy($new_image);
					}
					imagedestroy($image_source); */

				}
				else{
				$msg=IMAGE_SIZE_LIMIT;
				$_SESSION['sess_img']=$msg;
				header("location:photogallery.php");
				exit;
				}	
				$add_img='../../upload/logo/'.$filename1;
				$add_thumb='../../upload/logo/thumb/'.$filename1;
				generate_image_thumbnail($add_img,$add_thumb);
			}			
			$filename1=addslashes($filename1); 
			$date = date("Y-m-d h:i:s");

			/* $tableName_send="bottom_logo";
			$tableFieldsName_old=array("title","l_url","txtcontentdesc","img_uplode","language_id","approve_status","postdate","user_login_id","state_id");
			$tableFieldsValues_send=array("$txtename1","$lurl","$txtcontentdesc","$filename1","$txtlanguage","$a_status1","$date","$user_id","$state_id");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
 */
			
			$sql = "INSERT INTO `bottom_logo` (`title`,`l_url`,`txtcontentdesc`,`img_uplode`,`language_id`,`approve_status`,`postdate`,`user_login_id`,`state_id`)VALUES ('$txtename1','$lurl','$txtcontentdesc','$filename1','$txtlanguage','$a_status1','$date','$user_id','$state_id')";
			$sqli = $conn->query($sql);	

			$page_id=$conn->insert_id;
			$action="Insert";
			$categoryid='1';
			$date=date("Y-m-d h:i:s");
			$ip=$_SERVER['REMOTE_ADDR'];

/* 			$tableName="audit_trail";
			$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			$tableFieldsValues_send=array("$user_id","$page_id","$txtename1","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$a_status1");
			$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send); */

			$sql1 = "INSERT INTO `audit_trail` (`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`)VALUES ('$user_id','$page_id','$txtename1','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$a_status1')";
			$sqli1 = $conn->query($sql1);	

			$msg=CONTENTADD;
			$_SESSION['SESS_MSG']=$msg;
			header("location:logo.php");
			exit;	
		}	
	}			  
			  

	//	Update Record Start
	if(isset($_POST['Submit_g']) && $_GET['id']!=''){
 
		$txtlanguage 	= trim(str_replace("'", '', $_POST['txtlanguage']));
		$a_status1	 	= trim(str_replace("'", '', $_POST['a_status1']));
		$txtename1	 	= trim(str_replace("'", '', $txtename1));
		$txtcontentdesc = trim(str_replace("'", '', $_POST['txtcontentdesc']));

		$lurl= $_POST['lurl'];
		$r_url=seo_url($txtename1);
		
		if (trim($txtlanguage) == "") {
			$errmsg .= "Please Select Language." . "<br>";
		}

		if (trim($a_status1) == ""){
			$errmsg .= "Please select page status." . "<br>";
		}	

		if(trim($txtcontentdesc)==""){
			$errmsg .="Please enter content description."."<br>";
		}
		
		if(trim($lurl)==""){
			$errmsg .="Please enter web link ."."<br>";
		}
				
				
		if ($_FILES["txtuplode"]["tmp_name"]!=""){
			$tempfile=($_FILES["txtuplode"]["tmp_name"]);
			$imageinfo = ($_FILES["txtuplode"]["type"]);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
		 	$nsection=substr($section,0,8);

			if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"])){
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			}else if ( $section != strip_tags($section)){
				$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
			}else{
				$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);
				$extarray = explode(".",$_FILES["txtuplode"]["name"]);
				if(count($extarray)>2){
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo)){
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
				{}else{
					$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
				}
				if ($_FILES["txtuplode"]["size"] < 1){
					$errmsg .= "Image Size is too less.<br>";
				}
				if ($_FILES["txtuplode"]["size"] >=(1048576*5)){
					$errmsg .= IMAGE_SIZE_LIMIT."<br>";
				}
			}
		}
		
		
		
		if($errmsg=='')
		{ 
			$tableName_send="bottom_logo";
			$whereclause="id='".$_GET['id']."'";
			if($_SESSION['logtoken']!=$_POST['random']){
				$msg = "Login to Access Admin Panel";
				$_SESSION['SESS_MSG']= $msg ;
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


			if ($_FILES["txtuplode"]["name"]!=""){

				$max_upload_width = 700;
				$max_upload_height = 500;

				$sql = "select img_uplode FROM bottom_logo WHERE id='$_GET[id]'";
				$rs = $conn->query($sql);
				$row=$rs->fetch_array();

				$path ="../../upload/logo";
				$path2 ="../../upload/logo/thumb";
				unlink($path . "/" .$row['img_uplode']);
				unlink($path2 . "/" .$row['img_uplode']);

				if ($_FILES["txtuplode"]["size"] < (1048576*5)){
					if($_FILES["txtuplode"]["type"] == "image/jpeg" || $_FILES["txtuplode"]["type"] == "image/pjpeg"){	
						$image_source = imagecreatefromjpeg($_FILES["txtuplode"]["tmp_name"]);
					}		
					// if uploaded image was GIF
					if($_FILES["image_upload_box"]["type"] == "image/gif"){	
						$image_source = imagecreatefromgif($_FILES["txtuplode"]["tmp_name"]);
					}	
					// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
					// if uploaded image was BMP
					if($_FILES["image_upload_box"]["type"] == "image/bmp"){	
						$image_source = imagecreatefromwbmp($_FILES["txtuplode"]["tmp_name"]);
					}			
					// if uploaded image was PNG
					if($_FILES["image_upload_box"]["type"] == "image/x-png"){
						$image_source = imagecreatefrompng($_FILES["txtuplode"]["tmp_name"]);
					}
		
					if($_FILES["txtuplode"]["type"] == "image/png"){
						$image_source = imagecreatefrompng($_FILES["txtuplode"]["tmp_name"]);
					}
					$filename1=$_FILES['txtuplode']['name'];
					$uniq = uniqid("");
					$filename1=$filename1;
					$PATH="../../upload/logo";
					
					if(!is_dir($PATH)){  
						mkdir($PATH,0777);
					}
					$PATH=$PATH."/";
					$remote_file = $PATH.$filename1;
					
					$test=imagejpeg($image_source,$remote_file,100);
					$size=filesize($PATH.$filename1);
					$size=ceil($size/1024);
					$found="false";
							
					/* list($image_width, $image_height) = getimagesize($remote_file);
					if($image_width>$max_upload_width || $image_height >$max_upload_height){
						$proportions = $image_width/$image_height;

						if($image_width>$image_height){
							$new_width = $max_upload_width;
							$new_height = $max_upload_height;
						}		
						else{
							$new_width = $max_upload_width;
							$new_height = $max_upload_height;
						}		

						$new_image = imagecreatetruecolor($new_width , $new_height);
						$image_source = imagecreatefromjpeg($remote_file);
						imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
						imagejpeg($new_image,$remote_file,100);
						imagedestroy($new_image);
					}
					imagedestroy($image_source);		 */		
				}
				else{
					echo $msg=IMAGE_SIZE_LIMIT;
					$_SESSION['sess_msg']=$msg;
					header("location:logo.php");
					exit;
				}	
				$add_img='../../upload/logo/'.$filename1;
				$add_thumb='../../upload/logo/thumb/'.$filename1;
				//$add_thumb1='../../upload/photogallery/front_thumb/'.$filename1;
				generate_image_thumbnail($add_img,$add_thumb);
				//generate_image_frontthaumb($add_img,$add_thumb1);

				$filename1=addslashes($filename1);
				$tableName_send="bottom_logo";
				$whereclause="id='$_GET[id]'";
				/* $old =array("img_uplode");
				$new =array("$filename1");
				$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */
				
				$sql = "UPDATE `bottom_logo` SET `img_uplode`='$filename1' WHERE `id`='$_GET[id]'";		
				$rs = $conn->query($sql);
				
			}		
			$date=date("Y-m-d");
		/* 	$old =array("title","l_url","txtcontentdesc","approve_status","language_id","postdate","user_login_id");
			$new =array("$txtename1","$lurl","$txtcontentdesc","$a_status1","$txtlanguage","$date","$user_id");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */
			
			 $sql = "UPDATE `bottom_logo` SET `title`='$txtename1',`l_url`='$lurl',`txtcontentdesc`='$txtcontentdesc',`approve_status`='$a_status1',`language_id`='$txtlanguage',`postdate`='$date',`user_login_id`='$user_id' WHERE `id`='$_GET[id]'";		
			$rs = $conn->query($sql);
      //14-02-2025
			$page_id=$conn->insert_id;
			$action="Update";
			$categoryid='1';
			$date=date("Y-m-d h:i:s");
			$ip=$_SERVER['REMOTE_ADDR'];

			/* $tableName="audit_trail";
			$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			$tableFieldsValues_send=array("$user_id","$page_id","$txtename1","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$a_status1");
			 $value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);*/

			$sql1 = "INSERT INTO `audit_trail` (`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`)VALUES ('$user_id','$page_id','$txtename1','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$a_status1')";
			$sqli1 = $conn->query($sql1);

			$msg=CONTENTUPDATE;
			$_SESSION['SESS_MSG']=$msg;
			//$_SESSION['token'] = "";
			//$_SESSION['uniq'] = "";
			header("location:logo.php");
			exit();
				
		}
	}
	


	if($_GET['did']!=''){
		if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($did)))){
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
			$sql = "select img_uplode FROM bottom_logo WHERE id='$did'";
			$rs = $conn->query($sql);
			$row=$rs->fetch_array();

			$path ="../../upload/logo";
			$path2 ="../../upload/logo/thumb";
			unlink($path . "/" .$row['img_uplode']);
			unlink($path2 . "/" .$row['img_uplode']);
			$rr ="delete from bottom_logo where id='$did'";
			$rss = $conn->query($rr);
			$_SESSION['SESS_MSG'] = " Record Successfully Delete";
			header("Location:logo.php");
			exit;
		}

	}
			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Top Header Logo : <?=$sitename?></title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/demo.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<link href="style/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/drop_down.js"></script>
<script language="JavaScript" src="js/validation.js"></script>
<script type="text/javascript" src="js/jsDatePick.js"></script>
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script src="js/jquery.tinylimiter.js"></script>



<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

<script>
$(document).ready( function() {
	var elem = $("#chars");
	$("#text").limiter(250, elem);
});
</script>

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
              return false;
		  }
		else
		  {
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
       


	<div class="right_col1">
             <?php if($errmsg!=""){?>
          <div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
</div>
</div>
          <?php }?>
		  <?php if($_SESSION['SESS_MSG']!=""){?>
<div  id="msgerror" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/approve.png"> <span>Attention! <br /></span><?php echo $_SESSION['SESS_MSG']; ?></p>
</div>
</div>
          <?php }?>	
      	<div class="clear"></div>
     
        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser"> Top Header Logo</h3>
<div class="right-section">

			<!-- <ul>
			
<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li  class="new-icon">
<a href="institution_trade.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <li class="divider"> </li><?php }?>
             
            </ul>-->
			
			
			
			
			
 
 </div>
 </div>	
        <div class="grid_view">
		<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
	<?php	
		if($_GET['id']!='')
		{
			$rq ="select * from bottom_logo where id='".$_GET['id']."'";
			$rs = $conn->query($rq);
			$rr = $rs->fetch_array();
			//print_r($rr);
		}	
	?>   

		
     <div class="frm_row"> 
				<span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> 
			    <span class="input1">
				<input type="radio" name="txtlanguage" id="txtlanguage" autocomplete="off"  value="1"<?php if($txtlanguage==1){ echo "checked"; } if($rr['language_id']==1){ echo 'checked="checked"';   }?> >English &nbsp;
				 <input type="radio" name="txtlanguage" autocomplete="off" id="txtlanguage"  value="2"<?php if($txtlanguage==2){ echo "checked"; } if($rr['language_id']==2){ echo 'checked="checked"';   }?>/>Hindi
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>	

		
		   <div class="frm_row"> <span class="label1">
              <label for="txtename1">Title</label>
              <span class="star">*</span></span> <span class="input1">
			   <input name="txtename1" type="text" size="50" class="input_class" id="txtename1" value="<?php if($txtename1!=""){ echo $txtename1;}  else   echo html_entity_decode($rr['title']);?>" />
				
				</span>
				<div class="clear"></div>
			  </div>
              
              <div class="frm_row"> <span class="label1">
              <label for="lurl">Url</label>
              <span class="star">*</span></span> <span class="input1">
			   <input name="lurl" type="text" size="50" class="input_class" id="lurl" value="<?php if($lurl!=""){ echo $lurl;}  else   echo html_entity_decode($rr['l_url']);?>" />
				
				</span>
				<div class="clear"></div>
			  </div>
              
               <div class="frm_row"> <span class="label1">
              <label for="txtuplode">Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <input type="file" name="txtuplode" id="txtuplode" />
				<?php if($rr['img_uplode'] !='') {?>
		   <img src="../../upload/logo/thumb/<?php echo $rr['img_uplode'];?>" alt="" title="" align="center" width="80" height="90" />
		   <?php }?> 
				</span>
				<div class="clear"></div>
			  </div>
			
			  
 <div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        <span class="star">*</span></span> <span class="input_fck">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/pii/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/pii/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/daf/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/daf/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($rr['txtcontentdesc'])));
		?>        </span>
        <div class="clear"></div>
        </div>
</div>

	    
	  <div class="frm_row"> 
			<span class="label1">
			<label for="a_status1">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="a_status1" id="a_status1"  autocomplete="off" onchange="divcomment(this.value)">
			<option value=""> Select </option>
			<?php 
			if($user_id =='101')
			{
			$sql="select * from content_state where state_status=1";
			$rs = $conn->query($sql);
			while($row=$rs->fetch_array())
			{ 
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			}
			else if($user_id !='101' )
			{
			$sql="select * from content_state where state_status=1";
			$srr = $conn->query($sql);
			while($row=$srr->fetch_array())
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
    
      <div class="frm_row"> <span class="button_row">
		<input name="Submit_g" type="submit" class="button" id="cmdsubmit" value="Submit" />
            <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
             <input type="button" class="button" value="Back" onClick="javascript:location.href = 'welcome.php';" />
	</span>
</div>
<div class="clear"></div>

  </form>

<form id="manage_menu" name="manage_menu" method="post" action="">
<input type="text" name="logoname" id="logoname">
<select name="txtstatus" id="txtstatus"  autocomplete="off">
			<option value=""> Select </option>
			<?php 
			if($user_id =='101')
			{
			$sql="select * from content_state where state_status=1";
			$rs = $conn->query($sql);
			while($row = $rs->fetch_array())
			{ 
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			}
			else if($user_id !='101' )
			{
			$sql="select * from content_state where state_status=1";
			$rss = $conn->query($sql);
			while($row = $rss->fetch_array())
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
<input type="submit" name="btnsubmit" value="Search" class="button_m"/>
</form>

<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">
	  <tr bgcolor="whitesmoke">
    <th width="38" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">S.No</th>
    <th width="510" colspan="2" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Name</span></th>
	<th width="510" colspan="2" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Page Status</span></th>
    <th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Edit</th>
    <th width="63" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</th>
    </tr>
	<?php 
	
	if($user_id == '101')
	{
	$qy="";
	}
	else
	{
	$qy="and state_id=$state_id";
	}
	
if($txtstatus!='' && $logoname !='')
{
$querywhere .="title LIKE '%$logoname%' and approve_status=$txtstatus";
}
else if($logoname!='')
		{
					$querywhere .="title LIKE '%$logoname%'"; 
		}
else if($txtstatus!='')
{
$querywhere .="approve_status=$txtstatus";
}



$columns = "select * ";
$sql = "from bottom_logo where 1 ";
$order_by == '' ? $order_by = 'title' : true;
$order_by2 == '' ? $order_by2 = 'ASC' : true;
$sql .= "$qy ";
$sql .= "order by $order_by $order_by2 ";
$sql_count = "select count(*) ".$sql; 
//$sql = $columns.$sql;

if($btnsubmit=="Search")
{
$sql = "select * from bottom_logo where $querywhere";
}
else
{
 $sql = $columns.$sql;
}

$result = $conn->query($sql);
$pager = new PS_Pagination($link, $sql,"");
//$rows = $pager->paginate();
$rows = $result->num_rows;

	if($rows==0) { ?>
    <tr><td style="color:#F00;" height="30" align="center" colspan="5"><b>Sorry.. No records available.</b></td></tr>
<?php	}else	{	?>
    
<?php 
while($data = $result->fetch_array()){
	
	@extract($data);


?>
  <tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
    <td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
      <td width="510" colspan="2" align="left" class="left-tdtext"><?php echo html_entity_decode($data['title']);?></td>
	  <td width="510" colspan="2" align="left" class="left-tdtext"><?php status($approve_status); ?></td>
    <td width="47" align="center" class="left-tdtext"><a href="logo.php?id=<?php echo $data['id'];?>" class="bluelink"><input type="image" border="0" alt="Edit" src="images/edit.png"  title="Edit" /></a></td>
    <td width="63" align="center" class="left-tdtext"><a href="logo.php?did=<?php echo $data['id'];?>&random=<?php echo $_SESSION['logtoken'];?>" class="bluelink" onClick="return confirm('Are you sure you want to delete record')"><input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a></td>
  </tr>
<?php	}?>
	<tr>
<td colspan="5" align="center"><?php echo $pager->renderFullNav();?></td>
</tr>
  <?php }	?> 
	</table>
          			 <div class="clear"></div>
          </div>
          </div>
</div>

<!-- right col -->


    <div class="clear"></div>





<!-- Content Area end -->





 
  </div>  <!-- main con-->

  <!-- Footer start -->
  
  <?php 
  $_SESSION['SESS_MSG']='';
			include("footer.inc.php");
    ?>
  <!-- Footer end -->

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

