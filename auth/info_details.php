<?php
ob_start();
session_start();
error_reporting(0);
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
require_once "../securimage/securimage.php";
include("../includes/def_constant.inc.php");
include('../design.php');
include("../includes/useAVclass.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
$id=$_GET['id'];
@extract($_POST);
$_SESSION['salt'] == "";
$_SESSION['saltCookie'] == "";
if ($_SESSION['admin_auto'] == '') {
    session_unset($admin_auto);
    session_unset($logintype);
    session_unset($login_user);
    session_unset($cookie_email);
    session_unset($cookie_fullname);
    $_SESSION['IsAuthorized'] = false;
    $msg = "Login to Access Employee Corner";
    $_SESSION['sess_msg'] = $msg;
    header("Location:index.php");
    exit;
}

?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>NWDA</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	
	
	
	</head>
	
	<body id="fontSize">
			<header>
			<?php include("../content/top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("../content/header.php");?>
		</div>	
		</nav>
	<section>
		
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("user_menu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a>&nbsp;/</li>
							<li><a href="information.php">Information</a></li>
							
						</ul>
					</div>
            
            
<div class="inner_right_container">
<?php  include('menu.php');?>
 
<div class="profile_page"> 
<h1>Information</h1>
</div>
<?php 
	 //include('menu.php');
 $edit="select * from employee where module_id='$id' ORDER BY page_postion  ASC";
$result = mysql_query($edit);
$res_rows=mysql_num_rows($result);
?>

<section>

                       <ul>
					   <?php
					   if($res_rows > 0) {
					    while($fetch_result=mysql_fetch_array($result)) {
@extract($fetch_result); 



?>


					   <li><a href="<?php echo $HomeURL.'/upload/employee/'.$docs_file;?>" target="_blank"><?php echo $m_name;?> </a></li>
					   <?php } } else {?>
					     <li>No Information available</li>
						 <?php } ?>
					   </ul>


   </section>

    </div> 
		</section>
	<footer>
			<?php include("../content/footer.php");?>
		</footer>
	
	<script type="text/javascript">
function editlist(id) {
var menuId = id;
var request = $.ajax({
url: "editid.php",
type: "POST",
data: {id : menuId},
dataType: "html"
});
request.done(function(msg) {
window.location.href = msg;
});
request.fail(function(jqXHR, textStatus) {
alert( "Request failed: " + textStatus );
});
 
}
</script>
	</body>
	
</html>
