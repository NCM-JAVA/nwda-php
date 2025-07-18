<?php ob_start();
session_start(); 
require_once "../../includes/connection.php";
require_once("../../includes/config.inc.php");
require_once "../../includes/functions.inc.php";
include("../../counter.php");
include("../../design.php");



if($_SERVER['REQUEST_URI'])
		{
			 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
			 $val=explode('/', $url);
			 $url=$val['3'];
			 $open=$val['2'];
		
		if($url !='')
		{
			$sql="SELECT m_publish_id as page_id, m_name, content as content, m_url ,m_title,menu_positions,module_id FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
		}
		else 
		{
			$sql="SELECT m_publish_id as page_id, m_name, content as content, m_url ,m_title,menu_positions,module_id FROM menu_publish where language_id='2' and approve_status='3'";
		}
			$sql=mysql_query($sql);
			$count=mysql_num_rows($sql); 
			if($count=='0')
			{
				  header("Location:".$HomeURL."/content/error.php");
				  exit(); 
			}
			$rownew=mysql_fetch_array($sql);
			$page_id=$rownew['page_id'];
			$page_name=$rownew['m_url'];
			$title= $rownew['m_name'];
			$position=$rownew['menu_positions'];
			$rootid=get_root_parent($page_id);
			$pagename=get_root_page($page_name);
			$rootid2=get_root_sparent($page_id);
			$subrootpage=root_mainpage($page_id);
			$m_name=get_page($page_id);
			$m_url=$rownew['m_url'];
		
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
			if($m_url=='archive.php')
			{
				header("Location:".$HomeURL."/content/archive.php");
				exit();
			}
			if($m_url=='photo-gallery.php')
			{
				header("Location:".$HomeURL."/content/photogallery.php");
				exit();
			}
			if($m_url=='organization-setup.php')
			{
				header("Location:".$HomeURL."/content/organization.php");
				exit();
			}

				if($m_url=='contact-us.php')
			{
				header("Location:".$HomeURL."/content/contact-us.php");
				exit();
			}
                        if($m_url=='annual-reports.php')
			{
				header("Location:".$HomeURL."/content/annualreport.php");
				exit();
			}

                        if($m_url=='tender--advertisement.php')
			{
				header("Location:".$HomeURL."/content/tender.php");
				exit();
			}
		if($m_url=='organisation-chart.php')
			{
				header("Location:".$HomeURL."/content/organization.php");
				exit();
			}

			
			$page='content';
			if($page_id!='0' && $page_id!='')
			{
				$method="mapping";
				$pgprntnams=pagebreadcrumb($page_id,0,$method,1,$page);
				$btitle=pagebreadcrumb1($page_id,0,$method,1,$page);
			}		
			 $title=$rownew['m_name'];
			 $btitle=''.$btitle.':DEPwD';
			 $body=stripslashes(html_entity_decode($rownew['content'])); 											 
		}
		
		$m_keyword=$rownew['m_keyword'];
		$m_description=$rownew['m_description'];
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta name="author" content="">
<link rel="apple-touch-icon" href="<?php echo $HomeURL;?>/assets/images/favicon/apple-touch-icon.png">
<link rel="icon" href=<?php echo $HomeURL;?>/"assets/images/favicon/favicon.png">
<title>Department of Empowerment of Persons with Disabilities</title>

<!-- Custom styles for this template -->
<link href="<?php echo $HomeURL;?>/assets/css/base.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/base-responsive.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/grid.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font-awesome.min.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/flexslider.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/print.css" rel="stylesheet" media="print" />

<!-- Theme styles for this template -->
<link href="<?php echo $HomeURL;?>/theme/css/site.css" rel="stylesheet" media="all">
	<link href="<?php echo $HomeURL;?>/theme/css/site-responsive.css" rel="stylesheet" media="all">

<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
<!-- Custom JS for this template -->

<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/framework.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/font-size.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/swithcer.js"></script>


</head>
<body>

<div class="wrapper common-wrapper">
	<?php include("../top_bar.php");?>
</div>
<!-- top bar end-->

<section class="wrapper header-wrapper">
	<?php include("../header.php");?>
</section>
<!-- Header end-->

<nav class="wrapper nav-wrapper">
	<?php include("../top_navigation.php");?>
</nav>
<!-- Nav end-->
<div class="wrapper" id="skipCont"></div> <!--/#skipCont-->

<section id="fontSize" class="wrapper body-wrapper">
<?php include("../second_levelmenu.php"); ?>

     <!--breadcrumb start-->
    <div id="breadcrumb">
      <div class="container"> 
       <div class="easy-breadcrumb">
        <ul>
  <li class="first"><?php echo "<a href=".$HomeURL."/content/>Home</a>"?></li>
			<span> &nbsp;>></span>  <?php if($pgprntnams !="") echo $pgprntnams; ?>
