<?php
   ob_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   include('../design.php');
   include("../counter.php");
   
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
                  <li>Advertisement</li>
                  <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
               </ul>
            </div>
            <h2>Advertisement</h2>
            <form method="post" action="form.php">
               <p>
                  <?php $p_query="SELECT * FROM advertisement_mst ORDER BY advertiseid DESC";
                     $p_res=mysql_query($p_query);
                     $i=1;
                     while($p_data = mysql_fetch_array($p_res))
                     {
                     @extract($p_data);
                       	
                     ?>
                  <?php echo html_entity_decode($advertisementdesc,ENT_QUOTES);?> (<?php echo $advertisementno; ?>)
               <table class="table table-bordered">
                  <thead>
				  <tr>
                     <th>S.No</th>
                     <th>Post name</th>
                     <th>Apply</th>
					 </tr>
                  </thead>
                  <tbody>
                     <?php
                        $sqldata="select * from advertisement_postapplied where postappliedid='".$p_data['advertiseid']."'";
                        $resdata=mysql_query($sqldata) or die(mysql_error());
                        
                        while($rowdata=mysql_fetch_array($resdata))
                        {
                        
                        $postid = $rowdata['post_id'];
                        
                        $sqlpost="select * from post_mst where post_id='".$postid."'";
                        $respost=mysql_query($sqlpost) or die(mysql_error());
                        $rowpost=mysql_fetch_array($respost);
                        $postid=$rowpost['post_id'];
                        ?>
                     <tr>
                        <td><?php  echo $i; ?></td>
                        <td><?php  echo $rowpost['postname']; ?></td>
                        <td><a href='form.php?pid=<?php echo $postid; ?>'>Apply Online</a></td>
                     </tr>
                     <?php  } ?>
					    </tbody>	
               </table>
               <?php $i++;}?>
            
            </form>
         </div>
         </div>
         </div>
      </section>
      <footer>
         <?php include("footer.php");?>
      </footer>
   </body>
</html>