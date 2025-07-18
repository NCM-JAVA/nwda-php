<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass_1.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
if($_SESSION['admin_auto_id_sess']=='')
{
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:index.php");
	exit;
}
if($role_id > 0)
{
	$msg = "Login to Access Admin Panel";
	$_SESSION['sess_msg'] = $msg ;
	header("Location:error.php");
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
if($_SESSION['lname']=='English')
{
$lan='1';
}
else if($_SESSION['lname']=='Hindi')
{
$lan='2';
}

if(isset($cmdsubmit) && $_GET['editid']=='')
{
//	 die;
//graduation post
$percentage= check_input($_POST['g_percentage']);
$g_min_percent=$select_qualification;
$g_no_percent=array_values(array_diff($qualification, $g_min_percent));
//post graduation
$post_percentage= check_input($_POST['percentage']);
$post_min_percent=$select_post_qualification;
$post_no_percent=array_values(array_diff($postqualification, $post_min_percent));

$postname = check_input($_POST['postname']);
$ptype = check_input($_POST['ptype']);
if($ptype==2)
{
$salary= check_input($_POST['salary']);
}
else
{
$salary = check_input($_POST['pscale']);
}

$gen= check_input($_POST['gen']);
$obc= check_input($_POST['obc']);
$scst= check_input($_POST['scst']);
$genph= check_input($_POST['genph']);
$obcph= check_input($_POST['obcph']);
$scstph= check_input($_POST['scstph']);
$exservice= check_input($_POST['exservice']);
$others= check_input($_POST['others']);
$incan= check_input($_POST['incan']);
$exservice_OBC= check_input($_POST['exservice_OBC']);
$exservice_SCST= check_input($_POST['exservice_SCST']);
$exservice_PH= check_input($_POST['exservice_PH']);
$exservice_GENPH= check_input($_POST['exservice_GENPH']);
$exservice_SCSTPH= check_input($_POST['exservice_SCSTPH']);
$exservice_OBCPH= check_input($_POST['exservice_OBCPH']);
$age1= check_input($_POST['age']);
$agenew = split('-', $age1);
$age = $agenew['2'] . "-" . $agenew['1'] . "-" . $agenew['0'];
$ddamount= check_input($_POST['ddamount']);
$totalexp= check_input($_POST['totalexp']);
$phsubcat= check_input($_POST['phsubcat']);
$startdate1 = check_input($_POST['startdate']);
$expairydate1 = check_input($_POST['expairydate']);
$starttime = check_input($_POST['starttime']);
$expairytime = check_input($_POST['expairytime']);
$sta = split('-', $startdate1);
$startdate = $sta['2'] . "-" . $sta['1'] . "-" . $sta['0'];
$exp = split('-', $expairydate1);
$expairydate = $exp['2'] . "-" . $exp['1'] . "-" . $exp['0'];
$createdate=date('Y-m-d');
$txtcontentdesc=check_input(content_desc($_POST['txtcontentdesc']));
$post_level=check_input($_POST['post_level']);
$txtstatus=check_input($_POST['txtstatus']);
$createdate=date('Y-m-d');
$errmsg="";  
if(trim($txtlanguage)=="")
		{
			$errmsg ="Please Select Language."."<br>";
		
		}
if($txtlanguage=='2')
{
		if (eregi('^[A-Za-z0-9 -.()&amp;]{3,50}$',$postname))
		{
		$valid_name=$postname;
		}
		else
		{ 
		$errmsg .='Enter valid Post Name.'."<br>"; 
		}
		// if(trim($salary)="")
		// {
		// $errmsg .="Salary should not be empty or be numeric."."<br>";
		// }
		if(trim($salary)=="")
		{
		$errmsg .="Please enter Salary."."<br>";
		}

		if($_POST["ptype"]=='Select')
		{
		$errmsg .="Please select atleast one Post Type."."<br>";
		}

		if(trim(empty($_POST["qualification"])))
		{
		$errmsg .="Please select atleast one Post Qualifications."."<br>";
		}
		if(trim(empty($_POST["postqualification"])))
		{
		
		$errmsg .="Please select atleast one Post Qualifications Experience."."<br>";
		}

		if(trim(empty($_POST["postqualificationexp"])))
		{
		$errmsg .="Please select atleast one Post QualificationsExp."."<br>";
		}
		
		if(!is_numeric(trim($percentage)))
		{
		$errmsg .="Percentage should be numeric."."<br>";
		}
		
		elseif(trim($percentage)=="")
		{
		$errmsg .="Please enter Post Percentage."."<br>";
		}
		
		$total_cat=count($_POST['catid']);
  $j=0;
   for($ct=0;$ct<$total_cat;$ct++)  
     {
	    $catid_in=$catid[$ct];                  // category title
		$catage_in=$catage[$ct];
		$catfee_in=$catfee[$ct];                  // category title
		
		if(trim($catage_in)=="")
		{
		    $j=$j+1;
			//echo $errmsg ="Please enter age of ."."<br>";
		
		}
		
	 }
	 
	 if($j==$total_cat)
	 {
	  $errmsg .="Please enter atleast one age and fee according to the particular category."."<br>";
	 }
		
		if(trim($age1)=="")
		{
		$errmsg .="Please enter Age as On."."<br>";
		}
		
		// if(trim($ddamount)=="")
		// {
		// $errmsg .="Please enter DD Amount."."<br>";
		// }
		if(trim($totalexp)=="")
		{
		$errmsg .="Please enter Total Experience."."<br>";
		}
		
		if(trim($phsubcat)=="")
		{
		$errmsg .="Please enter PH Sub Category."."<br>";
		}
		if(trim($startdate1)=="")
		{
		$errmsg .="Please enter Post Date."."<br>";
		}
		if(trim($expairydate1)=="")
		{
		$errmsg .="Please enter Last Date."."<br>";
		}
		
		if(trim($txtcontentdesc)=="")
		{
		$errmsg .="Please enter Post Description."."<br>";
		}
		
		if(trim($txtstatus)=="")
		{
			$errmsg .="Please Select Post Status."."<br>";
		}
		

}
else
{
		if(trim($postname)=="")
		{
			$errmsg .="Please enter Post Name."."<br>";
		}
		if (eregi('^[A-Za-z0-9 -.()&amp;]{3,50}$',$postname))
		{
		$valid_name=$postname;
		}
		else
		{ 
		$errmsg .='Enter valid Post Name.'."<br>"; 
		}
		// if(trim($salary))
		// {
		// $errmsg .="Salary should not be empty or be numeric."."<br>";
		// }
		if(trim($salary)=="")
		{
		$errmsg .="Please enter Salary."."<br>";
		}
		if($_POST["ptype"]=='Select')
		{
		$errmsg .="Please select atleast one Post Type."."<br>";
		}
		if(trim(empty($_POST["qualification"])))
		{
		$errmsg .="Please select atleast one Post Qualifications."."<br>";
		}
		if(trim(empty($_POST["postqualification"])))
		{
		
		$errmsg .="Please select atleast one Post Qualifications Experience."."<br>";
		}
		if(trim(empty($_POST["postqualificationexp"])))
		{
		$errmsg .="Please select atleast one Post QualificationsExp."."<br>";
		}
		if(!is_numeric(trim($percentage)))
        {
        $errmsg .="Percentage should be numeric."."<br>";
        }
		
		elseif(trim($percentage)=="")
		{
		$errmsg .="Please enter Post Percentage."."<br>";
		}
		
	 $total_cat=count($_POST['catid']);
  $j=0;
   for($ct=0;$ct<$total_cat;$ct++)  
     {
	    $catid_in=$catid[$ct];                  // category title
		$catage_in=$catage[$ct];
		$catfee_in=$catfee[$ct];                  // category title
		
		if(trim($catage_in)=="")
		{
		    $j=$j+1;
			//echo $errmsg ="Please enter age of ."."<br>";
		
		}
		
		/*if(trim($catfee_in)=="")
		{
        echo $errmsg ="Please enter fee."."<br>";
		
		}*/
		
	 }
	 
	 if($j==$total_cat)
	 {
	  $errmsg .="Please enter atleast one age and fee according to the particular category."."<br>";
	 }
		
		
		if(trim(empty($_POST["catage"])))
		{
		
		$errmsg .="Please enter the age."."<br>";
		}
		
		if(trim($age1)=="")
		{
		$errmsg .="Please enter Age as On."."<br>";
		}
		
		// if(trim($ddamount)=="")
		// {
		// $errmsg .="Please enter DD Amount."."<br>";
		// }
		if(trim($totalexp)=="")
		{
		$errmsg .="Please enter Total Experience."."<br>";
		}
		
		if(trim($phsubcat)=="")
		{
		$errmsg .="Please enter PH Sub Category."."<br>";
		}
		if(trim($startdate1)=="")
		{
		$errmsg .="Please enter Post Date."."<br>";
		}
		if(trim($expairydate1)=="")
		{
		$errmsg .="Please enter Last Date."."<br>";
		}

		if(trim($txtcontentdesc)=="")
		{
		$errmsg .="Please enter Post Description."."<br>";
		}
		
	
		if(trim($txtstatus)=="")
		{
		$errmsg .="Please Select Post Status."."<br>";
		}
}
if($errmsg == '')
	{
 if($_SESSION['logtoken']!=$_POST['random'])
		{
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
$create_date=date('y-m-d');
$tableName_send="post_mst";
$tableFieldsName_old=array("language_id","postname","post_type","salary","percentage","p_percentage","gen","obc","scst","genph","obcph","scstph","exservice","others","incan","exservice_OBC","exservice_SCST","exservice_PH","exservice_GENPH","exservice_SCSTPH","exservice_OBCPH","age","ddamount","totalexp","phsubcat","startdate","starttime","expairydate","expairytime","txtcontentdesc","post_level","approve_status");
$tableFieldsValues_send=array("$txtlanguage","$postname","$ptype","$salary","$percentage","$post_percentage","$gen","$obc","$scst","$genph","$obcph","$scstph","$exservice","$others","$incan","$exservice_OBC","$exservice_SCST","$exservice_PH","$exservice_GENPH","$exservice_SCSTPH","$exservice_OBCPH","$age","$ddamount","$totalexp","$phsubcat","$startdate","$starttime","$expairydate","$expairytime","$txtcontentdesc","$post_level","$txtstatus");
$value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
$page_id=mysql_insert_id();


//graduation loop

for ($i=0; $i <count($g_min_percent) ; $i++) {

        $qualificationtitle_in=$g_min_percent[$i];                  // qualification title
		$sqlInsertI1="insert into post_qualification  (qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in, ENT_QUOTES)."','".$page_id."','".$percentage."')";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());

	
}

for ($j=0; $j <count($g_no_percent) ; $j++) { 
	$qualificationtitle_in_p=$g_no_percent[$j];      // qualification title		
		$sqlInsertI1="insert into post_qualification  (qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in_p, ENT_QUOTES)."','".$page_id."',0)";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());
}


  
//post graduation looop

for ($i=0; $i <count($post_min_percent) ; $i++) {

        $qualificationtitle_in=$post_min_percent[$i];                  // qualification title
		$sqlInsertI1="insert into p_post_qualification  (post_qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in, ENT_QUOTES)."','".$page_id."','".$post_percentage."')";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());

	
}

for ($j=0; $j <count($post_no_percent) ; $j++) { 
	$qualificationtitle_in_p=$post_no_percent[$j];                  // qualification title	
	$sqlInsertI1="insert into p_post_qualification  (post_qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in_p, ENT_QUOTES)."','".$page_id."',0)";
	$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());
}


$total_postqualification=count($_POST['postqualificationexp']);
   for($bt=0;$bt<$total_postqualification;$bt++)  
     {
			
	   $postqualificationtitle_in=$postqualificationexp[$bt];                  // post qualification title
		
	   $sqlInsertI12="insert into post_qualificationexperience  (qualificationexp_id,post_id) values('".htmlentities($postqualificationtitle_in, ENT_QUOTES)."','".$page_id."')";
	  $rsInsertI12=mysql_query($sqlInsertI12) or die(mysql_error());
		
			
	 }
	 
$total_cat=count($_POST['catid']);

  for($ct=0;$ct<$total_cat;$ct++)  
     {
			
		$catid_in=$catid[$ct];                  // category title
		$catage_in=$catage[$ct];
		$catfee_in=$catfee[$ct];                  // category title
		
		$sqlInsertI123="insert into post_qualificationage  (catid,catage,catfee,post_id) values('".$catid_in."', '".$catage_in."', '".$catfee_in."', '".$page_id."')";
		$rsInsertI123=mysql_query($sqlInsertI123) or die(mysql_error());
		
			
	 }

	$user_id=$_SESSION['admin_auto_id_sess'];
		$page_id=mysql_insert_id();
		$action="Insert";
		$categoryid='1'; 
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array("$user_id","$page_id","$postname","$action","$model_id","$date","$ip","$txtlanguage","$postname","$txtstatus");
	$value=$useAVclass->insertQuery($tableName,$tableFieldsName_old,$tableFieldsValues_send);
$msg=CONTENTADD;
$_SESSION['content']=$msg;
header("location:manage_post.php");
exit;	
}	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add Post Details :<?=$sitename; ?></title>
	<link rel="SHORTCUT ICON" href="images/favicon.ico" />
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<link href="style/admin.css" rel="stylesheet" type="text/css">
	
	<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="js/jquery-1.9.0.js"></script>
	<script type="text/javascript" src="js/jsDatePick.js"></script>
	<script language="JavaScript" src="js/validation.js"></script>
	<script type="text/javascript">    dropdown('nav', 'hover', 1);</script>
	<style type="text/css">
		.label {width:100px;text-align:right;float:left;padding-right:10px;font-weight:bold;}
		#register-form label.error, .output {color:#FB3A3A;font-weight:bold;}
	</style>

	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="style/ie7.css">
	<![endif]-->
	<script type="text/javascript">
		window.onload = function(){
			new JsDatePick({
				useMode:2,
				target:"age",
				dateFormat:"%d-%m-%Y"
			});
			new JsDatePick({
		useMode:2,
		target:"startdate",
		dateFormat:"%d-%m-%Y"
	});
	new JsDatePick({
		useMode:2,
		target:"expairydate",
		dateFormat:"%d-%m-%Y"
	});

		};

		function isNumberKey(evt)
		{
		

			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
			{
				alert("Please enter numbers only");
				return false;
			}
			else
			{
				return true;
			}
		}


	</script>
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
	
	<script type="text/javascript">
        function GetSelected (selectTag) {
            var selIndexes = "";

            for (var i = 0; i < selectTag.options.length; i++) {
                var optionTag = selectTag.options[i];

                if (optionTag.selected) {


if (selIndexes.length > 0)
       
                          selIndexes += "";
                     selIndexes += '<li><input type="checkbox" name="select_qualification[]" value="'+optionTag.value+'">&nbsp;&nbsp;&nbsp;<span>'+optionTag.text+'</span></li>';
                }
              
            }

            var info = document.getElementById ("info");
            if (selIndexes.length > 0) {
                info.innerHTML = selIndexes;
            }
            else {
                info.innerHTML = "There is no selected option";
            }
        }
		function GetSelectedpost (selectTag) {
            var selIndexes = "";

            for (var i = 0; i < selectTag.options.length; i++) {
                var optionTag = selectTag.options[i];

                if (optionTag.selected) {
                 //alert(optionTag.text);
                    if (selIndexes.length > 0)
             selIndexes += "";
                     selIndexes += '<li><input type="checkbox" name="select_post_qualification[]" value="'+optionTag.value+'">&nbsp;&nbsp;&nbsp;<span>'+optionTag.text+'</span></li>';
                }
            }

            var info1 = document.getElementById ("info1");
            if (selIndexes.length > 0) {
                info1.innerHTML =selIndexes;
            }
            else {
                info1.innerHTML = "There is no selected option";
            }
        }

function GetSelectedpost_exp (selectTag) {
            var selIndexes = "";

            for (var i = 0; i < selectTag.options.length; i++) {
                var optionTag = selectTag.options[i];
                if (optionTag.selected) {
                    if (selIndexes.length > 0)
                        selIndexes += ", ";
                    selIndexes += optionTag.text;
                }
            }

            var info1 = document.getElementById ("info3");
            if (selIndexes.length > 0) {
                info1.innerHTML ="List : " + selIndexes;
            }
            else {
                info1.innerHTML = "There is no selected option";
            }
        }

    </script>
	 <script language="Javascript" type="text/javascript">
 
        function onlyNos(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            catch (err) {
                alert(err.Description);
            }
        }
 
    </script>
</head>
<body>
<?php include('top_header.php'); ?>
<div id="container">

	<!-- Header start -->


	<?php
	include_once('main_menu.php');
	?>
	<!-- Header end -->


	<div class="main_con">
		<div class="admin-breadcrum">
			<div class="breadcrum">
				<span class="submenuclass"><a href="welcome.php">Dashboard</a></span>
				<span class="submenuclass">>> </span>
				<span class="submenuclass"><a href="manage_post.php">Post Details Management</a></span>
				<span class="submenuclass">>> </span>
				<span class="submenuclass">Add Post Details</span>
			</div>
			
			<div class="clear"> </div>
		</div>


		<div class="right_col1">
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
					<h3 class="manageuser">Add Post Details</h3>

			   </div>

			<div class="grid_view">
				<form action="" method="post" name="form1"  autocomplete="off" enctype="multipart/form-data" onsubmit="return add_user('form1')" id="register-form" novalidate="novalidate">


		  <div class="frm_row"> <span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if($_REQUEST['txtlanguage']=='1'){ echo 'checked'; } ?> id="txtlanguage" checked />English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if($_REQUEST['txtlanguage']=='2'){ echo 'checked'; } ?>/>Hindi 
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
			
			<div class="frm_row"> <span class="label1">
              <label for="postname">Post Title:</label>
              <span class="star">*</span></span> <span class="input1">
             <input name="postname"  type="text" class="input_class" id="postname" size="30" value="<?php if(htmlspecialchars(content_desc($postname!=""))) { echo htmlspecialchars($postname);} ?>" autocomplete = "off" placeholder="Name" required/>	  </span>
						<div class="clear"></div>
			</div>
			
			
<script language="javascript" type="text/javascript">
	function addmenutype(id) {
	if(id=='1')
		{ 	document.getElementById('consolidate').style.display = 'none';
			document.getElementById('scale').style.display = 'block';
			
		}
		else if(id=='2')
		{	document.getElementById('consolidate').style.display = 'block';
			document.getElementById('scale').style.display = 'none';
			
		}
			
		else 
		{	document.getElementById('consolidate').style.display = 'none';
			document.getElementById('scale').style.display = 'none';
			
	    }
	
}
</script>
<div class="frm_row"> 
			<span class="label1">
			<label for="txtstatus">Post Type:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="ptype" id="ptype"  autocomplete="off" onchange="addmenutype(this.value)">
			<option>Select</option>
			<?php
                $sql="SELECT * FROM `post_type_master` WHERE `status`=1 ";
                $data=mysql_query($sql);
                while ($row=mysql_fetch_array($data)) {
                ?>

                	 <!--<option value="<?php echo $row['job_type']?>"><?php echo $row['post_type']?></option>-->
					 <option value="<?php echo $row['id'];?>"<?php if($ptype==$row['id']){ echo 'selected'; } ?>><?php echo $row['post_type']?></option>

                <?php }  ?>
            
  
			</select>
			</span>
			<div class="clear"></div>
	</div>



			<div class="frm_row" id="scale" style="display:none"> 
			<span class="label1">
			<label for="txtstatus">Pay Scale:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="pscale" id=""  autocomplete="off">
			<option>Select</option>
			<?php
                $sql="SELECT * FROM `scale_master` WHERE `status`=1 ";
                $data=mysql_query($sql);
                while ($row=mysql_fetch_array($data)) {
				$tottal_sal=$row['salary_from']."-".$row['salary_to'];
                ?>

                	<!-- <option><?php echo $row['salary_from']."-".$row['salary_to']?></option>-->
					<option value="<?php echo $tottal_sal;?>"<?php if($tottal_sal==$pscale)  {  echo "selected";   }  ?>><?php echo $row['salary_from']."-".$row['salary_to'];?></option>
                <?php
				
                }
              ?>
			</select>
			</span>
			<div class="clear"></div>
			</div>


			<div class="frm_row" id="consolidate" style="display:none"> <span class="label1">
              <label for="salary">Salary:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="salary" type="text" class="input_class" id="salary" size="30" value="<?php if($salary!=""){ echo $salary;} ?>" autocomplete = "off" placeholder="Salary" required onkeypress="return isNumberKey(event,this);" />
              </span>
			<div class="clear"></div>
			</div>
					 
         <div class="frm_row"> <span class="label1">
              <label for="qualification">Qualification:</label>
              <span class="star">*</span></span> <span class="input1">
			 
	<?php
  	 $sqlqual="select * from qualification_mst where c_status='1'  and category=1 order by Qualification_list";
	 $resqual=mysql_query($sqlqual);	
    ?>
  <select name="qualification[]" id="qualification"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelected (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=mysql_fetch_array($resqual)){?>
    <option value="<?php echo $rowqual['qualification_id'] ;?>"<?php  if (in_array($rowqual['qualification_id'], $_REQUEST['qualification']) || $rowqual['qualification_id']==1 || $rowqual['qualification_id']==2)
  {
     echo "selected";
  } ?>><?php echo $rowqual['Qualification_list'] ;?></option>
    <?php } ?>
  </select>
  
  <br /><br />

 </span>
  <div class="clear"></div>
	   </div>

<div class="frm_row" id=""> 
              <label for="">Select For Percentage:</label>
              <span class="input1">
 <ul id="info" type="none" style="border:1px solid #606060; background-color:#e0d0e0;width:65%;" >

     </ul>       
     </span>
						
	</div>

<div class="frm_row"> <span class="label1">
              <label for="percentage">Graduation Percentage:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="g_percentage" type="text" class="input_class" id="percentage" size="30" value="<?php if($g_percentage!=""){ echo  htmlentities($g_percentage);} ?>" autocomplete = "off" placeholder="percentage" required/>
              </span>
			<div class="clear"></div>
			</div>
	   
	   <div class="frm_row"> <span class="label1">
              <label for="qualification">Post Qualification :</label>
              <span class="star">*</span></span> <span class="input1">
			 
			 <?php
  	$sqlqual="select * from qualification_mst where c_status='1' and category=2 order by Qualification_list";
	$resqual=mysql_query($sqlqual);	
 ?>
  <select name="postqualification[]" id="postqualification"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelectedpost (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=mysql_fetch_array($resqual)){?>
    <option value="<?php echo $rowqual['qualification_id'] ;?>"<?php  if (in_array($rowqual['qualification_id'], $_REQUEST['postqualification']))
  {
  echo "selected";
  } ?>><?php echo $rowqual['Qualification_list'] ;?></option>
    <?php } ?>
  </select>

<!--  <br /> 
<span id="info1" style="border:1px solid #606060; background-color:#e0d0e0;height:200px; width:300px; margin-left: 230px; size=200"></span>

  <br /> -->

    
			 
              </span>
		   <div class="clear"></div>
	   </div>

	   <div class="frm_row" id=""> 
              <label for="">Select For Percentage:</label>
              <span class="input1">
 <ul id="info1" type="none" style="border:1px solid #606060; background-color:#e0d0e0;width:65%;" >


     </ul>       
              </span>
						
					</div>



					<div class="frm_row"> <span class="label1">
              <label for="percentage">Post_grad. Percentage:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="percentage" type="text" class="input_class" id="percentage" size="30" value="<?php if($percentage!=""){ echo  htmlentities($percentage);} ?>" autocomplete = "off" placeholder="percentage" required/>
              </span>
						<div class="clear"></div>
					</div>
		
<div class="frm_row"> <span class="label1">
              <label for="qualification">Post Qualification Exp-:</label>
              <span class="star">*</span></span> <span class="input1">
			 
			 <?php
  	$sqlqual="select * from qualification_mst where c_status='1' order by Qualification_list";
	$resqual=mysql_query($sqlqual);	
 ?>
  <select name="postqualificationexp[]" id="postqualificationexp"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelectedpost_exp (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=mysql_fetch_array($resqual)){?>
    <option value="<?php echo $rowqual['qualification_id'] ;?>"<?php  if (in_array($rowqual['qualification_id'], $_REQUEST['postqualificationexp']))
  {
  echo "selected";
  } ?>><?php echo $rowqual['Qualification_list'] ;?></option>
    <?php } ?>
  </select>
  <br />
<span id="info3" style="border:1px solid #606060; background-color:#e0d0e0;height:200px; width:300px; margin-left: 230px; size=200"></span>

  <br />

    
			 
              </span>
		   <div class="clear"></div>
	   </div>

<div class="frm_row"> <span class="label1">
              <label for="totalexp">Total Experience:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="totalexp" type="text" class="input_class" id="totalexp" size="30" value="<?php if($totalexp!=""){ echo  htmlentities($totalexp);} ?>" autocomplete = "off" placeholder="totalexp" required/>
              </span>
						<div class="clear"></div>
					</div>
					
					
				<div class="frm_row"> <span class="label1">
              <label for="age">Age:</label>
              <span class="star">*</span></span> <span class="input1">
			  <table>
  <tr>
    <th>Category</th>
    <th>Age</th>
    
  </tr>
			<?php
             $sqlcat="select * from category_master where status='1'";
			 $rescat=mysql_query($sqlcat) or die(mysql_error());
//echo $totalrows=mysql_num_rows($rescat);
$n=0;
			 while($rowcat = mysql_fetch_array($rescat))
			 {
             
			 if($_REQUEST['catage'][$n]!='')
			 {
			     $catageArr=$_REQUEST['catage'][$n];
			 }
			 else
			 {
			    $catageArr='';
			 }
			 
			 if($_REQUEST['catfee'][$n]!='')
			 {
			     $catfeeArr=$_REQUEST['catfee'][$n];
			 }
			 else
			 {
			    $catfeeArr='';
			 }
			 
			 ?>
<tr>
    <td><input name="catid[]" type="hidden" class="input_class" id="catid" size="30" value="<?php echo $rowcat['c_id']; ?>" autocomplete = "off" readonly="readonly"/><b><?php echo $rowcat['c_name']; ?></b></td>
    <td><input name="catage[]" type="text" class="input_class" id="catage" size="30" value="<?php echo $catageArr; ?>" autocomplete = "off" maxlength="3" onkeypress="return isNumberKey(event,this);"/></td>
   
  </tr>

            <?php
			 $n++; }

            ?>			
			  </table>
			  </span>
			<div class="clear"></div>
					</div>

					<div class="frm_row"> <span class="label1">
                                                        <label for="age">Age as on:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="age" id="age" readonly="readonly"  autocomplete="off" value="<?php if($_REQUEST['age'] !=''){ echo $_REQUEST['age']; } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                          </span>
                                          <div class="clear"></div>
                 </div> 
			
			<div class="frm_row"> <span class="label1">
              <label for="ddamount">DD Amount:</label>
              </span> <span class="input1">
              <input name="ddamount" type="text" class="input_class" id="ddamount" size="30" value="<?php if($ddamount!=""){ echo  htmlentities($ddamount);} ?>" autocomplete = "off" placeholder="ddamount" required/>
              </span>
			<div class="clear"></div>
		   </div>
					
							
			<div class="frm_row"> <span class="label1">
              <label for="phsubcat">PH SubCategory%:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="phsubcat" type="text" class="input_class" id="phsubcat" size="30" value="<?php if($phsubcat!=""){ echo  htmlentities($phsubcat);} ?>" autocomplete = "off" placeholder="phsubcat" required/>
              </span>
			  <div class="clear"></div>
			 </div>
					
					<div class="frm_row"> <span class="label1">
                                                        <label for="startdate">Post Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="startdate" id="startdate" readonly="readonly"  autocomplete="off" value="<?php if($_REQUEST['startdate'] !=''){ echo $_REQUEST['startdate']; } else { } ?>"/><span class="date">[dd-mm-yyyy]</span>
										  
                                         <label>Post Time:</label> <span class="input1">
                                                        <input type="time" name="starttime" autocomplete="off"  value="<?php if($_REQUEST['starttime'] !=''){  echo $_REQUEST['starttime']; }else {}
                                                               
                                                           ?>"/><span class="time">[H:M AM]</span> 

                                                    </span>
 

                                                    </span>
                                                    <div class="clear"></div>
            </div> 
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="expairydate">Last Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                                        <input type="text" name="expairydate" autocomplete="off" readonly="readonly"  id="expairydate" value="<?php if($_REQUEST['expairydate'] !=''){  echo $_REQUEST['expairydate']; }else {}
                                                               
                                                           ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <label>Post Time:</label>
                                                    <span class="input1">
                                                        <input type="time" name="expairytime" autocomplete="off"  value="<?php if($_REQUEST['expairytime'] !=''){  echo $_REQUEST['expairytime']; }else {}
                                                               
                                                           ?>"/><span class="time">[H:M AM]</span> 

                                                    </span>

                                                    <div class="clear"></div>
            </div>
			
			
			<div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        <span class="star">*</span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/awda/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/awda/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/awda/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/awda/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($_REQUEST['txtcontentdesc'])));
		?>        </span>
        <div class="clear"></div>
        </div>
			<div class="frm_row"> <span class="label1">
              <label for="post_level">Enter Level:</label>
              <span class="star">*</span></span> <span class="input1">
             <input name="post_level"  type="text" class="input_class" id="post_level" size="30" value="<?php if(htmlspecialchars(content_desc($post_level!=""))) { echo htmlspecialchars($post_level);} ?>" autocomplete = "off" placeholder="Level" required/>	  </span>
						<div class="clear"></div>
			</div>
			
			<div class="frm_row"> 
			<span class="label1">
			<label for="txtstatus">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
			
			 <option value="1">Active</option>
             <option value="0">In Active</option>
			</select>
			
			</span>
			<div class="clear"></div>
			</div>

				<div class="clear"></div>
				<div class="frm_row"> <span class="button_row">
                <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="Submit" />
                <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
                <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
                <input type="button" class="button" value="Back" onClick="javascript:location.href = 'manage_post.php';" />

              </span>
				<div class="clear"></div>
				</div>
				</form>
			</div>
		</div>
	</div>

	<!-- right col -->







	<!-- Content Area end -->






</div>  <!-- main con-->

<!-- Footer start -->

<?php

include("footer.inc.php");
?>
<!-- Footer end -->

</div> <!-- Container div-->
</body>
</html>
<script type="text/javascript">
	$(".closestatus").click(function() {
		$("#msgerror").addClass("hide");
	});
</script>

<style>
	.hide {display:none;}
</style>

