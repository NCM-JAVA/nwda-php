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
  <?php include("leftmenu.php");?>
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

<?php
// Some changes made by Neeraj like language id added, and in place of * required field like img_uplode,url,name,designation were added(13/12/19) 
function recurs_orgchart_level($level=0,$HomeURL)
 {
 $sql1 = mysql_query("select img_uplode,url,name,designation from organizationchart where level='$level' and profile_status='1' and approve_status='3' AND language_id='1' order by page_postion desc");
 $numRows1 = mysql_num_rows($sql1);
 if($numRows1>0):
 echo "<ul>";
 while($row1 = mysql_fetch_assoc($sql1))
 {
 echo "<li>";
 $personName = "";
 echo "<a href='".$HomeURL."/content/organization/".$row1['url']."' title='".$row1['name']."' class=''>".$personName.stripslashes(func_org_designation($row1['designation']))."</a>";
 $sql2 = mysql_query("select img_uplode,url,name,designation from organizationchart where level='".$row1['designation']."' and profile_status='1' and approve_status='3' AND language_id='1' order by page_postion desc");
 $numRows2 = mysql_num_rows($sql2);
 if($numRows2>0)
 {
 recurs_orgchart_level($row1['designation'],$HomeURL);
 }
 echo "</li>";
 }
 echo "</ul>";
 endif;
 }
?>


<!--Some changes made by Neeraj like language id added, and in place of * required field like img_uplode,url,name,designation were added(13/12/19)-->

<div class="int-content orgcharts table-responsive" id="skip">
    <div id="chart" class="orgChart"></div>
    	<div id='orgf1'>
		<?php
		$sql1 = "select img_uplode,url,name,designation from organizationchart where designation='1' AND language_id='1'";
		$rs = $conn->query($sql1); 
		$i = 1;
		$numRows1 = $rs->num_rows;
		if($numRows1>0):
		?>
      	<ul id="org1" >
		<?php
		$row1 = $rs->fetch_assoc();
		// commented by neeraj because it was not required(13/12/19)
		  	// while($row1 = mysql_fetch_assoc($sql1))
			// { 
				if($row1['img_uplode']!=='')
				{
				$imgparent=$HomeURL.'/upload/profile/'.$row1['img_uplode'];
				}
				else
				{
				$imgparent=$HomeURL.'/upload/profile/noimage.jpg';
				}
				?>
				<li><a href="<?php echo $HomeURL.'/content/organization/'.$row1['url'];?>" title="<?php echo $row1['name']; ?>" class="<?=$row1['designation']?>"><?php //echo $row1['name']."<br>";?>
				<?php echo stripslashes(func_org_designation($row1['designation']));?> </a>

			<?php
				$sql2 = mysql_query("select img_uplode,url,name,designation from organizationchart where level='".$row1['designation']."' and profile_status='1' and approve_status='3' AND language_id='1' order by page_postion desc");
				$numRows2 = mysql_num_rows($sql2);
				// $level = $row1['designation'];
				if($numRows2>0)
				{?>
			<ul>
			<?php
			while($row2 = mysql_fetch_assoc($sql2))
			{
				?>
				<li><a href="<?php echo $HomeURL.'/content/organization/'.$row2['url'];?>" title="<?php echo $row2['name']; ?>" class="<?=$row2['designation']?>"><?php //echo $row1['name']."<br>";?>
				<?php echo stripslashes(func_org_designation($row2['designation']));?> </a>
				<?php
				$sql3 = mysql_query("select img_uplode,url,name,designation from organizationchart where level='".$row2['designation']."' and profile_status='1' and approve_status='3' AND language_id='1' order by page_postion desc");
				$numRows3 = mysql_num_rows($sql3);
				if($numRows3>0)
				{
					// $level = $row2['designation'];
					recurs_orgchart_level($row2['designation'],$HomeURL);
					// include('child.php');
				}
				?>
					</li>
				<?php
			}
			?>
			</ul>	
			<?php
				}
				?>
				</li>
			<?php
			// }
		?>
	  	</ul>
		<?php
		endif;
		?>
		</div>
	</div>
</div>




<!-- this code is depricated to above one -->
<!--

  <div class="int-content orgcharts" id="skip">
    <div id="chart" class="orgChart"></div>
    <div id='orgf1'>
      <?php
