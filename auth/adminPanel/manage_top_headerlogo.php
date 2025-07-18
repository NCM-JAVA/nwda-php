<?php ob_start();
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
$role_map=role_permission($user_id,$model_id);
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

/******Insert Record Start****/

if(isset($_POST['Submit_g']) && $_GET['id']==''){
		
		$txtlanguage= content_desc(check_input($_POST['txtlanguage']));
		$txtuplode = content_desc(check_input($_POST['txtuplode']));
		$logo_image = content_desc(check_input($_POST['logo_image']));
		$emblem_image = content_desc(check_input($_POST['emblem_image']));
		$right_image = content_desc($_POST['right_image']));
		//$txtcontentdesc= content_desc(check_input(($_POST['txtcontentdesc'])));	
		$a_status1=content_desc(check_input($_POST['a_status1']));
		$txtename1= content_desc(check_input($txtename1));
		//$lurl= $_POST['lurl'];
		//$r_url=seo_url($txtename1);

		if($txtlanguage=='2')
		{
	
		}
		else {
		if (trim($txtlanguage) == "") {
				$errmsg .= "Please Select Language." . "<br>";
		}
				
		if (trim($txtename1) == "") {
				$errmsg .= "Please Enter Title." . "<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\'/']{3,50}$/i", $txtename1) === 0)
		{
		$errmsg .= "Language Name must be from letters that should be minimum 3 and maximum 50."."<br>";
		}
		
		
		if (trim($a_status1) == "") {
		$errmsg .= "Please select page status." . "<br>";
		}	
		}
		/*if(trim($lurl)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}*/
				
				
		/*if(trim($txtcontentdesc)=="")
		{
			$errmsg .="Please enter content description."."<br>";
		}*/
		
		if($_FILES["txtuplode"]["tmp_name"]=="" || $_FILES["logo_image"]["tmp_name"]=="" || $_FILES["emblem_image"]["tmp_name"]==""|| $_FILES["right_image"]["tmp_name"]=="")
		{
		$errmsg .= "Please upload .jpg,.png,.jpeg files only."."<br>";
		}
		elseif ($_FILES["txtuplode"]["tmp_name"]!="")
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
					if ($_FILES["txtuplode"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["logo_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["logo_image"]["tmp_name"]);
				$imageinfo = ($_FILES["logo_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["logo_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["logo_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["logo_image"]["name"]);
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
					if ($_FILES["logo_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["logo_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["emblem_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["emblem_image"]["tmp_name"]);
				$imageinfo = ($_FILES["emblem_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["emblem_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["emblem_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["emblem_image"]["name"]);
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
					if ($_FILES["emblem_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["emblem_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["right_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["right_image"]["tmp_name"]);
				$imageinfo = ($_FILES["right_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["right_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["right_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["right_image"]["name"]);
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
					if ($_FILES["right_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["right_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		
		
		 if($errmsg=='')
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
	
	
	if ($_FILES["txtuplode"]["tmp_name"]!=""){
		
		$tmp_file = $_FILES["txtuplode"]["tmp_name"];
			$filename1 = $_FILES["txtuplode"]["name"];
			$new_path1 = '../../upload/logo/'.$filename1;
			
			move_uploaded_file($tmp_file,$new_path1);

}

if ($_FILES["logo_image"]["tmp_name"]!=""){
		
		$tmp_file = $_FILES["logo_image"]["tmp_name"];
			$filename2 = $_FILES["logo_image"]["name"];
			$new_path2 = '../../upload/logo/'.$filename2;
			
			move_uploaded_file($tmp_file,$new_path2);

}

if ($_FILES["emblem_image"]["tmp_name"]!=""){
		
		$tmp_file = $_FILES["emblem_image"]["tmp_name"];
			$filename3 = $_FILES["emblem_image"]["name"];
			$new_path3 = '../../upload/logo/'.$filename3;
			
			move_uploaded_file($tmp_file,$new_path3);

}

if ($_FILES["right_image"]["tmp_name"]!=""){
		
		$tmp_file = $_FILES["right_image"]["tmp_name"];
			$filename4 = $_FILES["right_image"]["name"];
			$new_path4 = '../../upload/logo/'.$filename4;
			
			move_uploaded_file($tmp_file,$new_path4);

}
			
	//$filename1=addslashes($filename1); 
	$sql_qry = mysql_query("SELECT * FROM header_logo");
	$numrows = mysql_num_rows($sql_qry);
	if($numrows < 4){
			 $date = date("Y-m-d h:i:s");
		
			$tableName_send="header_logo";
			$tableFieldsName_old=array("title","image1","image2","image3","image4","page_language","page_status");
			$tableFieldsValues_send=array("$txtename1","$filename1","$filename2","$filename3","$filename4","$txtlanguage","$a_status1");
			$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
			/*echo "insert into header_logo(image1,page_language,page_status) values ('".$filename1."','".$txtlanguage."','".$a_status1."')";
			$str= mysql_query("insert into header_logo(image1,page_language,page_status) values ('".$filename1."','".$txtlanguage."','".$a_status1."')");
			mysql_result($str);*/

			$page_id=mysql_insert_id();
			$action="Insert";
			$categoryid='1';
			$date=date("Y-m-d h:i:s");
			$ip=$_SERVER['REMOTE_ADDR'];

			$tableName="audit_trail";
			$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			$tableFieldsValues_send=array("$user_id","$page_id","$txtename1","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$a_status1");
			$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
								
			$msg=CONTENTADD;
			$_SESSION['SESS_MSG']=$msg;
			header("location:manage_top_headerlogo.php");
			exit;
	}
	else{ 
		$errmsg .= 'Sorry, you cannot insert more than 4 logo';
	}
		
			}
			
	}			  
			  

/******Update Record Start****/

if(isset($_POST['Submit_g']) && $_GET['id']!=''){

		$txtlanguage= check_input($_POST['txtlanguage']);
		$txtename1= content_desc(check_input($txtename1));
		$txtuplode = $_POST['txtuplode'];
		$logo_image = $_POST['logo_image'];
		$emblem_image = $_POST['emblem_image'];
		$right_image = $_POST['right_image'];
		$a_status1=check_input($_POST['a_status1']);
		
		//$txtcontentdesc= content_desc(check_input(($_POST['txtcontentdesc'])));
		//$lurl= seo_url($txtename1);
		//$lurl= $_POST['lurl'];
		//$r_url=seo_url($txtename1);
		if (trim($txtlanguage) == "") {
				$errmsg .= "Please Select Language." . "<br>";
		}
		
		if (trim($txtename1) == "") {
				$errmsg .= "Please Enter Title." . "<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\'/']{3,50}$/i", $txtename1) === 0)
		{
		$errmsg .= "Language Name must be from letters that should be minimum 3 and maximum 50."."<br>";
		}		
		
		
		if (trim($a_status1) == "") {
		$errmsg .= "Please select page status." . "<br>";
		}


		if($_FILES["txtuplode"]["tmp_name"]=="" || $_FILES["logo_image"]["tmp_name"]=="" || $_FILES["emblem_image"]["tmp_name"]==""|| $_FILES["right_image"]["tmp_name"]=="")
		{
		$errmsg .= "Please upload .jpg,.png,.jpeg files only."."<br>";
		}
		elseif ($_FILES["txtuplode"]["tmp_name"]!="")
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
					if ($_FILES["txtuplode"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["logo_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["logo_image"]["tmp_name"]);
				$imageinfo = ($_FILES["logo_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["logo_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["logo_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["logo_image"]["name"]);
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
					if ($_FILES["logo_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["logo_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["emblem_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["emblem_image"]["tmp_name"]);
				$imageinfo = ($_FILES["emblem_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["emblem_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["emblem_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["emblem_image"]["name"]);
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
					if ($_FILES["emblem_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["emblem_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		elseif ($_FILES["right_image"]["tmp_name"]!="")
		{
				$tempfile=($_FILES["right_image"]["tmp_name"]);
				$imageinfo = ($_FILES["right_image"]["type"]);
				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
				$nsection=substr($section,0,8);

				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["right_image"]["name"]) )
				{
					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
				}else if ( $section != strip_tags($section) )
				{
					$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
				}else{
					//echo $section;die();
					$imageinfo = getimagesize($_FILES["right_image"]["tmp_name"]);

					$extarray = explode(".",$_FILES["right_image"]["name"]);
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
					if ($_FILES["right_image"]["size"] < 1)
					{
						$errmsg .= "Image Size is too less.<br>";
					}
					if ($_FILES["right_image"]["size"] >=1048576)
					{
						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
					}
					
				}


		}
		
		
		
		 if($errmsg=='')
		 { 
			 
		$tableName_send="header_logo";
		$whereclause="id='".$_GET['id']."'";
		if($_SESSION['logtoken']!=$_POST['random'])
		{
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

		if ($_FILES["txtuplode"]["name"]!="")
			{
				
			$sql = "select image1 FROM header_logo WHERE id='".$_GET['id']."'";
			$rs = mysql_query($sql);
			$row=mysql_fetch_array($rs);
			$image_path = "../../upload/".$row['image1'];
			unlink($image_path);
   
			/*if ($_FILES["txtuplode"]["size"] < 500000)
			{*/
			$txtuplode=$_FILES['txtuplode']['name'];
			$uniq = uniqid("");
			$txtuplode=$uniq.$txtuplode;		
			$PATH="../../upload/logo";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
			$size=filesize($PATH.$txtuplode);
			$size=ceil($size/1024);
			$found="false";
			$txtuplode=addslashes($txtuplode); 
			//echo $txtuplode; 
			$old =array("image1");
			$new =array("$txtuplode");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	


			elseif ($_FILES["logo_image"]["name"]!="")
			{
				
			$sql = "select image2 FROM header_logo WHERE id='".$_GET['id']."'";
			$rs = mysql_query($sql);
			$row=mysql_fetch_array($rs);
			$image_path = "../../upload/".$row['image2'];
			unlink($image_path);
   
			/*if ($_FILES["logo_image"]["size"] < 500000)
			{*/
			$logo_image=$_FILES['logo_image']['name'];
			$uniq = uniqid("");
			$logo_image=$uniq.$logo_image;		
			$PATH="../../upload/logo";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["logo_image"]["tmp_name"],$PATH.$logo_image);
			$size=filesize($PATH.$logo_image);
			$size=ceil($size/1024);
			$found="false";
			$logo_image=addslashes($logo_image); 
			//echo $logo_image; 
			$old =array("image2");
			$new =array("$logo_image");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}


			elseif ($_FILES["emblem_image"]["name"]!="")
			{
				
			$sql = "select image3 FROM header_logo WHERE id='".$_GET['id']."'";
			$rs = mysql_query($sql);
			$row=mysql_fetch_array($rs);
			$image_path = "../../upload/".$row['image3'];
			unlink($image_path);
   
			/*if ($_FILES["emblem_image"]["size"] < 500000)
			{*/
			$emblem_image=$_FILES['emblem_image']['name'];
			$uniq = uniqid("");
			$emblem_image=$uniq.$emblem_image;		
			$PATH="../../upload/logo";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["emblem_image"]["tmp_name"],$PATH.$emblem_image);
			$size=filesize($PATH.$emblem_image);
			$size=ceil($size/1024);
			$found="false";
			$emblem_image=addslashes($emblem_image); 
			//echo $emblem_image; 
			$old =array("image3");
			$new =array("$emblem_image");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	
			elseif ($_FILES["txtuplode"]["name"]!="")
			{	
			$sql = "select image3 FROM header_logo WHERE '".$_GET['id']."'";
			$rs = mysql_query($sql);
			$row=mysql_fetch_array($rs);
			$image_path = "../../upload/".$row['image3'];
			unlink($image_path);
   
			/*if ($_FILES["txtuplode"]["size"] < 500000)
			{*/
			$right_image=$_FILES['right_image']['name'];
			$uniq = uniqid("");
			$right_image=$uniq.$right_image;		
			$PATH="../../upload/logo";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["right_image"]["tmp_name"],$PATH.$txtuplode);
			$size=filesize($PATH.$right_image);
			$size=ceil($size/1024);
			$found="false";
			$right_image=addslashes($right_image); 
			//echo $txtuplode; 
			$old =array("image4");
			$new =array("$right_image");
			$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			}	
	
		else
				{
				$whereclause="id='$_GET[id]'";
				$sql=mysql_query("Select * from header_logo where $whereclause");
				$res=mysql_fetch_array($sql);
				$txtuplode=$res['image1'];
				$logo_image=$res['image2'];
				$emblem_image=$res['image3'];
				$right_image=$res['image4'];
				}
	
	
	
	$date=date("Y-m-d");
	$tableName_send="header_logo";
	$whereclause="id='$_GET[id]'";
	$old =array("title","image1","image2","image3","image4","page_language","page_status");
	print_r($old);
	$new =array("$txtename1","$txtuplode","$logo_image","$emblem_image","$right_image","$txtlanguage","$a_status1"); 
	print_r($new);
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);


	$action="Update";
	$categoryid='1';
	$date=date("Y-m-d h:i:s");
	$ip=$_SERVER['REMOTE_ADDR'];

	$tableName="audit_trail";
	$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
	$tableFieldsValues_send=array("$user_id","$page_id","$txtename1","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$a_status1");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

	$msg=CONTENTUPDATE;
	$_SESSION['SESS_MSG']=$msg;
	//$_SESSION['token'] = "";
	//$_SESSION['uniq'] = "";
	header("location:manage_top_headerlogo.php");
	exit();
				
		}
	}
	


 if($_GET['did']!='')
 {
 if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($did))))
	{
		/*session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);*/
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
		$sql = "select * FROM header_logo WHERE id='$did'";
    $rs = mysql_query($sql);
	$row=mysql_fetch_array($rs);

	$path ="../../upload/logo";
	//$path2 ="../../upload/logo/thumb";
unlink($path . "/" .$row['image1']);
unlink($path . "/" .$row['image2']);
unlink($path . "/" .$row['image3']);
unlink($path . "/" .$row['image4']);
//unlink($path2 . "/" .$row['img_uplode']);
		mysql_query("delete from header_logo where id='$did'");
		
		$_SESSION['SESS_MSG'] = " Record Successfully Delete";
		header("Location:manage_top_headerlogo.php");
		exit;
	
	}
 	
 }
			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Logo : <?=$sitename?></title>
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
 <h3 class="manageuser"> Logo</h3>
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
		$rq = mysql_query("select * from header_logo where id='".$_GET['id']."'");
		
		$rr = mysql_fetch_array($rq);
		//print_r($rr);
		}
		
	
?>   

		
     <div class="frm_row"> 
				<span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> 
			    <span class="input1">
				<input type="radio" name="txtlanguage" id="txtlanguage" autocomplete="off"  value="1"<?php if($txtlanguage==1){ echo "checked"; } if($rr['page_language']==1){ echo 'checked="checked"';   }?> >English &nbsp;
				 <input type="radio" name="txtlanguage" autocomplete="off" id="txtlanguage"  value="2"<?php if($txtlanguage==2){ echo "checked"; } if($rr['page_language']==2){ echo 'checked="checked"';   }?>/>Hindi
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
              
              <!--<div class="frm_row"> <span class="label1">
              <label for="lurl">Url</label>
              <span class="star">*</span></span> <span class="input1">
			   <input name="lurl" type="text" size="50" class="input_class" id="lurl" value="<?php //if($lurl!=""){ echo $lurl;}  else   echo html_entity_decode($rr['l_url']);?>" />
				
				</span>
				<div class="clear"></div>
			  </div>-->
              
               <div class="frm_row"> <span class="label1">
              <label for="txtuplode">Fevicon Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <?php if($_GET[id]!=''){?>
			    <input type="file" name="txtuplode" id="txtuplode" />
			   <img src="../../upload/logo/<?php echo $rr['image1'];?>" alt="<?php echo $rr['image1'];?>" title="" align="center" width="80" height="90" />
				 <?php } else {?>
				 <input type="file" name="txtuplode" id="txtuplode" />
				 <?php } ?>
				</span>
				<div class="clear"></div>
			  </div>
			  
			  <div class="frm_row"> <span class="label1">
              <label for="logo_image">Logo Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <?php if($_GET[id]!=''){?>
			    <input type="file" name="logo_image" id="logo_image" />
			   <img src="../../upload/logo/<?php echo $rr['image2'];?>" alt="<?php echo $rr['image2'];?>" title="" align="center" width="80" height="90" />
				 <?php } else { ?>
				 <input type="file" name="logo_image" id="logo_image" /> 
				 <?php }?>
				</span>
				<div class="clear"></div>
			  </div>
			  
			  <div class="frm_row"> <span class="label1">
              <label for="emblem_image">Emblem Image</label>
              <span class="star">*</span></span> <span class="input1">
			   <?php if($_GET[id]!=''){?>
			    <input type="file" name="emblem_image" id="emblem_image" />
			   <img src="../../upload/logo/<?php echo $rr['image3'];?>" alt="<?php echo $rr['image3'];?>" title="" align="center" width="80" height="90" />
				 <?php } else { ?>
				  <input type="file" name="emblem_image" id="emblem_image" />
				  <?php } ?>
				</span>
				<div class="clear"></div>
			  </div>
			
			<div class="frm_row"> <span class="label1">
              <label for="right_image">Right Image </label>
              <span class="star">*</span></span> <span class="input1">
			   <?php if($_GET[id]!=''){?>
			    <input type="file" name="right_image" id="right_image" />
			   <img src="../../upload/logo/<?php echo $rr['image4'];?>" alt="<?php echo $rr['image4'];?>" title="" align="center" width="80" height="90" />
				 <?php } else{ ?>
				  <input type="file" name="right_image" id="right_image" />
				  <?php } ?>
				</span>
				<div class="clear"></div>
			  </div>
			  
 <!--<div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        <span class="star">*</span></span> <span class="input_fck">
<?php
		
		/*$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/pii/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/pii/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/daf/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/daf/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($rr['txtcontentdesc'])));*/
		?>        </span>
        <div class="clear"></div>
        </div>
</div>-->

	    
	  <div class="frm_row"> 
			<span class="label1">
			<label for="a_status1">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="a_status1" id="a_status1"  autocomplete="off" onchange="divcomment(this.value)">
			<option value=""> Select </option>
			<?php 
			if($user_id =='101')
			{
			$sql=mysql_query("select * from content_state where state_status=1");
			
			while($row=mysql_fetch_array($sql))
			{ if($row['state_id']>1){
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['page_status']==$row['state_id']) echo 'selected="selected"';?>><?php if($row['state_id']==2){echo "Inactive";}else{echo "Active";} ?></option>
			<?php }}
			}
			else if($user_id !='101' )
			{
			$sql=mysql_query("select * from content_state where state_status=1");
			
			while($row=mysql_fetch_array($sql))
			{  
			if($row['state_short']==$role_map['draft']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($rr['page_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			
			if($row['state_short']==$role_map['mapprove']){
			?>
                <option value="<?php echo $row['state_id'];?>"><?php echo $row['state_name']; ?></option>
                <?php }
			if($row['state_short']==$role_map['publish']){
			?>
			<option value="<?php echo $row['state_id'];?>" <?php if ($rr['page_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
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
			$sql=mysql_query("select * from content_state where state_status=1");
			
			while($row=mysql_fetch_array($sql))
			{ if($row['state_id']>1){
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php if($row['state_id']==2){echo "Inactive";}else{echo "Active";}; ?></option>
			<?php }}
			}
			else if($user_id !='101' )
			{
			$sql=mysql_query("select * from content_state where state_status=1");
			
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
$querywhere .="page_status=$txtstatus";
}



$columns = "select * ";
$sql = "from header_logo where 1 ";
$order_by == '' ? $order_by = 'title' : true;
$order_by2 == '' ? $order_by2 = 'ASC' : true;
$sql .= "$qy ";
$sql .= "order by $order_by $order_by2 ";
$sql_count = "select count(*) ".$sql; 
//$sql = $columns.$sql;

if($btnsubmit=="Search")
{
$sql = "select * from header_logo where $querywhere";
}
else
{
 $sql = $columns.$sql;
}


$pager = new PS_Pagination($link, $sql,"");
$rows = $pager->paginate();

	if($rows==0) { ?>
    <tr><td style="color:#F00;" height="30" align="center" colspan="5"><b>Sorry.. No records available.</b></td></tr>
<?php	}else	{	?>
    
<?php 
while($data=mysql_fetch_array($rows)){
	@extract($data);


?>
  <tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
    <td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
      <td width="510" colspan="2" align="left" class="left-tdtext"><?php echo html_entity_decode($data['title']);?></td>
	  <td width="510" colspan="2" align="left" class="left-tdtext"><?php status_new($page_status); ?></td>
    <td width="47" align="center" class="left-tdtext"><a href="manage_top_headerlogo.php?id=<?php echo $data['id'];?>" class="bluelink"><input type="image" border="0" alt="Edit" src="images/edit.png"  title="Edit" /></a></td>
    <td width="63" align="center" class="left-tdtext"><a href="manage_top_headerlogo.php?did=<?php echo $data['id'];?>&random=<?php echo $_SESSION['logtoken'];?>" class="bluelink" onClick="return confirm('Are you sure you want to delete record')"><input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a></td>
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

