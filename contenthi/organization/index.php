<?php
	ob_start();
	require_once "../../includes/connection.php";
	require_once("../../includes/config.inc.php");
	include("../../includes/useAVclass.php");
	require_once "../../includes/functions.inc.php";
	//include('../../design.php');
	//include("../../counter.php");
	$url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
	$val=explode('/', $url);
	$url=$val['3'];
	$open=$val['2'];
	 $sql="SELECT * FROM `organizationchart` where url='$url'";
	$sql=mysqli_query($conn, $sql);
	$count=mysqli_num_rows($sql); 
	if($count=='0')
	{
	header("Location:".$HomeURL."/content/error.php");
	exit();
	}

	$row=mysqli_fetch_assoc($sql);
	$name=$row['name'];
	$content = $row['content'];
	$title='';
	$m_keyword=$row['name'];


	?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>संगठन चार्ट: राष्ट्रीय जल विकास अभिकरण?></title>
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
			<?php include("../top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toggle" title="toggle">
				</div>
		<nav>
		<div class="container">
			<?php include("../header.php");?>
		</div>	
		</nav>
		<section>
		
			
			<div class="container" id="skipCont">
				<div class="row">
					<div class="col-sm-3 left-navigation">
					<?php include("../leftmenu.php");?>
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
						<li><a href="<?php echo $HomeURL?>/contenthi/index.php" alt="मुख्य पृष्ठ">मुख्य पृष्ठ</a></li>
						<li><a href="<?php echo $HomeURL?>/contenthi/organization.php" alt="संगठन चार्ट">संगठन चार्ट</a></li>
						<li><?php echo $name;?></li>
						<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
						<div class="bannerBox">
							<img src="../../images/organization_banner.jpg" alt="" title="" >
							<h2><?php echo $name;?></h2>
                        </div>
					</div>
						<?php  
							if($count >0) {
								echo $body=stripslashes(html_entity_decode($content)); 
							} 

							else { ?>
							No details available.
							<?php }
						?>
							
					</div>
				</div>
				</div>
			
		
		
		</section>
		
		<footer>
			<?php include("../footer.php");?>
		</footer>
	
	
	</body>
	
</html>
