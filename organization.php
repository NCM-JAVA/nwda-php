<?php
ob_start();
require_once "../includes/connection.php";
// Commented by Neeraj because it was causing loading time. (13/12/19)
// require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
?>
<!DOCTYPE html>

<html lang="en">
<head>
<title>संगठन चार्ट:<?=$sitename;?></title>
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
<script src="<?php echo $HomeURL?>/js/modern-ticker.js"> </script>
<script src="<?php echo $HomeURL;?>/js/jquery.jOrgChart.js"></script>
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
<style>
/*.jOrgChart .top {height: 50px !important;}*/



a.tooltip span {
	background-color: #eeeeee;
	color:#013665;
	border:dotted 1px #c6c6c6;
}
a.tooltip {
	position: relative;
	top:0px;
	left: 0px;
}
a.tooltip:hover span {
	opacity: 1;
	visibility: visible;
}
a.tooltip span {
	padding:3px 3px 3px 7px;
	top:-111px;
	left:20px;
	white-space:nowrap;
	font-size:95%;
	height:auto;
	opacity:0;
	z-index:1000;
	position:absolute;
	visibility: hidden;
	word-wrap: break-word;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	-ms-transition: all 0.5s;
	-o-transition: all 0.5s;
}
/*#nav li {display:inline-block; padding:10px; border:1px solid;} 
#nav li a {padding:10px;}
#nav li ul {display:inline-block; padding:10px; border:2px solid #000;}
#nav li ul li {display:; padding:10px;}*/
.jOrgChart .line {
	height:15px;
	width:2px;
}
.jOrgChart .down {
	background-color:#656565;
	margin:0px auto;
}
.jOrgChart .top {
	border-top:2px solid #656565;
}
.jOrgChart .left {
	border-right:2px solid #656565;
}
.jOrgChart .right {
	border-left:2px solid #656565;
}
/* node cell */
.jOrgChart td {
	text-align:center;
	vertical-align:top;
	padding:0;
}
/* The node */
.jOrgChart .node {
	background-color:#4F81BC;
	display:inline-block;
	min-height:30px;
	z-index:10;
	/*margin:0 16px;*/
	margin:0 1px;
	font-size: 13px;
	border:1px solid #c7c7c7;
	padding: 6px;
	border-radius: 10px;
	color:#fff;
}
.jOrgChart .node a {
	background-color:#4F81BC;
	color:#fff;
	white-space:nowrap;
}
/* jQuery drag 'n drop */


.drag-active {
	border-style:dotted !important;
	background-color:red;
}
.drop-hover {
	border-style:solid !important;
	border-color:#E05E00 !important;
}
.os-page {
	width:100%;
}
.orgcharts table tr td, .orgcharts table {
	border:none;
}
.gallery_title {
	margin-top:8px;
	margin-bottom:5px;
}
.orgcharts table {
	font-size:0px;
}
#os-page {
	background:url("../images/internal-bg.jpg") no-repeat scroll left top #FCF8F4;
}
.orgChart {
	margin-top:10px;
	margin-bottom:20px;
}
.jOrgChart1 .line {
	height:30px;
	width:2px;
}
.jOrgChart1 .down {
	background-color:#656565;
	margin:0px auto;
}
.jOrgChart1 .top {
	border-top:2px solid #656565;
}
.jOrgChart1 .left {
	border-right:2px solid #656565;
}
.jOrgChart1 .right {
	border-left:2px solid #656565;
}
/* node cell */
.jOrgChart1 td {
	text-align:center;
	vertical-align:top;
	padding:0;
}
/* The node */
.jOrgChart1 .node {
	background-color:#EDEDED;
	display:inline-block;
	min-height:65px;
	z-index:10;
	margin:0 10px;
	padding:3px;
	font-size: 13px;
	border:1px solid #c7c7c7;
}
/* jQuery drag 'n drop */
a.tooltip1 span {
	background-color: #eeeeee;
	color:#013665;
	border:dotted 1px #c6c6c6;
}
a.tooltip1 {
	position: relative;
	top:0px;
	left: 0px;
}
a.tooltip1:hover span {
	opacity: 1;
	visibility: visible;
}
a.tooltip1 span {
	padding:3px 3px 3px 7px;
	top:70px;
	left:-30px;
	white-space:nowrap;
	font-size:100%;
	height:auto;
	opacity:0;
	z-index:1000;
	min-height:50px;
	min-width:70px;
	position:absolute;
	visibility: hidden;
	word-wrap: break-word;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	-ms-transition: all 0.5s;
	-o-transition: all 0.5s;
}
.orgChart {
	margin-top: 10px;
	/*margin-left: 150px;*/
}


