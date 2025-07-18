<?php
ob_start();
include("../../includes/config.inc.php");
require_once "../../includes/connection.php";
include("../../includes/useAVclass_1.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
// include("../../includes/class.upload.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
//$aid=$_SESSION['org_deg'];
$aid=$_SESSION['orgdesignation'];

$useAVclass = new useAVclass();
$useAVclass->connection();



/*-------------- Code For User Authotication------------------------ */
if($_SESSION['admin_auto_id_sess']=='')
	{	
	session_unset($admin_auto_id_sess);
	session_unset($login_name);
	session_unset($dbrole_id);
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
	exit;	
	}
	
if($_SESSION['saltCookie'] !=$_COOKIE['Temp'])
{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
}
/* -------------Close User Authotication Code------------ */

/* -------------Variable defined for choose language------------ */
if($_SESSION['lname']=='English')
{
$lan='1';
}
else if($_SESSION['lname']=='Hindi')
{
$lan='2';
}

$module_id='Manage Organization Chart';
$role_id = $_SESSION['dbrole_id'];
$user_id = $_SESSION['admin_auto_id_sess']; 
$root_adminid=$_SESSION['root_adminid'];
// $role_map = role_permission($user_id, $module_id); 


/* --------------Code For Submit data in to database------------------*/  
   
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
			

			$designationId 	= trim($_POST['designationId']);
			$txtename 		= trim($_POST['txtename']);
			$txtpageurl 	= trim($_POST['txtpageurl']);
			$txtpageurl 	= str_replace('.php','', $txtpageurl);
			$url 			= seo_url($txtpageurl);
			$txtemail 		= trim($_POST['email']);
			$contact_no 	= trim($_POST['contact_no']);
			$txtroom 		= trim($_POST['roomno']);
			$txtcategory 	= trim($_POST['txtcategory']);
			$sortcontentdesc= trim($_POST['sortcontentdesc']);
			$txtcontentdesc	= trim($_POST['txtcontentdesc']);
			$txtlanguage 	= trim($_POST['txtlanguage']);
			$txtstatus 		= trim($_POST['txtstatus']);
			$retirementdate	= trim($_POST['r_date']);
			$sta			= explode('-',$retirementdate);
			//$r_date			= $sta['2']."-".$sta['1']."-".$sta['0'];
      if (isset($sta['0'], $sta['1'], $sta['2']) && !empty($sta['0']) && !empty($sta['1']) && !empty($sta['2'])) {
        $r_date = $sta['0'] . "-" . $sta['1'] . "-" . $sta['2'];
      } else {
          $r_date = "0000-00-00";
      }
			$user_status	= trim($_POST['user_status']); 
			$parentId 		= trim($_POST['parentId']);

			$errmsg = "";
			$createdate = date('Y-m-d');
			if ($txtlanguage == '2') {
				if (trim($txtlanguage) == "") {
					$errmsg = "Please select language." . "<br>";
				}
				
				if (trim($txtpageurl) == "") {
					$errmsg .= "Please enter Page Url." . "<br>";
				} elseif (!preg_match('/^[A-Za-z -_]+$/i', $txtpageurl)) {
					$errmsg .= "Page Url should be Alphabats only." . "<br>";
				}

				if(trim($txtroom)!="")
				{
					if(preg_match("/^[a-zA-Z0-9'-_() &amp;\"]{1,20}$/", trim($txtroom)) === 0)
					{
						$errmsg.="Room Number should be valid."."<br>";
					}
				}
			}
			else 
			{
			
				if (trim($txtlanguage) == "") {
				$errmsg = "Please select language." . "<br>";
				}

				if(trim($designationId)=="")
				{
					$errmsg .="Please Select Designation."."<br>";
				}
				if(trim($txtename)=="")
				{
					$errmsg .="Please Enter The Name."."<br>";
				}


	
				if (trim($txtpageurl) == "") {
					$errmsg .= "Please enter Page Url." . "<br>";
				} elseif (!preg_match('/^[A-Za-z -_]+$/i', $txtpageurl)) {
					$errmsg .= "Page Url should be Alphabats only." . "<br>";
				}

				
				if((trim($sortcontentdesc) !="") && (preg_match("/^[a-zA-Z0-9 _.,:\"\']{5,175}+$/", $sortcontentdesc) === 0))
				{
					$errmsg .="Please enter Alphanumeric characters, Special Characters( _.,: ) that should be minimum 5 and maximum 175 in Sort Description."."<br>";
				}
				
				if ($_FILES["txtuplode"]["tmp_name"] != "")
				{
					$tempfile=($_FILES["txtuplode"]["tmp_name"]);
					$imageinfo = ($_FILES["txtuplode"]["type"]);
					$section = strtoupper(base64_encode(file_get_contents($tempfile)));
					 $nsection=substr($section,0,8);
			
					 if( !preg_match("/^[a-zA-Z0-9.]+$/", $_FILES["txtuplode"]["name"]) )
					 {
						 $errmsg .= 'Uploaded file name should be alphanumeric only.<br>';
					 }else if ( $section != strip_tags($section) )
					 {
						$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
					 }else{
						 //echo $section;die();
						$imageinfo = getimagesize($_FILES["txtuplode"]["tmp_name"]);
			
						$extarray = explode(".",$_FILES["txtuplode"]["name"]);
						if(count($extarray)>2)
						{
							$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
						}elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
						{
							$errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images.<br>';
						}elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
						{}else{
							$errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only.<br>';
						}
						if ($_FILES["txtuplode"]["size"] < 1)
						{
							$errmsg .= "Image Size is too less.<br>";
						}
						if ($_FILES["txtuplode"]["size"] >=(1048576*5))
						{
							$errmsg .= IMAGE_SIZE_LIMIT."<br>";
						}
						
					}
				}


				if(trim($txtemail)!="")
				{
					if(!filter_var(trim($txtemail), FILTER_VALIDATE_EMAIL)){
						
					$errmsg.="Please enter valid email Id."."<br>";
					}
				}
				
				
				if(trim($contact_no)!="")
					{
				 if(preg_match("/^[0-9]{8,12}$/", trim($contact_no)) === 0)
				{
				$errmsg.="Phone Number should be 8 to 12 digits."."<br>";
				}
				}
					
				if(trim($txtroom)!="")
				{
					if(preg_match("/^[a-zA-Z0-9'-_() &amp;\"]{1,20}$/", trim($txtroom)) === 0)
					{
						$errmsg.="Room Number should be valid."."<br>";
					}
				}
				if(trim($user_status)==""){
					$errmsg .="Please Select Profile  Status."."<br>";
				}
				
				if(trim($txtstatus)=="")
				{
					$errmsg .="Please Select Status."."<br>";
				}
	
			}
		}

    if ($errmsg == '') {
		
		if ($_FILES["txtuplode"]["name"]!="")
		{
			$txtuplode=$_FILES['txtuplode']['name'];
			$txtuplode = preg_replace("/[^a-zA-Z0-9.]/", "", $txtuplode);
			$uniq = uniqid("");
			$txtuplode=$uniq.$txtuplode;		
			$PATH="../../upload/profile";
			$PATH=$PATH."/"; 
			$val=move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
			$size=filesize($PATH.$txtuplode);
			$size=ceil($size/1024);
			$found="false";
		
		}

		// $check_status=check_status($user_id,$txtstatus,$model_id);
			// if($check_status >0)
			// {
			 // $txtstatus; 
			// }

        // $tableName_send = "organizationchart";
        // $tableFieldsName_old = array("language_id","designation","name","email","img_uplode","retiere_date", "phone", "short_desc","create_date", "approve_status","content","url","profile_status","level","room");
		// $tableFieldsValues_send = array("$txtlanguage","$designationId","$txtename","$txtemail","$txtuplode","$r_date","$contact_no","$sortcontentdesc", "$createdate","$txtstatus","$txtcontentdesc","$url","$user_status","$parentId","$txtroom");
		// $value = $useAVclass->insertQuery($tableName_send, $tableFieldsName_old, $tableFieldsValues_send);
		
	 	$sql = "INSERT INTO `organizationchart`(`language_id`, `designation`, `name`, `email`, `img_uplode`, `retiere_date`, `mobile`, `short_desc`, `create_date`, `approve_status`, `content`, `url`, `profile_status`, `level`, `room`, `responsibility`,`intercom`) VALUES('$txtlanguage','$designationId','$txtename','$txtemail','$txtuplode','$r_date','$contact_no','$sortcontentdesc', '$createdate','$txtstatus','$txtcontentdesc','$url','$user_status','$parentId','$txtroom', '0','0')";
		$sql21 = $conn->query($sql);
	
        $page_id = $conn->insert_id;
		
		 $user_id = $_SESSION['admin_auto_id_sess'];
        // $page_id = mysql_insert_id();
        $action = "Insert";
        $categoryid = '1';
        $date = date("Y-m-d h:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
       
	   // $tableName = "audit_trail";
        // $tableFieldsName_old = array("user_login_id", "page_id", "page_name", "page_action", "page_category", "page_action_date", "ip_address", "lang", "page_title", "approve_status");
        // $tableFieldsValues_send = array("$user_id", "$page_id", "$txtename", "$action", "$module_id", "$date", "$ip", "$txtlanguage", "$txtepage_title", "$txtstatus");
        // $value = $useAVclass->insertQuery($tableName, $tableFieldsName_old, $tableFieldsValues_send);

		//$sql5 = "INSERT INTO `audit_trail`(`user_login_id`, `page_id`, `page_name`, `page_action`, `page_category`, `page_action_date`, `ip_address`, `lang`, `page_title`, `approve_status`)VALUES('$user_id','$page_id','$txtename','$action','$module_id','$date','$ip','$txtlanguage','$txtepage_title','$txtstatus')";
		//$sql21 = $conn->query($sql5);

        $msg = CONTENTADD;
        $_SESSION['content'] = $msg;
        header("location:organization-chart.php");
        exit;
        
		 }
       
    }

