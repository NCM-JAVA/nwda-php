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
			
					 $sqd = "select advertisedoc FROM appform_detail WHERE app_id=$deleteid";
					$sql="Delete From appform_detail where app_id='$deleteid'";
				
					$res = $conn->query($sql);
					$page_id = $conn->insert_id;
				
		//$sqli11 = $conn->query($sqd);
		//$row = $sqli11->fetch_array();
	
     // $image_path = "../../upload/photogallery/".$row['advertisedoc'];
     // $image_path2 = "../../upload/photogallery/thumb/".$row['advertisedoc'];
    // unlink($image_path);
	// unlink($image_path2);	
	
					$SQL1 = "SELECT * FROM audit_trail where page_id='$deleteid'";
				    $Query = $conn->query($SQL1);
					
					// $pagename  = mysql_result($Query,0,'page_name');
					// $txtlanguage  = mysql_result($Query,0,'lang');
					// $txtstatus  = mysql_result($Query,0,'approve_status');
					// $gallery_categoryname  = mysql_result($Query,0,'page_title');
					
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
					$model_id='Manage Applicant';
	
					// $tableName="audit_trail";
					// $tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
					// $tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
					// $useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
					
					$sql = "INSERT INTO audit_trail ('user_login_id','page_id','page_name','page_action','page_category','page_action_date','ip_address','lang','page_title','approve_status')VALUES ('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
			$sqli1 = $conn->query($sql);
					
					if($res)
					{	
					header("location:delete.php?status=applicants_deleteid");
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

   $sql="Update appform_detail set txtstatus='1' where app_id='$inactiveid'";
 $res=$conn->query($sql);
  
	if($res)
	{	
	header("location:delete.php?status=applicants_inactiveid");
	}
}



	$limit = 10;  
	if (isset($_GET["page"])) {
		$page  = $_GET["page"]; 
	} 
	else{ 
		$page=1;
	};
	$start_from = ($page-1) * $limit; 
	
if($_REQUEST['st']=='acc')
{
  $sqlup="update appform_detail set status='A' where app_id='".$_REQUEST['appid']."'";
  $resup=mysql_query($sqlup) or die(mysql_error());
}

   $sqlquery ="select * from appform_detail where 1";
   if($_POST['search_applicantno']!='')
   {
   $sqlquery .=" and app_no LIKE '%$search_applicantno%'"; 
   }
   if($_POST['search_post']!='')
   {
   //error_reporting(E_ALL);
   //ini_set('display_errors', 1);
   $sqlpost="select post_id,postname from post_mst where postname LIKE '%$search_post%'"; 
  
   $respost=mysqli_query($conn, $sqlpost) or die(mysql_error());
   $rowpost=mysqli_fetch_assoc($respost);   
   $postid=$rowpost['post_id'];
   
   $sqlquery .=" and post = '$postid'"; 
   }
   if($_POST['search_applicants']!='')
   {
   $sqlquery .=" and name LIKE '%$search_applicants%'"; 
   }
   if($_POST['search_dob']!='')
   {
   $dob1 = explode('-', $_POST['search_dob']);
   $dob2 = $dob1['2'] . "-" . $dob1['1'] . "-" . $dob1['0'];
   
   $sqlquery .=" and dob='$dob2'"; 
   }
    if($_POST['postappliedid']!='')
   {
   $sqlquery .=" and post = '$_POST[postappliedid]'"; 
   }
   
    if($_POST['search_status']=='P')
   {
   $sqlquery .=" and status = '$_POST[search_status]'"; 
   }
    if($_POST['search_status']=='A')
   {
   $sqlquery .=" and status = '$_POST[search_status]'"; 
   }
   
   if($_POST['search_status']=='R')
   {
   $sqlquery .=" and status = '$_POST[search_status]'"; 
   }

   if($startdate !='' && $expairydate !="")
{
		$startdate1=changeformate($startdate);
		$expairydate1=changeformate($expairydate);
		$sqlquery .=" and i_date between '$startdate1' and '$expairydate1' "; 

}


   
     $sqlquery .=" ORDER BY app_id DESC LIMIT $start_from, $limit"; 

?>

	<script type="text/javascript" src="js/jsDatePick.js"></script>
	<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"search_dob",
		dateFormat:"%d-%m-%Y"
	});
};


</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Applicants List: <?=$sitename; ?></title>
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
	
	<script type="text/javascript">
function PopupCenterDual(url, title, w, h) {
// Fixes dual-screen position Most browsers Firefox
var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

var left = ((width / 2) - (w / 2)) + dualScreenLeft;
var top = ((height / 2) - (h / 2)) + dualScreenTop;
var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

// Puts focus on the newWindow
if (window.focus) {
newWindow.focus();
}
}
</script>
	
	</head>
<style>
.page-link{
	position: relative;
    padding: 0.5rem 0.75rem;
    margin-left: 5px;
    line-height: 2.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 5px;
}
</style>
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

          <?php
		  if($_REQUEST['st']=='acc')
          { ?>
		    <div align="center"><font color="red"><?php echo "Applicant Status Approve Successfully" ?><font></div>
		  <?php }
		  ?>
 

      <div class="clear"></div>
      <div class="internalpage_heading">
 <h3 class="manageuser">Applicants List</h3>
