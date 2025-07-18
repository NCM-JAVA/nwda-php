<?php
   ob_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   //include('../design.php');
   //include("../counter.php");
   
   
   $category_id = mysqli_real_escape_string($conn, $_REQUEST['catid'] );
   $category_id = content_desc($category_id);
   
   if(!is_numeric($category_id))
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
   		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
   		}
   		else {
   		 $sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='2' and approve_status='3'";
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
	/* 		 
   			 $rootid=get_root_parent($page_id);
   			 $parentid=parentid($page_id);
   			 $m_name=get_page($page_id); */
			 
			 
   			 $m_url=$row['m_url'];
   			 $sub_flag_id=$row['m_id'];
   			 $m_flag_id = $row['m_flag_id'];

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
   ?>
<?php
   $photo_query = "select category.c_name,category.c_id,photogallery.sortdesc,photogallery.img_uplode,photogallery.gallery_type from photogallery  join category on photogallery.category_id=category.c_id  where photogallery.category_id='".$category_id."' and photogallery.approve_status='3'  and photogallery.gallery_type='1' and category.c_name!='Home Page Banner' group by photogallery.category_id order by  category.c_id  desc";
   	$photo_result = mysqli_query($conn, $photo_query);
   	$res_rows = mysqli_num_rows($photo_result);
   

   	while ($fetch_result = mysqli_fetch_array($photo_result)) {
   	//@extract($fetch_result);
   	$newid = $fetch_result['c_id'];
   	$newimg_uplode = $fetch_result['img_uplode'];
   	$categoryname = $fetch_result['c_name'];
   	$_SESSION['category'] = $fetch_result['c_name'] ;
   	$categoryname1=htmlspecialchars($c_name);
   	$categoryid = $fetch_result['c_id'];
   	$eng_pagetitle = $fetch_result['eng_pagetitle'];
   	 $image_path = $HomeURL.'/upload/photogallery/media/'.$newimg_uplode;
   	}
	$keyword = explode(" ", $categoryname);
   	?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title><?php echo $categoryname;?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="title" content="View photo gallery">
		<meta name="description" content="Details of <?php echo $categoryname;?>">
		<meta name="keywords" content="<?php echo $keyword[0]?>, <?php echo $keyword[2]?>, NWDA Events, Seminars, Meetings, Field Survey, Locations">
		
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
	
	  
      <?php /* <link href="<?php echo $HomeURL;?>/css/lightbox.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo $HomeURL;?>/js/lightbox.js"></script> */ ?>
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
                        <li><a href="<?php echo $HomeURL?>/content/index.php">होम</a></li>
                        <li>चित्र प्रदर्शनी</li>
                        <li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button></li>
                     </ul>
                  </div>
                  <h2>चित्र प्रदर्शनी</h2>
                  <div class="photo-gallery">
                     <?php
                         $photo_query = "select category.c_name,category.c_namehi	,category.c_id,photogallery.sort_desc_hindi,photogallery.sortdesc,photogallery.img_uplode,photogallery.gallery_type from photogallery inner join category on category.c_id = photogallery.category_id where photogallery.category_id='".$category_id."' and photogallery.approve_status='3'  and photogallery.gallery_type='1' and category.c_name!='Home Page Banner' group by photogallery.category_id order by  category.c_id  desc";
                        	$photo_result = mysqli_query($conn, $photo_query);
                        	$res_rows = mysqli_num_rows($photo_result);
                        
                        	
                        	
                        	while ($fetch_result = mysqli_fetch_array($photo_result)) {
                        	//@extract($fetch_result);
                        	$newid = $fetch_result['c_id'];
                        	$newimg_uplode = $fetch_result['img_uplode'];
                        	$categoryname = $fetch_result['c_namehi'];
								$categoryname1=htmlspecialchars($c_namehi);
                        	$categoryname1=htmlspecialchars($c_name);
                        	$categoryid = $fetch_result['c_id'];
                        	$eng_pagetitle = $fetch_result['eng_pagetitle'];
                        	 $image_path = $HomeURL.'/upload/photogallery/media/'.$newimg_uplode;
                        
                        	?>
                     <!--<div class="clear">  </div>-->
                     <div class="form-field">
                        <h4 class="font120"><?php echo $categoryname;?></h4>
						
                        <!--<div class="back"><a href="#" onclick="javascript:history.go(-1)">Back</a></div>-->
                        <?php
                           $photo_query1 = "select category.c_name,category.c_namehi,photogallery.sort_desc_hindi,photogallery.sortdesc,photogallery.img_uplode from photogallery inner join category on category.c_id = photogallery.category_id where photogallery.approve_status='3' and photogallery.gallery_type='1' and category.c_name!='Home Page Banner' and photogallery.category_id ='$newid' order by  photogallery.id  ASC";
                           

                           $photo_result1 = mysqli_query($conn, $photo_query1);
                           $res_rows1 = mysqli_num_rows($photo_result1);
                           ?>
                        <?php
                           while ($fetch_result1 = mysqli_fetch_array($photo_result1)) {
                           //echo "ggg".$newcat=$categoryid;
                           $categoryname = $fetch_result1['categoryname'];
                           $categoryname1=htmlspecialchars($categoryname);
                           $photoimg=$fetch_result1['img_uplode'];
                            $image_pathnew = $HomeURL.'/upload/photogallery/media/'.$photoimg;
                           ?> 
                        <div class="frame1 galleryDiv">
                          	<a href="<?php echo $HomeURL . "/upload/photogallery/media/" . $fetch_result1['img_uplode'] ?>" 
								rel="lightbox[<?php echo $categoryid ?>]" title="<?php echo $fetch_result1['sort_desc_hindi']; ?>" alt="<?php echo $fetch_result1['sort_desc_hindi']; ?>">
								<img src="<?php echo $image_pathnew;?>" width="209" height="138" alt=""  border="0" title=""/></a>
                           <!-- set div -->	
                           <div class="form-field">
                              <p><?php  echo $fetch_result1['sort_desc_hindi'];  ?></p>
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
      </section>
      <footer>
         <?php include("footer.php");?>
      </footer>
      <a href="javascript:" id="return-to-top"><img src="../images/top-arrow.png" title="Go to Top" alt="Go to Top"></a>
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
      <script type="text/javascript">
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