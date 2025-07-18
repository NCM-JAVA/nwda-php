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

echo "Organization setup";
die();

$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "9";
$role_map=role_permission($user_id,$role_id,$model_id);
$role_id_page=role_permission_page($user_id,$role_id,$model_id);
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
 $check_status=check_delete($user_id,$role_id,$model_id);
			if($check_status >0)
			{
					$sql="Delete From organization_chart where id='$deleteid'";
					$res=mysql_query($sql);
					$page_id=mysql_insert_id();
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
					$model_id='Manage Latest Update';

					$tableName="audit_trail";
					$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
					$tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
					$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

					if($res)
					{	
					header("location:delete.php?status=delete_organization");
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
    $sql="Update organization_chart set approve_status='1' where id='$inactiveid'";
 $res=mysql_query($sql);
	if($res)
	{	
	header("location:delete.php?status=inactived_organization");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Organization Setup: DDA</title>
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
				  
<?php if($btnsubmit=="Search")
{
		if($filter_search!='')
		{
				if(preg_match("/^[aA-zZ][a-zA-Z -]{2,20}+$/", trim($filter_search)) == 0)
				{
				$errmsg = 'Name must be from letters that should be minimum 3 and maximum 20.<br>';
				}
				else
				 {
					$querywhere .=" and ename LIKE '%$filter_search%'"; 
				 }
		}
	
		if($txtstatus=='')
		{
		$errmsg .="Please select Status.<br>";
		}
		else { 
		$querywhere .=" and approve_status=$txtstatus";
		}

	  if($errmsg=='')	
	  {
		 $query ="select * from organization_chart  where 1 $querywhere  ORDER BY page_postion ASC";
	  }
	 else
	{
	$_SESSION['errors']=$errmsg;
	}	
}
else {   
if($role_map['draft']=='DR' || $role_map['mapprove']=='AP' || $role_map['review']=='RV' || $user_id=='101'){
	if($_GET['txtstatus'] !='')
	 {
			if($_GET['txtstatus'] =='3')
			{
				
			$txtstatus=$_GET['txtstatus'].' and menu_positions='.$_GET['menucategory'].' ';
			}
			
			else { $txtstatus=$_GET['txtstatus'];} 
	 }
	 else { $txtstatus=1; }
 $wherecluse=" and approve_status=$txtstatus";
}
 if($role_map['pending']=='PND' || $role_map['publish']=='PB'){
	if($_GET['txtstatus'] !='')
	 {
		$txtstatus=$_GET['txtstatus'];
	 }	 
	 else { $txtstatus=3; }
$wherecluse=" and approve_status='$txtstatus'";
}
   $query ="select * from organization_chart where 1 $wherecluse  ORDER BY page_postion ASC";
}
?>  
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
 <h3 class="manageuser">Manage Organization Setup</h3>
 <div class="right-section">

			 <ul>
			
<?php if($role_map['draft']=='DR' || $_SESSION['admin_auto_id_sess']=='101'){?><li class="new-icon">
<a href="organizationchart.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <?php }?>
<?php if($_SESSION['admin_auto_id_sess']=='101' or $role_map['medit']=='ED'){?><li id="editer" class="edit-icon"><a href="#" onclick="alert('Please select atleast one record')" title="Edit">Edit</a><?php }?></li>
             <?php if($role_map['mdelete']=='DE' || $_SESSION['admin_auto_id_sess']=='101'){?> 
			 <?php if ($txtstatus!='3'){?>
               <li id="delete" class="delete-icon"><a href="#" onclick="alert('Please select atleast one record')" title="Delete">Delete</a></li><?php } } ?>   
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
<select name="txtstatus" id="txtstatus"  class="inputbox" autocomplete="off">
			<option value=""> Select </option>
			<?php if($role_map['pending']=='PND'){?>
					<option value="5" <?php if ($txtstatus=='5') echo 'selected="selected"';?>>Pending</option>
					<?php }
					if($role_map['draft']=='DR' || $user_id=='101' || $user_id=='104'){?>
                    <option value="1" <?php if ($txtstatus=='1') echo 'selected="selected"';?>>Draft</option>
					<?php }if($role_map['mapprove']=='AP' || $user_id=='101' || $user_id=='104' ){?>
                      <option value="2" <?php if ($txtstatus=='2') echo 'selected="selected"';?>>Approval</option>
										<?php }
					if($role_map['publish']=='PB' || $user_id=='101' || $user_id=='104'){?>
                                          <option value="3" <?php if ($txtstatus=='3') echo 'selected="selected"';?>>Publish</option>

					<!--<li><a href="#menu-1-c" onClick="document.location.href='#menu-1-c';document.location.reload(false);return false">Publish</a></li>-->
					<?php }
					
					
					?>
 
</select>

	</span>
		
 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>			
</div>
	            <div class="clear"></div>
          
              </form>
 
 </div>

 </div>
		
              <div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
            <div class="grid_view">
                         <table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" bgcolor="#f8f8f8" >
                                  <tr>
								  <th  width="2%"></th>
                                   <th width="20%">Name</th>
                                 
                                  <th width="12%">Page Status</th>
                                 <th width="14%">Options</th>
                                </tr>
								</table>
								
          <div id="list">

    <div id="response"> </div>
  
									<?php	
							$pager = new PS_Pagination($link, $query,"txtstatus=$txtstatus&menucategory=$menucategory");
							$rs = $pager->paginate();
							if($rs > 0){
							?>
							<ul class="">
							<?php 
							while($data = mysql_fetch_array($rs, MYSQL_ASSOC))
							{ 
							@extract($data);
							
							?>
							<li id="arrayorder_<?php echo $id ?>">
							<span class="space-menuname"><input type="radio"  name="radio1" id="<?php echo $id; ?>"  value="<?php echo $id; ?>" onclick="editlist(this.value);" >&nbsp;&nbsp; <?php echo $ename	; ?></span>
							<span class="space-pagetitle"><?php echo $email; ?></span>
							
							<span class="space-pagestatus"><?php status($approve_status);?></span>
								<span class="space-option">
                          <?php   if($role_map['publish']=='PB' || $txtstatus=='3'){?>
							<a href="organization_setup.php?inactiveid=<?php echo $id; ?>&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm('Are you sure you want to Inactive this page?')">Inactive</a>&nbsp;/&nbsp;<?php }?>
                            <a href="#" class="cat_link" title="View" onclick="MM_openBrWindow('organizationview.php?page_id=<?php echo $id;?>','window','width=700,height=600,scrollbars=yes')">View </a> 
							</span><div class="clear"></div>
							</li><?php }?>
							</ul>
						<ul><li style="text-align:center"><?php echo $pager->renderFullNav();?></li></ul>
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
			
			var order = jQuery(this).sortable("serialize") + '&update=update' + '&tab=organizationchart'; 
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
			var e='<a href="organizationchart.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="organization_setup.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
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


