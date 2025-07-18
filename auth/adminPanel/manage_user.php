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
 $role_id = $_SESSION['dbrole_id']; 

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

if($role_id < 0)
{
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:error.php");
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
	if(($deleteid!='') and ($role_id==0))
		{
	
			$sql="Delete From admin_login where id='$deleteid'";
			$res=mysql_query($sql);
			
			if($res)
			{	
			header("location:delete.php?status=deleteid_user");
			}
		}
}
if($btnsubmit=="Search")
	{
		if($filter_search!='')
		{
				if(preg_match("/^[aA-zZ][a-zA-Z -]{2,20}+$/", trim($filter_search)) == 0)
				{
				$errmsg = 'Name must be from letters that should be minimum 2 and maximum 20.<br>';
				}
				else
				 {
					$querywhere .=" and user_name LIKE '%$filter_search%'"; 
				 }
		}
		if($user_status1!='')
		{
		if($user_status1=='1' || $user_status1=='0')
				  {
					  
					  $querywhere .=" and user_status=$user_status1";
				  }
				 
			}	
	 if($errmsg=='')	
	  { 
		 $sqlquery = "select * from admin_login where  1 $querywhere ";

		}

else
		{
			$_SESSION['errors']=$errmsg;
		}	
}	
else
{
 $sqlquery = "select * from admin_login ";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage User : <?php echo $sitename;?></title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->
<script>

	 function MM_openBrWindow(theURL,winName,features) { 
  window.open(theURL,winName,features);
}

("#add").click(function(){
    ("#div_tag").html("<html code here>");
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
			var e='<a href="edit_user.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="manage_user.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
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
     <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_user.php"> User Management</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Manage User</span>
  </div>
<div class="clear"> </div>
</div>    

<div id="validterror" style="color:#F00" align="center"></div>
<div class="right_col1">
<!--<?php if($_SESSION['admin_auto_id_sess']=='101')
{
?>
<div class="add_button"><a href="add_user.php" title="Add User" >Add User</a></div>  <div class="clear"></div>
<?php }?>-->
 <?php if($_SESSION['manage_user']!=""){?>
        <div  id="msgclose" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['manage_user'];
$_SESSION['manage_user']=""; ?>.</p>
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

 <div class="internalpage_heading">
 <h3 class="manageuser">Manage User</h3>
 <div class="right-section">
 <ul>
			
			 <?php if($_SESSION['admin_auto_id_sess']=='101')
				{
				?>
              <li class="new-icon">
			 
			  <a href="add_user.php" title="New"><span class="icon-28-new"></span>New</a>
			
			  </li>
           
              <li id="editer" class="edit-icon">
			 <a href="#" onclick="alert('Please select atleast one radio button! ')" title="Edit"><span class="icon-28-edit"></span>Edit</a>
			  </li>
              
			
              <!--<li id="delete" class="delete-icon"><a href="#" onclick="alert('Please select atleast one radio button!')" title="Delete"><span class="icon-28-delete"></span>Delete</a></li>-->
			
<!--              <li id="delete"><a href="#" onclick="alert('Please Select Manage Role ')" title="Delete"><span class="icon-28-delete"></span>Delete</a></li>
              <li class="divider"> </li>
             --> 
			  
			    <?php }?>
            </ul>
 
 </div>
 </div>
 <div class="clear">  </div>
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
    
		<table width="100%"  border="1" cellspacing="0" cellpadding="0" summary="">
			<tr>
				<th width="52"></th>
				<th width="118">Name</th>
				<th width="128">Phone</th>
				<th width="127">Email </th>
				<th width="127">User Status </th>
				<th width="154">Registration Date </th>
				<!--<th width="162">Last login Date </th>-->
				<th width="89">Options</th>
			</tr>

			<?php  
			
							//$pager = new PS_Pagination($link, $sqlquery,"");
							$result = $conn->query($sqlquery);
							//$rs = $pager->paginate();
							//echo "<pre>"; print_r($rs); "</pre>"; die;
							if($result > 0){
							
							/*while($data = mysql_fetch_array($result, MYSQL_ASSOC))
							{ 
							*/	while($data = $result->fetch_array())
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
							if($user_status=='1')
							{
							$user_status="Active";
							}
							else
							{
							$user_status="Inactive";
							}
							?>

			<tr class="<?php echo $class;?>">
				<td  align="left"> <?php if($id=='101') {}else{?>
				<input  id="<?php echo $id; ?>" type="radio" name="radio1"  onclick="editlist(this.value);"  value="<?php echo $id; ?>">
				<?php }?>				</td>
				<td  align="left" class="black-text1" >
				<?php echo ucfirst($user_name); ?>				</td>
				<td  align="left"><?php echo ucfirst($user_phone); ?></td>
				<td  align="left"><?php echo $user_email; ?></td>
				<td  align="left"><?php echo $user_status; ?></td>
				<td  align="left"><?php echo date("d-m-Y", strtotime($create_login_date));?></td>
			<!--	<td  align="left"><?php echo $last_login_date; ?></td>-->
				<td  align="left" >
				&nbsp;&nbsp;
				<a href="#" class="link2" title="View" onclick="MM_openBrWindow('userview.php?page_id=<?php echo $id?>','window','width=650,height=300,scrollbars=yes')">View</a>				</td>
			</tr>
			<?php
				}
				?>
				<tr>
<td colspan="7" align="center"><?php echo $pager->renderFullNav();?></td>
</tr>
				
				<?php
				}else{
			?>
			<tr>
				<td colspan="7" bgcolor="#ffffff" class="black-text textfield_smallest"  align="center">No record found.</td>
			</tr>
			<?php
			}?>
		</table>
	</div>
    
<!--<div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->

</div><!-- right col -->


    <div class="clear"></div>

<!-- Content Area end -->


  
  </div>  <!-- main con-->


</div>
</div> <!-- Container div-->
<!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
</body>
</html>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgclose").addClass("hide");
});
</script>
	
	
<style>
.hide {display:none;}
</style>

