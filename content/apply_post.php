<?php error_reporting(E_ALL);
   //session_start();
   require_once "../includes/connection.php";
   require_once("../includes/config.inc.php");
   include("../includes/useAVclass.php");
   require_once "../includes/functions.inc.php";
   // include('../design.php');
   // include("../counter.php");
   // require_once "../securimage/securimage.php";
   
   include ("../mpdf/mpdf.php");
   extract($_POST);
   extract($_GET);
   extract($_REQUEST);

   @extract($_POST);
   $useAVclass = new useAVclass();
   $useAVclass->connection();
   $application   = date(dmy);
   $ran           = substr(rand(1000, 9999), 0, 4);
   $applicationno = $ran . $application;
     
   $ptid       = base64_decode(trim($_REQUEST['post']));
   $requestpid = $ptid;
   if ($requestpid != $ptid) {
   	header("Location:" . $HomeURL . "/content/error.php");
   	exit();
   }
     
   $postid    = trim($postid);
   $postedidd = $postid;
   $postid    = content_desc(check_input($postid));
   if ($postedidd != $postid) {
   	header("Location:" . $HomeURL . "/content/error.php");
   	exit();
   }
     
   $pid = base64_decode($postid);
   if (isset($cmdsubmit)) {
    	$p_need = content_desc(check_input($_POST['post_need']));
   	$loop   = content_desc(check_input($_POST['loop']));
   	
    	if ($p_need == 1) {
   		$loop = 4;
   	}
   	if (empty($loop)) {
   		$loop = 3;
   	}
   	/********************* Ratanveer Code *********/
   	if($_POST['post_grad_exam'] == ''){
   		$loops = 3;
   	}else{
   		$loops = 4;
   	}
   	/**********************************************/
   	extract($_POST);
   	$appno     = $applicationno;
   	$firstname      = $_POST['firstname'];
   	$middlename      = $_POST['middlename'];
   	$lastname      = $_POST['lastname'];
   	$name      = $firstname.' '. $middlename.' '.$lastname;
   	
   	$exp_dob = explode('-', $_POST['dob']);
   	$dob = $exp_dob[2].'-'.$exp_dob[1].'-'.$exp_dob[0];
   
   	$exp_idate = explode('-', $_POST['i_date']);
   	$i_date = $exp_idate[2].'-'.$exp_idate[1].'-'.$exp_idate[0];
   	 	$tmp_name            = $_FILES["file"]["tmp_name"];
   	$image_name1         = $_FILES["file"]["name"];
   	$image_name          = $unique . $image_name1;
    	$tenth_certificate1   = $_FILES["tenth_certificate"]["name"];
   	$tenth_certificate    = $unique . $tenth_certificate1;
   	$gate_certificate1   = $_FILES["gate_certificate"]["name"];
   	$gate_certificate    = $unique . $gate_certificate1;
         
   	$imagepath         = "../upload/advertise/" . $image_name;
   	$tenthcerti_tmp_name      = $_FILES["tenth_certificate"]["tmp_name"];
   	$tenth_certificatepath     = "../upload/advertise/" . $tenth_certificate;
   	$gatecerti_tmp_name      = $_FILES["gate_certificate"]["tmp_name"];
   	$gate_certificatepath     = "../upload/advertise/" . $gate_certificate;
   	$consider_tmp_name = $_FILES["w_consider"]["tmp_name"];
   	$consider_name     = $_FILES["w_consider"]["name"];
   	$consider_path     = "../upload/advertise/" . $consider_name;
   	
   	$a_10th = array(
   		$exam_10th,
   		$exam_board_10th,
   		$exam_month_10th,
   		$exam_year_10th,
   		$exam_subj_10th,
   		$exam_div_10th,
   		$exam_perc_10th
   	);
   	
   	$a_12th = array(
   		$exam_12th,
   		$exam_board_12th,
   		$exam_month_12th,
   		$exam_year_12th,
   		$exam_subj_12th,
   		$exam_div_12th,
   		$exam_perc_12th
         );
      
   	$graduatee = array(
   		$grad_exam,
   		$grad_exam_board,
   		$grad_exam_month,
   		$grad_exam_year,
   		$grad_exam_subj,
   		$grad_exam_div,
   		$grad_exam_perc
   	);
   	
   	$post_graduatee = array(
   		$post_grad_exam,
   		$post_exam_board,
   		$post_exam_month,
   		$post_exam_year,
   		$post_exam_subj,
   		$post_exam_div,
   		$post_exam_perc
   	);
         
   	// echo "break 3"; exit();
   	$errmsg = ""; // Initializing the message to hold the error messages
         
   	if (trim($post) == "") {
   		$errmsg .= "Please select post applied for." . "<br>";
   	}
   	
   	if (trim($name) == "") {
   		$errmsg .= "Please enter name." . "<br>";
   	} else if (preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $name) == 0) {
   		$errmsg .= "Name must be from letters that should be minimum 3 and maximum 30." . "<br>";
   	}
   	
   	if (trim($email) == "") {
   		$errmsg .= "Please enter Email Id." . "<br>";
   	} /*elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
   		$errmsg = $errmsg . "Please enter valid email Id." . "<br>";
   	}*/ elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $email)) {
   		$errmsg = $errmsg . "Please enter valid email Id." . "<br>";
   	}
   	
   	$filesize      = $_FILES['file']['size'];
    	$maxsize       = 100000;
   	$maxsize1       = 50000;
   	$maxsize2       = 200000;
   	
   	if ($_FILES["file"]["tmp_name"] == "") {
   		$errmsg .= "Please Upload a Picture.<br>";
   	} elseif ($_FILES["file"]["tmp_name"] != "") {
   		$tempfile  = ($_FILES["file"]["tmp_name"]);
   		$imageinfo = ($_FILES["file"]["type"]);
   		$section   = strtoupper(base64_encode(file_get_contents($tempfile)));
   		$nsection  = substr($section, 0, 8);
             
   		if ($section != strip_tags($section)) {
   			// $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Picture.<br>';
   			$errmsg .= 'Sorry, we only accept JPG and JPEG images For Picture.<br>';
   		} else {
   			//echo $section;die();
   			$imageinfo = getimagesize($_FILES["file"]["tmp_name"]);
                 
   			$extarray = explode(".", $_FILES["file"]["name"]);
   			if (count($extarray) > 2) {
   				$errmsg .= 'Sorry, we only accept JPG and JPEG images For Picture.<br>';
   			} elseif (isset($imageinfo) && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg') {
   			
   				$errmsg .= 'Sorry, we only accept JPG and JPEG images For Picture.<br>';
   			} elseif (($nsection == "/9J/4AAQ") OR ($nsection == "IVBORW0K") OR ($nsection == "R0LGODLH") OR ($nsection == "/9J/4TFN")) {
   			} else {
   				$errmsg .= '';
   			}
   			if ($_FILES["file"]["size"] > $maxsize) {
   				$errmsg .= "Picture should not be greater than 100kb.<br>";
   			}
   		}
   	}
   
   	if ($_FILES["tenth_certificate"]["tmp_name"] == "") {
   		$errmsg .= "Please Upload a 10th Certificate.<br>";
   	} elseif ($_FILES["tenth_certificate"]["tmp_name"] != "") {
   		$tempfile  = ($_FILES["tenth_certificate"]["tmp_name"]);
   		$imageinfo = ($_FILES["tenth_certificate"]["type"]);
   		$section   = strtoupper(base64_encode(file_get_contents($tempfile)));
   		$nsection  = substr($section, 0, 8);
             
   		if ($section != strip_tags($section)) {
   			$errmsg .= 'Sorry, we only accept pdf For 10th Certificate1.<br>';
   		} else {
   				$extarray = explode(".", $_FILES["tenth_certificate"]["name"]);
   			if (count($extarray) > 2) {
   				$errmsg .= 'Sorry, we only accept pdf For 10th Certificate.<br>';
   			} elseif (isset($imageinfo) && $imageinfo != 'application/pdf') {
   					$errmsg .= 'Sorry, we only accept pdf For 10th Certificate.<br>';
   			} elseif (($nsection == "/9J/4AAQ") OR ($nsection == "IVBORW0K") OR ($nsection == "R0LGODLH") OR ($nsection == "/9J/4TFN")) {
   			} else {
   				// $errmsg .= 'Please upload pdf only For 10th Certificate.<br>';
   				$errmsg .= '';
   			}
   			if ($_FILES["tenth_certificate"]["size"] > $maxsize2) {
   				$errmsg .= "10th Certificate should not be greater than 200kb.<br>";
   			}
   		}
   	}
   
   	if ($_FILES["gate_certificate"]["tmp_name"] == "") {
   		$errmsg .= "Please Upload a GATE certificate.<br>";
   	} elseif ($_FILES["gate_certificate"]["tmp_name"] != "") {
   		$tempfile  = ($_FILES["gate_certificate"]["tmp_name"]);
   		$imageinfo = ($_FILES["gate_certificate"]["type"]);
   		$section   = strtoupper(base64_encode(file_get_contents($tempfile)));
   		$nsection  = substr($section, 0, 8);
             
   		if ($section != strip_tags($section)) {
   			$errmsg .= 'Sorry, we only accept pdf For GATE Certificate1.<br>';
   		} else {
   			//echo $section;die();
   			// $imageinfo = getimagesize($_FILES["gate_certificate"]["tmp_name"]);
                 
   			$extarray = explode(".", $_FILES["gate_certificate"]["name"]);
   			if (count($extarray) > 2) {
   				$errmsg .= 'Sorry, we only accept pdf For GATE Certificate.<br>';
   			} elseif (isset($imageinfo) && $imageinfo != 'application/pdf') {
   			// }elseif (isset($imageinfo) && $imageinfo['mime'] != 'application/pdf' && $imageinfo['mime'] != 'application/pdf') {
   				$errmsg .= 'Sorry, we only accept pdf For GATE Certificate.<br>';
   			} elseif (($nsection == "/9J/4AAQ") OR ($nsection == "IVBORW0K") OR ($nsection == "R0LGODLH") OR ($nsection == "/9J/4TFN")) {
   			} else {
   				$errmsg .= '';
   			}
   			if ($_FILES["gate_certificate"]["size"] > $maxsize2) {
   				$errmsg .= "10GATEth Certificate should be between 200kb.<br>";
   			}
   		}
   	}
   	
   	// echo "break 8"; exit();
   	if (trim($par_name) == "") {
   		$errmsg .= "Please enter Father's/Husband's Name." . "<br>";
   	}
   	
   	if (trim($dob) == "") {
   		$errmsg .= "Please select Date of Birth." . "<br>";
   	}
   	
   	if (trim($nation) == "") {
   		$errmsg .= "Please enter Nationality." . "<br>";
   	}
   	
   	if (trim($m_status) == "") {
   		$errmsg .= "Please select marital status." . "<br>";
   	}
         
   	if (trim($c_address) == "") {
   		$errmsg .= "Please enter Present Address." . "<br>";
   	}
         
   	if (trim($mobile) == "") {
   		$errmsg .= "Please enter Phone Number." . "<br>";
   	}
   	if (!is_numeric(trim($mobile))) {
   		$errmsg .= "Phone number should be numeric." . "<br>";
   	}
         
   	if (trim($ph_percentage) == "") {
   		$errmsg .= "Please select Physical Handicap." . "<br>";
   	}
         
   	/*if (trim($inter_place) == "") {
   		$errmsg .= "Please select Preferred Place of Interview." . "<br>";
   	}
         
   	if (trim($place) == "") {
   		$errmsg .= "Please select Place." . "<br>";
   	}*/
   	$considerinfo = $_FILES["w_consider"]["type"];
   	/* if (trim($total_exp) == "" || trim($total_exp) == "NaN year and NaN month") {
   		$errmsg .= "Please Select Individual experience or Total Experience." . "<br>";
   	} */
   	if (empty($_POST['lang'][0])) {
   		$errmsg .= "One Language must Fill." . "<br>";
   	}
   	if ($errmsg != '') {
   		// $errmsg .= "Please Select Post Again And Fill the experience And rest Empty Mandatory field" . "<br>";
   		$errmsg .= "Please select post again and rest empty field mandatory." . "<br>";
   	}
   	
   	// echo "break 9"; exit();
   	// echo $errmsg ;
   	// die;
   	if ($errmsg == '') {
   		move_uploaded_file($tmp_name, $imagepath);
   		// move_uploaded_file($sig_tmp_name, $signaturepath);
   		move_uploaded_file($tenthcerti_tmp_name, $tenth_certificatepath);
   		move_uploaded_file($gatecerti_tmp_name, $gate_certificatepath);
   		move_uploaded_file($consider_tmp_name, $consider_path);
   		//first part and last part
   		
   		$tableName_send         = "appform_detail";
   		$tableFieldsName_send   = array(
   			"app_no",
   			"post",
   			"advertisement_no",
   			"name",
   			"email",
   			"opt_email",
   			"gender",
   			"par_name",
   			"dob",
   			"nation",
   			"age",
   			"m_status",
   			"c_address",
   			"p_address",
   			"mobile",
   			"category",
   			"other_qualification",
   			// "typeingspeed",
   			"total_exp",
   			"image_name",
   			// "signature",
   			"suitable",
   			// "suitable_pdf",
   			"rel",
   			"relative_per",
   			"def_h",
   			"def_s",
   			"def_l",
   			"decipline",
   			"inter_place",
   			"place",
   			"i_date",
   			"academic",
   			"publication",
   			"activities",
   			"membership",
   			"ph_percentage",
   			"gate_score",
   			"enter_score",
   			"tenth_certificate",
   			"gate_certificate",
   			"discipline_against",
   			"read_dec"
   		);
             
   		$tableFieldsValues_send = array(
   			"$appno",
   			"$post",
   			"$advertisement_no",
   			"$name",
   			"$email",
   			"$opt_email",
   			"$gender",
   			"$par_name",
   			"$dob",
   			"$nation",
   			"$age",
   			"$m_status",
   			"$c_address",
   			"$p_address",
   			"$mobile",
   			"$category",
   			"$other_qualification",
   			// "$typeingspeed",
   			"$total_exp",
   			"$image_name",
   			// "$signature",
   			"$suitable",
   			// "$consider_name",
   			"$rel",
   			"$relative_per",
   			"$def_h",
   			"$def_s",
   			"$def_l",
   			"$decipline",
   			"$inter_place",
   			"$place",
   			"$i_date",
   			"$academic",
   			"$publication",
   			"$activities",
   			"$membership",
   			"$ph_percentage",
   			"$gate_score",
   			"$enter_score",
   			"$tenth_certificate",
   			"$gate_certificate",
   			"$discipline_against",
   			"$read_dec"
   		);
   		// echo "<pre>";print_r($tableFieldsName_send);
   		// echo "<pre>";print_r($tableFieldsValues_send);die;
   		$useAVclass->insertQuery($tableName_send, $tableFieldsName_send, $tableFieldsValues_send);
   		$id = mysql_insert_id(); 
   		// echo "break 10"; exit();
   		//second part exam  
   		$tableName_send2       = "appform_qualification";
   		$tableFieldsName_send2 = array(
   			"app_id",
   			"exam",
   			"board",
   			"pass_month",
   			"pass_year",
   			"subject",
   			"divison",
   			"marks"
   		);
   		//echo $loops;die;
   		for ($i = 1; $i <= $loops; $i++) {
   			if ($i == 1) {
   				$arr = $a_10th;
   			} elseif ($i == 2) {
   				$arr = $a_12th;
   			} elseif ($i == 3) {
   				$arr = $graduatee;
   			} elseif ($i == 4) {
   				$arr = $post_graduatee;
   			}
   			$tableFieldsValues_send2[] = $id;
   			for ($j = 0; $j < count($arr); $j++) {
   				$tableFieldsValues_send2[] = $arr[$j];
                     
   				if ($j == count($arr) - 1) {
   					//print_r($tableFieldsValues_send2);die;
   					$useAVclass->insertQuery($tableName_send2, $tableFieldsName_send2, $tableFieldsValues_send2);
   					unset($tableFieldsValues_send2);
   				}
   			}
   		}
   		// echo "break 11"; exit();
   		//part 3
   		
   		if (!empty($_POST['e_name'][0])) {
   			$tableName_send3       = "appform_experience";
   			$tableFieldsName_send3 = array(
   				"app_id",
   				"e_name",
   				"e_address",
   				"e_post",
   				"e_from",
   				"e_to",
   				"j_d",
   				"e_type",
   				"experience",
   				"pay_type",
   				"pay_scale",
   				"gross_salary",
   				"month_salary"
   			);
   			for ($i = 0; $i < count($_POST['e_name']); $i++) {
   				if (!empty($_POST['e_name'][$i])) {
   					$exp_efrom = explode('-', $_POST['e_from'][$i]);
   					$exp_eto = explode('-', $_POST['e_to'][$i]);
   					// $e_from = $exp_efrom[2].'-'.$exp_efrom[1].'-'.$exp_efrom[0];
   					
   					$e_name = $_POST['e_name'][$i];
                         
   					$e_address  = $_POST['e_address'][$i];
   					$e_post     = $_POST['e_post'][$i];
   					$e_from     = $exp_efrom[2].'-'.$exp_efrom[1].'-'.$exp_efrom[0];
   					$e_to       = $exp_eto[2].'-'.$exp_eto[1].'-'.$exp_eto[0];
   					$j_d        = $_POST['j_d'][$i];
   					$e_type     = $_POST['e_type'][$i];
   					$experience = $_POST['experience'][$i];
   
   					$pay_type = $_POST['pay_type'][$i];
   
   					// $pay_scale               = $_POST['pay_scale'][$i];
   					$pay_scale               = 0;
   					$month_salary            = $_POST['month_salary'][$i];
   					$gross_salary            = $_POST['gross_salary'][$i];
   					$tableFieldsValues_send3 = array(
   						"$id",
   						"$e_name",
   						"$e_address",
   						"$e_post",
   						"$e_from",
   						"$e_to",
   						"$j_d",
   						"$e_type",
   						"$experience",
   						"$pay_type",
   						"$pay_scale",
   						"$gross_salary",
   						"$month_salary"
   					);
   					$useAVclass->insertQuery($tableName_send3, $tableFieldsName_send3, $tableFieldsValues_send3);
   				}
   			}
   		}
             
   		// echo "break 13"; exit();
   		//PART4
   		
   		if (!empty($_POST['lang'][0])) {
   			$tableName_send4       = "appform_language";
   			$tableFieldsName_send4 = array(
   				"app_id",
   				"language",
   				"status",
   				"certificate"
   			);
   			for ($i = 0; $i < count($_POST['lang']); $i++) {
   				if (!empty($_POST['lang'][$i])) {
   					$lang = $_POST['lang'][$i];
                         
   					$status                  = $_POST['status'][$i];
   					$certificate             = $_POST['exam_pass'][$i];
   					$tableFieldsValues_send4 = array(
   						"$id",
   						"$lang",
   						"$status",
   						"$certificate"
   					);
   					$useAVclass->insertQuery($tableName_send4, $tableFieldsName_send4, $tableFieldsValues_send4);
   				}
   			}
   		}
   		// echo "Ratan";die;
   		$sqlPost=mysql_query("SELECT postname, advertisement_no FROM `post_mst` WHERE  post_id = '$post' ");
   		while ($postPost = mysql_fetch_assoc($sqlPost)) {
   			@extract($postPost);
   		}
   		$catRes=mysql_query("SELECT c_name FROM `category_master` WHERE `c_id` ='$category' ");
   		while ($catRow = mysql_fetch_assoc($catRes)) {
   			@extract($catRow);
   		}
   		$monthList = array("1"=>"Janaury","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
   		if (array_key_exists($exam_month_10th, $monthList)) {
   			$exam_month_10th = $monthList[$exam_month_10th];
   		}
   		if (array_key_exists($exam_month_12th, $monthList)) {
   			$exam_month_12th = $monthList[$exam_month_12th];
   		}
   		if (array_key_exists($grad_exam_month, $monthList)) {
   			$grad_exam_month = $monthList[$grad_exam_month];
   		}
   		if (array_key_exists($post_exam_month, $monthList)) {
   			$post_exam_month = $monthList[$post_exam_month];
   		}
   		// echo "Ratan1";die;
   		$getQual = mysql_query("SELECT `Qualification_list`, `qualification_id` FROM `qualification_mst` WHERE `qualification_id` = '$grad_exam'");
   
   		$resQual = mysql_fetch_assoc($getQual);
   		
   		$getPqual = mysql_query("SELECT `Qualification_list`, `qualification_id` FROM `qualification_mst` WHERE `qualification_id` = '$post_grad_exam'");
   		$resPqual = mysql_fetch_assoc($getPqual);
   
   		// echo "break 14"; exit();
   		//echo "SELECT `Qualification_list`, `qualification_id` FROM `qualification_mst` WHERE `qualification_id` = '$post_grad_exam'";
   		// die;
   		$age_on_que = "SELECT `age` FROM `post_mst` where   post_id='".$post."'";
   		$dadt_age_on_que = mysql_query($age_on_que);
   		$row_age_on_que = mysql_fetch_array($dadt_age_on_que, MYSQL_ASSOC);
   		$age_o_date = date('d-m-Y', strtotime($row_age_on_que['age']));
   		
   		$dob = date('d-m-Y', strtotime($dob));
   		//https://45.115.99.201/nwda/images/emblem.png
   		$html = '<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5">
   			<tr>
   				<td colspan="1"><img src="'.$HomeURL.'/images/emblem.png" id="logo" style="width: 50px;"></td>
   				<td colspan="2"><h3>National Water Development Agency</h3></td>
   			</tr>
   		</table>';
   		
   		$html .= '<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
   			<!-- <tr>
   				<td colspan="3"><h3>National Water Development Agency</h3></td>
   			</tr> -->
   			<tr>
   				<td>Application Number</td>
   				<td>'.$appno.' </td>
   				<td rowspan="5" align="center">
   					<img src="'.$HomeURL.'/upload/advertise/'.$image_name.'" class="avatar img-circle img-thumbnail" alt="avatar"width="125px" height="125px">
   				</td>
   			</tr>
   			<tr>
   				<td>Post Applied For</td>
   				<td>'.$postname.' </td>
   			</tr>
   			<tr>
   				<td>Advertisement No.</td>
   				<td>'.$advertisement_no.' </td>
   			</tr>
   			<tr>
   				<td>1.Name of the Applicant</td>
   				<td>'.$name.'</td>
   			</tr>
   			<tr>
   				<td>2.Email Id</td>
   				<td>'.$email.'</td>
   			</tr>
   			<!--<tr>
   				<td>3.Optional Email Id</td>
   				<td>'.$opt_email.'</td>
   			</tr>-->
   			<tr>
   				<td>4.Gender</td>
   				<td>'.$gender.'</td>
   			</tr>
   			<tr>
   				<td>5.Father\'s/Husband\'s Name</td>
   				<td colspan="2">'.$par_name.'</td>
   			</tr>
   			<tr>
   				<td>6.Date of Birth: '.$dob.'</td>
   				<td>7.Nationality: '.$nation.'</td>
   				<td>8.Marital Status: '.$m_status.'</td>
   			</tr>
   			<tr>
   				<td colspan="3">Age as on :-</strong> <span>'. $age_o_date.'</span>:'.$age.'
   				</td>
   			</tr>
   			<tr>
   				<td colspan="3">9.(i)Present Address:'.$c_address.'
   				</td>
   			</tr>
   			<tr>
   				<td colspan="3">(ii)Permanent Address:'.$p_address.'</td>
   			</tr>
   			<tr>
   				<td>10.Phone No.</td>
   				<td colspan="2">'.$mobile .'</td>
   			</tr>
   			<tr>
   				<td>11.Category</td>
   				<td colspan="2">'.$c_name.'</td>
   			</tr>
   			<tr>
   				<td>Physical Handicap (Is More than 40%)</td>
   				<td colspan="2">'.ucfirst($ph_percentage).'</td>
   			</tr>
   			<tr>
   				<td colspan="3">12.Qualification (Matriculation onward) (10<sup>th</sup>,12<sup>th</sup>/Diploma and Degree Qualifications are mandatory)</td>
   			</tr>
   			<tr>
   				<td colspan="3">
   					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
   						<thead>
   							<tr>
   								<td>Examination Passed</td>
   								<td>Name of Universtiy Board</td>
   								<td>Month of Passing</td>
   								<td>Year of passing</td>
   								<td>Subjects</td>
   								<td>Division</td>
   								<td>% of Mark</td>
   							</tr>
   							<tr>
   								<td>'.$exam_10th.'</td>
   								<td>'.$exam_board_10th.'</td>
   								<td>'.$exam_month_10th.'</td>
   								<td>'.$exam_year_10th.'</td>
   								<td>'.$exam_subj_10th.'</td>
   								<td>'.$exam_div_10th.'</td>
   								<td>'.$exam_perc_10th.'</td>
   							</tr>
   							<tr>
   								<td>'.$exam_12th.'</td>
   								<td>'.$exam_board_12th.'</td>
   								<td>'.$exam_month_12th.'</td>
   								<td>'.$exam_year_12th.'</td>
   								<td>'.$exam_subj_12th.'</td>
   								<td>'.$exam_div_12th.'</td>
   								<td>'.$exam_perc_12th.'</td>
   							</tr>
   							<tr>
   								<td>'.$resQual['Qualification_list'].'</td>
   								<td>'.$grad_exam_board.'</td>
   								<td>'.$grad_exam_month.'</td>
   								<td>'.$grad_exam_year.'</td>
   								<td>'.$grad_exam_subj.'</td>
   								<td>'.$grad_exam_div.'</td>
   								<td>'.$grad_exam_perc.'</td>
   							</tr>
   							<tr>
   								<td>'.$resPqual['Qualification_list'].'</td>
   								<td>'.$post_exam_board.'</td>
   								<td>'.$post_exam_month.'</td>
   								<td>'.$post_exam_year.'</td>
   								<td>'.$post_exam_subj.'</td>
   								<td>'.$post_exam_div.'</td>
   								<td>'.$post_exam_perc.'</td>
   							</tr>
   						</tbody>
   					</table>
   				</td>
   			</tr>
                  <tr>  
                      <td>Other Qualification :</td>
                      <td colspan="2">'.$other_qualification.'</td>
                  </tr>
   			<tr>  
                      <td>GATE Qualifying Year:</td>
                      <td colspan="2">'.$gate_score.'</td>
                  </tr>
   			<tr>  
                      <td>GATE Score :</td>
                      <td colspan="2">'.$enter_score.'</td>
                  </tr>
   			<tr>  
                      <td>GATE Score Card :</td>
                      <td colspan="2"><a href ="'.$HomeURL.'/upload/advertise/'.$gate_certificate.'" class="avatar" alt="avatar"width="125px" height="125px">View</a></td>
                  </tr>
                  <tr>
   				<td colspan="3">13.Post Qualifcation Experience After(<span class="star" id="post_qual"></span>) (<span class="star" id="post_exp"></span>)(From Current Employment to Past Employment.)</td>
                  </tr>
   			<tr>
   				<td colspan="3" width="100px">
   					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
   						<tr>
   							<td>Employer Name</td>
   							<td>Address of employer</td>
   							<td>Post Held</td>
   							<td>From</td>
   							<td>To</td>
   							<td>Job Description</td>
   							<td>Individual Exp</td>
   							<td>Gross Pay</td>
   						</tr>';
   						for ($i = 0; $i < count($_POST['e_name']); $i++) {
   							if (!empty($_POST['e_name'][$i])) {
   								$html .='<tr id="addr0">
                                          <td>'.$_POST['e_name'][$i].'</td>
                                          <td>'.$_POST['e_address'][$i].'</td>
                                          <td>'.$_POST['e_post'][$i].'</td>
                                          <td>'.$_POST['e_from'][$i].'</td>
                                          <td>'.$_POST['e_to'][$i].'</td>
                                          <td>'.$_POST['j_d'][$i].'</td>
                                          <td>'.$_POST['experience'][$i].'</td>
                                          <td>'.$_POST['month_salary'][$i].'</td>
                                      </tr>';
   							}
   						}
   					$html .='</table>
                          </div>
                      </td>
                  </tr>
   			<tr>
   				<td><label for="total_exp">Total Experience</label> :(Y-m)</td>
   				<td colspan="2">'.$total_exp.'</td>
   			</tr>
   			<tr>
   				<td colspan="3">14.Language Known:</td>
   			</tr>
   			<tr>
   				<td style="width: 33%">Language</td>
   				<td colspan="2" style="width: 33%">Status</td>
   			</tr>';
                  for ($i = 0; $i < count($_POST['lang']); $i++) {
   				if (!empty($_POST['lang'][$i])) {
   					$html .= '<tr id="addr02">
                              <td style="width: 33%">'.$_POST['lang'][$i].'</td>
                              <td colspan="2" style="width: 33%">'.$_POST['status'][$i].'</td>
                          </tr>';
   				}
   			}
   		
   			if($decipline == 'yes') {
   				$txt_dec = "Yes";
   				$decactagnst = '<tr><td colspan="1">What disciplinary action taken against you: </td><td colspan="2">'.$discipline_against.'</td></tr>';
   			} else if($decipline == 'no') {
   				$txt_dec = "No";
   				$decactagnst = '';
   			} else {
   				$txt_dec = '';
   				$decactagnst = '';
   			}
   
   			if ($read_dec == 'Yes') {
   				$read_dec = $read_dec;
   				// $fcs = 'colspan="2"';
   				// $decy = "<td>Yes, I have read the declaration carefully.</td>";
   			} else {
   				$read_dec = '';
   				// $fcs = 'colspan="3"';
   				// $decy = "";
   			}
   
   			$i_date = date('d-m-Y', strtotime($i_date));
   
   			$html .= '
   			<!-- <tr>
   				<td>a.GATE Year '.$gate_score.'</td>
   				<td>b.GATE Score '.$enter_score.'</td>
   				<td><a href ="'.$HomeURL.'/upload/advertise/'.$gate_certificate.'" class="avatar" alt="avatar"width="125px" height="125px">View GATE Certificate</a></td>
   			</tr>-->
   			<tr>
   				<td colspan="3">15.Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer: '.$txt_dec.'</td>
   			</tr>
   			'.$decactagnst.'
   			<tr>
   				<td>Date</td>
   				<td colspan="2">'. $i_date.'</td>
   			</tr>
   			<tr>
   				<td>10th Certificate</td>
   				<td colspan="2" align="center">
   					<a href ="'.$HomeURL.'/upload/advertise/'.$tenth_certificate.'" class="avatar img-circle img-thumbnail" alt="avatar"width="125px" height="125px">View</a>
   				</td>
   			</tr>
   			<!-- <tr>
   				<td>Signature</td>
   				<td colspan="2" align="center">
   					<img src="'.$HomeURL.'/upload/advertise/'.$signature.'" class="avatar img-circle img-thumbnail" alt="avatar"width="125px" height="125px">
   				</td>
   			</tr> -->
   			<tr>
   				<td colspan="3">
   					Declaration<br>
   					<p>
   					'.$read_dec.', I Declare that I have carefully read and fully understood the various instructions, eligibility criteria and other conditions and I hereby agree to abide by them.<br><br>
   					I declare that all the entries made by me in this application form are true to the best of my knowledge and belief.<br><br>
   					I am aware that if any particular information furnished by me in the application are found to be false/incorrect/wrong, at any stage of recruitment or later, I am liable to be disqualified/cancelled/terminated by National Water Development Agency (NWDA) without any notice.<br>
   	                I have not concealed any information with respect to qualification/work experiance/disciplinary and vigilace action (If applicable).
   					</p>
   				</td>
   			</tr>
   		</table>';
   		//echo "break 15"; 
   		// echo $html;
   		$mpdf=new mPDF('win-1252','A4','','',20,15,10,5,10,10);
   		//echo "<pre>"; print_r($mpdf); die;
   		$mpdf->curlAllowUnsafeSslRequests = true;
   		$target = "Application_form.pdf";  
   		$mpdf->WriteHTML($html);
   		$mpdf->Output($target,'D');
   	   
   		
   		// $msg                  = Application_Complete;
   		// echo "break 17"; die;
   		$msg                  = 'Thank you for applying this job. Your application has been successfully submitted.';
   		
   		$_SESSION['sess_msg'] = $msg;
   		// echo $_SESSION['sess_msg'];
   		// $send = base64_encode($id);
   		header("location: content/vacancy_list.php");
   		exit;
   	}
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="keywords" content="Apply Post" />
      <meta name="description" content="Apply for various Post" />
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>National Water Development Agency</title>
      <!-- Bootstrap -->   
      <script src="<?php echo $HomeURL;?>/js/jquery.min.js"></script>
      <script src="<?php echo $HomeURL;?>/js/notify.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> <!-- added by bhola -->
      <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
      <script src="<?php echo $HomeURL;?>/js/swithcer.js"></script>
      <script type="text/javascript" src="<?php echo $HomeURL;?>/js/font-size.js"></script> 
      <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
      <script src="<?php echo $HomeURL;?>/js/bootstrap-datepicker.min.js"></script> <!-- added by bhola -->
      <script src="<?php echo $HomeURL;?>/js/swithcer.js"></script>
      <script type="text/javascript" src="<?php echo $HomeURL;?>/js/font-size.js"></script> 
      <script type="text/javascript" src="<?php echo $HomeURL;?>/js/validation.js"></script>
      <link href="<?php echo $HomeURL;?>/css/bootstrap-datepicker.min.css" rel="stylesheet">
      <!-- added by bhola -->
      <link href="<?php echo $HomeURL;?>/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/bootstrap-theme.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/bootstrap-theme.min.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/style.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/responsive.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/jquery.treeview.css" rel="stylesheet">
      <link href="<?php echo $HomeURL;?>/css/high.css" rel="alternate stylesheet" type="text/css" media="screen" title="change" />
      <link href="<?php echo $HomeURL;?>/css/blue.css" rel="alternate stylesheet" type="text/css" media="screen" title="blue" />
      <link href="<?php echo $HomeURL;?>/css/green.css" rel="alternate stylesheet" type="text/css" media="screen" title="green" />
      <link href="<?php echo $HomeURL;?>/css/orange.css" rel="alternate stylesheet" type="text/css" media="screen" title="orange" />
      <link rel="stylesheet" href="<?php echo $HomeURL;?>/css/lightbox.css" type="text/css" media="screen" />
      <link href="<?php echo $HomeURL;?>/css/print.css" media="print" rel="stylesheet" type="text/css" />
      <style>
         table td {
         /*border: 1px solid #015198;*/ 
         /*font-size: 14px;
         text-align: left !important; 
         font-size:13px;
         width:200px;*/
         }
         .about-child {
         display: block !important;
         }
         span.help-text {
         font-size: 9px;
         color: #000;
         }
         .no-padding{
         padding: 0px;
         }
         input[type="text"],input[type=file]{
         width: 100%;
         }
         div#myModal .modal-dialog {
         width: 80%;
         }
         .prelabel-text {
         float: left;
         /*margin-right: 10px;*/
         margin-bottom: 0;
         width: 100%;
         }
         .label-inline {
         /*display: inline-flex;*/
         }
         hr {
         margin-top: 0px;
         margin-bottom: 0px;
         }
      </style>
   </head>
   <?php
      $yearList = array("2020","2019","2018","2017","2016","2015","2014","2013","2012","2011","2010","2009","2008","2007","2006","2005","2004","2003","2002","2001","2000","1999","1998","1997","1996","1995","1994","1993","1992","1991","1990","1989","1988","1987","1986","1985","1984","1983","1982","1981","1980","1979","1978","1977","1976","1975","1974","1973","1972","1971","1970","1969","1968","1967","1966","1965","1964","1963","1962","1961","1960"); 
      $monthList = array("1"=>"Janaury","2"=>"February","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"August","9"=>"September","10"=>"October","11"=>"November","12"=>"December");
      ?>
   <body id="fontSize" onLoad="fetch_education(<?php  echo $ptid; ?>)">
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
               <!-- <div class="col-sm-3 left-navigation">
                  <?php include("leftmenu.php");?>
                  </div> -->
               <div class="col-sm-12 inner">
                  <div class="">
                     <ul class="breadcrumb">
                        <li><a href="<?php echo $HomeURL;?>">Home</a></li>
                        <li>Assistant Engineer Application Form </li>
                        <li class="pull-right">
                           <button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button>
                     </ul>
                  </div>
                  <?php
                     if (isset($errmsg) && $errmsg != '') {
                     	echo "<span style=\"color: #ff0000;\">";
                     	echo $errmsg;
                     	echo "</span>";
                     }
                     ?>
                  <div class="col-sm-12">
                     <form action="apply_post.php" method="post" name="form1" autocomplete="off" id="feedback-form" enctype="multipart/form-data" >
                        <div class="row">
                           <div class="col-md-9 no-padding">
                              <div class="row">
                                 <div class="col-md-6 col-sm-12" style="padding-left: 30px;">
                                    <h5>Post Applied For</h5>
                                    <select required="" id="select_post" name="post" class=" form-control">
                                       <?php 
                                          $sqlVacancy=mysql_query("SELECT post_id as postId , postname as postTitle, advertisement_no FROM `post_mst` WHERE `approve_status` = '1' and post_id = '$ptid'");
                                          if (count($sqlVacancy) > 0) {
                                          	while ($postApplied = mysql_fetch_assoc($sqlVacancy)) {
                                          		@extract($postApplied);
                                          
                                          		if (isset($errmsg) && $errmsg != '') {
                                          			if ($postId == $_POST['post']) {
                                          				$post_sel = 'selected';
                                          			} else {
                                          				$post_sel = '';
                                          			}
                                          		} else {
                                          			$post_sel = '';
                                          		}
                                          		?>
                                       <option value="<?=$postId?>" <?php echo $post_sel; ?>><?=$postTitle?></option>
                                       <?php
                                          }
                                          } else { ?>
                                       <option value="">No post found.</option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                 <div class="col-md-6 col-sm-12" style="padding-right: 30px;">
                                    <h5>Advertisement No.<span class="star">*</span></h5>
                                    <?php
                                       $sqladv = mysql_query("SELECT advertisement_no FROM `post_mst` WHERE `approve_status` = '1' and post_id = '$ptid'");
                                       $postadvno = mysql_fetch_assoc($sqladv); ?>
                                    <input class="form-control" type="text" name="advertisement_no" id="advertisement_no" value="<?php if (isset($postadvno['advertisement_no']) && $postadvno['advertisement_no'] != '') { echo $postadvno['advertisement_no']; } else { echo ""; } ?>" placeholder="Advertisement No." readonly>
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>1. First Name<span class="star">*</span></h5>
                                 <input class="form-control alphaSpc" type="text" name="firstname" id="firstname" value="<?php if (isset($errmsg) && $errmsg != '') { echo $_POST['firstname']; } ?>" data-req="Yes" placeholder="First Name">
                                 <div class="error-firstname"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>2.Middle Name</h5>
                                 <input class="form-control alphaSpc" type="text" name="middlename" id="middlename" value="<?php if (isset($errmsg) && $errmsg != '') { echo $_POST['middlename']; } ?>" placeholder="Middle Name">
                                 <div class="error-middlename"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>3.Last Name</h5>
                                 <input class="form-control alphaSpc" type="text" name="lastname" id="lastname" value="<?php if (isset($errmsg) && $errmsg != '') { echo $_POST['lastname']; } ?>" placeholder="Last Name">
                                 <div class="error-lastname"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>4.Email Id<span class="star">*</span></h5>
                                 <input class="form-control validEmail" type="text" name="email" id="email" value="<?php if (isset($errmsg) && $errmsg != '') { echo $_POST['email']; } ?>" data-req="Yes" placeholder="Enter Email">
                                 <div class="error-email"></div>
                              </div>
                              <div class="clearfix"></div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>5.Gender <span class="star">*</span></h5>
                                 <select required name="gender" class=" form-control" id="gender" data-req="Yes">
                                    <option value="">Select Gender</option>
                                    <option <?php if (isset($errmsg) && $errmsg != '' && $_POST['gender'] == 'Male') { echo "selected"; } ?>>Male</option>
                                    <option <?php if (isset($errmsg) && $errmsg != '' && $_POST['gender'] == 'Female') { echo "selected"; } ?>>Female</option>
                                    <option <?php if (isset($errmsg) && $errmsg != '' && $_POST['gender'] == 'Other') { echo "selected"; } ?>>Other</option>
                                 </select>
                                 <div class="error-gender"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>6.Father's/Husband's Name<span class="star">*</span></h5>
                                 <!-- onblur="return commanValidation(this)" -->
                                 <input class="form-control alphaSpc" id="parent_name" type="text" name="par_name" value="<?php if (isset($errmsg) && $errmsg != '') { echo $_POST['par_name']; } ?>" data-req="Yes" required="">
                                 <span id="par_name" class="validation_error"></span>
                                 <div class="error-parent_name"></div>
                                 <div class="error-par_name"></div>
                              </div>
                              <!-- <hr> -->
                              <div class="col-md-3 col-sm-12">
                                 <h5>7.Date of Birth <span class="star">*</span></h5>
                                 <input type="text" name="dob" id="example1" placeholder="click to show datepicker" class="form-control validDate" value="" data-req="Yes"  required>
                                 <div class="error-example1"></div>
                                 <div class="error-dob"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>8.Category<span class="star">*</span></h5>
                                 <select id="category" name="category" class=" form-control" onchange="fetch_age_fe(this.value)" required="" data-req="Yes">
                                    <?php 
                                       $catSql= "SELECT * FROM `category_master` WHERE `status` ='1' ";
                                       $catRes=mysql_query($catSql);
                                       ;
                                       if (count($catRes)>0) { ?>
                                    <option value="">-Select-</option>
                                    <?php 
                                       while ($catRow=mysql_fetch_assoc($catRes)) {
                                       
                                       	if (isset($errmsg) && $errmsg != '') {
                                       		if ($catRow['c_id'] == $_POST['category']) {
                                       			$cat_sel = 'selected';
                                       		} else {
                                       			$cat_sel = '';
                                       		}
                                       	} else {
                                       		$cat_sel = '';
                                       	}
                                       	?>
                                    <option value="<?=$catRow['c_id']?>" <?php echo $cat_sel; ?>><?=$catRow['c_name']?></option>
                                    <?php }
                                       } else { ?>
                                    <option value="">No category found.</option>
                                    <?php } ?>
                                 </select>
                                 <div class="error-category"></div>
                              </div>
                              <div class="clearfix"></div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>9.Nationality<span class="star">*</span></h5>
                                 <input class="form-control" type="text" name="nation" id="nationality" onblur="return commanValidation(this)" value="Indian" data-req="Yes">
                                 <span id="nation" class="validation_error"></span>
                                 <div class="error-nation"></div>
                                 <div class="error-nationality"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>Age as on <b><span id="show_age_on"></span></b></h5>
                                 <input type="hidden" value="" id="fetch_age_on" name="fetch_age_on">
                                 <input class="form-control" type="text" id="age" name="age" value="<?php echo $_POST['age'];?>" readonly>
                                 <input type="hidden" name="" id="hid_age">
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>10.Marital Status<span class="star">*</span><b><span id="show_age_on"></span></b></h5>
                                 <select name="m_status" class=" form-control" id="m_status" data-req="Yes" required="">
                                    <option value="">Select</option>
                                    <option>Married</option>
                                    <option>Unmarried</option>
                                 </select>
                                 <div class="error-m_status"></div>
                              </div>
                              <div class="col-md-3 col-sm-12">
                                 <h5>11.Contact No.<span class="star">*</span></h5>
                                 <!-- onblur="return mobileValidation(this)" -->
                                 <input class="form-control validMobileNo" id="mobile" type="text" name="mobile" value="" data-req="Yes" maxlength="10" required="">
                                 <div class="error-mobile"></div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="col-md-3 text-center">
                              <span class="star">*</span>
                              <img src=<?php echo $HomeURL;?>/images/1.jpg class="avatar img-circle img-thumbnail" id="show-file" alt="avatar" style="width: 125px;height: 125px;">
                              <h6>Upload the latest photo</h6>
                              <input type="file" class="text-center center-block well well-sm upldJpgImgFile checkFileSize" name="file" id="file" onchange="getChangeImg(this, 'file')" min="" max="100" required="" style="margin-bottom: 0px; padding: 4px;">
                              <span class="help-text">(Only jpeg, jpg format and Max Size 100 KB)</span>
                              <div class="error-file"></div>
                           </div>
                           <div class="col-md-12 col-sm-12 no-padding">
                              <div class="col-md-6 col-sm-12">
                                 <h5>(i)Present Address(With Pincode)<span class="star">*</span></h5>
                                 <div class="form-group">
                                    <textarea class="form-control" rows="3" data-req="Yes" id="caddress" name="c_address" onblur="return alphanumeric(this)" required=""></textarea>
                                    <span id="c_address" class="validation_error"></span>
                                    <div class="error-caddress"></div>
                                    <div class="error-c_address"></div>
                                 </div>
                                 <!--  onchange="same_add()" -->
                                 <input type="checkbox" id="same_add"><span style="margin-left: 10px;">check if both addresses are same.</span>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                 <h5>(ii)Permanent Address(With Pincode)</h5>
                                 <div class="form-group">
                                    <textarea class="form-control" onblur="return alphanumeric(this)" rows="3" id="paddress" name="p_address"></textarea><span id="p_address" class="validation_error"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <h5> 12.Qualification (Matriculation onwards - 10<sup>th</sup> , 12<sup>th</sup>/Diploma and Degree in Civil Engineering are mandatory) <span class="star">*</span></h5>
                           </div>
                           <div class="col-md-12 no-padding">
                              <div class="col-md-2 col-md-12">
                                 <h5>Examination Passed</h5>
                              </div>
                              <div class="col-md-2 col-md-12">
                                 <h5>Name of Universtiy Board</h5>
                              </div>
                              <div class="col-md-2 col-md-12">
                                 <h5>Month of Passing</h5>
                              </div>
                              <div class="col-md-2 col-md-12">
                                 <h5>Year of passing</h5>
                              </div>
                              <div class="col-md-2 col-md-12">
                                 <h5>Subjects</h5>
                              </div>
                              <div class="col-md-1 col-md-12">
                                 <h5>Division</h5>
                              </div>
                              <div class="col-md-1 col-md-12">
                                 <h5>% of Mark</h5>
                              </div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_10th" value="10th" id="tenth_exam" data-req="Yes" readonly="">
                              <span id="exam_10th" class="validation_error"></span>
                              <div class="error-tenth_exam"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_board_10th" onblur="return alphanumeric(this)" value="" class="form-control" id="tenth_exam_board" data-req="Yes" required="">
                              <span id="exam_board_10th" class="validation_error"></span>
                              <div class="error-tenth_exam_board"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="exam_month_10th" id="Month1" class="form-control" data-req="Yes" required="">
                                 <option value="">Select Month</option>
                                 <?php foreach ($monthList as $key => $month) { ?>
                                 <option value="<?=$key?>"><?=$month?></option>
                                 <?php } ?>
                              </select>
                              <div class="error-Month1"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="exam_year_10th" id="year1" class="form-control" data-req="Yes" onchange="or_year(this)" required="">
                                 <option value="">Select</option>
                                 <?php foreach($yearList as $year){ ?>
                                 <option value="<?=$year?>"><?=$year?></option>
                                 <?php } ?>
                              </select>
                              <div class="error-year1"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_subj_10th" id="tenth_exam_subj" onblur="return alphanumeric(this)" value="" class="form-control" data-req="Yes" required="">
                              <span id="exam_subj_10th" class="validation_error"></span>
                              <div class="error-tenth_exam_subj"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <select name="exam_div_10th" class="form-control" id="div_1" data-req="Yes" required="">
                                 <option value="">-Select-</option>
                                 <option value="First">First</option>
                                 <option value="Second">Second</option>
                                 <option value="Third">Third</option>
                              </select>
                              <div class="error-div_1"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <input type="text" id="1" name="exam_perc_10th" onblur="percentage(this)" value="" class="form-control tenth_exam_perc onlyNumeric" data-req="Yes" maxlength="3" required="">
                              <span id="10th_exam_perc" class="10th_exam_perc"></span>
                              <div class="error-1"></div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_12th" id="twlth_exam" value="12th/Diploma" class="form-control" data-req="Yes" readonly="">
                              <span id="12th_exam" class="validation_error"></span>
                              <div class="error-twlth_exam"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_board_12th" onblur="return alphanumeric(this)" value="" class="form-control" id="twlth_exam_board" data-req="Yes" required="">
                              <span id="exam_board_12th" class="validation_error"></span>
                              <div class="error-twlth_exam_board"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="exam_month_12th" id="Month2" class="form-control" data-req="Yes" required="">
                                 <option value="">Select Month</option>
                                 <?php foreach ($monthList as $key => $month) {?>
                                 <option value="<?=$key?>"><?=$month?></option>
                                 <?php }?>
                              </select>
                              <div class="error-Month2"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="exam_year_12th" onchange="or_year(this)" class="form-control" id="year2" data-req="Yes" required="">
                                 <option value="">Select</option>
                                 <?php foreach($yearList as $year){ ?>
                                 <option value="<?=$year?>"><?=$year?></option>
                                 <?php } ?>
                              </select>
                              <div class="error-year2"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="exam_subj_12th" id="twlth_exam_subj" onblur="return alphanumeric(this)" value="" class="form-control" data-req="Yes" required="">
                              <span id="exam_subj_12th" class="validation_error"></span>
                              <div class="error-twlth_exam_subj"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <select name="exam_div_12th" class="form-control" id="div_2" data-req="Yes" required="">
                                 <option value="">-Select-</option>
                                 <option value="First">First</option>
                                 <option value="Second">Second</option>
                                 <option value="Third">Third</option>
                              </select>
                              <div class="error-div_2"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <input type="text" id="2" name="exam_perc_12th" onblur="percentage(this)" value="" class="form-control twlth_exam_perc onlyNumeric" data-req="Yes" maxlength="3" required="">
                              <span id="12th_exam_div" class="validation_error"></span>
                              <div class="error-2"></div>
                           </div>
                           <div class="clearfix"></div>
                           <input type="hidden" name="graduation_min_percent" value="" id="graduation_min_percent">
                           <div class="col-md-2 col-md-12" id="other_graduation">
                              <select name="grad_exam" class="form-control" id="grad_exam" data-req="Yes">
                              </select>
                              <div class="error-grad_exam"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="grad_exam_board" onblur="return alphanumeric(this)" value="" class="form-control" id="gradn_exam_board" data-req="Yes">
                              <span id="grad_exam_board" class="validation_error"></span>
                              <div class="error-gradn_exam_board"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="grad_exam_month" id="Month3" class="form-control" data-req="Yes">
                                 <option value="">Select Month</option>
                                 <?php foreach ($monthList as $key => $month) {?>
                                 <option value="<?=$key?>"><?=$month?></option>
                                 <?php }?>
                              </select>
                              <div class="error-Month3"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="grad_exam_year" onchange="or_year(this)" class="form-control" id="year3" data-req="Yes">
                                 <option value="">Select</option>
                                 <?php foreach($yearList as $year){ ?>
                                 <option value="<?=$year?>"><?=$year?></option>
                                 <?php  } ?>
                              </select>
                              <div class="error-year3"></div>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <input type="text" name="grad_exam_subj" onblur="return alphanumeric(this)" value="" class="form-control" id="gradn_exam_subj" data-req="Yes">
                              <span id="grad_exam_subj" class="validation_error"></span>
                              <div class="error-gradn_exam_subj"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <select name="grad_exam_div" class="form-control" id="div_3" data-req="Yes">
                                 <option value="">-Select-</option>
                                 <option value="First">First</option>
                                 <option value="Second">Second</option>
                                 <option value="Third">Third</option>
                              </select>
                              <div class="error-div_3"></div>
                           </div>
                           <div class="col-md-1 col-md-12">
                              <input type="text" id="3" name="grad_exam_perc" onblur="percentage(this)" value="" class="form-control gradn_exam_perc onlyNumeric" data-req="Yes" maxlength="3">
                              <span id="grad_exam_div" class="validation_error"></span>
                              <div class="error-3"></div>
                           </div>
                           <div class="clearfix"></div>
                           <input type="hidden" name="post_graduation_min_percent" value="" id="post_graduation_min_percent">
                           <div class="col-md-2 col-md-12">
                              <select name="post_grad_exam" class="form-control post_exam_req" id="post_grad_exam">
                                 <option value="">Select Post Graduation</option>
                                 <option value="105">M.Sc.(Engg) -Civil</option>
                                 <option value="26">M.Tech(Civil)</option>
                                 <option value="22">ME(Civil)</option>
                                 <option value="30">Other - Post Graduation (Civil Engg)</option>
                              </select>
                           </div>
                           <div class="col-md-2 col-md-12"><input type="text" name="post_exam_board" id="pg_exam_board" onblur="return alphanumeric(this)" value="" class="form-control post_exam_req"><span id="post_exam_board" class="validation_error"></span></div>
                           <div class="col-md-2 col-md-12">
                              <select name="post_exam_month" id="Month4" class="form-control post_exam_req">
                                 <option value="">Select Month</option>
                                 <?php foreach ($monthList as $key => $month) {?>
                                 <option value="<?=$key?>"><?=$month?></option>
                                 <?php }?>
                              </select>
                           </div>
                           <div class="col-md-2 col-md-12">
                              <select name="post_exam_year" class="form-control post_exam_req" onchange="or_year(this)" id="year4">
                                 <option value="">Select</option>
                                 <?php foreach($yearList as $year){ ?>
                                 <option value="<?=$year?>"><?=$year?></option>
                                 <?php  } ?>
                              </select>
                           </div>
                           <div class="col-md-2 col-md-12"><input type="text" name="post_exam_subj" id="pg_exam_subj" onblur="return alphanumeric(this)" value="" class="form-control post_exam_req"><span id="post_exam_subj" class="validation_error"></span></div>
                           <div class="col-md-1 col-md-12">
                              <select name="post_exam_div" class="form-control post_exam_req" id="div_4">
                                 <option value="">-Select-</option>
                                 <option value="First">First</option>
                                 <option value="Second">Second</option>
                                 <option value="Third">Third</option>
                              </select>
                           </div>
                           <div class="col-md-1 col-md-12"><input type="text" id="4" name="post_exam_perc" onblur="percentage(this)" value="" class="form-control post_exam_req pg_exam_perc onlyNumeric" maxlength="3"><span id="post_exam_div" class="validation_error"></span></div>
                           <div class="clearfix"></div>
                           <!-- <div class="col-md-12 col-sm-12 no-padding"> -->
                           <div class="col-md-3 col-sm-3">
                              <h5>Other Qualification</h5>
                              <div class="form-group">
                                 <textarea placeholder="Other qualification" class="form-control" onblur="return alphanumeric(this)" rows="3" cols="245" id="comment" name="other_qualification"></textarea>
                                 <span id="other_qualification" class="validation_error"></span>
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-3">
                              <h5>GATE Qualifying Year<span class="star">*</span></h5>
                              <div class="form-group">
                                 <!-- post_exam_req -->
                                 <select name="gate_score" class="form-control" id="gate_year" data-req="Yes" required="">
                                    <option value="">-Select-</option>
                                    <?php
                                       $gyear = date('Y');
                                       for ($i = $gyear; $i > $gyear - 2; $i--) { 
                                       echo "<option value=\"".$i."\">".$i."</option>";
                                       }
                                       ?>
                                 </select>
                                 <div class="error-gate_year"></div>
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-3">
                              <h5>GATE Score<span class="star">*</span></h5>
                              <div class="form-group">
                                 <input type="text" placeholder="Enter Score" class="form-control onlyNumeric" id="gate_score" name="enter_score" data-req="Yes" required="" maxlength="4" >
                                 <span id="" class="validation_error"></span>
                                 <div class="error-enter_score"></div>
                                 <div class="error-gate_score"></div>
                              </div>
                           </div>
                           <div class="col-md-3 col-sm-3 col-sm-12">
                              <h5>GATE Score Card<span class="star">*</span> </h5>
                              <input type="file" class="text-center well well-sm upldPdfFile checkFileSize" name="gate_certificate" id="gate_certificate" required="" onchange="getChangeImg(this, 'gate_certificate')" data-req="Yes" min="" max="200" style="margin-bottom: 0px; padding: 4px;">
                              <span class="help-text">(Only pdf format and Max Size 200 KB)</span>
                              <div class="error-gate_certificate"></div>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        <div class="col-sm-12">
                           <h5>13.Post Qualifcation Experience After(<span class="star" id="post_qual"></span>) (<span class="star" id="post_exp"></span>)(From Current Employment to Past Employment.)</h5>
                           <div>
                              <table class="table table-striped" id="tab_logic1">
                                 <tbody>
                                    <tr>
                                       <td width="300px">Employer Name</td>
                                       <td width="300px">Address of employer</td>
                                       <td width="300px">Post Held</td>
                                       <td width="300px">From</td>
                                       <td width="300px">To</td>
                                       <td width="300px">Jobs Description</td>
                                       <td width="300px">Individual Exp</td>
                                       <td width="300px">Gross Pay <br>(Per Month)</td>
                                    </tr>
                                    <tr id="addr0">
                                       <td>
                                          <input type="text" onblur="return alphanumeric(this)" name="e_name[]" value="" class="form-control">
                                          <span id="e_name[]" class="validation_error"></span>
                                       </td>
                                       <td>
                                          <textarea id="comment" onblur="return alphanumeric(this)" rows="3" class="form-control" name="e_address[]"></textarea>
                                          <span id="e_address[]" class="validation_error"></span>
                                       </td>
                                       <td>
                                          <input type="text" name="e_post[]" onblur="return alphanumeric(this)" class="form-control">
                                          <span id="e_post[]" class="validation_error"></span>
                                       </td>
                                       <td>
                                          <input type="text" name="e_from[]" placeholder="click to show datepicker" id="dfrom_1" class="date1">
                                       </td>
                                       <td>
                                          <input type="text" name="e_to[]" placeholder="click to show datepicker" id="dto_1" class="date2">
                                       </td>
                                       <td>
                                          <textarea id="comment" rows="3" class="form-control exp_valid" onblur="return alphanumeric(this)" name="j_d[]" maxlength="100"></textarea>
                                          <p>(Max 100 words)</p>
                                          <span id="j_d" class="validation_error"></span>
                                       </td>
                                       <td>
                                          <textarea id="ex_coment1" rows="3" class="form-control totalexp" name="experience[]" onclick="getdate(this.id)" readonly=""></textarea>
                                       <td>
                                          <!-- onkeypress="return number_valid(event,this)" -->
                                          <input type="text" name="month_salary[]" id="month_10" class="onlyNumber" onblur="return number_valid(event,this)">
                                       </td>
                                    </tr>
                                    <tr id="addr1"> </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-12" style="margin-top: 10px;">
                           <a id="add_row1" class="btn btn-primary">Add Row</a>&nbsp;
                           <a id="delete_row1" class="btn btn-primary">Delete Row</a>
                        </div>
                        <div class="col-md-3 col-sm-6" style="margin-top: 10px;">
                           <h5>Total Experience: (Y-m)</h5>
                        </div>
                        <div class="col-md-3 col-sm-6" style="margin-top: 10px;">
                           <input type="text" name="total_exp" id="total_exp" class="form-control" onclick="total()" readonly="">
                           <span class="help-text">(After filling experience details, click on text box)</span>
                        </div>
                        <div class="col-sm-12">
                           <h5>14.Language Known:<span class="star">*</span></h5>
                        </div>
                        <div id="tab_logic2">
                           <div class="col-sm-12">
                              <div class="col-md-3 col-sm-4">
                                 <h5>Language</h5>
                              </div>
                              <div class="col-md-3 col-sm-4">
                                 <h5>Status</h5>
                              </div>
                              <div class="col-md-3 col-sm-4">
                                 &nbsp;
                                 <!-- <h5>Examination Passed</h5> -->
                              </div>
                              <div class="col-md-3 col-sm-4">&nbsp;</div>
                           </div>
                           <div class="col-sm-12" id="addr02">
                              <div class="col-md-3 col-sm-4">
                                 <input type="text" id="add_lang_10" name="lang[]" onblur="return alphanumeric(this)" value="" class="form-control" data-req="Yes" required="">
                                 <span id="lang[]" class="validation_error"></span>
                                 <div class="error-add_lang_10"></div>
                              </div>
                              <div class="col-md-3 col-sm-4">
                                 <select class="form-control" onblur="return alphanumeric(this)" name="status[]" id="add_status_10" data-req="Yes" required="">
                                    <option value="">Select</option>
                                    <option>Read Only</option>
                                    <option>Speak only</option>
                                    <option>Read And Speak</option>
                                    <option>Read, write And speak</option>
                                 </select>
                                 <span id="status" class="validation_error"></span>
                                 <div class="error-add_status_10"></div>
                              </div>
                              <div class="col-md-6 col-sm-12">
                                 <a id="add_row2" class="btn btn-primary">Add Row</a>&nbsp;
                                 <a id="delete_row2" class="btn btn-primary">Delete Row</a>
                              </div>
                           </div>
                           <div class="col-sm-12" id="addr2"> </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                           <h5>Physical Handicap (Is More than 40%)<span class="star">*</span></h5>
                        </div>
                        <div class="col-md-8 col-sm-12">
                           <h5><input type="radio" name="ph_percentage" value="yes"> Yes &nbsp;<input type="radio" name="ph_percentage" value="no" checked="">No</h5>
                           <span id="ph" class="validation_error"></span>
                           <div class="error-ph_percentage"></div>
                        </div>
                        <div class="col-sm-12">
                           15.Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer:
                           <input type="radio" name="decipline" value="yes"><span>Yes</span>
                           <input type="radio" name="decipline" value="no" checked><span>No</span>
                           <div class="error-decipline"></div>
                        </div>
                        <?php
                           if (isset($_POST['decipline']) && $_POST['decipline'] == 'yes') {
                           	$style_dis_agnst = 'display: block;';
                           } else {
                           	$style_dis_agnst = 'display: none;';
                           }
                           
                           ?>
                        <div class="col-md-12 col-sm-12 div-discp-agnst" style="<?php echo $style_dis_agnst; ?>">
                           <h5>What disciplinary action taken against you<span class="star">*</span></h5>
                           <div class="form-group">
                              <textarea placeholder="Mention Here" class="form-control" onblur="return alphanumeric(this)" rows="3" cols="245" id="discipline_against" name="discipline_against"></textarea>
                              <span id="discipline_against" class="validation_error"></span>
                              <span id="error-discipline_against"></span>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                           <h5>Date</h5>
                           <input class="form-control" type="text" name="i_date" id="sub_date" value="<?=date('d-m-Y')?>" readonly="">
                        </div>
                        <div class="col-md-3 col-sm-12 pull-right">
                           <h5>10<sup>th</sup> Certificate(As an age proof)<span class="star">*</span> </h5>
                           <input type="file" class="text-center well well-sm upldPdfFile checkFileSize" name="tenth_certificate" id="tenth_certificate" required="" onchange="getChangeImg(this, 'tenth_certificate')" min="" max="200" style="margin-bottom: 0px; padding: 4px;">
                           <span class="help-text">(Only pdf format and Max Size 200 KB)</span>
                           <div class="error-tenth_certificate"></div>
                        </div>
                        <div class="col-sm-12" style="font-size:11px;">
                           <input type="checkbox" onchange="declare(this)" id="conform_check">
                           <span class="star">*</span>
                           <input type="hidden" name="read_dec" id="read_dec" value="Yes">
                           I Declare that I have carefully read and fully understood the various instructions, eligibility criteria and other conditions and I hereby agree to abide by them.<br>
                           I declare that all the entries made by me in this application form are true to the best of my knowledge and belief.<br>
                           I am aware that if any particular information furnished by me in the application are found to be false/incorrect/wrong, at any stage of recruitment or later, I am liable to be disqualified/cancelled/terminated by National Water Development Agency (NWDA) without
                           any notice.<br>
                           I have not concealed any information with respect to qualification/work experiance/disciplinary and vigilace action (If applicable).
                        </div>
                  </div>
                  <div class="col-md-12">
                  <span id="confirm_cmd">To Submit the Form Please Accept Declaration</span><input name="cmdsubmit" type="submit" class="btn btn-primary " id="cmdsubmit" title="Submit" value="Submit" style="display: none;">
                  <button type="button" id="formPreviewBtn" onclick="" class="btn btn-primary" style="display: none;">Preview</button>
                  </div>
               </div>
               <script type="text/javascript">
                  function declare(a) {
                  		$('#decModal').modal('show');
                  		$("#formPreviewBtn").show();
                  		$("#confirm_cmd").hide();
                  	} else {
                  		$("#formPreviewBtn").hide();
                  		$("#confirm_cmd").show();
                  	}
                  }
               </script>
               <input type="hidden" name="age_block_msg1" id="age_block_msg1">
               <input type="hidden" name="min_age_block_msg1" id="min_age_block_msg1">
               <input type="hidden" name="per_block_msg1" id="per_block_msg1">
               <input type="hidden" name="per_block_msg12" id="per_block_msg12">
               <input type="hidden" name="w_12_10th_block_msg1" id="w_12_10th_block_msg1">
               <input type="hidden" name="w_12_g_block_msg1" id="w_12_g_block_msg1">
               <input type="hidden" name="w_pg_g_block_msg1" id="w_pg_g_block_msg1">
               <input type="hidden" name="exp_date_block_msg1" id="exp_date_block_msg1">
               <input type="hidden" name="exp_less_block_msg1" id="exp_less_block_msg1">
               </form>
            </div>
         </div>
         </div>
         </div>
      </section>
      <footer>
         <?php include("footer.php");?>
         <script type="text/javascript" src="<?php echo $HomeURL;?>/js/clientside.validation.js"></script>
      </footer>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>
      <script type="text/javascript">
         $("#example1, #dfrom_1, #dto_1, #sub_date").keypress(function(event) {event.preventDefault();});
         
         function fetch_education(id) {
         	var send = id;
         	$.ajax({
         		type: "post",
         		url: "fetch_edu.php",
         		data: {
         			"id": send
         		},
         		success: function (msg) {
         			// console.log(msg);
         			$("#grad_exam").html(msg);
         		}
         
         	});
         
         	$.ajax({
         		type: "post",
         		url: "fetch_age_ondate.php",
         		data: {
         			"id": send
         		},
         		dataType: "json",
         		success: function (msg2) {
         			
         			var age_on_date = msg2.age_on.split('/');
         			var show_age_on = age_on_date[2]+"/"+age_on_date[1]+"/"+age_on_date[0];
         
         			$("#fetch_age_on").val(msg2.age_on);
         			$("#show_age_on").text(show_age_on);
         			$("#percennt").val(msg2.percent);
         		}
         	});
         }
               
         function get_percent_ajax(argument) {
         	var post_id = $("#select_post").val();
         	var qualif = argument.value;
         	if (qualif.trim() != '' && qualif.trim() != 'Select Graduation') {
         		$.ajax({
         			type: "post",
         			url: "fetch_post_percent.php",
         			data: {
         				"id": post_id,
         				"grad": qualif
         			},
         			success: function (msg3) {
         				//alert(msg3);
         				console.log(msg3);
         				$("#post_grad_exam").html(msg3);
         			}
         		});
         
         		$.ajax({
         			type: "post",
         			url: "fetch_require_percent.php",
         			data: {
         				"id": post_id,
         				"grad": qualif
         			},
         			dataType: "json",
         			success: function (msg) {
         
         				if (msg.need == 1) {
         					$("#p_post_need").val(1);
         					$('#graduation_min_percent').val(msg.req_perc);
         					$('#post_grad_exam').notify("For Your Graduation Post Qualification Is Mandatory", {
         						position: "right",
         						className: "warn"
         					});
         					// $(".post_exam_req").prop('required', true);
         					$(".post_exam_req").attr("data-req", "yes");
         				} else {
         					$('#graduation_min_percent').val(msg.req_perc);
         					$("#p_post_need").val(0);
         					// $(".post_exam_req").prop('required', false);
         					$('.post_exam_req').removeAttr("data-req");
         					$('#post_grad_exam').notify("For Your Graduation Post Qualification Is Optional", {
         						position: "right",
         						className: "info"
         					});
         				}
         			}
         		});
         
         		$.ajax({
         			type: "post",
         			url: "fetch_exp_on_gradu.php",
         			data: {
         				"id": post_id,
         				"grad": qualif
         			},
         			dataType: "json",
         			success: function (msg3) {
         				//alert(msg3.year_field);
         				$("#after_date_exp").val(msg3.year_field);
         
         			}
         		});
         
         		$.ajax({
         			type: "post",
         			url: "fetch_for_other.php",
         			data: {
         				"grad": qualif
         			},
         			//dataType: "json",
         			success: function (msg3) {
         				//alert(msg3);
         				if (msg3 == 1) {
         					$("#alt_grad").remove();
         					$("#other_graduation").append('<input type="text" name="grad_exam" required id="alt_grad" placeholder="Your Other Graduation">');
         					$("#grad_exam").attr('name', 'grad_exam_alt');
         				} else {
         					$("#alt_grad").remove();
         					$("#grad_exam").attr('name', 'grad_exam');
         				}
         			}
         		});
         	} else {
         		$("#alt_grad").remove();
         	}
         }
               
         function get_post_percent_ajax(arg) {
         
         	if ($("#p_post_need").val() == 0) {
         		if (arg.value != '') {
         			// $(".post_exam_req").prop('required', true);
         			$(".post_exam_req").attr("data-req", "yes");
         			$("#loop").val(4);
         		} else {
         			// $(".post_exam_req").prop('required', false);
         			$('.post_exam_req').removeAttr("data-req");
         			$("#loop").val(3);
         		}
         	}
         
         	var post_id = $("#select_post").val();
         	var post_qualif = arg.value;
         	if (post_qualif.trim() != '') {
         		$.ajax({
         			type: "post",
         			url: "fetch_require_percent.php",
         			data: {
         				"pid": post_id,
         				"post_grad": post_qualif
         			},
         			//dataType: "json",
         			success: function (msg) {
         				$("#post_graduation_min_percent").val(msg.trim());
         
         			}
         		});
         
         		$.ajax({
         			type: "post",
         			url: "fetch_for_other.php",
         			data: {
         				"grad": post_qualif
         			},
         			//dataType: "json",
         			success: function (msg3) {
         				//alert(msg3);
         				if (msg3 == 1) {
         					$("#alt_post_grad").remove();
         					$("#other_post_graduation").append('<input type="text" name="post_grad_exam" required id="alt_post_grad" placeholder="Your Other Post Graduation">');
         					$("#post_grad_exam").attr('name', 'post_grad_exam_alt');
         				} else {
         					$("#alt_post_grad").remove();
         					$("#post_grad_exam").attr('name', 'post_grad_exam');
         				}
         
         
         			}
         		});
         	} else {
         		$("#alt_post_grad").remove();
         	}
         }
         
         $(document).ready(function(){
               		$('input[name="decipline"]').change(function(){
               			var descp = $('input[name="decipline"]:checked').val();
               			if (descp == 'yes') {
         			$(".div-discp-agnst").css("display","block");
               			} else if (descp == 'no') {
         			$(".div-discp-agnst").css("display","none");
               			} else {
         			$(".div-discp-agnst").css("display","none");
               			}
               		});
         
               		$('input[name="rd_dec"]').change(function(){
               			var rddec = $('input[name="rd_dec"]:checked').val();
               			if (rddec == 'yes') {
         			$("#read_dec").val('Yes');
               			} else if (rddec == 'no') {
         			$("#read_dec").val('No');
               			} else {
         			$("#read_dec").val('');
               			}
               		});
               	});
               
      </script>
      <script type="text/javascript">
         $('#same_add').click(function () {
         	var cadd = $("#caddress").val();
         
         	if (cadd == '') {
         
         		$("#c_address").html('<span style="color: #ff0000;">Please enter present address</span>');
         		$(this).prop('checked', false);
         
         	} else {
         
         		$("#c_address").html('');
         		var sameadd = $(this).prop('checked');
         
         		if (sameadd == true) {
         
         			$("#paddress").val($("#caddress").val());
         			$("#paddress").attr("readonly", "true");
         			$("#caddress").attr("readonly", "true");
         
         		} else {
         
         			$("#paddress").val('');
         			$("#paddress").removeAttr("readonly");
         			$("#caddress").removeAttr("readonly");
         
         		}
         	}
         });
      </script>
      <script type="text/javascript">
         function fetch_age_fe(val) {
         	var post = $("#select_post").val();
         	var send = val;
         	$.ajax({
         		type: "post",
         		url: "fetch_age_fe.php",
         		data: {
         			"post": post,
         			"send": send
         		},
         		dataType: "json",
         		success: function (msg) {
         			if ($("#hid_age").val() > parseInt(msg.age)) {
         							$("#example1").val('');
         				$("#age").notify("Your age is greter than max age So you are not Eligible", {
         					
         		
         		
         					className: "error",
         					hideDuration: 3000
         				});
         				// $.notify("Your age is greter than max age So you are not Eligible", "warn");
         				var msg = "You are not Eligible due to your age is Max ";
         				//block(msg);
         				$("#age_block_msg1").val(msg);
         
         			} else {
         
         				$("#age_block_msg1").val('');
         
         			}
         		}
         	});
         }
      </script>
      <script>
         $(document).ready(function () {
         	var i = 1;
         	var j = 0
         	$("#add_row1").click(function () {
         		var val1 = $('#pay_1' + j).val();
         		var val2 = $('#month_1' + j).val();
         		var val3 = $('#gross_1' + j).val();
         		if (val1 == "" || val2 == "" || val3 == "") {
         			$("#add_row1").notify("Kindly Fill the All Values Of Above row", {
         				position: "right",
         				className: "warn"
         			});
         			return false;
         		} else {
         			j = j + 1;
         	
         			$('#addr1' + i).html("<td><input type='text' id='username' name='e_name[]' value=''  class='form-control' required /></td><td><textarea required id='comment' rows='3' class='form-control' name='e_address[]' ></textarea> </td>\n\<td><input  required type='text' class='form-control'  name='e_post[]'/></td><td><input required  name='e_from[]'  type='text' class='form-control date1' id='dfrom_" + i + "'/></td><td><input  required name='e_to[]'  type='text' class='form-control date2' id='dto_" + i + "'/></td>\n\<td><textarea required  id='comment' rows='3' class='exp_valid' name='j_d[]' maxlength='100'></textarea></td>\n\<td><textarea  required onclick='getdate(this.id)' id='ex_coment" + i + "' rows='3' class='form-control totalexp' name='experience[]' readonly></textarea></td>\n\<td><input required name='month_salary[]'  id='month_1" + j + "' type='text' class='form-control' onblur='return number_valid(event,this)' /></td></tr>");
         		}
         
         		$('#tab_logic1').append('<tr id="addr1' + (i + 1) + '"></tr>');
         		i++;
         
         		$('.date1').datepicker({
         
         			format: "dd-mm-yyyy"
         
         		});
         		$('.date2').datepicker({
         
         			format: "dd-mm-yyyy"
         		});
         
         		$('.date1').on('changeDate', function (ev) {
         			if (this.value != '') {
         
         				less_year_exp(this);
         
         			}
         
         			$('.date1').datepicker('hide');
         		});
         
         		$('.date2').on('changeDate', function (ev) {
         			if (this.value != '') {
         
         				last_ex_ind(this);
         
         			}
         			$('.date2').datepicker('hide');
         		});
         	});
         	$("#delete_row1").click(function () {
         		if (i > 1) {
         			$("#addr1" + (i - 1)).html('');
         			i--;
         		}
         	});
         });
      </script>
      <script type="text/JavaScript"></script>
      <script>
         $(document).ready(function () {
         	var i = 1;
         	var k = 0;
         	$("#add_row2").click(function () {
         		var vall1 = $('#add_lang_1' + k).val();
         		var vall2 = $('#add_status_1' + k).val();
         
         		if (vall1 == "" || vall2 == "") {
         			alert("Kindly Fill the All Values Of Above row");
         			return false;
         		} else {
         			k = k + 1;
         
         			$html ='<div class="col-md-3 col-sm-4"><input type="text" id="add_lang_1'+k+'" name="lang[]" value="" class="form-control" data-req="Yes"/><div class="error-add_lang_1'+k+'"></div></div><div class="col-md-3 col-sm-4"><select class="form-control" onBlur="return alphanumeric(this)" name="status[]" id="add_status_1'+k+'" data-req="Yes"><option value="">-Select-</option><option>Read Only</option><option>Speak only</option><option>Read And Speak</option><option>Read, write And  speak</option></select><div class="error-add_status_1'+k+'"></div></div><div class="col-md-3 col-sm-4"></div><div class="col-md-3 col-sm-4">&nbsp;</div>';
         			$('#addr2' + i).html($html);
         		}
         		$('#tab_logic2').append('<div class="col-sm-12" id="addr2' + (i + 1) + '"></div>');
         
         		i++;
         	});
         
         	$("#delete_row2").click(function () {
         		if (i > 1) {
         			$("#addr2" + (i - 1)).html('');
         			i--;
         		}
         	});
         });
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function () {
         	$("#cmdsubmit").hide();
         	$("#rel_comment").hide();
         	$('input:radio[name="rel"]').change(function () {
         		if ($(this).val() == 'no') {
         			$("#rel_comment").hide();
         		}
         		if ($(this).val() == 'yes') {
         			$("#rel_comment").show();
         		}
         	});
         });
               
         // ]]>
      </script>
      <script type="text/javascript">
         function last_ex_ind(arg) {
         	$("#last_idv_exp").val(arg.value);
         }
               
         function percentage(a) {
         	var id = a.id;
         	var name_val = a.value;
         	if (name_val <= 100) {
         		var division = $("#div_" + id).val();
         		// console.log(division);
         		var max = 0;
         		min = 0;
         		switch (division) {
         			case 'First':
         				max = 100;
         				min = 60;
         				break;
         
         			case 'Second':
         				max = 59;
         				min = 45;
         				break;
         
         			case 'Third':
         				max = 44;
         				min = 30;
         				break;
         		}
         		// console.log(name_val+'<='+max +'<<>>'+ name_val+'>='+min)
         		if (name_val <= max && name_val >= min) {
         
         			if (id == 3) {
         				var per_val = $("#graduation_min_percent").val();
         
         				if (name_val < per_val) {
         					$('#' + id).notify("Your Graduation below than Required " + per_val, {
         						position: "left",
         						className: "error"
         					});
         
         					var msg = "Your Graduation below than Required " + per_val;
         					$("#per_block_msg1").val(msg);
         
         				} else {
         					$("#per_block_msg1").val('');
         				}
         
         			}
         			if (id == 4) {
         				var per_val = $("#post_graduation_min_percent").val();
         
         				if (name_val < per_val) {
         					$('#' + id).notify("Your Post Graduation Percentage below than Required " + per_val, {
         						position: "left",
         						className: "error"
         					});
         
         					var msg = "Your Post Graduation Percentage below than Required " + per_val;
         					$("#per_block_msg12").val(msg);
         				} else {
         					$("#per_block_msg12").val('');
         				}
         
         			}
         
         		} else {
         			$('#' + id).notify("Percentage Should match according to your Division ", {
         				position: "left",
         				className: "warn"
         			});
         		}
         	} else {
         		$('#' + id).notify("Percentage should not Blank and less than 100  ", {
         			position: "left",
         			className: "warn"
         		});
         	}
         }
               
         function or_year(b) {
         	var year_select_id = b.id;
         
         	switch (year_select_id) {
         		case 'year1':
         			break;
         		case 'year2':
         			var exam_value = $("#" + year_select_id).val();
         			var pre_exam_value = $("#year1").val();
         			if (pre_exam_value == '') {
         				$('#year1').notify("Please Select 10th Year)", {
         					position: "top",
         					className: "error"
         				});
         
         			}
         			if (exam_value < parseInt(pre_exam_value) + 2) {
         				$('#year2').notify("Please Enter correct year of 10th and 12th (10th should be minimum than 12th)", {
         					position: "top",
         					className: "error"
         				});
         
         				var msg = "Please Enter correct year of 10th and 12th  ";
         				$("#w_12_10th_block_msg1").val(msg);
         
         			} else {
         				$("#w_12_10th_block_msg1").val('');
         			}
         			break;
         
         		case 'year3':
         			var exam_value = $("#" + year_select_id).val();
         			var pre_exam_value = $("#year2").val();
         			if (pre_exam_value == '') {
         				$('#year2').notify("Please Select 12th Year)", {
         					position: "top",
         					className: "error"
         				});
         			}
         			if (exam_value < parseInt(pre_exam_value) + 3) {
         				$('#year3').notify("Please Enter correct year order of Graduation and  12th", {
         					position: "top",
         					className: "error"
         				});
         				var msg = "Please Enter correct year order of Graduation and 12th  ";
         				$("#w_12_g_block_msg1").val(msg);
         			} else {
         				$("#w_12_g_block_msg1").val('');
         			}
         			break;
         
         		case 'year4':
         			var exam_value = $("#" + year_select_id).val();
         			var pre_exam_value = $("#year3").val();
         			if (pre_exam_value == '') {
         				$('#year3').notify("Please Select Graduation Year)", {
         					position: "top",
         					className: "error"
         				});
         
         			}
         			if (exam_value < parseInt(pre_exam_value) + 2) {
         				$('#year4').notify("Please Enter correct year order of Post Graduation and  Graduation", {
         					position: "top",
         					className: "error"
         				});
         				var msg = "Please Enter correct year order of Post Graduation and  Graduation";
         				$("#w_pg_g_block_msg1").val(msg);
         
         			} else {
         				$("#w_pg_g_block_msg1").val('');
         			}
         			break;
         	}
         }
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function () {
         	jQuery('li.dropdown:has(ul:empty)').remove();
         	jQuery('ul.menu li:has(ul)').addClass('collapsed');
         	jQuery("ul.menu").treeview({
         		collapsed: true,
         		unique: true,
         		persist: "location"
         	});
         	return false;
         });
      </script>
      <script type="text/javascript">
         function less_year_exp(v) {
         	var rublock_id = v.id;
         	var ara = rublock_id.split("_");
         	var subling_id = parseInt(ara[1]);
         	var pre_to = subling_id - 1;
         	//alert(subling_id+1);
         	var d = new Date(v.value);
         	//alert(d);
         	var d2 = new Date($("#dto_" + pre_to).val());
         	//alert(d2);
         	var date_diff_from = Math.ceil((d - d2) / (365.25 * 24 * 60 * 60 * 1000));
         
         	var e_from = d.getFullYear();
         	gr_date_id = $("#after_date_exp").val()
         	var else_year = parseInt($("#" + gr_date_id).val());
         	if (d != 'Invalid Date') { //alert(date_diff_from);
         		if (e_from < else_year) {
                     
         		} else if (date_diff_from <= 0 && rublock_id != dfrom_1) {
         			$("#dto_" + pre_to).notify("Experience should be start after Last Experience date", {
         				position: "top left",
         				className: "warn"
         			});
         			msg = "Experience Start date and end date should be in order";
         			//block(msg);
         			$("#exp_date_block_msg1").val(msg);
         		} else {
         
         			//allow();
         			$("#exp_date_block_msg1").val('');
         		}
         	}
         }
         //function getAge(dob,as_on) 
         function getAge(fromdate, todate) {
         
         	todate = new Date(todate);
         	today = new Date();
         	fromdate = new Date(fromdate);
         	min_age = fromdate.getFullYear() + 12;  
         	var age = [],
         		y = [todate.getFullYear(), fromdate.getFullYear()],
         		ydiff = y[0] - y[1],
         		m = [todate.getMonth(), fromdate.getMonth()],
         		mdiff = m[0] - m[1],
         		d = [todate.getDate(), fromdate.getDate()],
         		ddiff = d[0] - d[1];
         	if (mdiff < 0 || (mdiff === 0 && ddiff < 0)) --ydiff;
         	if (mdiff < 0) mdiff += 12;
         	if (ddiff < 0) {
         		fromdate.setMonth(m[1] + 1, 0);
         		ddiff = fromdate.getDate() - d[1] + d[0];
         		--mdiff;
         	}
         	if (ydiff > 0) age.push(ydiff + ' year' + (ydiff > 1 ? 's' : ''));
         	if (mdiff > 0) age.push(mdiff + ' month' + (mdiff > 1 ? 's' : ''));
         	if (ddiff > 0) age.push(ddiff + ' day' + (ddiff > 1 ? 's' : ''));
         	if (age.lengtd > 1) age.splice(age.length - 1, 0, ' and ');
         	$('#age').val(age.join(' '));
         	var age_diff = Math.ceil((todate - fromdate) / (365.25 * 24 * 60 * 60 * 1000));
         	if (isNaN(age_diff) || age_diff < 0) {
         		return false;
         	} else {
         		$('#hid_age').val(age_diff);
         	}
         }
         function getdate(d)
         {
         	var id=d;
         	var pid=id.substring(9, 10);
         	
         	var date1=$("#dfrom_"+pid).val();
         	var fdate = date1.split('-');
         	var date1 = fdate[2]+"/"+fdate[1]+"/"+fdate[0];
         
         	var date2=$("#dto_"+pid).val();
         	var tdate = date2.split('-');
         	var date2 = tdate[2]+"/"+tdate[1]+"/"+tdate[0];
         
         	experience(date1,date2,id);
         }
         function experience(fromdate,todate,id)
         {
         	todate= new Date(todate);
         	
         	var age= [], fromdate= new Date(fromdate),
         	y= [todate.getFullYear(), fromdate.getFullYear()],
         	ydiff= y[0]-y[1],
         	m= [todate.getMonth(), fromdate.getMonth()],
         	mdiff= m[0]-m[1],
         	d= [todate.getDate(), fromdate.getDate()],
         	ddiff= d[0]-d[1];
         
         	if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
         	if(mdiff<0) mdiff+= 12;
         	if(ddiff<0){
         		fromdate.setMonth(m[1]+1, 0);
         		ddiff= fromdate.getDate()-d[1]+d[0];
         		--mdiff;
         	}
         
         	//alert(ydiff + " years and " + mdiff+"month"+ ddiff+"days");
         	var total = ydiff + " years and " + mdiff+" month "+ ddiff+" days" ;
         	$("#"+id).val(total);
         }         
      </script>
      <script>
         function total() {
         	var y = 0,
         		m = 0,
         		d = 0;
         	$(".totalexp").each(function () {
         		var date = $(this).val();
         		var arr = date.split(" ");
         		var year = parseInt(arr[0]);
         		var month = parseInt(arr[3]);
         		var date1 = parseInt(arr[5]);
         		y += year;
         		m += month;
         		d += date1;
         	});
         	if (m >= 12) {
         
         		y++;
         		m = m - 12;
         	}
         	if (d >= 30) {
         		d = d - 30
         		m++;
         		if (m >= 12) {
         
         			y++;
         			m = m - 12;
         		}
         	}
         	$("#total_exp").val(y + " year and " + m + " month " + d + " day");
         	var exp_db = $("#post_exp").text();
         	if ($("#total_exp").val() == 'NaN year and NaN month NaN day') {
         		$("#total_exp").notify("Select Individual Experience", {
         			position: "right",
         			className: "error"
         		});
         		msg = "Not eligible Experience less than Required";
         		block(msg);
         		$("#exp_less_block_msg1").val(msg);
         	} else if (y < exp_db) {
         		$("#total_exp").notify("Your total experience minimum than " + " " + exp_db, {
         			position: "right",
         			className: "error"
         		});
         		msg = "Not eligible Experience less than  Required" + " " + exp_db;
         		block(msg);
         		$("#exp_less_block_msg1").val(msg);
         	} else {
         		allow();
         		$("#exp_less_block_msg1").val('');
         	}
         
         }
         
         function number_valid(evt, a) {
         	var charCode = (evt.which) ? evt.which : event.keyCode
         	if (charCode > 31 && (charCode < 44 || charCode > 57)) {
         		$.notify("Please enter numbers only", "error");
         
         		return false;
         	} else {
         		return true;
         	}
         }
         
         function block(msg) {
         
         	$("#confirm_cmd").text(msg);
         	$("#confirm_cmd").show();
         	$("#conform_check").hide();
         	$("#cmdsubmit").hide();
         	//alert("helo")
         }
         
         function allow() {
         
         	$("#confirm_cmd").text("To submit the Form Please check Declaration");
         	$("#confirm_cmd").show();
         	$("#cmdsubmit").hide();
         	$("#conform_check").show().prop('checked', false);
         
         }
         
      </script>
      <script type="text/javascript">
         $('.onlyNumber').on('keypress',function(event){
         	if (event.which === 32 && !event.length) {
         		event.preventDefault();
         	} else if (isNaN(String.fromCharCode(event.keyCode))) {
         		event.preventDefault();
         	}
         });
               
         $(".closestatus").click(function() {
         	$("#msgerror").addClass("hide").hide();
         });
         $(".closestatus").click(function() {
         	$("#msgclose").addClass("hide").hide();
         });
         
         function pageScrollUp(){
         	$('html, body').animate({
         		scrollTop: $("#feedback-form").offset().top
         	}, 700);
         	return false;
         }
               
         $('#formPreviewBtn').click(function(){
         	var form = $('#feedback-form');
         	var error = 0;
         
         	$("#feedback-form input,select,textarea").each(function () {
                          var fieldid = $(this).attr("id");
                          if (fieldid != 1 || fieldid != 2 || fieldid != 3 || fieldid != 4) {
                          	var isrequire = $('#'+fieldid).attr('data-req');
                           if(isrequire == 'Yes'){
                           	var Fieldval = $('#'+fieldid).val();
         				if(Fieldval == ''){
         					error = 1;
         					$('span.err-' + fieldid).remove();
         					$('.error-' + fieldid).append('<span class="error err-' + fieldid + '" style="color:red;">This field is required.</span>');
         				} else {
         					$('span.err-' + fieldid).remove();
         				}
                           }
         		}
                      });
         
         	if($('input[name="ph_percentage"]:checked').val() == undefined)
                {
                    error = 1;
                    $('span.err-ph_percentage').remove();
                    $('.error-ph_percentage').append('<span class="error err-ph_percentage" style="color:red;">Please select physical handicap.</span>');
                }
         
         	if($('input[name="decipline"]:checked').val() == undefined)
                {
                    error = 1;
                    $('span.err-decipline').remove();
                    $('.error-decipline').append('<span class="error err-decipline" style="color:red;">Please select.</span>');
                }
         
                if($('input[name="decipline"]:checked').val() == 'yes') {
                	var desagnst = $("#discipline_against").val();
                	if (desagnst == '') {
                		error = 1;
                     $('span.err-discipline_against').remove();
                     $('.error-discipline_against').append('<span class="error err-discipline_against" style="color:red;">Please enter what disciplinary action taken against you.</span>');
                	}
                }
         
                var photo = $('#file').val();
                var gate_certificate = $('#gate_certificate').val();
                var tenth_certificate = $('#tenth_certificate').val();
         
                if(photo == "")
                      {
                       error = 1;
                       $('span.err-file').remove();
                       $('.error-file').append('<span class="error err-file" style="color:red;">Please upload photo.</span>');
                      }
         
                if(gate_certificate == "")
                      {
                       error = 1;
                       $('span.err-gate_certificate').remove();
                       $('.error-gate_certificate').append('<span class="error err-gate_certificate" style="color:red;">Please upload GATE score card.</span>');
                      }
         
                if(tenth_certificate == "")
                      {
                       error = 1;
                       $('span.err-tenth_certificate').remove();
                       $('.error-tenth_certificate').append('<span class="error err-tenth_certificate" style="color:red;">Please upload 10<sup>th</sup> certificate.</span>');
                      }
         
         	if (error == 1) {
         		pageScrollUp();
                          return false;
                      } else {
         		var post = $('#select_post option:selected').text();
         		var adv_no = $('#advertisement_no').val();
         		var firstname = $('#firstname').val();
         		var middlename = $('#middlename').val();
         		var lastname = $('#lastname').val();
         		var name = firstname+' '+middlename+' '+lastname;
         		var email = $('#email').val();
         		var gender = $('#gender option:selected').text();
         		var parent_name = $('#parent_name').val();
         		var category = $('#category option:selected').text();
         		var dob = $('#example1').val();
         		var nationality = $('#nationality').val();
         		var age = $('#age').val();
         		var m_status = $('#m_status option:selected').text();
         		var mobile = $('#mobile').val();
         		var caddress = $('#caddress').val();
         		var paddress = $('#paddress').val();
         		var tenth_exam = $('#tenth_exam').val();
         		var tenth_exam_board = $('#tenth_exam_board').val();
         		var Month1 = $('#Month1 option:selected').text();
         		var year1 = $('#year1 option:selected').text();
         		var tenth_exam_subj = $('#tenth_exam_subj').val();
         		var div_1 = $('#div_1 option:selected').text();
         		var tenth_exam_perc = $('.tenth_exam_perc').val();
         		var twlth_exam = $('#twlth_exam').val();
         		var twlth_exam_board = $('#twlth_exam_board').val();
         		var Month2 = $('#Month2 option:selected').text();
         		var year2 = $('#year2 option:selected').text();
         		var twlth_exam_subj = $('#twlth_exam_subj').val();
         		var div_2 = $('#div_2 option:selected').text();
         		var twlth_exam_perc = $('.twlth_exam_perc').val();
         		var grad_exam = $('#grad_exam option:selected').text();
         		var gradn_exam_board = $('#gradn_exam_board').val();
         		var Month3 = $('#Month3 option:selected').text();
         		var year3 = $('#year3 option:selected').text();
         		var gradn_exam_subj = $('#gradn_exam_subj').val();
         		var div_3 = $('#div_3 option:selected').text();
         		var gradn_exam_perc = $('.gradn_exam_perc').val();
         		var post_grad_exam_val = $('#post_grad_exam option:selected').val();
         		var post_grad_exam = $('#post_grad_exam option:selected').text();
         		var pg_exam_board = $('#pg_exam_board').val();
         		var Month4 = $('#Month4 option:selected').text();
         		var year4 = $('#year4 option:selected').text();
         		var pg_exam_subj = $('#pg_exam_subj').val();
         		var div_4 = $('#div_4 option:selected').text();
         		var pg_exam_perc = $('.pg_exam_perc').val();
         		var comment = $('#comment').val();
         		var gate_year = $('#gate_year').val();
         		var gate_score = $('#gate_score').val();
         		var total_exp = $('#total_exp').val();
         		var ph_percentage = $('input[name=ph_percentage]:checked').val();
         		var decipline = $('input[name=decipline]:checked').val();
         		var disagnst = $('#discipline_against').val();
         		var sub_date = $('#sub_date').val();
         
         		var e_name = $("input[name='e_name[]']")
         			.map(function(){return $(this).val();}).get();
         		var e_address = $("textarea[name='e_address[]']")
         			.map(function(){return $(this).val();}).get();
         		var e_post = $("input[name='e_post[]']")
         			.map(function(){return $(this).val();}).get();
         		var e_from = $("input[name='e_from[]']")
         			.map(function(){return $(this).val();}).get();
         		var e_to = $("input[name='e_to[]']")
         			.map(function(){return $(this).val();}).get();
         		var j_d = $("textarea[name='j_d[]']")
         			.map(function(){return $(this).val();}).get();
         		var experience = $("textarea[name='experience[]']")
         			.map(function(){return $(this).val();}).get();
         		/*var pay_scale = $("input[name='pay_scale[]']")
         			.map(function(){return $(this).val();}).get();*/
         		var month_salary = $("input[name='month_salary[]']")
         			.map(function(){return $(this).val();}).get();
         		
         		var lang = $("input[name='lang[]']")
         			.map(function(){return $(this).val();}).get();
         		var status = $("select[name='status[]']")
         			.map(function(){return $(this).val();}).get();
         
         		$('.preview_post').html(post);
         		$('.preview_advno').html(adv_no);
         		$('.preview_name').html(name);
         		$('.preview_email').html(email);
         		$('.preview_gender').html(gender);
         		$('.preview_parent_name').html(parent_name);
         		$('.preview_category').html(category);
         		$('.preview_dob').html(dob);
         		$('.preview_nationality').html(nationality);
         		$('.preview_age').html(age);
         		$('.preview_m_status').html(m_status);
         		$('.preview_mobile').html(mobile);
         		$('.preview_caddress').html(caddress);
         		$('.preview_paddress').html(paddress);
         		
         		if (post_grad_exam_val != '') {
         			var html_pg = '<tr><td>'+post_grad_exam+'</td><td>'+pg_exam_board+'</td><td>'+Month4+'</td><td>'+year4+'</td><td>'+pg_exam_subj+'</td><td>'+div_4+'</td><td>'+pg_exam_perc+'</td></tr>'
         		} else {
         			var html_pg = '';
         		}
         
         		var qua_tbody = '<tr><td>'+tenth_exam+'</td><td>'+tenth_exam_board+'</td><td>'+Month1+'</td><td>'+year1+'</td><td>'+tenth_exam_subj+'</td><td>'+div_1+'</td><td>'+tenth_exam_perc+'</td></tr><tr><td>'+twlth_exam+'</td><td>'+twlth_exam_board+'</td><td>'+Month2+'</td><td>'+year2+'</td><td>'+twlth_exam_subj+'</td><td>'+div_2+'</td><td>'+twlth_exam_perc+'</td></tr><tr><td>'+grad_exam+'</td><td>'+gradn_exam_board+'</td><td>'+Month3+'</td><td>'+year3+'</td><td>'+gradn_exam_subj+'</td><td>'+div_3+'</td><td>'+gradn_exam_perc+'</td></tr>'+html_pg;
         
         		$('.qua-tbody').html(qua_tbody);
         
         		$('.preview_oth_qua').html(comment);
         		$('.preview_gate_year').html(gate_year);
         		$('.preview_gate_score').html(gate_score);
         		$('.preview_total_exp').html(total_exp);
         		// $('.preview_ph_handicap').html(ph_percentage);
         		
         		if (ph_percentage == 'yes') {
         			$('.preview_ph_handicap').html('Yes');
         		} else if (ph_percentage == 'no') {
         			$('.preview_ph_handicap').html('No');
         		}
         
         		if (decipline == 'yes') {
         			$('.preview_decipline').html('Yes');
         			$(".pre-discp-agnst").show();
         			$('.preview_discipline_against').html(disagnst);
         		} else if (decipline == 'no') {
         			$('.preview_decipline').html('No');
         			$(".pre-discp-agnst").hide();
         			$('.preview_discipline_against').html('');
         		}
         		$('.preview_sub_date').html(sub_date);
         
         		var exp_tbody = '';
         
         		if (e_name != '') {
         			for (var i = 0; i < e_name.length; i++) {
         				// e_name[i]
         				exp_tbody += '<tr><td>'+e_name[i]+'</td><td>'+e_address[i]+'</td><td>'+e_post[i]+'</td><td>'+e_from[i]+'</td><td>'+e_to[i]+'</td><td>'+j_d[i]+'</td><td>'+experience[i]+'</td><td>'+month_salary[i]+'</td></tr>';
         			}
         		}
         
         		$('.exp-tbody').html(exp_tbody);
         		
         		var lang_tbody = '';
         
         		if (lang != '') {
         			for (var i = 0; i < lang.length; i++) {
         				lang_tbody += '<tr><td>'+lang[i]+'</td><td>'+status[i]+'</td></tr>';
         			}
         		}
         		
         		$('.lang-tbody').html(lang_tbody);
         
         		$('#myModal').modal('show');
         	}
         });
         
         function getChangeImg(input, imgid) {
         	var html = '';
         	if (input.files && input.files[0]) {
         		//condition to check for image or pdf for creating img tag or view button 
         		if(input.files[0].type  == 'image/jpg' || input.files[0].type  == 'image/jpeg')
         		{
         			// html += '<img id="photo-upload" class="uplod_'+imgid+'" src="assets/images/placehold.gif">';
         			html += '<img id="photo-upload" class="upload_'+imgid+'" src="">';
         		}else{
         			html +='<input class="upload_'+imgid+'" type="button" value="Open Pdf"/>';
         		}
         		var reader = new FileReader();
         		reader.onload = function (e) 
         		{
         			//Check image or pdf to create src or buttton path
         			if(input.files[0].type  == 'image/jpg' || input.files[0].type  == 'image/jpeg')
         			{ 
         				$('.upload_' + imgid).attr('src', e.target.result);
         				$('#show-' + imgid).attr('src', e.target.result);
         			}else{
         				$(".upload_"+ imgid).attr('onclick','openPdf("'+e.target.result+'")');
         			}
         			
         		}
         		reader.readAsDataURL(input.files[0]);
         		
         	}
         	//generate dynamic content
         	$('.preview_'+imgid).html(html);
         
         }
         function openPdf(Source)
         {
         	var omyFrame = document.getElementById("myFrame");
         	omyFrame.style.display="block";
         	omyFrame.src = Source;
         }
         
         function submitFormNow(){
         	if(confirm("Do you really want to submit the form?"))
         	{
         		$('#cmdsubmit').trigger('click');
         	}
         	$('#myModal').modal('hide');
         	<?php $msg = 'Thank you for applying this job. Your application has been successfully submitted.'; $_SESSION['sess_msg'] = $msg; ?>
         	setInterval(function(){ window.location.href = 'https://nwda.gov.in/content/innerpage/vacancy_list.php'; }, 15000);
         }
      </script>
      <div id="myModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title text-center">Form Preview</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group" style="display: inline-flex;">
                           <label class="control-label" for="">Post:</label>
                           <div class="preview_post" style="width: 100%; margin-left: 10px;"></div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                           <label class="control-label" for="" style="float: left;">Advertisement No.:</label>
                           <div class="preview_advno" style="width: 68%; float: right;"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Name:</label>
                           <div class="preview_name"></div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Email Id:</label>
                           <div class="preview_email">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Gender:</label>
                           <div class="preview_gender">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Father's/Husband's Name:</label>
                           <div class="preview_parent_name">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Category:</label>
                           <div class="preview_category">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Date of Birth:</label>
                           <div class="preview_dob">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Nationality:</label>
                           <div class="preview_nationality">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Age:</label>
                           <div class="preview_age">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Marital Status:</label>
                           <div class="preview_m_status">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Contact No.:</label>
                           <div class="preview_mobile">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-xs-12">
                        <h4>Address Details</h4>
                        <hr>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Present Address(With Pincode):</label>
                           <div class="preview_caddress">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Permanent Address(With Pincode):</label>
                           <div class="preview_paddress">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-xs-12">
                        <h4>Qualification Details</h4>
                        <hr>
                     </div>
                  </div>
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>Examination Passed</th>
                           <th>Universtiy/Board</th>
                           <th>Month of Passing</th>
                           <th>Year of Passing</th>
                           <th>Subjects</th>
                           <th>Division</th>
                           <th>Percentage</th>
                        </tr>
                     </thead>
                     <tbody class="qua-tbody">
                     </tbody>
                  </table>
                  <div class="row">
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Other Qualification:</label>
                           <div class="preview_oth_qua">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Gate Year:</label>
                           <div class="preview_gate_year"></div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Gate Score:</label>
                           <div class="preview_gate_score">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-xs-12"></div>
                     <div class="col-md-12 col-xs-12">
                        <h4>Experience Details</h4>
                        <hr>
                     </div>
                  </div>
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>Employer Name</th>
                           <th>Address of employer</th>
                           <th>Post Held</th>
                           <th>From</th>
                           <th>To</th>
                           <th>Jobs Description</th>
                           <th>Individual Exp</th>
                           <!-- <th>Pay Scale</th> -->
                           <th>Gross Pay<br>(Per Month)</th>
                        </tr>
                     </thead>
                     <tbody class="exp-tbody">
                     </tbody>
                  </table>
                  <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label prelabel-text" for="">Total Experience:</label>
                           <div class="preview_total_exp">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="display: inline-flex;">
                           <label class="control-label prelabel-text" for="">Physical Handicap:</label>
                           <div class="preview_ph_handicap" style="width: 100%; margin-left: 10px;">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="display: inline-flex;">
                           <label class="control-label prelabel-text" for="">Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer:</label>
                           <div class="preview_decipline" style="width: 100%; margin-left: 10px;">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 pre-discp-agnst" style="display: none;">
                        <div class="form-group" style="display: inline-flex;">
                           <label class="control-label prelabel-text" for="">What disciplinary action taken against you:</label>
                           <div class="preview_discipline_against" style="width: 100%; margin-left: 10px;">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-xs-12">
                        <h4>Language Known</h4>
                        <hr>
                     </div>
                  </div>
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>Language</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody class="lang-tbody">
                     </tbody>
                  </table>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-xs-12">
                        <h4>Declaration</h4>
                        <hr>
                        <p>I Declare that I have carefully read and fully understood the various instructions, eligibility criteria and other conditions and I hereby agree to abide by them.<br>
                           I declare that all the entries made by me in this application form are true to the best of my knowledge and belief.<br>
                           I am aware that if any particular information furnished by me in the application are found to be false/incorrect/wrong, at any stage of recruitment or later, I am liable to be disqualified/cancelled/terminated by National Water Development Agency (NWDA) without any notice.<br>
                           I have not concealed any information with respect to qualification/work experiance/disciplinary and vigilace action (If applicable).
                        </p>
                     </div>
                  </div>
                  <div class="row form-horizontal">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>Uploaded Documents</h4>
                        <hr>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label col-md-6 col-xs-12" for="">Photo:</label>
                           <div class="col-md-6 col-xs-12 p-t-6 preview_file"></div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label col-md-6 col-xs-12" for="">10<sup>th</sup> Certificate:</label>
                           <div class="col-md-6 col-xs-12 p-t-6 preview_tenth_certificate">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group label-inline">
                           <label class="control-label col-md-6 col-xs-12" for="">GATE Certificate:</label>
                           <div class="col-md-6 col-xs-12 p-t-6 preview_gate_certificate">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12">
                        <iframe id="myFrame" style="display:none" width="100%" height="300"></iframe>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" onclick="submitFormNow()" class="btn btn-primary">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <div id="decModal" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <!-- <h4 class="modal-title text-center"></h4> -->
               </div>
               <div class="modal-body">
                  <form>
                     <div class="row">
                        <!-- onchange="checkReadDec('no')"  onclick="closeDecModal()" -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           Have you read the declaration:
                           <input type="radio" name="rd_dec" value="yes" style="margin: 0 3px 0 8px; position: relative; top: 2px;">Yes
                           <input type="radio" name="rd_dec" value="no" style="margin: 0 3px 0 8px; position: relative; top: 2px;">No
                           <div class="error-rd_dec"></div>
                           <span class="help-text">(If you not selected, ByDefault wil be 'Yes'.)</span>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <script>
         $('.carousel').carousel({
         	interval: 3000
         })
      </script>
      <script type="text/javascript">
         $(function () {
         	$(window).scroll(function () {
         		if ($(this).scrollTop() > 300) {
         			$('.back-top').fadeIn();
         		} else {
         			$('.back-top').fadeOut();
         		}
         	});
               
         	// scroll body to 0px on click
         	$('.back-top').click(function () {
         		$('body,html').animate({
         			scrollTop: 0
         		}, 1600);
         		return false;
         	});
         });
      </script>
      <script>
         $(document).ready(function () {
               
         	// hide #back-top first
         	$("#back-top").hide();
               
         	// fade in #back-top
         	$(function () {
         		$(window).scroll(function () {
         			if ($(this).scrollTop() > 100) {
         				$('#back-top').fadeIn();
         			} else {
         				$('#back-top').fadeOut();
         			}
         		});
         		// scroll body to 0px on click
         		$('#back-top a').click(function () {
         			$('body,html').animate({
         				scrollTop: 0
         			}, 800);
         			return false;
         		});
         	});
         });
      </script>
      <script type="text/javascript" >
         if(getCookie("mysheet") == "change" ) {
         	setStylesheet("change") ;
         }else if(getCookie("mysheet") == "blue" ) {
         	setStylesheet("blue") ;
         }else if(getCookie("mysheet") == "green" ) {
         	setStylesheet("green") ;
         } else if(getCookie("mysheet") == "orange" ) {
         	setStylesheet("orange") ;
         }else   {
         	setStylesheet("") ;
         }
      </script>
      <script>
         $(document).ready(function () {
         	$(".mobile-nav").click(function () {
         		$(".sidebar-nav").toggle();
         	});
         });
      </script>
      <script type="text/javascript">
         $(document).ready(function () {
         	$('#example1').datepicker({ 
         		// format: "yyyy-mm-dd",
         		format: "dd-mm-yyyy",
         		autoclose: true
         	}); 
         	$('#example1').on('changeDate', function(ev){ 
         		var age = this.value;
         
         		var age_date = age.split('-');
         		var age = age_date[2]+"/"+age_date[1]+"/"+age_date[0];
         
         		var age_on=$("#fetch_age_on").val();
         		
         		if(age!='')
         		{
         			getAge(age,age_on);
         			if($('#category').val()!='')
         			{ 
         				$('#category').val('');
         			}
         		}
         		$('#example1').datepicker('hide');
         	});
         	$('.date1').datepicker({
         		// format: "yyyy/mm/dd",
         		format: "dd-mm-yyyy",
         		autoclose: true
         	});
         	$('.date2').datepicker({
         		// format: "yyyy/mm/dd",
         		format: "dd-mm-yyyy",
         		autoclose: true
         	});
         	$('.date1').on('changeDate', function(ev){
         		if(this.value!='')
         		{ 
         			less_year_exp(this);
         		}
         		$('.date1').datepicker('hide');
         	});
         	$('.date2').on('changeDate', function(ev){
         		if(this.value!='')
         		{
         			last_ex_ind(this);
         		}
         		$('.date2').datepicker('hide');
         	});
         });
      </script>  
   </body>
</html>