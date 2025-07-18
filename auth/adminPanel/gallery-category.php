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
	if($role_id_page==0){
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}
	if(isset($_POST['Submit_g']) && $_GET['id']=='')
	{
		if($_SESSION['logtoken']!=$_POST['random']){
			session_unset($admin_auto_id_sess);
			session_unset($login_name);
			session_unset($dbrole_id);
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
		}else{
			$_COOKIE['Temp']		=	"";
			$_SESSION['saltCookie']	=	"";
			$_SESSION['Temptest']	=	"";
			$saltCookie 			=	uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] =	$saltCookie;
			$_SESSION['Temptest']	=	$_SESSION['saltCookie'];
			setcookie("Temp",$_SESSION['saltCookie']);
			$_SESSION['logtoken'] 	=	md5(uniqid(mt_rand(), true));

			$user_status	=	content_desc($_POST['user_status']);
			$startdate		=	content_desc($_POST['startdate']);
			$cat_id			=	content_desc($_POST['hometype']);
			$txtename		=	content_desc($txtename);
			$txtenamehi		=	content_desc($txtenamehi);
			$errmsg="";

			if(trim($cat_id)==""){
				 $errmsg .="Please select media Gallery."."<br>";
			}
			if(trim($txtename)==""){
				$errmsg .="Please enter name."."<br>";
			}
			if(trim($txtenamehi)==""){
				$errmsg .="Please enter hindi name."."<br>";
			}
			if(trim($startdate)==""){
				$errmsg .="Please enter Uploaded Date."."<br>";
			}

			if(trim($user_status)==""){
				$errmsg .="Please select status."."<br>";
			}
      
     
      
			if($errmsg==''){
				$sql ="INSERT INTO `category`(`c_name`, `c_namehi`, `c_status`, `cat_id`, `create_date`) VALUES ('$txtename','$txtenamehi','$user_status','$cat_id','$startdate')";
				$res = $conn->query($sql);				
				$page_id=$conn->insert_id;
				$msg=CONTENTADD;
				$_SESSION['SESS_MSG']=$msg;
				header("location:gallery-category.php");
				exit;	
			}		
		}
	}
	//	Update Record Start
	if(isset($_POST['Submit_g']) && $_GET['id']!='')
	{
		$user_status	=	trim($_POST['user_status']);
		$startdate		=	trim($_POST['startdate']);
		$txtename1		= 	trim($txtename);
		$txtenamehi		= 	trim($txtenamehi);
		$cat_id			=	trim($_POST['hometype']);
		
		if(trim($cat_id)==""){
			$errmsg .="Please select media Gallery."."<br>";
		}
		if(trim($txtename)==""){
			$errmsg .="Please enter name."."<br>";
		}
		if(trim($txtenamehi)==""){
			$errmsg .="Please enter hindi name."."<br>";
		}
		if(trim($startdate)==""){
			$errmsg .="Please enter Uploaded Date."."<br>";
		}
		if(trim($user_status)==""){
			$errmsg .="Please select status."."<br>";
		}
		if($errmsg=='')
		{ 
			$tableName_send="category";
			$whereclause="c_id='".$_GET['id']."'";
			if($_SESSION['logtoken']!=$_POST['random']){
				$msg = "Login to Access Admin Panel";
				$_SESSION['SESS_MSG']= $msg ;
				header("Location:error.php");
				exit();
			}else {
				$_COOKIE['Temp']="";
				$_SESSION['saltCookie']="";
				$_SESSION['Temptest']="";
				$saltCookie =uniqid(rand(59999, 199999));
				$_SESSION['saltCookie'] =$saltCookie;
				$_SESSION['Temptest']=$_SESSION['saltCookie'];
				setcookie("Temp",$_SESSION['saltCookie']);
				$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
			}
      
     
      
			$sql = "UPDATE `category` SET `c_name`='$txtename',`c_namehi`='$txtenamehi',`c_status`='$user_status',`cat_id`='$cat_id',`create_date`='$startdate' WHERE c_id='".$_GET['id']."'";
			$resu = $conn->query($sql);
			$msg=CONTENTUPDATE;
			$_SESSION['SESS_MSG']=$msg;
			header("location:gallery-category.php");
			exit;	
		}
	}

	if($_GET['did']!='')
	{
		if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($did))))
		{
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
		}else{
			$_COOKIE['Temp']		=	"";
			$_SESSION['saltCookie']	=	"";
			$_SESSION['Temptest']	=	"";
			$saltCookie 			=	uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] =	$saltCookie;
			$_SESSION['Temptest']	=	$_SESSION['saltCookie'];
			setcookie("Temp",$_SESSION['saltCookie']);
			$_SESSION['logtoken'] 	=	md5(uniqid(mt_rand(), true));
			$sql 					=	"delete from category where c_id='$did'";
			$res 					=	$conn->query($sql);
			$_SESSION['SESS_MSG'] 	= 	"Record Successfully Delete";
			header("Location:gallery-category.php");
			exit;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Manage Media Categories : <?php echo $sitename;?></title>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/demo.js"></script>
	<link href="style/admin.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-latest.js"></script>
	<script src="js/jquery.tinylimiter.js"></script>
	<script type="text/javascript" src="js/jsDatePick.js"></script>
	<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
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
				dateFormat:"%Y-%m-%d"
			});
		};

		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57)){
				return false;
			}else{
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
			<?php include_once('main_menu.php'); ?>
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
				<?php } if($_SESSION['SESS_MSG']!=""){?>
					<div  id="msgclose" class="status success">
						<div class="closestatus" style="float: none;">
							<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
							<p><img alt="Attention" src="images/approve.png" class="margintop"><span>Attention!</span><?php echo $_SESSION['SESS_MSG']; ?></p>
						</div>
					</div>
				<?php }?>	
					<div class="clear"></div>

					<div class="addmenu"> 
						<div class="internalpage_heading">
							<h3 class="manageuser">Manage Media Categories </h3>
							<div class="right-section">
								<!--<ul>
								<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li  class="new-icon">
								<a href="gallery-category.php" title="New"><span class="icon-28-new"></span>New</a></li>
								<li class="divider"> </li><?php }?>
								</ul>-->
							</div>
						</div>	
						<div class="grid_view">
							<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
								<?php	
									if($_GET['id']!=''){
										$rq = "select * from category where c_id='".$_GET['id']."'";
										$rs = $conn->query($rq);
										$rr = $rs->fetch_array();
										$id=$rr['p_type'];
										$module=$rr['m_type'];
									}
								?>   
								<div class="frm_row"> 
									<span class="label1">
										<label for="hometype">Media Gallery:</label>
										<span class="star">*</span>
									</span> 
									<span class="input1">
										<select name="hometype" id="hometype"  autocomplete="off">
											<option value=""> Select </option> 	
											<?php  foreach($media_type as $key=>$value){?>
												<option value="<?php echo $key;?>" <?php if($rr['cat_id']==$key){ echo 'selected'; } ?>> <?php echo $value;?> </option>
											<?php } ?>
										</select>
									</span>
									<div class="clear"></div>
								</div>

								<div class="frm_row"> <span class="label1">
									<label for="txtename"> Name:</label>
									<span class="star">*</span></span> <span class="input1">
									<input name="txtename" type="text" size="50" class="input_class" id="txtename" value="<?php echo html_entity_decode($rr['c_name']);?>" />
									</span>
									<div class="clear"></div>
								</div>

								<div class="frm_row"> <span class="label1">
									<label for="txtenamehi">Hindi Name:</label>
									<span class="star">*</span></span> <span class="input1">
									<input name="txtenamehi" type="text" size="50" class="input_class" id="txtenamehi" value="<?php echo html_entity_decode($rr['c_namehi']);?>" />
									</span>
									<div class="clear"></div>
								</div>
								<div class="frm_row"> <span class="label1">
									<label for="startdate">Start Date:</label><span class="star">*</span>
									</span> <span class="input1">
									<input type="text" name="startdate" id="dob" readonly="" class="input_class" autocomplete="off" value="<?php //if($rr['create_date'] !=''){ echo changeformate($rr['create_date']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 
									</span>
									<div class="clear"></div>
								</div>
								<div class="frm_row"> <span class="label1">
									<label for="user_status">Status:</label>
									<span class="star">*</span></span> <span class="input1">
									<select name="user_status" id="user_status" autocomplete="off">
									<option value=""> Select </option>
									<?php 
									foreach($status as  $key => $value)
									{
									?>
									<option value="<?php echo $key; ?>"<?php if($key==$rr['c_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
									<?php }
									?>
									</select></span>
									<div class="clear"></div>
								</div>

								<div class="frm_row"> <span class="button_row">
									<input name="Submit_g" type="submit" class="button" id="cmdsubmit" value="Submit" />
									<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
									<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
									<input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_photo_gallery.php';" />
									</span>
								</div>
								<div class="clear"></div>
							</form>
							
							<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">
							<tr bgcolor="whitesmoke">
							<th width="38" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">S.No</th>
							<th width="510" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Name</span></th>
							<th width="510" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Hindi Name</span></th>
							<th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Status</th>
							<th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Add</th>
							<th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Edit</th>
							<th width="63" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</th>
							<th width="63" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">View</th>
							</tr>
							<?php 
							$columns = "select * ";
							$sql = "from category where 1 ";
							$order_by == '' ? $order_by = 'c_id' : true;
							$order_by2 == '' ? $order_by2 = 'DESC' : true;
							$sql .= "order by $order_by $order_by2 ";
							$sql_count = "select count(*) ".$sql; 
							$sql = $columns.$sql;
							$result = $conn->query($sql);

							$pager = new PS_Pagination($link, $result,"");
							$rs = $pager->paginate();
							if($result->num_rows == 0){
							?>
							<tr><td style="color:#F00;" height="30" align="center" colspan="6"><b>Sorry.. No records available.</b></td></tr>
							<?php	}else	{	?>

							<?php 
								while($data = $result->fetch_array()){
							
									$dsql = "select id from photogallery where category_id='".$data['c_id']."'"; 
									$s_res = $conn->query($dsql);

									if($data['c_status']=='1'){
										$status="Active"; 
									}else{
										$status="Inactive";
									}
							?>
							<tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
							<td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
							<td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['c_name']);?></td>
							<td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['c_namehi']);?></td>
							<td width="50" align="left" class="left-tdtext"><?php echo html_entity_decode($status);?></td>
							<td>
								<a href="add_photos.php?cat_id=<?php echo $data['c_id'];?>" class="bluelink"><input type="image" alt="View Photo" title="view photo" src="<?php echo $HomeURL?>/images/extlink.png">Add Photo</a>
							</td>
							<td width="47" align="center" class="left-tdtext">
								<a href="gallery-category.php?id=<?php echo $data['c_id'];?>" class="bluelink"><input type="image" border="0" alt="Edit" src="images/edit.png"  title="Edit" /></a>
							</td>
							<td width="63" align="center" class="left-tdtext">
								<a href="gallery-category.php?did=<?php echo $data['c_id'];?>&random=<?php echo $_SESSION['logtoken'];?>" class="bluelink" onClick="return confirm('Are you sure want to delete record')">
								<input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a>
							</td>
							<td width="63" align="center" class="left-tdtext">
								<a href="photo_by_category_id.php?cat_id=<?php echo $data['c_id'];?>" class="bluelink"><input type="image" alt="View Photo" title="view photo" src="<?php echo $HomeURL?>/images/extlink.png">View Photo</a>
							</td>
							
							</tr>
							<?php } }	?> 
							</table>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>  <!-- main con-->
		</div> <!-- Container div-->
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

