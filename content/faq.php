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
   		
   		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
   		 $val=explode('/', $url);
   		 $url=$val['4'];
   		$open=$val['3'];
   		
   		if($url !='')
   		{
   		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
   		}
   		else {
   		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3'";
   		}
   		
   						
   						
   			$sql=$conn->query($sql);
   			 $count=$sql->num_rows; 
   			 if($count=='0')
   				{
                   header("Location:".$HomeURL."/contenthi/error.php");
   						exit(); 
   				}
   		
   
   			$row=$sql->fetch_array();
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
   			 if($row['upload_img']!=""){
   				 $img="$HomeURL/upload/breadcrum_image/".$row['upload_img'];
   			 }else{
   				 $img="$HomeURL/upload/breadcrum_image/594264cff26ffwater_banner.jpg";
   
   			 }
   
   			$page='content';
   			if($page_id!='0' && $page_id!='')
   			{
   				$method="mapping";
   				/* $pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
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

<html lang="en">
	<head>
		<title>FAQ: National Water Development Agency</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="title" content="FAQ">
		<meta name="description" content="Details of Frequently asked questions on ILR and studies of NWDA">
		<meta name="keywords" content="FAQ, ILR, NWDA Studies">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
        <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script>
        <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script>  
	<script >
    
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
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
	
	</head>
	
	<body id="fontSize">
			<header>
			<?php include("top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="<?php echo $HomeURL?>/images/toogle.png" alt="toggle" title="toggle">
				</div>
		<nav>
		<div class="">
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
							<li></li>
							<li>Faq's</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
					</div>
					
						<h2>Faq's</h2>
<div class="col-sm-12 inner-container" id="abc">
			
					<ul class="faq">
			<?php  $sqlfaq="select * from faq where approve_status='3' order by f_id desc";
                   $resfaq=mysqli_query($conn, $sqlfaq) or die(mysql_error());
				   while($rowfaq=mysqli_fetch_array($resfaq))
				   {
				?>	
				<li>
				<b><?php  echo $rowfaq['title']; ?></b>
						<?php  echo stripslashes(html_entity_decode($rowfaq['description']));  ?>
					
			<?php  }  ?>
				</li>			
					</ul>
				
			
				</div>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	<a href="javascript:" id="return-to-top"><img src="../images/top-arrow.png" title="Go to Top" alt="Go to Top"></a>
    <script >
    // ===== Scroll to Top ==== 
    $(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
    $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
    scrollTop : 0                       // Scroll to top of body
    }, 500);
    });
    </script>
	
	</body>
	
</html>