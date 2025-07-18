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
	 $_SESSION['catid'] = $_GET['cat_id'];

	$role_id=$_SESSION['dbrole_id'];
	$user_id=$_SESSION['admin_auto_id_sess'];
	$model_id= "16";

	$sql         = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
    $rs          = $conn->query($sql);
    $role_module = $rs->fetch_array();

    $module_id   = $role_module['module_id'];
    if ($module_id == 'ALL'){
        $role_id_page = 1;
    }else{
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
	if($role_id_page==0)
	{
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}
	
	//	Update Record Start
	if(isset($cmdsubmit) && $_GET['id']!='')
	{
	
	$cid=$_GET['id'];
	$txtcategory = trim($_POST['cat_id']);
	$txtepage_title= trim($_POST['txtename']);
	$txtepage_title1= trim($_POST['txtenamehi']);
	$txtstatus=trim($_POST['user_status']);
	$errmsg="";        
  
	if(trim($txtepage_title)=="")
	{
		$errmsg .="Please enter Image Title (English)."."<br>";
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
   					if ($_FILES["txtuplode"]["size"] >=(1048576*6))
   					{
   						$errmsg .= IMAGE_SIZE_LIMIT."<br>";
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
   		//if($_POST['random']!=$_POST['random'])
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
   			if ($_FILES["txtuplode"]["size"] < (1048576*6))
   				{
   	   $sql1 = "select img_uplode FROM photogallery WHERE id=$cid";
       $rs = mysqli_query($conn, $sql1);
   	$row=mysqli_fetch_array($rs);
   
   	$path ="../../upload/photogallery/media";
   	$path2 ="../../upload/photogallery/media/thumb";
   unlink($path . "/" .$row['img_uplode']);
   unlink($path2 . "/" .$row['img_uplode']);
   
		$max_upload_width = 891;
		$max_upload_height = 546;
		if ($_FILES["txtuplode"]["size"] < (1048576*6))
		{
		$filename1=preg_replace('/__+/', '_', preg_replace('/--+/', '-', preg_replace( "/\s+/", "", trim($_FILES['txtuplode']['name']) ) ) );
		$uniq = uniqid("");
		$filename1=$filename1;
		$PATH="../../upload/photogallery/media/";
		
		if(!is_dir($PATH)){  
		mkdir($PATH,0777);
		}
		$PATH=$PATH."/";

		$remote_file = $PATH.$filename1;
		$found="false";
   
   	}
   else{
   			$msg=IMAGE_SIZE_LIMIT;
   			$_SESSION['sess_msg']=$msg;
   			header("location:edit_banner.php");
   			exit;
   }	
   
   
   
   
   $add_img='../../upload/photogallery/media/'.$filename1;
   $add_thumb='../../upload/photogallery/media/thumb/'.$filename1;
   
    if (move_uploaded_file($_FILES["txtuplode"]["tmp_name"], $add_img)) {
		echo "image uploaded";
     }
   
   if (move_uploaded_file($_FILES["txtuplode"]["tmp_name"], $add_thumb)) {
   echo "image uploaded 1";
     }
   
   	$filename1=addslashes($filename1);
/*    	$tableName_send="photogallery";
   	$whereclause="id='$cid'";
   	$old =array("img_uplode");
   	$new =array("$filename1"); */
   	//$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
   	$sql = "UPDATE `photogallery` SET `img_uplode`='$filename1'  WHERE id='$cid'";
	$resu = $conn->query($sql);
   }	
   
   
    if (move_uploaded_file($_FILES["txtuplode"]["tmp_name"], $add_img)) {
   echo "image uploaded";
     }
   
   if (move_uploaded_file($_FILES["txtuplode"]["tmp_name"], $add_thumb)) {
   echo "image uploaded 1";
     }
   }		
   		$tableName_send="photogallery";
   	$whereclause="id='$cid'";
   	$cat=$_POST['txtcategory'];
   	$rq = mysqli_query($conn, "select * from category where c_id='$cat'");
	$rr = mysqli_fetch_array($rq);
	$event_url=$rr['event_url'];
 
      //ini_set('display_errors', 1);
	    //error_reporting(E_ALL);
	
/*    	$old=array("sortdesc","sort_desc_hindi","approve_status","category_id","admin_id","page_url");
   $new=array("$txtepage_title","$txtepage_title1","$txtstatus","$txtcategory","$user_id","$event_url");
   $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new); */
   $dsf = "UPDATE `photogallery` SET `sortdesc`='$txtepage_title',`sort_desc_hindi`='$txtepage_title1',`approve_status`='$txtstatus',`category_id`='$txtcategory',`admin_id`='$user_id',`page_url`='$event_url'  WHERE id='$cid'";
   $resuu = $conn->query($dsf);
   
   $user_login_id=$_SESSION['admin_auto_id_sess'];
   $page_id=$cid;
   $action="Update";
   $categoryid='3';
   $date=date("Y-m-d h:i:s");
   $ip=$_SERVER['REMOTE_ADDR'];
   //$tableName="audit_trail";
/*    $tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title");
   $tableFieldsValues_send=array("$user_login_id","$page_id","$url","$action","$model_id","$date","$ip","$txtlanguage","$txtepage_title");
   $value=$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send); */
   
   //$insert = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`) VALUES ('$user_login_id','$page_id','$url','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title')";
  // $resqu = $conn->query($insert);
   $msg=UPDATE;
   $_SESSION['content']=$msg;
   $_SESSION['token'] = "";
   	$_SESSION['uniq'] ="";
   	
   header("location:photo_by_category_id.php?cat_id=".$_POST['cat_id']."");
   exit;
   
   }
   
   
   }
   	
   
   
   
    if($_GET['did']!='')
    {
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
			mysqli_query($conn, "delete from photogallery where id='$did'"); 
			
			$_SESSION['SESS_MSG'] = " Record Successfully Delete";
			header("Location:photo_by_category_id.php?cat_id=".$_GET['id']."");
			//header("Location:gallery-category.php");
			exit;
		
		}
    }
   			
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Manage Media Categories : <?php echo $sitename;?></title>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/demo.js"></script>
		<link href="style/admin.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-latest.js"></script>
		<script src="js/jquery.tinylimiter.js"></script>
		<script>
			$(document).ready( function() {
				var elem = $("#chars");
				$("#text").limiter(250, elem);
			});
		</script>
		<script type="text/javascript">
			function isNumberKey(evt){
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57)){
					return false;
				}else{
					return true;
				}
			}  
         
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
	
    function goBack(){
    window.history.back();
}
</script>
		<style>
			table {
			  border-collapse: collapse;
			  border-spacing: 0;
			  width: 100%;
			  border: 1px solid #ddd;
			}
			th, td {
			  text-align: left;
			  padding: 8px;
			}
			tr:nth-child(even){background-color: #f2f2f2}
		</style>
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
                     <p><img alt="error" src="images/error.png"> <span>Attention! </span><?php echo $errmsg; ?></p>
                  </div>
               </div>
               <?php }?>
               <?php if($_SESSION['SESS_MSG']!=""){?>
               <div  id="msgclose" class="status success">
                  <div class="closestatus" style="float: none;">
                     <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                     <p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo "Record has been Updated successfully."; ?></p>
                  </div>
               </div>
               <?php }?>	
               <div class="clear"></div>
				<div class="addmenu">
					<div class="internalpage_heading">
						<h3 class="manageuser">Manage Photo Gallery</h3>
						<div class="right-section" style="margin-top: 15px; margin-right: 2%;">
							<button class="bt90" title="Go Back" onclick="window.history.go(-1)" ><strong>Back</strong></button>
						</div>
					</div>
					<div class="grid_view">
						<?php	if($_GET['id']!='') {
								$rq = mysqli_query($conn,"SELECT * FROM photogallery LEFT JOIN category ON category.c_id=photogallery.category_id WHERE id='".$_GET['id']."'");
								$rr = mysqli_fetch_array($rq);
								$id=$rr['p_type'];
								$module=$rr['m_type'];
                        ?> <?php } ?>
						<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
							<div class="frm_row">
							   <span class="label1">
							   <label for="hometype">Category Name:</label>
							   <span class="star">*</span></span> <span class="input1">
							   <input name="txtename" type="text" size="50" class="input_class" id="txtename" readonly value="<?php echo html_entity_decode($rr['c_name']);?>" />
							   </span>
							   <div class="clear"></div>
							</div>
							<div class="frm_row">
							   <span class="label1">
							   <label for="txtename"> Name:</label>
							   <span class="star">*</span></span> <span class="input1">
							   <input name="txtename" type="text" size="50" class="input_class" id="txtename" value="<?php echo html_entity_decode($rr['sortdesc']);?>" />
							   </span>
							   <div class="clear"></div>
							</div>
							<div class="frm_row">
							   <span class="label1">
							   <label for="txtenamehi">Hindi Name:</label>
							   <span class="star">*</span></span> <span class="input1">
							   <input name="txtenamehi" type="text" size="50" class="input_class" id="txtenamehi" value="<?php echo html_entity_decode($rr['sort_desc_hindi']);?>" />
							   </span>
							   <div class="clear"></div>
							</div>
							<div class="frm_row">
							   <span class="label1">
							   <label for="txtuplode">Image Upload :</label>
							   </span> <span class="input1">
							   <input type="file" name="txtuplode" id="txtuplode"/><?php if($rr['img_uplode'] !='') {?>
							   <img src="../../upload/photogallery/media/<?php echo $rr['img_uplode'];?>" alt="" title="" align="center" width="80" height="90" />
							   <?php }?> 
							   </span>
							   <strong> <a href="https://pixlr.com/editor/" title="If images not less then 1 MB, online reduce the image size." onclick="sitevisit();" target="_blank">Image upload less then 4 MB</a></strong>
							   <input type="hidden" value="<?php echo $rr['c_id'];?>" name="cat_id">
							   <div class="clear"></div>
							</div>
							<div class="frm_row">
							   <span class="label1">
							   <label for="user_status">Status:</label>
							   <span class="star">*</span></span> 
							   <span class="input1">
								  <select name="user_status" id="user_status" autocomplete="off">
									 <option value=""> Select </option>
										<option value="1" <?php if($rr['approve_status']==1){ echo "selected"; } ?>>Draft</option>
										<option value="2" <?php if($rr['approve_status']==2){ echo "selected"; } ?>>Approval</option>
										<option value="3" <?php if($rr['approve_status']==3){ echo "selected"; } ?>>Publish</option>
								  </select>
							   </span>
							   <div class="clear"></div>
							</div>
							<div class="frm_row"> 
								<span class="button_row">
									<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="<?php if($_GET['id']!='') { echo 'Update';} else { echo'Submit';}?>" />
									<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
									<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
									<input type="button" class="button" value="Back" onClick="javascript:location.href ='gallery-category.php';"/>
								</span>
							</div>
							<div class="clear"></div>
						</form>
						<div class="clear"></div>
					</div>
					<div style="overflow-x:auto;">
						<table class="table table-responsive">
							<thead>
								<tr>
								   <th>S.No</th>
								   <th>English Name</th>
								   <th>Hindi Name</th>
								   <th>Create Date</th>
								   <th>Status</th>
								   <th>Edit</th>
								   <th>Delete</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$columns = "select * ";
								$sql = "from photogallery where category_id=".$_GET['cat_id']."";
								$order_by == '' ? $order_by = 'id' : true;
								$order_by2 == '' ? $order_by2 = 'ASC' : true;
								$sql .= " order by $order_by $order_by2 ";
								$sql_count = "select count(*) ".$sql; 
								$sql = $columns.$sql;

								$rs = $conn->query($sql);
								$count = $rs->num_rows;
								if($count > 0){
									while($data=mysqli_fetch_array($rs)){
										if($data['approve_status']=='3'){
											$status="Active";
										}
										else{
											$status="Inactive";
										}
										$_GET['catid'] =  $data['category_id'];	
							?>
							<tr>
								<td><?php echo ++$counter;?></td>
								<td><?php echo html_entity_decode($data['sortdesc']);?></td>
								<td><?php echo html_entity_decode($data['sort_desc_hindi']);?></td>
								<td><?php if($data['createdate']!="" || $data['createdate']!=NULL) { echo date('d-m-Y',strtotime($data['createdate'])); }else {} ?></td>
								<td><?php echo html_entity_decode($status);?></td>
								<td width="47" align="center" class="left-tdtext"><a href="photo_by_category_id.php?id=<?php echo $data['id'];?>" class="bluelink"><input type="image" border="0" alt="Edit" src="images/edit.png"  title="Edit" /></a></td>
								<td width="63" align="center" class="left-tdtext"><a href="photo_by_category_id.php?did=<?php echo $data['id'];?>&random=<?php echo $_SESSION['logtoken'];?>&id=<?php echo $_GET['cat_id'];?>" class="bluelink" onClick="return confirm('Are you sure want to delete record')"><input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a></td>
							</tr>
							<?php }}else{	?>
								<tr>
								   <td style="color:#F00;text-align:center;" colspan="7"><b>Sorry.. No records available.</b></td>
								</tr>
							<?php }?> 
							</tbody>
						</table>
					</div>
               </div>
            </div>
            <!-- right col -->
            <div class="clear"></div>
            <!-- Content Area end -->
         </div>
         <!-- main con-->
      </div>
      <!-- Container div-->
      <!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
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