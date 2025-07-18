<?php
   ob_start();
   error_reporting(0);
   session_start();
 
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php"; 
   include('../design.php');
   //include("../counter.php");
   //require_once "../securimage/securimage.php";
 
   $m_name = "Online Query";
  
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Vacancy Details</title>
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
      <script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
<style>
.even{
	background-color: #0475ce;
    color: #fff;
}
.odd{
	background-color: #5378c1;
    color: #fff;
}
td a {
    color: #fff;
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
               <div class="col-sm-9 inner">
				   <div class="">
				      <ul class="breadcrumb">
				         <li><a href="<?php echo $HomeURL?>">Home</a></li>
				         <li>Vacancies</li>
				         <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onclick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
				      </ul>
				      <div class="bannerBox">
				         <img src="<?php echo $HomeURL?>/upload/breadcrum_image/5942695f13e3cspecial_committee_banner.jpg" alt="" title="">
				         <h2>Vacancy Circulars</h2>
				      </div>
				   </div>

					   
					   <table class="table table-bordered table-responsive" >
							<thead style="background-color: #00348b; color: #fff;">
								<th>Sr.No</th>
								<th>Vacancy Title</th>
								<th>Advertisement No.</th>
								<th>Start Date</th>
								<th>Last Date</th>
								<th>External Link</th>
								<th>Other Document</th>
								<th>Vacancy document</th>
							</thead>	
							<tbody>	
							 <?php $date=date('Y-m-d');
							 $sql="select * from manage_vacancy where status='3' and language_id='1' and date(end_date ) >= '$date' order by id asc ";
							 $sqlVacancy = $conn->query($sql);
							 if ($sqlVacancy->num_rows > 0) {
								$key=1;
								while ($row = $sqlVacancy->fetch_assoc()) { 
								 if($class=="odd")
								  {
									$class="even";
								  }
								  else
								  {
									$class="odd";
								  } 
								@extract($row);
								
								  $doc_file = $row['docs_file'];
								  $other_doc_file = $row['other_docs_file'];
								  
								if($doc_file!=''){
									$filen="<a href='../upload/$doc_file' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'>" . Filebytes('../upload/'.$doc_file)."</a>";
								}
								else{
									$filen="No file available for preview";
								}
								if($other_doc_file!=''){
									$filens="<a href='../upload/$other_doc_file' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'>" . Filebytes('../upload/'.$other_doc_file)."</a>";
								}
								else{
									$filens="No file available for preview";
								}
								
								?>

									<tr class="<?=$class;?>">
										<td><?=$key?></td>
										<td><?=$job_title; ?></td>
										<td><?=$advt_no; ?></td>
										<td><?=$start_date?></td>
										<td><?=$end_date?></td>
										<td><?php if($external_link!='') { echo '<a href="'.$external_link.'" target="_blank">Click Here to View</a>'; }else{ echo "N/A"; } ?></td>
										<td><?php if($other_docs_file!="") { echo $filens; }else{ echo"N/A"; } ?></td>
										<td><?php  echo $filen;  ?></td>
									</tr>
									<?php $key++;
								} }else{
									echo "<tr><td colspan='8' align='center'>No vacancy found.</td></tr>";
								}
							  ?>				         
							</tbody>
					   </table>
					   <a href="<?php echo $HomeURL?>/content/vacancy_archives.php" class="btn btn-primary btn-sm" style="float:right;">View Archive</a>
				   </div>
				</div>
            </div>
         </div>
      </section>
      <footer>
         <?php include("footer.php");?>
      </footer>

      <script>
	function MM_openBrWindow(theURL,winName,features) 
	{ 
		window.open(theURL,winName,features);
	}
	</script>
   </body>
</html>