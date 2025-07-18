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
$model_id= "2";
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
					$sql="Delete From category where cat_id='$deleteid'";
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
					$model_id='Manage Category';

					$tableName="audit_trail";
					$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
					$tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
					$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

					if($res)
					{	
					header("location:delete_category.php?status=deleteid");
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

   $sql="Update category set approve_status='1' where cat_id='$inactiveid'";
 $res=mysql_query($sql);
  $sql="Update publish_category set  approve_status='1' where publish_id ='$inactiveid'";
 $res=mysql_query($sql);
	if($res)
	{	
	header("location:delete_category.php?status=inactiveid");
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Home Page:DDA</title><link rel="stylesheet" href="style/general1.css" type="text/css" media="screen" />
	
        <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script src="js/jquery.cookie.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.colorbox.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script src="js/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/demo.js"></script>
        
        
	<link href="style/admin.css" rel="stylesheet" type="text/css" />
	<link href="style/dropdown.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/drop_down.js"></script>
	<script type="text/javascript" src="style/validation.js"></script>


<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->








	<!--<script type="text/javascript" src="js/tabs.js"></script>-->

	<script>
function load() {
		document.getElementById('load').style.display = "block";
		document.getElementById('noscriptmsg').style.display = "none";
     
     }
	</script>
	<script>
	
	 function MM_openBrWindow(theURL,winName,features) { 
		 window.open(theURL,winName,features);
}
	</script>
<script type="text/javascript">
function checkall1(objForm){
//alert("a");
	
	
	len = objForm.elements.length;

//	alert(len);

	var i=0;
	for( i=0 ; i<len ; i++) {
//alert(objForm.elements[i].type);
		if (objForm.elements[i].type=='checkbox') {
			objForm.elements[i].checked=objForm.check_all.checked;
		}
	}
}


</script>





	</head>


<script>
	function MM_openBrWindow(theURL,winName,features) 
	{ 
		window.open(theURL,winName,features);
	}
	</script>
	<script type="text/javascript">

$(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update' + '&tab=update_cat'; 
			$.post("updateList.php", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
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
            //hide the progress bar
			var e='<a href="edit_category.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="manage_category.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
			   
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
  <div id="toolbar-box">
        <div class="m">
          
          <div id="toolbar" class="toolbar-list">
            <ul>
			
<?php if($role_map['draft']=='DR' || $user_id=='101'){?><li>
<a href="add_category.php" title="New"><span class="icon-28-new"></span>New</a></li>
              <li class="divider"> </li><?php }?>
             <?php if($role_map['medit']=='ED' || $user_id=='101'){?>  <li id="editer"><a href="#" onclick="alert('Please select atleast one record')" title="Edit"><span class="icon-28-edit"></span>Edit</a><?php }?>			</li>
             <?php if($role_map['mdelete']=='DE' || $user_id=='101'){?><li> <li class="divider"> </li>
               <?php if ($txtstatus!='3'){?>
               <li id="delete"><a href="#" onclick="alert('Please select atleast one record')" title="Delete"><span class="icon-28-delete"></span>Delete</a></li><li class="divider"> </li><?php } } ?>   
<li><a href="logout.php?random=<?php echo $_SESSION['logtoken'];?>" title="Logout"><span class="icon-28-logout"></span>Logout</a></li>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
      </div>
  <div class="main_con">
       
         <div id="validterror" style="color:#F00" align="center"></div>     
        <div class="right_col1">
                  <div class="clear"></div><?php if($btnsubmit=="Search")
{
		if($filter_search!='')
		{
				if($filter_search == 0)
				
				 {
					$querywhere .=" and section_id LIKE '%$filter_search%'"; 
				 }
		}
		if($txtstatus=='')
		{
		$errmsg .="Please select Status.<br>";
		}
		else { 
				if($txtstatus=='5')
				  {
					  $txtstatus='2';
					  $querywhere .=" and approve_status=$txtstatus";
				  }
				  if($txtstatus=='3')
				  {
					 $querywhere .=" and approve_status=$txtstatus"; 
				  }
				  else
				   {  $querywhere .=" and approve_status=$txtstatus"; }
		 
		
		}

	
	  if($errmsg=='')	
	  {
		//$wherecluse="where category.approve_status='1'";
		 $query ="select cat_id,categoryname,hindi_categoryname,approve_status,section_id from category where 1 $querywhere  ORDER BY page_postion ASC";

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
				
			$txtstatus=$_GET['txtstatus'];
			}
			
			else { $txtstatus=$_GET['txtstatus'];} 
	 }
	 else { $txtstatus=1; }
$wherecluse="where approve_status=$txtstatus";
}
 if($role_map['pending']=='PND' || $role_map['publish']=='PB'){
	if($_GET['txtstatus'] !='')
	 {
		$txtstatus=$_GET['txtstatus'];
	 }	 
	 else { $txtstatus=3; }
$wherecluse="where approve_status='$txtstatus'";
}

	$query ="select cat_id,categoryname,hindi_categoryname,approve_status,section_id from category $wherecluse  ORDER BY page_postion ASC";
}
?>      
          <?php if($_SESSION['add_category']!=""){?>
        <div  id="msgclose" class="status success">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['add_category'];
$_SESSION['add_category']=""; ?>.</p>
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

          
 <div id="filter_block">
     <div class="internalpage_heading">
 <h3 class="manageuser">Manage Category

</h3>
 <div class="right_form"> 
 
            	<form id="manage_category" name="manage_category" method="post" action="">
      <div class="filter-select fltrt">          
<!--<label class="filter-search-lbl" for="filter_search">Filter:</label>
<input id="filter_search" type="text" title="Search title or alias. Prefix with ID: to search for an article ID." value="" name="filter_search">-->
<select name="txtstatus" id="txtstatus"  class="inputbox" autocomplete="off">
			<option value=""> Select </option>
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
					if($role_map['review']=='RV' || $user_id=='101'){?>
                                                              <option value="4" <?php if ($txtstatus=='4') echo 'selected="selected"';?>>Review</option><?php } 
					
					?>

</select>

 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>			
</div>
	            <div class="clear"></div>
                
              </form>
              </div>
              </div>
          </div>

           <div class="clear"></div>
		
              <div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
            <div class="grid_view">
                         <table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" bgcolor="#f8f8f8" >
                                  <tr>
							
									<!--<th width="15%">Category Type</th>-->
									<th width="15%">Image Category</th>
									<!--<th width="12%">Hindi Title Name</th>-->
									<th width="12%">Page Status</th>
									<th width="14%">Options</th>
									</tr>
								</table>
								
          <div id="list">

    <div id="response"> </div>
  
							<?php	
							$pager = new PS_Pagination($link, $query,"txtstatus=$txtstatus");
							$rs = $pager->paginate();
							//echo $rs;
							if($rs > 0){
							?>
							<ul class="">
							<?php 
							while($data = mysql_fetch_array($rs, MYSQL_ASSOC))
							{ 
								//print_r($data);
							@extract($data);
							if($class=="odd")
							{
							$class="even";
							}
							else
							{
							$class="odd";
							}
							$cat_id = stripslashes($data['cat_id']);
							//$categoryname = stripslashes($data['categoryname']);
							?>
							<li id="arrayorder_<?php echo $cat_id ?>" class="<?php echo $class;?>">
							<?php 
								foreach($categorytype as $key=>$value)
								{

								if($section_id==$key) {
									?>
							<!--<span class="space-menuname_mm">
							<input type="radio"  name="radio1" id="<?php echo $cat_id; ?>"  value="<?php echo $cat_id; ?>" onclick="editlist(this.value);" >&nbsp;&nbsp; <?php echo $value; ?>
							</span>-->
								<?php } }?>
							<span class="space-menuname_imgcat"><input type="radio"  name="radio1" id="<?php echo $cat_id; ?>"  value="<?php echo $cat_id; ?>" onclick="editlist(this.value);" >&nbsp;&nbsp; <?php echo $categoryname; ?></span>
							<span class="space-menuname_pg"><?php status($approve_status); ?></span>
							<span class="space-menuname_pg">
                          <?php   if($role_map['publish']=='PB' || $txtstatus=='3'){?>
							<a href="manage_category.php?inactiveid=<?php echo $cat_id; ?>&random=<?php echo $_SESSION['logtoken'];?>#menu-1-c" onclick="return confirm('Are you sure you want to Inactive this page?')">Inactive</a>&nbsp;/&nbsp;<?php }?>
                            <a href="#menu-1-c" class="cat_link" title="View" onclick="MM_openBrWindow('categoryview.php?page_id=<?php echo $cat_id;?>','window','width=500,height=400,scrollbars=yes')">View </a> <div class="clear">
							</span>
							</div>
							
							</li><?php }?>
							</ul>
						<ul><li><?php echo $pager->renderFullNav();?></li></ul>
								<?php } else
							{ ?><ul> <li style="text-align:center"> No record found.</li></ul>
							<?php } ?>
  </div>
                        </div>
          </div>
             <!--  <div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->
          <div class="clear"></div>
            </div>
			
			<div style='display:none'>
		<div id='inline_content' style='padding:10px; background:#fff;'>
		<p><strong>This content comes from a hidden element on this page.</strong></p>
		<p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
		<p><a id="click" href="#" style='padding:5px; background:#ccc;'>Click me, it will be preserved!</a></p>
		
		<p><strong>If you try to open a new ColorBox while it is already open, it will update itself with the new content.</strong></p>
		<p>Updating Content Example:<br />
		<a class="ajax" href="../content/flash.html">Click here to load new content</a></p>
		</div>
	
        <div style="height:40px"></div>
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
    </div>
<!-- Container div-->
</body>
</html>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgclose").addClass("hide");
});
</script>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide");
});
</script>
	
<style>
.hide {display:none;}
</style>
