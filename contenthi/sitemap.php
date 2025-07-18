<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
// include('../design.php');
// include("../counter.php");

		if($_SERVER['REQUEST_URI'])
		{
		
			$url = mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
			$val=explode('/', $url);
			$url=$val['4'];
			$open=$val['3'];
		
			if($url !='')
			{
				$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
			}else {
				$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3'";
			}
		
			$sql=mysqli_query($conn, $sql);
			$count=mysqli_num_rows($sql); 
			if($count=='0'){
				header("Location:".$HomeURL."/contenthi/error.php");
				exit(); 
			}
				
			$row = mysqli_fetch_array($sql);
			$page_id = $row['page_id'];
			$page_name = $row['m_name'];
			$position = $row['menu_positions'];
			//$rootid = get_root_parent($page_id);
				//$rootid=get_root_parent($page_id);
			$rootid=$page_id;
			//$parentid=parentid($page_id);
			$parentid=$page_id;
			//$m_name=get_page($page_id);
			$m_name=$page_name;
			$sub_flag_id = $row['m_id'];
			$m_flag_id = $row['m_flag_id'];
			if($row['upload_img']!="")
			$img = "../../upload/breadcrum_image/".$row['upload_img'];
			else
			$img = "../../upload/breadcrum_image/594264cff26ffwater_banner.jpg";
		 
			$page='contenthi';
			if($page_id!='0' && $page_id!=''){
				$method="mapping";
				//$pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
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
						<li><a href="<?php echo $HomeURL?>/contenthi/index.php" title="मुख्य पृष्ठ">मुख्य पृष्ठ</a></li>
							<li>साइटमैप</li>
							<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
                        			<div class="bannerBox">
			                        	<img src="<?php echo $img;?>" alt="" title="" >
                        				<h2>साइटमैप</h2>
			                        </div>
					</div>
					
						
						<ul style="font-size: 15px;">
					<li><a href="<?php echo $HomeURL?>/contenthi/index.php" title="मुख्य पृष्ठ">मुख्य पृष्ठ</a></li>
					<?php
			    $sqlquery="select * from menu_publish where m_flag_id='0' and (menu_positions='1' OR menu_positions='2' OR menu_positions='3')  and language_id='2' and approve_status='3'  ORDER BY page_postion ASC";
				$sql = mysqli_query($conn, $sqlquery); 
			$count=mysqli_num_rows($sql);
				$i = 1;
				while ($row = mysqli_fetch_array($sql)) {
				$sqlquery11="select * from menu_publish where m_flag_id='".$row['m_publish_id']."' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
				$sql1 = mysqli_query($conn, $sqlquery11);
				 $row2 = mysqli_num_rows($sql1);
				$m_id=$row['m_id'];
				?>
					<li ><a title="<?php echo $row['m_nfame'];?>" href="<?php echo $HomeURL;?>/contenthi/innerpage/<?php echo $row['m_url']; ?>"><?php echo  $row['m_name'];?></a>
                     <?php if($row2>0 ) {  ?>
					<ul>
					 <?php while ($rows = mysqli_fetch_array($sql1)) { 
                $sqlquery22="select * from menu_publish where m_flag_id='".$rows['m_publish_id']."' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
				$sql2 = mysqli_query($conn, $sqlquery22);
			    $row3 = mysqli_num_rows($sql2);
				$m_id=$row2['m_id']; 
                    
					 ?>
						<li class="<?php if($row3>0) { ?>has-sub<?php  } ?>"><a title="<?php echo $rows['m_name'];?>" href="<?php echo $HomeURL;?>/contenthi/innerpage/<?php echo $rows['m_url']; ?>"><?php echo  $rows['m_name'];?></a>
						<?php if($row3>0 ) {  ?>
						<ul>
						<?php while ($rowssub = mysqli_fetch_array($sql2)) {  ?>
								<li><a title="<?php echo $rowssub['m_name'];?>" href="<?php echo $HomeURL;?>/contenthi/innerpage/<?php echo $rowssub['m_url']; ?>"><?php echo  $rowssub['m_name'];?></a></li>
						<?php }  ?>		
						</ul>
                        <?php  }  ?>							
						</li>
					<?php  } ?>	
				    </ul>
					<?php  }  ?>
					</li>
					
			<?php $i++;} ?>
				</ul>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
	
	</body>
	
</html>
