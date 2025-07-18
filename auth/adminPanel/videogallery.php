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
$model_id= "16";
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
	


$txtcategory = check_input($_POST['txtcategory']);
$txtepage_title= check_input($_POST['txtepage_title']);
$txtepage_title1= check_input($_POST['txtepage_title1']);
$txtstatus=check_input($_POST['txtstatus']);
$createdate=date('Y-m-d');
$errmsg="";  
//$video = array('.mpg','.MPG', '.wma','.WMA','.MOV', '.mov', '.flv', '.mp4', '.avi', '.qt', '.wmv', '.rm');
$video = array('.mp4');
$videofile = $_FILES['vid_file']['name'];
$videoext = substr($videofile, strpos($videofile,'.'), strlen($videofile)-1); 

		if(trim($txtcategory)=="")
		{
			$errmsg .="Please Select Category Name."."<br>";
		}
		if(trim($txtepage_title)=="")
		{
		$errmsg .="Please enter Video Title (English)."."<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\']{3,100}$/i", $txtepage_title) === 0)
		{
		$errmsg .= "Video Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 3 and maximum 100."."<br>";
		}
		// if(trim($txtepage_title1)=="")
		// {
		// $errmsg .="Please enter Video Title (Hindi)."."<br>";
		// }
		
		if ($_FILES["vid_file"]["tmp_name"]!="")
		{ 
			$tempfile=($_FILES["vid_file"]["tmp_name"]);
			$imageinfo = ($_FILES["vid_file"]["type"]);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection=substr($section,0,8);
		
			if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["vid_file"]["name"]) )
			{
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			}else if ( $section != strip_tags($section) )
			{
				$errmsg .= 'Sorry, we only accept mp4 format.<br>';
			}else{
				$extarray = explode(".",$_FILES["vid_file"]["name"]);
				if(count($extarray)>2)
				{
					$errmsg .= 'Sorry, we only accept mp4 format.<br>';

				}elseif(($nsection!="AAAAIGZ0"))
				{
					$errmsg .= 'Please upload mp4 file only.<br>';
				}elseif ($_FILES["vid_file"]["size"] < 1)
				{
					$errmsg .= "Image Size is too less.<br>";
				}
				elseif ($_FILES["vid_file"]["size"] > 15728640)
				{
					$errmsg .= "Please Upload upto 15 mb.<br>";
				}
			}
		}
		
		if(trim($txtstatus)=="")
		{
		$errmsg .="Please Select Page Status."."<br>";
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
		if ($_FILES["vid_file"]["name"]!="")
		{
		
				$video=$_FILES['vid_file']['name'];
				//$filename1=$_FILES['txtuplode']['name'];
				$uniq = uniqid("");
				//$filename1=$uniq.$filename1;
				$video=$uniq.$video;
				//	$PATH="../../upload/video_galery/thumb/";
				
				if(!is_dir($PATH)){  
				mkdir($PATH,0777);
				}
				$PATH=$PATH."/";
				$add_img='../../upload/video_galery/'.$video;
				move_uploaded_file($_FILES['vid_file']['tmp_name'],$PATH.$add_img);
				//move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$filename1);
										
		}
		else{
				$msg=IMAGE_SIZE_LIMIT;
				$_SESSION['sess_img']=$msg;
				header("location:add_photo_gallary.php");
				exit;
		}				
		$filename1=addslashes($filename1); 
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


		$tableName_send="photogallery";
		$tableFieldsName_old=array("img_uplode","sortdesc","sort_desc_hindi","approve_status","gallery_type","category_id","admin_id","createdate");
		$tableFieldsValues_send=array("$video","$txtepage_title","$txtepage_title1","$txtstatus","2","$txtcategory","$user_id","$createdate");
		$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
		$page_id=mysql_insert_id();
		$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id=mysql_insert_id();
		$action="Insert";
		$categoryid='2'; 
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array("$user_id","$page_id","$txtename","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title","$txtstatus");
		$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
		$msg=CONTENTADD;
		$_SESSION['content']=$msg;
		header("location:manage_video_gallery.php");
		exit;	
	}	
}
if(isset($cmdsubmit) && $_GET['editid']!='')
{
	
$cid=$_GET['editid'];
$txtcategory = check_input($_POST['txtcategory']);
$txtepage_title= check_input($_POST['txtepage_title']);
$txtepage_title1= check_input($_POST['txtepage_title1']);
$txtstatus=check_input($_POST['txtstatus']);
$errmsg="";        // Initializing the message to hold the error messages
$video = array('.mpg','.MPG', '.wma','.WMA','.MOV', '.mov', '.flv', '.mp4', '.avi', '.qt', '.wmv', '.rm');
$videofile = $_FILES['vid_file']['name'];  
$videoext = substr($videofile, strpos($videofile,'.'), strlen($videofile)-1); 
	if(trim($txtcategory)=="")
		{
			$errmsg .="Please Select Category Name."."<br>";
		}
		if(trim($txtepage_title)=="")
		{
		$errmsg .="Please enter Video Title (English)."."<br>";
		}
		else if (preg_match("/^[a-zA-Z0-9 _.,:()&amp;\"\']{3,100}$/i", $txtepage_title) === 0)
		{
		$errmsg .= "Video Title must be Alphanumeric and Special Characters( _.,:()&amp ) that should be minimum 3 and maximum 100."."<br>";
		}
		if(trim($txtepage_title1)=="")
		{
		$errmsg .="Please enter Video Title (Hindi)."."<br>";
		}
		// if($_FILES["vid_file"]["tmp_name"]!="")
		// { 	
		// 	if(!in_array($videoext,$video))
		// 	{
		// 		$errmsg .="Please Upload mpg,MOV,flv and avi video file ."."<br>";
		// 	}elseif( mime_content_type($_FILES["vid_file"]["name"]) != "video/quicktime" ){
		// 		$errmsg .="Please Upload mpg,MOV,flv and avi video file ."."<br>";
		// 	}
		// }

		if ($_FILES["vid_file"]["tmp_name"]!="")
		{ 
			$tempfile=($_FILES["vid_file"]["tmp_name"]);
			$imageinfo = ($_FILES["vid_file"]["type"]);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection=substr($section,0,8);
		//echo $nsection;exit;
			if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["vid_file"]["name"]) )
			{
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			}else if ( $section != strip_tags($section) )
			{
				$errmsg .= 'Sorry, we only accept mp4 format.<br>';
			}else{
				$extarray = explode(".",$_FILES["vid_file"]["name"]);
				if(count($extarray)>2)
				{
					$errmsg .= 'Sorry, we only accept mp4 format.<br>';

				}elseif(($nsection!="AAAAIGZ0"))
				{
					$errmsg .= 'Please upload mp4 file only.<br>';
				}elseif ($_FILES["vid_file"]["size"] < 1)
				{
					$errmsg .= "Image Size is too less.<br>";
				}
				elseif ($_FILES["vid_file"]["size"] > 15728640)
				{
					$errmsg .= "Please Upload upto 15 mb.<br>";
				}
			}
		}


		if(trim($txtstatus)=="")
		{
		$errmsg .="Please Select Banner Status."."<br>";
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
 if ($_FILES["vid_file"]["name"]!="")
		{
		   $sql = "select img_uplode FROM photogallery WHERE id=$cid";
    $rs = mysql_query($sql);
	$row=mysql_fetch_array($rs);
	$path ="../../upload/video_galery";
unlink($path . "/" .$row['img_uplode']);
				$video=$_FILES['vid_file']['name'];
				//$filename1=$_FILES['txtuplode']['name'];
				$uniq = uniqid("");
				//$filename1=$uniq.$filename1;
				$video=$uniq.$video;
				//	$PATH="../../upload/video_galery/thumb/";
				
				if(!is_dir($PATH)){  
				mkdir($PATH,0777);
				}
				$PATH=$PATH."/";
				$add_img='../../upload/video_galery/'.$video;
				move_uploaded_file($_FILES['vid_file']['tmp_name'],$PATH.$add_img);
				//move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$filename1);
				
$add_img='../../upload/video_galery/'.$video;
	$filename1=addslashes($video);
	$tableName_send="photogallery";
	$whereclause="id='$cid'";
	$old =array("img_uplode");
	$new =array("$filename1");
	$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
				}
$tableName_send="photogallery";
$whereclause="id='$cid'";
$old=array("sortdesc","sort_desc_hindi","approve_status","category_id","admin_id");
$new=array("$txtepage_title","$txtepage_title1","$txtstatus","$txtcategory","$user_id");
$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);

