<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
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
if($_SESSION['admin_auto_id_sess']==''){	
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
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
if($role_id < 0 && $role_map['draft']=='')
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

if($_SESSION['lname']=='English')
{
$lan='1';
}
else if($_SESSION['lname']=='Hindi')
{
$lan='2';
}
if(isset($cmdsubmit))
{
	$txtename 				= trim(str_replace("'", "\'", $_POST['txtename']));
	$txtsl 					= content_desc($_POST['txtsl']);
	$page_url 				=  trim(str_replace("'", "\'", $_POST['page_url']));
	$menucategory			= content_desc($_POST['menucategory']);
	$txtekeyword			= trim(str_replace("'", "\'", $_POST['txtekeyword']));
	$txtmeta_description	= trim(str_replace("'", "\'", $_POST['txtmeta_description']));
	if($txtlanguage!='2'){
		$txtcontentdesc		= htmlentities(stripslashes(utf8_encode($_POST['txtcontentdesc'])), ENT_QUOTES); 	
	}else{
		$txtcontentdesc		= $_POST['txtcontentdesc'];
	}
	$link					= content_desc($_POST['txtweblink']);
	$txtpostion				= content_desc($_POST['txtpostion']);
	$txtlanguage			= content_desc($_POST['txtlanguage']);
	$txtstatus				= content_desc($_POST['txtstatus']);
	$createdate				= date('Y-m-d');
	$errmsg					= "";  
if(trim($txtlanguage)=="")
		{
			
		}
	
if($txtlanguage=='2')
{
	
	if(trim($txtename)=="")
		{
		$errmsg .= "Please Enter Menu Title "."<br>";
		}
		
		if(trim($texttype)=="")
		{
			$errmsg .="Please Select Menu Type."."<br>";
			
		}
		if(trim($txtlanguage)!="")
		{
			if(trim($menucategory)=="")
			{
			$errmsg .="Please Select Primary Link."."<br>";
			
			}
		
		}
		
		if(trim($texttype)!="")
		{
			if($texttype=='1')
			  {
				if(trim($page_url)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}
				/*if(trim($page_url)!="")
					{			
						if (preg_match("/^[a-zA-Z0-9'-_() &amp;\"]{2,100}$/i", $page_url) === 0)
						{
						$errmsg .= "Menu Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 2 and maximum 100."."<br>";
						}
					}*/
			  	if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter Content Description."."<br>";
				
				}
			}
					
			if($texttype=='2')
			  {
				
				if($_FILES["txtuplode"]["name"]=="")
				{
				$errmsg .="Please enter Document upload."."<br>";
				}
				
			}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($link)!="")
				{
					if (!validateURL($link))
					 {
					$errmsg .="URL address not valid.<br>";
						}
				}

			}
			
		}

		if(trim($txtpostion)=="")
		{
			$errmsg .="Please Select Position."."<br>";
			
		}
		if(trim($txtstatus)=="")
		{
			$errmsg .="Please Select Page Status."."<br>";
		}
}
else
{
		if(trim($txtename)=="")
		{
		$errmsg .= "Menu title should be alphanumeric "."<br>";
		}
		if(trim($txtename)!="")
		{			
			 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename))
			{
				$errmsg .= "Menu Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 2 and maximum 100."."<br>";
			}
		}
		if(trim($txtlanguage)=="")
		{
			$errmsg .="Please Select Language"."<br>";
		}
		if(trim($texttype)=="")
		{
		$errmsg .="Please Select Menu Type"."<br>";
		}
		if(trim($texttype)!="")
		{

			if($texttype=='1')
			  {	

				if(trim($page_url)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}
					if(trim($page_url)!="")
					{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$page_url))
						{
						$errmsg .= "Meta Title must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}
					}
				if(trim($txtekeyword)!="")
					{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtekeyword))
						{
						$errmsg .= "Meta Keyword must be Alphanumeric  that should be minimum 2 and maximum 100."."<br>";
						}
					}
					if(trim($txtmeta_description)!="")
					{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtmeta_description))
						{
						$errmsg .= "Meta Description Title must be Alphabet that should be minimum 2 and maximum 100."."<br>";
						}
					}
				if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter  Description."."<br>";
				
				}
			}
	
			 if($texttype=='2')
			  {	
				if($_FILES["txtuplode"]["name"]=="")
				{
				$errmsg .="Please upload Document."."<br>";
				}

			}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($txtweblink) !="")
				{
					if (!validateURL($txtweblink))
					 {
					$errmsg .="URL address not valid.<br>";
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
			}elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
			{}else{
				$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
			}
			if ($_FILES["uploadImage"]["size"] < 1)
			{
				$errmsg .= "Image Size is too less.<br>";
			}
			if ($_FILES["uploadImage"]["size"] >=(1048576*5))
			{
				$errmsg .= IMAGE_SIZE_LIMIT."<br>";
			}
			
		}
	}



		if(trim($txtpostion)=="")
		{
			$errmsg .="Please Select Position."."<br>";
			
		}
		if(trim($txtstatus)=="")
		{
			$errmsg .="Please Select Page Status."."<br>";
		
		
		}
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
		if ($_FILES["txtuplode"]["name"]!="")
		{
				$txtuplode=$_FILES['txtuplode']['name'];
				$txtuplode = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplode);
				$uniq = uniqid("");
				$txtuplode=$uniq.$txtuplode;		
				$PATH="../../upload/";					
				$PATH=$PATH."/"; 
				$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
				$size=filesize($PATH.$txtuplode);
				$size=ceil($size/1024);
				$found="false";
		
		}	
		if ($_FILES["uploadImage"]["name"]!="")
		{
			if($_FILES["uploadImage"]["size"] >=150 || $_FILES["uploadImage"]["size"] <=30)
			{
				
				$txtuplode1=$_FILES['uploadImage']['name'];
				$txtuplode1 = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplode1);
				$uniq = uniqid("");
			$txtuplode1=$uniq.$txtuplode1;	
				$PATH="../../upload/breadcrum_image/";					
				if(!is_dir($PATH)){  
					mkdir($PATH,0777);
					}
					$PATH=$PATH."/"; 
				$val=move_uploaded_file($_FILES["uploadImage"]["tmp_name"],$PATH.$txtuplode1);
				$size=filesize($PATH.$txtuplode1);
				$size=ceil($size/1024);
				$found="false";
		
		}	
		
		else{
			$msg=IMAGE_SIZE_LIMIT;
			$_SESSION['sess_img']=$msg;
			header("location:add_menu.php");
			exit;
		}	

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
		
	if($txtlanguage=='2')
		{		
		$url=seo_url($page_url.'-hi'); }
		else { $url=seo_url($page_url);
		}
		

		
