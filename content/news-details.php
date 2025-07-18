<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
//include('../design.php');
//include("../counter.php");


$news_id = mysqli_real_escape_string($conn, $_REQUEST['nid'] );
$news_id = trim($news_id);

if(!is_numeric($news_id))
{
	header("Location:".$HomeURL."/content/error.php");
	exit(); 
}

if($_SERVER['REQUEST_URI'])
		{
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
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
			 
			if($m_url=='media-gallery.php' || $m_url=='photogallery.php')
			{
			header("Location:".$HomeURL."/content/photogallery.php");
			exit();
			}
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		   //$pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			//$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
		  $title=$row['m_name'];
		 $btitle=''.$btitle.' : NWDA';
		 $body=stripslashes(html_entity_decode($row['content'])); 	
		
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
		
	  $sqlnews="select * from combine_publish where m_id='".$news_id."'  and  cat_id='1' and approve_status='3' order by m_id desc";
                    $resnews=mysqli_query($conn, $sqlnews) or die(mysqli_error());
					$rownews=mysqli_fetch_array($resnews);
				$keywords = explode(" ", $rownews['m_name']);

?>
<!DOCTYPE html>

<html lang="en">
	<head> 
		<title><?php echo $rownews['m_name']; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="">
		<meta name="description" content="<?php echo $rownews['m_name']; ?>">
		<meta name="keywords" content="<?php echo $keywords[0]?>, <?php echo $keywords[2]?>, The Hindu news, The Times Of India news, Flood, Water Rsources, ILR, Water Pollution ">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	<script src="<?php echo $HomeURL?>/js/superfish.js"></script> 
				<link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />

		      <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script> 
			
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
								<li>News Details</li>
								<li><?php  echo $rownews['m_name']; ?></li>
								<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button></li>
							</ul>
						</div>
						<h3><?php  echo $rownews['m_name']; ?></h3>						
						<?php 
							$body=html_entity_decode($rownews['m_content']);
							$path='../';
							echo type_of_extention_size_file($body,$HomeURL,$path);
						?>
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
	</body>
</html>
