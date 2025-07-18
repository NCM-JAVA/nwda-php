<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");

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
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />

	    <script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
		<script src="<?php echo $HomeURL?>/js/swithcer.js" type="text/javascript"> </script>
		
		
		
	


		
	</head>
	
	<body id="fontSize">
		<header id="skipCont">
			<?php include("top_bar.php");?>
		</header>
				<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("header.php");?>
		</div>	
		</nav>
		<section>
		
			
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
					<?php include("leftmenu.php");?>
					</div>
					<div class="col-sm-9 main-content">
						
							<div class="col-sm-9 top-main">
								
									<div class="col-md-6 banner">
									<?php include("banner.php");?>
									</div>
									<div class="col-md-3 news">
										<?php include("news.php");?>
									</div>
									<div class="col-md-3 top-button">
									<?php include("linkmenu.php");?>
									</div>
								
								<div class="bottom-main" id="skipCont">
								<h1>एनडब्ल्यूडीए मे आपका स्वागत है </h1>
					<?php
					$sqlhome="select * from menu where menu_positions='1' and m_id='1' and language_id='2'";
					$reshome=mysql_query($sqlhome) or die(mysql_error());
					$rowhome=mysql_fetch_array($reshome);
					?>
								<p><?php  echo substr($rowhome['content'],0,1180); ?>...<a href="innerpage/about-us.php">और देखें</a></p>
								
								</div>
							</div>
							
							<div class="col-sm-3 minister-profile">
								<?php include("profile.php");?>
							</div>
						
						
						<div  class="bottom-slider col-sm-12">
						<h3>चित्र प्रदर्शनी</h3>
						<?php include("photocategory.php");?>			
						</div>
						
					</div>
				</div>
				</div>
			
		
		
		</section>
		
		<footer>
			<?php include("footer.php");?>
		</footer>
		
<script>

       


$('a:has(span[tabindex])').on('focus', function () {
    $(this).find('span[tabindex]').focus();
}).on('keypress', 'span[tabindex]', function (e) {
    if(e.which === 13) { 
       this.click(); //this not $(this), to call native click method
       //or: $(this).parent()[0].click();
    }
});


$(document).ready(function(){
	$(".mobile-nav").click(function(){
	$("nav").toggle();
	
	});

});


  $('.carousel').carousel({
        interval: 3000
    })
 
 $(function () {
				
                $(".ticker").modernTicker({
                    effect: "scroll",
                    scrollInterval: 20,
                    transitionTime: 1000,
                    autoplay: true
                });
                });

$(function(){
	$('.demo5').easyTicker({
		direction: 'up',
		visible: 3,
		interval: 2500,
		controls: {
			up: '.btnUp',
			down: '.btnDown',
			toggle: '.btnToggle'
		}
	});
});

</script>
	   
	
	</body>
	
</html>
