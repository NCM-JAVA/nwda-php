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

if($status=='deleteid_user')
{
 $msg=CONTENTDELETE; 
	$_SESSION['manage_user']=$msg;
		header("Location:manage_user.php");
		exit();
}

if($status=='deleteid')
{
 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("Location:manage_menu.php");
		exit();
}
if($status=='inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_menu.php");
}
if($status=='employees_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_employee.php");
}
if($status=='whatnews_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_whatnews.php");
}
if($status=='whatnews_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_whatnews.php");
}


if($status=='employees_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_employee.php");
}

if($status=='circualr_deleteid')
{
	// $msg=CONTENTDELETE; 
	 $msg="Circular Deleted Successfully"; 
	$_SESSION['content']=$msg;
		header("location:manage_circular_events.php");
}
if($status=='circualr_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_circular_events.php");
}
if($status=='minister_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:minister_speech.php");
}
if($status=='minister_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:minister_speech.php");
}

if($status=='important_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_important_link.php");
}
if($status=='important_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_important_link.php");
}
if($status=='tenders_deleteid')
{
	// $msg=CONTENTDELETE; 
	 $msg="Tender Delete Successfully"; 
	$_SESSION['content']=$msg;
		header("location:manage_tenders.php");
}
if($status=='tenders_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_tenders.php");
}

if($status=='faq_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_faq.php");
}
if($status=='faq_deleteid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_faq.php");
}


if($status=='recruitement_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_tenders.php");
}
if($status=='recruitement_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_tenders.php");
}
if($status=='reports_deleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_annual_reports.php");
}
if($status=='reports_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_annual_reports.php");
}


if($status=='home_deleteid')
{
	$msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
	header("location:manage_homepage.php");
}
if($status=='home_inactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_homepage.php");
}
if($status=='delete_organization')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:organization_setup.php");
}
if($status=='inactived_organization')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:organization_setup.php");
}
if($status=='orgdeleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:organization-chart.php");
}

if($status=='orginactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:organization-chart.php");
}
if($status=='orderdeleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_order.php#menu-1");
}


if($status=='orderinactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_order.php#menu-2");
}
if($status=='pbdeleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_pbnotice.php#menu-1");
}


if($status=='pbinactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_pbnotice.php#menu-2");
}
if($status=='redeleteid')
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_report.php#menu-1");
}


if($status=='rwinactiveid')
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_report.php#menu-2");
}



if($status=='u_inactiveid1')
{
	$msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
	header("location:manage_update.php?module_id=$module_id");
	exit;
}

if($status=='u_del' )
{
     
	$msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
	header("location:manage_update.php?module_id=$module_id");
        exit;
}
if($status=='f_inactiveid1')
{
	$msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
	header("location:manage_faq.php");
	exit;
}

if($status=='front_deleteid' )
{
     
	$msg=CONTENTDELETE; 
	$_SESSION['manage_user']=$msg;
	header("location:manage_front_user.php");
        exit;
}
if($status=='deleteid_roleid' )
{
     
	$msg=CONTENTDELETE; 
	$_SESSION['manage_user']=$msg;
	header("location:manage_role.php");
        exit;
}

if($status=='banner' )
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_banner.php");
}
if($status=='bannerdelete' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_banner.php");
}
if($status=='video_gallerydelete' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_video_gallery.php");
}
if($status=='video_gallery' )
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_video_gallery.php");
}
if($status=='photo_gallerydelete' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_photo_gallery.php");
}
if($status=='photo_gallery' )
{
	 $msg=CONTENTINACTIVE; 
	$_SESSION['content']=$msg;
		header("location:manage_photo_gallery.php");
}
if($status=='deleteid' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_submenu.php");
}

if($status=='advertise_deleteid' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_advertisement.php");
}
if($status=='post_deleteid' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_post.php");
}
if($status=='applicants_deleteid' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_applicants.php");
}
if($status=='deletefeedback' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_feedback.php");
}
if($status=='deleteviewsonilr' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_viewsonilr.php");
}
if($status=='inactiveviewonilr' )
{
	$msg=CONTENTINACTIVE;
	$_SESSION['content']=$msg;
		header("location:manage_viewsonilr.php");
}
if($status=='deleteonlinequery' )
{
	 $msg=CONTENTDELETE; 
	$_SESSION['content']=$msg;
		header("location:manage_onlinequery.php");
}
if($status == 'vacancy_inactiveid'){
	$msg=CONTENTINACTIVE;
	$_SESSION['content']=$msg;
	header("location:manage_vacancy.php");
}
if($status == 'vacancy_deleteid'){
	$msg=CONTENTDELETE;
	$_SESSION['content']=$msg;
	header("location:manage_vacancy.php");
}
?>