$edit_contrator ="select * from organizationchart";
$contrator_result = $conn->query($edit_contrator);
$res_rows = $contrator_result->num_rows;

$fetch_result = $contrator_result->fetch_array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Add Organization Chart: <?php echo $sitename;?></title><meta name="description" content=""/>
        <meta name="keywords" content="" />


        <link href="style/admin.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jsDatePick.js"></script>
<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />

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
<script type="text/javascript">
function getPage(id) {
	//alert(id);
    //generate the parameter for the php script
    var data = 'state_id=' + id;
    $.ajax({
        url: "orgcategory.php",  
        type: "POST", 
        data: data,     
        cache: false,
        success: function (pub){ 
		 $('#loading').hide(); 
            $('#test').html(pub);			
        }       
    });
}

function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
	      {
		  	alert("Please enter numeric value only");
              return false;
		  }
		else
		  {
              return true;
		  }
    }
	
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"r_date",
			dateFormat:"%d-%m-%Y"
		});
		
	};
 
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
 <?php
		include_once('main_menu.php');
	 ?>
  <!-- Header end -->
  

  
  <div class="main_con">
  <div class="admin-breadcrum">
<div class="breadcrum">
  <span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass"><a href="organization-chart.php">Manage Organization Chart</a></span>
			 <span class="submenuclass">>> </span> 
			<span class="submenuclass">Add Organization Profile</span>
	</div>
