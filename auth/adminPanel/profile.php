<?php
	ob_start();
	require_once "../../includes/connection.php";
	include("../../includes/config.inc.php");
	include("../../includes/useAVclass.php");
	include("../../includes/def_constant.inc.php");
	include("../../includes/functions.inc.php");
	
	@extract($_GET);
	@extract($_POST);
	@extract($_SESSION);
	
	
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


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Profile: <?=$sitename; ?></title>
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
			<span class="submenuclass">View Profile</a>
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
                     <div class="cpanel-right_heading"><h3 class="editprofile">View Profile</h3>  </div>
	<?php
								$sql = "select * from admin_login where id ='$admin_auto_id_sess'";
								$result1 = $conn->query($sql);
									if($line = $result1->fetch_array()){
										@extract($line);
									}
							?>
               <div class="frm_row"> <div class="clear"></div></div>
              <div class="frm_row"> 
			  <span class="label1">
              <label>Login ID :</label>
              </span> 
			  <span class="input1">
			   <label  class="label1">
			  <?php echo $login_name;?>
			  </label>
			  </span>
              <div class="clear"></div>
            </div>
                <div class="frm_row"> <span class="label1">
              <label>Email :</label>
              <span class="star"></span></span> <span class="input1">
              <label  class="label1">
					<?php echo $user_email;?></label>
                         </span>
              <div class="clear"></div>
            </div>
              
          </div>

		   
        <!--  <div class="return_dashboard"> <a href="welcome.php" title="Return to Dashboard">Return to Dashboard</a></div>-->
          <div class="clear"></div>
      </div>

<!-- right col -->


    <div class="clear"></div>





<!-- Content Area end -->





  </div>  <!-- area div-->
  </div>  <!-- main con-->

  

</div> <!-- Container div-->

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
