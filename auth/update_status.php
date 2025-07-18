<?php
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
                    	<?php } 
								$pay_slip = base64_decode($_POST['pay_slip']);
								$sqlq="select * from employee_payslip";
								$sqlsub1 = mysql_query($sqlq);
								while($data=mysql_fetch_assoc($sqlsub1)){									
		
						?>                	                   	                   	
            			<div >    
							<table style="width:130%;" border="1" cellspacing="2" cellpadding="2" summary="">
								<thead>
									<tr>
										<th colspan="4" style="text-align:center;">Pay Slip for the Month of DECEMBER-2020</th>
										<!-- <th colspan="1"><select class="form-control">
											<option>Select FY-Year
												<?php $dates = range('1991', date('Y'));
												foreach($dates as $date){

												    if (date('m', strtotime($date)) <= 6) {//Upto June
												        $year = ($date-1) . '-' . $date;
												    } else {//After June
												        $year = $date . '-' . ($date + 1);
												    }
												?>
												    <option value='<?php echo $year; ?>'><?php echo $year; ?></option>
												<?php }
												?></option>
										</select></th>
										<th colspan="1"><select class="form-control">
											<option>Select Month
												<?php for ($m=1; $m<=12; $m++) {
												    $month = date('F', mktime(0,0,0,$m)); 
												     	echo '<br>'.$month. '<br>'; ?>
														   <option value='<?php echo $month; ?>'><?php echo $month; ?></option>
												<?php } ?> 
											</option>	
															
										</select></th> -->
									</tr>
																		
									<tr>
										<th>Employee ID No</th>										
										<td><?php echo $data['emp_id']; ?></td>
										<th>Bank Name</th>
										<td><?php echo $data['bank_name']; ?></td>
									</tr>
									<tr>
										<th>Employee Name</th>
										<td><?php echo $data['emp_name']; ?></td>
										<th>Bank A/C No</th>
										<td><?php echo $data['bank_acc_no']; ?></td>
									</tr>
									<tr>
										<th>Designation</th>
										<td><?php echo $data['emp_degnation']; ?></td>
										<th>CPF/GPF/NPS. A/c No</th>
										<td><?php echo $data['cpf_gpf_nps_acc_no']; ?></td>
									</tr>
									<tr>
										<th>Level & Pay Scale</th>
										<td><?php echo $data['level_pay_scale']; ?></td>
										<th>GSLIS.No</th>
										<td><?php echo $data['gslis']; ?></td>
									</tr>
									<tr>
										<th>Date of Birth</th>
										<td><?php echo $data['dob']; ?></td>
										<th>PAN No</th>
										<td><?php echo $data['pan_no']; ?></td>
									</tr>
									<tr>
										<th>Date of Joining</th>
										<td><?php echo $data['doj']; ?></td>
										<th>AAADHAAR No</th>
										<td><b>N/A</b></td>
									</tr>
									<tr>
										<th>Payments</th>
										<th>Amount</th>
										<th>Deduction</th>
										<th>Amount</th>
									</tr>
									<tr>
										<th>Basic Pay</th>
										<td><?php echo $data['basic_pay']; ?></td>
										<th>IncomeTax</th>
										<td><?php echo $data['income_tax']; ?></td>
									</tr>
									<tr>
										<th>D.A.</th>
										<td><?php echo $data['da']; ?></td>
										<th>Cess</th>
										<td><?php echo $data['cess']; ?></td>
									</tr>
									<tr>
										<th>H.R.A.</th>
										<td><?php echo $data['hra']; ?></td>
										<th>GSLIS</th>
										<td><?php echo $data['employee_gslis']; ?></td>
									</tr>
									<tr>
										<th>Trans.Allow</th>
										<td><?php echo $data['trans_allow']; ?></td>
										<th>C.P.F./G.P.F Contri.</th>
										<td><?php echo $data['cpf_gpf_contri']; ?></td>
									</tr>
									<tr>
										<th>D.A on T.A.</th>
										<td><?php echo $data['da_ta']; ?></td>
										<th>C.P.F.Adv</th>
										<td><?php echo $data['cpf_adv']; ?></td>
									</tr>
									<tr>
										<th>Special Pay</th>
										<td><?php echo $data['special_pay']; ?></td>
										<th>NPS</th>
										<td><?php echo $data['nps']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>CGEIS / GIS</th>
										<td><?php echo $data['cgeis_gis']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>HBA</th>
										<td><?php echo $data['hba']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Computer Adv.</th>
										<td><?php echo $data['computer_adv']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>HPL</th>
										<td><?php echo $data['hpl']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Motor Car Adv.</th>
										<td><?php echo $data['motar_car_adv']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>CGHS</th>
										<td><?php echo $data['cghs']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Society</th>
										<td><?php echo $data['society']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Welfare Fund</th>
										<td><?php echo $data['welfare_fund']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Miscellaneous</th>
										<td><?php echo $data['miscellaneous']; ?></td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>Festival Adv.</th>
										<td><?php echo $data['festival_adv']; ?></td>
									</tr>
									<tr>
										<th>Total salary</th>
										<td><?php echo $data['total_salary']; ?></td>
										<th>Total Deduction</th>
										<td><?php echo $data['total_deduction']; ?></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<th>dqy Hkqxrku Net Pay</th>
										<td><?php echo $data['dqy_hkqxrku_net_pay']; ?></td>
									</tr>
									<tr>
										<th colspan="4" style="text-align:center;"><?php echo $data['amount_eng']; ?>
										</th>
									</tr>									 									
								</thead>            					
							</table>	
            			</div> 
					<?php } ?>    						
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