/* $tableName_send="menu";
$tableFieldsName_old=array("m_flag_id","m_type","menu_positions","language_id","m_name","m_url","m_title","m_keyword","m_description","content","doc_uplode","linkstatus","start_date","end_date","create_date","update_date","approve_status","admin_id","page_postion","current_version","upload_img");
$tableFieldsValues_send=array("$menucategory","$texttype","$txtpostion","$txtlanguage","$txtename","$url","$page_url","$txtekeyword","$txtmeta_description","$txtcontentdesc","$txtuplode","$link","$startdate","$expairydate","$createdate","","$txtstatus","$user_id","$txtsl","0","$txtuplode1");
echo $value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send); */

	$insert_sql = "INSERT INTO `menu`(`m_flag_id`,`m_type`,`menu_positions`,`language_id`,`m_name`,`m_url`,`m_title`,`m_keyword`,`m_description`,`content`,`doc_uplode`,`linkstatus`,`start_date`,`end_date`,`create_date`,`update_date`,`approve_status`,`admin_id`,`page_postion`,`current_version`,`upload_img`)VALUES('$menucategory','$texttype','$txtpostion','$txtlanguage','$txtename','$url','$txtename','$txtekeyword','$txtmeta_description','$txtcontentdesc','$txtuplode','$link','$startdate','$expairydate','$createdate','$createdate','$txtstatus','$user_id','$txtsl','0','$txtuplode1')"; 
	
	$ins_sqli1 = $conn->query($insert_sql);
	$page_id = $conn->insert_id;

