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
$model_id= "10";
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
$txtlanguage= content_desc(check_input($_POST['txtlanguage']));
$txtename = content_desc(check_input($_POST['txtename']));
$newicons = content_desc(check_input($_POST['newicons']));
$sortcontentdesc= content_desc(check_input($_POST['sortcontentdesc']));
$cat_id= content_desc(check_input($_POST['texcat']));
$addphoto= content_desc(check_input($_POST['addphoto']));
$texttype= content_desc(check_input($_POST['texttype']));
$txtekeyword=content_desc(check_input($_POST['txtekeyword']));
$txtmeta_description=content_desc(check_input($_POST['txtmeta_description']));
$txtcontentdesc= content_desc(check_input($_POST['txtcontentdesc']));
$txtweblink= content_desc(check_input($_POST['txtweblink']));
$txtstatus=content_desc(check_input($_POST['txtstatus']));
$m_title=content_desc(check_input($_POST['page_url']));
$url=seo_url($page_url);
$startdate1 = content_desc(check_input($_POST['startdate']));
$expairydate1 = content_desc(check_input($_POST['expairydate']));
$sta = split('-', $startdate1);
$startdate = $sta['2'] . "-" . $sta['1'] . "-" . $sta['0'];
$exp = split('-', $expairydate1);
$expairydate = $exp['2'] . "-" . $exp['1'] . "-" . $exp['0'];
$createdate=date('Y-m-d');
$errmsg=""; 
	if(trim($txtlanguage)=="")
	{
	$errmsg .="Please Select Language."."<br>";
	}
