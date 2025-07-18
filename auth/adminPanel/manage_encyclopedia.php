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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Manage Encyclopedia Forum: <?=$sitename; ?></title>
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
				  
<?php 
	if($btnsubmit=="Search")
	{ 
		if($filter_search=='')
		{
		$errmsg ="Please select Encyclopedia Topic.<br>";
		}
		else
		{
		$querywhere =" and ThreadID=$filter_search"; 
		}
		if($txtstatus=='')
		{
		$errmsg .="Please select Status.<br>";
		}
		else { 
		$querywhere .=" and  m_status=$txtstatus";
		}
	  if($errmsg=='')	
	  {

		  $query ="select * from encyclopedia_messagelist  where Author !='' $querywhere  ORDER BY MessageID DESC";
	  }
	 else
	{
	$_SESSION['errors']=$errmsg;
	}	
}?>   
	  <?php if($_SESSION['SESS_MSG']!=""){?>
<div  id="msgerror" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/approve.png"> <span>Attention! <br /></span><?php echo $_SESSION['SESS_MSG'];  $_SESSION['SESS_MSG']='';?></p>
</div>
</div>
          <?php }?>	
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
 <h3 class="manageuser">Manage Encyclopedia Forum</h3>
 <div class="right-section">

			 <ul>
<?php if($role_map['medit']=='ED' || $user_id=='101'){?><li id="editer" class="edit-icon"><a href="#" onclick="alert('Please select atleast one record')" title="Edit">Edit</a><?php }?></li>
             <?php if($role_map['mdelete']=='DE' || $user_id=='101'){?> 
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
	<?php
		$rq = "SELECT * FROM encyclopedia_threadlist where t_status='1' ORDER BY Title ASC";
		$rs = $conn->query($rq);
	 ?>
<select name="filter_search" id="filter_search" autocomplete="off">
	<option value=""> Select Encyclopedia Topic </option>
<?php 
while($rr= $rs->fetch_array())
{
	?>
<option value="<?php echo $rr['ThreadID']; ?>"<?php if($rr['ThreadID']==$_POST['filter_search']) echo 'selected="selected"';?>><?php echo $rr['Title']; ?></option>
<?php }
 ?>
</select>		
<select name="txtstatus" id="txtstatus" autocomplete="off">
	<option value=""> Select </option>
<?php 
foreach($status as  $key => $value)
{
	?>
<option value="<?php echo $key; ?>"<?php if($key==$_POST['txtstatus']) echo 'selected="selected"';?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>			
</div>
	            <div class="clear"></div>
          
              </form>
 
 </div>

 </div>
		
              <div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
            <div class="grid_view">
                         <table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" >
                                  <tr>
							      <th  colspan="3">Post Description</th>
                                   <th width="162">Post By / Date</th>
                                  <th width="101">Options</th>
                                </tr>
						<?php	
							$result = $conn->query($query);
							$pager = new PS_Pagination($link, $result,"txtstatus=$txtstatus");
							$rs = $pager->paginate();
			
			
							if($result->num_rows > 0){
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
							?>		
								
								<tr class="<?php echo $class;?>">
				<td  colspan="3" align="left" class="black-text1" >
				<input  id="<?php echo $MessageID; ?>" type="radio" name="radio1"  onclick="editlist(this.value);"  value="<?php echo $MessageID; ?>"> &nbsp;<?php echo $Message; ?>
				</td>
				<td  align="left" class="black-text1"><?php  echo $Author; ?>&nbsp;/&nbsp;<?php echo change_date_full_formate($CreationDate); ?></td>
				<td  align="left" class="black-text1">
				<?php echo active($m_status);?>
				&nbsp;/&nbsp;
				<a href="#" class="link2" title="View" onclick="MM_openBrWindow('encyclopediaID.php?page_id=<?php echo $MessageID?>','window','width=650,height=300,scrollbars=yes')">View</a>
				</td>
			</tr>
			<?php
				}
				?>
				<tr>
<td colspan="8" align="center"><?php echo $pager->renderFullNav();?></td>
</tr>
				
				<?php
				}
			else
			{
			?>
			<tr>
				<td colspan="8" bgcolor="#ffffff" class="black-text textfield_smallest"  align="center">No record found.</td>
			</tr>
			<?php
			}?>
			  </table>
								
         
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
    $.ajax({
        url: "editid.php",  
        type: "POST", 
        data: data,     
        cache: false,
        success: function (pub) { 
		 $('#loading').hide(); 
		var dataid=+pub;
		if(dataid==0)
		{
			var eror='Please valid input Type ';
			
			  $('#validterror').html(eror);
			   $('#validterror').fadeIn('slow');    
            //hide the progress bar
			
		}
		else
		{
			var e='<a href="edit_encyclopedia_form.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="edit_encyclopedia_form.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
			  //add the content retrieved from ajax and put it in the #content div
            $('#editer').html(e);
			$('#delete').html(d);
            //display the body with fadeIn transition
            $('#editer').fadeIn('slow');    
			 $('#delete').fadeIn('slow');  	
			
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