$user_login_id=$_SESSION['admin_auto_id_sess'];
$page_id=$cid;
$action="Update";
$categoryid='3';
$date=date("Y-m-d h:i:s");
$ip=$_SERVER['REMOTE_ADDR'];
$tableName="audit_trail";
$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title");
$tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title");
$value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
$msg=UPDATE;
$_SESSION['content']=$msg;
$_SESSION['token'] = "";
	$_SESSION['uniq'] ="";
header("location:manage_video_gallery.php");
exit;

}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Video Gallery add/update: DDA</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
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
			<span class="submenuclass"><a href="manage_video_gallery.php" title="Manage Video Gallery">Manage Video Gallery</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add/Update Video Gallery</span>
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
 <h3 class="manageuser">Add/Update Video Gallery </h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
	<?php	
	if($_GET['editid']!='')
	{
		$rq = mysql_query("select * from photogallery where id='".$_GET['editid']."'");
		//echo "select * from category where c_id='".$_GET['id']."'";
		$rr = mysql_fetch_array($rq);
				//print_r($rr);
		}
		
	
?>   
<div class="frm_row"> <span class="label1">
<label for="txtcategory">Category Name :</label>
<span class="star">*</span></span> <span class="input1">
					<?php 
						$CatgorySql=mysql_query("Select * from category where cat_id='2'  order by c_id asc");
						//echo "Select * from category where c_type!='5' order by c_id asc";
						$CategoryNum = mysql_num_rows($CatgorySql);
					?>
					<select name="txtcategory" id="txtcategory" autocomplete="off"  >
					<option  value="">Select</option>
					<?php 
							while($CategoryNum =mysql_fetch_array($CatgorySql))
							{
						?>
					<option value="<?php echo $CategoryNum['c_id'];?>"<?php if($CategoryNum['c_id']==$rr['category_id']) echo 'selected="selected"';?>><?php echo $CategoryNum['c_name']; ?></option>
					<?php } 
					 ?>
					 </option>
					</select></span>
