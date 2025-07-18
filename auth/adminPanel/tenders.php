<?php 
   error_reporting(E_ALL);

// Display errors in the browser
ini_set('display_errors', 1);
   ob_start();
   include("../../includes/config.inc.php");
   require_once "../../includes/connection.php";
   include("../../includes/useAVclass.php");
   include("../../includes/functions.inc.php");
   include("../../includes/def_constant.inc.php");
   include_once 'ckeditor/ckeditor.php';
   include_once 'ckfinder/ckfinder.php';
   // echo include ('pdf2text.php');
   $useAVclass = new useAVclass();
   $useAVclass->connection();
   $role_id=$_SESSION['dbrole_id'];
   $user_id=$_SESSION['admin_auto_id_sess'];
   $model_id= "5";
   
   
   // $role_map=role_permission($user_id,$role_id,$model_id);
   // $role_id_page=role_permission_page($user_id,$role_id,$model_id);
	$sql         = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
	$rs          = $conn->query($sql);
	$role_module = $rs->fetch_array();
   
		$module_id   = $role_module['module_id'];
		if ($module_id == 'ALL') {
           $role_id_page = 1;
		} else {
			$cms = array(
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
   
   	if(isset($cmdsubmit) && $_GET['editid']==''){
   		$cat_id= 4;
   		$txtlanguage     = trim($_POST['txtlanguage']);
   		$txtename        = trim(str_replace("'", "\'", $_POST['txtename']));
   		$newicons        = trim($_POST['newicons']);
   		$sortcontentdesc = trim(str_replace("'", "\'", $_POST['sortcontentdesc']));
   		$txtstatus       = trim($_POST['txtstatus']);
   		$startdate1 	 = trim($_POST['startdate']);
   		$expairydate1 	 = trim($_POST['expairydate']);
   		$sta 			 = explode('-', $startdate1);
   		$startdate 		 = $sta['2'] . "-" . $sta['1'] . "-" . $sta['0'];
   		$exp 			 = explode('-', $expairydate1);
   		$expairydate 	 = $exp['2'] . "-" . $exp['1'] . "-" . $exp['0'];
   		$createdate		 = date('Y-m-d');
   		$errmsg=""; 
   		
   		if(trim($txtlanguage)==""){
   			$errmsg .="Please Select Language."."<br>";
   		}
   
   		if ($_FILES["txtuplodepdf"]["name"]==""){
   			$errmsg .= "Please Upload document."."<br>";
   		}
   		
   		if($txtlanguage=='2'){
   			if(trim($txtename)==""){
   				$errmsg .="Please enter Name."."<br>";
   			}
   			if(trim($newicons)==""){
   				$errmsg .="Please select Display New Icons."."<br>";
   			}
   			if(trim($sortcontentdesc)==""){
   				$errmsg .="Please enter Short Description."."<br>";
   			}
   			
   			if ($_FILES["txtuplodepdf"]["tmp_name"]!=""){
   		
   				$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
   				$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
   				$head = fgets(fopen($tempfile, "r"),5);
   				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
   				$nsection=substr($section,0,8);
   			
   				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) ){
   					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
   				}else if ( $section != strip_tags($section) ){
   					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   				}else{		
   					$extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
   					if(count($extarray)>2){
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}elseif($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)){
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}elseif(($nsection=="JVBERI0X") OR ($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN")){}else{
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}
   					if ($_FILES["txtuplodepdf"]["size"] < 1){
   						$errmsg .= "Document Size is too less.<br>";
   					}
   					if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5)){
   						$errmsg .= "Document Size is too big.<br>";
   					}
   				}
   			}
   
   			if(trim($startdate1)==""){
   				$errmsg .="Please enter Start Date:<br>";
   			}
   			if(trim($expairydate1)==""){
   				$errmsg .="Please enter Termination Date.<br>";
   			}
   			else if($exp['2'] < $sta['2']){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			}
   			if(trim($txtstatus)==""){
   				$errmsg .="Please Select Page Status."."<br>";
   			}
   		}
   		else{
   			if(trim($txtename)==""){
   				$errmsg .="Please enter Name."."<br>";
   			}
   			if(trim($txtename)!=""){
   				if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename)){
   					$errmsg .= "Name must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
   				}
   			}
   			
   			if(trim($newicons)==""){
   				$errmsg .="Please select Display New Icons."."<br>";
   			}
   			if(trim($sortcontentdesc)==""){
   			$errmsg .="Please enter Short Description."."<br>";
   			}
   			if(trim($sortcontentdesc)!=""){
   				 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$sortcontentdesc)){
   					$errmsg .= "Short Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
   				}
   			}
   		
   
   			if ($_FILES["txtuplodepdf"]["tmp_name"]!=""){
   				$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
   				$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
   				$head = fgets(fopen($tempfile, "r"),5);
   				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
   				$nsection=substr($section,0,8);
   				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) ){
   					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
   				}else if ( $section != strip_tags($section) ){
   					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   				}else{	
   					$extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
   					if(count($extarray)>2){
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}elseif($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)){
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}elseif(($nsection=="JVBERI0X") OR ($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN")){}else{
   							$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
   					}
   					if ($_FILES["txtuplodepdf"]["size"] < 1){
   						$errmsg .= "Document Size is too less.<br>";
   					}
   					if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5)){
   						$errmsg .= "Document Size is too big.<br>";
   					}
   				}
   			}
   		
   			if(trim($startdate1)==""){
   				$errmsg .="Please enter Start Date:<br>";
   			}
   			if(trim($expairydate1)==""){
   				$errmsg .="Please enter Termination Date.<br>";
   			}
   			else if($exp['2'] < $sta['2']){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			}
   			if(trim($txtstatus)==""){
   				$errmsg .="Please Select Page Status."."<br>";
   			}	
   		}
   		if($errmsg == ''){
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
   			
   			}

   			if ($_FILES["txtuplodepdf"]["name"]!=""){
   				$txtuplodepdf=$_FILES['txtuplodepdf']['name'];
   				$txtuplode = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplodepdf);
   				$uniq = uniqid("");
   				$txtuplodepdf=$uniq.$txtuplodepdf;		
   				$PATH="../../upload/";					
   				$PATH=$PATH."/"; 
   				$val=move_uploaded_file($_FILES["txtuplodepdf"]["tmp_name"],$PATH.$txtuplodepdf);
   				$size=filesize($PATH.$txtuplodepdf);
   				$size=ceil($size/1024);
   				$found="false";
   			}	
   			$check_status=check_status($user_id,$role_id,$txtstatus,$model_id);
   			if($check_status >0){
   				$txtstatus;
   			}
   			else{
   				$msg = "Login to Access Admin Panel";
   				$_SESSION['sess_msg'] = $msg ;
   				header("Location:error.php");
   				exit();
   			}

   	
			// $tableName_send="tender";
			//$tableFieldsName_old=array("language_id","cat_id","m_name","m_short","m_title","m_content","page_url","start_date","end_date","approve_status","admin_id","c_new_status","image_file","create_date","docs_file","ext_url","content_type","more_photo","m_keyword","m_description");
			// $tableFieldsValues_send=array();
			// $value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
			// $page_id=mysql_insert_id();
   			