$sql1 = mysql_query("select  * from organizationchart where designation='1' ");   
//echo  "select * from organizationchart where designation='1'";
$i = 1;
$numRows1 = mysql_num_rows($sql1);
?>
      <ul  id="org1" style="display:none;">
        <?php
while ($row1 = mysql_fetch_array($sql1))
{
 if($row1['img_uplode']!=='')
 {
 $imgparent=$HomeURL.'/upload/profile/'.$row1['img_uplode'];
 }
 else
 {
 $imgparent=$HomeURL.'/upload/profile/noimage.jpg';
 }
//echo $row['name']; 

$sql2 = mysql_query("select  * from organizationchart where level='".$row1['designation']."' and profile_status='1' order by page_postion desc");
$numRows2 = mysql_num_rows($sql2);
?>
        <li><a href="<?php echo $HomeURL.'/content/organization/'.$row1['url'];?>" title="<?php echo $row1['name']; ?>" class=""><?php echo $row1['name'];?><br/>
          <?php echo stripslashes(func_org_designation($row1['designation']));?> </a>
          <ul>
            <?php while ($row2 = mysql_fetch_array($sql2)) 
			{
			if($row2['img_uplode']!=='')
			 {
			 $img=$HomeURL.'/upload/profile/'.$row2['img_uplode'];
			 $alt = $row2['name'];
			 }
			 else
			 {
			 $img=$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }


			$sql3 = mysql_query("select * from organizationchart where level='".$row2['designation']."' and profile_status='1' and approve_status='3' order by page_postion desc");
			//echo "select * from organizationchart where level='".$rows['designation']."'  and approve_status='3' ";
			$numRows3 = mysql_num_rows($sql3);
		
		
		 if($row2['designation']==3)
		{?>
            <li><a href="<?php echo $HomeURL.'/content/organization/'.$row2['url'];?>"  title="<?php echo $row2['name']; ?>" class=""><?php echo $row2['name']; ?><br/>
              (<strong><?php echo stripslashes(func_org_designation($row2['designation']));?></strong>) </a>
              <?php } else { ?>
            <li><a href="<?php echo $HomeURL.'/content/organization/'.$row2['url'];?>"  title="<?php echo $row2['name']; ?>" class=""><?php echo $row2['name']; ?><br/>
              (<strong><?php echo stripslashes(func_org_designation($row2['designation']));?></strong>) </a>
              <?php } ?>
              <ul>
                <?php  
	
 while ($row3 = mysql_fetch_array($sql3))
			{
 
				if($row3['img_uplode']!=='')
			 {
			 $imgsub=$HomeURL.'/upload/profile/'.$row3['img_uplode'];
			 $alt = $row3['name'];
			 }
			 else
			 {
			 $imgsub=//$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }
			 $sql4 = mysql_query("select  * from organizationchart where level='".$row3['designation']."'  and profile_status='1' and approve_status=3");
			//echo "select * from organizationchart where level='".$row3['designation']."'  and approve_status='3' ";

		 ?>
                <li><a href="<?php //echo $HomeURL.'/content/organization/'.$row3['url'];?>?deg_id=<?php echo $row2['designation']; ?>" title="<?php echo $row3['name']; ?>" class=""><?php echo $row3['name']; ?><br/>
                  (<strong><?php echo stripslashes(func_org_designation($row3['designation']));?></strong>) </a>
                  <ul>
					<?php 
					

  while ($row4 = mysql_fetch_array($sql4)) 
			{
			if($row4['img_uplode']!=='')
			 {
			 $imgsub1=$HomeURL.'/upload/profile/'.$row4['img_uplode'];
			 $alt = $row4['name'];
			 }
			 else
			 {
			 $imgsub1=//$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }
			//print_r($row4);
				$sql5 = mysql_query("select * from organizationchart where level='".$row4['designation']."' and profile_status='1' and approve_status=3");
//echo "select * from organizationchart where level='".$row4['designation']."' and approve_status=3";
 ?>
                    <li><a href="<?php //echo $HomeURL.'/content/organization/'.$row2['url'];?>?deg_id=<?php //echo $row2['designation']; ?>" title="<?php //echo $row4['name']; ?>" class=""><?php //echo $row4['name']; ?><br/>
                      <?php //echo stripslashes($r);?> </a> </li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </li>
      </ul>
      <?php $i++; } ?>
    </div>
  </div>
</div>

-->
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
