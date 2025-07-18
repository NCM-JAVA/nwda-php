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
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />

	    <script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<link rel="stylesheet" href="<?php echo $HomeURL?>/css/meanmenu.css" />
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
		<!--<script src="<?php echo $HomeURL?>/js/swithcer.js" type="text/javascript"> </script>-->
        <script src="<?php echo $HomeURL?>/js/styleswitcher.js" type="text/javascript"></script>  
	<script type="text/javascript">
    
        // initialise plugins
        if(getCookie("mysheet") == "change" ) {
        setStylesheet("change") ;
        }else if(getCookie("mysheet") == "style" ) {
        setStylesheet("style") ;
        }else if(getCookie("mysheet") == "green" ) {
        setStylesheet("green") ;
        } else if(getCookie("mysheet") == "orange" ) {
        setStylesheet("orange") ;
        }else   {
        setStylesheet("") ;
        }
    </script>

			<script src="<?php echo $HomeURL?>/js/superfish.js"></script> 
			<script>

	(function($){ //create closure so we can safely use $ as alias for jQuery
	
	$(document).ready(function(){
	
	// initialise plugin
	var example = $('#example').superfish({
	//add options here if required
	});
	
	// buttons to demonstrate Superfish's public methods
	$('.destroy').on('click', function(){
	example.superfish('destroy');
	});
	
	$('.init').on('click', function(){
	example.superfish();
	});
	
	$('.open').on('click', function(){
	example.children('li:first').superfish('show');
	});
	
	$('.close').on('click', function(){
	example.children('li:first').superfish('hide');
	});
	});
	
	})(jQuery);
	</script>
			<script src="<?php echo $HomeURL?>/js/jquery.meanmenu.js"></script>   
    <script type="text/jscript">
    jQuery(document).ready(function () {
        jQuery('#main-nav nav').meanmenu()
    });
    </script>

		
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
