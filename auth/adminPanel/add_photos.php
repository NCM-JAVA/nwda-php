<?php ob_start();
	include("../../includes/config.inc.php");
	require_once "../../includes/connection.php";
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
	if(isset($cmdsubmit) && $_GET['editid']=='')
	{
		$txtcategory = trim($_POST['txtcategory']);
		$txtepage_title= trim($_POST['txtepage_title']);
		$txtepage_title1= trim($_POST['txtepage_title1']);
		$txtstatus=trim($_POST['txtstatus']);
		$createdate=date('Y-m-d');
		$errmsg="";  

	if(trim($txtcategory)==""){
		$errmsg .="Please Select Category Name."."<br>";
	}
	if(trim($txtepage_title)==""){
		$errmsg .="Please enter Image Title (English)."."<br>";
	}

	if($_FILES["txtuplode"]["tmp_name"]==""){
		$errmsg .= "Please Uploade GIF,PNG,JPG and JPEG images."."<br>";
	}
	elseif ($_FILES["txtuplode"]["tmp_name"]!=""){
		$tempfile=($_FILES["txtuplode"]["tmp_name"]);
		$imageinfo = ($_FILES["txtuplode"]["type"]);
		$section = strtoupper(base64_encode(file_get_contents($tempfile)));
		$nsection=substr($section,0,8);
		
		if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"])){
			$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
		}else if ( $section != strip_tags($section) ){
			$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
		}else{
			$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);
			$extarray = explode(".",$_FILES["txtuplode"]["name"]);
			if(count($extarray)>2){
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
	if ($_FILES["txtuplode"]["tmp_name"]!="")
	{
	$max_upload_width = 891;
	$max_upload_height = 546;

	$image=$_FILES['txtuplode']['name'];
	$filename1=$_FILES['txtuplode']['tmp_name'];
	$add_img='../../upload/photogallery/media/'.$image;
	$add_thumb='../../upload/photogallery/media/thumb/'.$image;
	if ($filename1!=""){
	$PATH="../../upload/photogallery/media/";
	if(!is_dir($PATH)){  
	mkdir($PATH,0777);
	}
	$PATH=$PATH."/";
	// Now let's move the uploaded image into the folder: image
	if (move_uploaded_file($filename1, $PATH.$image)) {
	//echo "<h3>  Image uploaded successfully!</h3>";
	} else {
	//echo "<h3>  Failed to upload image!</h3>";
	}
	}
	if ($filename1!=""){

	$PATH2="../../upload/photogallery/media/thumb/";
	if(!is_dir($PATH2)){  
	mkdir($PATH2,0777);
	}
	$PATH=$PATH."/";
	if (move_uploaded_file($filename1, $PATH2.$image)) {
	echo "<h3>  Image uploaded successfully!</h3>";
	} else {
	//echo "<h3>  Failed to upload image!</h3>";
	}
	}

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
	$cat=$_POST['txtcategory'];
	$rq = "select * from category where c_id='$cat'";
	$rs = $conn->query($rq);
	$rr = $rs->fetch_array();

	$sql = "INSERT INTO `photogallery` (`img_uplode`,`sortdesc`,`sort_desc_hindi`,`approve_status`,`gallery_type`,`category_id`,`admin_id`,`createdate`,`page_url`)VALUES ('$image','$txtepage_title','$txtepage_title1','$txtstatus','1','$txtcategory','$user_id','$createdate','$event_url')";

	$sqli1 = $conn->query($sql);

	$user_id=$_SESSION['admin_auto_id_sess'];
	$page_id=$conn->insert_id;
	$action="Insert";
	$categoryid='1'; 
	$date=date("Y-m-d h:i:s");
	$ip=$_SERVER['REMOTE_ADDR'];

	$sql1 = "INSERT INTO `audit_trail` (`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`,`approve_status`)VALUES ('$user_id','$page_id','$txtename','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title',$txtstatus')";

	$msg=CONTENTADD;
	$_SESSION['content']=$msg;
	header("Location:add_photos.php?cat_id=".$txtcategory."");
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
			header("Location:add_photos.php?cat_id=".$_GET['id']."");
			//header("Location:gallery-category.php");
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Manage Photo Gallery add/update: <?=$sitename;?></title>
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<link href="style/admin.css" rel="stylesheet" type="text/css">
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
			if(a){}else{
				alert('offline');
				window.location='index.php';
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
			<?php include_once('main_menu.php'); ?>
				<!-- Header end -->
				<div class="main_con">
					<div class="admin-breadcrum">
						<div class="breadcrum">
							<span class="submenuclass"><a href="welcome.php" title="Dashboard">Dashboard</a></span>
							<span class="submenuclass">>> </span> 
							<span class="submenuclass"><a href="manage_photo_gallery.php" title="Manage Photo Gallery">Manage Photo Gallery</a></span>
							<span class="submenuclass">>> </span> 
							<span class="submenuclass">Add Photo Gallery</span>
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
								<h3 class="manageuser">Add Photo Gallery </h3>
								<div class="right-section"></div>
							</div>
							<div class="grid_view">
								<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_cp('form1')">
									<?php	
										if($_GET['editid']!=''){
											$rq = "select * from photogallery where id='".$_GET['editid']."'";
											$rs = $conn->query($rq);
											$rr = $rs->fetch_array();
										}
									?>   
									<div class="frm_row">
										<span class="label1">
											<label for="txtcategory">Category Name :</label><span class="star">*</span>
										</span> 
										<span class="input1">
											<?php 
											$CatgorySql="Select * from category where cat_id='1'  order by c_id asc";
											$rs = $conn->query($CatgorySql);
											$CategoryNum = $rs->num_rows;
											?>
											<select name="txtcategory" id="txtcategory" autocomplete="off" onchange="document.getElementById('myhidden').value=this.value" >
												<option  value="">Select</option>
												<?php while($CategoryNum =$rs->fetch_array()){ ?>
													<option value="<?php echo $CategoryNum['c_id'];?>"<?php if($txtcategory==$CategoryNum['c_id']) { echo "selected"; }  if($CategoryNum['c_id']==$_GET['cat_id']){ echo "selected"; } ?>><?php echo $CategoryNum['c_name']; ?></option>
												<?php } ?>
											</select>
											<input type='hidden' name="myhidden"id='myhidden' value="<?php echo $_POST['txtcategory'];?>">
										</span>
										<div class="clear"></div>
									</div>
									<div class="frm_row">
										<span class="label1">
											<label for="txtepage_title">Image Title (English) :</label><span class="star">*</span>
										</span> 
										<span class="input1">
											<input type="text" name="txtepage_title" autocomplete="off" id="txtepage_title" class="input_class"  value="<?php  if (htmlspecialchars($txtepage_title != "")) { echo htmlspecialchars($txtepage_title);} if(htmlspecialchars($rr['sortdesc']!="")){ echo htmlspecialchars($rr['sortdesc']);} ?>" />
										</span>
										<div class="clear"></div>
									</div>
									<div class="frm_row">
										<span class="label1">
											<label for="txtepage_title1">Image Title (Hindi) :</label>
										</span> 
										<span class="input1">
											<input type="text" name="txtepage_title1" autocomplete="off" id="txtepage_title1" class="input_class"  value="<?php if (htmlspecialchars($txtepage_title1 != "")) { echo htmlspecialchars($txtepage_title1);} if(htmlspecialchars($rr['sort_desc_hindi']!="")){ echo htmlspecialchars($rr['sort_desc_hindi']);} ?>" />
										</span>
										<div class="clear"></div>
									</div>
									<div class="frm_row">
										<span class="label1">
											<label for="txtuplode">Image Upload :</label>
										</span> 
										<span class="input1">
											<input type="file" name="txtuplode" id="txtuplode"/>
											<?php if($rr['img_uplode'] !='') {?>
												<img src="../../upload/photogallery/media/thumb/<?php echo $rr['img_uplode'];?>" alt="" title="" align="center" width="80" height="90" />
											<?php }?> 
										</span>
										<strong> <a href="https://pixlr.com/editor/" title="If images not less then 1 MB, online reduce the image size." onclick="sitevisit();" target="_blank">Image upload less then 4 MB</a></strong>
										<div class="clear"></div>
									</div>
									<div class="frm_row">
										<span class="label1">
											<label for="txtstatus">Page Status:</label><span class="star">*</span>
										</span> 
										<span class="input1">
											<select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
												<option value=""> Select </option>
												<?php if($user_id =='101'){
														$sql="select * from content_state where state_status=1";
														$res = $conn->query($sql);
														while($row = $res->fetch_array()){ 
												?>
												<option value="<?php echo $row['state_id'];?>" <?php  if ($txtstatus==$row['state_id']) echo 'selected="selected"';  if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
												<?php }} else if($user_id !='101' ){
														$sql=mysqli_query($conn, "select * from content_state");
														$res1 = $conn->query($sql);
														while($row = $res1->fetch_array()){  
															if($row['state_short']==$role_map['draft']){
												?>
												<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"'; if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
												<?php }
												if($row['state_short']==$role_map['mapprove']){
												?>
												<option value="<?php echo $row['state_id'];?>" <?php if ($txtstatus==$row['state_id']) echo 'selected="selected"'; if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?>><?php echo $row['state_name']; ?></option>
												<?php }
												if($row['state_short']==$role_map['publish']){
												?>
												<option value="<?php echo $row['state_id'];?>" <?php if ($rr['approve_status']==$row['state_id']) echo 'selected="selected"';?>><?php echo $row['state_name']; ?></option>
												<?php } } } ?>
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
											<input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_photo_gallery.php';" />
										</span>
										<div class="clear"></div>
									</div>
								</form>
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
										   <td style="color:#F00;text-align:center;" colspan="6"><b>Sorry.. No records available.</b></td>
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
			<?php 
			include("footer.inc.php");
			?>
			<!-- Footer end -->
		</div> <!-- Container div-->
	</body>
</html>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
function sitevisit()
{
if (! confirm('This is external link, Are you sure you want to continue?')) 
return false;
}
</script>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
</script>
<style>
.hide {display:none;}
</style>