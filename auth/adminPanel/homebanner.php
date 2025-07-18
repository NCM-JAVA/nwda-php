<?php ob_start();
include("../../includes/config.inc.php");
 require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
//include ('pdf2text.php');
$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "15";
// $role_map=role_permission($user_id,$role_id,$model_id);
// $role_id_page=role_permission_page($user_id,$role_id,$model_id);

//ini_set('display_errors', 1); 
//error_reporting(E_ALL);

 
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
	
        $txtename 			= trim(str_replace("'", "\'", $_POST['txtename']));
        $txtepage_title		= trim(str_replace("'", "\'", $_POST['txtepage_title']));
        $txtepage_titlehi	= trim(str_replace("'", "\'", $_POST['txtepage_titlehi']));
		$txtlanguage		= trim($_POST['txtlanguage']);
        $url				= seo_url($txtepage_title);
		if($txtlanguage!='2'){
			$sortcontentdesc		= htmlentities(stripslashes(utf8_encode($_POST['sortcontentdesc'])), ENT_QUOTES); 	
		}else{
			$sortcontentdesc		= $_POST['sortcontentdesc'];
		}
		
        
        $txtstatus			= trim($_POST['txtstatus']);
        $createdate 		= date('Y-m-d');
        $errmsg="";  
		
		
        if(trim($txtlanguage)=="")
        {
                $errmsg ="Please Select Language."."<br>";

        }
        if($txtlanguage=='2')
        {
                if(trim($txtename)=="")
                {
                        $errmsg .="Please enter Banner Name."."<br>";
                }
                
                if(trim($txtepage_title)=="")
                {
                        $errmsg .="Please enter Banner Title."."<br>";
                }
                
                if(trim($sortcontentdesc)=="")
                {
                        $errmsg .="Please enter Banner Short Description."."<br>";
                }
                if($_FILES["txtuplode"]["tmp_name"]=="")
                {
                        $errmsg .= "Please Uploade GIF,PNG,JPG and JPEG images."."<br>";
                }
                else if ($_FILES["txtuplode"]["tmp_name"]!="")
                {
				
                        // $tempfile=($_FILES["txtuplode"]["tmp_name"]);
                        // $imageinfo = ($_FILES["txtuplode"]["type"]);
                        // $section = strtoupper(base64_encode(file_get_contents($tempfile)));
                        // $nsection=substr($section,0,8);

                        // $imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);

                        // if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
                        // {
                        //         $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images'.'<br>';
                        // }

                        // if(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH"))
                        // {}
                        // else
                        // {
                        //         $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images'.'<br>';
                        // }
                        // if ($_FILES["txtuplode"]["size"] >=5048576)
                        // {
                        //         $errmsg .= IMAGE_SIZE_LIMIT."<br>";
                        // }
                        $tempfile=($_FILES["txtuplode"]["tmp_name"]);
                        $imageinfo = ($_FILES["txtuplode"]["type"]);
                        $section = strtoupper(base64_encode(file_get_contents($tempfile)));
                         $nsection=substr($section,0,8);
        
                         if(preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
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
                        $errmsg .="Please Select Banner Status."."<br>";
                }


        }
        else
        {
			
                if(trim($txtename)=="")
                {
                        $errmsg .="Please enter Banner Name."."<br>";
                }
                if(trim($txtepage_title)=="")
                {
                        $errmsg .="Please enter Banner Title."."<br>";
                }
         
                if($_FILES["txtuplode"]["tmp_name"]=="")
                {
                $errmsg .= "Please Uploade GIF,PNG,JPG and JPEG images."."<br>";
                }
                elseif ($_FILES["txtuplode"]["tmp_name"]!="")
                 {
					 	 
                        $tempfile=($_FILES["txtuplode"]["tmp_name"]);
                        $imageinfo = ($_FILES["txtuplode"]["type"]);
                        $section = strtoupper(base64_encode(file_get_contents($tempfile)));
                        $nsection=substr($section,0,8);

                        $imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);
			

                        if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
                        {
                                $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images';
                        }
                        if ($_FILES["txtuplode"]["size"] >=5048576)
                        {
                        $errmsg .= IMAGE_SIZE_LIMIT."<br>";
                        }

                        $tempfile=($_FILES["txtuplode"]["tmp_name"]);
                        $imageinfo = ($_FILES["txtuplode"]["type"]);
                        $section = strtoupper(base64_encode(file_get_contents($tempfile)));
                         $nsection=substr($section,0,8);
 

                         if(!preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
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
                $errmsg .="Please Select Banner Status."."<br>";
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

                if ($_FILES["txtuplode"]["tmp_name"]!="")
                {
                        $max_upload_width = 568;
                        $max_upload_height = 365;

                        if ($_FILES["txtuplode"]["size"] < 5048576)
                        {
                               /*  if($_FILES["txtuplode"]["type"] == "image/jpeg" || $_FILES["txtuplode"]["type"] == "image/pjpeg"){	
                                        $image_source = imagecreatefromjpeg($_FILES["txtuplode"]["tmp_name"]);
                                }		
                         
                                if($_FILES["txtuplode"]["type"] == "image/gif"){	
                                        $image_source = imagecreatefromgif($_FILES["txtuplode"]["tmp_name"]);
                                }	
                    
                                if($_FILES["txtuplode"]["type"] == "image/bmp"){	
                                        $image_source = imagecreatefromwbmp($_FILES["txtuplode"]["tmp_name"]);
                                }			
                          
                                if($_FILES["txtuplode"]["type"] == "image/png"){
                                        $image_source = imagecreatefrompng($_FILES["txtuplode"]["tmp_name"]);
                                } */

                                $image = $_FILES['txtuplode']['name'];
                                $filename1 = $_FILES['txtuplode']['tmp_name'];
                           
                            /*     $uniq = uniqid("");
                                $filename1=$filename1; */
                                $PATH="../../upload/banner/";
                                $remote_file = $PATH.$image;
								if ($filename1!=""){
									if(!is_dir($PATH)){  
										mkdir($PATH,0777);
									}
									$PATH=$PATH."/";
								   // Now let's move the uploaded image into the folder: image
									if (move_uploaded_file($filename1, $remote_file)) {
										//echo "<h3>  Image uploaded successfully!</h3>";
									} else {
										//echo "<h3>  Failed to upload image!</h3>";
									}
								}
						  
                        }
                        else{
                                $msg=IMAGE_SIZE_LIMIT;
                                $_SESSION['sess_img']=$msg;
                                header("location:manage_banner.php#");
                                exit;
                        }	
                        $add_img='../../upload/banner/'.$filename1;
                        $add_thumb='../../upload/banner/thumb/'.$filename1;
							
                       // generate_image_thumbnail($add_img,$add_thumb);

                }			
                //$filename1=addslashes($filename1); 
		
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
				
                // $tableName_send="banner";
                // $tableFieldsName_old=array("b_name","b_title","h_title","	b_language","b_short_desc","b_image_path","approve_status","admin_id","page_postion");
                // $tableFieldsValues_send=array("$txtename","$txtepage_title","$txtepage_titlehi","$txtlanguage","$sortcontentdesc","$filename1","$txtstatus","$user_id","");
                // $value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
				
					$sql = "INSERT INTO `banner` (`b_name`,`b_title`,`h_title`,`b_language`,`b_short_desc`,`b_image_path`,`approve_status`,`admin_id`,`page_postion`)VALUES ('$txtename','$txtepage_title','$txtepage_titlehi','$txtlanguage','$sortcontentdesc','$image','$txtstatus','$user_id','0')";
				
				$sqli123 = $conn->query($sql);
					
                $page_id = $conn->insert_id; 
			
                if($txtstatus=='3')
                {

					$sql32 = "INSERT INTO banner_publish (`publish_id`,`b_name`,`b_title`,`h_title`,`b_language`,`b_short_desc`,`b_image_path`,`approve_status`,`admin_id`,`page_postion`)VALUES ('$page_id','$txtename','$txtepage_title','$txtepage_titlehi','$txtlanguage','$sortcontentdesc','$image','$txtstatus','$user_id','0')";
					$sqli1 = $conn->query($sql32);
                }
	
                $user_id=$_SESSION['admin_auto_id_sess'];
                $page_id = $conn->insert_id;
                $action="Insert";
                $categoryid='1'; 
                $date=date("Y-m-d h:i:s");
                $ip=$_SERVER['REMOTE_ADDR'];
				 //$sqlrt = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES ('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
				//$sqli11 = $conn->query($sqlrt);
		
                $msg=CONTENTADD;
			
                $_SESSION['content']=$msg;
                header("location:manage_banner.php");
                exit;	
        }	
	}
	if(isset($cmdsubmit) && $_GET['editid']!='')
	{
        $cid=$_GET['editid'];
		$txtename 			= trim(str_replace("'", "\'", $_POST['txtename']));
        $txtepage_title		= trim(str_replace("'", "\'", $_POST['txtepage_title']));
        $txtepage_titlehi	= trim(str_replace("'", "\'", $_POST['txtepage_titlehi']));
		$txtlanguage= trim($_POST['txtlanguage']);
        $url=seo_url($txtepage_title);
       	if($txtlanguage!='2'){
			$sortcontentdesc		= htmlentities(stripslashes(utf8_encode($_POST['sortcontentdesc'])), ENT_QUOTES); 	
		}else{
			$sortcontentdesc		= $_POST['sortcontentdesc'];
		}
      
        $txtstatus=trim($_POST['txtstatus']);
        if($txtstatus =="")
        {
                $txtstatus='1';
        }
        $errmsg="";        // Initializing the message to hold the error messages
        if(trim($txtlanguage)=="")
        {
                $errmsg ="Please Select Language."."<br>";
        }
        if($txtlanguage=='2')
        {
                if(trim($txtename)=="")
                {
                        $errmsg .="Please enter Banner Name."."<br>";
                }
                if(trim($txtepage_title)=="")
                {
                        $errmsg .="Please enter Banner Title."."<br>";
                }
                if(trim($sortcontentdesc)=="")
                {
                        $errmsg .="Please enter Banner Short Description."."<br>";
                }

                if ($_FILES["txtuplode"]["tmp_name"]!="")
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
                        $errmsg .="Please Select Banner Status."."<br>";
                }
        }
        else
        {
                if(trim($txtename)=="")
                {
                        $errmsg .="Please enter Banner Name."."<br>";
                }

                if(trim($txtepage_title)=="")
                {
                        $errmsg .="Please enter Banner Title."."<br>";
                }

                if(trim($sortcontentdesc)=="")
                {
                        $errmsg .="Please enter Banner Short Description."."<br>";
                }
                if ($_FILES["txtuplode"]["tmp_name"]!="")
                {
				
                        $tempfile=($_FILES["txtuplode"]["tmp_name"]);
                        $imageinfo = ($_FILES["txtuplode"]["type"]);
                        $section = strtoupper(base64_encode(file_get_contents($tempfile)));
                         $nsection=substr($section,0,8);
        	
                         if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
                         {
                                 $errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
                         }/* else if ( $section != strip_tags($section) )
                         {
                                $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
                         } */else{
							
                                 //echo $section;die();
                                $imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);
        
                                $extarray = explode(".",$_FILES["txtuplode"]["name"]);
                                if(count($extarray)>2)
                                {
                                        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
                                }elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
                                {
                                        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
                                }/* elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
                                {}else{
                                        $errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
                                } */
                                if ($_FILES["txtuplode"]["size"] < 1)
                                {
                                        $errmsg .= "Image Size is too less.<br>";
                                }
                               
                                
                        }
                }
                if(trim($txtstatus)=="")
                {
                        $errmsg .="Please Select Banner Status."."<br>";
                }
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

                if ($_FILES["txtuplode"]["name"]!=""){
                        if ($_FILES["txtuplode"]["size"] < (1048576*8))                       
                        {
                              
							    $sql   = "select b_image_path FROM banner WHERE b_id=$cid";
							   	$sqli1 = $conn->query($sql);
                                $row   = $sqli1->fetch_array();
 
                                $path ="../../upload/banner";
                                $path2 ="../../upload/banner/thumb";
                                unlink($path . "/" .$row['b_image_path']);
                                unlink($path2 . "/" .$row['b_image_path']);

                                $max_upload_width = 568;
                        $max_upload_height = 365;
						
					
						
                                if ($_FILES["txtuplode"]["size"] < (1048576*8))
                                {

	 
                                        $filename1=$_FILES['txtuplode']['name'];
                                        $uniq = uniqid("");
                                        $filename1=$filename1;
                                        $PATH="../../upload/banner/";

                                        if(!is_dir($PATH)){  
                                                mkdir($PATH,0777);
                                        }
                                        $PATH=$PATH."/";
										$val = move_uploaded_file($_FILES["txtuplode".$i]["tmp_name"], $PATH . $filename1);
                                        // $remote_file = $PATH.$filename1;
                                        // $test=imagejpeg($image_source,$remote_file,100);
                                        // $size=filesize($PATH.$filename1);
                                        // $size=ceil($size/1024);
                                        // $found="false";


                                      //  list($image_width, $image_height) = getimagesize($remote_file);
                                     
									  /* if($image_width>$max_upload_width || $image_height >$max_upload_height)
                                        {
                                              
							 
											  $proportions = $image_width/$image_height;

                                                if($image_width>$image_height)
                                                {
                                           
                                                        $new_width = $max_upload_width;
                                                        $new_height = $max_upload_height;

                                                }		
                                                else{
                                               
                                                        $new_width = $max_upload_width;
                                                        $new_height = $max_upload_height;
                                                }		


                                                
                                        }
										
                                        imagedestroy($image_source); */

                                }
                                else{
                                        $msg=IMAGE_SIZE_LIMIT;
                                        $_SESSION['sess_msg']=$msg;
                                        header("location:homebanner.php");
                                        exit;
                                }
 
                                $add_img='../../upload/banner/'.$filename1;
                                $add_thumb='../../upload/banner/thumb/'.$filename1;
                                //$add_thumb1='../../upload/photogallery/front_thumb/'.$filename1;
                             //   generate_image_thumbnail($add_img,$add_thumb);
                                //generate_image_frontthaumb($add_img,$add_thumb1);

                               // $filename1=addslashes($filename1);
                                // $tableName_send="banner";
                                // $whereclause="b_id='$cid'";
                                // $old =array("b_image_path");
                                // $new =array("$filename1");
                                // $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
								
								$update = "UPDATE `banner` SET `b_image_path`='$filename1' WHERE `b_id`=$cid";
								$up_result = $conn->query($update);
								
                        }

						



						
                }	

                // $tableName_send="banner";
                // $whereclause="b_id='$cid'";
                // $old=array("","","","","","","");
                // $new=array("$","$","$","$","$","$","$");
                // $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
				
				$sql1 = "UPDATE `banner` SET `b_name`='$txtename',`b_title`='$txtepage_title',`h_title`='$txtepage_titlehi',`b_language`='$txtlanguage',`b_short_desc`='$sortcontentdesc',`approve_status`='$txtstatus',`admin_id`='$user_id' WHERE `b_id`=$cid";
				$result = $conn->query($sql1);
	
                if($txtstatus=='3')
                {
					
                        $tableName_send = "banner_publish";
                        $whereclause = "where publish_id='$cid'";
                        $page_id = $cid;
                        $sql = "Select * from banner_publish $whereclause";
						$result = $conn->query($sql);
                        $row = $result->num_rows; 
						
                        $whereclause = "where b_id='$cid'";
                        $sql1 = "Select * from banner $whereclause";
						$result_f = $conn->query($sql1);
                        $rowss = $result_f->fetch_array();
                        $imagepath = $rowss['b_image_path']; 

                        if($row >0)
                        {

							// $whereclause="publish_id='$cid'";
							// $old =array("publish_id","b_name","b_title","h_title","b_language","b_short_desc","b_image_path","approve_status","admin_id");
							// $new =array("$page_id","$txtename","$txtepage_title","$txtepage_titlehi","$txtlanguage","$sortcontentdesc","$imagepath","$txtstatus","$user_id");
							// $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
							
							$sql1 = "UPDATE `banner_publish` SET `publish_id`='$page_id',`b_name`='$txtename',`b_title`='$txtepage_title',`h_title`='$txtepage_titlehi',`b_language`='$txtlanguage',`b_short_desc`='$sortcontentdesc',`b_image_path`='$imagepath',`approve_status`='$txtstatus',`admin_id`='$user_id' WHERE `publish_id`=$cid";
							$result = $conn->query($sql1);
							$user_id=$_SESSION['admin_auto_id_sess'];
						
                        }
                        else
                        {
                               // $page_id=$cid; 
                               // $tableFieldsName_old=array("publish_id","b_name","b_title","h_title","b_language","b_short_desc","b_image_path","approve_status","admin_id","page_postion");
                               // $tableFieldsValues_send=array("$page_id","$txtename","$txtepage_title","$txtepage_titlehi","$txtlanguage","$sortcontentdesc","$imagepath","$txtstatus","$user_id","");
                               // $useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
							   
							   $sql = "INSERT INTO banner_publish (`publish_id`,`b_name`,`b_title`,`h_title`,`b_language`,`b_short_desc`,`b_image_path`,`approve_status`,`admin_id`,`page_postion`)VALUES ('$page_id','$txtename','$txtepage_title','$txtepage_titlehi','$txtlanguage','$sortcontentdesc','$imagepath','$txtstatus','$user_id','')";
								$sqli1 = $conn->query($sql);
							   
                        }
                }

                $user_login_id=$_SESSION['admin_auto_id_sess'];
                $page_id=$cid;
                $action="Update";
                $categoryid='3';
                $date=date("Y-m-d h:i:s");
                $ip=$_SERVER['REMOTE_ADDR'];
                // $tableName="audit_trail";
                // $tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title");
                // $tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title");
                // $value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
				
				//$sql = "INSERT INTO `audit_trail`(`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`)VALUES('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
				//$sqli1 = $conn->query($sql);
				
                $msg=UPDATE;
                $_SESSION['content']=$msg;
                $_SESSION['token'] = "";
                $_SESSION['uniq'] ="";

                header("location:manage_banner.php");
                exit;

        }

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Home Banner add/update: <?php echo $sitename;?></title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
 <script type="text/javascript" src="js/jsDatePick.js"></script>
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
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
			<span class="submenuclass"><a href="manage_banner.php" title="Manage What's New">Manage Home Banner</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add/Update Home Banner</span>
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
 <h3 class="manageuser">Add/Update Home Banner </h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	if($_GET['editid']!=''){
		$rq = "select * from banner where b_id='".$_GET['editid']."'";
		$rs = $conn->query($rq);
		$rr = $rs->fetch_array();
	}
		
	
