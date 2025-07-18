<?php
ob_start();
session_start();
@extract($_GET);
require_once "../../includes/connection.php";
require_once("../../includes/frontconfig.inc.php");
require_once "../../includes/functions.inc.php";
require_once("../../design.php");
$url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
$val=explode('?', $url);
$cat_url=$val['1'];
$d_url = substr($cat_url,-1);
$val=explode('/', $url);
$url=$val['4'];
$open=$val['3'];
 /*$c=substr($cat_url, -1);
$sql1=mysql_query("SELECT * FROM org_designation Where  $cat_url");
				$query=mysql_num_rows($sql1);
				while($result=mysql_fetch_array($sql1))
				{

					$cat_id=$result['deg_id'];
				}
if(!is_numeric($c) || ($c!=$cat_id))
{
	header("Location:".$HomeURL."/content/error.php");
						exit(); 
}*/

if($url=='chairman.php' || $d_url=='1')
{
	
	 $cls="class='selected'";
	 $title="Chairperson";
}
elseif($url=='member.php' || $d_url=='2')
{
	$cls="class='selected'";
	 $title="Member";
}
elseif($url=='secretary.php' || $d_url=='3')
{
	$cls="class='selected'";
	 $title="Secretary";
}
elseif($url=='otherofficers.php')
{
	$cls="class='selected'";
	 $title="Other Officers";
}
else {
	$cls="class=''";
}
?>
<!DOCTYPE HTML>
<html  xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width"/>

<title><?php echo $title ?> : AERA</title>
<meta name="keywords" content="<?php echo  $c_name; ?>" />
<meta name="description" content="<?php echo $c_name; ?>" />
<link href="<?php echo $HomeURL;?>/style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $HomeURL;?>/style/demoStyleSheet.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $HomeURL;?>/style/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $HomeCss;?>/style/page-background.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $HomeURL;?>/js/html5.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery-migrate-1.0.0.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/access.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/dropdown.js"></script>

<link href="<?php echo $HomeURL; ?>/style/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jsDatePick.js"></script>


<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jquery-latest.js"></script>

<script type="text/javascript" src="<?php echo $HomeURL;?>/js/fadeSlideShow.js"></script>
<script type="text/javascript">jQuery(document).ready(function(){
	jQuery('#slideshow').fadeSlideShow();
});
</script>
<script type="text/javascript">
      // initialise plugins
      jQuery(function () {
          dropdown('nav', 'hover', 1);
      });
</script>
<!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->

<!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="style/ie8.css">
<![endif]-->

</head>

<body class="noJS">
<div id="wrapper"> 
  <!--Accessibility-->
  <div class="access-links">
       <?php include('../accessbility-menu.php'); ?>

  </div>
  <div class="clear"> </div>
  <div class="shadow-contaier"> </div>
  <div class="shadow-mid-content"> 
    <!--Header-->
    <header>
     <?php include('../header.php'); ?>
    </header>
    <!--Navigation-->
    <div class="nav">
      <div class="nav-left">
        <div class="nav-right">
          <div class="nav-mid">
            <div class="nav-link">
              <?php include('../navigation.php');?>
            </div>
            <div class="search">
              <?php include('../search.php');?>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"> </div>
    </div>
    <!--Banner-->
    <section id="internalpage-content">
    <!--Left-Links-->
    <aside id="left-link">
	 <div class="left-links">
<div class="left-h">
<h2><strong>About Us</strong></h2>
</div> 


<ul>
<?php $sql=mysql_query("SELECT * FROM menu_publish where language_id='1' and  m_flag_id='1' and m_publish_id!='9' and approve_status='3' and m_publish_id!='41' and menu_positions='1' ORDER BY page_postion ASC");
$count=mysql_num_rows($sql);
 $k=1;
//echo "SELECT * FROM menu_publish where language_id='1' and  m_flag_id='".$rootid."' and approve_status='3' and menu_positions='1' ORDER BY page_postion ASC";
				while($data=mysql_fetch_array($sql))
				{
				
				$page=$data['m_name'];
				if($data['m_url']!=$m_url)
				{
				$class='';
				}
				elseif($page=="Key Officials")
				{
				$class='active';
				}
				else
				{
				$class='active';
				}
				$sql1=mysql_query("select * from menu_publish where m_flag_id='".$data['m_publish_id']."' and menu_positions='1'  and language_id='1' and approve_status='3' ORDER BY page_postion ASC");
			$row2=mysql_num_rows($sql1);
		  	?>
			
			<?php if($data['linkstatus']!='' ) { ?>
		<li class="active"><a title="<?php echo $data['linkstatus'];?>" href="<?php echo $data['linkstatus'];?>"><?php echo  $data['m_name'];?></a></li>
		<?php } else { ?>
	<li class="<?php echo $class; ?>"><a href="<?php echo $HomeURL;?>/content/innerpage/<?php echo $data['m_url']; ?>" title="<?php echo $data['m_name'];?>"><?php echo $data['m_name'];?></a></li>
					 <?php }  ?></li>
					 <?php } ?>
</ul>











<?php //include('../innerleft-menu.php');?>

</div>

<div class="left-button">   
<?php include('../left-icon.php');?>
</div>
    </aside>
    <!--Right content-->
    <div id="internal-content">   
    <div class="breadcrumb">
		<ul>
		 <li class="first"><?php echo "<a href=".$HomeURL."/content/>Home</a>"?></li>
		<li class=""><a href="<?php echo $HomeURL; ?>/content/organization.php" title="Organization Chart">Organization Chart</a></li>
		<li class="last"><?php echo  $title;?></li>
		</ul>

<div id="skip">


<div class="clear">  </div>
      </div>


<div class="clear">  </div>
      </div>
 <div class="heading-p">
