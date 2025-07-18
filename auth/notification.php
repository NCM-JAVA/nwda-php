<!DOCTYPE HTML>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Pragma: no-store");
ob_start();
session_start();
error_reporting(0);
require_once("../includes/frontconfig.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
/* include("../includes/def_constant.inc.php");
include('../design.php'); */
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
?>
    <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile :: Department of Disability Affairs</title>
<link rel="SHORTCUT ICON" href="<?php echo $HomeURL;?>/images/favicon.ico" />
<meta name="keywords" content="Profile " />
<meta name="description" content="Profile" />
<!--This is main stylesheet -->
<link href="<?php echo $HomeURL;?>/style/style.css" rel="stylesheet" type="text/css" /> <link href="<?php echo $HomeCss;?>style/page-background.css" rel="stylesheet" type="text/css"> <link href="<?php echo $HomeURL;?>/style/responsive.css" rel="stylesheet" type="text/css" /> <link href="<?php echo $HomeCss;?>style/page-responsive.css" rel="stylesheet" type="text/css"> 
<!--This is for mobile menu -->
<!--for dropdownmenu -->
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/access.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/dropdown.js"></script>

<script type="text/javascript">
      // initialise plugins
      jQuery(function () {
          dropdown('nav', 'hover', 1);
      });
</script>

<script>
    $(document).ready(function () {
        var i = false;
        $('.menu-icon').click(function () {
            $('.drop-down').stop(true, false).slideToggle(200);
        });

    });

</script>
<!--End -->
   

</head>

<body>

<!--Accessibility-->
<!--Accessibility-->
 <?php include('../content/accessbility-menu.php'); ?>
<!--Header-->


<!--Home page content-->
<!--Home page content-->
<div class="bottom-shadow">
<section>
<div class="menu-icon">
<div class="bar"> </div>
<div class="bar"> </div>
<div class="bar"> </div>
</div>
<div id="mcontent">
<nav class="drop-down tk-museo-sans">
    	   <?php include('../content/navigation.php'); ?>

    </nav>
  </div>  

    <div id="nav-banner-bottom">
     <?php include('../content/navigation-second.php'); ?>
    </div>
    <div class="clear"> </div>
    <div id="content-section">
      
      <div id="right-part-inner-page">
      <div id="about-us-buttons">
      <h2><a href="<?php echo $HomeURL;?>" title="Home">Home</a> >> Profile</h2>
      </div>
	   <?php 
	 include('menu.php');?>
      <div class="about-us-heading">
      <h2>Profile</h2>
     <div class="int-content feedback"> 
<div class="frm_row">
	 <?php
		if($_SESSION['sess_msg']!=''){?>
          <div class="status1 success">
            <p class="closestatus"> <a title="Close" href="">x</a></p>
            <p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><a href="#"><?php echo $_SESSION['sess_msg'];
			 $_SESSION['sess_msg']=""; ?></a>.</p>
          </div>
          <?php
		}
		?>
<span class="forget"><a href="index.php">Back </a></span>
<div class="clear"> </div>
 </div>
<div class="clear"> </div>
 </div>
<div class="clear"> </div>
</div>
</div>
<aside id="left-nav-inner-pages">
        <div>
<div id="main-points-section-inner-page"><?php if($_SESSION['admin_auto'] !=''){ include('left_menu_inner.php'); }?>
<?php include('../content/left_menu_inner.php');?></div>
 <div id="social-icons-inner-page"><?php include('../content/soical_media.php');?></div>
 
        </div>
      </aside> 
      <div class="clear"> </div>
    </div>
  </section>
</div>

<!--footer Section -->
<footer> 
<?php include('../content/footer.php');?>
</footer>
</body>
</html>
