<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
//include("../../includes/functions-data.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
include('pdf2text.php');

// error_reporting(E_ALL);
//     ini_set('display_errors', 1);


$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id = $_SESSION['dbrole_id'];
$user_id = $_SESSION['admin_auto_id_sess'];
$model_id = "6";
// $role_map=role_permission($user_id,$role_id,$model_id);
// $role_id_page=role_permission_page($user_id,$role_id,$model_id);

$sql = "SELECT * FROM admin_role where admin_role.user_id='$user_id'";
$rs = $conn->query($sql);
$role_module = $rs->fetch_array();

$module_id = $role_module['module_id'];
if ($module_id == 'ALL') {
	$role_id_page = 1;
} else {
	$cms = array(
		$model_id
	);
	$exploded = explode(',', $module_id);
	$module_id_cms = array_intersect($exploded, $cms);
	if (count($module_id_cms) > 0) {
		$role_id_page = 1;
	} else {
		$role_id_page = 0;
	}
}

if ($_SESSION['admin_auto_id_sess'] == '') {
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:index.php");
	exit;
}
if ($role_id_page == 0) {
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:error.php");
	exit;
}

if ($_SESSION['saltCookie'] != $_COOKIE['Temp']) {
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:error.php");
	exit;
}

if ($_SESSION['lname'] == 'English') {
	$lan = '1';
} else if ($_SESSION['lname'] == 'Hindi') {
	$lan = '2';
}
if (isset($_POST['cmdsubmit']) && (!isset($_GET['editid']) || $_GET['editid'] == '')) {
	$txtlanguage = check_input($_POST['txtlanguage']);
	$v_title = check_input($_POST['v_title']);
	$newicons = check_input($_POST['newicons']);
	$txtcontentdesc = check_input($_POST['txtcontentdesc']);
	$txtstatus = check_input($_POST['txtstatus']);
	$ext_url = check_input($_POST['ext_url']);
	$startdate = !empty($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : null;
	$expairydate = !empty($_POST['expairydate']) ? date('Y-m-d', strtotime($_POST['expairydate'])) : null;

	$errmsg = "";

	if (trim($txtlanguage) == "") {
		$errmsg .= "Please Select Language." . "<br>";
	}
	if ($txtlanguage == '2') {
		if (trim($v_title) == "") {
			$errmsg .= "Please enter Title." . "<br>";
		}
		if (trim($newicons) == "") {
			$errmsg .= "Please select Display New Icons." . "<br>";
		}
		if (trim($txtcontentdesc) == "") {
			$errmsg .= "Please enter Description." . "<br>";
		}

		if ($_FILES["docs_file"]["tmp_name"] != "") {

			$tempfile = ($_FILES["docs_file"]["tmp_name"]);
			$imageinfo = ($_FILES["docs_file"]["type"]);
			$head = fgets(fopen($tempfile, "r"), 5);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection = substr($section, 0, 8);

			if (!preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["docs_file"]["name"])) {
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			} else if ($section != strip_tags($section)) {
				$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
			} else {
				$extarray = explode(".", $_FILES["docs_file"]["name"]);
				if (count($extarray) > 2) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif ($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif (($nsection == "JVBERI0X") or ($nsection == "/9J/4AAQ") or ($nsection == "IVBORW0K") or ($nsection == "R0LGODLH") or ($nsection == "/9J/4TFN")) {
				} else {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				}
				if ($_FILES["docs_file"]["size"] < 1) {
					$errmsg .= "Document Size is too less.<br>";
				}
				if ($_FILES["docs_file"]["size"] >= (1048576 * 5)) {
					$errmsg .= "Document Size is too big.<br>";
				}
			}
		}

		if (trim($startdate) == "") {
			$errmsg .= "Please enter Start date." . "<br>";
		}
		if (trim($expairydate) == "") {
			$errmsg .= "Please enter Termination date." . "<br>";
		}
		if (trim($txtstatus) == "") {
			$errmsg .= "Please Select Page Status." . "<br>";
		}
	} else {
		if (trim($v_title) == "") {
			$errmsg .= "Please enter Title." . "<br>";
		}
		if (trim($newicons) == "") {
			$errmsg .= "Please select Display New Icons." . "<br>";
		}
		if (trim($txtcontentdesc) == "") {
			$errmsg .= "Please enter Description." . "<br>";
		}

		if ($_FILES["docs_file"]["tmp_name"] != "") {
			$tempfile = ($_FILES["docs_file"]["tmp_name"]);
			$imageinfo = ($_FILES["docs_file"]["type"]);
			$head = fgets(fopen($tempfile, "r"), 5);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection = substr($section, 0, 8);
			if (!preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["docs_file"]["name"])) {
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			} else if ($section != strip_tags($section)) {
				$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
			} else {
				$extarray = explode(".", $_FILES["docs_file"]["name"]);
				if (count($extarray) > 2) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif ($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif (($nsection == "JVBERI0X") or ($nsection == "/9J/4AAQ") or ($nsection == "IVBORW0K") or ($nsection == "R0LGODLH") or ($nsection == "/9J/4TFN")) {
				} else {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				}
				if ($_FILES["docs_file"]["size"] < 1) {
					$errmsg .= "Document Size is too less.<br>";
				}
				if ($_FILES["docs_file"]["size"] >= (1048576 * 5)) {
					$errmsg .= "Document Size is too big.<br>";
				}
			}
		}

		if (trim($startdate) == "") {
			$errmsg .= "Please enter Start date." . "<br>";
		}
		if (trim($expairydate) == "") {
			$errmsg .= "Please enter Termination date." . "<br>";
		}
		if (trim($txtstatus) == "") {
			$errmsg .= "Please Select Page Status." . "<br>";
		}
	}


	if ($errmsg == '') {

		if ($_SESSION['logtoken'] != $_POST['random']) {
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg;
			header("Location:error.php");
			exit();
		} else {
			$_COOKIE['Temp'] = "";
			$_SESSION['saltCookie'] = "";
			$_SESSION['Temptest'] = "";
			$saltCookie = uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] = $saltCookie;
			$_SESSION['Temptest'] = $_SESSION['saltCookie'];
			setcookie("Temp", $_SESSION['saltCookie']);
			$_SESSION['logtoken'] = md5(uniqid(mt_rand(), true));

		}

		if ($_FILES["docs_file"]["name"] != "") {
			$txtuplodepdf = $_FILES['docs_file']['name'];
			$txtuplode = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplodepdf);
			$uniq = uniqid("");
			$txtuplodepdf = $uniq . $txtuplodepdf;
			$PATH = "../../upload/vacancy/";
			if (!is_dir($PATH)) {
				if (!mkdir($PATH, 0755, true)) {
					die("Failed to create vacancy directory.");
				}
			}
			// $PATH = $PATH . "/";
			$val = move_uploaded_file($_FILES["docs_file"]["tmp_name"], $PATH . $txtuplodepdf);
			$size = filesize($PATH . $txtuplodepdf);
			$size = ceil($size / 1024);
			$found = "false";
		}

		if ($_FILES["image_file"]["name"] != "") {
			$txtuplodeimg = $_FILES['image_file']['name'];
			$txtuplode = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplodeimg);
			$uniq = uniqid("");
			$txtuplodeimg = $uniq . $txtuplodeimg;
			$PATH = "../../upload/vacancy/images/";
			if (!is_dir($PATH)) {
				if (!mkdir($PATH, 0755, true)) {
					die("Failed to create vacancy directory.");
				}
			}
			// $PATH = $PATH . "/";
			$val = move_uploaded_file($_FILES["image_file"]["tmp_name"], $PATH . $txtuplodeimg);
			$size = filesize($PATH . $txtuplodeimg);
			$size = ceil($size / 1024);
			$found = "false";
		}

		$check_status = check_status($user_id, $role_id, $txtstatus, $model_id);
		if ($check_status > 0) {
			$txtstatus;
		} else {
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg;
			header("Location:error.php");
			exit();
		}
		$tableName_send = "vacancy";

		$tableFieldsName_old = array("language_id", "v_title", "v_description", "c_new_status", "approve_status", "start_date", "end_date", "docs_file", "admin_id", "ext_url", "image_file");
		$tableFieldsValues_send = array("$txtlanguage", "$v_title", "$txtcontentdesc", "$newicons", "$txtstatus", "$startdate", "$expairydate", "$txtuplodepdf", "$user_id", "$ext_url", "$txtuplodeimg");
		$value = $useAVclass->insertQuery($tableName_send, $tableFieldsName_old, $tableFieldsValues_send);

		$page_id = mysqli_insert_id($conn);


		$user_id = $_SESSION['admin_auto_id_sess'];
		$page_id = mysqli_insert_id($conn);
		$action = "Insert";
		$categoryid = '1';
		$date = date("Y-m-d h:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		$tableName = "audit_trail";
		$tableFieldsName_old = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title", "approve_status");
		$tableFieldsValues_send = array("$user_id", "$page_id", "$v_title", "$action", "$model_id", "$date", "$ip", "$txtlanguage", "$v_title", "$txtstatus");
		$value = $useAVclass->insertQuery($tableName, $tableFieldsName_old, $tableFieldsValues_send);
		$msg = CONTENTADD;
		$_SESSION['content'] = $msg;
		header("location:manage_vacancy.php");
		exit;
	}
}


