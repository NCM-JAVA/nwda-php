<?php
	ob_start();
	session_start();
	error_reporting(1);

		require_once "../includes/connection.php";
		require_once("../includes/frontconfig.inc.php");
		require_once "../includes/functions.inc.php";
		//require_once "../securimage/securimage.php";
		include("../includes/def_constant.inc.php");
		include('../design.php');
		include("../includes/useAVclass.php");

	$useAVclass = new useAVclass();
	$useAVclass->connection();


	 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Employee Payslip Details</title>
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
  		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
							<li>Employee Payments Details</li>
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
						
							<table style="width:130%;" border="1" cellspacing="2" cellpadding="2" summary="">
								<thead>
									<tr class="">
										<th colspan="4" style="text-align:center;">Please select the month for view pay-slip.</th>
									</tr>
									<tr>
										<th style="text-align:center;">Employee Pay Slip for the Month Wise Details</th>
										<th>
											<select class="form-control" id="year">
												<option value="">Select Year</option>
													<?php $dates = range('2020', date('Y'));
													foreach($dates as $date){
														if (date('m', strtotime($date)) <= 6) {//Upto June
															$year = ($date-1) . '-' . $date;
														} else {//After June
															$year = $date . '-' . ($date + 1);
														}
													?>
												<option value='<?php echo $year; ?>'>FY-<?php echo  $year; ?></option>
													<?php } ?>
											
											</select>
										</th> 
										<th >
											<select class="form-control" id="month">
												<option value="">Select Month</option>
												<?php for ($m=1; $m<=12; $m++) {
											    	$month = date('F', mktime(0,0,0,$m)); ?>
													<option value='<?php echo $m; ?>'><?php echo $month; ?></option>
												<?php } ?> 
											</select>
										</th>
										<th>
										<button style="background:#0b6ba5; padding:5px;"  onclick="myFunction();">Get Pay Slip</button>
										</th>
									</tr>
								</thead>
							</table>
							<br>
							
							<div id="hidepayslip"></div>
							
				   						
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

<script>
function myFunction(){
	var month = $("#month").val();
	var year = $("#year").val();
	
	if(month==''){
		alert('Please select Month');
	}
	if(year==''){
		alert('Please select Financial Year');
	}

	var emp_id ='<?php echo base64_decode($_GET["id"]);?>';
	$.ajax({
	type: "POST",
	url: "get_payslip_details.php",
	   data: {"emp_id":emp_id,'month':month,'year':year},
		success: function(data){
			$("#hidepayslip").html(data);
		}
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
