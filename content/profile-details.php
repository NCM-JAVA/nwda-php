<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
//include('../design.php');
//include("../counter.php");

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
							<li>Profile Details</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button></li>
						</ul>
					</div>
						<h2>Profile Details</h2>
						<?php  $sqlprofile="select org.*,os.designation from organizationchart as org INNER JOIN org_setup as os ON org.designation=os.deg_id  where org.id='".$_REQUEST['pid']."' and  org.approve_status='3' order by org.id asc";
$resprofile=mysql_query($sqlprofile) or die(mysql_error());
$Totalrows=mysql_num_rows($resprofile);
					$rowprofile=mysql_fetch_array($resprofile);
				$newimg_uplode = $rowprofile['img_uplode'];
 $image_path = $HomeURL.'/upload/profile/'.$newimg_uplode;
				?>	
				<div class="profile">
								<img src="<?php echo $image_path?>" width="83" height="103" alt="profile2" title="minister img1">
								<p><b><?php echo $rowprofile['designation'];    ?></b><br>
<?php  echo strip_tags($rowprofile['content']);  ?>..<a href="profile-details.php?pid=<?php echo $rowprofile['id'];  ?>"></a></p>
								</div>
					
						
							
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
	
	</body>
	
</html>