/* box color codding */
.jOrgChart table .node, .jOrgChart table .node a {
	background-color:#561bd6;
}

.jOrgChart table table .node, .jOrgChart table table .node a {
	background-color:#70ad47;
}

.jOrgChart table table table .node, .jOrgChart table table table .node a {
	background-color:#1a7aba;
}

.jOrgChart table table table table .node, .jOrgChart table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table .node, .jOrgChart table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table table .node, .jOrgChart table table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table table table .node, .jOrgChart table table table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table table table table .node, .jOrgChart table table table table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table table table table table .node, .jOrgChart table table table table table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}

.jOrgChart table table table table table table table table table table .node, .jOrgChart table table table table table table table table table table .node a {
	background-color:#b71f1f;
	// pointer-events: none;
}


</style>
</head>

<body id="fontSize">
<header>
  <?php include("top_bar.php");?>
</header>
<div class="mobile-nav"> <img src="images/toogle.png" alt="toogle" title="toogle"> </div>
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

<div class="col-sm-9 h-content">
  	<div class="">
    	<ul class="breadcrumb">
      		<li><a href="<?php echo $HomeURL?>/contenthi/index.php">मुख्य पृष्ठ</a></li>
      		<li>संगठन चार्ट</li>
	  		<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
    	</ul>
		<div class="bannerBox">
			<img src="../upload/breadcrum_image/594265325588eorganization_banner.jpg" alt="" title="">
			<h2>संगठन चार्ट</h2>
		</div>
  	</div>
<!--Some changes made by Neeraj like language id added, and in place of * required field like img_uplode,url,name,designation were added(13/12/19)-->