<div class="clear"></div>
</div>
			<div class="frm_row"> <span class="label1">
<label for="txtepage_title">Video Title (English) :</label>
<span class="star">*</span></span> <span class="input1">
<input type="text" name="txtepage_title" autocomplete="off" id="txtepage_title" class="input_class"  value="<?php if(htmlspecialchars($rr['sortdesc']!="")){ echo htmlspecialchars($rr['sortdesc']);} ?>" />
</span>
<div class="clear"></div>
</div>
<div class="frm_row"> <span class="label1">
<label for="txtepage_title1">Video Title (Hindi) :</label>
</span> <span class="input1">
<input type="text" name="txtepage_title1" autocomplete="off" id="txtepage_title1" class="input_class"  value="<?php if(htmlspecialchars($rr['sort_desc_hindi']!="")){ echo htmlspecialchars($rr['sort_desc_hindi']);} ?>" />
</span>
<div class="clear"></div>
</div>
			
		
            <!--<div class="frm_row"> <span class="label1">
            <label for="txtuplode">Video Upload :</label>
            </span> <span class="input1">
           <input type="file" name="txtuplode" id="txtuplode"/><?php if($rr['img_uplode'] !='') {?>
		   <img src="../../upload/photogallery/thumb/<?php echo $rr['img_uplode'];?>" alt="" title="" align="center" width="80" height="90" />
		   <?php }?> 
            </span>
			<strong> <a href="http://pixlr.com/editor/" title="If images not less then 500 kb, online reduce the image size." target="_blank">Video upload less then 500kb</a></strong>
            <div class="clear"></div>
            </div>-->
			<div class="frm_row"> <span class="label1">
<label for="vid_file">Video Upload:</label>
<span class="star">*</span></span> <span class="input1">
<input name="vid_file" type="file" id="vid_file" />[.mp4 Video Formet]</span>
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
			<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_video_gallery.php';" />
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
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
</body>
</html>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
	
<style>
.hide {display:none;}
</style>