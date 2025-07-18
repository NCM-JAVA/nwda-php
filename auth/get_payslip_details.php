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
 
if(!empty($_POST["month"])) 
{ 
	$sqlq="select * from employee_payslip WHERE payment_month = '". $_POST["month"]."' AND payment_year = '". $_POST["year"]."' AND emp_id = '". $_POST["emp_id"]."'";
	$sqlsub1 = mysql_query($sqlq);
	$total = mysql_num_rows($sqlsub1);
	if($total >0){
	while($data=mysql_fetch_assoc($sqlsub1)){
		
?>
		<table style="width:130%;">
			<tr>
				<th colspan="3" style="text-align:center;">Employee Payment Details (Pay Slip for the Month )</th>
				<th colspan="1" style="text-align:center;"><button id="refresh" style="background:#0b6ba5;" onclick="window.print('print_setion')"> Print</button></th>
			</tr>	
		</table>
<table  class="hidee" style="width:130%;" id="print_setion">
	<thead>								
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
			<td><strong><?php echo $data['total_salary']; ?></strong></td>
			<th>Total Deduction</th>
			<td><strong><?php echo $data['total_deduction']; ?></strong></td>
		</tr>
		<tr>

			<th colspan="3" style="text-align:right;">Net Pay</th>
			<td><strong><?php echo $data['dqy_hkqxrku_net_pay']; ?></strong></td>
		</tr>
		<tr>
			<th colspan="4" style="text-align:center;"><?php echo $data['amount_eng']; ?>
			</th>
		</tr>
		<tr>
			<th style="width:30%;"><img src="<?php echo $HomeURL.'/upload/signature/update_1st.png'?>" style="width:90px; height:70px"><br>Prepared By</th>
			<th colspan="2"><img src="<?php echo $HomeURL.'/upload/signature/updated_2nd.png'?>" width="100px"><br>Junior Accountant</th>
			<th  style="width:30%;"><img src="<?php echo $HomeURL.'/upload/signature/update_3rd.png'?>" width="100px"><br>Jr. Accounts Officer</th>
		</tr>									 									
	</thead>            					
</table>



<?php } }else{?>
	<table border="1" cellspacing="2" cellpadding="2" class="hidee" style="width:130%;">
		<tr >
			<p style="text-align:center; color:red;">No Pay Slip data Found for this month.</p>
		</tr>	
	</table>
<?php } } ?>
