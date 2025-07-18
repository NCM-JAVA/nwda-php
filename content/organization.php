<?php
ob_start();

require_once "../includes/connection.php";
// Commented by Neeraj because it was causing loading time. (13/12/19)
 require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";

?>
<!DOCTYPE html>

<html lang="en">
<head>
<title>Organization Chart</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="title" content="Organization Chart">
<meta name="description" content="Organization chart of NWDA from the Director General to Executive Engineer level">
<meta name="keywords" content="Organization structure, Director General, Chief Engineer, Director Finance, Executive Engineer">
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
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />

		      <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script>  

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
	background-color:#295809;
}

.jOrgChart table table table .node, .jOrgChart table table table .node a {
	background-color:#08446c;;
}

.jOrgChart table table table table .node, .jOrgChart table table table table .node a {
	background-color:#b71f1f;

}

.jOrgChart table table table table table .node, .jOrgChart table table table table table .node a {
	background-color:#b71f1f;


}

.jOrgChart table table table table table table .node, .jOrgChart table table table table table table .node a {
	background-color:#b71f1f;
	
}

.jOrgChart table table table table table table table .node, .jOrgChart table table table table table table table .node a {
	background-color:#b71f1f;

}

.jOrgChart table table table table table table table table .node, .jOrgChart table table table table table table table table .node a {
	background-color:#b71f1f;

}

.jOrgChart table table table table table table table table table .node, .jOrgChart table table table table table table table table table .node a {
	background-color:#b71f1f;

}

.jOrgChart table table table table table table table table table table .node, .jOrgChart table table table table table table table table table table .node a {
	background-color:#b71f1f;

}


</style>
</head>

<body id="fontSize">
<header>
  <?php include("top_bar.php");?>
</header>
<div class="mobile-nav"> <img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle"> </div>
<nav>
  <div class="container">
    <?php include("header.php");?>
  </div>
</nav>
<section>
<div class="container"  id="skipCont">
<div class="row">
<div class="col-sm-3 left-navigation">
  <ul class="list-group">
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/special-committee-for-ilr.php" title="SPECIAL COMMITTEE FOR ILR">Special Committee for ILR</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/india-water-week.php" title="INDIA WATER WEEK">India Water Week</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/citizens-charter.php" title="CITIZENS CHARTER">Citizens Charter</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/ilr-related-matters.php" title="ILR RELATED MATTERS">ILR Related Matters</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/publications.php" title="PUBLICATIONS">Publications</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/grievance-redressal.php" title="GRIEVANCE REDRESSAL">Grievance Redressal</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/vigilance-matters.php" title="VIGILANCE MATTERS">Vigilance Matters</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/court-cases.php" title="COURT CASES">Court Cases</a></li>
    <li class="list-group-item"><a href="<?php echo $HomeURL?>/content/leftpage/use-of-hindi.php" title="USE OF HINDI">Use of Hindi</a></li>
  </ul>
</div>

<div class="col-sm-9 h-content">
  <div class="">
    <ul class="breadcrumb">
      <li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
      <li>Organization Chart</li>
	  <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
    </ul>
	<div class="bannerBox">
	<img src="../upload/breadcrum_image/594265325588eorganization_banner.jpg" alt="" title="">
	<h2>Organization Chart</h2>
	</div>
  </div>



<!--Some changes made by Neeraj like language id added, and in place of * required field like img_uplode,url,name,designation were added(13/12/19)-->