if (empty($texttype)) {
    $texttype = 0; // Set a default value (e.g., 0)
}
if (empty($addphoto)) {
    $addphoto = 0; // Set default value if empty (e.g., 0 for no more photos)
}
			$sql15 = "INSERT INTO `tender`(`language_id`, `cat_id`, `m_name`, `m_short`, `m_title`, `m_content`, `page_url`, `start_date`, `end_date`, `approve_status`, `admin_id`,`c_new_status`,`image_file`,`create_date`,`docs_file`,`ext_url`,`content_type`,`more_photo`,`m_keyword`,`m_description`)VALUES('$txtlanguage','$cat_id','$txtename','$sortcontentdesc','$m_title','$txtcontentdesc','$url','$startdate','$expairydate','$txtstatus','$user_id','$newicons','$image_file','$createdate','$txtuplodepdf','$txtweblink','$texttype','$addphoto','$txtekeyword','$txtmeta_description')";
			$result5 = $conn->query($sql15);
			$page_id = $conn->insert_id;

   			if($txtstatus=='3'){
        //$minister_name="nulll";
        //$minister_thumb="nulll";
				$sql="INSERT INTO tender_publish (m_publish_id,language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description)
				SELECT m_id, language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description
				FROM tender WHERE m_id=$page_id";
				$result1 = $conn->query($sql);
   			}
   			$user_id=$_SESSION['admin_auto_id_sess'];
   			$page_id = $conn->insert_id;
   			$action="Insert";
   			$categoryid='1'; 
   			$date=date("Y-m-d h:i:s");
   			$ip=$_SERVER['REMOTE_ADDR'];
		
   			// $tableName="audit_trail";
			//$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			//$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
			// $value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
		//	$sql51 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";

   			//$sql21 = $conn->query($sql51);
   			$msg = 'Tender has been added successfully';
			$_SESSION['content']=$msg;
   			header("location:manage_tenders.php");
   			exit;	
   		}
   	}
   
   	if(isset($cmdsubmit) && $_GET['editid']!=''){
   		$cat_id= 4;
   		$cid                 = $_GET['editid'];
   		$txtlanguage         = Trim($_POST['txtlanguage']);
   		$txtename            = trim(str_replace("'", "\'", $_POST['txtename']));
   		$create_version      = Trim($_POST['create_version']);
   		$newicons            = Trim($_POST['newicons']);
   		$sortcontentdesc     = trim(str_replace("'", "\'", $_POST['sortcontentdesc']));
   		$addphoto            = Trim($_POST['addphoto']);
   		$texttype            = Trim($_POST['texttype']);
   		$txtekeyword         = trim(str_replace("'", "\'", $_POST['txtekeyword']));
   		$txtmeta_description = trim(str_replace("'", "\'", $_POST['txtmeta_description']));
		//$txtcontentdesc      = trim(str_replace("'", "\'", $_POST['txtcontentdesc']));
		if($txtlanguage!='2'){
			$txtcontentdesc	= htmlentities(stripslashes(utf8_encode($_POST['txtcontentdesc'])), ENT_QUOTES); 	
		}else{
			$txtcontentdesc		= $_POST['txtcontentdesc'];
		}
		
   		$txtweblink          = Trim($_POST['txtweblink']);
   		$txtstatus           = Trim($_POST['txtstatus']);
   		$m_title1            = Trim($_POST['page_url']);
   		
   		$url                 = seo_url($page_url);
   	
   		$startdate1          = Trim($_POST['startdate']);
   		$expairydate1        = Trim($_POST['expairydate']);
   		$sta                 = explode('-', $startdate1);
   		$startdate           = $sta['2'] . "-" . $sta['1'] . "-" . $sta['0'];
   		$exp                 = explode('-', $expairydate1);
   		$expairydate         = $exp['2'] . "-" . $exp['1'] . "-" . $exp['0'];
   		$createdate          = date('Y-m-d');
   		$update_date         = date('Y-m-d h:i:s');
   		$errmsg=""; 
   		if(trim($txtlanguage)==""){
   			$errmsg .="Please Select Language."."<br>";
   		}
    
   		if($txtlanguage=='2'){
   			if(trim($txtename)==""){
   				$errmsg .="Please enter Name."."<br>";
   			}	
   			if(trim($newicons)==""){
   				$errmsg .="Please select Display New Icons."."<br>";
   			}
   			if(trim($sortcontentdesc)==""){
   			$errmsg .="Please enter Short Description."."<br>";
   			}
   			if ($_FILES["txtuplodepdf"]["tmp_name"]!=""){
   				$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
   				$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
   				$head = fgets(fopen($tempfile, "r"),5);
   				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
   				$nsection=substr($section,0,8);
   				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) ){
   					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
   				}else if ( $section != strip_tags($section) ){
   					$errmsg .= 'Sorry, we accept PDF files only';
   				}else{
   				   $extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
   					if(count($extarray)>2){
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}elseif($imageinfo != 'application/pdf'){
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}else if($head != "%PDF"){
   						$errmsg .= 'Sorry,we accept PDF files only';
   					}elseif($nsection=="JVBERI0X"){}else{
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}
   					if ($_FILES["txtuplodepdf"]["size"] < 1){
   					   $errmsg .= "Image Size is too less.<br>";
   					}
   					if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5)){
   					   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
   					}
   				}
   			}
   			
   			if(trim($startdate1)==""){
   				$errmsg .="Please enter Start Date:<br>";
   			}
   			if(trim($expairydate1)==""){
   				$errmsg .="Please enter Termination Date.<br>";
   			}
   			else if($exp['2'] < $sta['2']){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			}
   			if(trim($txtstatus)==""){
   				$errmsg .="Please Select Page Status."."<br>";
   			}
   		}
   		else
   		{
   			if(trim($txtename)=="")
   			{
   				$errmsg .="Please enter Name."."<br>";
   			}
   			if(trim($txtename)!=""){
   				 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename)){
   					$errmsg .= "Name  must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
   				}
   			}
   
   			if(trim($sortcontentdesc)==""){
   				$errmsg .="Please enter Short Description."."<br>";
   			}
   			if(trim($sortcontentdesc)!=""){
   				if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$sortcontentdesc)){
   					$errmsg .= "Short Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
   				}
   			}
   	
   			if($_FILES["txtuplodepdf"]["tmp_name"]!=""){
   				$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
   				$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
   				$head = fgets(fopen($tempfile, "r"),5);
   				$section = strtoupper(base64_encode(file_get_contents($tempfile)));
   				$nsection=substr($section,0,8);
   	
   				if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) ){
   					$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
   				}else if ( $section != strip_tags($section) ){
   					$errmsg .= 'Sorry, we accept PDF files only';
   				}else{
   					$extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
   					if(count($extarray)>2){
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}elseif($imageinfo != 'application/pdf'){
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}else if($head != "%PDF"){
   						$errmsg .= 'Sorry,we accept PDF files only';
   					}elseif($nsection=="JVBERI0X"){}else{
   						$errmsg .= 'Sorry, we accept PDF files only';
   					}
   					if ($_FILES["txtuplodepdf"]["size"] < 1){
   					   $errmsg .= "Image Size is too less.<br>";
   					}
   					if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5)){
   					   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
   					}   
   				}
   			}
   	
   			if(trim($startdate1)==""){
   				$errmsg .="Please enter Start Date:<br>";
   			}
   			if(trim($expairydate1)==""){
   				$errmsg .="Please enter Termination Date.<br>";
   			}
   			else if($exp['2'] < $sta['2']){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			} 
   			else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])){
   				$errmsg .="Please enter Start Date less then Termination Date.<br>";
   			}
   			if(trim($txtstatus)==""){
   				$errmsg .="Please Select Page Status."."<br>";
   			}
   		}
   		
   		
   		if($errmsg == ''){
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
   			}
   			if ($_FILES["txtuplode"]["name"]!=""){
   				
   				$sql = "select docs_file FROM tender WHERE m_id=$cid";
   				$rs  = $conn->query($sql);
   				$row = $rs->fetch_array();
   				
   				$image_path = "../../upload/".$row['docs_file'];
   				unlink($image_path);
   	   
   				/*if ($_FILES["txtuplode"]["size"] < 500000)
   				{*/
   				$txtuplodepdf=$_FILES['txtuplode']['name'];
   				$uniq = uniqid("");
   				$txtuplodepdf=$uniq.$txtuplodepdf;		
   				$PATH="../../upload/";					
   				$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplodepdf);
   				$size=filesize($PATH.$txtuplodepdf);
   				$size=ceil($size/1024);
   				$found="false";
   				$txtuplodepdf=addslashes($txtuplodepdf); 
   				$whereclause="m_id=$cid";
   				$tableName_send="tender";
   				$old =array("docs_file");
   				$new =array("$txtuplodepdf");
   				//$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
   				$sql1 = "UPDATE `tender` SET `docs_file`='$txtuplodepdf' WHERE `m_id`=$cid";
   				$result = $conn->query($sql1);
   			}	
	
   			$check_status=check_status($user_id,$role_id,$txtstatus,$model_id);
   			if($check_status >0){
   				$txtstatus;
   			}
   			else{
   				$msg = "Login to Access Admin Panel";
   				$_SESSION['sess_msg'] = $msg ;
   				header("Location:error.php");
   				exit();
   			}
   			$create_date=date('y-m-d');
   			$whereclause="m_id=$cid";
   			// $tableName_send="tender";
   			// $old=array("language_id","cat_id","m_name","m_short","m_title","m_content","page_url","start_date","end_date","approve_status","admin_id","c_new_status","create_date","ext_url","content_type","more_photo","m_keyword","m_description","update_date");
   			// $new=array("$txtlanguage","$cat_id","$txtename","$sortcontentdesc","$m_title1","$txtcontentdesc","$url","$startdate","$expairydate","$txtstatus","$user_id","$newicons","$create_date","$txtweblink","$texttype","$addphoto","$txtekeyword","$txtmeta_description","$update_date");
   			// $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
   			error_reporting(E_ALL);