</ul>
       </div>
       <div class="block-webspeech">      
          <button onclick="sideSpr(this);" id="sideSprButton">Read Content</button>
          <button onclick="sideStop()" id="sideStopButton">Stop</button>
       </div>   
      </div>  
    </div>
    <!--breadcrumb end-->
  <div class="inner-bg-wrapper">  
   <div class="container">     
    <div class="inner_left_container">
      <div class="inner_left_childmenu">
         
         <?php include("../inner_left_menu.php");?>
      </div>
      <div class="inner_left_fixmenu">
        <?php include("../inner_fixed_menu.php");?>
     </div>
  </div>
    <!--inner_left_container end-->
    
    <div class="inner_right_container">
      <h1 class="page__title">  <?php echo $title; //echo $m_name;?>  </h1>
      <a href="#" class="page_print_icon"></a>
      <h2><?php //echo $title;?></h2>
      <p>
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
			
			$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('' , '' , $match[2]) );

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeCss/images/pdf_icon.png'></a>".'&nbsp;&nbsp;'  . Filebytes($file),$body);
		}

		if(($exten=='.ppt') ||  ($exten=='.pptx'))
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/ppt.gif' alt='PPT Image'></a>",$body);
		}

		if(($exten=='.doc') || ($exten=='docx'))
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg' alt='Word Doc Image'></a>",$body);

		}

		if(($exten=='.xls') || ($exten=='xlsx'))
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/excel_icon.JPEG' alt='Excel Image'></a>",$body);

		}
		else
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit();' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/external_link_icon.png' alt='External Link Image'></a>",$body);
		}

	} 
	else
	{


		if($exten=='.pdf')
		{
			

			$file = $_SERVER['DOCUMENT_ROOT'].str_replace(  '%20',' ' , str_replace('' , '' , $match[2]) );

		$body=str_replace($match[0],"<a  href='$match[2]' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src=' $HomeURL/images/pdf_icon.png' width='12' height='16' alt='PDF Image'/></a>".'&nbsp;&nbsp;'  . Filebytes($file),$body);
		}

		if($exten=='.ppt' || $exten=='.pptx')
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/ppt.gif' alt='PPT Image'></a>",$body);
		}

		if(($exten=='.doc') || ($exten=='docx'))
		{
			

		$body=str_replace($match[0],"<a  href='$match[2]'  target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/word.jpeg' alt='Word Doc Image'></a>",$body);

		}

		if(($exten=='.xls') || ($exten=='xlsx'))
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit()' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/excel_icon.jpg' alt='Excel Image'></a>",$body);

		}
		else
		{

		$body=str_replace($match[0],"<a  href='$match[2]'  onclick='return sitevisit();' target='_blank'  title='External Link thats open in new window'>$match[3]&nbsp;<img src='$HomeURL/images/external_link_icon.png' alt='External Link Image'></a>",$body);
		}




	}


	} // foreach
}// main if
 
 echo $body; 

$sql1 = mysql_query("select * from menu_publish where m_flag_id='".$rownew['page_id']."'   and language_id='2' and	approve_status='3'  ORDER BY page_postion ASC ");
?>
<ul>
<?php 
		while ($row = mysql_fetch_array($sql1)) 
		{ 
		if($row['doc_uplode']!='')
		{
		$content='../../upload/'.$row['doc_uplode'];
		}
		else 
		{
		$content=$row['m_url'];
		}
		?>

				<?php if($row['linkstatus']!='')  { ?>
					 <li><a href="<?php  echo $row['linkstatus']?>" ><?php echo $row['m_name'];?></a></li>
					<?php  } elseif($i=='1') {?>
					 <li  class="first"><a title="<?php echo $row['m_name'];?>" href="<?php echo $content; ?>"><?php echo $row['m_name'];?></a></li>
					<?php }
					elseif($i==$count)
					 { ?>
						<li class="last"><a title="<?php echo $row['m_name'];?>" href="<?php echo $content;?>"><?php echo $row['m_name'];?></a></li>
					<?php }
					else { ?>
					
					<li><a title="<?php echo $row['m_name'];?>"  href="<?php echo $content; ?>"><?php echo $row['m_name'];?></a></li>
					<?php }?>
					
		<?php $i++; }	?>
		</ul>
		
	  
	  </p>
    </div>
    <!--inner_right_container end-->
   </div>
 </div>
</section>

<!--carousel-wrapper-Start-->
<section class="wrapper carousel-wrapper">
	<?php  //include("../footer_gov_link.php");?>
</section>
<!--carousel-wrapper-end-->

<!--footer-start-->
<footer class="wrapper footer-wrapper">
	<?php include("../footer.php");?>
</footer>
<!--footer-end-->



<script type="text/javascript">
$(document).ready(function(e) {

        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

 });


$(window).load(function(){
// Slider						
 $('#flexSlider').flexslider({
        animation: "slide",
		controlNav: false,
        start: function(slider){
        $('body').removeClass('loading');
        }
 });
 
// Carousel						
 $('#flexCarousel').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 200,
        itemMargin: 5,
        minItems: 2,
        maxItems: 6,
		slideshow: 1,
		move: 1,
		controlNav: false,
        start: function(slider){
          $('body').removeClass('loading');
		  if (slider.pagingCount === 1) slider.addClass('flex-centered');
        }
      });
	  
// Carousel						
 $('#flexCarousel2').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 130,
        itemMargin: 5,
        minItems: 2,
        maxItems: 6,
		slideshow: 1,
		move: 1,
		controlNav: false,
        start: function(slider){
          $('body').removeClass('loading');
		  if (slider.pagingCount === 1) slider.addClass('flex-centered');
        }
      });	  
 
 // Gallery
      $('#galleryCarousel').flexslider({
        animation: "fade",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
  });
</script>
</body>
</html>