if (isset($cmdsubmit) && $_GET['editid'] != '') {

	$cid = $_GET['editid'];
	$txtlanguage = check_input($_POST['txtlanguage']);
	$v_title = check_input($_POST['v_title']);
	$newicons = check_input($_POST['newicons']);
	$txtcontentdesc = check_input($_POST['txtcontentdesc']);
	$txtstatus = check_input($_POST['txtstatus']);
	$ext_url = check_input($_POST['ext_url']);
	$startdate = !empty($_POST['startdate']) ? date('Y-m-d', strtotime($_POST['startdate'])) : null;
	$expairydate = !empty($_POST['expairydate']) ? date('Y-m-d', strtotime($_POST['expairydate'])) : null;

	$errmsg = "";

	if (trim($txtlanguage) == "") {
		$errmsg .= "Please Select Language." . "<br>";
	}
	if ($txtlanguage == '2') {
		if (trim($v_title) == "") {
			$errmsg .= "Please enter Title." . "<br>";
		}
		if (trim($newicons) == "") {
			$errmsg .= "Please select Display New Icons." . "<br>";
		}
		if (trim($txtcontentdesc) == "") {
			$errmsg .= "Please enter Description." . "<br>";
		}

		if ($_FILES["docs_file"]["tmp_name"] != "") {

			$tempfile = ($_FILES["docs_file"]["tmp_name"]);
			$imageinfo = ($_FILES["docs_file"]["type"]);
			$head = fgets(fopen($tempfile, "r"), 5);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection = substr($section, 0, 8);

			if (!preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["docs_file"]["name"])) {
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			} else if ($section != strip_tags($section)) {
				$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
			} else {
				$extarray = explode(".", $_FILES["docs_file"]["name"]);
				if (count($extarray) > 2) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif ($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif (($nsection == "JVBERI0X") or ($nsection == "/9J/4AAQ") or ($nsection == "IVBORW0K") or ($nsection == "R0LGODLH") or ($nsection == "/9J/4TFN")) {
				} else {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				}
				if ($_FILES["docs_file"]["size"] < 1) {
					$errmsg .= "Document Size is too less.<br>";
				}
				if ($_FILES["docs_file"]["size"] >= (1048576 * 5)) {
					$errmsg .= "Document Size is too big.<br>";
				}
			}
		}

		if (trim($startdate) == "") {
			$errmsg .= "Please enter Start date." . "<br>";
		}
		if (trim($expairydate) == "") {
			$errmsg .= "Please enter Termination date." . "<br>";
		}
		if (trim($txtstatus) == "") {
			$errmsg .= "Please Select Page Status." . "<br>";
		}
	} else {
		if (trim($v_title) == "") {
			$errmsg .= "Please enter Title." . "<br>";
		}
		if (trim($newicons) == "") {
			$errmsg .= "Please select Display New Icons." . "<br>";
		}
		if (trim($txtcontentdesc) == "") {
			$errmsg .= "Please enter Description." . "<br>";
		}

		if ($_FILES["docs_file"]["tmp_name"] != "") {
			$tempfile = ($_FILES["docs_file"]["tmp_name"]);
			$imageinfo = ($_FILES["docs_file"]["type"]);
			$head = fgets(fopen($tempfile, "r"), 5);
			$section = strtoupper(base64_encode(file_get_contents($tempfile)));
			$nsection = substr($section, 0, 8);
			if (!preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["docs_file"]["name"])) {
				$errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
			} else if ($section != strip_tags($section)) {
				$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
			} else {
				$extarray = explode(".", $_FILES["docs_file"]["name"]);
				if (count($extarray) > 2) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif ($imageinfo != 'application/pdf' && $imageinfo != 'image/gif' && $imageinfo != 'image/jpeg' && $imageinfo != 'image/jpg' && $imageinfo != 'image/png' && isset($imageinfo)) {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				} elseif (($nsection == "JVBERI0X") or ($nsection == "/9J/4AAQ") or ($nsection == "IVBORW0K") or ($nsection == "R0LGODLH") or ($nsection == "/9J/4TFN")) {
				} else {
					$errmsg .= 'Sorry, we accept PDF files and GIF,PNG,JPG or JPEG images only';
				}
				if ($_FILES["docs_file"]["size"] < 1) {
					$errmsg .= "Document Size is too less.<br>";
				}
				if ($_FILES["docs_file"]["size"] >= (1048576 * 5)) {
					$errmsg .= "Document Size is too big.<br>";
				}
			}
		}

		if (trim($startdate) == "") {
			$errmsg .= "Please enter Start date." . "<br>";
		}
		if (trim($expairydate) == "") {
			$errmsg .= "Please enter Termination date." . "<br>";
		}
		if (trim($txtstatus) == "") {
			$errmsg .= "Please Select Page Status." . "<br>";
		}
	}


	if ($errmsg == '') {
		if ($_SESSION['logtoken'] != $_POST['random']) {
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg;
			header("Location:error.php");
			exit();
		} else {
			$_COOKIE['Temp'] = "";
			$_SESSION['saltCookie'] = "";
			$_SESSION['Temptest'] = "";
			$saltCookie = uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] = $saltCookie;
			$_SESSION['Temptest'] = $_SESSION['saltCookie'];
			setcookie("Temp", $_SESSION['saltCookie']);
			$_SESSION['logtoken'] = md5(uniqid(mt_rand(), true));

		}
		
		if ($_FILES["docs_file"]["name"]!=""){
			
			$sql = "select docs_file FROM vacancy WHERE id=$cid";
			$rs  = $conn->query($sql);
			$row = $rs->fetch_array();
			
			$image_path = "../../upload/".$row['docs_file'];
			unlink($image_path);
	
			/*if ($_FILES["txtuplode"]["size"] < 500000)
			{*/
			$txtuplodepdf=$_FILES['docs_file']['name'];
			$uniq = uniqid("");
			$txtuplodepdf=$uniq.$txtuplodepdf;		
			$PATH="../../upload/vacancy/";	
			if (!is_dir($PATH)) {
				if (!mkdir($PATH, 0755, true)) {
					die("Failed to create vacancy directory.");
				}
			}				
			$val=move_uploaded_file($_FILES["docs_file"]["tmp_name"],$PATH.$txtuplodepdf);
			$size=filesize($PATH.$txtuplodepdf);
			$size=ceil($size/1024);
			$found="false";
			$txtuplodepdf=addslashes($txtuplodepdf); 
			$whereclause="id=$cid";
			$tableName_send="vacancy";
			$old =array("docs_file");
			$new =array("$txtuplodepdf");
			//$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			$sql1 = "UPDATE `vacancy` SET `docs_file`='$txtuplodepdf' WHERE `id`=$cid";
			$result = $conn->query($sql1);
		}	
		

		if ($_FILES["image_file"]["name"]!=""){
			
			$sql = "select docs_file FROM vacancy WHERE id=$cid";
			$rs  = $conn->query($sql);
			$row = $rs->fetch_array();
			
			$image_path = "../../upload/".$row['docs_file'];
			unlink($image_path);
	
			/*if ($_FILES["txtuplode"]["size"] < 500000)
			{*/
			$txtuplodeimg=$_FILES['image_file']['name'];
			$uniq = uniqid("");
			$txtuplodeimg=$uniq.$txtuplodeimg;		
			$PATH="../../upload/vacancy/images/";	
			if (!is_dir($PATH)) {
				if (!mkdir($PATH, 0755, true)) {
					die("Failed to create vacancy directory.");
				}
			}				
			$val=move_uploaded_file($_FILES["image_file"]["tmp_name"],$PATH.$txtuplodeimg);
			$size=filesize($PATH.$txtuplodeimg);
			$size=ceil($size/1024);
			$found="false";
			$txtuplodeimg=addslashes($txtuplodeimg); 
			$whereclause="id=$cid";
			$tableName_send="vacancy";
			$old =array("image_file");
			$new =array("$txtuplodeimg");
			//$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
			$sql1 = "UPDATE `vacancy` SET `image_file`='$txtuplodeimg' WHERE `id`=$cid";
			$result = $conn->query($sql1);
		}	

		$check_status = check_status($user_id, $role_id, $txtstatus, $model_id);
		if ($check_status > 0) {
			$txtstatus;
		} else {
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg;
			header("Location:error.php");
			exit();
		}


		$create_date = date('y-m-d');
		$whereclause = "id=$_GET[editid]";
		$tableName_send = "vacancy";
		$old = array("language_id", "v_title", "v_description", "c_new_status", "approve_status", "start_date", "end_date", "admin_id", "ext_url");
		$new = array("$txtlanguage", "$v_title", "$txtcontentdesc", "$newicons", "$txtstatus", "$startdate", "$expairydate", "$user_id", "$ext_url");
		// $old = array("language_id", "location_id", "category_id", "job_title", "description", "status", "contact_email");
		// $new = array("$txtlanguage", "$location", "$category", "$pro_title", "$txtcontentdesc", "$txtstatus", "$contact_email");
		$useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);



		$user_id = $_SESSION['admin_auto_id_sess'];
		$page_id = mysqli_insert_id($conn);
		$action = "Insert";
		$categoryid = '1';
		$date = date("Y-m-d h:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		$tableName = "audit_trail";

		$tableFieldsName_old = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title", "approve_status");
		$tableFieldsValues_send = array("$user_id", "$page_id", "$pro_title", "$action", "$model_id", "$date", "$ip", "$txtlanguage", "$pro_title", "$txtstatus");
		$value = $useAVclass->insertQuery($tableName, $tableFieldsName_old, $tableFieldsValues_send);
		$msg = CONTENTUPDATE;
		$_SESSION['content'] = $msg;
		header("location:manage_vacancy.php");
		exit;
	}
}

