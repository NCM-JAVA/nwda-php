<?php
   ob_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   // include('../design.php');
   // include("../counter.php");
   
	if($_SERVER['REQUEST_URI']){
		$url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
		$val=explode('/', $url);
		$url=$val['4'];
		$open=$val['3'];
   		
		if($url !=''){
			$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3' and m_url='$url' ";
		}
		else {
			$sql="SELECT m_publish_id as page_id, m_flag_id as m_flag_id , m_name, content as content, m_url ,m_title,menu_positions,m_keyword,m_description FROM menu_publish where language_id='1' and approve_status='3'";
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

   		$page='content';
   		if($page_id!='0' && $page_id!='')
   		{
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
      <title>Circulars Archives: National Water Development Agency</title>
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
                        <li>Archices</li>
                        <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onclick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
                     </ul>
                  </div>
                  <h2>Archives</h2>
                  <div class="archive-grid">
                     <form  action="circulars_archives.php" name="searchform" method="post">
                        <div class="acchive-div">
							<div class="archive-div">
								<label for="texcat" style="position: absolute;">Circulars Title</label>
								<input type="text" name="job_title" style="width: 200px; margin-left: 120px;" value="<?php echo content_desc($_POST['job_title']);?>"/>
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
					 <table class="table table-bordered table-responsive" >
							<thead style="background-color: #00348b; color: #fff;">
								<th>Sr.No</th>
								<th>Circualrs Title</th>
								<th>Published Date</th>
								<th>View / document</th>
							</thead>	
							<tbody>	
                        <?php 	
                           if(isset($cmdsubmit)) {
                           $txtname= content_desc($_POST['job_title']);
                           $sta=explode('-',$startdate);
                           $startdate1=$sta['2']."-".$sta['1']."-".$sta['0'];
                           $startdate1=content_desc($startdate1);
                           $exp=explode('-',$expairydate);
                           $expairydate1=$exp['2']."-".$exp['1']."-".$exp['0'];
                           $expairydate1=content_desc($expairydate1);
                           
							/* if(trim($txtname)==""){
                                $errmsg .="Please Enter Title."."<br>";
                            } */
                           
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
								$startdate1=content_desc($startdate1); 
								$expairydate1=date('Y-m-d',strtotime($expairydate));
								$expairydate1=content_desc($expairydate1);
								$querywhere=" and end_date >= '$startdate1' and end_date <= '$expairydate1' "; 
                            }
							if($txtname!=""){
								$querywh=" and `m_name` LIKE '%$txtname%'"; 
                            }
                           
							
							if($errmsg == ''){
								$date=date('Y-m-d');
                                $query="SELECT * from combine_publish where cat_id='2' and `approve_status`=3 and date(end_date ) < '$date' and `language_id`=1 $querywhere"."$querywh";
                           		
                                $res=$conn->query($query);
                           
                           		if($res->num_rows >0){
                                   while($row=$res->fetch_array()) 
                                   {
										if($class=="odd")
										{
											$class="even";
										}
										else
										{
											$class="odd";
										} 
										@extract($row);	
										
										$doc_file = $row['docs_file'];
						
									  
										if($doc_file!=''){
											$filen="<a href='../upload/$doc_file' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'>" . Filebytes('../upload/'.$doc_file)."</a>";
										}
										else{
											$filen="No file available for preview";
										}
										
									
									
                           			?>
									<tr class="<?=$class;?>">
										<td><?=$key?></td>
										<td><?=$m_name; ?></td>
										<td><?=$end_date?></td>
										<td><?php  echo $filen;  ?></td>
									</tr>
									<?php
								
								}
							}else{?>
									<tr>
										<td colspan="8" style="text-align:center; color:#fff;"> No Record Found</td>
									</tr>
							<?php }?>
							<?php }
                           else{
								echo $errmsg;
                           }
                           
                           } 
                           else
                           {    
				
								$date=date('Y-m-d'); 
								$query="SELECT * from combine_publish where cat_id='2' and `approve_status`=3 and date(end_date) < '$date' and `language_id`=1 $querywhere   ";
								$res=$conn->query($query);
								$key=1;
								if($res->num_rows >0){
								while($row=$res->fetch_array()) 
								{
					
									if($class=="odd")
									{
										$class="even";
									}
									else
									{
										$class="odd";
									} 
									@extract($row);	
									
									$doc_file = $row['docs_file'];
								 
									if($doc_file!=''){
										$filen="<a href='../upload/$doc_file' target='_blank'><img src='../images/pdf_icon.png' alt='pdf image' title='pdf image'>" . Filebytes('../upload/'.$doc_file)."</a>";
									}
									else{
										$filen="No file available for preview";
									}
									
									
                        ?>
									<tr class="<?=$class;?>">
										<td><?=$key?></td>
										<td><?=$m_name; ?></td>
										<td><?=$end_date?></td>
										<td><?php  echo $filen;  ?></td>
									</tr>
                       
                     <?php $key++; }}else{?>
									<tr>
										<td colspan="8" style="text-align:center; color:#fff;"> No Record Found</td>
									</tr>
							<?php } } ?>
					 	</tbody>
					   </table>
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