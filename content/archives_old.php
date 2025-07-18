<?php
   ob_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   include('../design.php');
   include("../counter.php");
   
	if($_SERVER['REQUEST_URI']){
		$url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
		$val=explode('/', $url);
		$url=$val['4'];
		$open=$val['3'];
   		
		if($url !=''){
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
      <title>Archives: National Water Development Agency</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="title" content="Archive">
      <meta name="description" content="Archive for tenders, what's new, circulars and this can be hold previous data">
      <meta name="keywords" content="Archive, Repository, Records">
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
      <script src="<?php echo $HomeURL?>/js/jsDatePick.js"></script>
      <link href="<?php echo $HomeURL?>/css/jsDatePick.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script>  
      <script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
      <script src="<?php echo $HomeURL?>/js/modern-ticker.js" > </script>
      <script src="<?php echo $HomeURL;?>/js/jquery-ui.js"></script>
      <script>
         window.onload = function(){
         	new JsDatePick({
         		useMode:2,
         		target:"startdate",
         		dateFormat:"%d-%m-%Y",
                 limitToToday :true
         	});
         	new JsDatePick({
         		useMode:2,
         		target:"expairydate",
         		dateFormat:"%d-%m-%Y",
                 limitToToday :true
         	});
         };
      </script>
      <script src="<?php echo $HomeURL?>/js/superfish.js"></script> 
      <script>
         (function($){ //create closure so we can safely use $ as alias for jQuery
         
         $(document).ready(function(){
         
         // initialise plugin
         var example = $('#example').superfish({
         //add options here if required
         });
         
         // buttons to demonstrate Superfish's public methods
         $('.destroy').on('click', function(){
         example.superfish('destroy');
         });
         
         $('.init').on('click', function(){
         example.superfish();
         });
         
         $('.open').on('click', function(){
         example.children('li:first').superfish('show');
         });
         
         $('.close').on('click', function(){
         example.children('li:first').superfish('hide');
         });
         });
         
         })(jQuery);
      </script>
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
                        <li>Archives</li>
                        <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onclick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
                     </ul>
                  </div>
                  <h2>Archives</h2>
                  <div class="archive-grid">
                     <form  action="#" name="searchform" method="post">
                        <div class="acchive-div">
							<div class="archive-div">
								<label for="texcat"><strong>Category:</strong></label>
								<select class="form-control" name="txtcategory" id="texcat" autocomplete="off"  >
									<option value="">Select</option>
									<option value="1" <?php echo '1'==$txtcategory?'selected="selected"':''; ?>>What's news</option>
									<?php  foreach($cat_type as $key=>$value){ ?>
									<option value="<?php echo $key; ?>" <?php if($key==$rr['whatsNew_cat'] || $key==$txtcategory){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
									<?php } ?>
									<option value="4" <?php echo '4'==$txtcategory?'selected="selected"':''; ?>>Tenders</option>
								</select>
							</div>
							<div class="archive-div">
                             <label for="texcat" style="position: absolute;">From Date:</label>
                              <input type="text" name="startdate" readonly="readonly"  id="startdate" style="width: 200px; margin-left: 100px;" value="<?php echo content_desc($_POST['startdate']);?>"/>
                              <input type="hidden" id="strtdate" />
							</div>
							<div class="acchive-div">
                             <label for="texcat" style="position: absolute;">Last Date:</label>
                              <input type="text" name="expairydate" readonly  id="expairydate" style="width: 200px; margin-left: 100px;" value="<?php echo content_desc($_POST['expairydate']);?>"/>
                              <input type="hidden" id="edate" />
							</div>
							<div class="archive-div">
                              <input type="submit"  name="cmdsubmit"  id="cmdsubmit" value="Go" class="go" >
							</div>
                        </div>
                     </form>
                  </div>
                  <div class="clear"></div>
                  <div class="col-sm-12">
                     <div class="row">
                        <?php 
                           if(isset($cmdsubmit)) {
                           $cat_id= content_desc(check_input($_POST['txtcategory']));
                           $sta=split('-',$startdate);
                           $startdate1=$sta['2']."-".$sta['1']."-".$sta['0'];
                           $startdate1=content_desc(check_input($startdate1));
                           $exp=split('-',$expairydate);
                           $expairydate1=$exp['2']."-".$exp['1']."-".$exp['0'];
                           $expairydate1=content_desc(check_input($expairydate1));
                           
							if(trim($cat_id)==""){
                                $errmsg .="Please Select Category Type."."<br>";
                            }
                           
							if($startdate !='' && $expairydate !=""){
                               if($exp['2'] < $sta['2']){
									$errmsg =" From Date should be lesser than To Date."."<br>";
                               } 
                               else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) {
									$errmsg .=" From Date should be lesser than To Date."."<br>";
                               } 
                               else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) {
									$errmsg .="Please enter From Date less then To Date."."<br>";
                               }
                               
								$startdate1=date('Y-m-d',strtotime($startdate));
								$startdate1=content_desc(check_input($startdate1)); 
								$expairydate1=date('Y-m-d',strtotime($expairydate));
								$expairydate1=content_desc(check_input($expairydate1));
								$querywhere =" and end_date > '$startdate1' and end_date <= '$expairydate1' "; 
                            }
							
							if($errmsg == ''){
								$date=date('Y-m-d');
                           		if($txtcategory=='4'){
                                    $query="SELECT * from tender_publish where `approve_status`=3 and   date(end_date ) < '$date' and `language_id`=1 $querywhere ";
                           		}
                           		else{
                                    $query="SELECT * from combine_publish where `cat_id`='$cat_id' and `approve_status`=3 and date(end_date ) < '$date' and `language_id`=1 $querywhere   ";
                           		}
								
                                $res=mysql_query($query) or die(mysql_error());
                           
                           		
                                   while($row=mysql_fetch_array($res)) 
                                   {
                           			//echo "<script>console.log('Debug:".$row['cat_id']."')</script>";
                           			if($row['cat_id'] == 1)
                           			{
                           				echo "<script>console.log('Debug:".$row['cat_id']." if')</script>";
                           			?>
										<div class="list-group-item">
										   <a href="news-details.php?nid=<?php  echo $row['m_id'];  ?>"><?php  echo $row['m_name'].". Published On: ".date('d-m-Y',strtotime($row['start_date'])); ?></a>
										</div>
									<?php
									}
									else{
										if($row['content_type']==2){
											$date = strtotime($row['create_date']);
											$s="/upload";   
											$source=$HomeURL.$s."/".$row['docs_file'];
									?>
											<div class="list-group-item"><a href="<?php echo $source ;?>" target="_blank"><?php echo $row['m_name'] ;?><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" width="12" height="16" alt="<?php echo $row['m_name'];?>" /></a></div>
									<?php
										}
										else if($row['content_type']==0){
											$date = strtotime($row['create_date']);
											$s="/upload";   
											$source=$HomeURL.$s."/".$row['docs_file'];
									?>
											<div class="list-group-item"><a href="<?php echo $source ;?>" target="_blank"><?php echo $row['m_name'] ;?><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" width="12" height="16" alt="<?php echo $row['m_name'];?>" /></a></div>
									<?php
										}
										else if($row['content_type']==3){
                           
									?>
											<div class="list-group-item"><a href="<?php echo $row['ext_url'] ;?>" target="_blank" title="<?php echo $row['ext_url'].','.$row['m_name']  ;?>: External website that opens in a new window" onClick="return sitevisit();"><?php echo $row['m_name'] ;?></a></div>
									<?php
										}else{
									?>
											<div class="list-group-item"><span><img src="../images/thamb-img.jpg" width="51" height="44" alt=""></span><a href="news-details.php?nid=<?php echo $row['m_id'] ;?>"><?php echo $row['m_name'] ;?></a></div>
									<?php
									   }
									}
								}
							}
                           else{
								echo $errmsg;
                           }
                           
                           } 
                           else
                           {    
                              $date=date('Y-m-d'); 
                               $query="SELECT * from combine_publish where `cat_id`=1 and `approve_status`=3 and date(end_date) < '$date' and `language_id`=1 $querywhere   ";
                               $res=mysql_query($query) or die(mysql_error());
                              while($row=mysql_fetch_array($res)) 
                              {
                                  if($row['content_type']==2)
                                           {
                           
                                                          $date = strtotime($row['create_date']);
                                        $s="/upload";   
                                        $source=$HomeURL.$s."/".$row['docs_file'];
                                        ?>
                        <div class="list-group-item"><a href="<?php echo $source ;?>" target="_blank"><?php echo $row['m_name'] ;?><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" width="12" height="16" alt="<?php echo $row['m_name'];?>" /></a></div>
                        <?php
                           }
                           else if($row['content_type']==3)
                           {
                           
                           ?>
                        <div class="list-group-item"><a href="<?php echo $row['ext_url'] ;?>" target="_blank" title="<?php echo $row['ext_url'].','.$row['m_name']  ;?>: External website that opens in a new window" onClick="return sitevisit();"><?php echo $row['m_name'] ;?></a></div>
                        <?php
                           }
                           
                           else
                           {
                           ?>
                     <div class="list-group-item">
                        <a href="news-details.php?nid=<?php  echo $row['m_id'];  ?>" target="_blank"><?php  echo $row['m_name'].". Published On: ".date('d-m-Y',strtotime($row['start_date'])); ?></a>
                     </div>
                     <?php } } } ?>
                  </div>
               </div>
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
      <a href="javascript:" id="return-to-top"><img src="../images/top-arrow.png" title="Go to Top" alt="Go to Top"></a>
      <script>
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