<div class="right-section">
			 <ul>
               <li id="delete" class="delete-icon"><a href="#" onClick="alert('Please Select Manage Menu')" title="Delete">Delete</a></li>  
            </ul>

 </div>
 </div>
		
              <div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
            <div class="grid_view">
            <div class="new-gried">
            
 <form id="manage_menu" name="manage_menu" method="post" action="">
     

<?php 
  	$sqlqual="select * from post_mst where approve_status='1' order by post_id desc";
	$resqual=$conn->query($sqlqual);	
 ?>
 <label for="startdate" >From Date:</label>
					
					<input type="text" name="startdate"  autocomplete="off" id="startdate" value="<?php echo htmlentities($startdate);?>" size="10"  onkeypress="return isNumberKey(event)"/>
					<label for="expairydate" >To Date:</label>
					<input type="text" name="expairydate"  autocomplete="off" id="expairydate" value="<?php echo htmlentities($expairydate);?>" size="10"  onkeypress="return isNumberKey(event)"/>
					<div class="filter-select fltrt" align="left">      
	<label class="filter-search-lbl" for="search_filter">Post:</label>				
  <select name="postappliedid" id="postappliedid" onChange="this.form.submit()">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=$resqual->fetch_array()){?>
    <option value="<?php echo $rowqual['post_id'] ;?>"<?php  if($rowqual['post_id']==$_REQUEST['postappliedid']) {  echo "selected";  } ?>><?php echo $rowqual['postname'] ;?></option>
    <?php } ?>
  </select>
 <a href="applicants_export.php?pid=<?php echo $_REQUEST['postappliedid']; ?>" class="btn btn-primary"  ><input type="button" name="btnsubmit" value="Export to Excel" class="button_m"/></a>
 <a href="applicants_export_short.php?pid=<?php echo $_REQUEST['postappliedid']; ?>" class="btn btn-primary" ><input type="button" name="btnsubmit" value="Export to Excel Short" class="button_m"/></a>			
</div>
 
      <div class="filter-select fltrt">          
<label class="filter-search-lbl" for="search_filter">Filter:</label>
<input id="search_applicantno" type="text" title="Search applicants no" value="<?php echo $_POST['search_applicantno']; ?>" name="search_applicantno" placeholder="Applicants No">
<input id="search_post" type="text" title="Search post" value="<?php echo $_POST['search_post']; ?>" name="search_post" placeholder="Post">
<input id="search_applicants" type="text" title="Search applicants" value="<?php echo  $_POST['search_applicants']; ?>" name="search_applicants" placeholder="Applicants Name">
<input id="search_dob" id="search_dob" type="text" title="Search DOB" value="<?php echo $_POST['search_dob']; ?>" name="search_dob" placeholder="Date of birth">
 <select name="search_status" id="txtstatus"  autocomplete="off">
			<option value=" ">Select Status</option>
			 <option value="P" <?php if($_POST['search_status']=='P') {  echo "selected";  } ?>>Pending</option>
			 <option value="A" <?php if($_POST['search_status']=='A') {  echo "selected";  } ?>>Accept</option>
             <option value="R" <?php if($_POST['search_status']=='R') {  echo "selected";  } ?>>Reject</option>
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
				<th width="118">Application No</th>
				<th width="127">Applicant Name </th>
				<th width="127">Post Applied </th>
				<!--<th width="127">Preferred Place</th>-->
				<th width="127">Category </th>
				<!--<th width="154">TransactionID</th>-->
				<!--<th width="154">Transaction Status </th>-->
				<th width="127">Date</th>
				<th width="127">Image</th>
				<!-- <th width="127">Signature</th> -->
				<th width="127">GATE Score Card</th>
				<th width="127">10th Certificate</th>
				<th width="127">View</th>
				<th width="127"></th>
			</tr>

			<?php  
							$result = $conn->query($sqlquery);
							$pager = new PS_Pagination($conn, $result,"");
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
				<input  id="<?php echo $id; ?>" type="radio" name="radio1"  onclick="editlist(this.value);"  value="<?php echo $app_id; ?>">
							</td>
				<td  align="left" class="black-text1" ><?php 


				echo $app_no; 
				// $sss = "SELECT * FROM `payment_status` WHERE `application_no`='$app_no'";
				// $rr = $conn->query($sss);
				// $payment = $rr->fetch_array();

				?></td>
				<td  align="left" class="black-text1" ><?php echo $name; ?></td>
				<td  align="left"><?php $postid=$post;
				$sqlpost="select postname from post_mst where post_id='".$postid."'";
				$respost=$conn->query($sqlpost);
				$rowpost=$respost->fetch_array();
				echo $rowpost['postname']."<br>";
				
				?></td>
				<!--<td  align="left"><?php echo $inter_place;?></td>-->
				<td  align="left" class="black-text1" ><?php $catid=$category;
                $sqlcat="select c_name from category_master where c_id='".$catid."'";
				$rescat=$conn->query($sqlcat);
				$rowcat=$rescat->fetch_array();
                echo $rowcat['c_name'];
				?></td>
				<!--<td  align="left"><?php 

