<?php ob_start();


include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
require_once("../../includes/ps_pagination.php");

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "1";
/* $role_map=role_permission($user_id,$role_id,$model_id);
$role_id_page=role_permission_page($user_id,$role_id,$model_id); */
 	$sql         = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
       $rs          = $conn->query($sql);
       $role_module = $rs->fetch_array();
   
       $module_id   = $role_module['module_id'];
       if ($module_id == 'ALL') {
           $role_id_page = 1;
       } else {
           $cms           = array(
               $model_id
           );
           $exploded      = explode(',', $module_id);
           $module_id_cms = array_intersect($exploded, $cms);
           if (count($module_id_cms) > 0) {
               $role_id_page = 1;
           } else {
               $role_id_page = 0;
           }
       }
	
if($_SESSION['admin_auto_id_sess']=='')
	{	

	session_unset();
	// session_unset($login_name);
	// session_unset($dbrole_id);
	
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
	exit;	
	}
	   
if($role_id_page==0)
{
$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
}
if($role_id <0 && $role_map['medit']=='')
{
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
$cid= content_desc($_POST['cid']);
$sid= content_desc($_POST['sid']);
$newid=md5($cid.$sid);
if($cmdsubmit=='Update') 
{
	$txtlanguage		= content_desc($_POST['txtlanguage']);
	$txtename 			= trim(str_replace("'", "\'", $_POST['txtename']));
	$txtsl 				= content_desc($_POST['txtsl']);
	$page_url 			= trim(str_replace("'", "\'", $_POST['page_url']));
	$create_version 	= content_desc($_POST['create_version']);
	$menucategory		= content_desc($_POST['menucategory']);
	$txtekeyword		= trim(str_replace("'", "\'", $_POST['txtekeyword']));
	$txtmeta_description= trim(str_replace("'", "\'", $_POST['txtmeta_description']));
	if($txtlanguage!='2'){
		$txtcontentdesc		= htmlentities(stripslashes(utf8_encode($_POST['txtcontentdesc'])), ENT_QUOTES); 	
	}else{
		$txtcontentdesc		= $_POST['txtcontentdesc'];
	}
	$link				= content_desc($_POST['txtweblink']);
	$txtpostion			= content_desc($_POST['txtpostion']);

	$txtstatus			= content_desc($_POST['txtstatus']); 
	$createdate			= date('Y-m-d');
	$cid				= content_desc($_POST['cid']);
	$update_date		= date('Y-m-d h:i:s');
	$flag_id=0;
 
if(trim($txtlanguage)=="")
		{
		}
		     // Initializing the message to hold the error messages
if($txtlanguage=='2')
		{
		
			if(trim($texttype)=="")
			{
			$errmsg.="Please Select Menu Content Type."."<br>";
			
			}
			//if(trim($create_version)=="")
			//{
			//$errmsg.="Please Select Create New Versions."."<br>";
			
			//}
		if(trim($txtlanguage)!="")
		{
			if(trim($menucategory)=="")
			{
			$errmsg.="Please Select Primary Link."."<br>";
			
			}		
		}
		
		if(trim($texttype)!="")
		{
		if($texttype=='1')
		{	
			if(trim($page_url)=="")
			{
			$errmsg.= "Meta Title must be Alphanumeric "."<br>";
			}
			if(trim($txtcontentdesc)=="")
			{
			$errmsg.="Please enter Content Description."."<br>";
			}
		}
		if($texttype=='3')
		{	if(trim($txtweblink)=="")
			{
			$errmsg.="Please enter web link ."."<br>";
			
			}
			if(trim($link) !="")
			{
				if (!validateURL($link))
				{
				$errmsg.="URL address not valid.<br>";
				}
			}
		}
		
		}
		if(trim($txtpostion)=="")
		{
		$errmsg.="Please Select Position."."<br>";
		
		}
		if(trim($txtstatus)=="")
		{
		$errmsg.="Please Select Page Status."."<br>";
		}
		}
	else
		{
		if(trim($txtename)=="")
		{
		$errmsg = "Menu Title must be Alphanumeric and Special ."."<br>";
		}
		if(trim($txtename)!="")
		{		
		/* if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename))
			{
				$errmsg .= "Menu Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 2 and maximum 100."."<br>";
			}
			*/
		}
	//if(trim($create_version)=="")
			//{
			//$errmsg.="Please Select Create New Versions."."<br>";
			
			//}
	if(trim($menucategory)=="")
		{
		$errmsg .="Please Select Primary Link.<br>";
		
		}
		if(trim($texttype)!="")
		{
		if($texttype=='1')
		{
		if(trim($page_url)=="")
		{
		$errmsg .= "Page  Url must be Alphanumeric "."<br>";
		}
			if(trim($page_url)!="")
					{			
						/*if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$page_url))
						{
						$errmsg .= "Meta Title must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}*/

					}
				if(trim($txtekeyword)!="")
					{			
						/*if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtekeyword))
						{
						$errmsg .= "Meta Keyword must be Alphanumeric  that should be minimum 2 and maximum 100."."<br>";
						}*/
					}
					if(trim($txtmeta_description)!="")
					{			
						/*if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtmeta_description))
						{
						$errmsg .= "Meta Description Title must be Alphabet that should be minimum 2 and maximum 100."."<br>";
						}*/
					}
		if(trim($txtcontentdesc)=="")
		{
		$errmsg.="Please enter Content Description.<br>";
		}
		
		}
		if($texttype=='3')
			{
			if(trim($txtweblink)=="")
			{
			$errmsg.="Please enter web link .<br>";
			}
				if(trim($txtweblink) !="")
				{
					if (!validateURL($txtweblink))
					 {
					$errmsg .="URL address not valid.<br>";
						}
				}
		}
		
		}
	
		if ($_FILES["txtuplode"]["tmp_name"]!="")
		{
			$tempfile=($_FILES["txtuplode"]["tmp_name"]);
			$imageinfo = ($_FILES["txtuplode"]["type"]);
			$head = fgets(fopen($tempfile, "r"),5);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection=substr($section,0,8);
	
			
			if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
			{
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			}else if ( $section != strip_tags($section) )
			{
				$errmsg .= 'Sorry, we accept PDF files only';
			}else{
				
			   $extarray = explode(".",$_FILES["txtuplode"]["name"]);
			   if(count($extarray)>2)
			   {
					$errmsg .= 'Sorry, we accept PDF files only';
			   }elseif($imageinfo != 'application/pdf')
			   {
					$errmsg .= 'Sorry, we accept PDF files only';
			   }else if($head != "%PDF") 
			   {
					$errmsg .= 'Sorry,we accept PDF files only';
			   }elseif($nsection=="JVBERI0X")
			   {}else{
					$errmsg .= 'Sorry, we accept PDF files only';
			   }
			   /*if ($_FILES["txtuplode"]["size"] < 1)
			   {
				   $errmsg .= "Image Size is too less.<br>";
			   }*/
			   if ($_FILES["txtuplode"]["size"] >=(1048576*5))
			   {
				   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
			   }
			   
		   }
	

		}
		

if ($_FILES["uploadImage"]["tmp_name"] != "")
{
$tempfile=($_FILES["uploadImage"]["tmp_name"]);
$imageinfo = ($_FILES["uploadImage"]["type"]);
$section = strtoupper(base64_encode(file_get_contents($tempfile)));
$nsection=substr($section,0,8);

if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["uploadImage"]["name"]) )
{
 $errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
}else if ( $section != strip_tags($section) )
{
$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
}else{
 //echo $section;die();
$imageinfo = getimagesize($_FILES["uploadImage"]["tmp_name"]);

$extarray = explode(".",$_FILES["uploadImage"]["name"]);
if(count($extarray)>2)
{
	$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
}elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
{
	$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
}
/*elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
{}else{
	$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
}*/
/*if ($_FILES["txtuplode"]["size"] < 1)
{
	$errmsg .= "Image Size is too less.<br>";
}*/
if ($_FILES["txtuplode"]["size"] >=(1048576*5))
{
	$errmsg .= IMAGE_SIZE_LIMIT."<br>";
}

}
}

		
		if(trim($txtpostion)=="")
		{
		$errmsg.="Please select Postion.<br>";
		
		}
		if(trim($txtstatus)=="")
		{
		$errmsg.="Please Select Page Status.<br>";
		}
		}