// Display errors in the browser
ini_set('display_errors', 1);
if (empty($texttype)) {
    $texttype = 0; // Set a default value (e.g., 0)
}
if (empty($addphoto)) {
    $addphoto = 0; // Set default value if empty (e.g., 0 for no more photos)
}
   			$sql1 = "UPDATE `tender` SET `language_id`='$txtlanguage',`cat_id`='$cat_id',`m_name`='$txtename',`m_short`='$sortcontentdesc',`m_title`='$m_title1',`m_content`='$txtcontentdesc',`page_url`='$url',`start_date`='$startdate',`end_date`='$expairydate',`approve_status`='$txtstatus',`admin_id`='$user_id',`c_new_status`='$newicons',`create_date`='$create_date',`ext_url`='$txtweblink',`content_type`='$texttype',`more_photo`='$addphoto',`m_keyword`='$txtekeyword',`m_description`='$txtmeta_description',`update_date`='$update_date' WHERE `m_id`=$cid";
   			$result = $conn->query($sql1);
   			
   			if($txtstatus=='3'){
   				$tableName_send="tender_publish";
   				$whereclause="where m_publish_id='$cid'";
   				$sql="Select * from tender_publish $whereclause";
   				$results = $conn->query($sql);
   				$row = $results->num_rows; 
   
   				if($row >0){
   					 $update="UPDATE tender_publish,tender SET tender_publish.m_publish_id = tender.m_id,tender_publish.language_id = tender.language_id,tender_publish.cat_id = tender.cat_id,tender_publish.m_name = tender.m_name,tender_publish.m_short = tender.m_short,tender_publish.m_title = tender.m_title,tender_publish.m_content = tender.m_content,tender_publish.page_url = tender.page_url,tender_publish.start_date = tender.start_date,tender_publish.end_date = tender.end_date,tender_publish.approve_status = tender.approve_status,tender_publish.admin_id = tender.admin_id,tender_publish.c_new_status = tender.c_new_status,tender_publish.create_date = tender.create_date,tender_publish.image_file = tender.image_file,tender_publish.docs_file = tender.docs_file,tender_publish.ext_url = tender.ext_url,tender_publish.content_type = tender.content_type,tender_publish.more_photo = tender.more_photo,tender_publish.m_keyword = tender.m_keyword,tender_publish.m_description = tender.m_description,tender_publish.update_date = tender.update_date WHERE tender_publish.m_publish_id =tender.m_id and tender.m_id=$cid";
   					  $results = $conn->query($update);
   				}else {
   					$sql="INSERT INTO tender_publish (m_publish_id,language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,update_date)
   					SELECT m_id, language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,update_date
   					FROM tender WHERE m_id=$cid";
   					$resultsq = $conn->query($sql);
   				}
   			}
   			$user_id=$_SESSION['admin_auto_id_sess'];
   			$page_id = $conn->insert_id;
   			$action="Insert";
   			$categoryid='1'; 
   			$date=date("Y-m-d h:i:s");
   			$ip=$_SERVER['REMOTE_ADDR'];
   			// $tableName="audit_trail";
   			// $tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
   			// $tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
   			// $value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
   			
   			//$sql5 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
			
   			//$sql21 = $conn->query($sql5);
   			$msg='Tender has been Updated Successfully';
   			$_SESSION['content']=$msg;
   			header("location:manage_tenders.php");
   			exit;	
   		}
   	}
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Manage Tenders add/update: <?php echo $sitename; ?></title>
      <!-- admin css  -->
      <link href="style/admin.css" rel="stylesheet" type="text/css">
      <!-- Ckeditor js  -->
      <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
      <!-- start Calender js and css  -->
      <script type="text/javascript" src="js/jsDatePick.js"></script>
      <link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript">
         window.onload = function(){
         	new JsDatePick({
         		useMode:2,
         		target:"startdate",
         		dateFormat:"%d-%m-%Y",
         		limitToToday:false
         	});
         	new JsDatePick({
         		useMode:2,
         		target:"expairydate",
         		dateFormat:"%d-%m-%Y",
         		limitToToday:false
         	});
         };
         
         
      </script>
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
                  <span class="submenuclass"><a href="manage_tenders.php" title="Manage Tenders">Manage Tenders</a></span>
                  <span class="submenuclass">>> </span> 
                  <span class="submenuclass">Add/Update Tenders</span>
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
                     <h3 class="manageuser">Add/Update Tenders</h3>
                     <div class="right-section">
                     </div>
                  </div>
                  <div class="grid_view">
                     <form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
                        <?php	
                           if($_GET['editid']!=''){	
                           	$sqlimg = "select * from tender where 	m_id='".$_GET['editid']."'";
                           	$rq  = $conn->query($sqlimg);
                           	$rr	 = $rq->fetch_array();
                           }
                           	
                           
                           ?>   
                        <div class="frm_row">
                           <span class="label1">
                           <label for="txtlanguage">Page Language :</label>
                           <span class="star">*</span></span> <span class="input1">
                           <input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if($rr['language_id']=='1'){ echo 'checked'; } ?> id="txtlanguage" />English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if($rr['language_id']=='2'){ echo 'checked'; } ?>/>Hindi 
                           </span>
                           <div class="clear"></div>
                           <div class="loading"></div>
                        </div>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="txtename">Name:</label>
                           <span class="star">*</span></span> <span class="input1">
                           <input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php if($txtename!=""){ echo $txtename;} echo $rr['m_name']; ?>"/>
                           </span>
                           <div class="clear"></div>
                        </div>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="newicons">Display New Icons :</label>
                           <span class="star">*</span></span> <span class="input1">
                           <input type="radio" name="newicons" id="newicons" autocomplete="off"  value="1" <?php if($rr['c_new_status']=='1'){ echo 'checked';} else ?> checked="checked" />Yes &nbsp;<input type="radio" name="newicons" autocomplete="off" value="2" <?php if($rr['c_new_status']=='2'){ echo 'checked'; } ?>/>No 
                           </span>
                           <div class="clear"></div>
                           <div class="loading"></div>
                        </div>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="sortcontentdesc">Short Description: </label>
                           <span class="star">*</span></span> 
                           <span class="input1">
                              <textarea rows="2" cols="35" name="sortcontentdesc" autocomplete="off"  id="sortcontentdesc" onkeyup="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" onkeypress="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" onmouseout="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" tabindex="1" ><?php if($sortcontentdesc!=""){ echo $sortcontentdesc;} echo $rr['m_short']; ?>