$cat_type = 'Vacancy';
$categoryList = getJobCategories($cat_type);
// d($categoryList)
$LocationList = getJobLocation();

?>


<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php if ($_GET['editid'] != '')
		echo "Update";
	else
		echo "Add"; ?> Vacancy : <?php echo $sitename; ?></title>
	<!-- admin css  -->
	<link href="style/admin.css" rel="stylesheet" type="text/css">
	<!-- Ckeditor js  -->
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<!-- start Calender js and css  -->
	<script type="text/javascript" src="js/jsDatePick.js"></script>
	<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		window.onload = function () {
			new JsDatePick({
				useMode: 2,
				target: "startdate",
				dateFormat: "%d-%m-%Y"
			});
			new JsDatePick({
				useMode: 2,
				target: "expairydate",
				dateFormat: "%d-%m-%Y"
			});
		};


	</script>
	<script language="javascript" type="text/javascript">
		function addmenutype(id) {
			if (id == '1') {
				document.getElementById('txtDoc').style.display = 'block';
				document.getElementById('txtPDF').style.display = 'none';
				document.getElementById('txtweb').style.display = 'none';
				document.getElementById('media').style.display = 'none';
			}
			else if (id == '2') {
				document.getElementById('txtDoc').style.display = 'none';
				document.getElementById('txtPDF').style.display = 'block';
				document.getElementById('txtweb').style.display = 'none';
				document.getElementById('media').style.display = 'none';
			}
			else if (id == '3') {
				document.getElementById('txtDoc').style.display = 'none';
				document.getElementById('txtPDF').style.display = 'none';
				document.getElementById('txtweb').style.display = 'block';
				document.getElementById('media').style.display = 'none';
			}
			else {
				document.getElementById('txtDoc').style.display = 'none';
				document.getElementById('txtPDF').style.display = 'none';
				document.getElementById('txtweb').style.display = 'none';
				document.getElementById('media').style.display = 'block';
			}

		}



	</script>
	<!-- end  Calender js and css  -->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

	<script type="text/javascript">
		function burstCache() {
			if (!navigator.onLine) {
				document.body.innerHTML = 'Loading...';
				window.location = 'index.php';
			}
		}
	</script>

	<script>
		var a = navigator.onLine;
		if (a) {
			// alert('online');
		} else {
			alert('offline');
			window.location = 'index.php';
		} 
	</script>

