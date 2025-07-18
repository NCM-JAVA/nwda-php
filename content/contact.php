<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");

if($_SERVER['REQUEST_URI'])
		{
		 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
		 $url=$val['4'];
		$open=$val['3'];
		
		if($url !='')
		{
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3' and m_url='$url' ";
		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3'";
		}
		
						
						
			$sql=mysql_query($sql);
			 $count=mysql_num_rows($sql); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}
				
				
				
				

			$row=mysql_fetch_array($sql);
			$page_id=$row['page_id'];
			 $page_name=$row['m_name'];
			 $position=$row['menu_positions'];
			 $rootid=get_root_parent($page_id);
			 $parentid=parentid($page_id);
			 $m_name=get_page($page_id);
			 $m_url=$row['m_url'];
			 $sub_flag_id=$row['m_id'];
			 $m_flag_id = $row['m_flag_id'];
			 
	
		
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		   $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
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
							<li>Contact Us</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
					</div>
					
						<h2>Contact Us</h2>
<p><a href="<?php echo $HomeURL?>/upload/mmmm.pdf" target="_blank">Profile of Director General</a></p>
<p><a href="<?php echo $HomeURL?>/upload/nnnn.pdf" target="_blank">Contact Us</a></p>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
	
	</body>
	
</html>
