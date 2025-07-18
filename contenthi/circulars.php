<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
/* include('../design.php');
include("../counter.php"); */

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
		
						
						
			$sql=mysqli_query($conn, $sql);
			 $count=mysqli_num_rows($sql); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/contenthi/error.php");
						exit(); 
				}
				
				
				
				

			$row=mysqli_fetch_array($sql);
			$page_id=$row['page_id'];
			 $page_name=$row['m_name'];
			 $position=$row['menu_positions'];
		/* 	 $rootid=get_root_parent($page_id);
			 $parentid=parentid($page_id);
			 $m_name=get_page($page_id); */
			 $m_url=$row['m_url'];
			 $sub_flag_id=$row['m_id'];
			 $m_flag_id = $row['m_flag_id'];
			 if($row['upload_img']!="")
				 $img="../../upload/breadcrum_image/".$row['upload_img'];
			 else
				 $img="../../upload/breadcrum_image/594264cff26ffwater_banner.jpg";
			 
	
		
			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		/*    $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
			$btitle=pagebreadcrumb1($page_id,0,$method,1,$page); */
			}		
		 $title=$row['m_name'];
		 $btitle=''.$btitle.' : National Water Development Agency';
		 $body=stripslashes(html_entity_decode($row['content'])); 	
		
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
?>
<!DOCTYPE html>

<html lang="hi">
	<head>
		<title>परिपत्र: राष्ट्रीय जल विकास एजेंसी</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="एनडब्ल्यूडीए अधिकारियों के स्थानांतरण, पदोन्नति और सेवानिवृत्ति पर सूचना।">
		<meta name="keywords" content="आधिकारिक परिपत्र, स्थानांतरण, पदोन्नति, सेवानिवृत्ति, अतिरिक्त शुल्क">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
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
							<li><a href="<?php echo $HomeURL?>/contenthi/index.php">मुख्य पृष्ठ</a></li>
							<li>परिपत्र</li>
							<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
                        			<div class="bannerBox">
			                        	<img src="<?php echo $img;?>" alt="" title="" >
                        				<h2>परिपत्र</h2>
			                        </div>
					</div>
					
						
						<div class="demo5 demof">
										<ul class="list-group">
											<table class="table table-bordered" title="tender">
					<thead>
						<tr>
							<th>क्र.</th>
							<th>परिपत्र शीर्षक</th>
							<th>प्रकाशित तिथि</th>
							<th>डाउनलोड देखें</th>
						</tr>
					</thead>
					<tbody>	
						<?php   $date=date('Y-m-d'); 
						//$sqlnews="select * from combine_publish where cat_id='2' and approve_status='3' and language_id='2' and date(end_date ) >= '$date' order by m_id asc ";
             $sqlnews="select * from combine_publish where cat_id='2' and language_id='2' and approve_status='3' and end_date >= CURDATE() - INTERVAL 6 MONTH order by end_date DESC;";
                    $resnews=mysqli_query($conn, $sqlnews) or die(mysqli_error());
					$m=1;
					if(mysqli_num_rows($resnews)>0)
					 {
					while($rownews=mysqli_fetch_array($resnews))
					{
		
		      $fname=$rownews['docs_file'];
					  if($fname!='')
					 {
					  $filen="<a href='../upload/$fname' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'>" . Filebytes('../upload/'.$fname)."</a>";
					 }
					 else
					 {
					  $filen="No file available for preview";
					 }
					 				
					
		if($rownews['content_type']=='1'){ $pageurlh1='<a javascript:void(0); href="circular_details.php?nid='.content_desc(($rownews['m_id'])).'">'.$rownews['m_name'].'</a>';  }
		if($rownews['content_type']=='2'){ $pageurlh1='<a title="'.$rownews['m_name'].'" target="_blank" href="../upload/'.$rownews['docs_file'].'">'.$rownews['m_name'].'</a>'; }
		if($rownews['content_type']=='3'){  $pageurlh1='<a title="'.$rownews['m_name'].'" target="_blank" href="'.$rownews['ext_url'].'">'.$rownews['m_name'].'</a>'; }
                 		
				?>	
				<?php /*<p><?php  //echo substr($rownews['m_name'],0,100); ?><?php echo $pageurlh1;?></p>*/?>
				
                 </ul>
                 
               
                 </div>	

					<tr>
					    <td><?php  echo $m; ?></td>
						<td><?php  echo $rownews['m_name']; ?></td>
						<td class="whitespace_nowrape"><?php  echo date('d-m-Y', strtotime($rownews['end_date'])); ?></td>
						<td><?php  echo $filen;  ?></td>
					</tr>
<?php  $m++; }  
				}
				else{?>	
					<tr>
					    <td colspan='5' style="text-align:center;color:white;">कोई रिकॉर्ड नहीं मिला।.</td>
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