?>   
<div class="frm_row"> <span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if($rr['b_language']=='1'){ echo 'checked'; } ?> id="txtlanguage" />English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if($rr['b_language']=='2'){ echo 'checked'; } ?>/>Hindi 
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
			<div class="frm_row"> <span class="label1">
				<label for="txtename">Name:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php echo $rr['b_name']; ?>"/>
				
				</span>
				<div class="clear"></div>
			</div>
			<div class="frm_row"> <span class="label1">
				<label for="txtepage_title">Title:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="txtepage_title" autocomplete="off" type="text" class="input_class" id="txtepage_title" size="30"   value="<?php echo $rr['b_title']; ?>"/>
				
				</span>
				<div class="clear"></div>
			</div>
		<div class="frm_row"> <span class="label1">
				<label for="txtepage_title">Hindi Title:</label>
				</span> <span class="input1">
				<input name="txtepage_titlehi" autocomplete="off" type="text" class="input_class" id="txtepage_titlehi" size="30"   value="<?php echo $rr['h_title']; ?>"/>
				
				</span>
				<div c
            <div class="frm_row"> <span class="label1">
            <label for="txtuplode">Image Upload :</label>
            </span> <span class="input1">
           <input type="file" name="txtuplode" id="txtuplode"/><?php if($rr['b_image_path'] !='') {?>
		   <img src="../../upload/banner/thumb/<?php echo $rr['b_image_path'];?>" alt="" title="" align="center" width="80" height="90" />
		   <?php }?> 
            </span>
			<strong> <a href="http://pixlr.com/editor/" title="If images not less then 1 MB, online reduce the image size." onclick="sitevisit();" target="_blank">Image upload less then 4 MB</a></strong>
            <div class="clear"></div>
            </div>
			<div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Short Description :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('sortcontentdesc',stripslashes(html_entity_decode($rr['b_short_desc'])));
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
			$sql="select * from content_state where state_status=1";
			$footersql = $conn->query($sql);
			while($row = $footersql->fetch_array())
			{ 
			?>
		<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
			<?php }
			}
			else if($user_id !='101' )
			{
			$sql=mysqli_query($conn, "select * from content_state");
			$footer = $conn->query($sql);
			while($row = $footer->fetch_array())
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
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_banner.php';" />
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
  <!--</div> -->  <!-- main con-->


 
</div> <!-- Container div-->
<?php include("footer.php"); ?>
</body>
</html>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
<script type="text/javascript">
function sitevisit()
{
if (! confirm('This is external link, Are you sure you want to continue?')) 
return false;
}
</script>
<style>
.hide {display:none;}
</style>