if($txtstatus=='3')
{

$whereclause="where v_type='$texttype' and v_pageid='$page_id' and v_flag_id='$menucategory' and v_langid='$txtlanguage'";
$sql=mysqli_query($conn, "Select v_version from versions $whereclause order by v_version DESC LIMIT 0 ,1");
$row=mysqli_num_rows($sql); 

if($row >0)
{
$rows=mysqli_fetch_array($sql);	
$version=$rows['v_version']+1;	
}

else
{  $version =1; }
	/* $tableName_send="menu_publish";
	$tableFieldsName_old=array("m_type","m_publish_id","m_flag_id","menu_positions","language_id","m_name","m_url","m_title","m_keyword","m_description","content","doc_uplode","linkstatus","start_date","end_date","create_date","update_date","approve_status","admin_id","page_postion","current_version","upload_img");
	$tableFieldsValues_send=array("$texttype","$page_id","$menucategory","$txtpostion","$txtlanguage","$txtename","$url","$page_url","$txtekeyword","$txtmeta_description","$txtcontentdesc","$txtuplode","$link","$startdate","$expairydate","$createdate","","$txtstatus","$user_id","$txtsl","$version","$txtuplode1");
	$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send); */
	
	$tablesql = "INSERT INTO `menu_publish`(`m_type`,`m_publish_id`,`m_flag_id`,`menu_positions`,`language_id`,`m_name`,`m_url`,`m_title`,`m_keyword`,`m_description`,`content`,`doc_uplode`,`linkstatus`,`start_date`,`end_date`,`create_date`,`update_date`,`approve_status`,`admin_id`,`page_postion`,`current_version`,`upload_img`)VALUES('$texttype','$page_id','$menucategory','$txtpostion','$txtlanguage','$txtename','$url','$page_url','$txtekeyword','$txtmeta_description','$txtcontentdesc','$txtuplode','$link','$startdate','$expairydate','$createdate','','$txtstatus','$user_id','$txtsl','$version','$txtuplode1')";
	$ins_sqli2 = $conn->query($tablesql);
	$page_id = $conn->insert_id;

	
/* $tableName_send="versions";
$tableFieldsName_old=array("v_type","v_pageid","v_flag_id","v_langid","v_pagename","v_title","v_content","v_version","v_date");
$tableFieldsValues_send=array("$texttype","$page_id","$menucategory","$txtlanguage","$url","$txtepage_title","$txtcontentdesc","$version","$createdate");
$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send); */

$tablesql2 = "INSERT INTO `versions`(`v_type`,`v_pageid`,`v_flag_id`,`v_langid`,`v_pagename`,`v_title`,`v_content`,`v_version`,`v_date`)VALUES('$texttype','$page_id','$menucategory','$txtlanguage','$url','$txtepage_title','$txtcontentdesc','$version','$createdate')";
	$ins_sqli3 = $conn->query($tablesql2);
	$page_id = $conn->insert_id;

}
		$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id = $conn->insert_id;
		$action="Insert";
		$categoryid='1'; 
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);

	$tablesql3 = "INSERT INTO `audit_trail`(`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
	$ins_sqli4 = $conn->query($tablesql3);

	

	$msg='Menu has been added successfully';
$_SESSION['content']=$msg;
header("location:manage_menu.php");
exit;	
}	
}
?>

<!DOCTYPE PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Menu Page :<?php echo $sitename;?></title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script language="JavaScript" src="js/validation.js"></script>