//$pay_id=$payment['PaymentID'];
				//if(isset($pay_id))echo $pay_id ;else echo "Pending";?></td>
				<!--<td  align="left"><?php echo "Transaction Status";?></td>-->
			    <td  align="left"><?php 
				if($i_date=='0000-00-00')
				{
				  echo "N/A";
				}
				else
				{
				echo date("d-m-Y", strtotime($i_date));
                }
				?></td>
				<td  align="left">
				<?php  if($image_name!='' ) {  ?>
				<img src="<?php echo "../../upload/advertise/".$image_name;?>" height=80; width=80; alt="avatar">
				<?php  }  else {  ?>
				No image available
				<?php  }  ?>
				</td>
				<!-- <td  align="left">
				<?php  /*if($signature!='') {  ?>
				
				<img src="<?php echo "../../upload/advertise/".$signature;?>" height=80; width=80; alt="avatar">
				<?php  }  else {  ?>
				No signature available
				<?php  }*/  ?>
				</td> -->
				<td  align="left">
					<?php if($gate_certificate!='') { ?>
						<a href="<?php echo "../../upload/advertise/".$gate_certificate;?>" height=80; width=80; alt="avatar" target="_blank">View</a>
					<?php } else { ?>
						No GATE Score Card available
					<?php } ?>
				</td>
				<td  align="left">
				<?php  if($tenth_certificate!='') {  ?>
				
				<a href="<?php echo "../../upload/advertise/".$tenth_certificate;?>" height=80; width=80; alt="avatar" target="_blank">View Certificate</a>
				<?php  }  else {  ?>
				No certificate available
				<?php  }  ?>
				</td>
				<td  align="left"><a href="applicants_form.php?appid=<?php echo $app_id;  ?>">View</td>
				<td  align="left">
				<?php if($status=='P') {  ?>
				<!--<a href="manage_applicants.php?appid=<?php echo $app_id;  ?>&st=acc"> <input type="button" name="button" value="Accept" class="button_m"/></a>
				<br><br>
				 <a onClick="PopupCenterDual('applicants_status.php?appid=<?php echo $app_id;  ?>&st=rej','NIGRAPHIC','600','450'); " href="javascript:void(0);"><input type="button" name="button" value="Reject" class="button_m"/></a>-->
				 <?php  } elseif($status=='A') { ?><font color="green"> <?php echo "Approved Successfully";?></font>  
				        <?php }   elseif($status=='R') { ?> <font color="red"> <?php echo "Rejected Successfully"."<br>";  ?></font>
                        <?php  echo "<b>Reasons</b> : $comment";
						}  ?>
				</td>
			</tr>
			<?php
				}
				?>
				<tr>
					<td colspan="12" align="center">
					<?php  

/* $result_db = mysqli_query($conn,""); 
$row_db = mysqli_fetch_row($result_db);  
$total_records = $row_db[0];  
$total_pages = ceil($total_records / $limit); 

$pagLink = "<ul class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {
              $pagLink .= "<li class='page-item'><a class='page-link' href='manage_applicants.php?page=".$i."'>".$i."</a></li>";	
}
echo $pagLink . "</ul>";  
 */
        
                $pr_query 		= "SELECT * FROM appform_detail";
                $pr_result 		= mysqli_query($conn,$pr_query);
                $total_record 	= mysqli_num_rows($pr_result );   
                $total_page 	= ceil($total_record/$limit);
                $start_loop 	= $page;
				$difference 	= $total_page - $page;
				
				if($difference <= 5){
					$start_loop = $total_page - 5;
				}
				$end_loop = $start_loop + 4;
				if($page > 1){
					echo "<a href='manage_applicants.php?page=1' class='page-link'>First</a>";
					echo "<a href='manage_applicants.php?page=".($page - 1)."' class='page-link'><<</a>";
				}
				for($i=$start_loop; $i<=$end_loop; $i++){     
					echo "<a href='manage_applicants.php?page=".$i."' class='page-link'>".$i."</a>";
				}
				if($page <= $end_loop){
					echo "<a href='manage_applicants.php?page=".($page + 1)."' class='page-link' >>></a>";
					echo "<a href='manage_applicants.php?page=".$total_page."'class='page-link'>Last</a>";
				}
			?>


</td>
				</tr>
				<?php
				}
			else
			{
			?>
			<tr>
				<td colspan="12" bgcolor="#ffffff" class="black-text textfield_smallest"  align="center">No record found.</td>
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
      
    
    </div>
<!-- Container div-->
<!-- Container div-->
<script type="text/javascript" src="js/jquery.min.js"></script> 
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
			var d='<a href="manage_applicants.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
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
  <!-- Footer start -->
      
      <?php 
  
			include("footer.php");
    ?>
      <!-- Footer end --> 
      
</body>
</html>


