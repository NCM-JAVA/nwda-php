<?php
ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include("../../includes/functions.inc.php");
$useAVclass = new useAVclass();
$useAVclass->connection();
if ($_SESSION['admin_auto_id_sess'] == '') {
    $msg = "Login to Access Admin Panel";
    $_SESSION['sess_msg'] = $msg;
    header("Location:index.php");
    exit;
}
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$sql = "select * from admin_login where id ='$admin_auto_id_sess'";
$result = $conn->query($sql);
$num = $result->num_rows;
if ($line = $result->fetch_array()) {
    @extract($line);
}

if (isset($cmdsubmit)) {
    $txtemail = addslashes(htmlspecialchars($txtemail));
    $flag = "OK";   // This is the flag and we set it to OK
    $errmsg = "";        // Initializing the message to hold the error messages
    if (trim($txtemail) == "") {
        $errmsg = "Please enter valid email id in format like abc@def.com.";
        $flag = "NOTOK";   //setting the flag to error flag.
    } elseif (strlen($txtemail) >= 80) {
        $errmsg = $errmsg . "Email id  length should not be greater than 80 character.";
        $flag = "NOTOK";   //setting the flag to error flag.
    } elseif (!filter_var($txtemail, FILTER_VALIDATE_EMAIL)) {
        $errmsg = $errmsg . "Please enter valid email Id.";
        $flag = "NOTOK";   //setting the flag to error flag.
    } elseif (trim($txtemail) != "") {
        $tableName_send = "admin_login";
        $field_name = "user_email";
        $field_id = "id";
        $id = $cid;
       // $checkuniqe = edit_check_unique($tableName_send, $field_name, $txtemail, $field_id, $id);
		$sql         = "select * from " . $tableName_send . " where " . $field_name . " ='" . $txtename . "' and " . $field_name1 . " !='" . $cid . "' ";
		$rs          = $conn->query($sql);
		$result_rows = $rs->num_rows;
		if ($result_rows > 0) {
			$checkuniqe ='1';
			
		} else {
			$checkuniqe ='0';
			
		}
		
        if ($checkuniqe > 0) {
            $errmsg = $errmsg . "Email id already exist." . "<br>";
        }
    }

    if ($errmsg == '') {
        if ($_SESSION['logtoken'] != $_POST['random']) {

            /* session_unset($admin_auto_id_sess);
              session_unset($login_name);
              session_unset($dbrole_id); */
            $msg = "Login to Access Admin Panel";
            $_SESSION['sess_msg'] = $msg;
            header("Location:error.php");
            exit();
        }
        $tableName_send = "admin_login";
        $whereclause = "id = '$admin_auto_id_sess'";
        $old = array("user_email");
        $new = array("$txtemail");
		
     //   $val = $useAVclass->UpdateQuery($tableName_send, $whereclause, $old, $new);
	 
		$sql1 = "UPDATE `audit_trail` SET `user_email`='$txtemail' WHERE id = '$admin_auto_id_sess'";
			$sqli11 = $conn->query($sql1);

        $user_login_id = $_SESSION['admin_auto_id_sess'];
        $page_id = $val;
        $url = substr(strrchr($_SERVER['REQUEST_URI'], "/"), 1);

        $action = "Update  super admin";
        $categoryid = '0'; //super admin
        $date = date("Y-m-d h:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        // $tableName = "audit_trail";
        // $tableFieldsName_send = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title");
        // $tableFieldsValues_send = array("$user_login_id", "$page_id", "$url", "$action", "$model_id", "$date", "$ip", "$txtlanguage", "$txtepage_title");
        // $value = $useAVclass->insertQuery($tableName, $tableFieldsName_send, $tableFieldsValues_send);
		
		$sql = "INSERT INTO `audit_trail` (`user_login_id`,`page_id`,`page_name`,`page_action`,`page_category`,`page_action_date`,`ip_address`,`lang`,`page_title`)VALUES ('$user_login_id','$page_id','$url','$action','$model_id','$date','$ip','$txtlanguage','$txtepage_title')";
			$sqli1 = $conn->query($sql);
					
		
        $msg = PROFILE_ADMIN_UPDATED;
        $_SESSION['edit_prof'] = $msg;
        header("location: profile.php");
        exit;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Edit Profile : <?php echo $sitename;?></title>
<link rel="SHORTCUT ICON" href="images/favicon.ico" />
        <link href="style/admin.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/validation.js"></script>
                   <!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->



                    </head>
                    <body>
<?php include('top_header.php'); ?>
                        <div id="container"> 

                            <!-- Header start -->

                           
                          
<?php include_once('main_menu.php'); ?>
                            <!-- Header end -->

                            <div class="main_con">
<div class="admin-breadcrum">
<div class="breadcrum">
	<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			<span class="submenuclass">>> </span>
			<span class="submenuclass">Edit Profile</span>
  </div>
<div class="clear"> </div>
</div>    
                                
                                <div class="content-content">
                                    <div class="right_col1"> 
<?php if ($_SESSION['edit_prof'] != '') { ?>
                                            <div  id="msgclose" class="status success">
                                                <div class="closestatus" style="float: none;">
                                                    <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                                                    <p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['edit_prof'];
$_SESSION['edit_prof'] = "";?>
</p>
                                                </div>
                                            </div>
<?php } ?>
<?php if ($errmsg != "") { ?>
                                            <div  id="msgerror" class="status error">
                                                <div class="closestatus" style="float: none;">
                                                    <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                                                    <p><img alt="error" src="images/error.png"> <span>Attention! <br />
                                                            </span><?php echo $errmsg; ?></p>
                                                </div>
                                            </div>
                                                        <?php } ?>

										
                                       <div class="cpanel-password">
                     <div class="cpanel-right_heading"><h3 class="editprofile">Edit Profile</h3>  </div>
                                            <form id="form1" name="form1" autocomplete="off" method="post" action="" onSubmit="return edit_emacil('form1');">
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="">Login ID:</label>
                                                    </span> <span class="label2"><?php echo $login_name; ?></span>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="txtemail">Email:</label>
                                                        <span class="star">*</span></span> <span class="input1">
                                                        <input name="txtemail" autocomplete="off" type="text" class="input_class" id="txtemail" size="40" maxlength="100" value="<?php echo $user_email; ?>"/>
                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="frm_row"> <span class="button_row">
                                                        <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Update" />
                                                        <input name="cid" type="hidden" value="<?php echo $id; ?>"/>
                                                        <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken']; ?>">
                                                            <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
                                                            <input type="button" class="button" value="Back" onClick="javascript:location.href = 'welcome.php';" />
                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- <div class="return_dashboard"> <a href="welcome.php" title="Return to Dashboard">Return to Dashboard</a></div>-->
                                        <div class="clear"></div>

                                    </div>
                                    <!-- right col -->

                                    <div class="clear"></div>
                                </div>
</div>

                            </div>
                            <!-- main con--> 

                            <!-- Footer start -->

<?php include("footer.inc.php"); ?>
                            <!-- Footer end --> 

                        </div>
                        <!-- Container div-->
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
