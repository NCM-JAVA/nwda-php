<?php 
   ob_start();
   error_reporting(0);
   session_start();
   require_once "../../includes/connection.php";
   require_once("../../includes/config.inc.php");
   include("../../includes/useAVclass.php");
   require_once "../../includes/functions.inc.php";
 //  include('../../design.php');
 //  include("../../counter.php");
  // require_once "../../securimage/securimage.php";
   
   $m_name = "Vacancy List";
  
   ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $m_name; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="Vacancy">
		<meta name="description" content="Details of Vacancy Circulars, Advertisement, Circulars, Records and Tenders.">
		<meta name="keywords" content="Advertisement, Circulars, Records, Tenders">

		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
		<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
<script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script> 
	</head>
   <body id="fontSize">
      <header>
         <?php include("../top_bar.php");?>
      </header>
      <div class="mobile-nav">
         <img src="<?php echo $HomeURL?>/images/toggle.png" alt="toggle" title="toggle">
      </div>
      <nav>
         <div class="container">
            <?php include("../header.php");?>
         </div>
      </nav>
      <section>
         <div class="container"  id="skipCont">
            <div class="row">
               <div class="col-sm-3 left-navigation">
                  <?php include("../leftmenu.php");?>
               </div>
               <div class="col-sm-9 inner">
				   <div class="">
				      <ul class="breadcrumb">
				         <li><a href="<?php echo $HomeURL?>">Home</a></li>
				         <li>Vacancies</li>
				         <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onclick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
				      </ul>
				      <div class="bannerBox">
				         <img src="../../../upload/breadcrum_image/5942695f13e3cspecial_committee_banner.jpg" alt="" title="">
				         <h2>Vacancies</h2>
				      </div>
				   </div>

				   
				   <table class="table table-bordered table-striped">
				      <tbody>
				         <tr>
				            <th>Sr.No</th>
				            <th>Post Title</th>
				            <th>Advertisement No.</th>
				             <!-- <th>Post Type</th>-->
				            <!-- <th>Salary</th> -->
				            <th>Last Date</th>
				            <!-- <th>Language</th> -->
				            <!-- <th>Description</th> -->
				            <th>Advertisement Doc</th>
				            <th>Action</th>
				         </tr>
				         <?php
				         $sql="SELECT * FROM `post_mst` WHERE `approve_status` = '1'";
							$sqlVacancy = $conn->query($sql);
							
				         if ($sqlVacancy->num_rows > 0) {
                        $key=1;
				         	while ($row = $sqlVacancy->fetch_assoc()) { 
				         	@extract($row);
			         		$category = getJobCategoryById($category_id);
							   $location = getJobLocationById($location_id);
							?>

				         		<tr>
						            <td><?=$key?></td>
						            <td><?=$postname?></td>
						            <td><?=$advertisement_no?></td>
									<!-- <td><?=$ptype?></td>-->
						            <!-- <td><?=$salary?></td> -->
						            <td><?=$expairydate?></td>
									<!-- <td><?=$post_id?></td> -->
									<!-- <td> <a href="javascript:;" class="cat_link" title="View" onclick="MM_openBrWindow('show_description.php?post=<?=base64_encode($post_id)?>','window','width=1000,height=600,scrollbars=yes')">View </a></td> -->
									<td><a href ="<?php echo $HomeURL.'/upload/advertise/advertisement/'.$txtuplode; ?>" class="" alt="advertisement_doc" target="_blank">View</a></td>
						            <td><a href="<?=$HomeURL."/content/apply_post.php?post=".base64_encode($post_id)?>" class="cat_link" title="Apply">Apply Now</a></td>
						        </tr>
				         		<?php $key++;
				         	} }else{
				         		echo "<tr><td colspan='7' align='center'>No vacancy found.</td></tr>";
				         	}
				          ?>				         
				      </tbody>
				   </table>
				</div>
            </div>
         </div>
      </section>
      <footer>
         <?php include("../footer.php");?>
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
	function MM_openBrWindow(theURL,winName,features) 
	{ 
		window.open(theURL,winName,features);
	}
	</script>
   </body>
</html>