if($txtlanguage=='2')
{
	
		if(trim($txtename)=="")
		{
			$errmsg .="Please enter Name."."<br>";
		}
		if(trim($newicons)=="")
		{
			$errmsg .="Please select Display New Icons."."<br>";
		}
		if(trim($sortcontentdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		
		if(trim($texttype)=="")
		{
			$errmsg .="Please Select Menu Type."."<br>";
		}
		if(trim($texttype)!="")
		{

			if($texttype=='1')
			  {	

				if(trim($page_url)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}

				if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter Meta Description."."<br>";
				
				}
			}
			 if($texttype=='2')
			  {	
				 if ($_FILES["txtuplodepdf"]["tmp_name"]!="")
					{
						// $tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						// $imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						// $head = fgets(fopen($tempfile, "r"),5);
						// $section = strtoupper(base64_encode(file_get_contents($tempfile)));
						// $nsection=substr($section,0,8);
				
				
						// if($imageinfo != "application/pdf" )
						// {
						// 	$errmsg .= 'Sorry, we accept PDF files only';
						// }
				
						// else if($head != "%PDF") 
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
				
				
						// elseif($nsection!="JVBERI0X")
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
						$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						$head = fgets(fopen($tempfile, "r"),5);
						$section = strtoupper(base64_encode(file_get_contents($tempfile)));
						$nsection=substr($section,0,8);
				
						
						if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) )
						{
							$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
						}else if ( $section != strip_tags($section) )
						{
							$errmsg .= 'Sorry, we accept PDF files only';
						}else{
							
						   $extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
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
						   if ($_FILES["txtuplodepdf"]["size"] < 1)
						   {
							   $errmsg .= "Image Size is too less.<br>";
						   }
						   if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5))
						   {
							   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
						   }
						   
					   }

					}
				}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($link) !="")
				{
					if (!validateURL($link))
					 {
					$errmsg .="URL address not valid.<br>";
					}
				}
				
			}
		}
		if(trim($startdate1)=="")
		{
			$errmsg .="Please enter Start Date:<br>";
		}
		if(trim($expairydate1)=="") 
		{
			$errmsg .="Please enter Termination Date.<br>";
		}
		else if($exp['2'] < $sta['2'])
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
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
			$errmsg .="Please enter Name."."<br>";
		}
		if(trim($txtename)!="")
		{			
			 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename))
			{
				$errmsg .= "Name must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
			}
		}
		if(trim($newicons)=="")
		{
			$errmsg .="Please select Display New Icons."."<br>";
		}
		if(trim($sortcontentdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		if(trim($sortcontentdesc)!="")
		{			
			 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$sortcontentdesc))
			{
				$errmsg .= "Short Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
			}
		}
		if(trim($texttype)=="")
		{
			$errmsg .="Please Select Menu Type."."<br>";
		}
		if(trim($texttype)!="")
		{

			if($texttype=='1')
			  {	

				if(trim($page_url)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}
				if(trim($txtekeyword)!="")
					{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtekeyword))
						{
						$errmsg .= "Keyword must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}
						}
						if(trim($txtmeta_description)!="")
						{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtmeta_description))
						{
						$errmsg .= "Meta Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}
					}
				if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter Meta Description."."<br>";
				
				}
			}
			 if($texttype=='2')
			  {	
				 if ($_FILES["txtuplodepdf"]["tmp_name"]!="")
					{
						// $tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						// $imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						// $head = fgets(fopen($tempfile, "r"),5);
						// $section = strtoupper(base64_encode(file_get_contents($tempfile)));
						// $nsection=substr($section,0,8);
				
				
						// if($imageinfo != "application/pdf" )
						// {
						// 	$errmsg .= 'Sorry, we accept PDF files only';
						// }
				
						// else if($head != "%PDF") 
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
				
				
						// elseif($nsection!="JVBERI0X")
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
						$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						$head = fgets(fopen($tempfile, "r"),5);
						$section = strtoupper(base64_encode(file_get_contents($tempfile)));
						$nsection=substr($section,0,8);
				
						
						if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) )
						{
							$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
						}else if ( $section != strip_tags($section) )
						{
							$errmsg .= 'Sorry, we accept PDF files only';
						}else{
							
						   $extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
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
						   if ($_FILES["txtuplodepdf"]["size"] < 1)
						   {
							   $errmsg .= "Image Size is too less.<br>";
						   }
						   if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5))
						   {
							   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
						   }
						   
					   }

					}
				}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($link) !="")
				{
					if (!validateURL($link))
					 {
					$errmsg .="URL address not valid.<br>";
					}
				}
				
			}
		}
		if(trim($startdate1)=="")
		{
			$errmsg .="Please enter Start Date:<br>";
		}
		if(trim($expairydate1)=="") 
		{
			$errmsg .="Please enter Termination Date.<br>";
		}
		else if($exp['2'] < $sta['2'])
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
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
if(trim($cat_id)=="3" || trim($cat_id)=="5"){
			
				if ($_FILES["txtuplode"]["name"] != "")
				{
				if($_FILES["txtuplode"]["type"] == "image/jpeg" || $_FILES["txtuplode".$i]["type"] == "image/pjpeg" || $_FILES["txtuplode".$i]["type".$i] == "image/gif" || $_FILES["txtuplode".$i]["type".$i] == "image/bmp" || $_FILES["txtuplode".$i]["type".$i] == "image/png"){	
				$image_source = imagecreatefromjpeg($_FILES["txtuplode".$i]["tmp_name"]);
				}		
				
				$filename1 = $_FILES['txtuplode'.$i]['name'];
				$filename1 = preg_replace("/[^a-zA-Z0-9.]/", "", $filename1);
				$uniq = uniqid("");
				$filename1 = $uniq . $filename1;
				$PATH = "../../upload/photogallery";
				$PATH1="../../upload/photogallery/thumb";
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
				$add_img='../../upload/photogallery/'.$filename1;
				$add_thumb='../../upload/photogallery/thumb/'.$filename1;
				generate_image_thumbnail($add_img,$add_thumb);
				}
				$image_file=$filename1;
		}
		if ($_FILES["txtuplodepdf"]["name"]!="")
		{
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
$tableName_send="combine";

$tableFieldsName_old=array("language_id","cat_id","m_name","m_short","m_title","m_content","page_url","start_date","end_date","approve_status","admin_id","c_new_status","image_file","create_date","docs_file","ext_url","content_type","more_photo","m_keyword","m_description");
$tableFieldsValues_send=array("$txtlanguage","$cat_id","$txtename","$sortcontentdesc","$m_title","$txtcontentdesc","$url","$startdate","$expairydate","$txtstatus","$user_id","$newicons","$image_file","$createdate","$txtuplodepdf","$txtweblink","$texttype","$addphoto","$txtekeyword","$txtmeta_description");
$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
$page_id=mysql_insert_id();
if($txtstatus=='3')
{
	$sql="INSERT INTO combine_publish (m_publish_id,language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description)
	 SELECT m_id, language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description
   FROM combine WHERE m_id=$page_id";
  mysql_query($sql);
}

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
	$msg=CONTENTADD;
$_SESSION['content']=$msg;
header("location:minister_speech.php");
exit;	
}
}
if(isset($cmdsubmit) && $_GET['editid']!='')
{
$cid=$_GET['editid'];
$txtlanguage= content_desc(check_input($_POST['txtlanguage']));
$txtename = content_desc(check_input($_POST['txtename']));
$create_version = content_desc(check_input($_POST['create_version']));
$newicons = content_desc(check_input($_POST['newicons']));
$sortcontentdesc= content_desc(check_input($_POST['sortcontentdesc']));
$cat_id= content_desc(check_input($_POST['texcat']));
$addphoto= content_desc(check_input($_POST['addphoto']));
$texttype= content_desc(check_input($_POST['texttype']));
$txtekeyword=content_desc(check_input($_POST['txtekeyword']));
$txtmeta_description=content_desc(check_input($_POST['txtmeta_description']));
$txtcontentdesc= content_desc(check_input($_POST['txtcontentdesc']));
$txtweblink= content_desc(check_input($_POST['txtweblink']));
$txtstatus=content_desc(check_input($_POST['txtstatus']));
$m_title1=content_desc(check_input($_POST['page_url']));
$url=seo_url($page_url);
$startdate1 = content_desc(check_input($_POST['startdate']));
$expairydate1 = content_desc(check_input($_POST['expairydate']));
$sta = split('-', $startdate1);
$startdate = $sta['2'] . "-" . $sta['1'] . "-" . $sta['0'];
$exp = split('-', $expairydate1);
$expairydate = $exp['2'] . "-" . $exp['1'] . "-" . $exp['0'];
$createdate=date('Y-m-d');
	$update_date=date('Y-m-d h:i:s');
$errmsg=""; 
if(trim($txtlanguage)=="")
		{
		$errmsg .="Please Select Language."."<br>";
}
 
if($txtlanguage=='2')
{
	
		if(trim($txtename)=="")
		{
			$errmsg .="Please enter Name."."<br>";
		}
		if(trim($create_version)=="")
			{
			$errmsg.="Please Select Create New Versions."."<br>";
			
			}
		if(trim($newicons)=="")
		{
			$errmsg .="Please select Display New Icons."."<br>";
		}
		if(trim($sortcontentdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		
		if(trim($texttype)=="")
		{
			$errmsg .="Please Select Menu Type."."<br>";
		}
		if(trim($texttype)!="")
		{

			if($texttype=='1')
			  {	

				if(trim($m_title1)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}
					
				if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter Meta Description."."<br>";
				
				}
			}
			 if($texttype=='2')
			  {	
				 if ($_FILES["txtuplodepdf"]["tmp_name"]!="")
					{
						// $tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						// $imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						// $head = fgets(fopen($tempfile, "r"),5);
						// $section = strtoupper(base64_encode(file_get_contents($tempfile)));
						// $nsection=substr($section,0,8);
				
				
						// if($imageinfo != "application/pdf" )
						// {
						// 	$errmsg .= 'Sorry, we accept PDF files only';
						// }
				
						// else if($head != "%PDF") 
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
				
				
						// elseif($nsection!="JVBERI0X")
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }

						$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						$head = fgets(fopen($tempfile, "r"),5);
						$section = strtoupper(base64_encode(file_get_contents($tempfile)));
						$nsection=substr($section,0,8);
				
						
						if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) )
						{
							$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
						}else if ( $section != strip_tags($section) )
						{
							$errmsg .= 'Sorry, we accept PDF files only';
						}else{
							
						   $extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
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
						   if ($_FILES["txtuplodepdf"]["size"] < 1)
						   {
							   $errmsg .= "Image Size is too less.<br>";
						   }
						   if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5))
						   {
							   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
						   }
						   
					   }

				

					}
				}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($link) !="")
				{
					if (!validateURL($link))
					 {
					$errmsg .="URL address not valid.<br>";
					}
				}
				
			}
		}
		if(trim($startdate1)=="")
		{
			$errmsg .="Please enter Start Date:<br>";
		}
		if(trim($expairydate1)=="") 
		{
			$errmsg .="Please enter Termination Date.<br>";
		}
		else if($exp['2'] < $sta['2'])
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
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
			$errmsg .="Please enter Name."."<br>";
		}
		if(trim($txtename)!="")
		{			
			 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtename))
			{
				$errmsg .= "Name must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
			}
		}
		if(trim($create_version)=="")
			{
			$errmsg.="Please Select Create New Versions."."<br>";
			
			}
		if(trim($newicons)=="")
		{
			$errmsg .="Please select Display New Icons."."<br>";
		}
		if(trim($sortcontentdesc)=="")
		{
		$errmsg .="Please enter Short Description."."<br>";
		}
		if(trim($sortcontentdesc)!="")
		{			
			 if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$sortcontentdesc))
			{
				$errmsg .= "Short Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
			}
		}
		if(trim($texttype)=="")
		{
			$errmsg .="Please Select Menu Type."."<br>";
		}
		if(trim($texttype)!="")
		{

			if($texttype=='1')
			  {	

				if(trim($m_title1)=="")
				{
				$errmsg .= "Meta Title must be Alphanumeric "."<br>";
				}
				if(trim($txtekeyword)!="")
					{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtekeyword))
						{
						$errmsg .= "Keyword must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}
						}
						if(trim($txtmeta_description)!="")
						{			
						if (preg_match('/[^a-zA-Z0-9\s\w-&]/i',$txtmeta_description))
						{
						$errmsg .= "Meta Description must be Alphanumeric that should be minimum 2 and maximum 100."."<br>";
						}
					}
				if(trim($txtcontentdesc)=="")
				{
				$errmsg .="Please enter Meta Description."."<br>";
				
				}
			}
			 if($texttype=='2')
			  {	
				 if ($_FILES["txtuplodepdf"]["tmp_name"]!="")
					{
						// $tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						// $imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						// $head = fgets(fopen($tempfile, "r"),5);
						// $section = strtoupper(base64_encode(file_get_contents($tempfile)));
						// $nsection=substr($section,0,8);
				
				
						// if($imageinfo != "application/pdf" )
						// {
						// 	$errmsg .= 'Sorry, we accept PDF files only';
						// }
				
						// else if($head != "%PDF") 
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
				
				
						// elseif($nsection!="JVBERI0X")
						// {
						// 	$errmsg .= 'Sorry,we accept PDF files only';
						// }
				
						$tempfile=($_FILES["txtuplodepdf"]["tmp_name"]);
						$imageinfo = ($_FILES["txtuplodepdf"]["type"]);
						$head = fgets(fopen($tempfile, "r"),5);
						$section = strtoupper(base64_encode(file_get_contents($tempfile)));
						$nsection=substr($section,0,8);
				
						
						if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplodepdf"]["name"]) )
						{
							$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
						}else if ( $section != strip_tags($section) )
						{
							$errmsg .= 'Sorry, we accept PDF files only';
						}else{
							
						   $extarray = explode(".",$_FILES["txtuplodepdf"]["name"]);
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
						   if ($_FILES["txtuplodepdf"]["size"] < 1)
						   {
							   $errmsg .= "Image Size is too less.<br>";
						   }
						   if ($_FILES["txtuplodepdf"]["size"] >=(1048576*5))
						   {
							   $errmsg .= IMAGE_SIZE_LIMIT."<br>";
						   }
						   
					   }

					   
					}
				}
			 if($texttype=='3')
			  {	if(trim($txtweblink)=="")
				{
				$errmsg .="Please enter web link ."."<br>";
				
				}
				if(trim($link) !="")
				{
					if (!validateURL($link))
					 {
					$errmsg .="URL address not valid.<br>";
					}
				}
				
			}
		}
		if(trim($startdate1)=="")
		{
			$errmsg .="Please enter Start Date:<br>";
		}
		if(trim($expairydate1)=="") 
		{
			$errmsg .="Please enter Termination Date.<br>";
		}
		else if($exp['2'] < $sta['2'])
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
		} 
		else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
		{
			$errmsg .="Please enter Start Date less then Termination Date.<br>";
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
	if(trim($cat_id)=="3" || trim($cat_id)=="5"){
 if ($_FILES["txtuplode"]["name"] != "")
	 {
			if($_FILES["txtuplode".$i]["type"] == "image/jpeg" || $_FILES["txtuplode".$i]["type"] == "image/pjpeg" || $_FILES["txtuplode".$i]["type".$i] == "image/gif" || $_FILES["txtuplode".$i]["type".$i] == "image/bmp" || $_FILES["txtuplode".$i]["type".$i] == "image/png"){
				
			$image_source = imagecreatefromjpeg($_FILES["txtuplode".$i]["tmp_name"]);
			}	
			  $sql = "select image_file FROM combine WHERE m_id=$cid";
    $rs = mysql_query($sql);
	$row=mysql_fetch_array($rs);

    $image_path = "../../upload/photogallery/".$row['image_file'];
    $image_path2 = "../../upload/photogallery/thumb/".$row['image_file'];
    unlink($image_path);
   unlink($image_path2);	
			
			$filename1 = $_FILES['txtuplode'.$i]['name'];
			$filename1 = preg_replace("/[^a-zA-Z0-9.]/", "", $filename1);
			$uniq = uniqid("");
			$filename1 = $uniq . $filename1;
			$PATH = "../../upload/photogallery";
			$PATH1="../../upload/photogallery/thumb";
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
			$add_img='../../upload/photogallery/'.$filename1;
			$add_thumb='../../upload/photogallery/thumb/'.$filename1;
			generate_image_thumbnail($add_img,$add_thumb);
				$filename1=addslashes($filename1);
	$tableName_send="combine";
	$whereclause="m_id=$cid";
	$old =array("image_file");
	$new =array("$filename1");
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
		}
	}
	if ($_FILES["txtuplodepdf"]["name"]!="")
			{
				
			$sql = "select docs_file FROM combine WHERE m_id=$cid";
			$rs = mysql_query($sql);
			$row=mysql_fetch_array($rs);
			$image_path = "../../upload/".$row['docs_file'];
			unlink($image_path);
   
			/*if ($_FILES["txtuplode"]["size"] < 500000)
			{*/
			$txtuplodepdf=$_FILES['txtuplodepdf']['name'];
			$uniq = uniqid("");
			$txtuplodepdf=$uniq.$txtuplodepdf;		
			$PATH="../../upload/";					
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["txtuplodepdf"]["tmp_name"],$PATH.$txtuplodepdf);
			$size=filesize($PATH.$txtuplodepdf);
			$size=ceil($size/1024);
			$found="false";
			$txtuplodepdf=addslashes($txtuplodepdf); 
			$whereclause="m_id=$cid";
$tableName_send="combine";
			$old =array("docs_file");
			$new =array("$txtuplodepdf");
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
	$whereclause="m_id=$cid";
$tableName_send="combine";
$old=array("language_id","cat_id","m_name","m_short","m_title","m_content","page_url","start_date","end_date","approve_status","admin_id","c_new_status","create_date","ext_url","content_type","more_photo","m_keyword","m_description","update_date");
$new=array("$txtlanguage","$cat_id","$txtename","$sortcontentdesc","$m_title1","$txtcontentdesc","$url","$startdate","$expairydate","$txtstatus","$user_id","$newicons","$create_date","$txtweblink","$texttype","$addphoto","$txtekeyword","$txtmeta_description","$update_date");
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
if($txtstatus=='3')
{
	$tableName_send="combine_publish";
	$whereclause="where m_publish_id='$cid'";
$sql=mysql_query("Select * from combine_publish $whereclause");
$row=mysql_num_rows($sql); 

	if($create_version==1 and $row >0){ 
	$sql="INSERT INTO combine_publish_versions (m_publish_id,language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,create_versions_date)
	 SELECT m_publish_id, language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,update_date FROM combine_publish WHERE m_publish_id=$cid";
  mysql_query($sql);
		}
	if($row >0)
	{
 $update="UPDATE combine_publish,combine SET combine_publish.m_publish_id = combine.m_id,combine_publish.language_id = combine.language_id,combine_publish.cat_id = combine.cat_id,combine_publish.m_name = combine.m_name,combine_publish.m_short = combine.m_short,combine_publish.m_title = combine.m_title,combine_publish.m_content = combine.m_content,combine_publish.page_url = combine.page_url,combine_publish.start_date = combine.start_date,combine_publish.end_date = combine.end_date,combine_publish.approve_status = combine.approve_status,combine_publish.admin_id = combine.admin_id,combine_publish.c_new_status = combine.c_new_status,combine_publish.create_date = combine.create_date,combine_publish.image_file = combine.image_file,combine_publish.docs_file = combine.docs_file,combine_publish.ext_url = combine.ext_url,combine_publish.content_type = combine.content_type,combine_publish.more_photo = combine.more_photo,combine_publish.m_keyword = combine.m_keyword,combine_publish.m_description = combine.m_description,combine_publish.update_date = combine.update_date WHERE combine_publish.m_publish_id =combine.m_id and combine.m_id=$cid";
  mysql_query($update);
	}
	else {
$sql="INSERT INTO combine_publish (m_publish_id,language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,update_date)
	 SELECT m_id, language_id,cat_id,m_name,m_short,m_title,m_content,page_url,start_date,end_date,approve_status,admin_id,c_new_status,create_date,image_file,docs_file,ext_url,content_type,more_photo,m_keyword,m_description,update_date
   FROM combine WHERE m_id=$cid";
  mysql_query($sql);
  }
}
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
	$msg=CONTENTADD;
$_SESSION['content']=$msg;
header("location:minister_speech.php");
exit;	
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Minister Speech add/update: DDA</title>
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
		dateFormat:"%d-%m-%Y"
	});
	new JsDatePick({
		useMode:2,
		target:"expairydate",
		dateFormat:"%d-%m-%Y"
	});
};


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
			<span class="submenuclass"><a href="minister_image.php" title="Manage Minister Speech ">Manage Minister Image </a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add/Update Minister Image </span>	</div>
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
 <h3 class="manageuser">Add/Update Minister Image </h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	if($_GET['editid']!='')
	{
		$rq = mysql_query("select * from combine where 	m_id='".$_GET['editid']."' and 	cat_id=7");
		//echo "select * from category where c_id='".$_GET['id']."'";
		$rr = mysql_fetch_array($rq);
				//print_r($rr);
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
				<label for="txtename">Name:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php echo $rr['m_name']; ?>"/>
				
				</span>
				<div class="clear"></div>
			</div>
						<?php 	if($_GET['editid']!=''){?>
			<div class="frm_row"> <span class="label1">
              <label for="create_version">Create New Versions:</label>
              <span class="star">*</span></span> <span class="input1">
            <input type="radio" name="create_version" autocomplete="off" value="0"<?php if($create_version=='0') echo 'checked=checked'?>/>No &nbsp;<input type="radio" name="create_version" autocomplete="off"  value="1"<?php if($create_version=='1') echo 'checked=checked'?>/>Yes 
			
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
<?php }?>	
			<div class="frm_row"> <span class="label1">
              <label for="newicons">Display New Icons :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="newicons" id="newicons" autocomplete="off"  value="1" <?php if($rr['c_new_status']=='1'){ echo 'checked';} else ?> checked="checked" />Yes &nbsp;<input type="radio" name="newicons" autocomplete="off" value="2" <?php if($rr['c_new_status']=='2'){ echo 'checked'; } ?>/>No 
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
				<div class="frm_row"> <span class="label1">
              <label for="sortcontentdesc">Short Description: </label>
              <span class="star">*</span></span> <span class="input1">
              <textarea rows="2" cols="35" name="sortcontentdesc" autocomplete="off"  id="sortcontentdesc" onkeyup="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" onkeypress="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" onmouseout="Javascript:charactersRemaining(this.form.sortcontentdesc, 150, this.form.msg_left); characterLimit(this.form.sortcontentdesc, 150, this.form.sortcontentdesc);" tabindex="1" ><?php  echo $rr['m_short']; ?>
</textarea> <label style="float:right; margin-right:30px;" class="free" for="textarea_field">
		<script type="text/javascript">
			document.write("&nbsp;&nbsp;&nbsp;<input type='text' name='msg_left' id='msg_left' style='text-align:right;' size='3' value='150' readonly='readonly' /> left of 150 characters maximum.");
		</script>
		<noscript>(text limited to 150 characters)</noscript>
		</label>
              </span>
              <div class="clear"></div>
          
            </div>
		
<div class="frm_row"> <span class="label1">
<label for="texttype">Menu Type :</label>
<span class="star">*</span></span> <span class="input1">
<select name="texttype" id="texttype" autocomplete="off"  onChange="addmenutype(this.value)" >
<option value="">Select</option>
<?php 
foreach($menutype1 as $key=>$value)
{
	?>
<option value="<?php echo $key; ?>" <?php if($key==$rr['content_type']){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
<?php }
 ?>
</select></span>
<div class="clear"></div>
</div>
<div id="txtDoc" <?php if($texttype=='1' || $rr['content_type']=='1') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
		<div class="frm_row"> <span class="label1">
				<label for="page_url">Meta Title:</label> <span class="star">*</span>
				</span> <span class="input1">
				<input name="page_url" autocomplete="off" type="text" class="input_class" id="page_url" size="30"   value="<?php if($rr['m_title']!=""){ echo $rr['m_title'];} ?>"/>
				
				</span>
				<div class="clear"></div>
			</div>
 <div class="frm_row"> <span class="label1">
              <label for="txtekeyword">Meta Keyword:</label>
              </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtekeyword" autocomplete="off" id="txtekeyword"><?php if($rr['m_keyword']!=""){ echo $rr['m_keyword'];} ?></textarea>
              </span>
              <div class="clear"></div>
            </div>
            <div class="frm_row"> <span class="label1">
              <label>Meta Description:</label>
              </span> <span class="input1">
              <textarea rows="2" cols="35" name="txtmeta_description" autocomplete="off"  id="txtmeta_description" ><?php if($rr['m_description']!=""){ echo $rr['m_description'];} ?>
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
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($rr['m_content'])));
		?>        </span>
        <div class="clear"></div>
        </div>
