<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
/* include('../design.php');
include("../counter.php");
 */
if($_SERVER['REQUEST_URI'])
		{
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
		 $url=$val['3'];
		$open=$val['2'];
		
		if($url !='')
		{
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3' and m_url='$url' ";
		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3'";
		}
		
						
						
			$sql=mysqli_query($conn, $sql);
			 $count=mysqli_num_rows($sql); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}
				
	

			$row=mysqli_fetch_array($sql);
			$page_id=$row['page_id'];
			 $page_name=$row['m_name'];
			 $position=$row['menu_positions'];
			$get_root_parent ="SELECT m_flag_id as page_id,m_publish_id FROM menu_publish where m_publish_id ='$page_id' and approve_status='3' ORDER BY page_postion ASC";  
			$result1 = $conn->query($get_root_parent);
			$line1 =$result1->fetch_array();
			$pag=$line1['page_id'];
			$m_publish_id=$line1['m_publish_id'];
			$rootid=$m_publish_id;
			

			$parentid ="SELECT m_flag_id as page_id,m_publish_id FROM menu_publish where m_publish_id ='$page_id' and approve_status='3' ORDER BY page_postion ASC";  
			$result2 = $conn->query($parentid);
			$line2 =$result2->fetch_array();
			$pag=$line2['page_id'];
			$parentid=$line2['m_publish_id']; 
			

			$get_page ="SELECT m_flag_id as page_id,m_publish_id,m_name FROM menu_publish where m_publish_id ='$page_id' and 	approve_status='3' ORDER BY page_postion ASC";  
			$result3 = $conn->query($get_page);
			$line3 =$result3->fetch_array();
			$pag=$line3['page_id'];
			$m_name=$line3['m_name']; 
			 $m_url=$row['m_url'];
			 $sub_flag_id=$row['m_id'];
			 $m_flag_id = $row['m_flag_id'];
			 
	
		
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		 //  $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			//$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
		 $title=$row['m_name'];
		 $btitle=''.$btitle.' : Police in India';
		 $body=stripslashes(html_entity_decode($row['content'])); 	
		
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Tenders</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="Tenders">
		<meta name="description" content="Tenders for survey & investigation, procurement and other work of NWDA">
		<meta name="keywords" content="tenders, E-tender, Pre-bid">
		
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
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
	 <script src="<?php echo $HomeURL?>/js/styleswitcher.js"></script>  
	
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
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Tenders</li>
							 <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
					 <div class="bannerBox">
                        <img src="../images/tender_banner.jpg" alt="" title="" >
							<h2>Tenders</h2>
                        </div>
					</div>
					
						
						<table class="table table-bordered" title="tender">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Tender Title</th>
							<th>Start Date</th>
							<th>Last Date</th>
							<th>File</th>
						</tr>
					</thead>
					<tbody>     
						
			  <?php  
			  if($_REQUEST['tid']!='')
			  {
			  $sqlten="select * from tender_publish where m_id='".$_REQUEST['tid']."' and language_id='1' and approve_status='3' order by start_date desc ";
			  }
			  else
			  {
				  $date=date('Y-m-d'); 
			  $sqlten="select * from tender_publish where approve_status='3' and language_id='1' and date(end_date) >= '$date' order by start_date desc ";
			  }
			  
                     $resten=mysqli_query($conn, $sqlten) or die(mysqli_error());
					 $m=1;
					 if(mysqli_num_rows($resten)>0)
					 {
					 while($rowten=mysqli_fetch_array($resten))
					 {
					 $fname=$rowten['docs_file'];
					$language_temp=$rowten['language_id'];
					 if($fname!='')
					 {
					  $filen="<a href='../upload/$fname' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'> ".Filebytes('../upload/'.$fname)."</a>";
					 }
					 else
					 {
					  $filen="No file available for preview";
					 }
				?>			
					<tr>
					    <td><?php  echo $m; ?></td>
						<td><?php  echo $rowten['m_name']; ?> <?php if($rowten['c_new_status']==1){ ?><img src="<?php echo $HomeURL?>/images/new.gif" style="width:50px;"><?php }else{}?></td>
						<td class="whitespace_nowrape"><?php  echo date('d-m-Y', strtotime($rowten['start_date'])); ?></td>
						<td class="whitespace_nowrape"><?php  echo date('d-m-Y', strtotime($rowten['end_date'])); ?></td>
						<td><?php  echo $filen;  ?></td>
					</tr>
				<?php  $m++; } 
					 

				}
				else{?>	
					<tr>
					    <td colspan='4' class="center">No Record Found.</td>
					</tr>
					<?php
					} ?>
					</tbody>
				
				</table>
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
	
	</body>
	
</html>
