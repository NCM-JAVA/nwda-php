<?php
	echo "string"; die();
	ob_start();
	session_start();
	error_reporting(1);

		require_once "../includes/connection.php";
		require_once("../includes/frontconfig.inc.php");
		require_once "../includes/functions.inc.php";
		require_once "../securimage/securimage.php";
		include("../includes/def_constant.inc.php");
		include('../design.php');
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
						<ul class="breadcrumb" style="margin-top:6px;">
							<li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a></li>
                            <li></li> 
							<li>Employee Login Details</li>
						</ul>
					</div>

                    <div class="inner_right_container">
                    	<div class="inner_right_container" style="width:130%; float: left; background: url(../images/Back-nav.jpg) repeat-x; border: 1px solid #686868; text-align: center; background-color:#17539a; color:white;">
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
         					$sqlq="select * from menu_publish where m_flag_id='0' and m_id='296'  and menu_positions='3' and language_id='1' and approve_status='4' ORDER BY page_postion ASC";
         					$sqlsub1 = mysql_query($sqlq);

         						while($data=mysql_fetch_assoc($sqlsub1)){
                    	?>                    	
            			<div style="width:100%;">    
            			    <table width="100%" border="1" cellspacing="2" cellpadding="2" summary="">
								<thead>
									<tr>
										<th style="text-align:left;">Sr No.</th>
										<th style="text-align:left;">User name</th>
										<th style="text-align:left;">Login name</th>
										<th style="text-align:left;">Email</th>
										<th style="text-align:left;">Phone</th>
										<th style="text-align:left;">Status</th>
										<th style="text-align:left;">Pay-slip</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$sqlq="select * from signup";
										$i=0;
										$sqlsub1 = mysql_query($sqlq);
										while($data=mysql_fetch_assoc($sqlsub1)){
										$i++;	
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $data['user_name']?></td>
										<td><?php echo $data['login_name']?></td>
										<td><?php echo $data['user_email']?></td>
										<td><?php echo $data['user_phone']?></td>
										<?php if( $data['flag_id']==NULL && $data['flag_id']!=1){ ?>
											<td style="color:red;"><b>Inactive <i class="fa fa-close"></i></b> </td>
											<?php } else{ ?>	
												<td style="color:green;"><b>Active <i class="fa fa-check"></i></b> </td>
											<?php }?>
										<td><a href="payslip.php"><b><?php if(!empty($_SESSION['login_user'] == $data['login_name'])) { echo $data['pay_slip']; }else{ echo 'Other User'; } ?></b></a></td>	
									</tr>
										<?php } ?> 
								</tbody>
							</table>
            			</div>    
            			<?php }?>
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
</script>
<script type='text/javascript'>
   $(document).ready(function(){
     $('.date').datepicker({
        dateFormat: "dd-mm-yy"
     });
   });
</script>
<script>
function myFunction(){
	$("#search").click(function(){
  	alert('Your Function Run Successfully.');
  	exit();
});
}
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
