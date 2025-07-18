<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
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

if(isset($cmdsubmit) && $_GET['editid']!='')
{

$cid=$_GET['editid'];
$txtlanguage= check_input($_POST['txtlanguage']);
$postname = check_input($_POST['postname']);
$advertisement_no = check_input($_POST['advertisement_no']);
$ptype = check_input($_POST['ptype']);
if($ptype==2)
{
$salary= check_input($_POST['salary']);
}
else
{
$salary = check_input($_POST['pscale']);
}
$percentage= check_input($_POST['g_percentage']);
$g_min_percent=$select_qualification;
if(empty($g_min_percent))
{
		$gloop=1;
}
else
{
		$gloop=2;
}
//print_r($g_min_percent);
$g_no_percent=array_values(array_diff($qualification, $g_min_percent));
//echo "gno";
//print_r($g_no_percent);
//echo "<br>";
//post graduation
$post_percentage= check_input($_POST['percentage']);
$post_min_percent=$select_post_qualification;
if(empty($post_min_percent))
{
	$ploop=1;
}
else
{
	$ploop=2;
}
//echo "pmin";
//print_r($post_min_percent);
$post_no_percent=array_values(array_diff($postqualification, $post_min_percent));
//echo "pno";
//print_r($post_no_percent);
//die;
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
$txtstatus=check_input($_POST['txtstatus']);
$errmsg="";

if ($_FILES["txtuplode"]["tmp_name"]!="")
{
	$tempfile = ($_FILES["txtuplode"]["tmp_name"]);
	$imageinfo = ($_FILES["txtuplode"]["type"]);
	$head = fgets(fopen($tempfile, "r"),5);
	$section = strtoupper(base64_encode(file_get_contents($tempfile)));
	$nsection = substr($section,0,8);	
	
	if( !preg_match("/^[a-zA-Z0-9.\-\_]+$/", $_FILES["txtuplode"]["name"]) )
	{
		$errmsg .= 'Uploaded file name should be alphanumeric, dash(-) and underscore(_) only.<br>';
	}else if ( $section != strip_tags($section) )
	{
		$errmsg .= 'Sorry, we accept PDF files only';
	}else{
		$extarray = explode(".",$_FILES["txtuplode"]["name"]);
		if(count($extarray)>2)
		{
			$errmsg .= 'Sorry, we accept PDF files only';
		}elseif(isset($imageinfo) && $imageinfo != 'application/pdf')
		{
			$errmsg .= 'Sorry, we accept PDF files only';
		}elseif(($nsection=="JVBERI0X") OR ($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
		{

		}else{
			$errmsg .= 'Sorry, we accept PDF files only';
		}
		if ($_FILES["txtuplode"]["size"] < 1)
		{
			$errmsg .= "Document Size is too less.<br>";
		}
		if ($_FILES["txtuplode"]["size"] >=(1048576*5))
		{
			$errmsg .= "Document Size is too big.<br>";
		}
	}
}

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

		if ($advertisement_no == '') {
			$errmsg .='Please enter advertisement no.'."<br>";
		}

		if($_POST["ptype"]=='')
		{
		$errmsg .="Please select atleast one Post Type."."<br>";
		}
		// if(!is_numeric(trim($salary)))
		// {
		// $errmsg .="Salary should be numeric."."<br>";
		// }
		if(trim($salary)=="")
		{
		$errmsg .="Please enter Salary."."<br>";
		}
		
		if(trim(empty($_POST["qualification"])))
		{
			$errmsg .="Please select atleast one Qualifications."."<br>";
		}
		/* if(trim(empty($_POST["postqualification"])))
		{		
			$errmsg .="Please select atleast one Post Qualifications Experience."."<br>";
		} */
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


		if (eregi('^[A-Za-z0-9 -.()&amp;]{3,50}$',$postname))
		{
			$valid_name=$postname;
		}
		else
		{ 
			$errmsg .='Enter valid Post Name.'."<br>"; 
		}
		
		if($_POST["advertisement_no"]=='')
		{
			$errmsg .="Please enter advertisement no."."<br>";
		}
		
		if($_POST["ptype"]=='')
		{
			$errmsg .="Please select atleast one Post Type."."<br>";
		}
		// if(!is_numeric(trim($salary)))
		// {
		// $errmsg .="Salary should be numeric."."<br>";
		// }
	if(trim($salary)=="")
		{
		$errmsg .="Please enter Salary."."<br>";
		}
		if(trim(empty($_POST["qualification"])))
		{
			$errmsg .="Please select atleast one Qualifications."."<br>";
		}
		/* if(trim(empty($_POST["postqualification"])))
		{		
			$errmsg .="Please select atleast one Post Qualifications Experience."."<br>";
		} */
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
		
		/*if(trim($catage_in)=="")
		{
		    $j=$j+1;
			//echo $errmsg ="Please enter age of ."."<br>";
		
		}*/
		
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
	
	if ($_FILES["txtuplode"]["name"]!="")
	{
		$txtuplode = $_FILES['txtuplode']['name'];
		$txtuplode = preg_replace("/[^a-zA-Z0-9.\-\_]/", "", $txtuplode);
		$uniq = uniqid("");
		$txtuplode = $uniq.$txtuplode;
		$PATH = "../../upload/advertise/advertisement/";
		// $PATH = $PATH."/";
		$val = move_uploaded_file($_FILES["txtuplode"]["tmp_name"],$PATH.$txtuplode);
		$size = filesize($PATH.$txtuplode);
		$size = ceil($size/1024);
		$found = "false";
	} else {
		$txtuplode = '';
	}

$create_date=date('y-m-d');
$whereclause="post_id=$cid";
$tableName_send="post_mst";
$old=array("language_id","postname","advertisement_no","post_type","salary","percentage","p_percentage","gen","obc","scst","genph","obcph","scstph","exservice","others","incan","exservice_OBC","exservice_SCST","exservice_PH","exservice_GENPH","exservice_SCSTPH","exservice_OBCPH","age","ddamount","totalexp","phsubcat","startdate","starttime","expairydate","expairytime","txtcontentdesc","post_level","approve_status","txtuplode");
$new=array(clean_string($txtlanguage),
	clean_string($postname),
	clean_string($advertisement_no),
clean_string($ptype),
clean_string($salary),
clean_string($percentage),
clean_string($post_percentage),
clean_string($gen),
clean_string($obc),
clean_string($scst),
clean_string($genph),
clean_string($obcph),
clean_string($scstph),
clean_string($exservice),
clean_string($others),
clean_string($incan),
clean_string($exservice_OBC),
clean_string($exservice_SCST),
clean_string($exservice_PH),
clean_string($exservice_GENPH),
clean_string($exservice_SCSTPH),
clean_string($exservice_OBCPH),
clean_string($age),
clean_string($ddamount),
clean_string($totalexp),
clean_string($phsubcat),
$startdate,
$starttime,
$expairydate,
$expairytime,
clean_string($txtcontentdesc),
clean_string($post_level),
clean_string($txtstatus),
$txtuplode);
$useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);
$user_login_id=$cid;
$page_id=$cid;

if($gloop==2)
{
$sqldel="delete from post_qualification where post_id='".$cid."'";
$resdel=mysql_query($sqldel) or die(mysql_error());

//graduation loop

for ($i=0; $i <count($g_min_percent) ; $i++) {

        $qualificationtitle_in=$g_min_percent[$i];                  // qualification title
		$sqlInsertI1="insert into post_qualification  (qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in, ENT_QUOTES)."','".$page_id."','".$percentage."')";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());

	
}

for ($j=0; $j <count($g_no_percent) ; $j++) { 
	$qualificationtitle_in_p=$g_no_percent[$j];                  // qualification title		
		$sqlInsertI1="insert into post_qualification  (qualification_id,post_id,percentage) values('".htmlentities($qualificationtitle_in_p, ENT_QUOTES)."','".$page_id."',0)";
		$rsInsertI=mysql_query($sqlInsertI1) or die(mysql_error());
}


}


if($ploop==2)
{

$sqldel2="delete from p_post_qualification where post_id='".$cid."'";
$resdel2=mysql_query($sqldel2) or die(mysql_error());


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



}


	 

$sqldel1="delete from post_qualificationexperience where post_id='".$cid."'";
$resdel1=mysql_query($sqldel1) or die(mysql_error());
	 
$total_postqualification=count($_POST['postqualificationexp']);

   for($bt=0;$bt<$total_postqualification;$bt++)  
     {
			
		$postqualificationtitle_in=$postqualificationexp[$bt];                  // post qualification title
		
		$sqlInsertI12="insert into post_qualificationexperience  (qualificationexp_id,post_id) values('".htmlentities($postqualificationtitle_in, ENT_QUOTES)."','".$cid."')";
		$rsInsertI12=mysql_query($sqlInsertI12) or die(mysql_error());
		
			
	 }
	 

//$sqldel2="delete from post_qualificationage where post_id='".$cid."'";
//$resdel2=mysql_query($sqldel2) or die(mysql_error());
	 
	 $total_cat=count($_POST['catid']);

   for($ct=0;$ct<$total_cat;$ct++)  
     {
			
		$catid_in=$catid[$ct];                  // category title
		$catage_in=$catage[$ct];
		$catfee_in=$catfee[$ct];                  // category title
		
		//$sqlInsertI123="insert into post_qualificationage  (catid,catfee,post_id) values('".$catid_in."', '".$catfee_in."', '".$page_id."')";
		$sqlInsertI123="update post_qualificationage set catage='".$catage_in."', catfee='".$catfee_in."' where  catid='".$catid_in."' and post_id='".$page_id."'";
		$rsInsertI123=mysql_query($sqlInsertI123) or die(mysql_error());
		
			
	 }

	    //$user_id=$_SESSION['admin_auto_id_sess'];
		$action="Update Posts";
		$date=date("Y-m-d h:i:s");
		$ip=$_SERVER['REMOTE_ADDR'];
		$tableName="audit_trail";
		$tableFieldsName_old=array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
		$tableFieldsValues_send=array(clean_string($user_id),
				clean_string($page_id),
				clean_string($postname),
				clean_string($action),
				clean_string($model_id),
				$date,
				clean_string($ip),
				clean_string($txtlanguage),
				clean_string($postname),
				clean_string($txtstatus));
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
	<title>Edit Post Details :<?=$sitename; ?></title>
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
                     selIndexes += '<li><input type="checkbox" checked name="select_qualification[]" value="'+optionTag.value+'">&nbsp;&nbsp;&nbsp;<span>'+optionTag.text+'</span></li>';
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
				<span class="submenuclass">Edit Post Details</span>
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
					<h3 class="manageuser">Edit Post Details</h3>

				</div>

			<div class="grid_view">
				<form action="" method="post" name="form1" autocomplete="off" enctype="multipart/form-data" onsubmit="return edit_user('form1')" id="register-form" novalidate="novalidate">
<?php	
	if($_GET['editid']!='')
	{
		$rq = mysql_query("select * from post_mst where post_id='".$_GET['editid']."'");
		$rr = mysql_fetch_array($rq);
				//print_r($rr);
		}
		
	
?>  

				 <div class="frm_row"> <span class="label1">
              <label for="txtlanguage">Page Language :</label>
              <span class="star">*</span></span> <span class="input1">
              <input type="radio" name="txtlanguage" autocomplete="off" value="1" <?php if($rr['language_id']=='1'){ echo 'checked'; } ?> id="txtlanguage" />English &nbsp;<input type="radio" name="txtlanguage" autocomplete="off" value="2" <?php if($rr['language_id']=='2'){ echo 'checked'; } ?>/>Hindi 
               </span>
              <div class="clear"></div>
			  <div class="loading"></div>
            </div>
					<div class="frm_row"> <span class="label1">
              <label for="postname">Post Title:</label>
              <span class="star">*</span></span> <span class="input1">
             <input name="postname"  type="text" class="input_class" id="postname" size="30" value="<?php echo $rr['postname']; ?>" autocomplete = "off" placeholder="Name" required/>	  </span>
						<div class="clear"></div>
					</div>
			<div class="frm_row">
				<span class="label1">
              		<label for="advertisement_no">Advertisement No.:</label>
              		<span class="star">*</span>
              	</span>
              	<span class="input1">
             		<input name="advertisement_no" type="text" class="input_class" id="advertisement_no" size="50" value="<?php echo $rr['advertisement_no']; ?>" autocomplete = "off" placeholder="Advertisement No." required/>
             	</span>
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
			<option value="">Select</option>
			<?php
                $sql="SELECT * FROM `post_type_master` WHERE `status`=1 ";
                $data=mysql_query($sql);
                while ($row=mysql_fetch_array($data)) {
                ?>

                	 <option value="<?php echo $row['id'];?>"<?php if($rr['post_type']==$row['id']){ echo 'selected'; } ?>><?php echo $row['post_type']?></option>
                <?php
                }


              ?>
			</select>
			</span>
			<div class="clear"></div>
			</div>



			<div class="frm_row" id="scale" style="<?php if($rr['post_type']==1){echo 'display:block';}else {echo 'display:none';}?>"> 
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
                             
					 <option value="<?php echo $tottal_sal;?>"<?php if($tottal_sal==$rr['salary'])  {  echo "selected";   }  ?>><?php echo $row['salary_from']."-".$row['salary_to'];?></option>

                <?php
                }


              ?>
			</select>
			</span>
			<div class="clear"></div>
			</div>


					<div class="frm_row" id="consolidate" style="<?php if($rr['post_type']==2){echo 'display:block';}else { echo 'display:none';}?>"> <span class="label1">
              <label for="salary">Salary:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="salary" type="text" class="input_class" id="salary" size="30" value="<?php echo $rr['salary']; ?>" autocomplete = "off" placeholder="Salary" required onkeypress="return isNumberKey(event,this);" />
              </span>
						<div class="clear"></div>
					</div>

		 <div class="frm_row"> <span class="label1">
              <label for="qualification">Qualification:</label>
              <span class="star">*</span></span> <span class="input1">
			 
			 <?php
	$sqlpos_qual="select * from post_qualification where post_id='".$_GET['editid']."'";		 
	$respos_qual=mysql_query($sqlpos_qual);
	while($rowpos_qual=mysql_fetch_array($respos_qual))
	{
	  $QualArr[]=$rowpos_qual['qualification_id']; 
	}
	//print_r($QualArr);
  	$sqlqual="select * from qualification_mst where c_status='1' and category=1 order by Qualification_list";
	$resqual=mysql_query($sqlqual);	
 ?>
  <select name="qualification[]" id="qualification"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelected (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=mysql_fetch_array($resqual)){ ?>
    <option value="<?php echo $rowqual['qualification_id'] ;?>"<?php  if (in_array($rowqual['qualification_id'], $QualArr))
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
              <input name="g_percentage" type="text" class="input_class" id="percentage" size="30" value="<?php if($rr['percentage']!=""){ echo  htmlentities($rr['percentage']);} ?>" autocomplete = "off" placeholder="percentage" required/>
              </span>
						<div class="clear"></div>
					</div>

<div class="frm_row"> <span class="label1">
              <label for="qualification">Post Qualification :</label>
              <!-- <span class="star">*</span> --></span> <span class="input1">
			 
			 <?php
$sqlpost_qual="select * from p_post_qualification where post_id='".$_GET['editid']."'";		 
	$respost_qual=mysql_query($sqlpost_qual);
	while($rowpost_qual=mysql_fetch_array($respost_qual))
	{
	  $QualArrr[]=$rowpost_qual['post_qualification_id']; 
	}

  	$sqlqual="select * from qualification_mst where c_status='1' and category=2 order by Qualification_list";
	$resqual=mysql_query($sqlqual);	
 ?>
  <select name="postqualification[]" id="postqualification"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelectedpost (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual=mysql_fetch_array($resqual)){?>
    <option value="<?php echo $rowqual['qualification_id'] ;?>"<?php  if (in_array($rowqual['qualification_id'],$QualArrr))
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
              <!-- <span class="star">*</span> --></span> <span class="input1">
              <input name="percentage" type="text" class="input_class" id="percentage" size="30" value="<?php if($rr['p_percentage']!=""){ echo  htmlentities($rr['p_percentage']);} ?>" autocomplete = "off" placeholder="percentage" required/>
              </span>
						<div class="clear"></div>
					</div>


	   <div class="frm_row"> <span class="label1">
              <label for="qualification">Post Qualification Exp:</label>
              <span class="star">*</span></span> <span class="input1">
			 
			 <?php
			 $sqlpos_qual12="select * from post_qualificationexperience where post_id='".$_GET['editid']."'";		 
	$respos_qual12=mysql_query($sqlpos_qual12);
	while($rowpos_qual12=mysql_fetch_array($respos_qual12))
	{
	  $PostQualArr[]=$rowpos_qual12['qualificationexp_id']; 
	}
			 
  	$sqlqual12="select * from qualification_mst where c_status='1' order by Qualification_list";
	$resqual12=mysql_query($sqlqual12);	
 ?>
  <select name="postqualificationexp[]" id="postqualificationexp"  multiple="multiple" size=30 style='height: 350px; width:40%;' onchange="GetSelectedpost_exp (this);">
    <option value="">..:Please Choose:..</option>
    <?php while($rowqual12=mysql_fetch_array($resqual12)){?>
    <option value="<?php echo $rowqual12['qualification_id'] ;?>"<?php  if (in_array($rowqual12['qualification_id'], $PostQualArr))
  {
  echo "selected";
  } ?>><?php echo $rowqual12['Qualification_list'] ;?></option>
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
              <input name="totalexp" type="text" class="input_class" id="totalexp" size="30" value="<?php echo $rr['totalexp']; ?>" autocomplete = "off" placeholder="totalexp" required/>
              </span>
						<div class="clear"></div>
					</div>


					<!-- <div class="frm_row"> <span class="label1">
              <label for="percentage">Percentage:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="percentage" type="text" class="input_class" id="percentage" size="30" value="<?php echo $rr['percentage']; ?>" autocomplete = "off" placeholder="percentage" required/>
              </span>
						<div class="clear"></div>
					</div> -->
				
				<div class="frm_row"> <span class="label1">
              <label for="age">Age:</label>
              <span class="star">*</span></span> <span class="input1">
			  <table>
  <tr>
    <th>Category</th>
    <th>Age</th>
    <!--<th>Fee</th>-->
  </tr>
			<?php
			$sqlcatfee="select * from  post_qualificationage where post_id='".$_GET['editid']."' order by`qualageid`";
			$rescatfee=mysql_query($sqlcatfee) or die(mysql_error());
			$m=0;
			while($rowcatfee=mysql_fetch_array($rescatfee))
			{
			
			 $catidArr[] = $rowcatfee['catid'];
			 $catageArr[] = $rowcatfee['catage'];
			 $catfeeArr[] = $rowcatfee['catfee'];
			 
			}
			//print_r($catfeeArr);
	
			
             $sqlcat="select * from category_master where status='1'";
			 $rescat=mysql_query($sqlcat) or die(mysql_error());
//echo $totalrows=mysql_num_rows($rescat);
			 while($rowcat = mysql_fetch_array($rescat))
			 {
			 
			 ?>
           
  <tr>
    <td><input name="catid[]" type="hidden" class="input_class" id="catid" size="30" value="<?php echo $rowcat['c_id']; ?>" autocomplete = "off" readonly="readonly"/><b><?php echo $rowcat['c_name']; ?></b></td>
    <td><input name="catage[]" type="text" class="input_class" id="catage" size="30" value="<?php if (in_array($rowcat['c_id'], $catidArr))
  { echo $catageArr[$m]; } ?>" autocomplete = "off" maxlength="3"/></td>
   <!-- <td><input name="catfee[]" type="text" class="input_class" id="catfee" size="30" value="<?php if (in_array($rowcat['c_id'], $catidArr))
  { echo $catfeeArr[$m]; } ?>" autocomplete = "off"/></td>-->
  </tr>
            <?php
			
			$m++;
			 }

            ?></table
			  ></span>
			<div class="clear"></div>
					</div>

					
					<div class="frm_row"> <span class="label1">
                                                        <label for="age">Age as on:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="age" id="age" readonly="readonly"  autocomplete="off" value="<?php if($rr['age'] !=''){ echo changeformate($rr['age']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <div class="clear"></div>
            </div> 
			
			<div class="frm_row"> <span class="label1">
              <label for="ddamount">DD Amount:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="ddamount" type="text" class="input_class" id="ddamount" size="30" value="<?php echo $rr['ddamount']; ?>" autocomplete = "off" placeholder="ddamount" required/>
              </span>
						<div class="clear"></div>
					</div>
					
					
					
					
					<div class="frm_row"> <span class="label1">
              <label for="phsubcat">PH SubCategory%:</label>
              <span class="star">*</span></span> <span class="input1">
              <input name="phsubcat" type="text" class="input_class" id="phsubcat" size="30" value="<?php echo $rr['phsubcat']; ?>" autocomplete = "off" placeholder="phsubcat" required/>
              </span>
						<div class="clear"></div>
					</div>
					
					


			
					
					<div class="frm_row"> <span class="label1">
                                                        <label for="startdate">Post Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                          <input type="text" name="startdate" id="startdate" readonly="readonly"  autocomplete="off" value="<?php if($rr['startdate'] !=''){ echo changeformate($rr['startdate']); } else { } ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                     <label>Post Time:</label> <span class="input1">
                                                        <input type="time" name="starttime" autocomplete="off"  value="<?php if($rr['starttime'] !=''){ echo $rr['starttime']; } else { } ?>"/><span class="time">[H:M AM]</span> 

                                                    </span>
                                                    <div class="clear"></div>
            </div> 
                                                <div class="frm_row"> <span class="label1">
                                                        <label for="expairydate">Last Date:</label><span class="star">*</span>
                                                    </span> <span class="input1">
                                                        <input type="text" name="expairydate" autocomplete="off" readonly="readonly"  id="expairydate" value="<?php if($rr['expairydate'] !=''){  echo changeformate($rr['expairydate']); }else {}
                                                               
                                                           ?>"/><span class="date">[dd-mm-yyyy]</span> 

                                                    </span>
                                                    <label>Post Time:</label>
                                                    <span class="input1">
                                                        <input type="time" name="expairytime" autocomplete="off"  value="<?php if($rr['expairytime'] !=''){ echo $rr['expairytime']; } else { } ?>"/><span class="time">[H:M AM]</span> 

                                                    </span>
                                                    <div class="clear"></div>
            </div>
			
			
			<div class="frm_row"> <span class="label1">
        <label for="txtcontentdesc">Description :</label>
        <span class="star"></span></span> <span class="input_fck" id="">
<?php
		
		$ckeditor = new CKEditor();
		$ckeditor->basePath = '/ckeditor/';
		$ckeditor->config['filebrowserBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html';
		$ckeditor->config['filebrowserImageBrowseUrl'] = '/epil/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
		$ckeditor->config['filebrowserUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		$ckeditor->config['filebrowserImageUploadUrl'] = '/epil/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		$ckeditor->editor('txtcontentdesc',stripslashes(html_entity_decode($rr['txtcontentdesc'])));
		?>        </span>
        <div class="clear"></div>
        </div>
		<div class="frm_row">
        	<span class="label1">
            	<label for="txtuplode">Document Upload :</label>
            </span>
            <span class="input1">
           		<input type="file" name="txtuplode" id="txtuplode"/>
           		<?php if($rr['image_file'] !='') {?>
		   			<img src="../../upload/photogallery/thumb/<?php echo $rr['image_file'];?>" alt="" title="" align="center" width="80" height="90" />
		   		<?php }?> 
            </span>
            <div class="clear"></div>
        </div>
		<div class="frm_row"> <span class="label1">
              <label for="post_level">Enter Level:</label>
              <span class="star">*</span></span> <span class="input1">
             <input name="post_level"  type="text" class="input_class" id="post_level" size="30" value="<?php if($rr['post_level'] !=''){ echo $rr['post_level']; } else { } ?>"/>	  </span>
						<div class="clear"></div>
			</div>
					
					<div class="frm_row"> 
			<span class="label1">
			<label for="txtstatus">Page Status:</label>
			<span class="star">*</span></span> <span class="input1">
			<select name="txtstatus" id="txtstatus"  autocomplete="off" onchange="divcomment(this.value)">
			<option value=""> Select </option>
			 <option value="1" <?php if($rr['approve_status']=='1') {   echo "selected"; }  ?>>Active</option>
             <option value="0" <?php if($rr['approve_status']=='0') {   echo "selected"; }  ?>>In Active</option>
			</select>
			</span>
			<div class="clear"></div>
			</div>

						<div class="clear"></div>
						
            <div class="frm_row"> <span class="button_row">
            <input name="cmdsubmit" type="submit" class="button" id="cmdsubmit" value="<?php if($_GET['editid']!='') { echo 'Update';} else { echo'Submit';}?>" />&nbsp;
			<input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
			<input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>" /><!-- <a href="employee.php"><input type="button" name="back" value="Back" class="button1"></a> -->&nbsp;
		<input type="button" class="button" value="Back" onClick="javascript:location.href ='manage_post.php';" />
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

