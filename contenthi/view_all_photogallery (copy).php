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
	
	<link href="<?php echo $HomeURL;?>/css/lightbox.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $HomeURL;?>/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo $HomeURL;?>/js/lightbox.js"></script>		
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
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Photo Gallery</li>
						</ul>
					</div>
						<h2>Photo Gallery</h2>
				
				
				
				<div class="photo-gallery">
					<?php
								 $photo_query = "select category.c_name,category.c_id,photogallery.sortdesc,photogallery.img_uplode,photogallery.gallery_type from photogallery inner join category on category.c_id = photogallery.category_id where photogallery.category_id='".$_REQUEST['catid']."' and photogallery.approve_status='3'  and photogallery.gallery_type='1' and category.c_name!='Home Page Banner' group by photogallery.category_id order by  category.c_id  desc";
								$photo_result = mysql_query($photo_query);
								$res_rows = mysql_num_rows($photo_result);

								
								
								while ($fetch_result = mysql_fetch_array($photo_result)) {
								//@extract($fetch_result);
								$newid = $fetch_result['c_id'];
								$newimg_uplode = $fetch_result['img_uplode'];
								$categoryname = $fetch_result['c_name'];
								$categoryname1=htmlspecialchars($c_name);
								$categoryid = $fetch_result['c_id'];
								$eng_pagetitle = $fetch_result['eng_pagetitle'];
								 $image_path = $HomeURL.'/upload/photogallery/media/'.$newimg_uplode;

								?>
							


									<!--<div class="clear">  </div>-->
								
                                <div class="form-field">
								<p><?php echo $categoryname;?></p>
								<div class="back"><a href="#" onclick="javascript:history.go(-1)">Back</a></div>
								
                                
                                
								<?php
								 $photo_query1 = "select category.c_name,photogallery.sortdesc,photogallery.img_uplode from photogallery inner join 
								category on category.c_id = photogallery.category_id where photogallery.approve_status='3' and photogallery.gallery_type='1'
								and category.c_name!='Home Page Banner' and photogallery.category_id ='$newid' limit 1, 20 ";

								//and img_uplode!='$newimg_uplode'

								$photo_result1 = mysql_query($photo_query1);
								$res_rows1 = mysql_num_rows($photo_result1);
								?>
								

<?php
	
								while ($fetch_result1 = mysql_fetch_array($photo_result1)) {
								//echo "ggg".$newcat=$categoryid;
								$categoryname = $fetch_result1['categoryname'];
								$categoryname1=htmlspecialchars($categoryname);
								$photoimg=$fetch_result1['img_uplode'];
								 $image_pathnew = $HomeURL.'/upload/photogallery/media/'.$photoimg;
								?> 
								<div class="frame1">
								<a href="<?php echo $HomeURL . "/upload/photogallery/media/" . $fetch_result1['img_uplode'] ?>" 
								rel="lightbox[<?php echo $categoryid ?>]" title="<?php echo $fetch_result1['sortdesc']; ?>" alt="<?php echo $fetch_result1['sortdesc']; ?>">
								<img src="<?php echo $image_pathnew;?>" width="209" height="138" alt=""  border="0" title=""/></a>
								 <!-- set div -->	
								  <div class="form-field">
								<p><?php  echo $fetch_result1['sortdesc'];  ?></p>
								</div>
								 </div>
								<?php 
								}
								?>
                                
                                <?php
								 }
								 ?>	

								
                       
                </div>
               
                    </div>
				
					
				
			
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