</textarea>
                              <label style="float:right; margin-right:30px;" class="free" for="textarea_field">
                                 <script type="text/javascript">
                                    document.write("&nbsp;&nbsp;&nbsp;<input type='text' name='msg_left' id='msg_left' style='text-align:right;' size='3' value='150' readonly='readonly' /> left of 150 characters maximum.");
                                 </script>
                                 <noscript>(text limited to 150 characters)</noscript>
                              </label>
                           </span>
                           <div class="clear"></div>
                        </div>
                        <?php if($_GET['editid']!=''){ ?>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="txtuplodepdf">Document Upload :</label>
                           <span class="star"></span></span> <span class="input1">
                           <input type="file" name="txtuplode" /><?php echo $rr['docs_file'];?>
                           </span>
                           <div class="clear"></div>
                        </div>
                        <?php } else{?>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="txtuplodepdf">Document Upload :</label>
                           <span class="star">*</span></span> <span class="input1">
                           <input type="file" name="txtuplodepdf" id="txtuplodepdf"/>
                           </span>
                           <div class="clear"></div>
                        </div>
                        <?php } ?>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="startdate">Start Date:</label><span class="star">*</span>
                           </span> <span class="input1">
                           <input type="text" name="startdate" id="startdate" readonly="readonly"  autocomplete="off" value="<?php if($rr['start_date'] !=''){ echo changeformate($rr['start_date']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 
                           </span>
                           <div class="clear"></div>
                        </div>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="expairydate">Termination Date:</label><span class="star">*</span>
                           </span> <span class="input1">
                           <input type="text" name="expairydate" autocomplete="off" readonly="readonly"  id="expairydate" value="<?php if($rr['end_date'] !=''){  echo changeformate($rr['end_date']); }else {}
                              ?>"/><span class="date">[dd-mm-yyyy]</span> 
                           </span>
                           <div class="clear"></div>
                        </div>
                        <div class="frm_row">
                           <span class="label1">
                           <label for="txtstatus">Page Status:</label>
                           <span class="star">*</span></span> 
                           <span class="input1">
                              <select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
                                 <option value=""> Select </option>
                                 <?php 
                                    if($user_id =='101')
                                    {
                                    $sql="select * from content_state where state_status=1";
                                    $result  = $conn->query($sql);
                                    while($row=$result->fetch_array())
                                    { 
                                    ?>
                                 <option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
                                 <?php }
                                    }
                                    else if($user_id !='101' )
                                    {
                                    $sql21="select * from content_state";
                                    $result1  = $conn->query($sql21);
                                    while($row=$result1->fetch_array())
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
                        <div class="frm_row">
                           <span class="button_row">
                              <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="<?php if($_GET['editid']!='') { echo 'Update';} else { echo'Submit';}?>" />&nbsp;
                              <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
                              <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
                              <input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_circular_events.php';" />
                           </span>
                           <div class="clear"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- right col -->
            <div class="clear"></div>
            <!-- Content Area end -->
         </div>
         <!-- area div-->
      </div>
      <!-- main con-->
      </div> <!-- Container div-->
      <!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
   </body>
</html>
<!--left of 150 characters maximum-->
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