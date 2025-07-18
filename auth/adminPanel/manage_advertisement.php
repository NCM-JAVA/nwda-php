<?php ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
require_once("../../includes/ps_pagination.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
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
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
if($_SESSION['saltCookie']!=$_COOKIE['Temp'])
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
if($_SESSION['lname'] =="")
{
$_SESSION['lname']='English';
}
if($_SESSION['lname']=='English')
{
$language='1';
}
else if($_SESSION['lname']=='Hindi')
{
$language='2';
}
if($deleteid !='')
{
if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($deleteid))))
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
	
	}
 $check_status=check_delete($user_id,$role_id,$model_id);
			if($check_status >0)
			{
			
			 $sqd = "select advertisedoc FROM advertisement_mst WHERE advertiseid=$cid";
					echo $sql="Delete From advertisement_mst where advertiseid='$deleteid'";
					$res=mysql_query($sql);
					$page_id=mysql_insert_id();
					
    $rs = mysql_query($sqd);
	$row=mysql_fetch_array($rs);

    $image_path = "../../upload/photogallery/".$row['advertisedoc'];
    $image_path2 = "../../upload/photogallery/thumb/".$row['advertisedoc'];
    unlink($image_path);
   unlink($image_path2);	
					$SQL1 = "SELECT * FROM audit_trail where page_id='$deleteid'";
				    $Query = mysql_query($SQL1);
					$pagename  = mysql_result($Query,0,'page_name');
					$txtlanguage  = mysql_result($Query,0,'lang');
					$txtstatus  = mysql_result($Query,0,'approve_status');
					$gallery_categoryname  = mysql_result($Query,0,'page_title');
					$user_id=$_SESSION['admin_auto_id_sess'];			
					$page_id=mysql_insert_id();
					$action="Delete";
					$categoryid='1'; //mol_content
					$date=date("Y-m-d h:i:s");
					$ip=$_SERVER['REMOTE_ADDR'];
					$model_id='Manage Latest New';

					$tableName="audit_trail";
					$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
					$tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
					$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

					if($res)
					{	
					header("location:delete.php?status=advertise_deleteid");
					}
			}
			else
			{
			/*session_unset($admin_auto_id_sess);
			session_unset($login_name);
			session_unset($dbrole_id); */
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
			}
	
}

if(($inactiveid !=''))
{
	if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($inactiveid))))	{
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

   $sql="Update advertisement_mst set txtstatus='1' where advertisement_mst='$inactiveid'";
 $res=mysql_query($sql);
  
	if($res)
	{	
	header("location:delete.php?status=advertise_inactiveid");
	}
}



?>
<?php 
   $sqlquery ="select * from advertisement_mst where 1";
   if($_POST['filter_search']!='')
   {
   $sqlquery .=" and advertisementno LIKE '%$filter_search%'"; 
   }
   if($_POST['user_status1']!='')
   {
   $sqlquery .=" and txtstatus='".$_POST['user_status1']."'"; 
   }
   $sqlquery .=" ORDER BY advertiseid DESC"; 
     
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Manage Advertisement: <?=$sitename; ?></title>
	<link href="style/admin.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
	<!--<script type="text/javascript" src="style/validation.js"></script>-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

<script>
	function MM_openBrWindow(theURL,winName,features) 
	{ 
		window.open(theURL,winName,features);
	}
	</script>
	
	</head>

	<body>
    
<?php include('top_header.php'); ?>
    
<div id="container"> 
      
    
  
  <div class="clear"></div>

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
 
  <div class="main_con">
       
       <div id="validterror" style="color:#F00" align="center"></div>   
        <div class="right_col1">
                  <div class="clear"></div>
		
          <?php if($_SESSION['content']!=""){?>
        <div  id="msgclose" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['content'];
$_SESSION['content']=""; ?>.</p>
</div>
</div>
                    <?php  
 }?>
  <?php if($_SESSION['errors']!=""){?> 
<div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $_SESSION['errors']; $_SESSION['errors']="";?></p>
</div>
</div>
  <?php }?>  

          
 

      <div class="clear"></div>
      <div class="internalpage_heading">
 <h3 class="manageuser">Manage Advertisement</h3>
 <div class="right-section">

			 <ul>
			
<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li class="new-icon">
<a href="advertisement.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <?php }?>
<?php if($role_map['medit']=='ED' || $user_id=='101'){?><li id="editer" class="edit-icon"><a href="#" onclick="alert('Please Select Manage Menu ')" title="Edit">Edit</a><?php }?></li>
             <?php if($role_map['mdelete']=='DE' || $user_id=='101'){?> 
			 <?php if ($txtstatus!='3'){?>
               <li id="delete" class="delete-icon"><a href="#" onclick="alert('Please Select Manage Menu')" title="Delete">Delete</a></li><?php } } ?>   
            </ul>
			
			
			
			
			
 
 </div>

 </div>
		
              <div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
            <div class="grid_view">
            <div class="new-gried">
            
 <form id="manage_menu" name="manage_menu" method="post" action="">
      <div class="filter-select fltrt">          
<label class="filter-search-lbl" for="filter_search">Filter:</label>
<input id="filter_search" type="text" title="Search title or Menu Name." value="" name="filter_search">
<select name="user_status1" id="user_status1" autocomplete="off">
	<option value=""> Select </option>
