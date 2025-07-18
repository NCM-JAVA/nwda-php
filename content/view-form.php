<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();

  $showid = base64_decode(trim($sid));
  $postedidd = $showid;
  $showid = content_desc(check_input($showid));
  if($postedidd != $showid)
  {
    header("Location:".$HomeURL."/content/error.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>National Water Development Agency</title>
  
   <script src="<?php echo $HomeURL;?>/js/jquery.flexslider.js"></script>	
  <script src="<?php echo $HomeURL;?>/js/jquery.min.js"></script>
  <script src="<?php echo $HomeURL;?>/js/bootstrap.min.js"></script>
  <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
   <script src="<?php echo $HomeURL;?>/js/swithcer.js"></script>
   <script type="text/javascript" src="<?php echo $HomeURL;?>/js/font-size.js"></script> 
    <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
   <script src="<?php echo $HomeURL;?>/js/jquery-migrate-1.0.0.js"></script>
    <script src="<?php echo $HomeURL;?>/js/jquery.js"></script>
	<script src="<?php echo $HomeURL;?>/js/jquery.easy-ticker.js"></script> 
	
 <link href="<?php echo $HomeURL; ?>/css/jsDatePick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $HomeURL;?>/js/jsDatePick.js"></script>

	<link href="<?php echo $HomeURL;?>/css/modern-ticker.css" rel="stylesheet">
	
    <link href="<?php echo $HomeURL;?>/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $HomeURL;?>/css/flexslider.css"/>
	
   <link href="<?php echo $HomeURL;?>/css/print.css" rel="stylesheet" media="print">
  <link href="<?php echo $HomeURL;?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $HomeURL;?>/css/bootstrap-theme.css" rel="stylesheet">
  <link href="<?php echo $HomeURL;?>/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="<?php echo $HomeURL;?>/css/style.css" rel="stylesheet">
  <link href="<?php echo $HomeURL;?>/css/responsive.css" rel="stylesheet">
   <link href="<?php echo $HomeURL;?>/css/jquery.treeview.css" rel="stylesheet">
  <link href="<?php echo $HomeURL;?>/css/high.css" rel="alternate stylesheet" type="text/css" media="screen" title="change" />  
  <link href="<?php echo $HomeURL;?>/css/blue.css" rel="alternate stylesheet" type="text/css" media="screen" title="blue" />  
  <link href="<?php echo $HomeURL;?>/css/green.css" rel="alternate stylesheet" type="text/css" media="screen" title="green" />  
  <link href="<?php echo $HomeURL;?>/css/orange.css" rel="alternate stylesheet" type="text/css" media="screen" title="orange" /> 


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script>
    $('.carousel').carousel({
        interval: 3000
    })
</script>
<style>
.about-child {
  display: block !important;
}
</style>
<script type="text/javascript">


$(function(){
	$('.demo5').easyTicker({
		direction: 'up',
		visible: 20,
		interval: 2500,
		controls: {
			up: '.btnUp',
			down: '.btnDown',
			toggle: '.btnToggle'
		}
	});
});

      $(function () {
          $(window).scroll(function () {
              if ($(this).scrollTop() > 300) {
                  $('.back-top').fadeIn();
              } else {
                  $('.back-top').fadeOut();
              }
          });

          // scroll body to 0px on click
          $('.back-top').click(function () {
              $('body,html').animate({
                  scrollTop: 0
              }, 1600);
              return false;
          });
      });
  
  </script>
  
  <script>
    $(document).ready(function () {

        // hide #back-top first
        $("#back-top").hide();

        // fade in #back-top
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });

            // scroll body to 0px on click
            $('#back-top a').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });

    });
</script>

<script type="text/javascript" >
    if(getCookie("mysheet") == "change" ) {
        setStylesheet("change") ;
    }else if(getCookie("mysheet") == "blue" ) {
        setStylesheet("blue") ;
    }else if(getCookie("mysheet") == "green" ) {
        setStylesheet("green") ;
    } else if(getCookie("mysheet") == "orange" ) {
        setStylesheet("orange") ;
    }else   {
        setStylesheet("") ;
    }
    </script>
		<script>
        $(document).ready(function () {
            $(".mobile-nav").click(function () {
                $(".sidebar-nav").toggle();
            });
        });
    </script>
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

    
    
</head>
<body id="fontSize" onLoad="initLightbox()">

	<section>
    <div class="container">
       <?php include("top-header.php");?>
	   </div> 
	
 <div class="container">
<div class="col-sm-3 color-left">
    <div class="sidebar-nav">
	<div class="left-nav">
		  <?php include("left-navigation.php");?>
	</div>
<script type="text/javascript">

//ddtreemenu.createTree(treeid, enablepersist, opt_persist_in_days (default is 1))