<div class="clear"> </div>
</div>  
       
                                
                                <div class="right_col1">

                                    <div class="clear"></div>

<?php if($errmsg!=""){?>
<div  id="msgerror" class="status error">
<div class="closestatus" style="float: none;">
<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
</div>
</div>
          <?php }?>
                                    <div class="clear"></div>
                                   
                                     <div class="addmenu"> 
    <div class="internalpage_heading">

  <h3 class="manageuser">
Add Organization Chart
</h3>


 </div>	

                                    <div class="grid_view">
                                        <form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return add_org('form1')">
            
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
									<?php if($res_rows >0) { ?>
									<div class="frm_row"> <span class="label1">
									<label for="parentId">Parent Id :</label>
									<span class="star">*</span></span> <span class="input1">
							<?php 
								$sqlquery= "SELECT `og`.* FROM `organizationchart` as `o` LEFT JOIN `org_setup` as `og` ON `og`.`deg_id`=`o`.`designation` WHERE `o`.`approve_status`='3' group by `designation`;";
								$rs = $conn->query($sqlquery);	
							?>
									<select name="parentId" id="parentId">
									<option value="">Select</option>
									<?php while($result=$rs->fetch_array())
									{
									 ?>
									<option value="<?php echo $result['deg_id'];?>"<?php if($result['deg_id']==$parentId) { echo  "selected='selected'"; } else {
									} ?>><?php echo $result['designation']; ?> </option>
									<?php } ?>
									</select>
									</span>
											<div class="clear"></div>
										</div>
									<?php } ?> 
									<div class="frm_row"> <span class="label1">
									<label for="designationId">Designation :</label>
									<span class="star">*</span></span> <span class="input1">
									<?php 
									$sqlquery="Select * from org_setup where approve_status='3' order by deg_id ASC"; 
									$rss = $conn->query($sqlquery);
									?>
									<select name="designationId" id="designationId">
									<option value="">Select</option>
									<?php while($result=$rss->fetch_array())
									{
									 ?>
									<option value="<?php echo $result['deg_id'];?>"<?php if($result['deg_id']==$designationId) { echo  "selected='selected'"; } else {
									} ?>><?php echo $result['designation']; ?></option>
									<?php } ?>
									</select>
									</span>
											<div class="clear"></div>
										</div>
			
												
			                                          <div class="frm_row"> <span class="label1">
                                                        <label for="txtename" >Name:</label>
                                                        <span class="star">*</span></span> <span class="input1">
                                                        <input name="txtename" autocomplete="off" type="text" class="input_class" id="txtename" size="30"   value="<?php if (htmlspecialchars($txtename != "")) {
    echo htmlspecialchars($txtename);} ?>"/>

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>

                                                <div class="frm_row"> <span class="label1">
                                                        <label>Page Url(In English):</label>
                                                        <span class="star">*</span></span> <span class="input1">
                                                        <input name="txtpageurl" autocomplete="off" type="text" class="input_class" id="txtpageurl" size="30"   value=""/>

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>


												<div class="frm_row"> <span class="label1">
