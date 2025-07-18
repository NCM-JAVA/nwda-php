<?php 

   ini_set('display_errors', 1);
   error_reporting(E_ALL);

ob_start();
 require_once "../../includes/connection.php";
 require_once "../../includes/def_constant.inc.php";
 require_once "../../includes/config.inc.php";
 require_once "../../includes/functions.inc.php";
// require_once "../../securimage/securimage.php";
 include("../../includes/useAVclass.php");
//echo session_id();

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dashboard : <?php echo $sitename;?></title> 
		
<link rel="icon" href="<?php echo $HomeURL?>/assets/images/favicon.ico">
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

</head>
<body class="noJS">
<?php include('top_header.php'); ?>

<div id="welcome_p">
    <div id="container">

                          
<?php
 include('main_menu.php');
?>

                            <!-- Header end -->

                            <div class="main_con">
                                <div class="right_col1">
                                
                                    <div class="dashboard">
                                    <div class="dashboard_heading">
                                    <h3> Dashboard : <?php echo $sitename;?> </h3>
                                    </div>
                                    <div class="das-box">
                                        <ul>
										 <li><a href="profile.php" title="Manage Profile"><img src="images/manageprofile.png" alt="Manage Profile" width="35" height="37" border="0" /><br />
                                                    Manage Profile</a></li>
													
													<?php 
	$user_id=$_SESSION['admin_auto_id_sess'];
	$user_role_id=$_SESSION['dbrole_id'];
	$sql="SELECT * FROM admin_role where admin_role.user_id='$user_id'";
	$result = $conn->query($sql);
	$role_module = $result->fetch_array();
	$module_id =$role_module['module_id'];
 
	// $rs=mysql_query($sql)	;
	// $role_module=mysql_fetch_array($rs);
	 // $module_id =$role_module['module_id'];
        if($module_id=='ALL')
		  { ?>
		<li><a href="manage_user.php" title="User Management"><img src="images/view-profile.png" alt="Manage User Management" width="35" height="37" border="0" /><br />
		User Management</a></li>
			<li><a href="manage_menu.php" title="CMS Page"><img src="images/cms-page.png" alt="Manage CMS Page" width="35" height="37" border="0" /><br />
		CMS Page</a></li>
		
		<li><a href="manage_feedback.php" title=" Manage Feedback"><img src="images/manage-feedback.png" alt="Manage Feedback" width="35" height="37" border="0" /><br />
		Manage Feedback</a></li>
		
		<li><a href="manage_discussion.php" title="Manage Discussion Forum"><img src="images/disscussion-forum.png" alt="Manage Feedback" width="35" height="37" border="0" /><br />
		Manage Discussion Forum</a></li>
		
		<li><a href="organization-chart.php" title="Manage Organization Setup"><img src="images/organization-setup.png" alt="Manage Organization Setup" width="35" height="37" border="0" /><br />
		Manage Organization Setup</a></li>
		<li><a href="manage_encyclopedia.php" title="Manage Discussion Forum"><img src="images/articles.jpg" alt="Manage Discussion Forum" width="35" height="37" border="0" /><br />
		Manage Glossary Forum</a></li>
		<li><a href="logo.php" title="Manage Importent Link Logo"><img src="images/audit_icon.png" alt="Manage Discussion Forum" width="35" height="37" border="0" /><br />
		Manage Importent Link Logo</a></li>

		<li><a href="manage_banner.php" title="Manage Media Center"><img src="images/media-certre.png" alt="Manage Media Center" width="35" height="37" border="0" /><br />
		Manage Media Center</a></li>
		<li><a href="manage_audit.php" title="Manage Audit"><img src="images/audit.png" alt="Manage Audit" width="35" height="37" border="0" /><br />
		Manage Audit</a></li>

		  <?php 
		  }
	  else
	  {	
		$cms=array('1','2','3','5','6','7','11');
		$exploded=explode(',',$module_id);
		$module_id_cms=array_intersect($exploded, $cms);
		$comma_separated = implode(",", $module_id_cms);
	// $query=mysql_query(""); 
	// $num=mysql_num_rows($query);
		$sql1="Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc";
	$result = $conn->query($sql1);
	
		if ($result->num_rows > 0) {
				?>
						<li><a href="manage_menu.php" title="CMS Page"><img src="images/cms-page.png" alt="Manage CMS Page" width="35" height="37" border="0" /><br />
		CMS Page</a></li>
			
	<?php } 
	$cms=array('4','9','10','12','13','14','15','16');
	 $exploded=explode(',',$module_id);
		$module_id_cms=array_intersect($exploded, $cms);
		$comma_separated = implode(",", $module_id_cms);
		// $query=mysql_query("Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc"); $num=mysql_num_rows($query);
				$sql2="Select * FROM module where module_status ='Active' and publish_id_module !='2' and module_id in($comma_separated) and page_type='cms_page' order by `module_id` asc";
	$result1 = $conn->query($sql2);
		
		
		while($data = $result1->fetch_array()) 
		{
			@extract($data);
		?>
		<?php if($data['module_id']==4){?>
<li><a href="manage_feedback.php" title=" Manage Feedback"><img src="images/manage-feedback.png" alt="Manage Feedback" width="35" height="37" border="0" /><br />
		Manage Feedback</a></li>
	<?php  } elseif($data['module_id']==10) { ?>
<li><a href="minister_speech.php" title="Manage Minister Speech"><img src="images/manager-minister-speech.png" alt="Manage Minister Speech" width="35" height="37" border="0" /><br />
		Manage Minister Speech</a></li>
	<?php } elseif($data['module_id']==9) { ?>
		<li><a href="organization-chart.php" title="Manage Organization Setup"><img src="images/organization-setup.png" alt="Manage Organization Setup" width="35" height="37" border="0" /><br />
		Manage Organization Setup</a></li>
		<?php } elseif($data['module_id']==12) { ?>
		<li><a href="manage_discussion.php" title="Manage Discussion Forum"><img src="images/disscussion-forum.png" alt="Manage Discussion Forum" width="35" height="37" border="0" /><br />
		Manage Discussion Forum</a></li>
			<?php } elseif($data['module_id']==13) { ?>
			<li><a href="manage_encyclopedia.php" title="Manage Disability Encyclopedia"><img src="images/encyclopedia.png" alt="Manage Disability Encyclopedia" width="35" height="37" border="0" /><br />
		Disability Encyclopedia</a></li>
				<?php } elseif($data['module_id']==14) { ?>
		<li><a href="manage_communities.php" title="Manage Communities"><img src="images/communities.png" alt="Manage Communities" width="35" height="37" border="0" /><br />
		Communities</a></li>
				<?php }elseif($data['module_id']==15) { ?>
				<a href="manage_banner.php" title="Home Banner" class="menuitem">Home Banner</a>
				<?php }elseif($data['module_id']==16){?>
	<li><a href="manage_banner.php" title="Manage Media Center"><img src="images/media-certre.png" alt="Manage Media Center" width="35" height="37" border="0" /><br />
		Manage Media Center</a></li>
         <?php  
		 }
		 }}
   ?>
                                         			
                                       
                                           

                                            <li><a href="logout.php?random=<?php echo $_SESSION['logtoken']; ?>" title="Logout"><img src="images/dashboard_images/logout.png"  alt="Logout" width="35" height="37" border="0"/><br/>Logout</a></li>


                                        </ul>
                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="cpanel-right">
                                    <div class="cpanel-right_heading"><h3>Last 4 Activity</h3>  </div>
                                    
                                    
                                        <table width='100%' border='0' cellpadding="0" cellspacing="0">
                                            <tr>
                                                <th width="25%">Name</th>
                                                <th width="15%">User Id</th>
                                                <th width="25%">Date</th>
                                                <th width="15%">Activity</th>
                                                <th width="20%">IP Address</th>
                                            </tr>
                                        
                                        

                                            <?php
                                            $sqlqry = "SELECT admin_login.user_name, admin_login.login_name,  `audit_trail`.user_login_id,  `audit_trail`.page_action,  `audit_trail`.page_action_date, `audit_trail`.ip_address
			FROM admin_login INNER JOIN  `audit_trail` ON  `audit_trail`.user_login_id = admin_login.id
			WHERE 1 ORDER BY  `audit_trail`.`audit_id` DESC LIMIT 0 , 4";
                                           	$sqlresult = $conn->query($sqlqry);
		
		

                                            $res_rows = mysqli_num_rows($sqlresult);
                                            if ($res_rows > 0) {
                                               	while($data = $sqlresult->fetch_array()){
                                                    @extract($data);
                                                    
                                                    if ($class == "odd") {
                                                        $class = "even";
                                                    } else {
                                                        $class = "odd";
                                                    }
                                                    ?>

                                                    <tr class="<?php echo $class; ?>">
                                                        <td><?php echo $user_name; ?></td>
                                                        <td><?php echo $login_name; ?></td>
                                                        <td><?php echo date("d-m-Y H:i:s", strtotime($page_action_date)); ?></td>
                                                        <td><?php echo $page_action; ?></td>
                                                        <td><?php echo $ip_address; ?></td>
                                                    </tr>


                                                <?php }
                                            } ?>

                                        </table>


                                    </div>
                                    <div class="clear"></div> 

                                </div><!-- right col -->

                                <div class="clear"></div>

                                <!-- Content Area end -->

                            </div>  <!-- main con-->

                         

                        </div> <!-- Container div-->
                          
</div>
                        
                         <!-- Footer start -->

<?php include("footer.php"); ?>
                            <!-- Footer end -->

                    </body>
                    </html>
