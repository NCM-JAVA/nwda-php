<?php
ob_start();
session_start();
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include("../includes/ps_pagination.php");
include('../design.php');
$cat=$_GET['txtcatgory'];
$m_name = "Archive";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta name="author" content="">
<link rel="apple-touch-icon" href="<?php echo $HomeURL;?>/assets/images/favicon/apple-touch-icon.png">
<link rel="icon" href="<?php echo $HomeURL;?>/assets/images/favicon/favicon.png">
<title>Department of Empowerment of Persons with Disabilities Gallery page</title>

<!-- Custom styles for this template -->
<link href="<?php echo $HomeURL;?>/assets/css/base.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/base-responsive.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/grid.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/font-awesome.min.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/flexslider.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/assets/css/print.css" rel="stylesheet" media="print" />
<link href="<?php echo $HomeURL; ?>/assets/css/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jsDatePick.js"></script>


<!-- Theme styles for this template -->
<link href="<?php echo $HomeURL;?>/theme/css/site.css" rel="stylesheet" media="all">
<link href="<?php echo $HomeURL;?>/theme/css/site-responsive.css" rel="stylesheet" media="all">

<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
<!-- Custom JS for this template -->

<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/framework.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/font-size.js"></script>
<script type="text/javascript" src="<?php echo $HomeURL;?>/assets/js/swithcer.js"></script>

