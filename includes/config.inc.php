<?php
header("Expires:" . gmdate("D, d M Y H:i:s") . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
ini_set("log_errors" , "1");
ini_set("error_log" , "phperrors.log");
ini_set("display_errors" , "0");
error_reporting(0);
@extract($_GET);
@extract($_POST);
@extract($_SESSION);

//  $HomeURL = 'https://'.$_SERVER["HTTP_HOST"];
 //$HomeURL = 'http://localhost/nwda_upgrades';
 $HomeURL = 'http://localhost/nwda';
// if(!define(WWW_PATH,$HomeURL ))
	// define(WWW_PATH,$HomeURL );
$ApplicationSettings['AdminURL']  = $HomeURL.'/auth/adminpanel';
$ApplicationSettings['PhysicalPath'] =str_replace("configure.php","",__FILE__);
$ApplicationSettings['ImageURL'] = $ApplicationSettings['HomeURL'] . "/images";
$postion=array("1" => "Header Menu","2" => "Left Menu","3" => "Footer Menu","4" => "Link Menu","5" => "Menu Not Show");
$postion1=array("2" => "Left Menu");
$language=array("1"=>"English","2"=>"Hindi");
$status=array("2"=>"Inactive","1"=>"Active");
$status1=array("0"=>"Inactive","1"=>"Active");

$menutype= array("1"=>" Content ","2"=>"PDF file Upload","3"=>"Web Site Url");
$menutype1= array("1"=>" Content ","2"=>"PDF file Upload","3"=>"Web Site Url");
$pageURL = $_SERVER["REQUEST_URI"];
$reporttype= array("1"=>"Annual Report ","2"=>"Survay Report" ,"3"=>"Performence Report");
$homepage_type= array("1"=>"Hon'ble Minister","2"=>"Director Message");
$media_type= array("1"=>"Photo Gallery","2"=>"Video Gallery");
$important_link_cat_english=array("1"=>"Statutory Bodies" ,"2"=>"CPSUs","3"=>"Nationals Institutes and CRCs");
$important_link_cat_hindi=array("10"=>"What's News" ,"11"=>"Circular","12"=>"Events");
$whats_new_category	= array("1"=>"News","2"=>"Scheme","3"=>"Scholorship","4"=>"Order");
$importantlink=array("1"=>"Related Link");
$important_link_cat_hindi=array("1"=>"सांविधिक निकाय" ,"2"=>"निगम","3"=>"राष्‍ट्रीय संस्‍थानें");
$user_type= array("1"=>" Normal User ","2"=>"Organization User");

// 1=> what's news "4"=>"Tenders","7"=>"Minister Speech"
//$cat_type= array("2"=>"Circular","3"=>"Events","5"=>"News" ,"4"=>"Tenders");
$cat_type= array("2"=>"Circular");
$inactive = 1000;
if(isset($_SESSION['timeout']) ) 
{
	 $session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        {
			session_destroy();
			if($pageURL==$ApplicationSettings['AdminURL']."/index.php")
			{ header("Location:".$HomeURL.'/auth/adminPanel/logout.php');}
			else
			{header("Location:".$HomeURL.'/index.php');}
		}
}
 $_SESSION['timeout'] = time();

/*if($_SERVER['QUERY_STRING'] !='')
	{  
			if(preg_match("/^[a-zA-Z0-9&&=.&%_-]+$/",$_SERVER['QUERY_STRING']) === 0)
		{
			session_destroy();
			header('Location:error.php');
		exit();
		}
		
	}*/
	
function currenttime () 
{
	$timezone = new DateTimeZone("Asia/Kolkata" );
	$date = new DateTime();
	$date->setTimezone($timezone );
	echo $date->format( 'H:i:s A  /  D, M jS, Y' );
}

$title="NWDA";
$sitename="National Water Development Agency";// change this variable to write site name
$sitenamehi="राष्ट्रीय जल विकास अभिकरण "; // change this variable to write hindi site name
$header_msg="Welcome Admin";
$date=date('d, M y'); // display date
$time=date('H:i A'); // display time
$edit="Edit";
$change="Change password";
$logout="Logout";
$orgname="Organization Name";
?>
