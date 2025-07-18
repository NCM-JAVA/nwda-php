<?php 

ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
//include("../counter.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="title" content="Nwda">
<meta name="language" content="EN">
<meta name="description" content="National Water  Development Agency is an autonomous organization which was established under Societies Registration Act (Act XXI of 1860) in 1972">
<meta name="keywords" content="NWDA, National Water Development Agency, Nwda Tenders, Nwda About us, Publications, ILR, Detailed Project Report">
<title>National Water Development Agency</title>
<link rel="icon" href="<?php echo $HomeURL?>/assets/images/favicon.ico">	
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/main-page-print.css" rel="stylesheet" media="print">
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
	    <script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<link rel="stylesheet" href="<?php echo $HomeURL?>/css/meanmenu.css" /> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
		<script src="<?php echo $HomeURL?>/js/jquery.flexisel.js"></script>
		<script src="<?php echo $HomeURL?>/js/swithcer.js" type="text/javascript"> </script>
        <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script>  
	

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
    <script >
    jQuery(document).ready(function () {
        jQuery('#main-nav nav').meanmenu()
    });
    </script>
		
	<style>
	.height100per{
		height:100vh;
	}
	</style>

</head>
	
	<body id="fontSize">
		<header>
			<?php include("top_bar.php");?>
		</header>
				<div class="mobile-nav">
                <img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle">
				</div>
		<nav>
		<div class="">
			<?php include("header.php");?>
		</div>	
		</nav>
		<section>
		
			
			<div class="container" id="skipCont">
				<div class="row">
					<div class="col-sm-3 left-navigation">
					<?php include("leftmenu.php");?>
                    
                    <div class="top-button margin-top-link-menu">
									<?php include("linkmenu.php");?>
									</div>
					</div>
					<div class="col-sm-9 main-content">
							<div class="col-sm-10 top-main">
								<div class="col-md-9 banner">
									<?php include("banner.php");?>
								</div>
								<div class="col-md-3 news">
									<?php include("news.php");?>
								</div>
								<div class="bottom-main">
									<div class="col-md-12 aboutNDWA">
										<h1>Welcome To NWDA </h1>
										<div class="col-md-2 aboutDirector text-center">
											<div class="directrBoxx">
												<?php
												$sqlprofile="select * from home_page where m_id='4'";
												$resprofile=$conn->query($sqlprofile) or die(mysql_error());
												$rowprofile=$resprofile->fetch_assoc();
												?>
												<p class="name">
													<strong>
														<?php echo (isset($rowprofile['m_name']) && $rowprofile['m_name']!='')?$rowprofile['m_name']:'Director General'; ?>
														<?php echo (isset($rowprofile['designation']) && $rowprofile['designation']!='')?" ".$rowprofile['designation']:' Director General NWDA'; ?>
													</strong>
												</p>
												
													 <p class="positionD">
													<a href="<?php $HomeURL;?>innerpage/director-general-nwda.php" title="Director General">Profile
													</a>
												</p>
											</div>
										</div>
										<div class="col-md-10">
										<?php
									 	$sqlhome="select * from menu where menu_positions='1' and m_id='10'";
										$reshome=$conn->query($sqlhome) or die(mysql_error());
										$rowhome=$reshome->fetch_array();
										?>
											<p><?php  echo html_entity_decode(substr($rowhome['content'], 0, 860)); ?>...<a href="innerpage/overview.php">Read More</a></p>
										</div>
			                        </div>
								</div>
							</div>
							
							<div class="col-sm-2">
								<div class="row">
									<div class="minister-profile">
										<?php include("profile.php");?>
									</div>
                                </div>
							</div>
						
						<div  class="bottm-scroller bottom-slider col-sm-12">
                                        <div class="row">
                                <h3><a href="<?php echo $HomeURL;?>/content/photogallery.php">Photo Gallery</a></h3>
                                <?php include("photocategory.php");?>	
                                </div>		
                                </div>
						
						
					</div>
				</div>
				</div>
			
		<?php //include("../fourtyeightmonths.php");?>
		
		</section>
        
		
		<footer class="col-md-12">
        
			<?php include("footer.php");?>
		</footer>
	<script>
    
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
		visible: 4,
		interval: 2500,
		controls: {
			up: '.btnUp',
			down: '.btnDown',
			toggle: '.btnToggle'
		}
	});
});

</script>
<script>

$(window).load(function() {
    
    $("#flexiselDemo3").flexisel({
        visibleItems: 5,
        itemsToScroll: 1,         
        autoPlay: {
            enable: true,
            interval: 3000,
            pauseOnHover: true
        }        
    });
        
    
});
</script>
</body>	
</html>