<script type="text/javascript">
window.onload = function(){
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
</script>


<script type="text/javascript">
function cat(id)

{

 if(id!='')
		{ 	document.getElementById('cat').style.display = 'block';
		}
		
		else
		{	document.getElementById('cat').style.display = 'none';
		} 
}
	

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

document.onkeydown = function (e) {           /* for Disable entries through keyboard    */
        return false;
}
</script>
<!--End -->

</head>

<body>

<div class="wrapper common-wrapper">
	<?php include("top_bar.php");?>
</div>
<!-- top bar end-->

<section class="wrapper header-wrapper">
	<?php include("header.php");?>
</section>
<!-- Header end-->

<nav class="wrapper nav-wrapper">
	<?php include("top_navigation.php");?>
</nav>
<!-- Nav end-->
<div class="wrapper" id="skipCont"></div><!--/#skipCont-->

<section id="fontSize" class="wrapper body-wrapper">
    <?php include("second_levelmenu.php"); ?> 
     <!--breadcrumb start-->
    <div id="breadcrumb">
      <div class="container"> 
       <div class="easy-breadcrumb">
        <ul>
  <li class="first"><?php echo "<a href=".$HomeURL."/content/>Home</a>"?></li>
			<span> &nbsp;>></span> Archive
</ul>
       </div>
       <div class="block-webspeech">      
          <button onClick="sideSpr(this);" id="sideSprButton">Read Content</button>
          <button onClick="sideStop()" id="sideStopButton">Stop</button>
       </div>   
      </div>  
    </div>
    <!--breadcrumb end-->
  <div class="inner-bg-wrapper">  
   <div class="container">     
    <div class="inner_left_container">
      <div class="inner_left_childmenu">
         
         <?php include("inner_left_menu.php");?>
      </div>
      <div class="inner_left_fixmenu">
        <?php include("inner_fixed_menu.php");?>
     </div>
  </div>
    <!--inner_left_container end-->
    
    <div class="inner_right_container">
      <h1>Archive</h1>
	  	 <table class="archivet">
  <tr>
    <td colspan="3">        
	    <?php
if(isset($cmdsubmit))
{
$sta=split('-',$startdate);
$startdate1=$sta['2']."-".$sta['1']."-".$sta['0'];
$startdate1=content_desc(htmlspecialchars($startdate1));
$exp=split('-',$expairydate);
$expairydate1=$exp['2']."-".$exp['1']."-".$exp['0'];
$expairydate1=content_desc(htmlspecialchars($expairydate1));
if(trim($textcatgory) =="")
{
 $errmsg ="Please Select Archives Category."."<br>";
}
if($startdate !='' && $expairydate !="")
{
		if($exp['2'] < $sta['2'])
		{
		$errmsg =" From Date should be lesser than To Date."."<br>";
		} 
		else if(($exp['2'] == $sta['2']) && ($exp['1'] < $sta['1'])) 
		{
		$errmsg .=" From Date should be lesser than To Date."."<br>";
		} 
		else if((($exp['2'] == $sta['2']) && ($exp['1'] == $sta['1'])) && ($exp['0'] < $sta['0'])) 
		{
		$errmsg .="Please enter From Date less then To Date."."<br>";
		}
		
		$startdate1=changeformate($startdate);
		$startdate1=content_desc(htmlspecialchars($startdate1));
		$expairydate1=changeformate($expairydate);
		$expairydate1=content_desc(htmlspecialchars($expairydate1));
		$querywhere ="and end_date between '$startdate1' and '$expairydate1' "; 

}			
		if($errmsg=="")
			{
				if($textcatgory=='1' || $textcatgory=='2' || $textcatgory=='3' || $textcatgory=='4' || $textcatgory=='5' || $textcatgory=='6' || $textcatgory=='12' ){
				$date=date('Y-m-d');
				//$sql="SELECT  * FROM  combine_publish_versions WHERE (m_publish_id, create_versions_date) IN ( SELECT  m_publish_id, MAX(create_versions_date) FROM  combine_publish_versions  GROUP BY m_publish_id) and cat_id=$textcatgory $querywhere  and date(end_date ) < '$date' ORDER BY combine_publish_versions.create_versions_date DESC";
				$sql="SELECT  * FROM  combine_publish WHERE 1 and  cat_id=$textcatgory $querywhere  and date(end_date ) < '$date' and language_id='2' ORDER BY combine_publish.create_date DESC";
				
				}
				
				if($textcatgory=='7'){
				$date=date('Y-m-d');
							$sql="SELECT  * FROM  menu_publish_versions WHERE (m_publish_id, create_versions_date) IN ( SELECT   m_publish_id, MAX(create_versions_date) FROM  menu_publish_versions  GROUP BY m_publish_id) and date(end_date ) < '$date' and language_id='2' ORDER BY menu_publish_versions.create_versions_date DESC";
						}
				if($textcatgory=='8'){
				$date=date('Y-m-d');
				$sql="SELECT  * FROM  annual_report_publish_versions WHERE (m_publish_id, create_versions_date) IN ( SELECT  m_publish_id, MAX(create_versions_date) FROM  annual_report_publish_versions  GROUP BY m_publish_id)  $querywhere  and date(end_date ) < '$date' and language_id='2' ORDER BY annual_report_publish_versions.create_versions_date DESC";
				}
			}

		
			
		
}
$date=date('Y-m-d');
if($cat=='1' || $cat=='2' || $cat=='3' || $cat=='4' || $cat=='5' || $cat=='6'  ){
			 $sql="SELECT  * FROM  combine_publish WHERE 1 and  cat_id='$cat'   and date(end_date ) < '$date' and language_id='2' ORDER BY combine_publish.create_date DESC";
			
			}
	$date=date('Y-m-d');
if($cat=='7') {
	 $sql="SELECT  * FROM  annual_report WHERE  date(end_date ) < '$date' and language_id='2'";
}
$pager = new PS_Pagination($link, $sql, 10, 5, "");
			 $rs = $pager->paginate();

		?>
	<form method="post" name="frm1" action="archive.php" autocomplete="off">
              <div class="frm_row">
                        <span class="label1"><label  for="textcatgory">Select Archives<span class="star">*</span>  : </label></span>
                        <span class="input1">
<select name="textcatgory" id="textcatgory"   onChange="cat(this.value)"  value="<?php echo content_desc(htmlspecialchars($textcatgory));?>" >
<option value="">Select</option>
<?php foreach($archive_arc as $key=>$value)
{?>

<option value="<?php echo content_desc(htmlspecialchars($key));?>" <?php if (htmlspecialchars(content_desc($textcatgory==$key))) { echo 'selected="selected"'; } if($cat==$key) { echo 'selected="selected"'; } ?>><?php echo (htmlspecialchars(content_desc($value)));?></option>
<?php }?>
</select>
</span>
                       </div>
                      
						<div class="frm_row">
                        <span class="label1"><label for="startdate">From Date: </label></span>
                        <span class="input1">
                      <input type="text" name="startdate"  autocomplete="off" id="startdate" value="<?php echo content_desc(htmlspecialchars($startdate));?>" readonly size="10"  onKeyPress="return isNumberKey(event)"/>
</span>
                        <div class="clear"></div>
                        </div>
						<div class="frm_row">
                        <span class="label1"><label for="expairydate">To Date : </label></span>
                        <span class="input1">
                      <input type="text" name="expairydate" autocomplete="off" id="expairydate" value="<?php echo content_desc(htmlspecialchars($expairydate));?>" size="10" readonly  onKeyPress="return isNumberKey(event)"/>
                      </span>                       
                    </div>
                  <div class="submit_block">
                   <div class="submit_block_row">
                      <input type="submit"  name="cmdsubmit"  id="cmdsubmit" value="Go" >
                   </div>
                 </div>	
             </div>
		 </div> 
     </form>
    </td>
	</tr> <?php if($errmsg!=""){?>
			<tr>
			<td colspan="3" class="archive-text star"><strong> <?php echo $errmsg; ?></strong></td>
			</tr>
			<?php } ?>
	</table>
  <table>
  <caption><?php echo $archive_arc["$textcatgory"];?> Archives</caption>
  <tr>
    <th>Page Title</th>
    <th width="15%">Publish Date</th>
    <th width="15%">End Date</th>
  </tr>
  <?php
if($rs>0)
{
if($textcatgory=='7'){
		while($row=mysql_fetch_array($rs))
		{
		 if($row['m_type']=='1'){ $pageurlh='<a title="'.$row['m_name'].'" href="'.$HomeURL.'/content/archive/'.$row['m_url'].'">'.$row['m_name'].'</a>'; }
		if($row['m_type']=='2'){ $file='../upload/'.$row['doc_uplode'];
		 $pageurlh='<a title="'.$row['m_name'].'" target="_blank" href="../upload/'.$row['doc_uplode'].'">'.$row['m_name'].'</a><img src="'.$HomeURL.'/assets/images/pdf_icon.png" alt="Pdf" height="16"   border="0"/> size:( '.formatFilebytes($file,'MB'). ')'; }
		if($row['m_type']=='3'){  $pageurlh='<a title="'.$row['m_name'].'" target="_blank" href="'.$row['linkstatus'].'">'.$row['m_name'].'</a> <img src="'.$HomeURL.'/assets/images/extlink.png" alt="External links" width="15" height="10" border="0"/>'; }
		?><tr>
		<td class="archive-text"><?php echo $pageurlh;?> </td>	
		<td class="published-date"><?php echo changeformate($row['start_date']);?></td>
		<td class="end-date"><?php echo changeformate($row['end_date']);?></td>
		</tr>
		<?php }	 }else { 
		while($rows=mysql_fetch_array($rs))
		{

			//echo $rows['docs_file'];
		if($rows['ext_url']!=''){  $pageurlh='<a title="'.$row['m_short'].'" target="_blank" href="'.$row['ext_url'].'">'.$row['m_short'].'</a> <img src="'.$HomeURL.'/images/extlink.png" alt="External links" width="15" height="10" border="0"/>'; }
		if($rows['docs_file']!=''){ $file='../upload/'.$rows['docs_file'];
		 $pageurlh='<a title="'.$rows['m_name'].'" target="_blank" href="../upload/'.$rows['docs_file'].'">'.$rows['m_short'].'</a><img src="'.$HomeURL.'/assets/images/pdf_icon.png" alt="Pdf" height="16"   border="0"/> size:( '.formatFilebytes($file,'MB'). ')'; }
		else
		{ 
		/*$pageurlh='<a title="'.$rows['m_short'].'" href="#">'.$rows['m_short'].'</a>';*/
		$pageurlh='<a title="'.$rows['m_short'].'" href="'.$HomeURL.'/content/viewpage/'.$rows['page_url'].'">'.$rows['m_short'].'</a>';
		}
		
		?><tr>
		<td class="archive-text"><?php echo $pageurlh;?> </a></td>	
		<td class="published-date"><?php echo changeformate($rows['start_date']);?></td>
		<td class="end-date"><?php echo changeformate($rows['end_date']);?></td>
		</tr><?php }}?>
						<tr>
						<td colspan="3" align="center"><?php   echo $pager->renderFullNav();?></td>
						</tr>
		
						<?php 
						}
						else
						{?>
						<tr>
						<td colspan="3">No record found </td>
						</tr>
						<?php 
						}

						?>
  
  
</table>
	  

      </div>
    </div> 
	 
    </div>
    <!--inner_right_container end-->
   </div>
 </div>
</section>

<!--carousel-wrapper-Start-->
<section class="wrapper carousel-wrapper">
	<?php include("footer_gov_link.php");?>
</section>
<!--carousel-wrapper-end-->

<!--footer-start-->
<footer class="wrapper footer-wrapper">
	<?php include("footer.php");?>
</footer>
<!--footer-end-->



<script type="text/javascript">
$(document).ready(function(e) {

        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

 });


$(window).load(function(){
// Slider						
 $('#flexSlider').flexslider({
        animation: "slide",
		controlNav: false,
        start: function(slider){
        $('body').removeClass('loading');
        }
 });
 
// Carousel						
 $('#flexCarousel').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 200,
        itemMargin: 5,
        minItems: 2,
        maxItems: 6,
		slideshow: 1,
		move: 1,
		controlNav: false,
        start: function(slider){
          $('body').removeClass('loading');
		  if (slider.pagingCount === 1) slider.addClass('flex-centered');
        }
      });
	  
// Carousel						
 $('#flexCarousel2').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 130,
        itemMargin: 5,
        minItems: 2,
        maxItems: 6,
		slideshow: 1,
		move: 1,
		controlNav: false,
        start: function(slider){
          $('body').removeClass('loading');
		  if (slider.pagingCount === 1) slider.addClass('flex-centered');
        }
      });	  
 
 // Gallery
      $('#galleryCarousel').flexslider({
        animation: "fade",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
  });
</script>
<script type="text/javascript">
function editlist(id) {
var menuId = id;
var request = $.ajax({
url: "editid.php",
type: "POST",
data: {id : menuId},
dataType: "html"
});
request.done(function(msg) {
window.location.href = msg;
});
request.fail(function(jqXHR, textStatus) {
alert( "Request failed: " + textStatus );
});
 
}
</script>
</body>
</html>
