<?php error_reporting(0);
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$HomeURL = 'https://'.$_SERVER["HTTP_HOST"];
 //$HomeURL = 'http://localhost/nwda_upgrades';
//$HomeURL = 'http://localhost/depwd';
$ApplicationSettings['AdminURL']  = $HomeURL.'/auth/adminpanel';
$ApplicationSettings['PhysicalPath'] =str_replace("configure.php","",__FILE__);
$ApplicationSettings['ImageURL'] = $ApplicationSettings['HomeURL'] . "/images";
$ApplicationSettings['AdminName'] = "";


$postion=array("1" => "Header Menu","2" => "Footer Link","3" => "Footer Menu");
$language=array("1"=>"English","2"=>"Hindi");
$status=array("1"=>"Active","2"=>"In Active");
$menutype= array("1"=>" Content ","2"=>"PDF file Upload","3"=>"Web Site Url");
$Newupdates=array("1"=>"News & Events","3"=>"Do's and Donts's");
$categorytype= array("1"=>" Photogallery ");
$categorytype= array("1"=>" Photogallery ","2"=>"Videogallery");
$pageURL = $_SERVER["REQUEST_URI"];
$membertype= array("1"=>" Marchants ","2"=>"Traders");
$request=array("1"=>"Disability Encyclopedia","2"=>"Communities" ,"3"=>"Discussion Forum");
$Newupdates=array("1"=>"Latest News","2"=>"Notices");
$archive_arc=array("1"=>"What's News" ,"2"=>"Circular","3"=>"Events","4"=>"Tenders","5"=>"Awards","6"=>"National Policy","8"=>"Annual Report","9"=>"Recruitment");
$important_link_cat_english=array("1"=>"Statutory Bodies" ,"3"=>"Nationals Institutes and CRCs","2"=>"CPSUs");
$important_link_cat_hindi=array("1"=>"सांविधिक निकाय" ,"2"=>"निगम","3"=>"राष्‍ट्रीय संस्‍थानें");

$alppha=range('A','Z');
/*$alppha=range('A','Z');
if($_SERVER['QUERY_STRING'] !='')
	{  		if(preg_match("/^[a-zA-Z0-9&=.&&_-]+$/", $_SERVER['QUERY_STRING']) === 0)
		{
			session_destroy();
			header('Location:error.php');
			exit();
		}
		
	}*/
?>