<?php 
ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
if($_SESSION['admin_auto_id_sess']=='')
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

@extract($_GET);
@extract($_POST);
@extract($_SESSION);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Employee Login List: <?=$sitename; ?></title>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

</head>
<body>
<?php include('top_header.php'); ?>
<div id="profile_p">
<div id="container">
<!-- Header start -->
 
  <div class="clear"></div>

  <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  
  
  
  
  <div class="main_con">
      <div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Employee Login List</a>
  </div>
<div class="clear"> </div>
</div>  
     
      <div class="content-content">
		<div class="right_col1"> 
		  <!-- Content div -->
          
       
			<?php
				if($_SESSION['edit_prof']!=''){?>
				<div  id="msgclose" class="status success">
				<div class="closestatus" style="float: none;">
				<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
				<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['edit_prof'];
				$_SESSION['edit_prof']=""; ?>.</p>
				</div>
				</div>
				<?php } ?>

				 <?php if($errmsg!=""){?>
				<div  id="msgerror" class="status error">
				<div class="closestatus" style="float: none;">
				<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
				<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?>.</p>
				</div>
				</div>
				<?php }?>
					 <div class="cpanel-left">
                     <div class="cpanel-right_heading"><h3 class="editprofile">Employee Login List</h3>  </div>
			
               	<div class="frm_row">
              		<table width="100%" border="1" cellspacing="2" cellpadding="2" summary="">
              			<thead>
              				<tr>
              					<th style="text-align:left;">Sr No.</th>
              					<th style="text-align:left;">User name</th>
              					<th style="text-align:left;">Login name</th>
              					<th style="text-align:left;">Email</th>
              					<th style="text-align:left;">Phone</th>
              					<th style="text-align:left;">Status</th>
              				</tr>
              			</thead>
              			<tbody>
              			<?php 
								$sqlq="select * from signup";
								$i=0;
            					$sqlsub1 = mysql_query($sqlq);
                			while($data=mysql_fetch_assoc($sqlsub1)){
							$i++;	
									?>
					<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $data['user_name']?></td>
					<td><?php echo $data['login_name']?></td>
					<td><?php echo $data['user_email']?></td>
					<td><?php echo $data['user_phone']?></td>
					<?php if( $data['flag_id']==NULL && $data['flag_id']!=1){ ?>
						<td style="color:red;"><b>Inactive</b> <i class="fa fa-close"></i></td>
						<?php } else{ ?>	
							<td style="color:green;"><b>Active</b> <i class="fa fa-check"></i></td>
						<?php }?>
					</tr>
						<?php } ?> 
							
							
							
							
						
						
						
              			</tbody>
              		</table>
              </div>        
        </div>
<!-- Footer start -->      
      <?php include("footer.php");    ?>
      <!-- Footer end --> 
</div>
</div>
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
