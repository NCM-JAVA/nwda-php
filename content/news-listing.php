<?php  
ini_set('display_errors', 1);
error_reporting(E_ALL);

ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
// include('../../design.php');
 // include("../../counter.php");

if($_SERVER['REQUEST_URI'])
		{ 
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']);  
		$val=explode('/', $url);
		$url=$val['3'];
		$open=$val['2'];

		if($url !='')
		{
		
	  $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description,upload_img FROM menu_publish where language_id='1' and approve_status='3' and  m_url='$url' ";

		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description,upload_img FROM menu_publish where language_id='1' and approve_status='3'";
		}
	
						
						
				$result1 = $conn->query($sql);
			 $count=mysqli_num_rows($result1); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
						
			}
	



			$row=mysqli_fetch_array($result1);
			 $page_id=$row['page_id']; 
			$page_name=$row['m_name'];
			$page_title=$row['m_title'];
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

			if($upload_img=="")
				$upload_img = '594264cff26ffwater_banner.jpg';
			if($m_url=='pmksy-aibp.php')
				$upload_img="pmksy-aibp-123.jpg";
			$img="../../upload/breadcrum_image/".$upload_img;
	
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
			$method="mapping";
		 //  $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
		//	$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
		 $title=$row['m_name'];
		 $btitle=''.$btitle.' : NWDA';

		$body=stripslashes(html_entity_decode($row['content'])); 	
 
		 
		}
		$m_keyword=$row['m_keyword'];
		$m_description=$row['m_description'];
		
		if($url=='pisnwda.php'){
			$Uri = 'PIS'." :: ".$title;
		}else{
			$Uri = $title;
		}
?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>What's New </title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Give information on media News about ILR and water Resources.">
		<meta name="keywords" content="Flood, Water Rsources, ILR, Water Pollution">
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
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Contents of What's New</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
					</div>
						<h3>Contents of What's New</h3>
				
				
				
				<?php  
					$date=date('Y-m-d');
					//$sqlnews="select * from combine_publish where cat_id='1' and approve_status='3' and language_id='1' and start_date <= '$date' and start_date  BETWEEN DATE_SUB(NOW(), INTERVAL 365 DAY) AND NOW() order by start_date desc limit 0,7 ";
          $sqlnews="select * from combine_publish where cat_id='1' and approve_status='3' and language_id='1' and date(end_date) >= '$date' and start_date  BETWEEN DATE_SUB(NOW(), INTERVAL 60 DAY) AND NOW() order by start_date desc";
                    $resnews=mysqli_query($conn, $sqlnews) or die(mysqli_error());
					while($rownews=mysqli_fetch_array($resnews))
					{
				?>	
						<p class="list-group-item"><b><a href="news-details.php?nid=<?php  echo $rownews['m_id'];  ?>"><?php  echo $rownews['m_name'].". Published On: ".date('d-m-Y',strtotime($rownews['start_date'])); ?></a></b></p>
				<?php }  ?>		
					
				
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
