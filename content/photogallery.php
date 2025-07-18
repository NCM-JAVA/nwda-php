<?php
   ob_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   //include('../design.php');
   //include("../counter.php");
   
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Photo Gallery</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="title" content="Photo Gallery">
		<meta name="description" content="Glimpses of various activities held in HQ and Field Offices of different Events, Seminars, Meetings, Field Surveys.">
		<meta name="keywords" content="NWDA Events, Seminars, Meetings, Field Survey, Locations, Events">
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
                        <li><a href="<?php echo $HomeURL?>/content/index.php">Home</a>&nbsp;/</li>
                        <li>Photo Gallery</li>
                        <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
                     </ul>
                  </div>
                  <h2>Photo Gallery</h2>
                  <div class="photo-gallery">
                     <div class="form-field">
                        <?php
                           $cat_query = "select * from category where cat_id='1' and c_status=1 and c_name!='Home Page Banner' order by create_date  DESC";
                           $cat_result = $conn->query($cat_query);
                           $cat_rows = $cat_result->num_rows;
                           while ($fetch_result =$cat_result->fetch_array()) {
                           //	echo "<pre>"; print_r($fetch_result);
                           	$newid = $fetch_result['c_id'];
                           	$categoryname = $fetch_result['c_name'];
                           	$photo_query = "select * from photogallery where approve_status='3' and gallery_type='1' and category_id='$newid' order by id asc limit 0,1";
                           	$photo_result = $conn->query($photo_query);
                           	$photo_rows = $photo_result->num_rows;
                           	if( $photo_rows>0 )
                           	{
                           		
                           		$fetch_result1 = $photo_result->fetch_assoc();
                           		$image_pathnew = $HomeURL.'/upload/photogallery/media/'.$fetch_result1['img_uplode'];
                           		?>
                        <div class="photo_gallCategoryBox">
                           <div class="photo_gallCategory">
                              <a class="photogallery_a" href="<?php echo $HomeURL;?>/content/view_all_photogallery.php?catid=<?php echo  $newid;  ?>" title="<?php echo $fetch_result1['sortdesc']; ?>" >
                              <img src="<?php echo $image_pathnew;?>" alt="image<?php echo $newid;?>"  border="0" title="<?php  echo $fetch_result1['sortdesc'];  ?> "/></a>
                              <!-- set div -->	
                              <div class="gall-field">
                                 <p><?php  echo $categoryname;  ?></p>
                              </div>
                           </div>
                        </div>
                        <?php
                           }
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