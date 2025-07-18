<?php ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
require_once("../../includes/ps_pagination.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id='';

//$role_map=role_permission($role_id,$model_id);
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
$check_status=check_delete($role_id,$txtstatus,$model_id);
if($check_status >0)
{
		$sql="Delete From viewsonilr where id='$deleteid'";
		$res=$conn->query($sql);
		$page_id=$conn->insert_id;
		
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
		$model_id='';

		$tableName="audit_trail";
		$tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
		$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

		if($res)
		{	
		header("location:delete.php?status=deleteviewsonilr");
		}
}
else
{
$msg = "Login to Access Admin Panel";
$_SESSION['sess_msg'] = $msg ;
header("Location:error.php");
exit();
}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Archive ILR Views : <?=$sitename; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jsDatePick.js"></script>
	<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
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
			var e='<a href="edit_viewsonilr.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Reply</a>';
			var d='<a href="manage_viewsonilr.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
			  //$('#loading').hide();   
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

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  <div class="main_con">
       
      <div id="validterror" style="color:#F00" align="center"></div>   
        <div class="right_col1">
            <div class="clear"></div>
				<?php 
				$querywhere ='';
				if($btnsubmit=="Search")
				{
					if($btneng!='')
					{
						$datef ='';

						if($_POST['startdate']!='' && $_POST['expairydate']!='')
						{
							$fromdate_old=$_POST['startdate'];
							$fromdate_new = date('Y-m-d', strtotime($startdate));
							$todate_old=$_POST['expairydate'];
							$todate_new = date('Y-m-d', strtotime($expairydate));
							
							$datef .=" AND create_date BETWEEN '$fromdate_new' AND '$todate_new'";
						}
						
						unset($_SESSION['lname']); 
						$_SESSION['lname']=$btneng;
							if($_SESSION['lname']=='English'){ 
							$language='1';
							} else { $language='2';
							}
							$querywhere .=" and language_id=$language";
					}
					if($errmsg=='')	
					{
						//echo $query ="select id,name,email,contact_no,review_comment,review_date from viewsonilr_temp  where create_date >= CURRENT_DATE() - INTERVAL 3 MONTH $querywhere $datef ORDER BY id DESC";
						$query ="select id,name,email,review_comment,review_date from viewsonilr  where review_comment IS NULL";
					
					}
				}else{
					$query ="select id,name,email,review_comment,review_date from viewsonilr  where review_comment IS NOT NULL";
				}
				$result = $conn->query($query);
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

 <div class="internalpage_heading">
 <h3 class="manageuser">Manage Views On ILR
</h3>
 <div class="right-section">
 <ul>
			
			

           
              <li id="editer" class="edit-icon">
			 <a href="manage_viewsonilr.php"></span>Back</a>
			  </li>

            </ul>
 </div>
</div>  
<div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
<div class="grid_view">
<div class="new-gried">
	<form id="manage_viewsonilr" name="manage_viewsonilr" method="post" action="">
      <div class="filter-select fltrt"> 
          <label>Date from</label>
   <input type="text" name="startdate"  class="datepicker" readonly="readonly" id="startdate" value="<?php echo isset($_POST['startdate'])?$_POST['startdate']:''?>"/>

  		<label>Date To</label> <input  type="text" class="datepicker" name="expairydate" id="expairydate" readonly="readonly"   value="<?php echo isset($_POST['expairydate'])?$_POST['expairydate']:''?>"/>
	<select class="inputbox" name="btneng">
		<option value="English"<?php if($btneng=='English') echo 'selected=selected'?>>English</option>
		<option value="Hindi"<?php if($btneng=='Hindi') echo 'selected=selected'?>>Hindi</option>
	</select>
 <input type="submit" name="btnsubmit" value="Search" class="button_m"/>		
</div>
	            <div class="clear"></div>
          
              </form>
</div>
<table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" >
  <tr>			 
  <th width="20%">Name</th>
  <th width="20%">Email</th>
  <th width="12%">Phone</th>
  <th width="12%">Language</th>
  <th width="14%">Options</th>
</tr>
</table>
		
  <div id="list">
    <div id="response"> </div>  
		<?php	
		$pager = new PS_Pagination($link, $result,"txtlanguage=$language");
		$rs = $pager->paginate();
		$result->num_rows;
		if($result->num_rows > 0){
		?>
		<ul class="">
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
		?>
		<li id="arrayorder_<?php echo $id ?>" class="<?php echo $class;?>">
			<span class="space-menuname1">
			    <input type="radio"  name="radio1" id="<?php echo $id; ?>"  value="<?php echo $id; ?>" onclick="editlist(this.value);" />
                &nbsp;&nbsp; <?php echo $name; ?>
				<?php
				if($review_comment != '')
				{
				echo " "."(Replied on $review_date)";
				
				}
				else
				{
				echo " "."(Waiting for reply)";
				}
				?>
				</span> 
				
		<span class="space-menuname"><?php echo $email; ?></span>
		<span class="space-lang"><?php echo $contact_no; ?></span>	
		<span class="space-option"><?php language($language_id); ?></span>

		<span class="space-option">
			<a href="" class="cat_link" title="View" onclick="MM_openBrWindow('viewsonilrview.php?page_id=<?php echo $id;?>','window','width=900,height=400,scrollbars=yes')">View </a> 
		</span>
		<div class="clear"></div>
		</li><?php }?>

		</ul>
		<ul><li class="page" style="text-align:center;"><?php echo $pager->renderFullNav();?></li></ul>
			<?php } else
		{ ?><ul> <li style="text-align:center"> No record found.</li></ul>
		<?php } ?>
  </div>
</div>
</div>

<div class="clear"></div>
</div>	
  </div>
  <!-- main con-->       
    
 </div>
    </div>
<!-- Container div-->
<!-- Footer start -->
        <?php include("footer.php"); ?>
        <!-- Footer end -->
<!-- <script src="http://code.jquery.com/jquery-1.9.0.js"></script>  -->
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script> 
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script src="js/demo.js" type="text/javascript"></script> 

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

// $(function() { 
   
// 	$("#start").datepicker({
// 		dateFormat:'yy-mm-dd',
// 		onSelect: function(selected) {
// 			$("#end").datepicker("option","minDate", selected)
// 		}
// 	});
// 	$("#end").datepicker({
// 		dateFormat:'yy-mm-dd',
// 		onSelect: function(selected) {
// 			$("#start").datepicker("option","maxDate", selected)
// 		}
// 	});
// });

</script>
<script type="text/javascript">
window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"startdate",
		dateFormat:"%d-%m-%Y"
	});
	new JsDatePick({
		useMode:2,
			target:"expairydate",
		dateFormat:"%d-%m-%Y"
	});
	
};
</script>

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