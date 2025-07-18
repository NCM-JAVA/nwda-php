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
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "3";
// $role_map=role_permission($user_id,$role_id,$model_id);
// $role_id_page=role_permission_page($user_id,$role_id,$model_id);
 
 	$sql         = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
    $rs          = $conn->query($sql);
    $role_module = $rs->fetch_array();

    $module_id   = $role_module['module_id'];
    if ($module_id == 'ALL') {
        $role_id_page = 1;
    } else {
        $cms           = array(
            $model_id
        );
        $exploded      = explode(',', $module_id);
        $module_id_cms = array_intersect($exploded, $cms);
        if (count($module_id_cms) > 0) {
            $role_id_page = 1;
        } else {
            $role_id_page = 0;
        }
    }
if($_SESSION['admin_auto_id_sess']=='')
{
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:index.php");
	exit;
}
if($_SESSION['saltCookie']!=$_COOKIE['Temp'])
{
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:error.php");
	exit;
}
if($role_id_page==0)
{
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:error.php");
	exit;
}
if($_SESSION['lname'] =="")
{
	$_SESSION['lname']='English';
}
if($_SESSION['lname']=='English')
{
	$language='1';
}
else if($_SESSION['lname']=='Hindi')
{
	$language='2';
}
if($deleteid !='')
{
	if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($deleteid))))
	{
		/*session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);*/
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg;
		header("Location:error.php");
		exit();
	}
	else {
		$_COOKIE['Temp']="";
		$_SESSION['saltCookie']="";
		$_SESSION['Temptest']="";
		$saltCookie =uniqid(rand(59999, 199999));
		$_SESSION['saltCookie'] =$saltCookie;
		$_SESSION['Temptest']=$_SESSION['saltCookie'];
		setcookie("Temp",$_SESSION['saltCookie']);
		$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
	}
 	$check_status=check_delete($user_id,$role_id,$model_id);
	if($check_status >0)
	{
		$sqd = "select advertisedoc FROM advertisement_mst WHERE advertiseid=$cid";
		$sql="Delete From advertisement_mst where advertiseid='$deleteid'";
		$res = $conn->query($sql);
		$page_id = $conn->insert_id;
					
    	$rs = $conn->query($sqd);
		$row = $rs->fetch_array();

	    $image_path = "../../upload/photogallery/".$row['advertisedoc'];
	    $image_path2 = "../../upload/photogallery/thumb/".$row['advertisedoc'];
	    unlink($image_path);
   		unlink($image_path2);	
		$SQL1 = "SELECT * FROM audit_trail where page_id='$deleteid'";
	    $Query = $conn->query($SQL1);
		
		// $pagename  = mysql_result($Query,0,'page_name');
		// $txtlanguage  = mysql_result($Query,0,'lang');
		// $txtstatus  = mysql_result($Query,0,'approve_status');
		// $gallery_categoryname  = mysql_result($Query,0,'page_title');
		
		$pagename  = $result['page_name'];
		$txtlanguage  = $result['lang'];
		$txtstatus  = $result['approve_status'];
		$gallery_categoryname  = $result['page_title'];
		
		$user_id=$_SESSION['admin_auto_id_sess'];			
		$page_id=$conn->insert_id;
		$action="Delete";
		$categoryid='1'; //mol_content
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$model_id='Manage Latest New';

		// $tableName="audit_trail";
		// $tableFieldsName_send=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		// $tableFieldsValues_send=array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
		// $useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);

		$sql = "INSERT INTO audit_trail ('user_login_id','page_id','page_name','page_action','page_category','page_action_date','ip_address','lang','page_title','approve_status')VALUES ('$user_id','$deleteid','$pagename','$action','$model_id','$date','$ip','$txtlanguage','$gallery_categoryname','$txtstatus')";
		$sqli1 = $conn->query($sql);

		if($res)
		{
			header("location:delete.php?status=advertise_deleteid");
		}
	}
	else
	{
		/*session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id); */
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
	}
}

