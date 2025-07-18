<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
//include('../design.php');
//include("../counter.php");


?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>स्क्रीन रीडर: <?=$sitenamehi;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
		<link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	
	</head>
	
	<body id="fontSize">
			<header>
			<?php include("top_bar.php");?>
		    </header>
		<div class="mobile-nav">
                <img src="images/toogle.png" alt="toogle" title="toogle">
				</div>
		<nav>
		<div class="container">
			<?php include("header.php");?>
		</div>	
		</nav>
	<section>
		
			
			<div class="container">
				<div class="row">
					<div class="col-sm-3 left-navigation">
						
							<?php include("leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL; ?>/contenthi/index.php" title="मुखपृष्ठ ">मुखपृष्ठ </a></li>
							<li></li>
							<li class="pull-right"><button class="bt90" title="पीछे के पृष्ठ पर जाए" onclick="window.history.go(-1)"><strong>पीछे</strong></button> / <a href="javascript:void(0);" title="प्रिंट" onClick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a></li>
						</ul>
                        			<div class="bannerBox">
			                        	<img src="<?php echo $img;?>" alt="" title="" >
                        				<h2>स्क्रीन रीडर</h2>
			                        </div>
					</div>
					

<table class="screen-reader" title="screenreader">
	<caption>स्क्रीन रीडर का उपयोग</caption>
	<tbody>
		<tr>
			<th>स्क्रीन रीडर का उपयोग</th>
			<th>वेबसाइट</th>
			<th>फ्री / कमर्सिअल</th>
		</tr>
		<tr class="odd headclass">
			<td>नॉन विसुअल डेस्कटॉप एक्सेस (नवदा)</td>
			<td><a href="http://www.nvda-project.org/" target="_blank" title="बाहरी साइट जो नई विंडो में खुलती है" onclick="return confirm('बाहरी साइट जो नई विंडो में खुलती है');" class="ext">http://www.nvda-project.org <img src="../images/extlink.png" alt="External Link"/></a></td>
			<td>फ्री</td>
		</tr>
		<tr class="even">
			<td>सिस्टम एक्सेस टू गो</td>
			<td><a href="http://www.satogo.com/" target="_blank" title="बाहरी साइट जो नई विंडो में खुलती है" onclick="return confirm('बाहरी साइट जो नई विंडो में खुलती है');" class="ext">http://www.satogo.com <img src="../images/extlink.png" alt="External Link"/></a></td>
			<td>फ्री</td>
		</tr>
		<tr class="odd">
			<td>जेएडब्ल्यूएस</td>
			<td><a href="http://www.freedomscientific.com/Downloads/JAWS" target="_blank" title="बाहरी साइट जो नई विंडो में खुलती है" onclick="return confirm('बाहरी साइट जो नई विंडो में खुलती है');" class="ext">http://www.freedomscientific.com/Downloads/JAWS <img src="../images/extlink.png" alt="External Link"/></a></td>
			<td>फ्री</td>
		</tr>
	</tbody>
</table>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("footer.php");?>
		</footer>
	
	
	</body>
	
</html>
 
 <script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide");
});

function sitevisit()
{
	var returnvalue = confirm("This is an external link.Do you want to continue.");
	if(returnvalue == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
if(getCookie("mysheet") == "change" ) {
        setStylesheet("change") ;
    }else if(getCookie("mysheet") == "style" ) {
        setStylesheet("style") ;
    }else if(getCookie("mysheet") == "blue" ) {
        setStylesheet("blue") ;
    } else if(getCookie("mysheet") == "orange" ) {
        setStylesheet("orange") ;
    }else   {
        setStylesheet("") ;
    }

</script>
	




