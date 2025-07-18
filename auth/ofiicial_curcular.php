<?php
  ob_start();
  session_start();
  error_reporting(1);

    require_once "../includes/connection.php";
    require_once("../includes/frontconfig.inc.php");
    require_once "../includes/functions.inc.php";
   // require_once "../securimage/securimage.php";
    include("../includes/def_constant.inc.php");
   // include('../design.php');
    include("../includes/useAVclass.php");

  $useAVclass = new useAVclass();
  $useAVclass->connection();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ofiicial Circular Details</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    <script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head> 
  <body id="fontSize">
    <header>
      <?php include("../content/top_bar.php");?>
    </header>
    <div class="mobile-nav">
            <img src="images/toogle.png" alt="toogle" title="toogle">
    </div>
    <nav>
      <div class="container">
        <?php include("../content/header.php");?>
      </div>  
    </nav>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-3 left-navigation">
                    <?php include("user_menu.php");?>
                </div>
       <div class="col-sm-9 main-content inner">
          <div class="">
            <ul class="breadcrumb" style="margin-top:5px;">
              <li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a></li>
              <li>Employee Login</li>
              <li></li>
            <li>Classified Official Circular Details</li>
            </ul>
          </div>
          

                    <div class="inner_right_container">
                      <div class="inner_right_container" style="width:136.6%; float: left; background: url(../images/Back-nav.jpg) repeat-x; border: 1px solid #686868; text-align: center; background-color:#17539a; color:white;">
                            <span><h3>Welcome&nbsp;<?php echo $_SESSION['login_user'];?><button style="background:#0b6ba5; margin-left:90%; margin-top:-21px;" onclick="goBack()">Back</button></h3></span> 
                        </div>                      

                      <?php if ($_SESSION['edit_prof'] != '') { ?>
                          <div  id="msgclose" class="status success">
                              <div class="closestatus" style="float: none;">
                                  <p><span>Attention! </span><?php echo $_SESSION['edit_prof'];
                                      $_SESSION['edit_prof'] = "";?>
                                  </p>
                              </div>
                          </div>
                      <?php } ?>

						<?php 
							if(isset($_POST['search'])){
								if(!empty($_POST['circular_title']) || !empty($_POST['from_date']) || !empty($_POST['to_date'] )){
									if(!empty($_POST['circular_title'])){
									$title="`m_title` LIKE '%".trim($_POST['circular_title'])."%' or ";
									}
								$sqlq ="select * FROM manage_circular where ".$title." `start_date` >='".date('Y-m-d',strtotime($_POST['from_date']))."' and `start_date` <='".date('Y-m-d',strtotime($_POST['to_date']))."' AND `category` = '1'"; 
									$sqlsub1 = $conn->query($sqlq);
								}else{
									$sqlq="SELECT * FROM `manage_circular` WHERE `language_id` = '1' AND `approve_status` = '1' AND `category` = '1'";
									$sqlsub1 = $conn->query($sqlq);
								}
							}else{
								 $sqlq="SELECT * FROM `manage_circular` WHERE `language_id` = '1' AND `approve_status` = '1' AND `category` = '1'";
								 $sqlsub1 = $conn->query($sqlq);
							}
						
         				?>                     
                  <div style="width:136.6%;">    
              <form method='post' action="ofiicial_curcular.php" enctype="multipart/form-data" >
                <table>
                  <thead>
                    <tr>
                      <th style="background-color:#0074bc;">
                        <div class="col-sm-12">
                          <div class="col-md-3">
                            <input type="text" autocomplete="off" name='circular_title'style="width: 100%; color: #555; background-color: #fff;" value="" placeholder="Enter Circular Title" />
                          </div>
                          <div class="col-md-3">
                            <input type="text" class='date' autocomplete="off" name='from_date' placeholder="From Date" style="width: 100%;color: #555; background-color: #fff;" value="" />
                          </div>
						   <div class="col-md-3">
                            <input type="text" class='date' autocomplete="off" name='to_date' placeholder="To Date" style="width: 100%;color: #555; background-color: #fff;" value="" />
                          </div>
                          <div class="col-md-3">
                            <button type='submit' id="search" name='search'style="background-color: #0074bc; color: white;padding:7px; border-radius: 25px;"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                            <button id="refresh" onclick="myFunction()" style="background-color: #0074bc; color: white;padding:7px; border-radius: 25px;"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Refresh</button>
                          </div>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <table>
                    <thead>
                      <tr>
                        <th>Sr No.</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Document</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      if (!$sqlsub1->num_rows) {
                    ?>
                      <tr>
                        <td colspan="5" style="text-align:center; color:red;">Oops No Record Found.</td>
                      <tr>
                    <?php }else{
                      $i = 0;
                      while($data=$sqlsub1->fetch_assoc()){ 
                      $i++;
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                    
                        <td><?php echo $data['m_title']; ?></td>
                        <td><?php echo $data['start_date']; ?></td>
                        <td><a href="<?php echo $data['m_url']; ?>" title="PDF that opens in new window" target="
                        _blank"><img src=" http://nwda.gov.in/images/pdf_icon.png" width="20" height="12" alt="PDF File">&nbsp;View</a></td>
                      </tr>
                    <?php } }?>
                    </tbody>
                  </table>
                </table>
                </form>
                  </div>    
                </div>
              </div> 
            </div>
        </div>
  </section>
<footer>
  <?php include("../content/footer.php");?>
</footer>

<script>
    function goBack(){
    window.history.back();
}
window.onload = function() {
 $(document).ready(function () { 
            $("#refresh").click(function () { 
                location.reload(true); 
            }); 
        });
};
</script>
<script type='text/javascript'>
   $(document).ready(function(){
     $('.date').datepicker({
        dateFormat: "dd-mm-yy"
     });
   });
</script>

<script type="text/javascript"> 
        $(document).ready(function () { 
            $("#refresh").click(function () { 
                location.reload(true); 
            }); 
        }); 
</script>
</body> 
</html>