if(($inactiveid !=''))
{
	if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($inactiveid)))) {
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit();
	}
	else {
		$_COOKIE['Temp']="";
		$_SESSION['saltCookie']="";
		$_SESSION['Temptest']="";
		$saltCookie =uniqid(rand(59999, 199999));
		$_SESSION['saltCookie'] =$saltCookie;
		$_SESSION['Temptest']=$_SESSION['saltCookie'];
		setcookie("Temp",$_SESSION['saltCookie']);
		$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
	}

   	$sql="Update advertisement_mst set txtstatus='1' where advertisement_mst='$inactiveid'";
 	$res=mysql_query($sql);
  
	if($res)
	{	
		header("location:delete.php?status=advertise_inactiveid");
	}
}

$sqlquery ="select * from appform_detail where 1";
if($_POST['search_applicantno']!='')
{
	$sqlquery .=" and app_no LIKE '%$search_applicantno%'"; 
}
if($_POST['search_post']!='')
{
   	$sqlpost="select post_id,postname from post_mst where postname LIKE '%$search_post%'";
   	$respost=$conn->query($sqlpost);
   	$rowpost = $respost->fetch_array();
   	$postid=$rowpost['post_id'];
   	
   	$sqlquery .=" and post = '$postid'"; 
}
if($_POST['search_applicants']!='')
{
   $sqlquery .=" and name LIKE '%$search_applicants%'"; 
}
if($_POST['search_dob']!='')
{
   $dob1 = explode('-', $_POST[search_dob]);
   $dob2 = $dob1['2'] . "-" . $dob1['1'] . "-" . $dob1['0'];
   
   $sqlquery .=" and dob='$dob2'"; 
}
$sqlquery .=" ORDER BY app_id DESC";
?>

