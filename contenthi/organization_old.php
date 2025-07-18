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
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	<script src="<?php echo $HomeURL;?>/js/jquery.jOrgChart.js"></script>
<style>
.jOrgChart .top {height: 50px !important;}



a.tooltip span {background-color: #eeeeee; color:#013665; border:dotted 1px #c6c6c6; }
a.tooltip {position: relative; top:0px; left: 0px;}
a.tooltip:hover span {opacity: 1; visibility: visible;}
a.tooltip span {padding:3px 3px 3px 7px; top:-111px; left:20px; white-space:nowrap;font-size:95%;height:auto;opacity:0; z-index:1000; 
position:absolute;visibility: hidden;word-wrap: break-word;-webkit-transition: all 0.5s; -moz-transition: all 0.5s; -ms-transition: all 0.5s;  -o-transition: all 0.5s;}
/*#nav li {display:inline-block; padding:10px; border:1px solid;} 
#nav li a {padding:10px;}
#nav li ul {display:inline-block; padding:10px; border:2px solid #000;}
#nav li ul li {display:; padding:10px;}*/
.jOrgChart .line {height:30px;width:2px;}
.jOrgChart .down {background-color:#656565;margin:0px auto;}
.jOrgChart .top {border-top:2px solid #656565;}
.jOrgChart .left {border-right:2px solid #656565;}
.jOrgChart .right {border-left:2px solid #656565;}
/* node cell */
.jOrgChart td {text-align:center;vertical-align:top;padding:0;}
/* The node */
.jOrgChart .node {background-color:#EDEDED;display:inline-block;min-height:65px;z-index:10;margin:0 2px; padding:3px; font-size: 16px; border:1px solid #c7c7c7;}
/* jQuery drag 'n drop */
.drag-active {border-style:dotted !important;}
.drop-hover {border-style:solid !important;border-color:#E05E00 !important;}
.os-page {width:100%;}
.orgcharts table tr td, .orgcharts table {border:none;}
.gallery_title {margin-top:8px; margin-bottom:5px;}
.orgcharts table {width:120px; font-size:0px;}
#os-page {background:url("../images/internal-bg.jpg") no-repeat scroll left top #FCF8F4;}
.orgChart {margin-top:10px;margin-left:150px;}

.jOrgChart1 .line {height:30px;width:2px;}
.jOrgChart1 .down {background-color:#656565;margin:0px auto;}
.jOrgChart1 .top {border-top:2px solid #656565;}
.jOrgChart1 .left {border-right:2px solid #656565;}
.jOrgChart1 .right {border-left:2px solid #656565;}
/* node cell */
.jOrgChart1 td {text-align:center;vertical-align:top;padding:0;}
/* The node */
.jOrgChart1 .node {background-color:#EDEDED;display:inline-block;min-height:65px;z-index:10;margin:0 10px; padding:3px; font-size: 13px; border:1px solid #c7c7c7;}
/* jQuery drag 'n drop */
a.tooltip1 span {background-color: #eeeeee; color:#013665; border:dotted 1px #c6c6c6; }
a.tooltip1 {position: relative; top:0px; left: 0px;}
a.tooltip1:hover span {opacity: 1; visibility: visible;}
a.tooltip1 span {padding:3px 3px 3px 7px; top:70px; left:-30px; white-space:nowrap;font-size:100%;height:auto;opacity:0; z-index:1000; min-height:50px; min-width:70px;
position:absolute;visibility: hidden;word-wrap: break-word;-webkit-transition: all 0.5s; -moz-transition: all 0.5s; -ms-transition: all 0.5s;  -o-transition: all 0.5s;}


orgChart {
    margin-top: 10px;
    margin-left: 150px;


}






</style>
	</head>
	
	<body id="fontSize">
			<header>
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
					<div class="col-sm-9 main-content orgcharts">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Organization Structure</li>
						</ul>
					</div>
					
						<h2>Organization Structure</h2>
<div class="int-content orgcharts" id="skip">
<div id="chart" class="orgChart"></div>
 <div id='orgf1'>

<?php
$sql = mysql_query("select * from organizationchart where designation='1' ");   
//echo  "select * from organizationchart where designation='1'";
$i = 1;
$count = mysql_num_rows($sql);
?>
<ul  id="org1" style="display:none">
<?php
while ($row = mysql_fetch_array($sql))
{
 if($row['img_uplode']!=='')
 {
 $imgparent=$HomeURL.'/upload/profile/'.$row['img_uplode'];
 }
 else
 {
 $imgparent=$HomeURL.'/upload/profile/noimage.jpg';
 }
echo $row['name']; 





$sql1 = mysql_query("select * from organizationchart where level='".$row['designation']."' and profile_status='1' order by page_postion desc");
 $row2 = mysql_num_rows($sql1);
?>
<li><a href="<?php echo $HomeURL.'/content/organization/'.$row['url'];?>" title="<?php echo $row['name']; ?>" class=""><?php echo $row['name'];?><br/>
<?php echo stripslashes(func_org_designation($row['designation']));?>
</a>
<ul>
		<?php while ($rows = mysql_fetch_array($sql1)) 
			{
			if($rows['img_uplode']!=='')
			 {
			 $img=$HomeURL.'/upload/profile/'.$rows['img_uplode'];
			 $alt = $rows['name'];
			 }
			 else
			 {
			 $img=$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }
			 $sqlsub = mysql_query("select * from organizationchart where level='".$rows['designation']."' and profile_status='1' and approve_status='3' order by page_postion desc");
			//echo "select * from organizationchart where level='".$rows['designation']."'  and approve_status='3' ";
			$row3 = mysql_num_rows($sqlsub);
		
		

		 if($rows['designation']==3)
		{?>



		<li><a href="<?php echo $HomeURL.'/content/organization/'.$rows['url'];?>"  title="<?php echo $rows['name']; ?>" class=""><?php echo $rows['name']; ?><br/>
(<strong><?php echo stripslashes(func_org_designation($rows['designation']));?></strong>)
 </a>
<?php } else { ?>

<li><a href="<?php echo $HomeURL.'/content/organization/'.$rows['url'];?>"  title="<?php echo $rows['name']; ?>" class=""><?php echo $rows['name']; ?><br/>
(<strong><?php echo stripslashes(func_org_designation($rows['designation']));?></strong>)
 </a>

		<?php } ?>
<ul>
		  <?php  
	
 while ($rowsub = mysql_fetch_array($sqlsub)) 
			{
 
				if($rowsub['img_uplode']!=='')
			 {
			 $imgsub=$HomeURL.'/upload/profile/'.$rowsub['img_uplode'];
			 $alt = $rowsub['name'];
			 }
			 else
			 {
			 $imgsub=$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }
			$sqlsub1 = mysql_query("select * from organizationchart where level='".$rowsub['designation']."'  and profile_status='1' and approve_status=3");
			//echo "select * from organizationchart where level='".$rowsub['designation']."'  and approve_status='3' ";

		 ?>
		 
		 
 <li><a href="<?php echo $HomeURL.'/content/organization/'.$rowsub['url'];?>?deg_id=<?php echo $rows['designation']; ?>" title="<?php echo $rowsub['name']; ?>" class=""><?php echo $rowsub['name']; ?><br/>
(<strong><?php echo stripslashes(func_org_designation($rowsub['designation']));?></strong>)
 </a>

 <ul>
 <?php 
  while ($rowsub1 = mysql_fetch_array($sqlsub1)) 
			{
			if($rowsub1['img_uplode']!=='')
			 {
			 $imgsub1=$HomeURL.'/upload/profile/'.$rowsub1['img_uplode'];
			 $alt = $rowsub1['name'];
			 }
			 else
			 {
			 $imgsub1=$HomeURL.'/upload/profile/noimage.jpg';
			 $alt = "";
			 }
			//print_r($rowsub1);
				 $sqlsub2 = mysql_query("select * from organizationchart where level='".$rowsub1['designation']."' and profile_status='1' and approve_status=3");
//echo "select * from organizationchart where level='".$rowsub1['designation']."' and approve_status=3";
 
 ?>
		 
  <li><a href="<?php echo $HomeURL.'/content/organization/'.$rows['url'];?>?deg_id=<?php echo $rows['designation']; ?>" title="<?php echo $rowsub1['name']; ?>" class=""><?php echo $rowsub1['name']; ?><br/>
<?php echo stripslashes($r);?>
  </a>
  
 
   </li>
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
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
	
	</body>
	<script type="text/javascript">
      // initialise plugins
     

	  $(document).ready(function() {
        $("#org1").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : false
        });//.find('div.node:nth(2)').parent().prepend('<table><tbody><tr><td class="line left ">&nbsp;</td> <td class="line right ">&nbsp;</td></tr></tbody></table>');
     $('div.node:nth(2)').parent().prepend('<table style="width: 100%;"><tbody><tr><td class="line left ">&nbsp;</td> <td class="line right " >&nbsp;</td></tr><tr><td class="line left ">&nbsp;</td> <td class="line right " >&nbsp;</td></tr></tbody></table>');
	  $('div.node:nth(16),  div.node:nth(18) , div.node:nth(18)').parent().prepend('<table style="width: 100%;"><tbody><tr><td class="line left " style=" height: 20px;">&nbsp;</td><td class="line right " style=" height: 20px;">&nbsp;</td></tr></tbody></table>');
    });
	
</script>
</html>