ddtreemenu.createTree("treemenu1", false)
ddtreemenu.createTree("treemenu2", false)

</script>

    </div>
    
   <div class="left-nav latest-news">
   
   <h2>Latest News</h2>
   <?php include("latest-news.php");?>
   </div> 
    
    
     </div>

 <div class="col-sm-9 rith-part">
 <div class="pull-right"><span class="btn btn-primary btn-sm ">
    <a href="<?php echo $HomeURL;?>/auth/logout.php"  onclick="return confirm('Do you really want to Logout?');" title="Logout" class="wcolor"><span class="glyphicon glyphicon-user"></span> Logout</a>
        </span></div>
<div class="clearfix"></div>
  
        <ul class="breadcrumb">

        <li><a href="index.php">Home</a></li>
        <li class="active">Application Form</li>
		<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button></li>

    </ul>

<p class="pull-right">
   <span class="btn btn-default btn-sm">
		<a href="javascript: void(0);" title="Print" onClick="javascript:window.print();"> <span class="glyphicon glyphicon-print"></span> Print</a>
        </span>
      </p>

 <h2>Application Form</h2>
<div>

<?php

 $show="SELECT * FROM `appform_detail` where app_id='$showid'";
 $result = mysql_query($show);
$fetch_detail=mysql_fetch_array($result);
$ccid=$fetch_detail['category'];
      $cat_id=$fetch_detail['post'];
 $queryfee="SELECT `catfee` FROM `post_qualificationage` WHERE `catid`='$ccid' and `post_id`='$cat_id'";
$resfee=mysql_query($queryfee);
$datafee = mysql_fetch_array($resfee, MYSQL_ASSOC);
$post_fee=$datafee['catfee'];
//$post_fee=0;
@extract($fetch_detail);
	  	$img_path = $HomeURL.'/upload/advertise/'.$image_name;
      $sig_path = $HomeURL.'/upload/advertise/'.$signature;
$_SESSION['app_no']=$fetch_detail['app_no'];
$_SESSION['fee']=$post_fee;
?>
<table class="table">
  <tr>
<?php
if($post_fee==0)
{

?>

    <td>Application Number :</td>
    <td><div class="col-md-12"><?php echo $fetch_detail['app_no'];?></div></td>
    

<?php

}
else
{
?>
    <td>Fee :</td>
    <td><div class="col-md-12"><?php echo $post_fee;?></div></td>
  <?php
  }

?>



    <td rowspan="6"><div class="col-md-4">
      <div class=""><img src="<?php echo $img_path;?>" alt="avatar" height=200px width=200px;>
      </div>
    </div></td>
  </tr>
  <tr>
    <td>Post Applied For</td>
    <td><div class="col-md-12">
      <?php 
      $cat_id=$fetch_detail['post'];
$qq="SELECT `postname` FROM `post_mst` where `post_id`='$cat_id'";
$p=mysql_query($qq);
$data = mysql_fetch_array($p, MYSQL_ASSOC);
echo $data['postname'];

$age_on_que="SELECT `age` FROM `post_mst` where   post_id='$cat_id'";
$dadt_age_on_que=mysql_query($age_on_que);
$row_age_on_que = mysql_fetch_array($dadt_age_on_que, MYSQL_ASSOC);


?>
    
</div></td>
    </tr>
  <tr>
    <td>Name in Full</td>
    <td><div class="col-md-12"> <?php echo $fetch_detail['name'];?></div></td>
    </tr>
  <tr>
    <td>Email Id</td>
    <td><div class="col-md-12"><?php echo $fetch_detail['email'];?></div></td>
    </tr>
  <tr>
    <td>Optional Email Id</td>
    <td><div class="col-md-12"><?php echo $fetch_detail['opt_email'];?> </div></td>
    </tr>
  <tr>
    <td>Gender</td>
    <td><div class="col-md-12"> <?php echo $fetch_detail['gender'];?> </div></td>
    </tr>
  <tr>
    <td>Father's/Husband's Name</td>
    <td colspan="2">
    <div class="col-md-6">
      <?php echo $fetch_detail['par_name'];?>
    </div></td>
    </tr>
  <tr>
    <td>Date of Birth</td>
    <td colspan="2"><div class="col-md-6">

    <?php echo date('d/m/Y', strtotime($fetch_detail['dob']));?>
      
    </div></td>
  </tr>
  <tr>
    <td>Nationality</td>
    <td colspan="2"><div class="col-md-6">
     <?php echo $fetch_detail['nation'];?>
    </div></td>
  </tr>
  <tr>
    <td>Age as on :- <span><?php echo date('d/m/Y', strtotime($row_age_on_que['age']));?></span></td>
    <td colspan="2"><div class="col-md-6">
     <?php echo $fetch_detail['age'];?>
    </div></td>
  </tr>
  <tr>
    <td>Marital Status</td>
    <td colspan="2">
    <div class="col-md-6">
   <?php echo $fetch_detail['m_status'];?></div></td>
  </tr>
  <tr>
    <td>Present Address</td>
    <td colspan="2"> <div class="form-group col-md-6"><?php echo $fetch_detail['c_address'];?>