<script type="text/javascript" src="js/jsDatePick.js"></script>
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"search_dob",
			dateFormat:"%d-%m-%Y"
		});
	};
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Applicants List</title>
		<link href="style/admin.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $HomeURL;?>/css/print.css" media="print" rel="stylesheet" type="text/css" />
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="style/ie7.css">
		<![endif]-->
		<!--<script type="text/javascript" src="style/validation.js"></script>-->
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="style/ie7.css">
		<![endif]-->

		<script>
			function MM_openBrWindow(theURL,winName,features) 
			{ 
				window.open(theURL,winName,features);
			}
		</script>
	</head>
	<body>
    
		<?php include('top_header.php'); ?>
    
		<div id="container">
			<div class="clear"></div>
			<?php
				include_once('main_menu.php');
			?>
			<!-- Header end -->
			<div class="main_con">
				<div id="validterror" style="color:#F00" align="center"></div>
				<div style="text-align: center;display: none;" id="logotext">
					<div style="width: 10%;" id="logotext1">
						<img src="<?php echo $HomeURL;?>/images/emblem.png" id="logo" style="width: 50px;">
					</div>
					<div style="" id="logotext2">
						<h2 style="margin:0px;">National Water Development Agency</h2>
					</div>
				</div>
				<div class="right_col1">
					<div class="clear"></div>
					<?php
					if($_SESSION['content']!="") {
						?>
						<div id="msgclose" class="status success">
							<div class="closestatus" style="float: none;">
								<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
								<p>
									<img alt="Attention" src="images/approve.png" class="margintop">
									<span>Attention! </span>
									<?php echo $_SESSION['content'];
									$_SESSION['content']=""; ?>.
								</p>
							</div>
						</div>
						<?php  
		 			}
					
					if($_SESSION['errors']!="") { ?>
						<div id="msgerror" class="status error">
							<div class="closestatus" style="float: none;">
								<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
								<p>
									<img alt="error" src="images/error.png">
									<span>Attention! <br /></span>
									<?php echo $_SESSION['errors']; $_SESSION['errors']="";?>
								</p>
							</div>
						</div>
					<?php } ?>
					<div class="clear"></div>
					<div class="internalpage_heading">
						
							<h3 class="manageuser">Applicants List</h3>
							<br>
							<div class="right-section1">
								<p class="pull-right">
									<span class="btn btn-default btn-sm print-btn">
										<a href="javascript: void(0);" title="Print" onClick="javascript:window.print(); hideMenu()"> <span class="glyphicon glyphicon-print"></span> Print</a>
									</span>
								</p>
							</div>
						
						<?php
						$showid=$_REQUEST['appid'];
						if(!is_numeric(trim($showid)))
						{
						    $msg = "Something wrong in your id";
						    $_SESSION['sess_msg'] = $msg ;
						    header("Location:error.php");
						    exit();
						}
						$show="SELECT * FROM `appform_detail` where app_id='$showid'";
						$result = $conn->query($show);
						$fetch_detail=$result->fetch_array();
						@extract($fetch_detail);
						?>
						<div class="tab-container" id="outer-container" style="padding:5px 5px -12px  0px">
							<div class="grid_view">
								<div class="new-gried" style="background:#fff; padding:10px;font-size:14px;">
									<table>
										<tr>
											<td><strong>Post Applied For</strong></td>
											<td>
												<div class="col-md-12">
													<?php
												  	$sqlpost = "select postname, advertisement_no from post_mst where post_id='".$fetch_detail['post']."'";
													$respost = $conn->query($sqlpost);
													$rowpost = $respost->fetch_array();
													echo $rowpost['postname'];

													$age_on_que = "SELECT `age` FROM `post_mst` where   post_id='".$fetch_detail['post']."'";
													$dadt_age_on_que = $conn->query($age_on_que);
													$row_age_on_que = $dadt_age_on_que->fetch_array();
													?>
												</div>
											</td>
											<td><strong>Advertisement No.</strong></td>
											<td>
												<div class="col-md-12">
													<?php echo $advertisement_no;?>
												</div>
											</td>
										</tr>
										<legend>Personal Details</legend>
										<tr>
											<td><strong>Name of the Applicant</strong></td>
											<td>
												<div class="col-md-12">
													<?php echo $fetch_detail['name'];?>
												</div>
											</td>
											<td><strong>Email Id</strong></td>
											<td>
												<div class="col-md-12">
													<?php echo $fetch_detail['email'];?>
												</div>
											</td>
										</tr>
										<!--<tr>
										    <td><strong>Optional Email Id</strong></td>
										    <td>
										    	<div class="col-md-12">
													<?php 
													if($fetch_detail['opt_email']!='') {
														echo $fetch_detail['opt_email'];
													}
													else {
														echo "-";
													}
													?>
												</div>
											</td>
										</tr>-->
										<tr>
											<td><strong>Gender</strong></td>
											<td>
												<div class="col-md-12">
													<?php echo $fetch_detail['gender'];?>
												</div>
											</td>
											<td><strong>Father's/Husband's Name</strong></td>
											<td>
												<div class="col-md-6">
													<?php echo $fetch_detail['par_name'];?>
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>Date of Birth</strong></td>
											<td>
												<div class="col-md-6">
													<?php echo date('d-m-Y', strtotime($fetch_detail['dob']));?>
												</div>
											</td>
											<td><strong>Category</strong></td>
											<td>
												<span class="col-md-6">
													<?php
													$catid = $fetch_detail['category'];
													$sqlcat="select c_name from category_master where c_id='".$catid."'";
											        $rescat=$conn->query($sqlcat);
											        $rowcat=$rescat->fetch_array();
													echo $rowcat['c_name'];
													?>
												</span>
											</td>
										</tr>
										<tr>
											<td><strong>Nationality</strong></td>
											<td>
												<div class="col-md-6">
													<?php echo $fetch_detail['nation'];?>
												</div>
											</td>
											<td><strong>Age as on :-</strong> <span><?php echo date('d-m-Y', strtotime($row_age_on_que['age']));?></span></td>
											<td>
												<div class="col-md-6">
													<?php echo $fetch_detail['age'];?>
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>Marital Status</strong></td>
											<td>
												<div class="col-md-6">
													<?php echo $fetch_detail['m_status'];?>
												</div>
											</td>
											<td><strong>Phone No</strong></td>
											<td>
												<div class="col-md-6">
													<?php echo $fetch_detail['mobile'];?>
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>Present Address</strong></td>
											<td>
												<div class="form-group col-md-6">
													<?php echo $fetch_detail['c_address'];?>
												</div>
											</td>
											<td><strong>Permanent Address</strong></td>
											<td>
												<div class="form-group col-md-6">
													<?php echo $fetch_detail['p_address'];?>
												</div>
											</td>
										</tr>
										<tr>
											<?php
											$show2="SELECT * FROM `appform_qualification` WHERE  app_id='$showid'";
											$result_qua = $conn->query($show2);
											//$rowno=mysql_num_rows($result_qua);
											?>
											<td colspan="4">
												<legend>Qualification (Matriculation onward) (10<sup>th</sup>, 12<sup>th</sup>/Diploma and Degree Qualifications are mandatory)</legend>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table class="table-striped" id="tab_logic" width="100%">
													<tr>
														<th>Examination Passed</th>
														<th>Name of Universtiy Board</th>
														<th>Month of Passing</th>
														<th>Year of passing</th>
														<th>Subjects</th>
														<th>Division</th>
														<th>% of Mark</th>
													</tr>
													<?php
													$exam_pass = array();
													while($fetch_qualification=$result_qua->fetch_array()) {
														$exam_pass[] = $fetch_qualification['exam'];
													    @extract($fetch_qualification);
														//print_r($exam_pass);
													  	?>
														<tr id="addr<?php echo $fetch_qualification['row_id'];?>">
															<td>
															<!--	<?php
																$qquid=$fetch_qualification['exam'];
																$exam = "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";
																$exam_rs = $conn->query($exam);
																$query_qual =$exam_rs->fetch_array();
//echo "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";

															    	echo $query_qual['Qualification_list'];
															   
		    														?>-->
																	<?php
															$qquid=$fetch_qualification['exam'];
																if($qquid=='10th')
																{
																//$query_qual = mysql_fetch_array(mysql_query("SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='1'"));
																$exam = "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";
																$exam_rs = $conn->query($exam);
																$query_qual =$exam_rs->fetch_array();
																
																} elseif($qquid=='12th'|| $qquid=='12th/Diploma')
																{
																//$query_qual = mysql_fetch_array(mysql_query("SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='2'"));
																$exam = "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";
																$exam_rs = $conn->query($exam);
																$query_qual =$exam_rs->fetch_array();
																}
																else {
																		// $query_qual = mysql_fetch_array(mysql_query("SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'"));
																		$exam = "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";
																		$exam_rs = $conn->query($exam);
																		$query_qual =$exam_rs->fetch_array();
																}
//echo "SELECT `Qualification_list` FROM `qualification_mst` WHERE `qualification_id`='$qquid'";
					   
													
															    	echo $query_qual['Qualification_list'];
															   
		    														?>
															</td>
															<td>
																<?php echo $fetch_qualification['board'];?>
															</td>
															<?php
															$monthList = array("1"=>"Janaury","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
															?>
															<td>
																<?php
																if (array_key_exists($fetch_qualification['pass_month'], $monthList)) {
														           	echo $monthList[$fetch_qualification['pass_month']];
														        } ?>
															</td>
															<td>
																<?php echo $fetch_qualification['pass_year'];?>
															</td>
															<td>
																<?php echo $fetch_qualification['subject'];?>
															</td>
															<td>
																<?php echo $fetch_qualification['divison'];?>
															</td>
															<td>
																<?php echo $fetch_qualification['marks']."%";?>
															</td>
														</tr>
														<?php
													}
													// print_r($exam_pass);
													// foreach($exam_pass as $ep) {
														// echo $ep;
														// echo "<br>";
													// }
													?>
													<tr id='addr1'> </tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Other Qualification </strong>
											</td>
											<td>
												<?php 
											    if($fetch_detail['other_qualification'])
											    	echo $fetch_detail['other_qualification'];
											  	else 
											  		echo "N/A";
											    ?>
											</td>
											<td>
												<strong>Gate Qualifying Year :-</strong>
											</td>
											<td>
												<?php 
											    echo $fetch_detail['gate_score'];
											    ?>
											</td>
										</tr>
										<!-- <tr>
											<td colspan="4">
												<strong>Gate Qualifying Year :-</strong>
												<?php 
											    // echo $fetch_detail['gate_score'];
											    ?>
											</td>
										</tr> -->
										<tr>
											<td>
												<strong>Gate Score </strong>
											</td>
											<td>
												<?php
											    echo $fetch_detail['enter_score'];
											    ?>
											</td>
											<td>
												<strong>GATE Score Card </strong>
											</td>
											<td>
												<a href="<?php echo $HomeURL.'/upload/advertise/'.$fetch_detail['gate_certificate']; ?>" class="" alt="gate_score_card" target="_blank">View</a>
											</td>
										</tr>
										<!-- <tr>
											<td colspan="4">
												<strong>GATE Score Card :-</strong>
												<a href="<?php // echo $HomeURL.'/upload/advertise/'.$fetch_detail['gate_certificate']; ?>" class="" alt="gate_score_card" target="_blank">View</a>
											</td>
										</tr> -->
										<tr>
											<td colspan="4">
												<legend>Post Qualifcation Experience (From Current Employment to Past Employment.)</legend>
											</td>
										</tr>
										<tr>
											<td colspan="4">
												<table class="table-striped" id="tab_logic1">
													<tr>
														<th>Name</th>
														<th>Address of employer</th>
														<th>Post Held</th>
														<th>From</th>
														<th>To</th>
														<th>Job Description</th>
														<!-- <th>Mention Govt. / PSU / Semi Govt. / Autonomous Body / Private</th> -->
														<th>Individual Exp</th>
														<!-- <th>Mention IDA / CDA / Grade Pay</th> -->
														<!-- <th>Pay Scale</th> -->
														<th>Gross Pay</th>
													</tr>
													<?php
												    $show3="SELECT * FROM `appform_experience` WHERE  app_id='$showid'";
												    $result_ex = $conn->query($show3);
												             
													while($fetch_exp = $result_ex->fetch_array())   
												    {
												      	@extract($fetch_exp);
														?>
														<tr id="addr<?php echo $fetch_exp['row_id'];?>">
															<td>
																<?php echo $fetch_exp['e_name'];?>
															</td>
															<td>
																<?php echo $fetch_exp['e_address'];?>
															</td>
															<td>
																<?php echo $fetch_exp['e_post'];?>
															</td>
															<td>
																<?php echo date('d/m/Y', strtotime($fetch_exp['e_from']));?>
															</td>
															<td>
																<?php echo date('d/m/Y', strtotime($fetch_exp['e_to']));?>
															</td>
															<td>
																<?php echo $fetch_exp['j_d'];?>
															</td>
															<!-- <td><?php echo $fetch_exp['e_type'];?></td> -->
															<td>
																<?php echo $fetch_exp['experience'];?>
															</td>
															<!-- <td><?php echo $fetch_exp['pay_type'];?></td> -->
															<!-- <td><?php echo $fetch_exp['pay_scale'];?></td> -->
															<td>
																<?php echo $fetch_exp['month_salary'];?>
															</td>
														</tr>
														<?php
													}
													?>
													<tr id='addr1'> </tr>
												</table>
											</td>
										</tr>
										<tr>
											<td><strong>Total Experience : (Y-m)</strong></td>
											<td colspan="3">
												<div class="col-md-6">
													<?php echo $fetch_detail['total_exp'];?>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="4"><strong>Language Known</strong></td>
										</tr>
										<tr>
											<td colspan="4">
												<table class="table-striped" id="tab_logic2">
													<tr>
														<th>Language</th>
														<th>Status</th>
													</tr>
													<?php
		                          					$show4="SELECT * FROM `appform_language` WHERE  app_id='$showid'";
		                        					$result_lang = $conn->query($show4);
													while($fetch_lang=$result_lang->fetch_array())   
													{
													    @extract($fetch_lang);
														?>
														<tr id="addr<?php echo $fetch_lang['row_id'];?>">
															<td>
																<?php echo $fetch_lang['language'];?>
															</td>
															<td>
																<?php echo $fetch_lang['status'];?>
															</td>
														</tr>
														<?php
													}
													?>
													<tr id='addr1'> </tr>
												</table>
											</td>
										</tr>
										<!-- <tr>
											<td><strong>Extra Curricular activities/professional attainments :</strong>
											<td colspan="2">
												<div class="form-group col-md-6">
													<table>
														<tr>
															<td><strong>Academic</strong></td>
															<td colspan="2">
																<div class="col-md-6">
																	<?php echo $fetch_detail['academic'];?>
																</div>
															</td>
														</tr>
														<tr>
															<td><strong>Publications</strong></td>
															<td colspan="2">
																<div class="col-md-6">
																	<?php echo $fetch_detail['publication'];?>
																</div>
															</td>
														</tr> 
														<tr>
															<td><strong>Sports/literary/cultural activities</strong></td>
															<td colspan="2">
																<div class="col-md-6">
																	<?php echo $fetch_detail['activities'];?>
																</div>
															</td>
														</tr>
														<tr>
															<td><strong>Membership of professional sicieties/organizations/Institutes</strong></td>
															<td colspan="2">
																<div class="col-md-6">
																	<?php echo $fetch_detail['membership'];?>
																</div>
															</td>
														</tr>
													</table>
												</div>
											</td>
										</tr> -->
										<!-- <tr>
											<td>
												<strong>Why do you consider yourself<br>
												suitable for the post !</strong>
											</td>
											<td colspan="2">
												<div class="form-group col-md-6">
													<?php echo $fetch_detail['suitable'];?>
												</div>
											</td>
										</tr> -->
										<!-- <tr>
											<td>
												<strong>Have you any relative employed in <br>
												this company before ? <br>
												If so, name designation and relationship:</strong>
											</td>
											<td colspan="2">
												<div>
													<?php
													/*if($fetch_detail['rel']=="yes")
													{
														echo $fetch_detail['relative_per']; 
													}
													else 
													{
														echo "NO"; 
													}*/
													?>
												</div>
											</td>
										</tr> -->
										<!-- <tr>
											<td colspan="3"><strong>Any defect or impairment in :</strong></td>
										</tr>
										<tr>
											<td><strong>Hearing</strong></td>
											<td colspan="2">
												<div class="col-md-6"><?php echo $fetch_detail['def_h'];?></div>
											</td>
										</tr>
										<tr>
											<td><strong>Sight</strong></td>
											<td colspan="2">
												<div class="col-md-6"><?php echo $fetch_detail['def_s'];?></div>
											</td>
										</tr>
										<tr>
											<td><strong>Limbs<strong></td>
											<td colspan="2">
												<div class="col-md-6"><?php echo $fetch_detail['def_l'];?></div>
											</td>
										</tr> -->
										<tr>
											<td>
												<strong>Physical Handicap </strong>
											</td>
											<td colspan="3">
												<?php if($fetch_detail['ph_percentage'] == 'yes') { echo 'Yes'; } else if($fetch_detail['ph_percentage'] == 'no') { echo "No"; } else { echo ""; } ?>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<strong>Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer </strong>
											</td>
											<td>
												<?php if($fetch_detail['decipline'] == 'yes') { echo 'Yes'; } else if($fetch_detail['decipline'] == 'no') { echo "No"; } else { echo ""; } ?>
											</td>
										</tr>
										<!-- <tr>
											<td><strong>Preferred Place of Interview</strong> :</td>
											<td colspan="2">
												<div class="col-md-6"><?php echo $fetch_detail['inter_place']; ?></div>
											</td>
										</tr> -->
										<!-- <tr>
											<td><strong>Place </strong></td>
											<td colspan="2">
												<div class="col-md-6"><?php echo $fetch_detail['place'];?></div>
											</td>
										</tr> -->
										<tr>
											<td><strong>Date of Submission</strong></td>
											<td colspan="3">
												<div class="col-md-6">
													<?php echo date('d-m-Y', strtotime($fetch_detail['i_date']));?>
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>Image</strong></td>
											<td colspan="3">
												<div class="col-md-6">
													<?php  
													$img_path = $HomeURL.'/upload/advertise/'.$fetch_detail['image_name'];
													?>
													<img src="<?php echo $img_path ;?>" height=80; width=80; alt="avatar">
												</div>
											</td>
										</tr>
										<tr>
											<td><strong>10th Cerificate</strong></td>
											<td colspan="3">
												<div class="col-md-6">
													<?php  
													$sig_path = $HomeURL.'/upload/advertise/'.$fetch_detail['tenth_certificate'];
													?>
													<a href="<?php echo $sig_path ;?>" height=80; width=80; alt="avatar" target="_blank">View</a>
												</div>
											</td>
										</tr>
										<!-- <tr>
											<td><strong>Signature</strong></td>
											<td colspan="2">
												<div class="col-md-6">
												<?php  
												$sig_path = $HomeURL.'/upload/advertise/'.$fetch_detail['signature'];
												?>
												<img src="<?php echo $sig_path ;?>" height=80; width=80; alt="avatar">
												</div>
											</td>
										</tr> -->
										<!-- <tr>
											<td colspan="3" style="font-size:11px;">
												I Declare that I have carefully read and fully understood the various instructions, eligibility criteria and other conditions and I hereby agree to abide by them.<br>

												I declare that all the entries made by me in this application form are true to the best of my knowledge and belief.<br>

												I am aware that if any particular information furnished by me in the application are found to be false/incorrect/wrong, at any stage of recruitment or later, I am liable to be disqualified/cancelled/terminated by National Water Development Agency (NWDA) without
												any notice.<br>

												I have not concealed any information with respect to qualification/work experiance/disciplinary and vigilace action (If applicable).
											</td>
										</tr> -->
										<tr>
											<td colspan="1"><strong>Declaration</strong></td>
											<td colspan="3">
												<?php echo $fetch_detail['read_dec']; ?>
											</td>
										</tr>
										<tr class="back-btn">
											<td>&nbsp;</td>
											<td colspan="3">
												<input type="button" class="button" value="Back" onclick="javascript:history.go(-1)" />
											</td>
										</tr>
									</table>
									<!-- main con-->
									<!-- Footer start -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		include("footer.inc.php");
		?>
		<!-- Footer end -->
		<script type="text/javascript">
			function MM_openBrWindow(theURL,winName,features) 
			{ 
				window.open(theURL,winName,features);
			}
			
			jQuery(document).ready(function(){
			  	function slideout(){
				  	setTimeout(function(){
					  	jQuery("#response").slideUp("slow", function () {
			      		});
		    
					}, 2000);
				}
			
			    jQuery("#response").hide();
				jQuery(function() {
					jQuery("#list ul").sortable({
						opacity: 0.8, cursor: 'move', update: function() {
							var order = jQuery(this).sortable("serialize") + '&update=update' + '&tab=combine'; 
							jQuery.post("updateList.php", order, function(theResponse){
								jQuery("#response").html(theResponse);
								jQuery("#response").slideDown('slow');
								slideout();
							});
						}
					});
				});
			});	

			function editlist(id) {
			    //generate the parameter for the php script
			    var data = 'id=' + id;
			    jQuery.ajax({
			        url: "editid.php",  
			        type: "POST", 
			        data: data,     
			        cache: false,
			        success: function (pub) { 
					 	jQuery('#loading').hide(); 
						var dataid=+pub;
						if(dataid==0)
						{
							var eror='Please valid input Type ';
							
							jQuery('#validterror').html(eror);
							jQuery('#validterror').fadeIn('slow');    
				            //hide the progress bar
						}
						else
						{
							var e='<a href="advertisement.php?editid='+dataid+'" title="Edit"><span class="icon-28-edit"></span>Edit</a>';
							var d='<a href="manage_advertisement.php?deleteid='+dataid+'&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm(\'Are you sure you want to delete this record permanently?\');" title="Delete"><span class="icon-28-delete"></span>Delete</a>';
							//add the content retrieved from ajax and put it in the #content div
				            jQuery('#editer').html(e);
							jQuery('#delete').html(d);
				            //display the body with fadeIn transition
				            jQuery('#editer').fadeIn('slow');    
							jQuery('#delete').fadeIn('slow');
						}
			        }       
			    });
			}

		    function burstCache() {
		        if (!navigator.onLine) {
		            document.body.innerHTML = 'Loading...';
		            window.location = 'index.php';
		        }
		    }

			var a = navigator.onLine;
			if(a){
				// alert('online');
			}else{
				alert('ofline');
				window.location='index.php';
			}

			jQuery(".closestatus").click(function() {
				jQuery("#msgclose").addClass("hide");
			});

			jQuery(".closestatus").click(function() {
				jQuery("#msgerror").addClass("hide");
			});
		</script>
		<style>
			.hide {
				display:none;
			}
		</style>
	</body>
</html>