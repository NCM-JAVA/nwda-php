<?php 
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
//include('../design.php');
//include("../counter.php");

 $news_id = trim($_REQUEST['nid']);


if(!is_numeric($news_id))
{
	header("Location:".$HomeURL."/contenthi/error.php");
	exit(); 
}


if($_SERVER['REQUEST_URI'])
		{
			
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']);  
		 $val=explode('/', $url);
		 $url=$val['3'];
		$open=$val['2'];
		
		if($url !='')
		{
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3'";
		}
		
						
						
			$sql1 = $conn->query($sql);			
			$count = $sql1->num_rows;
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}
				
				
		

			$row=mysqli_fetch_array($sql1);
			$page_id=$row['page_id'];
			 $page_name=$row['m_name'];
			 $position=$row['menu_positions'];
			//$rootid=get_root_parent($page_id);
			$rootid=$page_id;
			//$parentid=parentid($page_id);
			$parentid=$page_id;
			//$m_name=get_page($page_id);
			$m_url = $row['m_url'];
			 $sub_flag_id=$row['m_id'];
			 $m_flag_id = $row['m_flag_id'];
			 if($row['upload_img']!="")
				 $img="../../upload/breadcrum_image/".$row['upload_img'];
			 else
				 $img="../../upload/breadcrum_image/594264cff26ffwater_banner.jpg";
			 
			if($m_url=='media-gallery.php' || $m_url=='photogallery.php')
			{
			header("Location:".$HomeURL."/content/photogallery.php");
			exit();
			}
			
			if($m_url=='employee-corner.php')
			{
			header("Location:".$HomeURL."/auth/adminPanel/index.php");
			exit();
			}
			
			if($m_url=='site-map.php')
			{
			header("Location:".$HomeURL."/content/sitemap.php");
			exit();
			}
            if($m_url=='feedback.php')
			{
				header("Location:".$HomeURL."/content/feedback.php");
				exit();
			}
			
			  if($m_url=='publication.php')
			{
				header("Location:".$HomeURL."/content/publication.php");
				exit();
			}
			
			 if($m_url=='faq.php')
			{
				header("Location:".$HomeURL."/content/faq.php");
				exit();
			}
			
			 if($m_url=='archives.php')
			{
				header("Location:".$HomeURL."/content/archives.php");
				exit();
			}
	
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		  // $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			//$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
		 $title=$row['m_name'];
		 $btitle=''.$btitle.' : Police in India';
		 $body=stripslashes(html_entity_decode($row['content'])); 	
		
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
		
				$sqlnews="select * from combine_publish where m_id='".$news_id."'  and  cat_id='1' and approve_status='3' order by m_id desc";
                    $resnews=mysqli_query($conn, $sqlnews) or die(mysql_error());
					$rownews=mysqli_fetch_array($resnews);
		$keywords = explode(" ", $rownews['m_name']);	
?>	
<!DOCTYPE html>

<html lang="hi">
	<head>
		<title><?php echo $rownews['m_name']; ?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo $rownews['m_name']; ?>">
		<meta name="keywords" content="<?php echo $keywords[0];?>, <?php echo $keywords[6];?>, द हिंदू न्यूज, द टाइम्स ऑफ इंडिया न्यूज, न्यू पेपर कटिंग, बाढ़, जलसंसाधन, आईएलआर, जलप्रदूषण">
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
							<li><a href="<?php echo $HomeURL?>/contenthi/index.php" title="मुखपृष्ठ ">मुखपृष्ठ </a></li>
							<li>समाचार विवरण</li>
							<li><?php  echo $rownews['m_name']; ?></li>
							<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
						<div class="bannerBox">
							<img src="<?php echo $img;?>" alt="" title="" >
							<h2><?php  echo $rownews['m_name']; ?></h2>
						</div>
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
	
	</body>
	
</html>
