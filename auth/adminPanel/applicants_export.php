<?php
ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
require_once("../../includes/ps_pagination.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();

if($_REQUEST['pid'] == '')
{	
	$rs = "SELECT * FROM appform_detail ORDER BY app_id DESC";
	$sql = $conn->query($rs);
}
else
{
	$poid = $_REQUEST['pid'];
	$rs = "SELECT * FROM appform_detail where post='".$poid."' ORDER BY app_id DESC";
	$sql = $conn->query($rs);
}

$no = 1;
?>
<table border="2">
   <tr>
		<th width="118">Application No</th>
		<th width="127">Applicant Name </th>
		<th width="127">Post Applied </th>
		<th width="127">Advertisement No.</th>
		<th width="127">Email </th>
		<th width="127">Gender </th>
		<th width="127">Father's/Husband's Name </th>  
		<th width="127">Date of Birth </th>
		<th width="127">Category </th>
		<th width="127">Nationality</th>  
		<th width="127">Age </th>  
		<th width="127">Marital Status</th>
		<th width="127">Phone No </th>
		<th width="127">Permanent Address</th>
		<th width="127">Present Address</th>
		<th width="127">Examination Passed </th>
		<th width="127">Name of Universtiy Board </th>
		<th width="127">Month of Passing </th>
		<th width="127">Year of passing </th>
		<th width="127">Subjects </th>
		<th width="127">Division</th>
		<th width="127">% of Mark</th>
		<th width="127">Other Qualification</th>
		<th width="127">GATE Qualifying Year</th>
		<th width="127">GATE Score</th>
		<th width="127">Employer Name</th>
		<th width="127">Address of employer</th>
		<th width="127">Post Held</th>
	    <th width="127">From</th>
		<th width="127">To</th>
		<th width="127">Jobs Description</th>
		<!-- <th width="127">Mention Govt. / PSU / Semi Govt. / Autonomous Body / Private</th> -->
		<th width="127">Individual Exp</th>
		<!-- <th width="127">Mention IDA / CDA / Grade Pay</th> -->
		<!-- <th width="127">Pay Scale</th> -->
		<!-- <th width="127">Monthly CTC</th> -->
		<!-- <th width="127">Annual CTC</th> -->
		<th width="127">Gross Pay (Per Month)</th>
		<th width="127">Total Experience : (Y-m)</th>
		<th width="127">Language</th>
		<th width="127">Status</th>
		<!-- <th width="127">Examination Passed</th> -->
		<th width="127">Physical Handicap</th>
		<!-- <th width="127">Suitablity for the post</th> -->
		<!-- <th width="127">Relative Employed</th> -->
		<!-- <th width="127">Hearing defect</th> -->
		<!-- <th width="127">Sight defect</th> -->
		<!-- <th width="127">Limbs defect</th> -->
		<th width="127">Disciplinary Proceedings</th>
		<th width="127">If Action Taken Against</th>
		<!-- <th width="127">Preferred Place</th> -->
		<!-- <th width="127">Place</th> -->
		<!-- <th width="154">TransactionID</th> -->
		<!-- <th width="154">Transaction Status </th> -->
		<th width="127">Date</th>
	</tr>
	<?php
	$monthList = array("1"=>"Janaury","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
	while($data = $sql->fetch_array()){
		
		$main_id = $data['app_id'];
        $sqlpost = "select postname, advertisement_no from post_mst where post_id='".$data['post']."'";
		$respost = $conn->query($sqlpost);
		$rowpost = $respost->fetch_array();
		
		$sqlcat = "select c_name from category_master where c_id='".$data['category']."'";
		$rescat = $conn->query($sqlcat);
		$rowcat = $rescat->fetch_array();
        //echo $rowcat['c_name'];

       	$show2 = "SELECT * FROM `appform_qualification` WHERE  app_id='$main_id'";
        $result_qua = $conn->query($show2);
        $row_qua = $result_qua->num_rows;

        $show3 = "SELECT * FROM `appform_experience` WHERE  app_id='$main_id'";
        $result_ex = $conn->query($show3);
        $row_ex = $result_ex->num_rows;

        $show4 = "SELECT * FROM `appform_language` WHERE  app_id='$main_id'";
        $result_lang = $conn->query($show4);
        $row_lang = $result_lang->num_rows;

	  	if($row_qua > $row_ex)
	  	{
         	if($row_qua > $row_lang)
         	{
         		$big = $row_qua;
         	}
         	else
         	{
         		$big = $row_lang;
         	}
  		}
  		else
  		{
  			$big = $row_ex;
  		}

		// for ($i=0; $i <$big ; $i++) { 
		    // $fetch_qualification = mysql_fetch_array($result_qua);
  			$exam_pass = array();
  			$uni_board = array();
  			$pass_month = array();
  			$pass_year = array();
  			$subjects = array();
  			$divison = array();
  			$percentage = array();
		    while($fetch_qualification=$result_qua->fetch_array()) {
		    	$exam_pass[] = $fetch_qualification['exam'];
		    	$uni_board[] = $fetch_qualification['board'];
		    	$pass_month[] = $fetch_qualification['pass_month'];
		    	$pass_year[] = $fetch_qualification['pass_year'];
		    	$subjects[] = $fetch_qualification['subject'];
		    	$divison[] = $fetch_qualification['divison'];
		    	$percentage[] = $fetch_qualification['marks'];
		    }

		    // $fetch_exp = mysql_fetch_array($result_ex);

  			$e_name = array();
  			$e_address = array();
  			$e_post = array();
  			$e_from = array();
  			$e_to = array();
  			$j_desc = array();
  			$experience = array();
  			$month_salary = array();
		    while($fetch_exp = $result_ex->fetch_array()) {
		    	$e_name[] = $fetch_exp['e_name'];
		    	$e_address[] = $fetch_exp['e_address'];
		    	$e_post[] = $fetch_exp['e_post'];
		    	$e_from[] = $fetch_exp['e_from'];
		    	$e_to[] = $fetch_exp['e_to'];
		    	$j_desc[] = $fetch_exp['j_d'];
		    	$experience[] = $fetch_exp['experience'];
		    	$month_salary[] = $fetch_exp['month_salary'];
		    }
		    
		    // $fetch_lang = mysql_fetch_array($result_lang);
		    $language = array();
  			$status = array();
		    while($fetch_lang = $result_lang->fetch_array()) {
		    	$language[] = $fetch_lang['language'];
		    	$status[] = $fetch_lang['status'];
		    }
		    echo "<tr>";
				?>

				<td><?php echo $data['app_no'];?></td>
				<td><?php echo $data['name'];?></td>
				<td><?php echo $rowpost['postname'];?></td>
				<td><?php echo $rowpost['advertisement_no'];?></td>
				<td><?php echo $data['email'];?></td>
				<td><?php echo $data['gender'];?></td>
				<td><?php echo $data['par_name'];?></td>
				<td><?php echo date('d-m-Y',strtotime($data['dob']));?></td>
				<td><?php echo $rowcat['c_name'];?></td>
				<td><?php echo $data['nation'];?></td>
				<td><?php echo $data['age'];?></td>
				<td><?php echo $data['m_status'];?></td>
				<td><?php echo $data['mobile'];?></td>
				<td><?php echo $data['p_address'];?></td>
				<td><?php echo $data['c_address'];?></td>
				<td>
					<?php
					foreach ($exam_pass as $epass) {
						if($epass!=='10th' && $epass!=='12th') {
							$rr = "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$epass'";
							$rs = $conn->query($rr);
							$query_qual = $rs->fetch_array();
							$epass = $query_qual['Qualification_list'];
							echo "<table border=\"1\"><tr><td>".$epass."</td></tr></table>";
						} else {
							echo "<table border=\"1\"><tr><td>".$epass."</td></tr></table>";
						}
					}
					//echo $fetch_qualification['exam'];
					?>
				</td>
	            <td>
	            	<?php
	            	foreach ($uni_board as $uboard) {
						echo "<table border=\"1\"><tr><td>".$uboard."</td></tr></table>";
					}
	            	// echo $fetch_qualification['board'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($pass_month as $pmonth) {
	            		if (array_key_exists($pmonth, $monthList)) {
							echo "<table border=\"1\"><tr><td>".$monthList[$pmonth]."</td></tr></table>";
	            		}
					}
	            	//echo $fetch_qualification['pass_month'];
	            	?>
            	</td>
	            <td>
	            	<?php
	            	foreach ($pass_year as $pyear) {
						echo "<table border=\"1\"><tr><td>".$pyear."</td></tr></table>";
					}
	            	// echo $fetch_qualification['pass_year'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($subjects as $subj) {
						echo "<table border=\"1\"><tr><td>".$subj."</td></tr></table>";
					}
	            	//echo $fetch_qualification['subject'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($divison as $divi) {
						echo "<table border=\"1\"><tr><td>".$divi."</td></tr></table>";
					}
	            	//echo $fetch_qualification['divison'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($percentage as $marks) {
						echo "<table border=\"1\"><tr><td>".$marks."</td></tr></table>";
					}
	            	//echo $fetch_qualification['marks'];
	            	?>
	            </td>
	            <td><?php 
				    if(!empty($data['other_qualification']))
				     	echo $data['other_qualification'];
					else 
				  		echo "NULL";
				    ?>
				</td>
	            <td><?php echo $data['gate_score'];?></td>
	            <td><?php echo $data['enter_score'];?></td>
	            <td>
	            	<?php
	            	foreach ($e_name as $ename) {
						echo "<table border=\"1\"><tr><td>".$ename."</td></tr></table>";
					}
	            	//echo $fetch_exp['e_name'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($e_address as $eadd) {
						echo "<table border=\"1\"><tr><td>".$eadd."</td></tr></table>";
					}
	            	//echo $fetch_exp['e_address'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($e_post as $epost) {
						echo "<table border=\"1\"><tr><td>".$epost."</td></tr></table>";
					}
	            	//echo $fetch_exp['e_post'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($e_from as $efrom) {
						echo "<table border=\"1\"><tr><td>".$efrom."</td></tr></table>";
					}
	            	//echo $fetch_exp['e_from'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($e_to as $eto) {
						echo "<table border=\"1\"><tr><td>".$eto."</td></tr></table>";
					}
	            	//echo $fetch_exp['e_to'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($j_desc as $jdesc) {
						echo "<table border=\"1\"><tr><td>".$jdesc."</td></tr></table>";
					}
	            	//echo $fetch_exp['j_d'];
	            	?>
	            </td>
	            <!-- <td><?php echo $fetch_exp['e_type'];?></td> -->
	            <td>
	            	<?php
	            	foreach ($experience as $exp) {
						echo "<table border=\"1\"><tr><td>".$exp."</td></tr></table>";
					}
	            	//echo $fetch_exp['experience'];
	            	?>
	            </td>
	            <!-- <td><?php echo $fetch_exp['pay_type'];?></td> -->
	            <!-- <td><?php echo $fetch_exp['pay_scale'];?></td> -->
	            <td>
	            	<?php
	            	foreach ($month_salary as $monsal) {
						echo "<table border=\"1\"><tr><td>".$monsal."</td></tr></table>";
					}
	            	//echo $fetch_exp['month_salary'];
	            	?>
	            </td>
	            <!-- <td><?php echo $fetch_exp['gross_salary'];?></td> -->
	            <td><?php echo $data['total_exp'];?></td>
	            <td>
	            	<?php
	            	foreach ($language as $lang) {
						echo "<table border=\"1\"><tr><td>".$lang."</td></tr></table>";
					}
	            	//echo $fetch_lang['language'];
	            	?>
	            </td>
	            <td>
	            	<?php
	            	foreach ($status as $sts) {
						echo "<table border=\"1\"><tr><td>".$sts."</td></tr></table>";
					}
	            	//echo $fetch_lang['status'];
	            	?>
	            </td>
	            <!-- <td><?php echo $fetch_lang['certificate'];?></td> -->
	            <td><?php if($data['ph_percentage'] == 'yes') { echo 'Yes'; } else if($data['ph_percentage'] == 'no') { echo "No"; } ?></td>
	            <!-- <td><?php echo $data['suitable'];?></td> -->
				<!-- <td>
					<?php
					/*if($data['rel']=="yes")
					{
					 	echo $data['relative_per']; 
					}
					else 
					{
					  	echo "NO"; 
					}*/
					?>
				</td> -->
				<!-- <td><?php echo $data['def_h'];?></td> -->
				<!-- <td><?php echo $data['def_s'];?></td> -->
				<!-- <td><?php echo $data['def_l'];?></td> -->
				<td><?php echo $data['decipline'];?></td>	
				<td><?php echo $data['discipline_against'];?></td>	
				<!-- <td><?php echo $data['inter_place'];?></td> -->
				<!-- <td><?php echo $data['place'];?></td> -->
			    <!-- <td>TransactionID</td> -->
				<!-- <td>TransactionStatus</td> -->
				<td><?php echo date('d-m-y',strtotime($data['i_date']));?></td>
				<?php
			echo "</tr>";
  		// }
	}
	?>
</table>
<?php
header("Content-type: application/vnd-ms-excel");
$fileName = "applicants_export";
header("Content-Disposition: attachment; filename=".$fileName.".xls");
?>