<div class="int-content orgcharts table-responsive" id="skip">
    <div id="chart" class="orgChart"></div>
    	<div id='orgf1'>
		      			      	<ul id="org1" style="display:none;">
						<li><a href="http://nwda.gov.in/content/organization/director-generalx.php" title="महानिदेशक" class="1">महानिदेशक </a>

						<ul>
							<li><a href="http://nwda.gov.in/content/organization/chief-engineernorth.php" title="मुख्य अभियंता (उत्तर) लखनऊ" class="2">मुख्य अभियंता (उत्तर) लखनऊ</a>
				<ul><li><a href='http://nwda.gov.in/content/organization/se-gwalior.php' title='अधीक्षण अभियन्ता ग्वालियर' class=''>अधीक्षण अभियन्ता<br> ग्वालियर</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-jhansi.php' title='कार्यपालक अभियन्ता झांसी' class=''>कार्यपालक<br> अभियन्ता झांसी</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-bhopal.php' title='कार्यपालक अभियन्ता भोपाल' class=''>कार्यपालक<br> अभियन्ता भोपाल</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-gwalior.php' title='कार्यपालक अभियन्ता ग्वालियर' class=''>कार्यपालक<br> अभियन्ता ग्वालियर</a></li></ul></li></ul></li></ul></li><li><a href='http://nwda.gov.in/content/organization/se-bhubaneswar.php' title='अधीक्षण अभियन्ता भुवनेश्वर' class=''>अधीक्षण अभियन्ता <br>भुवनेश्वर</a><ul><li><a href='http://nwda.gov.in/content/organization/bhubaneswar.php' title='कार्यपालक अभियन्ता भुवनेश्वर' class=''>कार्यपालक<br> अभियन्ता भुवनेश्वर</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-kolkata.php' title='कार्यपालक अभियन्ता कोलकत्ता' class=''>कार्यपालक<br> अभियन्ता कोलकत्ता</a></li></ul></li></ul></li><li><a href='http://nwda.gov.in/content/organization/se-patna.php' title='अधीक्षण अभियन्ता पटना' class=''>अधीक्षण अभियन्ता<br> पटना</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-patna.php' title='कार्यपालक अभियन्ता पटना' class=''>कार्यपालक<br> अभियन्ता पटना</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-lucknow.php' title='कार्यपालक अभियन्ता लखनऊ' class=''>कार्यपालक<br> अभियन्ता लखनऊ</a></li></ul></li></ul></li></ul>					</li>
								<li><a href="http://nwda.gov.in/content/organization/chief-engineerhq.php" title="मुख्य अभियंता (मुख्यालय) नई दिल्ली" class="3">मुख्य अभियंता (मुख्यालय) नई दिल्ली</a>
				<ul><li><a href='http://nwda.gov.in/content/organization/adminstration-wing.php' title='निदेशक प्रशासन' class=''>निदेशक<br>(प्रशासन)</a></li><li><a href='http://nwda.gov.in/content/organization/finance-wing.php' title='निदेशक वित्त' class=''>निदेशक<br> (वित्त)</a></li><li><a href='http://nwda.gov.in/content/organization/technical-wing.php' title='निदेशक तकनीकी' class=''>निदेशक<br> (तकनीकी)</a></li><li><a href='http://nwda.gov.in/content/organization/multi-disciplinary-unit.php' title='निदेशक एम.डी.यू' class=''>निदेशक<br> (एम.डी.यू)</a></li><li><a href='http://nwda.gov.in/content/organization/superintending-engineer-1.php' title='SE 1' class=''>अधीक्षण अभियन्ता(द) </a></li><li><a href='http://nwda.gov.in/content/organization/superintending-engineer-2.php' title='Superintending Engineer(N)' class=''>अधीक्षण अभियन्ता(उ) </a></li></ul>					</li>
								<li><a href="http://nwda.gov.in/content/organization/chief-engineersouth.php" title="मुख्य अभियंता (दक्षिण) हैदराबाद" class="4">मुख्य अभियंता (दक्षिण) हैदराबाद</a>
				<ul><li><a href='http://nwda.gov.in/content/organization/se-valsad.php' title='अधीक्षण अभियन्ता वलसाड' class=''>अधीक्षण अभियन्ता <br>वलसाड</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-valsad.php' title='कार्यपालक अभियन्ता वलसाड' class=''>कार्यपालक<br> अभियन्ता वलसाड</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-vadodara.php' title='अधीक्षण अभियन्ता वडोदरा' class=''>कार्यपालक अभियन्ता <br>वडोदरा</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-nasik.php' title='EE, ID-I, Nashik' class=''>कार्यपालक अभियन्ता <br>नासिक - I</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-nasik-2.php' title='EE, ID-II, Nashik' class=''>कार्यपालक अभियन्ता <br>नासिक - II</a></li></ul></li></ul></li></ul></li></ul></li><li><a href='http://nwda.gov.in/content/organization/se-hyderabad.php' title='अधीक्षण अभियन्ता हैदराबाद' class=''>अधीक्षण अभियन्ता <br>हैदराबाद</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-hyderabad.php' title='कार्यपालक अभियन्ता हैदराबाद' class=''>कार्यपालक<br> अभियन्ता हैदराबाद</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-bangalore.php' title='कार्यपालक अभियन्ता बेंगलुरु' class=''>कार्यपालक<br> अभियन्ता बेंगलुरु</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-chennai.php' title='कार्यपालक अभियन्ता चेन्नई' class=''>कार्यपालक<br> अभियन्ता चेन्नई</a><ul><li><a href='http://nwda.gov.in/content/organization/ee-nagpur.php' title='कार्यपालक अभियन्ता नागपुर' class=''>कार्यपालक<br> अभियन्ता नागपुर</a></li></ul></li></ul></li></ul></li></ul></li></ul>					</li>
							</ul>	
							</li>
				  	</ul>
				</div>
	</div>
</div>


</div>
</div>
</section>

<footer>
  <?php include("footer.php");?>
</footer>
</body>
<script>
      // initialise plugins
     

	  $(document).ready(function() {
        $("#org1").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });
    });

</script>
</html>
