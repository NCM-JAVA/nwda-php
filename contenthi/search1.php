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
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="title" content="ICAR">
		<meta name="language" content="EN">
		<meta name="description" content="ICAR">
		<meta name="keyword" content="Home ,  ICAR-Vivekananda parvatiya Krishi Anusandhan Santhan">
		<title>ICAR</title>
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $HomeURL?>/css/meanmenu.css" />
		<link rel="stylesheet" href="<?php echo $HomeURL?>/css/responsive.css" />
		<link rel="stylesheet" media="print" href="<?php echo $HomeURL?>/css/print.css" />
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
		<!--<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />-->
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/blue.css" media="screen" title="blue" />
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
		
		<script src="<?php echo $HomeURL?>/js/swithcer.js"></script>
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>		
		<script src="<?php echo $HomeURL?>/js/superfish.js"></script>
		<script src="<?php echo $HomeURL?>/js/jquery.meanmenu.js"></script>
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script>
		<script type="text/javascript" src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		
			
	</head>
	<body id="fontSize">
	<div class="full_header">
	<header>
	<?php include("top_bar.php");?>
	</header>
	<div id="main-nav">
    <nav>
		<div class="container-fluid">
			<?php include("header.php");?>
		</div>
	
	</nav>
	</div>
	</div>
	<section>
	<div id="skipCont"class="clearfix"></div>
	<div class="container-fluid" >
	<div class="breadcrumb-nav">
		<ul class="breadcrumb">
			<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
			<li>Search</li>
		</ul>
		<span class="print">
						<a href="javascript: void(0);" title="Print" onclick="javascript:window.print();"> <span class="glyphicon glyphicon-print"></span></a>
	    </span>
	</div>
	</div>
	
		<div class="container-fluid">
		<div class="row">
			 <?php //include("mainmenu.php");?>
			<div class="col-sm-12 inner-main-contant">
                   <h2>Search </h2>
					 <?php $qtext=content_desc($_GET['q']); ?>


<form  action="<?php echo $HomeURL;?>/content/search.php" id="cse-search-box" name="searchform" onSubmit=" if(this.q.value == '' || this.q.value.length < 1) { alert('Please enter a Search Keyword'); return false; }else {return gsearch('searchform')}">
<input type="hidden" value="013280925726808751639:prx_1_bgpve" name="cx">
<input type="hidden" value="FORID:10" name="cof">
<input type="hidden" value="UTF-8" name="ie" />
<div class="form-group">
<label for="qq">Enter your keywords</label>
<input type="text"  autocomplete="off"  id="qq" class="form-control" name="q" value="<?php echo content_desc(htmlspecialchars(htmlentities($qtext)));?>"  />
</div>
<input type="image" alt="Search" id="cmdsubmit"   class="top-search btn btn-success" title="Search" />


</form>

<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=en"></script>
<div id="cse-search-results" style="padding-left:10px; height:auto"></div>

<script>
(function() {
var cx = '013280925726808751639:prx_1_bgpve';
var gcse = document.createElement('script');
gcse.type = 'text/javascript';
gcse.async = true;
gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
'//cse.google.com/cse.js?cx=' + cx;
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(gcse, s);
})();
</script>
<gcse:searchresults-only></gcse:searchresults-only>

<script>
 $(function(){
	$('#qq').keyup(function()
	{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
			var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
			$(this).val(no_spl_char);
		}
	});
 
 });
</script>
				
	     
		
            </div>
		</div>
		</div>
	</section>
	<footer>
		<?php include("../footer.php");?>
	</footer>
	
	

<script>
$(window).scroll(function(){
  var sticky = $('#main-nav'),
      scroll = $(window).scrollTop();

  if (scroll >= 100) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
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

	jQuery(document).ready(function () {
		jQuery('#main-nav nav').meanmenu()
	});
	
	if(getCookie("mysheet") == "change" ) {
        setStylesheet("change") ;
    }else if(getCookie("mysheet") == "style" ) {
        setStylesheet("style") ;
    }else if(getCookie("mysheet") == "blue" ) {
        setStylesheet("blue") ;
    } else if(getCookie("mysheet") == "orange" ) {
        setStylesheet("orange") ;
    }else   {
        setStylesheet("") ;
    }
	
</script>

	
	
	</body>
</html>