</div>
<div id="txtPDF"  <?php if($texttype=='2' || $rr['content_type']=='2') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
            <div class="frm_row"> <span class="label1">
            <label for="txtuplodepdf">Document Upload :</label>
            <span class="star">*</span></span> <span class="input1">
           <input type="file" name="txtuplodepdf" id="txtuplodepdf"/>Please Upload Only PDF File.
            </span>
            <div class="clear"></div>
            </div>
</div>

<div id="txtweb"<?php if($texttype=='3' || $rr['content_type']=='3') {?> style="display:block" <?php } else {?>style="display:none" <?php } ?>>
   <div class="frm_row"> <span class="label1">
            <label for="txtweblink">Web Site Link :</label>
            <span class="star">*</span></span> <span class="input1">
          <input type="text" name="txtweblink" id="txtweblink" size="30" class="textbox" value="<?php if($rr['ext_url']!=""){ echo $rr['ext_url'];} ?>">
		<span class="date"><strong>Example : https://www.xyz.com</strong></span>

            </span>
            <div class="clear"></div>
            </div>
</div>


    <div class="frm_row"> <span class="label1">
                                                        <label for="startdate">Start Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="startdate" id="startdate" readonly="readonly"  autocomplete="off" value="<?php if($rr['start_date'] !=''){ echo changeformate($rr['start_date']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <div class="clear"></div>
          </div> 
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="expairydate">Termination Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                                        <input type="text" name="expairydate" autocomplete="off" readonly="readonly"  id="expairydate" value="<?php if($rr['end_date'] !=''){  echo changeformate($rr['end_date']); }else {}
                                                               
                                                           ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <div class="clear"></div>
            </div>  
	<?php $con="select * from papers_publish where m_flag_id ='0'  and menu_positions	='1' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
	$sql=mysql_query($con);
	$counter=mysql_num_rows($sql);
	$footercon="select * from papers_publish where m_flag_id ='0'  and menu_positions	='3' and language_id='$lan' and approve_status='3' ORDER BY m_publish_id";
	$footersql=mysql_query($footercon);
	$footercounter=mysql_num_rows($footersql);
	?>
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
			<input type="hidden" value="7" name="texcat" />
			<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='minister_image.php';" />
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