<div class="int-content orgcharts table-responsive" id="skip">
    <div id="chart" class="orgChart"></div>
    	<div id='orgf1'>
		      	<ul id="org1" style="display:none;">
						<li><a href="<?php echo $HomeURL?>/content/organization/director-generalx.php" title="Director General" class="1">				Director General </a>

						<ul>
							<li><a href="<?php echo $HomeURL?>/content/organization/chief-engineernorth.php" title="Chief Engineer(North)" class="2">				Chief Engineer (North)  Lucknow </a>
				<ul><li><a href='<?php echo $HomeURL?>/content/organization/se-gwalior.php' title='SE Gwalior' class=''>SE Gwalior</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-jhansi.php' title='EE Jhansi' class=''>EE Jhansi</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-bhopal.php' title='EE Bhopal' class=''>EE Bhopal</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-gwalior.php' title='EE Gwalior' class=''>EE Gwalior</a></li></ul></li></ul></li></ul></li><li><a href='<?php echo $HomeURL?>/content/organization/se-bhubaneswar.php' title='SE Bhubaneswar' class=''>SE Bhubaneswar</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/bhubaneswar.php' title='Bhubaneswar' class=''>EE Bhubaneswar</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-kolkata.php' title='EE Kolkata' class=''>EE Kolkata</a></li></ul></li></ul></li><li><a href='<?php echo $HomeURL?>/content/organization/se-patna.php' title='SE Patna' class=''>SE Patna</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-patna.php' title='EE Patna' class=''>EE Patna</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-lucknow.php' title='EE Lucknow' class=''>EE Lucknow</a></li></ul></li></ul></li></ul>					</li>
								<li><a href="<?php echo $HomeURL?>/content/organization/chief-engineerhq.php" title="Chief Engineer(HQ)" class="3">				Chief Engineer (HQ) New Delhi </a>
				<ul><li><a href='<?php echo $HomeURL?>/content/organization/adminstration-wing.php' title='Adminstration Wing' class=''>Dir(A)</a></li><li><a href='<?php echo $HomeURL?>/content/organization/finance-wing.php' title='Finance Wing' class=''>Dir(F)</a></li><li><a href='<?php echo $HomeURL?>/content/organization/technical-wing.php' title='Technical Wing' class=''>Dir(T)</a></li><li><a href='<?php echo $HomeURL?>/content/organization/multi-disciplinary-unit.php' title='Multi Disciplinary Unit' class=''>Dir(MDU)</a></li><li><a href='<?php echo $HomeURL?>/content/organization/superintending-engineer-1.php' title='SE 1' class=''>SE(S)</a></li><li><a href='<?php echo $HomeURL?>/content/organization/superintending-engineer-2.php' title='Superintending Engineer(N)' class=''>SE(N)</a></li></ul>					</li>
								<li><a href="<?php echo $HomeURL?>/content/organization/chief-engineersouth.php" title="Chief Engineer(South)" class="4">				Chief Engineer (South) Hyderabad </a>
				<ul><li><a href='<?php echo $HomeURL?>/content/organization/se-valsad.php' title='SE Valsad' class=''>SE Valsad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-valsad.php' title='EE Valsad' class=''>EE Valsad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-vadodara.php' title='EE Vadodara' class=''>EE Vadodara</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-nasik.php' title='EE Nashik' class=''>EE Nashik</a></li></ul></li></ul></li></ul></li><li><a href='<?php echo $HomeURL?>/content/organization/se-hyderabad.php' title='SE Hyderabad' class=''>SE Hyderabad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-hyderabad.php' title='EE Hyderabad' class=''>EE Hyderabad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-rajahmundry.php' title='EE Rajahmundry' class=''>EE Rajahmundry</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-bangalore.php' title='EE Bengaluru' class=''>EE Bengaluru</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-chennai.php' title='EE Chennai' class=''>EE Chennai</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-nagpur.php' title='EE Nagpur' class=''>EE Nagpur</a></li></ul></li></ul></li></ul></li></ul></li></ul></li></ul>					</li>
				<!-- <ul><li><a href='<?php echo $HomeURL?>/content/organization/se-valsad.php' title='SE Valsad' class=''>SE Valsad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-valsad.php' title='EE Valsad' class=''>EE Valsad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-vadodara.php' title='EE Vadodara' class=''>EE Vadodara</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-nasik.php' title='EE, ID-I, Nashik' class=''>EE ID-I Nashik</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-nasik-2.php' title='EE, ID-II, Nashik' class=''>EE ID-II Nashik</a></li></ul></li></ul></li></ul></li></ul></li><li><a href='<?php echo $HomeURL?>/content/organization/se-hyderabad.php' title='SE Hyderabad' class=''>SE Hyderabad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-hyderabad.php' title='EE Hyderabad' class=''>EE Hyderabad</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-bangalore.php' title='EE Bengaluru' class=''>EE Bengaluru</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-chennai.php' title='EE Chennai' class=''>EE Chennai</a><ul><li><a href='<?php echo $HomeURL?>/content/organization/ee-nagpur.php' title='EE Nagpur' class=''>EE Nagpur</a></li></ul></li></ul></li></ul></li></ul></li></ul>					</li> -->
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
<script>
      // initialise plugins
     

	  $(document).ready(function() {
        $("#org1").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });
    });

</script>
</body>

</html>
