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
	$url=$val['4'];
	$open=$val['3'];
	$sql="SELECT * FROM `organizationchart` where url='$url'";
	$sql = $conn->query($sql);
	$count=$sql->num_rows; 
	if($count=='0'){
		header("Location:".$HomeURL."/content/error.php");
		exit(); 
	}

	$row=$sql->fetch_assoc();
	$name=$row['name'];
	$content = $row['content'];
	$title='';
	$m_keyword=$row['name'];
?>
<!DOCTYPE html>
  
<html lang="en">
	<head>
		<title><?=$name;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="<?php echo $title;?>">
		<meta name="keywords" content="<?php echo $m_keyword;?>, Organization Chart">
		<meta name="description" content="<?php echo 'Details and Work of NWDA Field office of '.$m_keyword; ?>">
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
                <img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle">
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
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li><a href="<?php echo $HomeURL;?>/content/organization.php" title="Organization Chart">Organization Chart</a></li>
							<li><?php echo $name;?></li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
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