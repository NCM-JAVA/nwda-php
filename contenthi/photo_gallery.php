<?php
 ob_start();
 require_once "../includes/connection.php";
 require_once("../includes/config.inc.php");
 include("../includes/useAVclass.php");
 require_once "../includes/functions.inc.php";
//include('../design.php');
//include("../counter.php");


?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>National Water Development Agency</title>
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
		<link href="<?php echo $HomeURL;?>/css/lightbox.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo $HomeURL;?>/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo $HomeURL;?>/js/lightbox.js"></script>
	</head>
	
	<body id="fontSize">
		<header>
			<?php include("top_bar.php");?>
		</header>
		<div class="mobile-nav">
			<img src="images/toogle.png" alt="toogle" title="toogle">
		</div>
		<nav>
			<div class="">
				<?php include("header.php");?>
			</div>	
		</nav>
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						<?php include("leftmenu.php");?>
					</div>
					<div class="col-sm-9 main-content inner">
						<div class="">
							<ul class="breadcrumb">
								<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
								<li>चित्र प्रदर्शनी</li>
								<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
							</ul>
						</div>
						<h2>चित्र प्रदर्शनी</h2>
						
						<div class="photo-gallery">
							<div class="form-field">
							<?php
								$cat_query = "select * from category where cat_id='1' and c_status=1 and c_namehi!='Home Page Banner' order by create_date  DESC";
								$cat_result = $conn->query($cat_query);
								$cat_rows = mysqli_num_rows($cat_result);
								
								while ($fetch_result = $cat_result->fetch_array()) 
								{	
									$newid = $fetch_result['c_id'];
									$categoryname = $fetch_result['c_namehi'];
									
									$photo_query = "select * from photogallery where approve_status='3' and gallery_type='1' and category_id='$newid' order by id asc limit 0,1";
									$photo_result = $conn->query($photo_query);
									$photo_rows = mysqli_num_rows($photo_result);
									if( $photo_rows>0 )
									{
										$fetch_result1 = $photo_result->fetch_assoc();
										$image_pathnew = $HomeURL.'/upload/photogallery/media/'.$fetch_result1['img_uplode'];
										?>
											<div class="photo_gallCategoryBox">
												<div class="photo_gallCategory">
													<a href="<?php echo $HomeURL;?>/contenthi/view_all_photogallery.php?catid=<?php echo  $newid;  ?>" title="<?php echo $fetch_result1['sort_desc_hindi']; ?>" alt="<?php echo $fetch_result1['sort_desc_hindi']; ?>">
													<img src="<?php echo $image_pathnew;?>" alt=""  border="0" title="<?php  echo $fetch_result1['sortdesc'];  ?>"/></a>
													<!-- set div -->	
													<div class="gall-field">
														<p><?php  echo $categoryname;  ?></p>
													</div>
												</div>
											</div>		
											<?php
										}
									}
								?>
							</div>     
						</div>
					</div>
				</div>		
			</div>
		</section>
		<footer>
			<?php include("footer.php");?>
		</footer>
		<a href="javascript:" id="return-to-top"><img src="../images/top-arrow.png" title="Go to Top" alt="Go to Top"></a>
		<script type="text/javascript">
		// ===== Scroll to Top ==== 
		$(window).scroll(function() {
		if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
		$('#return-to-top').fadeIn(200);    // Fade in the arrow
		} else {
		$('#return-to-top').fadeOut(200);   // Else fade out the arrow
		}
		});
		$('#return-to-top').click(function() {      // When arrow is clicked
		$('body,html').animate({
		scrollTop : 0                       // Scroll to top of body
		}, 500);
		});
		</script>
	</body>
</html>