<div class="int-heading">
<h3><ul class="shadetabs">
<h3><ul class="shadetabs">
<li><a href="chairman.php" title="Chairperson" <?php if($url=='chairman.php' || $d_url=='1') { echo $cls; } else {}?>>Chairperson</a></li>
<li><a href="member.php" title="Member" <?php if($url=='member.php' || $d_url=='2') { echo $cls; } else {}?>>Member</a></li>
<li><a href="secretary.php"  title="Secretary" <?php if($url=='secretary.php' || $d_url=='3') { echo $cls; } else {}?>>Secretary</a></li>
<li><a href="otherofficers.php" title="Other Officers" <?php if($url=='otherofficers.php') { echo $cls; } else {}?>>Other Officers</a></li>
</ul>
</h3>

<div class="clear">  </div>	  
</div>		
<div class="print">
<a href="javascript: void(0);" title="Print" onClick="javascript:window.print();"> <img src="<?php echo $HomeURL?>/images/print-icon.png" width="16" height="16" alt="Print" /></a>
</div>
<div class="clear"></div>
</div>

<div class="int-content">
 <?php 
if($url=='chairman.php' || $d_url=='1') { 
$sql="SELECT * FROM `organization_chart` where designation='1'";
				$sql=mysql_query($sql);
				$count=mysql_num_rows($sql);
				while($row=mysql_fetch_array($sql)) { 
		 $chairman_date = "09-03-2015";
						 $update_date=$row['create_date'];
		$date=explode(' ',$row['create_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];
						echo $body=stripslashes(html_entity_decode($row['content'])); 
					?>
					 <div class="page gradient" style="float:right"><a href="<?php echo $HomeURL;?>/content/innerpage/archive-of-chairperson.php">Archive</a></div>
<?php }} else if($url=='member.php' || $d_url=='2'){ 
$sql="SELECT * FROM `organization_chart` where designation='2'";
				$sql=mysql_query($sql);
				$count=mysql_num_rows($sql);
				while($row=mysql_fetch_array($sql)) { 
						 $update_date=$row['create_date'];
		$date=explode(' ',$row['create_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];
				echo $body=stripslashes(html_entity_decode($row['content'])); 
				?>
<?php } ?>

<div class="page gradient" style="float:right"><a href="<?php echo $HomeURL;?>/content/innerpage/archive-of-member.php">Archive</a></div>

<?php } else if($url=='secretary.php' || $d_url=='3'){ 
$sql="SELECT * FROM `organization_chart` where designation='3'";
				$sql=mysql_query($sql);
				$count=mysql_num_rows($sql);
				while($row=mysql_fetch_array($sql)) { 
						 $update_date=$row['create_date'];
		$date=explode(' ',$row['create_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];
				echo $body=stripslashes(html_entity_decode($row['content'])); 
				?>
				 <div class="page gradient" style="float:right"><a href="<?php echo $HomeURL;?>/content/innerpage/archive-of-secretary.php">Archive</a></div>
<?php }} else if($url=='otherofficers.php'){ 
$sql="SELECT * FROM `menu_publish` where m_publish_id='41' and approve_status='3'";
				$sql=mysql_query($sql);
				$count=mysql_num_rows($sql);
				while($row=mysql_fetch_array($sql)) { 
						 $update_date=$row['create_date'];
		$date=explode(' ',$row['create_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];
					
					
				echo $body=stripslashes(html_entity_decode($row['content'])); 
				?>
				 <div class="page gradient" style="float:right"><a href="<?php echo $HomeURL;?>/content/innerpage/other-officers.php">Archive</a></div>
<?php }} ?>

 <div class="clear">  </div>

</div>



<p style="float:right;font-weight:bold">Page Last updated on :

<?php

if($url=='chairman.php') {
$sql=mysql_query("SELECT admin_login.`user_name` , admin_login.`login_name`,audit_trail.* from audit_trail inner join admin_login ON audit_trail.user_login_id = admin_login.id where 1 and audit_trail.page_category='Manage Menu'  order by audit_id desc");


}
else if($url=='member.php') {
$sql=mysql_query("SELECT admin_login.`user_name` , admin_login.`login_name`,audit_trail.* from audit_trail inner join admin_login ON audit_trail.user_login_id = admin_login.id where 1 and  audit_trail.page_category='Manage Menu' order by audit_id desc");

}
else if($url=='secretary.php') {
$sql=mysql_query("SELECT admin_login.`user_name` , admin_login.`login_name`,audit_trail.* from audit_trail inner join admin_login ON audit_trail.user_login_id = admin_login.id where 1 and  audit_trail.page_category='Manage Menu' order by audit_id desc");

}
else if($url=='otherofficers.php') {
$sql=mysql_query("SELECT admin_login.`user_name` , admin_login.`login_name`,audit_trail.* from audit_trail inner join admin_login ON audit_trail.user_login_id = admin_login.id where 1 and  audit_trail.page_category='Manage Menu' order by audit_id desc");
}
$data1 = mysql_fetch_array($sql);
						@extract($data1);
						$page_action_date=date("d-m-Y", strtotime($page_action_date));
						$update_date=$data1['page_action_date'];
		$date=explode(' ',$data1['page_action_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];
						
 
if($update_date=='0000-00-00 00:00:00')
{
echo $cd2.'-'.$cd1.'-'.$cd;
}
else
{
	echo $d2.'-'.$d1.'-'.$d;

}
?> 
</p>
    </div>
    <div class="clear">  </div>
    </section>
    <!--Bottom Links-->
    <div id="bottom-links">
     <?php include('../bottom-link.php')?>
    </div>
    <!--Footer-->
     <div class="footer">
        <?php include('../footer.php');?>
    </div>
    <div class="clear"> </div>
  </div>
</div>
</body>
</html>