</head>

<body>
	<?php include('top_header.php'); ?>
	<div id="container">



		<?php
		include_once('main_menu.php');
		?>
		<!-- Header end -->



		<div class="main_con">
			<div class="admin-breadcrum">
				<div class="breadcrum">
					<span class="submenuclass"><a href="welcome.php" title="Dashboard">Dashboard</a></span>
					<span class="submenuclass">>> </span>
					<span class="submenuclass"><a href="manage_academy_souvenir.php"
							title="Manage Academy Souvenir">Manage Vacancy</a></span>
					<span class="submenuclass">>> </span>
					<span class="submenuclass"><?php if ($_GET['editid'] != '')
						echo "Update";
					else
						echo "Add"; ?>
						Vacancy</span>
				</div>
				<div class="clear"> </div>
			</div>

			<div class="right_col1">

				<div class="clear"></div>
				<?php if ($errmsg != "") { ?>
					<div id="msgerror" class="status error">
						<div class="closestatus" style="float: none;">
							<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png"
									class="margintop"></p>
							<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?>
							</p>
						</div>
					</div>
				<?php } ?>
				<div class="clear"></div>


				<div class="addmenu">
					<div class="internalpage_heading">
						<h3 class="manageuser"><?php if ($_GET['editid'] != '')
							echo "Update";
						else
							echo "Add"; ?> Vacancy
						</h3>
						<div class="right-section">

						</div>
					</div>
					<div class="grid_view">
						<form action="" method="post" name="form1" autocomplete="off" enctype="multipart/form-data"
							onsubmit="return add_cp('form1')">
							<?php
							if ($_GET['editid'] != '') {
								$rq = mysqli_query($conn, "select * from vacancy where 	id='" . $_GET['editid'] . "'");
								$rr = mysqli_fetch_array($rq);

							}


							?>

							<div class="frm_row"> <span class="label1">
									<label for="txtlanguage">Page Language :</label>
									<span class="star">*</span></span> <span class="input1">
									<input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if ($rr['language_id'] == '1') {
										echo 'checked';
									} ?> id="txtlanguage" />English
									&nbsp;
									<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if ($rr['language_id'] == '2') {
										echo 'checked';
									} ?> />Hindi
								</span>
								<div class="clear"></div>
								<div class="loading"></div>
							</div>

							<div class="frm_row"> <span class="label1">
									<label for="txtename">Title:</label>
									<span class="star">*</span></span> <span class="input1">
									<input name="v_title" autocomplete="off" type="text" class="input_class"
										id="txtename" size="30" value="<?php echo $rr['v_title']; ?>" />
								</span>
								<div class="clear"></div>
							</div>

							<div class="frm_row">
								<span class="label1">
									<label for="newicons">Display New Icons :</label>
									<span class="star">*</span></span> <span class="input1">
									<input type="radio" name="newicons" id="newicons" autocomplete="off" value="1" <?php if ($rr['c_new_status'] == '1') {
										echo 'checked';
									} ?> />Yes
									&nbsp;<input type="radio" name="newicons" autocomplete="off" value="2" <?php if ($rr['c_new_status'] == '2') {
										echo 'checked';
									} ?> />No
								</span>
								<div class="clear"></div>
								<div class="loading"></div>
							</div>

							<div class="frm_row"> <span class="label1">
									<label> Description :</label>
									<span class="star"></span></span> <span class="input_fck">
									<textarea class="input_class" name="txtcontentdesc"><?php echo $rr['v_description']; ?></textarea>
								</span>
								<div class="clear"></div>
							</div>

							<!-- <div class="frm_row"> <span class="label1">
									<label> Description :</label>
									<span class="star">*</span></span> <span class="input_fck">
									<?php

									$ckeditor = new CKEditor();
									$ckeditor->basePath = '/ckeditor/';
									$ckeditor->config['filebrowserBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html';
									$ckeditor->config['filebrowserImageBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
									$ckeditor->config['filebrowserUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
									$ckeditor->config['filebrowserImageUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
									$ckeditor->editor('txtcontentdesc', stripslashes(html_entity_decode($rr['v_description'])));
									?> </span>
								<div class="clear"></div>
							</div> -->



							<!-- <div class="frm_row"> <span class="label1">
									<label for="docs_upload">Document Upload:</label>
									<span class="star">*</span></span> <span class="input1">
									<input type="file" name="docs_file" id="docs_upload" />
									<span class="date"><strong></strong></span>

								</span>
								<div class="clear"></div>
							</div> -->

							<?php if ($_GET['editid'] != '') { ?>
								<div class="frm_row">
									<span class="label1">
										<label for="txtuplodepdf">Document Upload :</label>
										<span class="star">*</span></span> <span class="input1">
										<input type="file" name="docs_file" /><?php echo $rr['docs_file']; ?>
									</span>
									<div class="clear"></div>
								</div>
							<?php } else { ?>
								<div class="frm_row">
									<span class="label1">
										<label for="txtuplodepdf">Document Upload :</label>
										<span class="star">*</span></span> <span class="input1">
										<input type="file" name="docs_file" id="txtuplodepdf" />
									</span>
									<div class="clear"></div>
								</div>
							<?php } ?>

							<div class="frm_row"> <span class="label1">
									<label for="docs_upload">Image Upload:</label>
									<span class="star"></span></span> <span class="input1">
									<input type="file" name="image_file" id="image_upload" />
										<?php echo $rr['image_file']; ?>
									<span class="date"><strong></strong></span>

								</span>
								<div class="clear"></div>
							</div>

							<div class="frm_row"> <span class="label1">
									<label for="txtename">External Link:</label>
									<span class="star"></span></span> <span class="input1">
									<input name="ext_url" autocomplete="off" type="text" class="input_class"
										id="txtename" size="30" value="<?php echo $rr['ext_url']; ?>" />
								</span>
								<div class="clear"></div>
							</div>

							<div class="frm_row">
								<span class="label1">
									<label for="startdate">Start Date:</label><span class="star">*</span>
								</span> <span class="input_fck">
									<input type="text" name="startdate" class="input_class" id="startdate"
										readonly="readonly" autocomplete="off" value="<?php if ($rr['start_date'] != '') {
											echo changeformate($rr['start_date']);
										} else {
										} ?>" />
									<span class="date">[dd-mm-yyyy]</span>
								</span>
								<div class="clear"></div>
							</div>

							<div class="frm_row">
								<span class="label1">
									<label for="expairydate">Termination Date:</label><span class="star">*</span>
								</span> <span class="input1 input_fck">
									<input type="text" name="expairydate" class="input_class" autocomplete="off"
										readonly="readonly" id="expairydate" value="<?php if ($rr['end_date'] != '') {
											echo changeformate($rr['end_date']);
										} else {
										}
										?>" /><span class="date ">[dd-mm-yyyy]</span>
								</span>
								<div class="clear"></div>
							</div>

							<div class="frm_row">
								<span class="label1">
									<label for="txtstatus">Page Status:</label>
									<span class="star">*</span></span> <span class="input1">
									<select name="txtstatus" id="txtstatus" autocomplete="off" class="input_class"
										onchange="divcomment(this.value)">
										<option value=""> Select </option>
										<?php
										if ($user_id == '101') {
											$sql = mysqli_query($conn, "select * from content_state where state_status=1");

											while ($row = mysqli_fetch_array($sql)) {
												?>
												<option value="<?php echo $row['state_id']; ?>" <?php if ($rr['approve_status'] == $row['state_id'])
													   echo 'selected="selected"'; ?>>
													<?php echo $row['state_name']; ?>
												</option>
											<?php }
										} else if ($user_id != '101') {
											$sql = mysqli_query($conn, "select * from content_state");

											while ($row = mysqli_fetch_array($sql)) {
												if ($row['state_short'] == $role_map['draft']) {
													?>
														<option value="<?php echo $row['state_id']; ?>" <?php if ($rr['approve_status'] == $row['state_id'])
															   echo 'selected="selected"'; ?>>
														<?php echo $row['state_name']; ?>
														</option>
												<?php }

												if ($row['state_short'] == $role_map['mapprove']) {
													?>
														<option value="<?php echo $row['state_id']; ?>">
														<?php echo $row['state_name']; ?>
														</option>
												<?php }
												if ($row['state_short'] == $role_map['publish']) {
													?>
														<option value="<?php echo $row['state_id']; ?>" <?php if ($rr['approve_status'] == $row['state_id'])
															   echo 'selected="selected"'; ?>>
														<?php echo $row['state_name']; ?>
														</option>
												<?php }


											}
										}
										?>
									</select>
								</span>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>

							<div class="frm_row"> <span class="button_row">
									<input name="cmdsubmit" type="submit" class="button" id="cmdsubmit"
										value="<?php echo (isset($_GET['editid']) && $_GET['editid'] != '') ? 'Update' : 'Submit'; ?>" />&nbsp;
									<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
									<input type="hidden" name="random"
										value="<?php echo $_SESSION['logtoken']; ?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
									<input type="button" class="button" value="Back"
										onClick="javascript:location.href ='manage_vacancy.php';" />
								</span>
								<div class="clear"></div>
							</div>

						</form>

					</div>
				</div>

			</div><!-- right col -->
			<div class="clear"></div>
			<!-- Content Area end -->
		</div> <!-- area div-->
	</div> <!-- main con-->

	<!-- Footer start -->

	<?php

	include("footer.inc.php");
	?>
	<!-- Footer end -->

	</div> <!-- Container div-->
</body>

</html>
<!--left of 150 characters maximum-->
<script type="text/javascript">
	//<!--
	// This is just one validation technique, with frm parameter being the submitted form
	// function to validate the submitted form's textarea field
	function validate_textarea(frm) {
		var result = false; // assume the worst
		frm.textarea_field.className = ""; // sets display field style to be normal (could be a specific class)

		if (frm.textarea_field.value.length == 0) {
			// show error
			alert("You must enter some text (10 characters minimum)!");
		} else if (frm.textarea_field.value.length < 10) {
			// show error
			alert("You must enter atleast 10 characters!");
		} else {
			// OK
			result = true;
		}

		if (!result) {
			// focus in and highlight input field
			frm.textarea_field.className = "err"; // assumes 'err' style class defined
			frm.textarea_field.focus();
		} else {
			alert("Text entered:\n\n" + frm.textarea_field.value);
			frm.textarea_field.blur();
			frm.textarea_validate.blur();
		}

		return result;
	}

	function charactersRemaining(input, max, out) {
		if (input.value.length <= max) {
			out.value = (max - input.value.length);
		}
		else {
			out.value = 0;
		}
		//alert("charactersRemaining("+input.value+","+max+","+out.value+")");
	}

	function characterLimit(input, max) {
		if (input.value.length > max) {
			// set field's value equal to first N characters.
			input.value = input.value.substring(0, max);
			//  move cursor out of form element to stop overwrite of the first character"
			input.blur();
			alert("No more text can be entered");
		}
	}
	//-->
</script>
<script>
	function btnAddMore() {
		if ($('#addmorehid').val() < 15) {
			var i = parseInt($('#addmorehid').val()) + 1;
			$('#add_more_file').append(' <div class="frm_row" > <span class="label1"><label for="upload_img' + i + '"></label></span> <span class="input1"><input type="file" name="upload_img' + i + '" id="upload_img' + i + '" autocomplete="off" value=""/></span><div class="clear"></div></div>  ');
			$('#addmorehid').val(i);
		} else {
			//$('#add_more_file').html("You can't upload more than 15 files");
			alert("You can't upload more than 5 files");
		}
	}
</script>

<script type="text/javascript" src="js/jquery-ui.js"></script>
<!--message display error and hide-->
<script type="text/javascript">
	$(".closestatus").click(function () {
		$("#msgerror").addClass("hide").hide();
	});
</script>

<style>
	.hide {
		display: none;
	}
</style>