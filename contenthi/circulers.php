<?php
ob_start();
error_reporting(0);
session_start();
require_once "../includes/connection.php";
require_once "../includes/functions.inc.php";
//include("../includes/config.inc.php");
include("../includes/def_constant.inc.php");
include("../design.php");


@extract($_GET);
@extract($_SESSION);
$m_name = "Tender / Advertisement";

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
<title>Tender / Advertisement::<?php echo $sitename;?></title>

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


<!--End -->
<script type="text/javascript">
   jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");

 jQuery.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
 });


(function($,W,D)
{
	//alert("fffff");
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#feedback-form").validate({
				
                rules: {
                  
					 txtemail: {
						required: true,
						email: true
						},
					txtphone: {
								required: true,
								number: true,
								minlength: 10
						},
					
					txtcomment: "required",
					code: "required"
						
                    
					
                },
                messages: {
                  txtename: "Please Enter Name that should be alphabet",
					txtemail: "Please  Enter Valid Email Id like abc@xyz.com ",
					 txtphone: "Please Enter Contact Number that should be 10 to 12 digits",
					 address: "Address should be alphanumeric",
					txtcomment: "Please Enter Comment",
                  	 code: "Please enter correct Captcha code"
					  
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
	
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<script>
function ClearFields() {
		
     document.getElementById("code").value = "";

}
</script>
<style>
#feedback-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align: left;
    width: 220px; font-weight:bold;
}
#msgerror label{
	color: #FB3A3A;
	display: inline-block;
	margin: 0px;;
	padding: 0px;
	text-align: left;
	}
</style>


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
			<span> &nbsp;>></span> Circulars
</ul>
 <?php  if($_SESSION['admin_auto']!='')
	{ ?>
	  <div class="welcome-login">
	   <h3>Welcome  to <?php echo $_SESSION['login_user'];?></h3>
         <ul id="popup">
           <li><a href='<?php echo $HomeURL;?>/auth/logout.php?random=<?php echo $_SESSION['logtoken']; ?>' title="Logout" class="logout">Logout</a></li>
         </ul>
</div>
<?php } ?>
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
      <!--<div class="inner_left_childmenu">
         
         <?php include("inner_left_menu.php");?>
      </div>-->
      <div class="inner_left_fixmenu">
        <?php include("inner_fixed_menu.php");?>
     </div>
  </div>
    <!--inner_left_container end-->
    
    <div class="inner_right_container">
     <h1>Circulers / Events</h1>
      
<table>
    <caption>Circulers / Events</caption>
  <tbody>

  <tr>
    <th class="tender-name">Title</th>
    <!--<th class="tender-startdate">Date</th>-->
    <th class="tender-expirydate">PDF</th>
  </tr>
<?php  
$date=date('Y-m-d');
$sql_tender=mysql_query("select * from combine_publish where cat_id='2' and language_id='2' and approve_status='3' and date(end_date) >='$date'");
$num_rows=mysql_num_rows($sql_tender);
if($num_rows>0)
{
while($row_tender=mysql_fetch_array($sql_tender))
	{
	$exten=substr($row_tender['docs_file'],-4);
	if($row_tender['docs_file']!=''){
	$file='../../depwd/upload/'.$row_tender['docs_file'];
	$pdfsize='size:( '.formatFilebytes($file,'MB').')';
	}
	else { $pdfsize='No pdf File Exit' ;}
	?>
	 <tr class="odd">
    <td valign="top"><?php echo $row_tender['m_short'];?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>">&nbsp;&nbsp;</td>
     <!--<td valign="top"><?php echo changeformate($row_tender['start_date']);?></td>-->
    <td valign="top">
	<?php if($exten=='.pdf') { ?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>"><img src="<?php echo $HomeURL;?>/images/pdf_icon.png" alt="Pdf" height="16" />&nbsp;&nbsp;<?php echo $pdfsize;?></a>
	<?php } else if($exten=='.doc' || $exten=='docx') {  ?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>"><img src="<?php echo $HomeURL;?>/images/word.jpeg" alt="Doc" height="16" />&nbsp;&nbsp;<?php echo $pdfsize;?></a>
	<?php } ?>
	</td>
  </tr>
  <?php }} else{ ?>
<tr><td colspan="3" class="even" >No records found.</td></tr>	
<?php	}?>
  </tbody></table>

<span class="anchor-icon"><a href="<?php echo $HomeURL; ?>/content/archive.php?txtcatgory=4">Archive</a></span>

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