<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->


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
<script type="text/javascript">
function getPage(id) {
    //generate the parameter for the php script
	//alert(id);
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

<script type="text/javascript">
function editlist(id) {
    //generate the parameter for the php script
    var data = 'id=' + id;
	//alert(id);
    $.ajax({
        url: "editid.php",  
        type: "POST", 
        data: data,     
        cache: false,
        success: function (html) {  
         
            //hide the progress bar
            $('#loading').hide();   
             $('#loading').hide();   
             
            //add the content retrieved from ajax and put it in the #content div
            $('#content1').html(html);
             
            //display the body with fadeIn transition
           
            //add the content retrieved from ajax and put it in the #content div
              
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
<script>
	$().ready(function() {
		// validate signup form on keyup and submit
		$("#demo-content").validate({
			rules: {
				txtename: "required"
			},
			messages: {
				txtename: "Please enter your firstname"
			}
		});
	});
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
			<span class="submenuclass"><a href="manage_menu.php?module_id=1"><?php echo "Manage Menu";?></a></span>
			<span class="submenuclass">>> </span> 
			<span class="submenuclass">Add Menu</span>
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
	<div class="internalpage_heading">
 <h3 class="manageuser">Add Menu</h3>
 
 </div>
</div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_content('form1')">

			
			<div class="frm_row"> <span class="label1">
				<label for="txtename">Menu Title:</label> <span class="star">*</span>
				</span> <span class="input1">
				<input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php if($txtename!=""){ echo $txtename;} ?>"/>
				
				</span>
				<div class="clear"></div>
				</div>
		
				
				<div class="frm_row"> 
				<span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> 
			    <span class="input1">
				<input type="radio" name="txtlanguage" autocomplete="off" onclick="getPage(this.value);" id="txtlanguage" value="1"<?php if($txtlanguage=='1'){ echo "checked"; }?> >English &nbsp;
				 <input type="radio" name="txtlanguage" autocomplete="off" id="txtlanguage"  onclick="getPage(this.value);" value="2"<?php if($txtlanguage=='2'){ echo "checked"; }?>/>Hindi

			               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
<div id="content1">

</div>

<div class="frm_row"> <span class="label1">
<label for="texttype">Menu Type :</label>
<span class="star">*</span></span> <span class="input1">
<select name="texttype" id="texttype" autocomplete="off"  onChange="addmenutype(this.value)" >
<option value="">Select</option>
<?php 
foreach($menutype as $key=>$value)
{
	?>
<option value="<?php echo $key; ?>" <?php if($key==$texttype){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
 ?>
</select></span>
<div class="clear"></div>
</div>
<div id="txtDoc" <?php if($texttype=='1') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
		<div class="frm_row"> <span class="label1">
				<label for="page_url">Meta Title / Page URL:</label> <span class="star">*</span>
				</span> <span class="input1">
				<input name="page_url" autocomplete="off" type="text" class="input_class" id="page_url" size="30"   value="<?php if($page_url!=""){ echo $page_url;} ?>"/>
				
				</span>
				<div class="clear"></div>
				</div><span class="date">[Meta Title should be only in English]</span>
 <div class="frm_row"> <span class="label1">
              <label for="txtekeyword">Meta Keyword:</label>
              </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtekeyword" autocomplete="off" id="txtekeyword"><?php if($txtekeyword!=""){ echo $txtekeyword;} ?></textarea>
              </span>
              <div class="clear"></div>
            </div>
            <div class="frm_row"> <span class="label1">
              <label for="txtmeta_description">Meta Description:</label>
              </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtmeta_description" autocomplete="off"  id="txtmeta_description" ><?php if($txtmeta_description!=""){ echo $txtmeta_description;} ?>
</textarea>
              </span>
              <div class="clear"></div>
            </div>
        <div class="frm_row"> <span class="label1">
        <label>Description :</label>
        <span class="star">*</span></span> <span class="input_fck">
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
</div>
<div id="txtPDF"  <?php if($texttype=='2') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
            <div class="frm_row"> <span class="label1">
            <label>Document Upload :</label>
            <span class="star">*</span></span> <span class="input1">
           <input type="file" name="txtuplode" id="txtuplode"/>
            </span>
            <div class="clear"></div>
            </div>
</div>

<div id="txtweb"<?php if($texttype=='3') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
   <div class="frm_row"> <span class="label1">
            <label for="txtweblink">Web Site Link :</label>
            <span class="star">*</span></span> <span class="input1">
          <input type="text" name="txtweblink" maxlength="100" id="txtweblink" size="30" class="textbox" value="<?php if($txtweblink!=""){ echo $txtweblink;} ?>">
		<span class="date"><strong>Example : https://www.xyz.com</strong></span>

            </span>
            <div class="clear"></div>
            </div>
</div>
<!--
 <div class="frm_row"> <span class="label1">
              <label for="uploadImage">Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <input type="file" name="uploadImage" id="uploadImage" />
				</span>
				<div class="clear"></div>
			  </div> -->
 
	<?php $con="select * from menu_publish where m_flag_id ='0'  and menu_positions	='1' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
	$sql=mysqli_query($conn, $con);
	$counter=mysqli_num_rows($sql);
	$footercon="select * from menu_publish where m_flag_id ='0'  and menu_positions	='3' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
	$footersql=mysqli_query($conn, $footercon);
	$footercounter=mysqli_num_rows($footersql);
	?>
	
            <div class="frm_row"> <span class="label1">
              <label for="txtpostion">Content Position:</label>
              <span class="star">*</span></span> <span class="input1">
              
<select name="txtpostion" id="txtpostion" autocomplete="off">
<option value=""> Select </option>

		
<?php 
foreach($postion as $key=>$value)
{  //print_r($postion);
		if(($key=='1' || $key=='2' || $key=='3' || $key=='4' || $key=='5'))
		{
		   if($counter <=12 && $key =='1')
		   {
		   ?>
		   <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>
		   <?php 
		   }
		   else if($footercounter <=19 && $key =='3')
		   { ?>
	 <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>
		  <?php  }
		  else if($key =='2')
		  {?>
		   <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>
		  <?php }
		   else if($key =='4')
		  {?>
		   <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>
		  <?php } else if ($key=='1') { ?>
             <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>   
               <?php } else if ($key=='5') { ?>
             <option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>   
               <?php } ?>
<?php }}
 ?>
</select>
               </span>
              <div class="clear"></div>
            </div>
				<div class="frm_row"> <span class="label1">
				<label for="txtename">Sl no:</label>
				</span> <span class="input1">
				<input name="txtsl" autocomplete="off" type="text" class="input_class" id="txtsl" size="30"   value="<?php if($txtsl!=""){ echo $txtsl;} ?>"/>
				
				</span>
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
			$sql=mysqli_query($conn, "select * from content_state where state_status=1");
			
			while($row=mysqli_fetch_array($sql))
			{ 
			 
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			}
			else if($user_id !='101' )
			{
			$sql=mysqli_query($conn, "select * from content_state");
			
			while($row=mysqli_fetch_array($sql))
			{  
			if($row['state_short']==$role_map['draft']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			if($row['state_short']==$role_map['mapprove']){
			?>
                <option value="<?php echo $row['state_id'];?>"><?php echo $row['state_name']; ?></option>
                <?php }
			if($row['state_short']==$role_map['publish']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			if($row['state_short']==$role_map['review'] && $role_type=='2'){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			
			}
			} ?>
			</select>
			</span>
			<div class="clear"></div>
			</div>
			<div class="clear"></div>

            <div class="frm_row"> <span class="button_row">
            <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Submit" />&nbsp;<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" /><input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_menu.php';" />
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

<?php include("footer.php"); ?>
                            <!-- Footer end -->
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
