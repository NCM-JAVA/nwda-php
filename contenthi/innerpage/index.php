<?php
ob_start();
 require_once "../../includes/connection.php";
 require_once("../../includes/config.inc.php");
 include("../../includes/useAVclass.php");
 require_once "../../includes/functions.inc.php";
//include('../../design.php');
//include("../../counter.php");

		if($_SERVER['REQUEST_URI'])
		{
			$url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
			$val=explode('/', $url);
			$url=$val['4'];
			$open=$val['3'];
		
			if($url !='')
			{
				$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
			}else{
				$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3'";
			}

			$sql1 = $conn->query($sql);
			 $count = $sql1->num_rows; 
			 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}

			$row = $sql1->fetch_array();
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
			
			$get_page_img ="SELECT m_flag_id as page_id,m_publish_id,m_name,upload_img FROM menu_publish where m_publish_id ='$page_id' and 	approve_status='3' ORDER BY page_postion ASC";  
			$result4 = $conn->query($get_page_img);
			$line4 =$result4->fetch_array();
			$pag=$line4['page_id'];
			$upload_img=$line4['upload_img'];
		
			 if($row['upload_img']!="")
				 $img="../../upload/breadcrum_image/".$row['upload_img'];
			 else
				 $img="../../upload/breadcrum_image/594264cff26ffwater_banner.jpg";
			 
		//	if($m_url=='tenders-hi.php')
			if($m_url=='tender-hi.php')
			{
			header("Location:".$HomeURL."/contenthi/tenders.php");
			exit();
			}
			
			if($m_url=='employee-corner-hi.php')
			{
			header("Location:".$HomeURL."/auth/adminPanel/index.php");
			exit();
			}
			
			if($m_url=='sitemap-hi.php')
			{
			header("Location:".$HomeURL."/contenthi/sitemap.php");
			exit();
			}
            if($m_url=='feedback-hi.php')
			{
				header("Location:".$HomeURL."/contenthi/feedback.php");
				exit();
			}
			
			  if($m_url=='vacancy-circulars-hi.php')
			{
				
				header("Location:".$HomeURL."/contenthi/innerpage/vacancydetails-hi.php");
				exit();
			} 
			
			 if($m_url=='official-circulars-hi.php')
			{
				
				header("Location:".$HomeURL."/contenthi/circulars.php");
				exit();
			} 
			
			 if($m_url=='faq-hi.php')
			{
				header("Location:".$HomeURL."/contenthi/faq-hi.php");
				exit();
			}
			
			 if($m_url=='archives-hi.php')
			{
				header("Location:".$HomeURL."/contenthi/archives.php");
				exit();
			}
		
			 if($m_url=='organization-chart-hi.php')
			{

				header("Location:".$HomeURL."/contenthi/organization.php"); 
				exit();
			}
			
			 if($m_url=='online-query-hi.php')
			{
				header("Location:".$HomeURL."/contenthi/feedback.php");
				exit();
			}
			
			//  if($m_url=='related-links-hi.php')
			// {
			// 	header("Location:".$HomeURL."/contenthi/related-links.php");
			// 	exit();
			// }
		
		  if($m_url=='discussion-forum-hi.php')
			{
				header("Location:".$HomeURL."/auth/discussion_forum.php");
				exit();
			}
			if($m_url=='glossary-hi.php')
			{
				header("Location:".$HomeURL."/auth/disability.php");
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

?>
<!DOCTYPE html>

<html lang="hi">
	<head>
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="EN">
<meta name="title" content="I<?php echo $title;?>">
<meta name="description" content="I<?php echo $m_description;?>">
<meta name="keyword" content="<?php echo $m_keyword;?>">

		<title><?php echo $title;?> :: <?=$sitenamehi;?> </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="language" content="hi">
		<meta name="title" content="<?php echo $title;?>">
		<meta name="keyword" content="<?php echo $title;?>">
		<meta name="description" content="<?php echo $title;?>">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
				<style>
		.archive{
			 background: #11a907; 
			 box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			 text-align: center;
			 padding: 5px; 
			 color: white;
			 float: right; 
			 margin-right: 10px;
		 }
		</style>
	</head>
	
	<body id="fontSize">
			<header>
			<?php include("../top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toggle.png" alt="toggle" title="toggle">
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
						<?php include("left_panel.php");?>
						<div class="top-button margin-top-link-menu">
							<?php include("../linkmenu.php");?>
						</div>
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/contenthi/index.php">मुख्य पृष्ठ</a></li>
							<li><?php if($pgprntnams !="") echo $pgprntnams; ?></li>
							
							<li><?php if($title !="" && $pgprntnams != $title ) echo $title; ?></li>
							
							<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
                        			<div class="bannerBox">
			                        	<img src="<?php echo $img;?>" alt="" title="" >
                        				<h2><?php echo $title;?></h2>
			                        </div>
					</div>
						<?php 
						$url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']);  
						$val=explode('/', $url);
						$url=$val['3'];
						$open=$val['2'];
						if($url=='vacancydetails-hi.php'){?>
						<div><a href="./vacancy-archives-hi.php" class="archive">अभिलेखागार देखें</a></div>
						<?php }elseif($url=='water-resources-in-media-hi.php'){ ?>
						<div><a href="./water-resources-in-media-archive-hi.php" class="archive">अभिलेखागार देखें</a></div>
						<?php } ?>
					
						<?php
			
					$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; 
							if(preg_match_all("/$regexp/siU", $body, $matches, PREG_SET_ORDER)) 
							{ 
						
							foreach($matches as $match) 
							{ 

								$phrase  = $match[2];
								$extenM1=substr($match[2],7);
								$healthy = array("_","@",".");
								$yummy   = array("[underscore]","[at]","[dot]");
								$newphrase = str_replace($healthy, $yummy, $extenM1);
								$extenM=substr($match[2],0,6);
								if($extenM=="mailto")
								{
									$body=str_replace($match[0],$newphrase,$body);
								}
							$exten=substr($match[2],-4);
							$startstr=substr($match[2],0,4);
							
							
							
							 
						if($startstr=="http")
						{
							if($exten=='.pdf')
							{
							$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('http://www.servicetax.gov.in' , '' , $match[2]) );
							//echo $file = $_SERVER['HTTP_HOST']. $match[2];
								$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='PDF that opens in new window'>$match[3]&nbsp;<img src='$HomeURL/images/pdf_icon.png' alt='PDF File'></a>".'&nbsp;&nbsp;'  .'<span class="file-size">'. Filebytes($file).'</span>',$body);
							}

							if(($exten=='.doc') || ($exten=='.docx'))
							{

								$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='Document file thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg' alt='Doc File'></a>",$body);

							}
							
								else
							{

								$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit();' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/extlink.png' alt='External link'></a>",$body);
							}
						} 
						else
						{


							if($exten=='.pdf')
							{
							$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('http://www.servicetax.gov.in' , '' , $match[2]) );

								$body=str_replace($match[0],"<a  href='$match[2]' target='_blank'  title='PDF that opens in new window'>$match[3]&nbsp;<img src=' $HomeURL/images/pdf_icon.png' width='12' height='12' alt='PDF File' /></a>".'&nbsp;&nbsp;'  .'[<span class="file-size">'. Filebytes($file).'</span>]',$body);
							}

							if(($exten=='.doc') || ($exten=='docx'))
							{
								$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('http://www.servicetax.gov.in' , '' , $match[2]) );

								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='Document file that opens in new window'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg' alt='Doc File'></a>".'&nbsp;&nbsp;'  .'[<span class="file-size">'. Filebytes($file).'</span>]',$body);

							}

							if(($exten=='.ppt') || ($exten=='pptx'))
							{

								$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('http://www.servicetax.gov.in' , '' , $match[2]) );
								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='Document file that opens in new window'>$match[3]&nbsp;<img src='$HomeURL/images/ppt.jpeg' alt='Doc File'></a>".'&nbsp;&nbsp;'  .'[<span class="file-size">'. Filebytes($file).'</span>]',$body);

							}

							if(($exten=='.xls') || ($exten=='xlsx'))
							{

								$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('http://www.servicetax.gov.in' , '' , $match[2]) );
								$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='Document file that opens in new window'>$match[3]&nbsp;<img src='$HomeURL/images/excel.jpeg' alt='Excel File'></a>".'&nbsp;&nbsp;'  .'[<span class="file-size">'. Filebytes($file).'</span>]',$body);

							}




						}


						} // foreach
					}// main if
					
					
					
			echo $body;	
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