<label for="txtuplode">Image Upload:</label>
</span> <span class="input1">
	<input type="file" autocomplete="off" name="txtuplode" id="txtuplode" />
</span>
<div class="clear"></div>
</div>
												<div class="frm_row"> <span class="label1">
                                                        <label for="email" >Email:</label>
                                                        </span> <span class="input1">
     <input name="email" autocomplete="off" type="text" class="input_class" id="email" size="30" placeholder="xyz@gmail.com"   value="<?php if (htmlspecialchars($email != "")) {
    echo htmlspecialchars($email);} ?>"/>

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
												<div class="frm_row"> <span class="label1">
                                                        <label for="contact_no">Contact Number:</label>
                                                        </span> <span class="input1">
                                                        <input name="contact_no" autocomplete="off" type="text" class="input_class" id="contact_no" maxlength="12"   value="<?php if (htmlspecialchars($contact_no != "")) { echo htmlspecialchars($contact_no);} ?>" onkeypress="return isNumberKey(event)" maxlength="12"/>

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
												<div class="frm_row"> <span class="label1">
                                                        <label for="roomno">Room Number:</label>
                                                        </span> <span class="input1">
                                                        <input name="roomno" autocomplete="off" type="text" class="input_class" id="roomno"  value="<?php if (htmlspecialchars($roomno != "")) { echo htmlspecialchars($roomno);} ?>" />

                                                    </span>
                                                    <div class="clear"></div>
                                                </div>
												 <div class="frm_row"> <span class="label1">
				<label for="r_date">Retirement Date:</label>
				</span> <span class="input1">
				<input type="text" name="r_date" id="r_date"  value="<?php if($r_date!=""){ echo $r_date;} ?>" readonly="readonly"  onKeyPress="return isNumberKey(event)"  autocomplete="off"placeholder="DD-MM-YYYY" required/><span class="date">[dd-mm-yyyy]</span>
				
				</span>
				<div class="clear"></div>
												<div class="frm_row"> <span class="label1">	
                                                            <label for="sortcontentdesc" >Short Description:</label>
                                                      </span> <span class="input1">
<textarea id="sortcontentdesc" name="sortcontentdesc" cols="35" rows="2" placeholder="Enter Message"><?php echo html_entity_decode($sortcontentdesc);?></textarea> 	
	<span id="chars" class="date">Maximum 175 characters</span>
                                                        </span>
                                                        <div class="clear"></div>
                                                    </div>
   <div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        </span> <span class="input_fck">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($txtcontentdesc)));
		?>        </span>
        <div class="clear"></div>
        </div>
		 <div class="frm_row"> <span class="label1">
              <label for="user_status">Profile Status:</label> <span class="star">*</span>
            </span> <span class="input1">
              <select name="user_status" id="user_status" autocomplete="off">
	<option value=""> Select </option>
<?php 
foreach($status as  $key => $value)
{
	?>
<option value="<?php echo $key; ?>"<?php if($key==$fetch_result['user_status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
<?php }
 ?>
</select>
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
if ($user_id == '101' || $user_id=='104' || $aid!='') {
    $sql = "select * from content_state where state_status=1 and  state_id!=4";
	$result = $conn->query($sql);
    while ($row = $result->fetch_array()) {
        ?>
                                                                    <option value="<?php echo $row['state_id']; ?>" <?php if ($txtstatus == $row['state_id']) echo 'selected="selected"'; ?>><?php echo $row['state_name']; ?></option>
    <?php
    }
}
else if ($user_id != '101' || $user_id != '104') {
    $sql = "select * from content_state";
	$result1 = $conn->query($sql);

    while ($row = result1->fetch_array()) {
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
                                                <input type="button" class="button" value="Back" onClick="javascript:location.href = 'organization-chart.php'" />
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

                                                            <?php
                                                            include("footer.php");
                                                            ?>
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