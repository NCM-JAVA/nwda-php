<?php ob_start();

 include("../../includes/config.inc.php");
 require_once "../../includes/connection.php";
 include("../../includes/useAVclass.php");
 include("../../includes/def_constant.inc.php");
 require_once("../../includes/ps_pagination.php");
$useAVclass = new useAVclass();
$useAVclass->connection();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$role_id=$_SESSION['dbrole_id']; 
 if($_SESSION['admin_auto_id_sess']=='')
{		
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
			$sql="Delete From admin_role where role_id='$deleteid'";
			$res=mysql_query($sql);
			$sql2="Delete From map_role where role_id='$deleteid'";
			$res2=mysql_query($sql2);
			if($res2)
			{	
			header("location:delete.php?status=deleteid_roleid");
			}
		}
}


$sql = "select * from admin_login where id ='$admin_auto_id_sess'";
$result1 = $conn->query($sql);
// $result=mysql_query($sql);
$num=mysqli_num_rows($result1);
if($line=mysqli_fetch_assoc($result1)){
@extract($line);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Role: <?php echo $sitename;?></title>
	<link href="style/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->



<script>
function showUser(role_id)
{
if (role_id=="")
  {
  document.getElementById("radio1").innerHTML="";

  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("radio1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","manage_role.php?q="+role_id,true);
xmlhttp.send();
}
</script>




<script>
function MM_openBrWindow(theURL,winName,features) { 
window.open(theURL,winName,features);
}
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
			var e='<a href="edit_role.php?editid='+id+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
			var d='<a href="manage_role.php?deleteid='+id+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
			  // $('#loading').hide();   
            //add the content retrieved from ajax and put it in the #content div
            $('#radio1').html(e);
			$('#delete').html(d);
            //display the body with fadeIn transition
            $('#radio1').fadeIn('slow');    
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
  
  <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="manage_role.php"> User Management</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Manage Role</span>
  </div>
<div class="clear"> </div>
</div>    
    <div id="validterror" style="color:#F00" align="center"></div>   
      <div class="right_col1">
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
  <div class="clear"></div>
   <div class="internalpage_heading">
 <h3 class="manageuser">Manage Role</h3>
 <div class="right-section">
<ul>
				
              <li  class="new-icon"><a href="add_role.php" title="New"><span class="icon-28-new"></span>New</a></li>
          
              <li id="radio1" class="edit-icon">
                 <a href="#" onclick="alert('Please select atleast one radio button!')" title="Edit"><span class="icon-28-edit"></span>Edit</a>
			  </li>
           
              <li id="delete" class="delete-icon"><a href="#" onclick="alert('Please select atleast one radio button!')" title="Delete"><span class="icon-28-delete"></span>Delete</a></li>
               </ul>
 
 </div>
 </div>
 <div class="clear">  </div>
          <div class="grid_view">
		             <table width="100%"  border="0" cellspacing="0" cellpadding="0" summary="">
              <tr>
                <th width="5%">Sl. No.</th>
				<th width="25%">Name</th>
                <th width="30%">Role</th>
                <th width="40%">Assign Module </th>
              </tr>
              <?php 
	
			$sql="select * from  admin_role inner join admin_login on admin_role.user_id=admin_login.id where role_status=1";
			$result = $conn->query($sql);
			// $rs=mysql_query($sql);
			if($result >0)
			{
			$i=1;
			while($row = $result->fetch_array())
			{
			@extract($row);
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
                <td  align="left" ><input type="radio"  name="radio1" id="<?php echo $row['role_id']; ?>"  value="<?php echo $row['role_id']; ?>" onclick="editlist(this.value);" ></td>
				<td  align="left" ><?php echo ucfirst($user_name) ; ?></td>
                <td  align="left" ><?php echo ucfirst($login_name) ; ?></td>
            
				<td  align="left" >
 
				<?php 
				$querysql="Select module.module_name  from map_role join  module  on module.module_id=map_role.module_id where map_role.role_id='$role_id' ";
				$queryresult = $conn->query($querysql);
				
				$modulename='';
				while($rows = $queryresult->fetch_array()) 
				{
					 $modulename.=$rows['module_name']." , ";
				}
				echo rtrim($modulename,' , ');

				if($_SESSION['admin_auto_id_sess']=='101')
				{
				?>
					<?php //echo ucfirst($module_name) ; ?>
                 <?php }?>

                </td>


              </tr>
              <?php
			$i++;
				}
				?>
            
              <?php
			
				}
			else
			{
			?>
              <tr>
                <td colspan="3"  align="center">No record found.</td>
              </tr>
              <?php
			}?>
            </table>
		
 
         <!-- <div class="return_dashboard"> <a href="welcome.php">Return to Dashboard</a></div>-->
          <div class="clear"></div>
      </div>
      <!-- right col -->
      
      <div class="clear"></div>
      
      <!-- Content Area end --> 
      
    </div>
    <!-- area div--> 
</div>
  <!-- main con--> 
  


</div>
</div>
<!-- Container div-->
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
