<?php  ob_start();
session_start();
require_once "../includes/connection.php";
require_once("../includes/frontconfig.inc.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");

if($_SERVER['REQUEST_URI'])
		{
		 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
		 
		$url=$val['4'];
		$open=$val['3'];
		if($url !='')
		{
		$sql="SELECT m_publish_id as page_id, m_name, content as content, m_url ,m_title,menu_positions,module_id,update_date,create_date FROM menu_publish where language_id='2' and approve_status='3' and m_url='$url' ";
		}
		else {
		 $sql="SELECT m_publish_id as page_id, m_name, content as content, m_url ,m_title,menu_positions,module_id,update_date,create_date FROM menu_publish where language_id='2' and approve_status='3'";
		}
			$sql=mysql_query($sql);
			 $count=mysql_num_rows($sql); 
			 if($count=='0')
				{
                header("Location:".$HomeURL."/content/error.php");
						exit(); 
				}
			$row=mysql_fetch_array($sql);
			
			$update_date=$row['update_date'];
		$date=explode(' ',$row['update_date']);
		$m=explode('-',$date[0]);
					$d=$m[0];
					$d1=$m[1];
					$d2=$m[2];

		$date1=explode(' ',$row['create_date']);
		$m1=explode('-',$date1[0]);
					$cd=$m1[0];
					$cd1=$m1[1];
					$cd2=$m1[2];								 
		}
		$where = "";			
		if(isset($_POST['cmdSearch']) && $_POST['txtCategory'] != "") {
			$category 	= $_POST['txtCategory'];
			$where 		= "and whatsNew_cat =".$category;
		}
		$date=date('Y-m-d');
		$querysqlNew="select * from combine_publish where cat_id=1 and language_id=1 and approve_status=3 and date(end_date ) > '$date' ". $where ." order by m_id desc";
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
<title>Department of Empowerment of Persons with Disabilities What News page</title>

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
     <!--breadcrumb start-->
    <div id="breadcrumb">
      <div class="container"> 
       <div class="easy-breadcrumb">
        <ul>
  <li class="first"><?php echo "<a href=".$HomeURL."/content/>Home</a>"?></li>
			<span> &nbsp;>></span> What News
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
      <h1>What News</h1>
	  	  	  <form method="post" name="frm1" action="" autocomplete="off">

<?php 
			$sqlCategory = "SELECT * FROM whatsnew_category WHERE c_type = 1 AND c_status = 1";
			$rsCategory	 = mysql_query($sqlCategory);
	
 	  ?>
		<!--<span class="label1"><label  for="textcatgory">Category:</label></span>-->
		  <select name="txtCategory">
			<option value="">All</option>
			<?php while($data = mysql_fetch_array($rsCategory)){ ?>
			<option value="<?php echo $data['c_id'];?>" <?php if($_POST['txtCategory'] == $data['c_id']) echo "selected ='selected'";?> ><?php echo $data['c_name'];?></option>
			<?php }?>
		  </select>
		   <input type="submit" value="Search" name="cmdSearch">
	  </form>
     	<?php 
		$rsNew = mysql_query($querysqlNew);
		if(mysql_num_rows($rsNew) > 0 ){
		while($row_what_news=mysql_fetch_array($rsNew))
		{
/*if($row_what_news['image_file'] !=''){
$image=$HomeURL.'/upload/photogallery/'.$row_what_news['image_file'];
 }else { $image=$HomeURL.'/images/no-image.jpg'; }*/
?>


<div class="whatnews">
<h3><?php echo $row_what_news['m_name'];?></h3>
<?php echo stripslashes(html_entity_decode($row_what_news['m_content']));?>
<div class="whatnews_button"><a href="<?php echo $HomeURL;?>/content/viewpage/<?php echo $row_what_news['page_url'];?>" title="Read More about <?php echo limit_words($row_what_news['m_name'],5);?>">Read More</a><strong>Posted on: <?php echo date("d-m-Y",strtotime($row_what_news['create_date']));?></strong></div>
</div>


		<?php  }
		} else {?>
		<div class="titel-name">No Record found</div>
		<?php }?>
		<p style="float:right;font-weight:bold">Page Last updated on :

<?php 
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
		
<div class="clear"> </div>
<span class="anchor-icon"><a href="<?php echo $HomeURL; ?>/content/archive.php?txtcatgory=1">Archive</a></span>
</div>

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