</div></td>
  </tr>
  <tr>
    <td>Permanent Address</td>
    <td colspan="2"><div class="form-group col-md-6"><?php echo $fetch_detail['p_address'];?>
</div></td>
  </tr>
  <tr>
    <td>Phone No</td>
    <td colspan="2"><div class="col-md-6">
     <?php echo $fetch_detail['mobile'];?>
    </div></td>
  </tr>
  <tr>
    <td>Category</td>
    <td colspan="2"><span class="col-md-6">
<?php 
$ccid=$fetch_detail['category'];
$q_q="SELECT `c_name` FROM `category_master` where `c_id`='$ccid'";
$pp=mysql_query($q_q);
$datap = mysql_fetch_array($pp, MYSQL_ASSOC);
echo str_replace("( No payment)"," ",$datap['c_name']);
?>
    </span></td>
  </tr>
  <tr>
                                      <?php

                          $show2="SELECT * FROM `appform_qualification` WHERE  app_id='$showid'";
 $result_qua = mysql_query($show2);
 //$rowno=mysql_num_rows($result_qua);
?>

    <td colspan="3">Qualification (Matriculation onward) (10<sup>th</sup> and 12<sup>th</sup> Qualifications are mandatory)</td>
    </tr>
  <tr>
    <td colspan="3">
    
<table class="table table-striped" id="tab_logic">
  <tr>
    <th>Examination Passed</th>
    <th>Name of Universtiy Board</th>
    <th>Month of Passing</th>
    <th>Year of passing</th>
    <th>Subjects</th>
     <th>Division</th>
   <th>% of Mark</th>
  </tr>
   <?php 
