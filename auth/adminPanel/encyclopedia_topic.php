<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/connection.php");
//include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
require_once("../../includes/ps_pagination.php");

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "15";
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
	if($_SESSION['admin_auto_id_sess']=='')	{		
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
	if(isset($_POST['Submit_g']) && $_GET['id']==''){
		$salt =rand(19999, 29999);
		$salt1 =rand(31999, 59999);
				
		if($_SESSION['logtoken']!=$_POST['random']){
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
			$result = "select * from  signup where  user_status='1'  and id='$user_id'";
			$rs 	= $conn->query($result);
			$line   = $rs->fetch_array();
			$user_name = $line['user_name'];
			$user_status=trim($_POST['user_status']);
			$title=trim($_POST['title']);
			$txtename= trim(str_replace("'", '', $txtename));
			if(trim($title)==""){
				$errmsg .="Please Enter Title Name."."<br>";
			}

			if(trim($txtename)==""){
				$errmsg .="Please Enter Message."."<br>";
			}
			if(trim($user_status)==""){
				$errmsg .="Please Select Status."."<br>";
			}
			if($errmsg ==""){
				$doj=date("Y-m-d h:m:s");
				$sql="insert into encyclopedia_threadlist set 
				Title='$title',short_des='$txtename',CreationDate='$doj',Author='$user_name',Posts ='1',t_status='$user_status'";
				$res=$conn->query($sql);
				$id=$conn->insert_id;

				$_SESSION['SESS_MSG']= INSERT;
				header("Location: encyclopedia_topic.php");
				exit;	
			}		
		}
	}

//	Update Record Start
	if(isset($_POST['Submit_g']) && $_GET['id']!=''){
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
			$result = "select * from  signup where  user_status='1'  and id='$user_id'";
			$rs 	= $conn->query($result);
			$line   = $rs->fetch_array();
			$user_name = $line['user_name'];
			$user_status=trim($_POST['user_status']);
			$title=trim($_POST['title']);
			$txtename= trim(str_replace("'", '', $txtename));
			
			if(trim($title)==""){
				$errmsg .="Please Enter Title Name."."<br>";
			}
		
			if(trim($txtename)==""){
				$errmsg .="Please Enter Message."."<br>";
			}
			if(trim($user_status)==""){
				$errmsg .="Please Select Status."."<br>";
			}
			
			if($errmsg ==""){
				$doj=date("Y-m-d h:m:s");
				$sql = "update encyclopedia_threadlist set Title='$title',short_des='$txtename',CreationDate='$doj',Author='$user_name',t_status='$user_status' where ThreadID='$id'";	
				$rs = $conn->query($sql);
				$_SESSION['SESS_MSG']=UPDATE;
				header("Location: encyclopedia_topic.php");
				exit;
			}	
		}
	}
	
	if($_GET['did']!=''){
		$del = "delete from encyclopedia_threadlist where ThreadID='$did'";
		$rr = $conn->query($del);
		$_SESSION['SESS_MSG'] =DELETE;
		header("Location:encyclopedia_topic.php");
		exit;
	}
	

 /* $edit_contrator ="select * from encyclopedia_threadlist where ThreadID=".$_GET['id'];
$cresult = $conn->query($edit_contrator);
$res_rows = $cresult->num_rows;

$result = $cresult->fetch_array();

@extract($fetch_result);
$editors=$short_des;  */

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Encyclopedia New Topic : <?=$sitename; ?></title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/demo.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
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
       <div  id="msgclose" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['SESS_MSG']; ?></p>
</div>
</div>
          <?php }?>	
      	<div class="clear"></div>
     
        	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser">Manage Encyclopedia New Topic </h3>
<div class="right-section">

			 <!--<ul>
			
<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li  class="new-icon">
<a href="gallery-category.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <li class="divider"> </li><?php }?>
             
            </ul>
			-->
 </div>
 </div>	
        <div class="grid_view">
		<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
	<?php	
		if($_GET['id']!='')
		{
			$rq = "select * from encyclopedia_threadlist where ThreadID='".$_GET['id']."'";
			$rs = $conn->query($rq);
			$rr = $rs->fetch_array();
		}
	?>   

<div class="frm_row"> 
			<span class="label1">
			<label for="title">Title:</label>
			<span class="star">*</span></span> <span class="input1">
			<input type="text" name="title" size="50" id="title" value="<?php echo html_entity_decode($rr['Title']);?>" />
			</span>
			<div class="clear"></div>
			</div>
		
     		   <div class="frm_row"> <span class="label1">
              <label for="text"> Message:</label>
              <span class="star">*</span></span> <!-- <span class="input1">
			  <textarea id="text" name="txtename" maxlength="250" cols="40" rows="7" placeholder="Enter Message"><?php echo html_entity_decode($rr['short_des']);?></textarea> 	
	<div id="chars">Maximum 250 characters</div>
				</span> -->

				     <span class="star">*</span></span> <span class="input_fck">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/disability/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/disability/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/disability/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/disability/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtename',stripslashes(html_entity_decode($rr['short_des'])));
		?>        </span>

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
<option value="<?php echo $key; ?>"<?php if($key==$rr['t_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
	</span>
				<div class="clear"></div>
		    </div>
    
      <div class="frm_row"> <span class="button_row">
		<input name="Submit_g" type="submit" class="button" id="cmdsubmit" value="Submit" />
            
            
            <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
             <input type="button" class="button" value="Back" onClick="javascript:location.href = 'encyclopedia_topic.php';" />
	</span>
</div>
<div class="clear"></div>

  </form>
	<table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">
	  <tr bgcolor="whitesmoke">
    <th width="38" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">S.No</th>
    <th width="68" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">Post Date</th>
    <th width="510" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text"> Tiltel Message</span></th>
    <th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Status</th>
	<th width="47" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Edit</th>
    <th width="63" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</th>
    </tr>
	<?php 
	$columns = "select * ";
$sql = "from encyclopedia_threadlist where 1 ";
$order_by == '' ? $order_by = 'CreationDate' : true;
$order_by2 == '' ? $order_by2 = 'DESC' : true;
$sql .= "order by $order_by $order_by2 ";
$sql_count = "select count(*) ".$sql; 
$sql = $columns.$sql;
$result = $conn->query($sql);
	$pager = new PS_Pagination($link, $result,"");
			//$rows = $pager->paginate();
			$rows = $result->num_rows;
	if($rows==0) { ?>
    <tr><td style="color:#F00;" height="30" align="center" colspan="5"><b>Sorry.. No records available.</b></td></tr>
<?php	}else	{	?>
    
<?php 
while($data = $result->fetch_array()){
?>
  <tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
    <td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
    <td width="68" align="left" class="left-tdtext"><?php echo change_date_full_formate($data['CreationDate']); ?></td>
    <td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['Title']);?></td>
				<td width="47" align="center" class="left-tdtext"><?php echo active($data['t_status']);?></td>
    <td width="47" align="center" class="left-tdtext"><a href="encyclopedia_topic.php?id=<?php echo $data['ThreadID'];?>" class="bluelink" title="Edit">Edit</a></td>
    <td width="63" align="center" class="left-tdtext"><a href="encyclopedia_topic.php?did=<?php echo $data['ThreadID'];?>" class="bluelink" onClick="return confirm('Are you sure want to delete record')" title="Delete">Delete</a></td>
  </tr>
<?php	}?>
	<tr>
<td colspan="6" align="center"><?php echo $pager->renderFullNav();?></td>
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

