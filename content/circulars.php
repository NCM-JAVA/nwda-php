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
<html lang="hi">
   <head>
      <title>Official Circulars: NWDA</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="Information on Transfer, Promotion and retirements of NWDA Officials.">
      <meta name="keywords" content="Official Circular, Transfer, Promotion, Retirements, Additional Charge">
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
                        <li><a href="<?php echo $HomeURL?>/contenthi/index.php">Home</a></li>
                        <li>Official Circular</li>
                        <li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
                     </ul>
                     <div class="bannerBox">
                        <img src="<?php echo $img;?>" alt="" title="" >
                        <h2>Official Circular</h2>
                     </div>
                  </div>
                        <table class="table table-bordered" title="tender">
                           <thead>
                              <tr>
                                 <th>S.no</th>
                                 <th>Title</th>
                                 <th>Publish Date</th>
                                 <th>View / Download</th>
                              </tr>
                           </thead>
                           	<tbody>
                            
                            <tr>
                                
                            
                           <?php   $date=date('Y-m-d'); 
                            //  $sqlnews="select * from combine_publish where cat_id='2' and approve_status='3' and language_id='1' and date(end_date ) >= '$date' order by m_id asc ";
                              $sqlnews="select * from combine_publish where cat_id='2' and language_id='1' and approve_status='3' and end_date >= CURDATE() - INTERVAL 6 MONTH order by end_date DESC;";
                              $resnews=$conn->query($sqlnews);
                              $m=1;
                              if($resnews->num_rows>0)
                              {
                              while($rownews=$resnews->fetch_array())
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
                                      		
                              ?>	
					
            	
              
                                  
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
						  <td colspan='5' style="text-align:center;color:white;">No Record Found</td>
						  </tr>
						  <?php
							 } ?>
						</tbody>
					</table>	
					<a href="<?php echo $HomeURL?>/content/innerpage/official-circular.php" class="btn btn-primary btn-sm" style="float:right;">Orders Before January 2024</a>				
				<?php /*	<a href="<?php echo $HomeURL?>/content/circulars_archives.php" class="btn btn-primary btn-sm" style="float:right;">View Archive</a>		*/ ?>		
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