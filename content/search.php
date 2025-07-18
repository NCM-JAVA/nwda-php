<?php ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php"); ?>
<!DOCTYPE html>
<html Lang="En">
	<head>
		<title>Search : National Water Development Agency</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="We are search everything in the NWDA website with the help of google custom search">
<meta name="keywords" content="Search, Custom Search, Google Custom Search">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
		<link rel="stylesheet" href="<?php echo $HomeURL?>/css/meanmenu.css" />
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js"> </script>
		<script src="<?php echo $HomeURL?>/js/styleswitcher.js"></script>  
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
		<script src="https://www.google.com/cse/brand?form=cse-search-box&lang=en"></script>
	</head>
	<body id="fontSize">
<?php
/* ob_start();
error_reporting(0);
session_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
require_once "../securimage/securimage.php"; */
?>
		<header>
			<?php include("top_bar.php");?>
		</header>
			<div class="mobile-nav">
				<img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle">
			</div>
		<nav>
			<div class="container">
				<?php include("header.php");?>
			</div>	
		</nav>
		<section>
			<div class="container"  id="skipCont">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						<?php include("leftmenu.php");?>
					</div>
					<div class="col-sm-9 main-content inner">
						<div class="">
							<ul class="breadcrumb">
								<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a>&nbsp;/</li>
								<li>Search</li>
								<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
							</ul>
						</div>
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-12 inner-main-contant">
									<h2>Search </h2>
									<?php $qtext=trim($_GET['q']); ?>
									<form  action="<?php echo $HomeURL;?>/content/search.php" id="cse-search-box" name="searchform" onSubmit=" if(this.q.value == '' || this.q.value.length < 1) { alert('Please enter a Search Keyword'); return false; }else {return gsearch('searchform')}">
										<input type="hidden" value="009166207481149357514:mz4zahaagea" name="cx">
										<input type="hidden" value="FORID:10" name="cof">
										<input type="hidden" value="UTF-8" name="ie" />
										<div class="form-group">
										<label for="qq">Enter your keywords</label>
										<input type="text"  autocomplete="off"  id="qq" class="form-control" name="q" value="<?php echo trim(htmlspecialchars(htmlentities($qtext)));?>"  placeholder ="Enter any keyword and press Enter "/>
										</div>
									<?php /*	<input type="button" alt="Search" id="cmdsubmit"   class="top-search btn btn-success" title="Search" value="Search"/> */ ?>
									</form>
									<div id="cse-search-results" style="padding-left:10px; height:auto"><gcse:searchresults-only></gcse:searchresults-only></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<footer> 
			<?php include("footer.php");?>
		</footer>
		<script>
			(function() {
			var cx = '009166207481149357514:mz4zahaagea';
			var gcse = document.createElement('script');
			gcse.type = 'text/javascript';
			gcse.async = true;
			gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//cse.google.com/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(gcse, s);
			})();
			</script>
			
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
		<script>
		jQuery.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^\w+$/i.test(value);
		}, "Letters, numbers, and underscores only please");

		jQuery.validator.addMethod("alpha", function(value, element) {
		return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
		});


		(function($,W,D)
		{
		//alert("fffff");
		var JQUERY4U = {};

		JQUERY4U.UTIL =
		{
		setupFormValidation: function()
		{
		//form validation rules
		$("#feedback-form").validate({

		rules: {

		txtemail: {
		required: true,
		email: true
		},
		txtphone: {
		required: true,
		number: true,
		minlength: 10
		},

		txtcomment: "required",
		code: "required"



		},
		messages: {
		txtename: "Please Enter Name that should be alphabet",
		txtemail: "Please  Enter Valid Email Id like abc@xyz.com ",
		txtphone: "Please Enter Contact Number that should be 10 to 12 digits",
		address: "Address should be alphanumeric",
		txtcomment: "Please Enter Comment",
		code: "Please enter correct Captcha code"

		},
		submitHandler: function(form) {
		form.submit();
		}
		});
		}
		}

		//when the dom has loaded setup form validation rules
		$(D).ready(function($) {

		JQUERY4U.UTIL.setupFormValidation();
		});

		})(jQuery, window, document);
		</script>
		<script>
		$(function(){
		$('#txtename').keyup(function()
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

		$(function(){
		$('#txtemail').keyup(function()
		{
		var yourInput = $(this).val();
		re = /[`~!#$%^*_|+=?;'<>\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
		var no_spl_char = yourInput.replace(/[`~!#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
		$(this).val(no_spl_char);
		}
		});

		});

		$(function(){
		$('#address').keyup(function()
		{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
		var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
		$(this).val(no_spl_char);
		}
		});

		});

		$(function(){
		$('#subject').keyup(function()
		{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
		var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
		$(this).val(no_spl_char);
		}
		});

		});

		$(function(){
		$('#comment').keyup(function()
		{
		var yourInput = $(this).val();
		re = /[`~!@#$%^*_|+=?;'\{\}\[\]\/]/gi;
		var isSplChar = re.test(yourInput);
		if(isSplChar)
		{
		var no_spl_char = yourInput.replace(/[`~!@#$%^*_|+=?;'<>\{\}\[\]\/]/gi, '');
		$(this).val(no_spl_char);
		}
		});

		});

		function validatePhone(txtPhone) {

		var a = document.getElementById(txtPhone).value;

		var filter = /^[0-9-+]+$/;

		if (filter.test(a)) {

		return true;

		}

		else {

		return false;

		}

		}​

		</script>
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
		function ClearFields() {

		document.getElementById("code").value = "";

		}
		</script>
		<script>
		function isNumberKey(evt)
		{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		{
		alert("Please enter numbers only");
		return false;
		}
		else
		{
		return true;
		}
		}  



		</script>
	</body>
</html>