while($fetch_qualification=mysql_fetch_array($result_qua))   
    {
      @extract($fetch_qualification);
?>
<tr>
    <td><?php 
      $qquid=$fetch_qualification['exam'];
     
    if( is_numeric($qquid))
    {
      $query_qual=mysql_fetch_array(mysql_query("SELECT `Qualification_list`
FROM `qualification_mst`
WHERE `qualification_id`='$qquid'"));


    echo $query_qual['Qualification_list'];
    }
    else
      echo $qquid;
   


    ?></td>


    <td><?php echo $fetch_qualification['board'];?></td>
    <td><?php echo $fetch_qualification['pass_month'];?></td>
    <td><?php echo $fetch_qualification['pass_year'];?></td>
    <td><?php echo $fetch_qualification['subject'];?></td>
     <td><?php echo $fetch_qualification['divison'];?></td>
    <td><?php echo $fetch_qualification['marks']."%";?></td>
    
  </tr>


<?php

}
?>
  <tr id='addr1'> </tr>
</table>
    </td>
    </tr>
  <tr>
    <td colspan="3">Other Qualification :-
    <?php 
    if(!empty($fetch_detail['other_qualification']))
     echo $fetch_detail['other_qualification'];
else 
  echo "NULL";
      ?></td>
  </tr>
  <tr>
    <td colspan="3">Post Qualifcation Experience (From Current Employment to Past Employment.)</td>
  </tr>
  <tr>
    <td colspan="3">

<table class="table table-striped" id="tab_logic1">
  <tr>
    <th>Name</th>
    <th>Address of employer</th>
    <th>Post Held</th>
    <th>From</th>
    <th>To</th>
    <th>Jobs Handled (Job Description) &amp; Nature of Job (Contractual / Regular)</th>
    <th>Mention Govt. / PSU / Semi Govt. / Autonomous Body / Private</th>
    <th>Individual Exp</th>
    <th>Mention IDA / CDA / Grade Pay</th>
    <th>Pay Scale</th>
    <th>Monthly CTC</th>
    <th>Annual CTC</th>
  </tr>
   <?php

                          $show3="SELECT * FROM `appform_experience` WHERE  app_id='$showid'";
                        $result_ex = mysql_query($show3);
             
while($fetch_exp=mysql_fetch_array($result_ex))   
    {
      @extract($fetch_exp);
?>
<tr>
    <td><?php echo $fetch_exp['e_name'];?></td>
    <td><?php echo $fetch_exp['e_address'];?></td>
    <td><?php echo $fetch_exp['e_post'];?></td>
    <td><?php echo date('d/m/Y', strtotime($fetch_exp['e_from']));?></td>
    <td><?php echo date('d/m/Y', strtotime($fetch_exp['e_to']));?></td>
    <td><?php echo $fetch_exp['j_d'];?></td>
    <td><?php echo $fetch_exp['e_type'];?></td>
    <td><?php echo $fetch_exp['experience'];?></td>
    <td><?php echo $fetch_exp['pay_type'];?></td>
    <td><?php echo $fetch_exp['pay_scale'];?></td>
    <td><?php echo $fetch_exp['month_salary'];?></td>
    <td><?php echo $fetch_exp['gross_salary'];?></td>
    
  </tr>


<?php

}




?>
  <tr id='addr1'> </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>Total Experience : (Y-m-d)</td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['total_exp'];?></div></td>
  </tr>
  <tr>
    <td colspan="3">Language Known</td>
  </tr>
  <tr>
    <td colspan="3">
    

<table class="table table-striped" id="tab_logic2">
  <tr>
    <th>Language</th>
    <th>Status</th>
    <th>Examination Passed</th>
  </tr>
<?php

                          $show4="SELECT * FROM `appform_language` WHERE  app_id='$showid'";
                        $result_lang = mysql_query($show4);
             
while($fetch_lang=mysql_fetch_array($result_lang))   
    {

      @extract($fetch_lang);
?>
<tr>
    <td><?php echo $fetch_lang['language'];?></td>
    <td><?php echo $fetch_lang['status'];?></td>
    <td><?php echo $fetch_lang['certificate'];?></td>
    
</tr>


<?php

}

?>

 <tr id='addr1'> </tr>
</table>
    
    </td>
  </tr>
  <tr>
    <td>Why do you consider yourself<br>
 suitable for the post !</td>
    <td colspan="2"><div class="form-group col-md-6">
  
  <?php echo $fetch_detail['suitable'];?>
</div></td>
  </tr>
  <tr>
    <td>Have you any relative employed in <br>
this company before ? <br>
If so, name designation and relationship:</td>
    <td colspan="2">
    <div>
<?php if($fetch_detail['rel']=="yes")
{

 echo $fetch_detail['relative_per']; 
}
 else 
 {

  echo "NO"; 
 }
 ?>

  
        
    </div>


  </tr>
  <tr>
    <td colspan="3">Any defect or impairment in :</td>
    </tr>
  <tr>
    <td>Hearing</td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['def_h'];?>
    </div></td>
  </tr>
  <tr>
    <td>Sight</td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['def_s'];?>
    </div></td>
  </tr>
  <tr>
    <td>Limbs</td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['def_l'];?>
    </div></td>
  </tr>
  <tr>
    <td colspan="3">Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer: <?php echo $fetch_detail['decipline'];?></td>
    </tr>
  <tr>
    <td>Preferred Place of Interview :</td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['inter_place'];?>
    </div></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:11px;">I solemnly declare that all the particulars furnished in this application are true and correct to the best of my knowledge and belief. I clearly understand that any misstatement of facts contained therein or wilful concealment of any material fact will render me liable to appropriate action as may be decided by the company.

</td>
    </tr>
  <tr>
    <td>Place </td>
    <td colspan="2"><div class="col-md-6"><?php echo $fetch_detail['place'];?>
    </div></td>
  </tr>
  <tr>
    <td>Date</td>  
    <td colspan="2"><div class="col-md-6"><?php echo date('d/m/Y', strtotime($fetch_detail['i_date']));?>
    </div></td>
  </tr>
  <tr>
    <td>Signature</td>
    <td colspan="2"><div class="col-md-6"><img src="<?php echo $sig_path;?>" alt="avatar" height=200px width=200px;></div></td>
  </tr>
  <tr>
<?php
if($post_fee==0)
{
  ?>
    <td><span >Your application has been submitted sucessfully</span></td>
  <?php


}
else
{
?>
   <!--<td><a href="payment/index.php" class="btn btn-primary" title="Make Payment" onclick="sitevisit()"><span class="glyphicon glyphicon-piggy-bank"></span>Make Payment</a></td>-->
  <?php
  }

?>


    
    <td colspan="2"><a href="vacancy_form_pdf.php?pdfid=<?php echo $showid;?>" class="btn btn-primary"><span class="glyphicon glyphicon-duplicate"></span> PDF</a> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>


</div>

 </div>
     
   </section>
   <p id="back-top">
		<a href="#top"><span></span></a>
	</p>
   
   <div class="container">
   
 <div class=" footer row col-sm-12">
 
<?php include('footer.php');?>
</div> 

 <script type="text/javascript">
function sitevisit()
{
if (! confirm('your application has been submitted sucessfully and you will not be able to edit your application after making online payment.?')) 
return false;
}
</script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('li.dropdown:has(ul:empty)').remove();
        jQuery('ul.menu li:has(ul)').addClass('collapsed');
        jQuery("ul.menu").treeview({
            collapsed: true,
            unique: true,
            persist: "location"
        });
        return false;
    });
	</script>

  </body>
</html>
