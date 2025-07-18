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
$model_id= "3";
// $role_map=role_permission($user_id,$role_id,$model_id);
// $role_id_page=role_permission_page($user_id,$role_id,$model_id);
 
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
if(isset($cmdsubmit) && $_GET['editid']=='')
{
$txtlanguage= check_input($_POST['txtlanguage']);
$advertisementno = check_input($_POST['advertisementno']);
$advertisementdesc= check_input($_POST['advertisementdesc']);
//$postappliedid= check_input($_POST['postappliedid']);
$lastdate1 = check_input($_POST['lastdate']);
$expairytime = check_input($_POST['expairytime']);
$lastd = split('-', $lastdate1);
$lastdate = $lastd['2'] . "-" . $lastd['1'] . "-" . $lastd['0'];
$paymentmode = check_input($_POST['paymentmode']);
$txtstatus=check_input($_POST['txtstatus']);
//$url=seo_url($txtename);
$createdate=date('Y-m-d');
$errmsg=""; 
	if(trim($txtlanguage)=="")
	{
	$errmsg .="Please Select Language."."<br>";
	}
if($txtlanguage=='2')
{
	
		if(trim($advertisementno)=="")
		{
			$errmsg .="Please enter advertisement no."."<br>";
		}
		if(trim($advertisementdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		if(trim(empty($_POST["postappliedid"])))
		{
		$errmsg .="Please select atleast one Post Applied For."."<br>";
		}
		
		if(trim($lastdate1)=="")
		{
			$errmsg .="Please enter Last Apply Date:<br>";
		}

		// if ($_FILES["txtuplode"]["name"] != "")
		// {
		// $tempfile=($_FILES["txtuplode"]["tmp_name"]);
		// $imageinfo = ($_FILES["txtuplode"]["type"]);
		// $section = strtoupper(base64_encode(file_get_contents($tempfile)));
		//  $nsection=substr($section,0,8);
	
		// $imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

		// //if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
		// //{
		// 	//$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
		// //}

		// /*if(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH"))
		// {}
		// else
		// {
		// 		$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
		// }*/
		// 	if ($_FILES["txtuplode"]["size"] >=1048576)
		// 	{
		// 	$errmsg .= IMAGE_SIZE_LIMIT."<br>";
		// 	}
		// }	

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






		if(trim($txtstatus)=="")
		{
			$errmsg .="Please Select Page Status."."<br>";
		}
}
else
{
		if(trim($advertisementno)=="")
		{
			$errmsg .="Please enter advertisement no."."<br>";
		}
		if(trim($advertisementdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		if(trim(empty($_POST["postappliedid"])))
		{
		$errmsg .="Please select atleast one Post Applied For."."<br>";
		}
		
		if(trim($lastdate1)=="")
		{
			$errmsg .="Please enter Last Apply Date:<br>";
		}

	// 	if ($_FILES["txtuplode"]["name"] != "")
	//  {
	// 	$tempfile=($_FILES["txtuplode"]["tmp_name"]);
	// 	$imageinfo = ($_FILES["txtuplode"]["type"]);
	// 	$section = strtoupper(base64_encode(file_get_contents($tempfile)));
	// 	 $nsection=substr($section,0,8);
	
	// 	$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

	// 	//if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
	// 	//{
	// 	//	$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
	// 	//}

	// 	if ($_FILES["txtuplode"]["size"] >=1048576)
	// 		{
	// 		$errmsg .= IMAGE_SIZE_LIMIT."<br>";
	// 		}
	// 	}	


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
		
		if (trim($txtstatus) == "") {
		$errmsg .="Please select page status." . "<br>";
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

			
 if ($_FILES["txtuplode"]["name"] != "")
	 {
			//if($_FILES["txtuplode"]["type"] == "image/jpeg" || $_FILES["txtuplode".$i]["type"] == "image/pjpeg" || $_FILES["txtuplode".$i]["type".$i] == "image/gif" || $_FILES["txtuplode".$i]["type".$i] == "image/bmp" || $_FILES["txtuplode".$i]["type".$i] == "image/png"){	
			//$image_source = imagecreatefromjpeg($_FILES["txtuplode".$i]["tmp_name"]);
			//}		
			
			$filename1 = $_FILES['txtuplode'.$i]['name'];
			$filename1 = preg_replace("/[^a-zA-Z0-9.]/", "", $filename1);
			$uniq = uniqid("");
			$filename1 = $uniq . $filename1;
			$PATH = "../../upload/advertise";
			$PATH1="../../upload/advertise/thumb";
			if(!is_dir($PATH)){  
			mkdir($PATH,0775);
			}
			$PATH=$PATH."/";

			if(!is_dir($PATH1)){  
			mkdir($PATH1,0775);
			}
			$PATH1=$PATH1."/";

			$remote_file = $PATH.$filename1;
			$val = move_uploaded_file($_FILES["txtuplode".$i]["tmp_name"], $PATH . $filename1);
			$size = filesize($PATH . $filename1);
			$size = ceil($size / 1024);
			$found = "false";
			list($image_width, $image_height) = getimagesize($remote_file);
		if($image_width>$max_upload_width || $image_height >$max_upload_height)
		{
				 $proportions = $image_width/$image_height;
			if($image_width>$image_height)
			{
			
				  $new_width = $max_upload_width;
			      $new_height = $max_upload_height;
				/*echo $new_height = round($max_upload_width/$proportions);
				echo $new_width = round($max_upload_height*$proportions);*/
			}		
			else
			{
			   $new_width = $max_upload_width;
				 $new_height = $max_upload_height;
				/*echo $new_width = round($max_upload_height*$proportions);
				echo $new_height = round($max_upload_width/$proportions);*/
			}
			
			$new_image = imagecreatetruecolor($new_width , $new_height);
			$image_source = imagecreatefromjpeg($remote_file);
			
			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image,$remote_file,100);
			
			imagedestroy($new_image);
		}
			imagedestroy($image_source);
			$add_img='../../upload/advertise/'.$filename1;
			$add_thumb='../../upload/advertise/thumb/'.$filename1;
			generate_image_thumbnail($add_img,$add_thumb);
		}
		$image_file=$filename1;
	 
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
		
$create_date=date('y-m-d');
$tableName_send="advertisement_mst";
$tableFieldsName_old=array("language_id","advertisementno","advertisementdesc","postappliedid","lastdate","expairytime","advertisedoc","paymentmode","txtstatus","create_date");
$tableFieldsValues_send=array("$txtlanguage","$advertisementno","$advertisementdesc","$postappliedid","$lastdate","$expairytime","$image_file","$paymentmode","$txtstatus","$create_date");
$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
$page_id=mysql_insert_id();


$total_post=count($_POST['postappliedid']);

   for($at=0;$at<$total_post;$at++)  
     {
			
		$postapplied_in=$postappliedid[$at];                  // post title
		
		$sqlInsertI1="insert into advertisement_postapplied  (post_id,postappliedid) values('".htmlentities($postapplied_in, ENT_QUOTES)."','".$page_id."')";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());
		
			
	 }

		$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id=mysql_insert_id();
		$action="Insert";
		$categoryid='1'; 
		$txtename="Advertisement";
		$txtepage_title="Advertisement";
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
	$msg=CONTENTADD;
$_SESSION['content']=$msg;
header("location:manage_advertisement.php");
exit;	
}
}
if(isset($cmdsubmit) && $_GET['editid']!='')
{
$cid=$_GET['editid'];
$txtlanguage= check_input($_POST['txtlanguage']);
$advertisementno = check_input($_POST['advertisementno']);
$advertisementdesc= check_input($_POST['advertisementdesc']);
//$postappliedid= check_input($_POST['postappliedid']);
$lastdate1 = check_input($_POST['lastdate']);
$lastd = split('-', $lastdate1);
$lastdate = $lastd['2'] . "-" . $lastd['1'] . "-" . $lastd['0'];
$expairytime = check_input($_POST['expairytime']);
$paymentmode = check_input($_POST['paymentmode']);
$txtstatus=check_input($_POST['txtstatus']);
$createdate=date('Y-m-d');
	$update_date=date('Y-m-d h:i:s');
$errmsg=""; 
if(trim($txtlanguage)=="")
		{
		$errmsg .="Please Select Language."."<br>";
}
 
if($txtlanguage=='2')
{
	
		if(trim($advertisementno)=="")
		{
			$errmsg .="Please enter Advertisement No."."<br>";
		}
		if(trim($advertisementdesc)=="")
		{
		$errmsg .="Please enter Advertisement Description."."<br>";
		}
		
		if(trim(empty($_POST["postappliedid"])))
		{
		$errmsg .="Please select atleast one Post Applied For."."<br>";
		}
		
		if(trim($lastdate1)=="")
		{
			$errmsg .="Please enter Last Apply Date.<br>";
		}

		// if ($_FILES["txtuplode"]["name"] != "")
		// {
		// if ($_FILES["txtuplode"]["size"] >=1048576)
		// {
		// $errmsg .= IMAGE_SIZE_LIMIT."<br>";
		// }
		// }	


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


		if(trim($txtstatus)=="")
		{
			$errmsg .="Please Select Page Status."."<br>";
		}
}
else
{
if(trim($advertisementno)=="")
		{
			$errmsg .="Please enter Advertisement No."."<br>";
		}
		if(trim($advertisementdesc)=="")
		{
		$errmsg .="Please enter Advertisement Description."."<br>";
		}
		
		if(trim(empty($_POST["postappliedid"])))
		{
		$errmsg .="Please select atleast one Post Applied For."."<br>";
		}
		
		if(trim($lastdate1)=="")
		{
			$errmsg .="Please enter Last Apply Date.<br>";
		}

// 		if ($_FILES["txtuplode"]["name"] != "")
// 		{
// 		$tempfile=($_FILES["txtuplode"]["tmp_name"]);
// 		$imageinfo = ($_FILES["txtuplode"]["type"]);
// 		$section = strtoupper(base64_encode(file_get_contents($tempfile)));
// 		 $nsection=substr($section,0,8);
	
// 		$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

// 		//if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
// 		//{
// 		//	$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
// //}

// 		/*if(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH"))
// 		{}
// 		else
// 		{
// 				$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
// 		}*/
// 		if ($_FILES["txtuplode"]["size"] >=1048576)
// 		{
// 		$errmsg .= IMAGE_SIZE_LIMIT."<br>";
// 		}
// 		}	

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

		if (trim($txtstatus) == "") {
		$errmsg .="Please select page status." . "<br>";
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
 if ($_FILES["txtuplode"]["name"] != "")
	 {
			//if($_FILES["txtuplode".$i]["type"] == "image/jpeg" || $_FILES["txtuplode".$i]["type"] == "image/pjpeg" || $_FILES["txtuplode".$i]["type".$i] == "image/gif" || $_FILES["txtuplode".$i]["type".$i] == "image/bmp" || $_FILES["txtuplode".$i]["type".$i] == "image/png"){
				
			//$image_source = imagecreatefromjpeg($_FILES["txtuplode".$i]["tmp_name"]);
			//}	
			  $sql = "select image_file FROM latest_news WHERE m_id=$cid";
    $rs = mysql_query($sql);
	$row=mysql_fetch_array($rs);

    $image_path = "../../upload/advertise/".$row['image_file'];
    $image_path2 = "../../upload/advertise/thumb/".$row['image_file'];
    unlink($image_path);
    unlink($image_path2);	
			
			$filename1 = $_FILES['txtuplode'.$i]['name'];
			$filename1 = preg_replace("/[^a-zA-Z0-9.]/", "", $filename1);
			$uniq = uniqid("");
			$filename1 = $uniq . $filename1;
			$PATH = "../../upload/advertise";
			$PATH1="../../upload/advertise/thumb";
			if(!is_dir($PATH)){  
			mkdir($PATH,0775);
			}
			$PATH=$PATH."/";

			if(!is_dir($PATH1)){  
			mkdir($PATH1,0775);
			}
			$PATH1=$PATH1."/";

			$remote_file = $PATH.$filename1;
			$val = move_uploaded_file($_FILES["txtuplode".$i]["tmp_name"], $PATH . $filename1);
			$size = filesize($PATH . $filename1);
			$size = ceil($size / 1024);
			$found = "false";
			list($image_width, $image_height) = getimagesize($remote_file);
		if($image_width>$max_upload_width || $image_height >$max_upload_height)
		{
				 $proportions = $image_width/$image_height;
			if($image_width>$image_height)
			{
			
				  $new_width = $max_upload_width;
			 $new_height = $max_upload_height;
				/*echo $new_height = round($max_upload_width/$proportions);
				echo $new_width = round($max_upload_height*$proportions);*/
			}		
			else
			{
			   $new_width = $max_upload_width;
				 $new_height = $max_upload_height;
				/*echo $new_width = round($max_upload_height*$proportions);
				echo $new_height = round($max_upload_width/$proportions);*/
			}		
			$new_image = imagecreatetruecolor($new_width , $new_height);
			$image_source = imagecreatefromjpeg($remote_file);
			
			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image,$remote_file,100);
			
			imagedestroy($new_image);
		}
			imagedestroy($image_source);
			$add_img='../../upload/advertise/'.$filename1;
			$add_thumb='../../upload/advertise/thumb/'.$filename1;
			generate_image_thumbnail($add_img,$add_thumb);

				$filename1=addslashes($filename1);
	$tableName_send="advertisement_mst";
	$whereclause="advertiseid=$cid";
	$old =array("advertisedoc");
	$new =array("$filename1");
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
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
$create_date=date('y-m-d');
	$whereclause="advertiseid=$cid";
$tableName_send="advertisement_mst";
$old=array("language_id","advertisementno","advertisementdesc","postappliedid","lastdate","expairytime","paymentmode","txtstatus","create_date","update_date");
$new=array("$txtlanguage","$advertisementno","$advertisementdesc","$postappliedid","$lastdate","$expairytime","$paymentmode","$txtstatus","$create_date","$update_date");
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);

$user_login_id=$cid;
$page_id=$cid;

$sqldel="delete from advertisement_postapplied where postappliedid='".$cid."'";
$resdel=mysql_query($sqldel) or die(mysql_error());
	
	$total_post=count($_POST['postappliedid']);

   for($at=0;$at<$total_post;$at++)  
     {
			
		$postapplied_in=$postappliedid[$at];                  // post title
		
		$sqlInsertI1="insert into advertisement_postapplied  (post_id,postappliedid) values('".htmlentities($postapplied_in, ENT_QUOTES)."','".$cid."')";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());
		
			
	 }
	
	
		$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id=mysql_insert_id();
		$action="Update";
		$categoryid='1'; 
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$txtename="Advertisement";
		$txtepage_title="Advertisement";
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
	$msg=CONTENTADD;
$_SESSION['content']=$msg;
header("location:manage_advertisement.php");
exit;	
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Advertisement add/update: <?=$sitename; ?> </title>
<!-- admin css  -->
<link href="style/admin.css" rel="stylesheet" type="text/css">
<!-- Ckeditor js  -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<!-- start Calender js and css  -->
 <script type="text/javascript" src="js/jsDatePick.js"></script>
 	<script language="JavaScript" src="js/validation.js"></script>
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"lastdate",
		dateFormat:"%d-%m-%Y"
	});
	new JsDatePick({
		useMode:2,
		target:"expairydate",
		dateFormat:"%d-%m-%Y"
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
			<span class="submenuclass"><a href="manage_advertisement.php" title="Manage What's New">Manage Advertisement</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add/Update Advertisement</span>
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
 <h3 class="manageuser">Add/Update Advertisement</h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	   if($_GET['editid']!='')
	   {
		$rq = mysql_query("select * from advertisement_mst where advertiseid='".$_GET['editid']."'");
		$rr = mysql_fetch_array($rq);
	   }
	?>   
<div class="frm_row"> <span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if($rr['language_id']=='1'){ echo 'checked'; } ?> id="txtlanguage" />English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if($rr['language_id']=='2'){ echo 'checked'; } ?>/>Hindi 
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
			<div class="frm_row"> <span class="label1">
				<label for="advertisementno">Advertise No:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="advertisementno" autocomplete="off" type="text" class="input_class" id="advertisementno" size="30"   value="<?php echo $rr['advertisementno']; ?>"/>
				
				</span>
				<div class="clear"></div>
			</div>
			
			<div class="frm_row"> <span class="label1">
        <label for="advertisementdesc">Advertise Description :</label>
        <span class="star">*</span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('advertisementdesc',stripslashes(html_entity_decode($rr['advertisementdesc'])));
		?>        </span>
        <div class="clear"></div>
        </div>	
		
		<div class="frm_row"> <span class="label1">
              <label for="postappliedid">Post applied for:</label>
              <span class="star">*</span></span> <span class="input1">
			 
			 <?php
			  $sqlpos_qual12="select * from advertisement_postapplied where postappliedid='".$_GET['editid']."'";		 
	$respos_qual12 = $conn->query($sqlpos_qual12);
	while($rowpos_qual12 = $respos_qual12->fetch_array())
	{
	  $PostIDArr[] = $rowpos_qual12['post_id']; 
	}
		echo "<pre>"; print_r($PostIDArr);	 
			 
  echo	$sqlqual="select * from post_mst where approve_status='1' order by post_id desc";
	$resqual=$conn->query($sqlqual);	
 ?>
  <select name="postappliedid[]" id="postappliedid" multiple="multiple" size=30 style='height: 350px; width:40%;'>
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=$resqual->fetch_array()){
	
		
		?>
    <option value="<?php echo $rowqual['post_id'] ;?>"<?php  if (in_array($rowqual['post_id'], $PostIDArr))
  {
  echo "selected";
  } ?>><?php echo $rowqual['postname'] ;?></option>
    <?php } ?>
  </select>
              </span>
		   <div class="clear"></div>
	   </div>
	   
	   <div class="frm_row"> <span class="label1">
                                                        <label for="lastdate">Last Date to apply:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="lastdate" id="lastdate" readonly="readonly"  autocomplete="off" value="<?php if($rr['lastdate'] !=''){ echo changeformate($rr['lastdate']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <label> Time:</label>
                                                    <span class="input1">
                                                        <input type="time" name="expairytime" autocomplete="off"  value="<?php if($_REQUEST['expairytime'] !=''){  echo $_REQUEST['expairytime']; }else {}
                                                               
                                                           ?>"/><span class="time">[H:M AM]</span> 

                                                    </span>
                                                    <div class="clear"></div>
            </div> 
		
			
            <div class="frm_row"> <span class="label1">
            <label for="txtuplode">Upload Supporting Document :</label>
            </span> <span class="input1">
           <input type="file" name="txtuplode" id="txtuplode"/><?php if($rr['advertisedoc'] !='') {?>
		   <img src="../../upload/advertise/thumb/<?php echo $rr['advertisedoc'];?>" alt="" title="" align="center" width="80" height="90" />
		   <?php }?> 
            </span>
            <div class="clear"></div>
            </div>
			
			<!--<div class="frm_row"><span class="label1">
              <label for="paymentmode">Payment Mode :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="paymentmode" id="paymentmode" autocomplete="off"  value="1" <?php if($rr['paymentmode']=='1'){ echo 'checked';} else ?> checked="checked" />Online
 
			  &nbsp;<input type="radio" name="paymentmode" autocomplete="off" value="2" <?php if($rr['paymentmode']=='2'){ echo 'checked'; } ?>/>Offline
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
           </div>-->
	
           
	     <div class="frm_row"> 
			<span class="label1">
			<label for="txtstatus">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
			
			 <option value="1">Active</option>
             <option value="0">In Active</option>
			</select>
			</span>
			<div class="clear"></div>
		</div>
			<div class="clear"></div>

            <div class="frm_row"> <span class="button_row">
            <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="<?php if($_GET['editid']!='') { echo 'Update';} else { echo'Submit';}?>" />&nbsp;
			<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
			<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_advertisement.php';" />
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
<script type="text/javascript" src="<?php echo $HomeURL?>/js/jquery-ui.js"></script>
<!--message display error and hide-->
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
	
<style>
.hide {display:none;}
</style>