if($errmsg=="")
{
	$tableName_send="menu";
	$whereclause="m_id='$cid'";
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
		$check_status;
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

if ($_FILES["txtuplode"]["name"]!="")
			{
				
			$sql = "select doc_uplode FROM menu WHERE m_id=$cid";
			$rs = mysqli_query($conn, $sql);
			$row=mysqli_fetch_array($rs);
			$image_path = "../../upload/".$row['doc_uplode'];
			unlink($image_path);
   			$txtuplode=$_FILES['txtuplode']['name'];
			$uniq = uniqid("");
			$txtuplode=$uniq.$txtuplode;		
			$PATH="../../upload/";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
			$size=filesize($PATH.$txtuplode);
			$size=ceil($size/1024);
			$found="false";
			$txtuplode=addslashes($txtuplode); 
			//echo $txtuplode; 
			$old =array("doc_uplode");
			$new =array("$txtuplode");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	else
				{
				$whereclause="m_id='$cid'";
				$sql=mysqli_query($conn, "Select * from menu where $whereclause");
				$res=mysqli_fetch_array($sql);
				$txtuplode=$res['doc_uplode'];
				}
				
				
				
		if ($_FILES["uploadImage"]["name"]!="")
			{
				
			$sql = "select upload_img FROM menu WHERE m_id=$cid";
			$rs = mysqli_query($conn, $sql);
			$row=mysqli_fetch_array($rs);
			$image_path = "../../upload/bottom_image/".$row['upload_img'];
			unlink($image_path);
   			$txtuplode1=$_FILES['uploadImage']['name'];
			$uniq = uniqid("");
			$txtuplode1=$uniq.$txtuplode1;		
			$PATH="../../upload/breadcrum_image/";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["uploadImage"]["tmp_name"],$PATH.$txtuplode1);
			$size=filesize($PATH.$txtuplode1);
			$size=ceil($size/1024);
			$found="false";
			$txtuplode1=addslashes($txtuplode1); 
			//echo $txtuplode; 
			$old =array("upload_img");
			$new =array("$txtuplode1");

			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	else
				{
				$whereclause="m_id='$cid'";
				$sql=mysqli_query($conn, "Select * from menu where $whereclause");
				$res=mysqli_fetch_array($sql);
				$txtuplode1=$res['upload_img'];
				}			
				
	if($txtlanguage=='2')
		{		
		$url=seo_url($page_url.'-hi'); }
		else { $url=seo_url($page_url);	}
/* 		
	$old =array("m_flag_id","m_type","menu_positions","language_id","m_name","m_url","m_title","m_keyword","m_description","content","doc_uplode","linkstatus","start_date","end_date","update_date","approve_status","admin_id","current_version","media_page","link_category","page_postion","upload_img");
	$new =array("$menucategory","$texttype","$txtpostion","$txtlanguage","$txtename","$url","$page_url","$txtekeyword","$txtmeta_description","$txtcontentdesc","$txtuplode","$link","$startdate","$expairydate","$update_date","$txtstatus","$user_id","$create_version","$media_page","$linktype","$txtsl","$txtuplode1");

	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */
 error_reporting(E_ALL);
ini_set('display_errors', 1);

 $startdate='2025-01-01';
 $expairydate='2025-12-31';
 $createdate='2025-01-01 00:00:00';
 $txtsl = 0;
 $create_version = 0;
 $linktype = 0;

			$sql1 = "UPDATE `menu` SET `m_flag_id`='$menucategory',`m_type`='$texttype',`menu_positions`='$txtpostion',`language_id`='$txtlanguage',`m_name`='$txtename',`m_url`='$url',`m_title`='$page_url',`m_keyword`='$txtekeyword',`m_description`='$txtmeta_description',`content`='$txtcontentdesc',`doc_uplode`='',`linkstatus`='$link',`start_date`='$startdate',`end_date`='$expairydate',`update_date`='$update_date',`approve_status`='$txtstatus',`admin_id`='$user_id',`current_version`='$create_version',`media_page`='$media_page',`link_category`='$linktype',`page_postion`='$txtsl',`upload_img`='$txtuplode1' WHERE m_id='$cid'";
			
			$rs = $conn->query($sql1);
	$page_id=$cid;

if($txtstatus=='3')
{

	$tableName_send="menu_publish";
	$whereclause="where m_publish_id='$cid'";
$sql= mysqli_query($conn, "Select * from menu_publish $whereclause");
$row= mysqli_num_rows($sql); 
	if($create_version==1 and $row >0){ 
 $sql="INSERT INTO menu_publish_versions(m_type,m_publish_id,m_flag_id,menu_positions,language_id,m_name,m_url,m_title,m_keyword,m_description,content,doc_uplode,linkstatus,	start_date,end_date,approve_status,	admin_id,page_postion,current_version,module_id,media_page,link_category,upload_img,create_versions_date)
	 SELECT m_type,m_publish_id,m_flag_id,menu_positions,language_id,m_name,m_url,m_title,m_keyword,m_description,content,doc_uplode,linkstatus,	create_date,date(update_date),approve_status,admin_id,page_postion,current_version,module_id,media_page,link_category,upload_img,update_date
   FROM menu_publish WHERE m_publish_id=$cid";
  mysqli_query($conn, $sql);
		}

	if($row >0){	
	/* 	$whereclause="m_publish_id='$cid'";
		$old =array("m_type","m_flag_id","menu_positions","language_id","m_name","m_url","m_title","m_keyword","m_description","content","doc_uplode","linkstatus","start_date","end_date","update_date","approve_status","admin_id","current_version","page_postion","upload_img");
		$new =array("$texttype","$menucategory","$txtpostion","$txtlanguage","$txtename","$url","$page_url","$txtekeyword","$txtmeta_description","$txtcontentdesc","$txtuplode","$link","$startdate","$expairydate","$update_date","$txtstatus","$user_id","$create_version","$txtsl","$txtuplode1");
		$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */

	$sql2 = "UPDATE `menu_publish` SET `m_flag_id`='$menucategory',`m_type`='$texttype',`menu_positions`='$txtpostion',`language_id`='$txtlanguage',`m_name`='$txtename',`m_url`='$url',`m_title`='$page_url',`m_keyword`='$txtekeyword',`m_description`='$txtmeta_description',`content`='$txtcontentdesc',`doc_uplode`='$txtuplode',`linkstatus`='$link',`start_date`='$startdate',`end_date`='$expairydate',`update_date`='$update_date',`approve_status`='$txtstatus',`admin_id`='$user_id',`current_version`='$create_version',`page_postion`='$txtsl',`upload_img`='$txtuplode1' WHERE m_publish_id='$cid'";
	$rss = $conn->query($sql2);

	$user_id=$_SESSION['admin_auto_id_sess'];
	$page_id=$cid;
	$action="Update";
	$categoryid='1';
	$date=date("Y-m-d h:i:s");
	$ip=$_SERVER['REMOTE_ADDR'];

	$tableName="audit_trail";
	$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
	$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);


	}else{
		$tableFieldsName_send=array("m_type","m_publish_id","m_flag_id","menu_positions","language_id","m_name","m_url","m_title","m_keyword","m_description","content","doc_uplode","linkstatus","start_date","end_date","update_date","approve_status","admin_id","current_version","upload_img");
		$tableFieldsValues_send=array("$texttype","$page_id","$menucategory","$txtpostion","$txtlanguage","$txtename","$url","$page_url","$txtekeyword","$txtmeta_description","$txtcontentdesc","$txtuplode","$link","$startdate","$expairydate","$update_date","$txtstatus","$user_id","$version","$txtuplode1");
		$useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
	}
}
		$msg=CONTENTUPDATE;
$_SESSION['content']=$msg;
$_SESSION['token'] = "";
$_SESSION['uniq'] = "";
header("location:manage_menu.php?txtstatus=" .$txtstatus);
}

}

 $edit_contrator ="select * from menu where m_id='$editid'";
