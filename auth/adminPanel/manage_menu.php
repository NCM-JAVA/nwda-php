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
$model_id= "1";




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
		// session_unset($admin_auto_id_sess);
		// session_unset($login_name);
		// session_unset($dbrole_id);		
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


	function showcontent($res) {
		$result = mysqli_query($conn, "select * from menu where m_flag_id='".$res."' and approve_status='3'"); 
		while ($line = mysqli_fetch_array($result)) 
		{ 
			if($catlistids!="")
			{ 
				$catlistids.=','; 
			}
			$catlistids .= $line["m_id"];
			showcontent($line["m_id"]); 
		}
		return $catlistids;
	} 
						
if($deleteid !='')
{
if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($deleteid))))
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
  $check_status=check_delete($user_id,$role_id,$model_id);
			if($check_status >0)
			{
			
					$sql="Delete From menu where m_id='$deleteid'";
					$res=$conn->query($sql);
					
					$sql2="Delete From menu_publish where m_id='$deleteid'";
					$res1=$conn->query($sql2);
					$page_id = $conn->insert_id; 
					
					$SQL1 = "SELECT * FROM audit_trail where page_id='$deleteid'";
					$rs  = $conn->query($SQL1);
					$result = $rs->fetch_array();
							
					$pagename  = $result['page_name'];
					$txtlanguage  = $result['lang'];
					$txtstatus  = $result['approve_status'];
					$gallery_categoryname  = $result['page_title'];
	

					$user_id=$_SESSION['admin_auto_id_sess'];			
					$page_id = $conn->insert_id; 
					$action="Delete";
					$categoryid='1'; //mol_content
					$date=date("Y-m-d h:i:s");
					$ip=$_SERVER['REMOTE_ADDR'];
					/* $tableName="audit_trail";
					$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
					$tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
					$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send); */
		
					$auditsql = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`) VALUES ('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
					$rss         = $conn->query($auditsql);

					header("Location:delete.php?status=deleteid");
			}
			else
			{
			
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

  $sql="Update menu set approve_status='1' where m_id='$inactiveid'";
 $res=mysqli_query($conn, $sql);
  $sql="Update menu_publish set approve_status='1' where m_publish_id ='$inactiveid'";
 $res=mysqli_query($conn, $sql);
	if($res)
	{	
	header("location:delete.php?status=inactiveid");
	}
}


 $sql ="SELECT * FROM menu where m_flag_id ='2' and approve_status='3'";
	$rs = $conn->query($sql);

    while ($line = $rs->fetch_array()) {
        if ($catlistids != "") {
            $catlistids .= ',';
        }
        $catlistids .= $line["m_id"];
        //showroot($line["m_id"]);
    }
     $catlistids;

/* 
function showroot($oldID)
{
	echo $sql ="SELECT * FROM menu where m_flag_id ='$oldID' and approve_status='3'";
	$rs = $conn->query($sql);

    while ($line = $rs->fetch_array()) {
        if ($catlistids != "") {
            $catlistids .= ',';
        }
        $catlistids .= $line["m_id"];
        showroot($line["m_id"]);
    }
    return $catlistids;
}
 */



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Menu : <?php echo $sitename;?></title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->	</head>

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
	<span class="submenuclass"><a href="welcome.php">Dashboard </a> </span>
			 <span class="submenuclass"> >> </span>
			 <span class="submenuclass"><a href="#">CMS Page</a></span>
			 <span class="submenuclass"> >> </span> 
			<span class="submenuclass">Manage Menu</span>
		
</div>
<div class="clear"> </div>
</div>   
<div id="validterror" style="color:#F00" align="center"></div>   
<div class="right_col1">
<div class="clear"></div>	  
<?php 
	if($btnsubmit=="Search" || $_GET['page_query'] =="Search")
	{
		
		if($filter_search!='')
		{
			if(preg_match("/^[aA-zZ][a-zA-Z -]{2,20}+$/", trim($filter_search)) == 0){
				$errmsg = 'Name must be from letters that should be minimum 2 and maximum 20.<br>';
			}
			else{
				$querywhere .=" and m_name LIKE '%$filter_search%'"; 
			}
		}
		if($txtpostion!=''){
					$querywhere .=" and menu_positions=$txtpostion"; 
		}
		if($txtstatus==''){
			$errmsg .="Please select Status.<br>";
		}
		else{ 
				 $querywhere .=" and approve_status=$txtstatus"; 
		}

		if($btneng!=''){
			unset($_SESSION['lname']); 
			$_SESSION['lname']=$btneng;
			if($_SESSION['lname']=='English'){ 
				$language='1';
			} 
			else{ 
				$language='2';
			}
			$querywhere .=" and menu.language_id=$language";
		}
		else{
			echo "hiii"; 
			if($_SESSION['lname']=='English'){ 
				$language='1';
			} 
			else{ 
				$language='2';
			}
			$querywhere .=" and menu.language_id=$language";
		}
		if($errmsg==''){
			if($txtstatus=='1' || $txtstatus=='2'){
			 	$query ="select m_id,m_name,m_title,approve_status from menu  where 1 $querywhere ORDER BY page_postion ASC";
			}
			else{ 
				$query ="select m_id,m_name,m_title,approve_status from menu  where m_flag_id=0 $querywhere ORDER BY page_postion ASC"; 
			}
		}else{
			$_SESSION['errors']=$errmsg;
		}
		
	}
	else{ 
		if($btneng!=''){
			unset($_SESSION['lname']); 
			$_SESSION['lname']=$btneng;
			if($_SESSION['lname']=='English'){ 
				$language='1';
			} 
			else{ 
				$language='2';
			}
			$querywhere .=" and menu.language_id=$language";
		}
		else{
			if($_SESSION['lname']=='English'){ 
				$language='1';
			} 
			else{ 
				$language='2';
			}
			$querywhere .=" and menu.language_id=$language";
		}	
	
	
	
		if($role_map['draft']=='DR' || $role_map['mapprove']=='AP' || $user_id=='101'){
			if($_GET['txtstatus'] !=''){
				if($_GET['txtstatus'] =='3'){
					$where= "and approve_status =".$_GET['txtstatus']." and m_flag_id=0";
				}
				else{ 
					$where=" and approve_status =". $_GET['txtstatus'];
				} 
			}
			else{ 
				$where= "and approve_status=3"; 
			}
			$wherecluse="where language_id=$language $where";
		}
		if($role_map['pending']=='PND' || $role_map['publish']=='PB'){
			if($_GET['txtstatus'] !=''){
				$txtstatus=$_GET['txtstatus'];
			}	 
			else{ 
				$txtstatus=3; 
			}
			$wherecluse="where language_id=$language and approve_status='$txtstatus' and m_flag_id='0'";
		}
		$query ="select m_id,m_name,m_title,language_id,approve_status from menu $wherecluse  ORDER BY page_postion  ASC";
	 
	}
		   $result = $conn->query($query);
		

?> <?php if($_SESSION['content']!=""){?>
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
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $_SESSION['errors']; $_SESSION['errors']="";?>.</p>
</div>
</div>
  <?php }?>  
      <div class="clear"></div>
      <div class="internalpage_heading">
 <h3 class="manageuser">Manage Menu</h3>
<div class="right-section">

			 <ul>
			
<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li class="new-icon">
<a href="add_menu.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <?php }?>
<?php if($role_map['medit']=='ED' || $user_id=='101'){?><li id="editer" class="edit-icon"><a href="#" onclick="alert('Please select atleast one radio button!')" title="Edit">Edit</a><?php }?>
</li>
             <?php if($role_map['mdelete']=='DE' || $user_id=='101'){?> 
			 <?php if ($txtstatus!='3'){?>
               <li id="delete" class="delete-icon"><a href="#" onclick="alert('Please select atleast one radio button!')" title="Delete">Delete</a></li><?php } } ?>   
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
<select name="txtpostion" id="txtpostion" autocomplete="off">
<option value=""> Select </option>
<?php 
foreach($postion as $key=>$value)
{ ?>
<option value="<?php echo $key; ?>"<?php if($key==$txtpostion){ echo 'selected'; } else { }?>><?php  echo $value; ?></option>
<?php }?>
</select>
 
<select name="txtstatus" id="txtstatus"  class="inputbox" autocomplete="off">
			<?php if($role_map['pending']=='PND'){?>
					<option value="5" <?php if ($txtstatus=='5') echo 'selected="selected"';?>>Pending</option>
					<?php }
					if($role_map['draft']=='DR' || $user_id=='101'){?>
                    <option value="1" <?php if ($txtstatus=='1') echo 'selected="selected"';?>>Draft</option>
					<?php }if($role_map['mapprove']=='AP' || $user_id=='101' ){?>
                      <option value="2" <?php if ($txtstatus=='2') echo 'selected="selected"';?>>Approval</option>
										<?php }
					if($role_map['publish']=='PB' || $user_id=='101'){?>
                                          <option value="3" <?php if ($txtstatus=='3') echo 'selected="selected"';?>>Publish</option>

					<!--<li><a href="#menu-1-c" onClick="document.location.href='#menu-1-c';document.location.reload(false);return false">Publish</a></li>-->
					<?php }
					
					?>
 
</select>

<select class="inputbox" name="btneng">
				<option value="English"<?php if($_SESSION['lname']=='English') echo 'selected=selected'?>>English</option>
				<option value="Hindi"<?php if($_SESSION['lname']=='Hindi') echo 'selected=selected'?>>Hindi</option>
			</select>
 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>			
</div>
	            <div class="clear"></div>
          
              </form>
            
            </div>
                         <table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" >
                                  <tr>
								   <th width="2%"></th>
                                  <th width="20%">Menu Name</th>
                                  
                                  <th width="12%">Page Status</th>
                                  <th width="12%">Language</th>
                                  <th width="14%">Options</th>
                                </tr>
								</table>
								
          <div id="list">

    <div id="response"> </div>
  
							<?php	
							$pager = new PS_Pagination($link, $result ,"txtstatus=$txtstatus&page_query=Search&&module_id=".$_GET['module_id']."");
							$rs = $pager->paginate();
							if($result->num_rows > 0){
							?>
							<ul class="">
							<?php 
							while($data = $result->fetch_array())
							{ 

							$content_id = stripslashes($data['m_id']); 
							$menu_name = stripslashes($data['m_name']);
							if($class=="odd")
							{
							$class="even";
							}
							else
							{
							$class="odd";
							}
						  $sql_res = "SELECT * FROM menu where m_flag_id =".$data['m_id']." and approve_status='3'"; 
									 $rss = $conn->query($sql_res);
									$list  = $rss->num_rows;
							?>
							
							
							
							<li id="arrayorder_<?php echo $data['m_id'] ?>" class="<?php echo $class;?>">
							
							<span class="space-menuname_pg"><input type="radio"  name="radio1" id="<?php echo $data['m_id']; ?>"  value="<?php echo $data['m_id']; ?>" onclick="editlist(this.value);" >&nbsp;&nbsp; <?php echo $data['m_name']; ?>	</span>

							
							<span class="space-pagetitle">
								<?php 
									
								 if($list >0) { 
?>
								<a href="manage_submenu.php?sub=<?php echo $data['m_id']; ?>&module_id=<?php echo $data['model_id'];?>&&txtstatus=<?php echo $data['approve_status'];?>" title="Sub Menu View">
								<?php status($data['approve_status']);?></a><br />
								<span class="clicksubmenu">(Click to View Submenu)</span>
								<?php  } else {  status($data['approve_status']); }?>
							</span>
							
							<span class="space-lang"><?php language($data['language_id']); ?></span>

							<span class="space-option">
                            <?php  if($role_map['publish']=='PB' || $txtstatus=='3'){?>
							<a href="manage_menu.php?inactiveid=<?php echo $data['m_id']; ?>&module_id=<?php echo $data['model_id'];?>&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm('Are you sure you want to Inactive this page?')">Inactive</a>&nbsp;/&nbsp;<?php }?>
                            <a href="" class="cat_link" title="View" onclick="MM_openBrWindow('menuview.php?page_id=<?php echo $data['m_id'];?>','window','width=700,height=600,scrollbars=yes')">View </a> 
							</span>
							<div class="clear"></div>
							</li><?php  }?>

							</ul>


							
							<ul><li class="page" style="text-align:center;"><?php echo $pager->renderFullNav();?></li></ul>
								<?php } else
							{ ?><ul> <li style="text-align:center"> No record found.</li></ul>
							<?php } ?>
  </div>
                        </div>
          </div>
             <!--  <div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->
          <div class="clear"></div>
            </div>
			
			
          <!-- right col -->
          
          <div class="clear"></div>
          
          
  </div>
      <!-- main con--> 
    
      
 </div>
    </div>
<!-- Container div-->
<!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
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
			
			var order = jQuery(this).sortable("serialize") + '&update=update' + '&tab=manage'; 
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
			var e='<a href="edit_menu.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="manage_menu.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
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


