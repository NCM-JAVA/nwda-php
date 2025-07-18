<?php
ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
 include("../../includes/useAVclass_1.php");
 include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
 include_once 'ckfinder/ckfinder.php';
//include("../../includes/class.upload.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();

if ($_SESSION['admin_auto_id_sess'] == '') {
    session_unset($admin_auto_id_sess);
    session_unset($login_name);
    session_unset($dbrole_id);
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

if ($_SESSION['lname'] == 'English') {
    $lan = '1';
} else if ($_SESSION['lname'] == 'Hindi') {
    $lan = '2';
}
$module_id='Manage Designation';
$role_id = $_SESSION['dbrole_id'];
$user_id = $_SESSION['admin_auto_id_sess']; 
$root_adminid=$_SESSION['root_adminid'];
// $role_map = role_permission($user_id, $module_id); 
if ($role_map['draft'] != 'DR' && $user_id != '101') {
    $msg = "Login to Access Admin Panel";
    $_SESSION['sess_msg'] = $msg;
    header("Location:error.php");
    exit;
}

if (isset($cmdsubmit)) {
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
 if ($_SESSION['logtoken'] != $_POST['random']) {
            $msg = "Login to Access Admin Panel";
            $_SESSION['sess_msg'] = $msg;
            header("Location:error.php");
            exit();
        }
		else {
            $_COOKIE['Temp'] = "";
            $_SESSION['saltCookie'] = "";
            $_SESSION['Temptest'] = "";
            $saltCookie = uniqid(rand(59999, 199999));
            $_SESSION['saltCookie'] = $saltCookie;
            $_SESSION['Temptest'] = $_SESSION['saltCookie'];
            setcookie("Temp", $_SESSION['saltCookie']);
            $_SESSION['logtoken'] = md5(uniqid(mt_rand(), true));
			
			$designation = trim($_POST['designation']);
			$txtcategory = $_POST['txtcategory'] ? trim($_POST['txtcategory']) : 0;
			$txtlanguage = trim($_POST['txtlanguage']);
			$txtstatus 	 = trim($_POST['txtstatus']);
			$errmsg = "";
			$createdate = date('Y-m-d');
					if ($txtlanguage == '2') {
					if (trim($txtlanguage) == "") {
					$errmsg = "Please select language." . "<br>";
					}
					
					/*if (trim($txtcategory) == "") {
					$errmsg .="Please select category." . "<br>";
					}*/
					/*if(trim($designation)=="")
					{
					$errmsg .="Please enter designation."."<br>";
					}*/
					
					
					
					if (trim($txtstatus) == "") {
					$errmsg .="Please select page status." . "<br>";
					}
					}
					else {
					if (trim($txtlanguage) == "") {
					$errmsg = "Please select language." . "<br>";
					}
					
					
					if(trim($designation)=="")
					{
					$errmsg .="Please enter designation."."<br>";
					}
					/*else if(preg_match("/^[aA-zZ][a-zA-Z -() &amp; ]{2,174}+$/", $designation) == 0)
					{
					$errmsg .= "Designation must be from letters that should be minimum 3 and maximum 175."."<br>";
					}*/
					
					
					if (trim($txtstatus) == "") {
					$errmsg .="Please select page status." . "<br>";
					}
					}
			}
	
    if ($errmsg == '') {
        
        
        // $check_status = check_status($user_id, $txtstatus, $module_id);
        // if ($check_status > 0) {
            // $txtstatus;
        // }
        // $tableName_send = "org_setup";
        // $tableFieldsName_old = array("language_id","designation","category_id","create_date", "approve_status");
		// $tableFieldsValues_send = array("$txtlanguage","$designation","$txtcategory","$createdate","$txtstatus");
		// $value = $useAVclass->insertQuery($tableName_send, $tableFieldsName_old, $tableFieldsValues_send);
	  
		$sql4 = "INSERT INTO `org_setup`(`language_id`, `designation`, `category_id`, `create_date`, `approve_status`)VALUES('$txtlanguage','$designation','$txtcategory','$createdate','$txtstatus')";
		$sql1 = $conn->query($sql4);

		$user_id = $_SESSION['admin_auto_id_sess'];
        $page_id = $conn->insert_id;
        $action = "Insert";
        $categoryid = '1';
        $date = date("Y-m-d h:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
      /*   $tableName = "audit_trail";
        $tableFieldsName_old = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title", "approve_status");
        $tableFieldsValues_send = array("$user_id", "$page_id", "$txtename", "$action", "$module_id", "$date", "$ip", "$txtlanguage", "$txtepage_title", "$txtstatus");
        $value = $useAVclass->insertQuery($tableName, $tableFieldsName_old, $tableFieldsValues_send);
 */
		//$sql5 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$module_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
		//$sql21 = $conn->query($sql5);

        $msg = CONTENTADD;
        $_SESSION['content'] = $msg;
        header("location:designation.php");
        exit;
        
		 }
       
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add Designation: DDA</title><meta name="description" content=""/>
        <meta name="keywords" content="" />

        <script type="text/javascript" src="js/jsDatePick.js"></script>
        <link href="style/admin.css" rel="stylesheet" type="text/css">
        <link href="style/dropdown.css" rel="stylesheet" type="text/css">
         <link href="style/jquery.css" rel="stylesheet" type="text/css">
          <link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
           <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
           <script language="JavaScript" src="js/validation.js"></script>
			<script type="text/javascript" src="js/jquery-latest.js"></script>
			<script src="js/jquery.tinylimiter.js"></script>
			<script>
$(document).ready( function() {
	var elem = $("#chars");
	$("#sortcontentdesc").limiter(175, elem);
});
</script>



                    <!--[if IE 7]>
                            <link rel="stylesheet" type="text/css" href="style/ie7.css">
                    <![endif]-->
                   

					<script type = "text/javascript" >
						  function burstCache() {
							if (!navigator.onLine) {
								document.body.innerHTML = 'Loading...';
								window.location = 'index.php';
							}
						}
					</script>

					<script>
					var a=navigator.onLine;
					if(a){
					// alert('online');
					}else{
					alert('offline');
					window.location='index.php';
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
                                
                                <div class="right_col1">

                                    <div class="clear"></div>


<?php if ($errmsg != "") { ?>
                                        <div  id="msgerror" class="status error">
                                            <div class="closestatus" style="float: none;">
                                                <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                                                <p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
                                            </div>
                                        </div>
<?php } ?>
                                    <div class="clear"></div>
                                   
                                     <div class="addmenu"> 
    <div class="internalpage_heading">
  <h3 class="manageuser">Add Designation</h3>
 </div>	

                                    <div class="grid_view">
                                        <form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data"  onsubmit="return add_designation('form1')">
            
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="txtlanguage">Page Language :</label>
                                                        <span class="star">*</span></span>
														 <span class="input1">
							 <select name="txtlanguage" id="txtlanguage" autocomplete="off"  >
							<option value="">Select</option>
							<?php 
							foreach($language as $key=>$value)
							{
								?>
							<option value="<?php echo $key; ?>" <?php if($key==$txtlanguage){ echo 'selected="selected"'; } else { }?>><?php echo $value; ?></option>
							<?php }
							 ?>
							</select>
													   </span>
                                                    <div class="clear"></div>
                                                    <div class="loading"></div>
                                      </div>
									 
									  
									  
									  					 <div class="frm_row"> <span class="label1">
                                                        <label for="designation">Designation:</label>
                                                        <span class="star">*</span></span> <span class="input1">
                                                        <input name="designation" autocomplete="off" type="text" class="input_class" id="designation" size="30"   value="<?php if (htmlspecialchars($designation != "")) {
    echo htmlspecialchars($txtename);} ?>"/>

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
			                                        
                                                <div class="frm_row"> 
                                                    <span class="label1">
                                                        <label for="txtstatus">Page Status:</label>
                                                        <span class="star">*</span></span> <span class="input1">
                                                        <select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
                                                            <option value=""> Select </option>
<?php
if ($user_id == '101') {
    $sql = "select * from content_state where state_status=1 and  state_id!=4";
$rs = $conn->query($sql);
    while ($row = $rs->fetch_array()) {
        ?>
                                                                    <option value="<?php echo $row['state_id']; ?>" <?php if ($txtstatus == $row['state_id']) echo 'selected="selected"'; ?>><?php echo $row['state_name']; ?></option>
    <?php
    }
}
else if ($user_id != '101') {
    $sql = "select * from content_state";
$rss = $conn->query($sql);
    while ($row = $rss->fetch_array()) {
        if ($row['state_short'] == $role_map['draft']) {
            ?>
                                                                        <option value="<?php echo $row['state_id']; ?>" <?php if ($txtstatus == $row['state_id']) echo 'selected="selected"'; ?>><?php echo $row['state_name']; ?></option>
        <?php
        }

        if ($row['state_short'] == $role_map['mapprove']) {
            ?>
                                                                        <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
        <?php
        }
        if ($row['state_short'] == $role_map['publish']) {
            ?>
                                                                        <option value="<?php echo $row['state_id']; ?>" <?php if ($txtstatus == $row['state_id']) echo 'selected="selected"'; ?>><?php echo $row['state_name']; ?></option>
                                                        <?php
                                                        }
                                                       
    }
}
?>
                                                        </select>
                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                               
                                                <div class="frm_row"> <span class="button_row">
                                                <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Submit" />&nbsp;
                                                <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
                                                <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken']; ?>" />&nbsp;
                                                <input type="button" class="button" value="Back" onClick="javascript:location.href = 'designation.php'" />
                                                    </span>
                                                    <div class="clear"></div>
                                                </div>

                                        </form>
                                    </div>
                                    </div>
                                </div><!-- right col -->
                                <div class="clear"></div>
                                <!-- Content Area end -->
                            </div>  <!-- area div-->
                        </div>  <!-- main con-->

                       

                        </div> <!-- Container div-->
                        
                         <!-- Footer start -->

<?php include("footer.php"); ?>
                            <!-- Footer end -->
                    </body>
                    </html>

                    <script type="text/javascript">
                        $(".closestatus").click(function() {
                            $("#msgerror").addClass("hide").hide();
                        });
                    </script>

                    <style>
                        .hide {display:none;}
                    </style>