$contrator_result = mysqli_query($conn, $edit_contrator);
$res_rows=mysqli_num_rows($contrator_result);
$fetch_result=mysqli_fetch_array($contrator_result);
@extract($fetch_result);
$module=$module_id;
$editors=$content; 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Edit Menu Page : <?php echo $sitename;?></title>
<link rel="SHORTCUT ICON" href="images/favicon.ico" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script language="JavaScript" src="js/validation.js"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
<script type="text/javascript">
function getPage(id) {

    //generate the parameter for the php script
    var data = 'language=' + id;
    $.ajax({
        url: "primarylink-menu.php",  
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
<script language="javascript" type="text/javascript">
	function addmenutype(id) {
	if(id=='1')
		{ 	document.getElementById('txtDoc').style.display = 'block';
			document.getElementById('txtPDF').style.display = 'none';
			document.getElementById('txtweb').style.display = 'none';
			document.getElementById('media').style.display = 'none';
		}
		else if(id=='2')
		{	document.getElementById('txtDoc').style.display = 'none';
			document.getElementById('txtPDF').style.display = 'block';
			document.getElementById('txtweb').style.display = 'none';
			document.getElementById('media').style.display = 'none';
		}
		else if(id=='3')
		{	document.getElementById('txtDoc').style.display = 'none';
			document.getElementById('txtPDF').style.display = 'none';
			document.getElementById('txtweb').style.display = 'block';
			document.getElementById('media').style.display = 'none';
		}	
		else 
		{	document.getElementById('txtDoc').style.display = 'none';
			document.getElementById('txtPDF').style.display = 'none';
			document.getElementById('txtweb').style.display = 'none';
			document.getElementById('media').style.display = 'block';
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
  <span class="submenuclass"><a href="welcome.php">Dashboard</a></span>

  
			
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_menu.php?module_id=1">Manage Menu</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Edit Menu</span>
			</span>
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
 <h3 class="manageuser">Edit Menu</h3>
<!-- <div class="right-section">
  <ul>
<?php if($role_map['draft']=='DR' || $user_id=='101'){?>
 <li  class="new-icon"><a href="add_menu.php?module_id=<?php echo $model_id;?>" title="New"><span class="icon-28-new"></span>New</a>            </li><?php }?>
              
            </ul>
			
 
 </div>-->
 
 </div>	
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return edit_content('form1')">
<div class="frm_row"> <span class="label1">
              <label for="txtename">Menu Title:</label>
              </span> <span class="input1">
              <input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30" value="<?php echo stripslashes($m_name);?>"/>
                                       </span>
              <div class="clear"></div>
            </div>
			
		<div class="frm_row"> <span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> <span class="input1">
            <input type="radio" name="txtlanguage" autocomplete="off"  value="1"<?php if($language_id=='1') echo 'checked=checked'?> onclick="getPage(this.value);"/>English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2"<?php if($language_id=='2') echo 'checked=checked'?> onclick="getPage(this.value);"/>Hindi
			
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
			<!-- <div class="frm_row"> <span class="label1">
              <label for="create_version">Create New Versions:</label>
              <span class="star">*</span></span> <span class="input1">
            <input type="radio" id="create_version" name="create_version" autocomplete="off" value="0"<?php if($create_version=='0') echo 'checked=checked'?>/>No &nbsp;<input type="radio" name="create_version" autocomplete="off"  value="1"<?php if($create_version=='1') echo 'checked=checked'?>/>Yes 
			
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div> -->
<div id="content1">
<div class="frm_row"> <span class="label1">
                    <label for="menucategory">Primary Link:</label>
                    <span class="star">*</span></span> <span class="input1">
                    
            <?php 
			
	 $sql1 = "select * from menu where approve_status='3' and m_flag_id='0' and language_id=".$language_id."";
$nav_query = $conn->query($sql1);
$tree = "";                         // Clear the directory tree
$depth = 1;                         // Child level depth.
$top_level_on = 1;               // What top-level category are we on?
$exclude = array();               // Define the exclusion array
array_push($exclude, 0);     // Put a starting value in it


if($m_flag_id==0){ 
				$val="selected"; 
			} else {
				$val='';
			}
 $tree = '<option value ="0"'.$val.'>It is Root Category</option>'; 
while ($nav_row = $nav_query->fetch_assoc() )
{
	
     $goOn = 1;               // Resets variable to allow us to continue building out the tree.
	for($x = 0; $x < count($exclude); $x++ )          // Check to see if the new item has been used
	{
		if ( $exclude[$x] == $nav_row['m_id'] )
		{
		   $goOn = 0;
		   break;                    // Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node
		}
	}
	if ( $goOn == 1 )
	{
	
		if($m_flag_id==$nav_row['m_id'])
		{ 
			$root="selected"; 
		}else {
			$root='';
		}
	      $tree .= '<strong><option value="'.$nav_row['m_id'].'"'.$root.'>'.$nav_row['m_name'].'</option></strong>';                    // Process the main tree node
          array_push($exclude, $nav_row['m_id']);          // Add to the exclusion list
          if ( $nav_row['m_id'] < 6 )
          { $top_level_on = $nav_row['m_id']; }
 
          $tree .= build_child($nav_row['m_id']);          // Start the recursive function of building the child tree
    }
}

function build_child($oldID)               // Recursive function to get all of the children...unlimited depth
{
 
    	$tempTree='';
	$temp='';
	include "../../includes/connection.php";
	GLOBAL $exclude, $depth, $m_flag_id; 
	$sql = 'select * from menu where approve_status="3" and m_flag_id="'.$oldID.'"';
	$rs = $conn->query($sql);
	while ( $child = $rs->fetch_assoc() ){
          if ( $child['m_id'] != $child['m_flag_id'] )
          {
               for ( $c=0;$c<$depth;$c++ )               // Indent over so that there is distinction between levels
               { $temp.= "&nbsp;&nbsp;&nbsp;"; }
	 
           		  if($m_flag_id==$child['m_id']){ 
					$subroot="selected"; 
				  }else {
					  $subroot='';
					}
					

			  $tempTree.='<option value="'.$child['m_id'].'"'.$subroot.'>'.$temp.'--'.$child['m_name'].'</option>';
               $depth++;          // Incriment depth b/c we're building this child's child tree  (complicated yet???)
               $tempTree .= build_child($child['m_id']);          // Add to the temporary local tree
               $depth--;  
			   $temp='';        // Decrement depth b/c we're done building the child's child tree.
               array_push($exclude, $child['m_id']);               // Add the item to the exclusion list
          }
     }
 
     return $tempTree;          // Return the entire child tree
}

echo '<select id="menucategory" name="menucategory">'.$tree.'</select>';


?>

                    </span>
                    <div class="clear"></div>
                    </div>
</div>
			
  

<div class="frm_row"> <span class="label1">
<label for="texttype">Menu Type :</label>
<span class="star">*</span></span> <span class="input1">
<select name="texttype" id="texttype" autocomplete="off" onChange="addmenutype(this.value)">
<option value="">Select</option>
<?php 
foreach($menutype as $key=>$value)
{
//if ($m_type==$key)
//{
	
	?>

<option value="<?php echo $key; ?>"<?php if ($m_type==$key) echo 'selected="selected"';?>><?php echo $value; ?></option><?php } //}
 ?>
</select></span>
<div class="clear"></div>
</div>

<div id="txtDoc" <?php if($m_type=='1') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>

<div class="frm_row"> <span class="label1">
				<label for="page_url">Meta Title:</label> <span class="star">*</span>
				</span> <span class="input1">
				<input name="page_url" autocomplete="off" type="text" class="input_class" id="page_url" size="30"   value="<?php echo stripslashes($m_title);?>"/>
				
				</span>
				<div class="clear"></div>
				</div>

   <div class="frm_row"> <span class="label1">
              <label for="txtekeyword">Meta Keyword:</label>
              
			  </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtekeyword" autocomplete="off" id="txtekeyword"><?php echo stripslashes($m_keyword);?></textarea>
                                       </span>
              <div class="clear"></div>
            </div>
            <div class="frm_row"> <span class="label1">
              <label for="txtmeta_description">Meta Description:</label>
              </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtmeta_description" autocomplete="off" id="txtmeta_description"><?php echo stripslashes($m_description);?>
</textarea>
                                       </span>
              <div class="clear"></div>
            </div>

        <div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        <span class="star">*</span></span> <span class="input_fck">
<?php
		

		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($editors)));
		?>        </span>
        <div class="clear"></div>
        </div>
</div>
<div id="txtPDF"  <?php if($m_type=='2') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
            <div class="frm_row"> <span class="label1">
            <label for="txtuplode">Document Upload :</label>
            <span class="star">*</span></span> <span class="input1">
           <input type="file" name="txtuplode" id="txtuplode"/>
            </span>
            <div class="clear"></div>
            </div>
</div>

<div id="txtweb"  <?php if($m_type=='3') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
   <div class="frm_row"> <span class="label1">
            <label for="txtweblink">Web Site Link :</label>
            <span class="star">*</span></span> <span class="input1">
          <input type="text" name="txtweblink" id="txtweblink" size="30" value="<?php echo stripslashes($linkstatus);?>" class="textbox">
		  <span class="date"><strong>Example : https://www.xyz.com</strong></span>
            </span>
            <div class="clear"></div>
            </div>
</div>
<div class="frm_row"> <span class="label1">
              <label for="uploadImage">Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <input type="file" name="uploadImage" id="uploadImage" />
				<?php if($upload_img !='') {?>
		   <img src="../../upload/breadcrum_image/<?php echo $upload_img;?>" alt="" title="" align="center" width="80" height="90" />
		   <?php }?> 
				</span>
				<div class="clear"></div>
			  </div>
<?php $con="select * from menu_publish where m_flag_id ='0'  and menu_positions	='1' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
$sql=mysqli_query($conn, $con);
$counter=mysqli_num_rows($sql);
 $footercon="select * from menu_publish where m_flag_id ='0'  and menu_positions	='3' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
$footersql=mysqli_query($conn, $footercon);
$footercounter=mysqli_num_rows($footersql);
$footercounter;
?>

<div class="frm_row"> <span class="label1">
  <label for="txtpostion">Content Positions:</label>
  <span class="star">*</span></span> <span class="input1">
  <select name="txtpostion" id="txtpostion" autocomplete="off">
<?php 
foreach($postion as $key=>$value)
{
	?>
<option value="<?php echo $key; ?>"<?php if ($menu_positions==$key) echo 'selected="selected"';?>><?php if($key=='1' || $key=='2' || $key=='3' || $key=='4' || $key=='5') echo $value; ?></option>
<?php }
 ?>
</select>
                                       </span>
              <div class="clear"></div>
            </div>
			
			<div class="frm_row"> <span class="label1">
				<label for="txtename">Sl no:</label>
				</span> <span class="input1">
				<input name="txtsl" autocomplete="off" type="text" class="input_class" id="txtsl" size="30"   value="<?php if($page_postion!=""){ echo $page_postion;} ?>"/>
				
				</span>
				<div class="clear"></div>
				</div>
        
             <div class="frm_row"> <span class="label1">
              <label for="txtstatus">Page Status:</label>
              <span class="star">*</span></span> <span class="input1">
              <select name="txtstatus" id="txtstatus" autocomplete="off" onchange="divcomment(this.value)">
	<option value=""> Select </option>
	 <?php if($user_id =='101')
	{
	$sql=mysqli_query($conn, "select * from content_state where state_status='1'");

		while($row=mysqli_fetch_array($sql))
		{  
		?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
		<?php }
	}
	else if($user_id !='101' )
	     {
		 $sql=mysqli_query($conn, "select * from content_state");

		 while($row=mysqli_fetch_array($sql))
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
			if($row['state_short']==$role_map['review']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($approve_status==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			
		
		}
		 }
 ?>
	</select>
                                       </span>
              <div class="clear"></div>
            </div>

<div class="frm_row"> 
<span class="button_row">   
<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" /><input name="cid" type="hidden" value="<?php echo $m_id;?>" /><input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">&nbsp;<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />&nbsp;
<input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_menu.php'" />
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