<?php 
foreach($status as  $key => $value)
{
	?>
<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php }
 ?>
</select>
 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>			
</div>
	            <div class="clear"></div>
          
              </form>
 
 </div>

 </div>
		
              <table width="100%"  border="1" cellspacing="0" cellpadding="0" summary="">
			<tr>
				<th width="52"></th>
				<th width="118">Advertise No</th>
				<th width="127">Post Applied </th>
				<th width="154">Last Date </th>
				<!--<th width="154">Payment Mode </th>-->
				<th width="127">User Status </th>
			</tr>

			<?php  
							$result = $conn->query($sqlquery);
							$pager = new PS_Pagination($link, $sqlquery,"");
							$rs = $pager->paginate();
							if($result->num_rows > 0){
							?>
							
							<?php 
							while($data = $result->fetch_array())
							{

							@extract($data);
							
							if($class=="odd")
							{
							$class="even";
							}
							else
							{
							$class="odd";
							}
							if($txtstatus=='1')
							{
							$txtstatus="Active";
							}
							else
							{
							$txtstatus="Inactive";
							}
							?>

			<tr class="<?php echo $class;?>">
				<td  align="left"> 
				<input  id="<?php echo $id; ?>" type="radio" name="radio1"  onclick="editlist(this.value);"  value="<?php echo $advertiseid; ?>">
							</td>
				<td  align="left" class="black-text1" ><?php echo $advertisementno; ?></td>
				<td  align="left"><?php 
				$sqladv="select post_id from advertisement_postapplied where postappliedid='".$advertiseid."'";
				$resadv=$conn->query($sqladv);
				while($rowadv=$resadv->fetch_array())
				{
				$postid=$rowadv['post_id']; 
				$sqlpost="select postname from post_mst where post_id='".$postid."'";
				$respost=$conn->query($sqlpost);
				$rowpost=$respost->fetch_array();
				echo $rowpost['postname']."<br>";
				}
				?></td>
				<td  align="left"><?php echo date("d-m-Y", strtotime($lastdate));?></td>
				<!--<td  align="left"><?php $paymode=$paymentmode;
				if($paymode=='1')
				{
				  echo "Online";
				}
				elseif($paymode=='2')
				{
				  echo "Offline";
				}
				
				?></td>-->
			    <td  align="left"><?php echo $txtstatus; ?></td>
			</tr>
			<?php
				}
				?>
				<tr>
<td colspan="7" align="center"><?php echo $pager->renderFullNav();?></td>
</tr>
				
				<?php
				}
			else
			{
			?>
			<tr>
				<td colspan="7" bgcolor="#ffffff" class="black-text textfield_smallest"  align="center">No record found.</td>
			</tr>
			<?php
			}?>
		</table>
             <!--  <div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->
          <div class="clear"></div>
            </div>
			
			
          <!-- right col -->
          
          <div class="clear"></div>
          
          
  </div>
      <!-- main con--> 
      
      <!-- Footer start -->
      
      <?php 
  
			include("footer.inc.php");
    ?>
      <!-- Footer end --> 
      
    </div>
<!-- Container div-->
<!-- Container div-->
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script> 
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script>
	function MM_openBrWindow(theURL,winName,features) 
	{ 
		window.open(theURL,winName,features);
	}
	</script>
	<script type="text/javascript">

jQuery(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  jQuery("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    jQuery("#response").hide();
	jQuery(function() {
	jQuery("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = jQuery(this).sortable("serialize") + '&update=update' + '&tab=combine'; 
			jQuery.post("updateList.php", order, function(theResponse){
				jQuery("#response").html(theResponse);
				jQuery("#response").slideDown('slow');
				slideout();
			}); 															 
		}								  
		});
	});

});	

</script>

<script type="text/javascript">

function editlist(id) {
    //generate the parameter for the php script
    var data = 'id=' + id;
    jQuery.ajax({
        url: "editid.php",  
        type: "POST", 
        data: data,     
        cache: false,
        success: function (pub) { 
		 jQuery('#loading').hide(); 
		var dataid=+pub;
		if(dataid==0)
		{
			var eror='Please valid input Type ';
			
			  jQuery('#validterror').html(eror);
			   jQuery('#validterror').fadeIn('slow');    
            //hide the progress bar
			
		}
		else
		{
			var e='<a href="advertisement.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="manage_advertisement.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
			  //add the content retrieved from ajax and put it in the #content div
            jQuery('#editer').html(e);
			jQuery('#delete').html(d);
            //display the body with fadeIn transition
            jQuery('#editer').fadeIn('slow');    
			 jQuery('#delete').fadeIn('slow');  	
			
		}
        }       
    });
}

</script>

<script type = "text/javascript" >
      function burstCache() {
        if (!navigator.onLine) {
            document.body.innerHTML = 'Loading...';
            window.location = 'index.php';
        }
    }
</script><script>
var a=navigator.onLine;
if(a){
// alert('online');
}else{
alert('ofline');
window.location='index.php';
} </script>


<script type="text/javascript">
jQuery(".closestatus").click(function() {
jQuery("#msgclose").addClass("hide");
});
</script>
<script type="text/javascript">
jQuery(".closestatus").click(function() {
jQuery("#msgerror").addClass("hide");
});
</script>
	
<style>
.hide {display:none;}
</style>

</body>
</html>


