<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
include("../../includes/functions-data.php");

$useAVclass = new useAVclass();
$useAVclass->connection();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
if ($_SESSION['admin_auto_id_sess'] == '') {
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg;
	header("Location:index.php");
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
$role_id = $_SESSION['dbrole_id'];


$sql = "Select * from vacancy where id='$page_id' ";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);
@extract($data);
$location = getJobLocationById($location_id);
$category = getJobCategoryById($category_id);
$image_path = $HomeURL . "/upload/academy_souvenir/images/" . $image_file;
?>



<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php echo $job_title; ?> Detail:<?php echo $sitename; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="style/popadmin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		<!--
		function toggle() {
			var ele = document.getElementById("toggleText");
			var text = document.getElementById("displayText");
			if(ele.style.display == "block") {
					ele.style.display = "none";
				text.innerHTML = "Show Password";
				}
			else {
				ele.style.display = "block";
				text.innerHTML = "Hide Password";
			}
		} 
		
		function MM_callJS(jsStr) { //v2.0
		  return eval(jsStr)
		}
		//-->
	</script>
</head>

<body>
	<?php //include('top_header.php'); ?>

	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">

		<tr>
			<td colspan="3" class="heading"><?php echo $v_title; ?></td>
		</tr>

		<tr>
			<td colspan="3">

				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">

					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>


					<tr>
						<td align="left" valign="top" class="content_page"><strong><span
									class="label2">Description</span></strong></td>
						<td>:</td>
						<td align="justify" class="label1"><?php echo html_entity_decode($v_description); ?></td>
					</tr>
					<tr>
						<td align="left" valign="top" class="content_page"><strong><span class="label2">Create Date
								</span></strong></td>
						<td>:</td>
						<td align="justify" class="label1"> <?php echo date($start_date); ?> </td>
					</tr>
					<tr>
						<td align="left" valign="top" class="content_page"><strong><span class="label2">Expire Date
								</span></strong></td>
						<td>:</td>
						<td align="justify" class="label1"> <?php echo date($end_date); ?> </td>
					</tr>

					<tr>
						<td colspan="3" align="center">
							<table border="0" cellpadding="2" cellspacing="2">
								<tr>
									<td>
										<input type="button" class="button" value="Close"
											onclick="MM_callJS('window.close();')">
									</td>
								</tr>
							</table>
						</td>
					</tr>

				</table>
		</tr>

		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</table>

</body>

</html>