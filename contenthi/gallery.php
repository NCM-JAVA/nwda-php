<?php  ob_start();
session_start();
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
 $id=$_GET['txtcategory'];
 $m_name = "Photo Gallery";
 if($_POST['search']=='Search'){
	  if(trim($txtcategory)=="")
		{
		$errmsg .="Please Select Page Status."."<br>";
		}
		if($errmsg==''){
			 $txtcategory1=content_desc(htmlspecialchars($txtcategory)); 
	  	 $record= mysql_query("select * from photogallery where approve_status='3' AND category_id ='$txtcategory1'");
		// echo "select * from photogallery where approve_status='3' AND category_id ='$txtcategory1'";
		 }
	  }
	  else {
	  $record= mysql_query("select photogallery.* from photogallery join category on photogallery.category_id=category.c_id  where photogallery.gallery_type='1' and photogallery.approve_status='3' and category.c_status='1' ORDER BY photogallery.id DESC LIMIT 0,10");

	//  echo "select photogallery.* from photogallery join category on photogallery.category_id=category.c_id  where photogallery.gallery_type='1' and photogallery.approve_status='3' and category.c_status='1' and  ORDER BY photogallery.page_position DESC LIMIT 0,20";
	   }
	  	$CatgorySql=mysql_query("Select * from category where cat_id='1' and c_status='1' order by c_id asc");

						$CategoryNum = mysql_num_rows($CatgorySql);
					
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta name="author" content="">
<link rel="apple-touch-icon" href="<?php echo $HomeURL;?>/assets/images/favicon/apple-touch-icon.png">
<link rel="icon" href="<?php echo $HomeURL;?>/assets/images/favicon/favicon.png">
<title>Department of Empowerment of Persons with Disabilities Gallery page</title>

<!-- Custom styles for this template -->
<link href="<?php echo $HomeURL;?>/assets/css/base.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/base-responsive.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/grid.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font-awesome.min.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/flexslider.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/print.css" rel="stylesheet" media="print" />
<link rel="stylesheet" href="<?php echo $HomeURL;?>/assets/css/jquery.css" type="text/css" media="screen">

<!-- Theme styles for this template -->
<link href="<?php echo $HomeURL;?>/theme/css/site.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/theme/css/site-responsive.css" rel="stylesheet" media="all">

<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
<!-- Custom JS for this template -->



 

</head>

<body>

<div class="wrapper common-wrapper">
	<?php include("top_bar.php");?>
</div>
<!-- top bar end-->

<section class="wrapper header-wrapper">
	<?php include("header.php");?>
</section>
<!-- Header end-->

<nav class="wrapper nav-wrapper">
	<?php include("top_navigation.php");?>
</nav>
<!-- Nav end-->
<div class="wrapper" id="skipCont"></div><!--/#skipCont-->

<section id="fontSize" class="wrapper body-wrapper">
    <?php include("second_levelmenu.php"); ?> 
     <!--breadcrumb start-->
    <div id="breadcrumb">
      <div class="container"> 
       <div class="easy-breadcrumb">
        <ul>
  <li class="first"><?php echo "<a href=".$HomeURL."/content/>Home</a>"?></li>
			<span> &nbsp;>></span> Photo Gallery
</ul>
       </div>
       <div class="block-webspeech">      
          <button onClick="sideSpr(this);" id="sideSprButton">Read Content</button>
          <button onClick="sideStop()" id="sideStopButton">Stop</button>
       </div>   
      </div>  
    </div>
    <!--breadcrumb end-->
  <div class="inner-bg-wrapper">  
   <div class="container">     
    <div class="inner_left_container">
      <div class="inner_left_childmenu">
         
         <?php include("inner_left_menu.php");?>
      </div>
      <div class="inner_left_fixmenu">
        <?php include("inner_fixed_menu.php");?>
     </div>
  </div>
    <!--inner_left_container end-->
    
    <div class="inner_right_container">
      <h1 class="page__title">Photo Gallery</h1>
      <div class="filter">
      
					<form action="gallery.php" method="Post" autocomplete="off" >
					<select name="txtcategory1" id="txtcategory1" >
					<option  value="">Select</option>
					<?php 
							while($CategoryNum =mysql_fetch_array($CatgorySql))
							{
						?>
					<option value="<?php echo (content_desc(htmlspecialchars($CategoryNum['c_id'])));?>"<?php if(content_desc(htmlspecialchars($CategoryNum['c_id'])==$_POST['txtcategory1'])) echo 'selected="selected"';?>><?php echo (content_desc(htmlspecialchars($CategoryNum['c_name']))); ?></option>
					<?php } 
					 ?>
				
				</select>
								
	<input type="submit" name="go" id="go"  value="GO" />
	  </form>
      </div>
      <div class="inner_gallery">
      

<ul>
<?php  $count=mysql_num_rows($record); if($count >0){
while ($rows = mysql_fetch_array($record)) {
				$img_uplode = $rows['img_uplode'];
				$img_title = $rows['sortdesc'];
				$image_Name = '../upload/photogallery/media/'.$img_uplode;
				$image_NameL = '../upload/photogallery/media/'.$img_uplode;
				list($width, $height) = getimagesize($image_Name);
				?>
<li class="photo_item"><a class="photo_item_link fancybox" data-fancybox-group="gallery" href="<?php echo $image_NameL;?>" target="_blank" title="<?php echo $img_title;?>"><img width="180" height="111" src="<?php echo $image_Name;?>" class="attachment-220x134" alt="<?php echo $img_title;?>"/></a></li>
<?php } } else { echo "<div class='star'>No Record Found</div>"; }?></li>




</ul>
      </div>
    </div> 
	 
    </div>
    <!--inner_right_container end-->
   </div>
 </div>
</section>

<!--carousel-wrapper-Start-->
<section class="wrapper carousel-wrapper">
	<?php include("footer_gov_link.php");?>
</section>
<!--carousel-wrapper-end-->

<!--footer-start-->
<footer class="wrapper footer-wrapper">
	<?php include("footer.php");?>
</footer>
<!--footer-end-->
<script src="<?php echo $HomeURL;?>/assets/js/jquery_002.js" type="text/javascript"> </script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery1.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// enable fancybox if device window is more than 550
		if (screen.width > 550) {
			$('.fancybox').fancybox({
				padding: "7",
				mouseWheel: false,
				fitToView: true
			});
		}
		
	});
	
	
	
</script>

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
