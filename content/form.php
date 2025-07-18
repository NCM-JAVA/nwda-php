<?php
//session_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");
require_once "../securimage/securimage.php";
extract($_POST);
extract($_GET);
extract($_REQUEST);
//if(empty($_SESSION['app_user']))
//{
  //header("Location:".$HomeURL."/auth/index.php");
//}
/*if(isset($_SESSION['app_user']))
{
$user=$_SESSION['app_user'];
$email=$_SESSION['app_user_email'];
$query="SELECT `app_no`,`app_id`,`payment_status` FROM `appform_detail` WHERE `name`= '$user' and`email`='$email'";
$res=mysql_query($query);
$row_no=mysql_num_rows($res);
if($row_no>0)
{
$data = mysql_fetch_array($res, MYSQL_ASSOC);
$app_id=$data['app_id'];
$_SESSION['app_id']=$data['app_no'];
$payment_status=$data['payment_status'];
if($payment_status==0)
{
 
$send=base64_encode($app_id);
header("location:view-form.php?sid=$send");
}
elseif ($payment_status==1) {
 header("location:after_payment.php");
}
}

}*/
//@extract($_GET);
@extract($_POST);
//@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
$application=date(dmy);
$ran=substr(rand(1000,9999),0,4);
$applicationno=$ran.$application;



$ptid = trim($_REQUEST['pid']);
$requestpid = $ptid;
$ptid = content_desc(check_input($ptid));
if($requestpid != $ptid)
{
	header("Location:".$HomeURL."/content/error.php");
	exit();
}

$postid = trim($postid);
$postedidd = $postid;
$postid = content_desc(check_input($postid));
if($postedidd != $postid)
{
	header("Location:".$HomeURL."/content/error.php");
	exit();
}

$pid=base64_decode($postid);
if(isset($cmdsubmit))
{
  // echo "<pre>";
  // print_R($_POST);
  // exit;

  $p_need=content_desc(check_input($_POST['post_need'])) ;
  $loop=content_desc(check_input($_POST['loop'])) ;
  if ($p_need==1){
    $loop=4;
  }
  if(empty($loop))
  {
    $loop=3;
  }


  $appno=$applicationno;
  $post= content_desc(check_input($_POST['post']));
  $name =content_desc(check_input($_POST['name']));
  $email=content_desc(check_input($_POST['email']));
  $opt_email= content_desc(check_input($_POST['opt_email']));

  $gender =content_desc(check_input($_POST['gender']));
  $par_name= content_desc(check_input($_POST['par_name']));
  $dob= content_desc(check_input($_POST['dob']));
  $nation= content_desc(check_input($_POST['nation']));
  $age= content_desc(check_input($_POST['age']));
  $m_status= content_desc(check_input($_POST['m_status']));
  $c_address= content_desc(check_input($_POST['c_address']));
  $p_address= content_desc(check_input($_POST['p_address']));
  $mobile= content_desc(check_input($_POST['mobile']));

  $unique=uniqid();
  $category= content_desc(check_input($_POST['category']));
  $ph_percentage= content_desc(check_input($_POST['ph_percentage']));
  $other_qualification= content_desc(check_input($_POST['other_qualification']));
  $typeingspeed= content_desc(check_input($_POST['typeingspeed']));
  $total_exp=content_desc(check_input($_POST['total_exp']));                       
  $tmp_name=$_FILES["file"]["tmp_name"];
  $image_name1=$_FILES["file"]["name"];
  $image_name=$unique. $image_name1;
  $signature1=$_FILES["signature"]["name"];
  $signature=$unique. $signature1;
  
  $sig_tmp_name=$_FILES["signature"]["tmp_name"];
  $imagepath="../upload/advertise/".$image_name ;
  $signaturepath="../upload/advertise/".$signature ;
  $consider_tmp_name=$_FILES["w_consider"]["tmp_name"];
  $consider_name=$_FILES["w_consider"]["name"];
  $consider_path="../upload/advertise/".$consider_name ;

  $suitable= content_desc(check_input($_POST['suitable']));
  $rel= content_desc(check_input($_POST['rel']));
  $relative_per= content_desc(check_input($_POST['relative_per']));
  $def_h= content_desc(check_input($_POST['def_h']));
  $def_s= content_desc(check_input($_POST['def_s']));
  $def_l= content_desc(check_input($_POST['def_l']));
  $decipline= content_desc(check_input($_POST['decipline']));
  $inter_place= content_desc(check_input($_POST['inter_place']));
  $place= content_desc(check_input($_POST['place']));                        
  $i_date= content_desc(check_input($_POST['i_date']));

      
  $academic= content_desc(check_input($_POST['academic']));
  $publication= content_desc(check_input($_POST['publication']));
  $membership= content_desc(check_input($_POST['membership']));                        
  $activities= content_desc(check_input($_POST['activities']));
  $exam=content_desc(check_input($_POST['exam']));



  $a_10th=array($exam_10th,$exam_board_10th,$exam_month_10th,$exam_year_10th,$exam_subj_10th,$exam_div_10th,$exam_perc_10th);


  $a_12th=array($exam_12th,$exam_board_12th,$exam_month_12th,$exam_year_12th,$exam_subj_12th,$exam_div_12th,$exam_perc_12th);
  $graduatee=array($grad_exam,$grad_exam_board,$grad_exam_month,$grad_exam_year,$grad_exam_subj,$grad_exam_div,$grad_exam_perc);
  $post_graduatee=array($post_grad_exam,$post_exam_board,$post_exam_month,$post_exam_year,$post_exam_subj,$post_exam_div,$post_exam_perc);


  $errmsg="";        // Initializing the message to hold the error messages
                                         
  if(trim($post)=="")
  {
    $errmsg .="Please select post applied for."."<br>";
  }
  
  if(trim($name)=="")
  {
    $errmsg .="Please enter name."."<br>";
  }
  else if(preg_match("/^[aA-zZ][a-zA-Z -]{2,30}+$/", $name) == 0)
  {
	  $errmsg .= "Name must be from letters that should be minimum 3 and maximum 30."."<br>";
  }
										 
  if(trim($email)=="")
  {
    $errmsg .="Please enter Email Id."."<br>";
  }
  elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
    $errmsg=$errmsg."Please enter valid email Id."."<br>";
  }

              
  $filesize=$_FILES['file']['size'];
  $signaturesize=$_FILES['signature']['size'];
  $maxsize=52400;
  $minsize=1048;
                                /*
                                $types = array('image/jpeg', 'image/gif', 'image/png','image/jpg');

                                if (!in_array($_FILES['file']['type'], $types)) {
                                $errmsg .= "Please Uploade GIF,PNG,JPG and JPEG images for Picture."."<br>";
                                } 
                                elseif($filesize<=$minsize || $filesize>=$maxsize )
                                {

                                  $errmsg .= "Picture  should be between in 2 kb and 50kb."."<br>";
                                } 
                                if (!in_array($_FILES['signature']['type'], $types)) {
                                $errmsg .= "Please Uploade GIF,PNG,JPG and  JPEG images For Signature."."<br>";
                                }

                                elseif($signaturesize<$minsize || $signaturesize>$maxsize )
                                {

                                  $errmsg .= "Signature should be between in 2 kb and 50kb";
                                }*/




  if($_FILES["file"]["tmp_name"]=="")
  {
    $errmsg .= "Please Upload a Picture.<br>";
  }
  elseif($_FILES["file"]["tmp_name"] != "")
  {
    $tempfile=($_FILES["file"]["tmp_name"]);
    $imageinfo = ($_FILES["file"]["type"]);
    $section = strtoupper(base64_encode(file_get_contents($tempfile)));
    $nsection=substr($section,0,8);
  
    if ( $section != strip_tags($section) )
    {
      $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Picture.<br>';
    }else{
      //echo $section;die();
      $imageinfo = getimagesize($_FILES["file"]["tmp_name"]);

      $extarray = explode(".",$_FILES["file"]["name"]);
      if(count($extarray)>2)
      {
        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Picture.<br>';
      }elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
      {
        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Picture.<br>';
      }elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
      {}else{
        $errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only For Picture.<br>';
      }
      if ($_FILES["file"]["size"] < $minsize || $_FILES["file"]["size"] > $maxsize )
      {
        $errmsg .= "Picture should be between in 2 kb and 50kb.<br>";
      }
    }
  }

                                
                            
  if($_FILES["file"]["tmp_name"]=="")
  {
    $errmsg .= "Please Upload a Picture.<br>";
  }
  elseif($_FILES["file"]["tmp_name"] != "")
  {
    $tempfile=($_FILES["signature"]["tmp_name"]);
    $imageinfo = ($_FILES["signature"]["type"]);
    $section = strtoupper(base64_encode(file_get_contents($tempfile)));
    $nsection=substr($section,0,8);

    if ( $section != strip_tags($section) )
    {
      $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Signature.<br>';
    }else{
      //echo $section;die();
      $imageinfo = getimagesize($_FILES["signature"]["tmp_name"]);

      $extarray = explode(".",$_FILES["signature"]["name"]);
      if(count($extarray)>2)
      {
        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Signature.<br>';
      }elseif($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png' && isset($imageinfo))
      {
        $errmsg .= 'Sorry, we only accept GIF,PNG,JPG and JPEG images For Signature.<br>';
      }elseif(($nsection=="/9J/4AAQ")  OR ($nsection=="IVBORW0K") OR ($nsection=="R0LGODLH") OR ($nsection=="/9J/4TFN"))
      {}else{
        $errmsg .= 'Please upload GIF,PNG,JPG or JPEG images only For Signature.<br>';
      }
      if ($_FILES["signature"]["size"] < $minsize || $_FILES["signature"]["size"] > $maxsize )
      {
        $errmsg .= "Signature should be between in 2 kb and 50kb.<br>";
      }
    }
  }


  
  if(trim($par_name)=="")
  {
    $errmsg .="Please enter Father's/Husband's Name."."<br>";
  }

  if(trim($dob)=="")
  {
    $errmsg .="Please select Date of Birth."."<br>";
  }

  if(trim($nation)=="")
  {
    $errmsg .="Please enter Nationality."."<br>";
  }

  if(trim($c_address)=="")
  {
    $errmsg .="Please enter Present Address."."<br>";
  }

  if(trim($mobile)=="")
  {
    $errmsg .="Please enter Phone Number."."<br>";
  }
  if(!is_numeric(trim($mobile)))
  {
    $errmsg .="Phone number should be numeric."."<br>";
  }
  
  if(trim($ph_percentage)=="")
  {
    $errmsg .="Please select Physical Handicap."."<br>";
  }
  
  if(trim($inter_place)=="")
  {
    $errmsg .="Please select Preferred Place of Interview."."<br>";
  }
  
  if(trim($place)=="")
  {
    $errmsg .="Please select Place."."<br>";
  }


  
  



                 $considerinfo =$_FILES["w_consider"]["type"];
                

                
if(trim($total_exp)=="" || trim($total_exp)=="NaN year and NaN month")
                {
          $errmsg .="Please Select Individual experience or Total Experience."."<br>";
                }

                          
                                          
       
                                          if (empty($_POST['lang'][0]))
                                          {

                                          $errmsg .= "One Language must Fill."."<br>";

                                          }


  


if($errmsg !='') 
         {

          $errmsg .= "Please Select Post Again And Fill the experience And rest Empty Mendtry field"."<br>";
         } 
                                  

//echo $errmsg ;

                                          if($errmsg == '')

          {             
            move_uploaded_file($tmp_name, $imagepath);
           move_uploaded_file($sig_tmp_name, $signaturepath);
           move_uploaded_file($consider_tmp_name, $consider_path);
      //first part and last part

           $tableName_send="appform_detail";
           $tableFieldsName_send=array("app_no","post","name","email","opt_email","gender","par_name","dob","nation","age","m_status","c_address","p_address","mobile","category","other_qualification","typeingspeed","total_exp","image_name","signature","suitable","suitable_pdf","rel","relative_per","def_h","def_s","def_l","decipline","inter_place","place","i_date","academic","publication","activities","membership","ph_percentage");
           $tableFieldsValues_send=array("$appno","$post","$name","$email","$opt_email","$gender","$par_name","$dob","$nation","$age","$m_status","$c_address","$p_address","$mobile","$category","$other_qualification","$typeingspeed","$total_exp","$image_name","$signature ","$suitable","$consider_name","$rel","$relative_per","$def_h","$def_s","$def_l","$decipline"," $inter_place"," $place","$i_date","$academic","$publication","$activities","$membership","$ph_percentage");
           $useAVclass->insertQuery($tableName_send,$tableFieldsName_send,$tableFieldsValues_send);
           $id=mysql_insert_id();

             //second part exam  
$tableName_send2="appform_qualification";
                        $tableFieldsName_send2=array("app_id","exam","board","pass_month","pass_year","subject","divison","marks");
                        for($i=1;$i<=$loop;$i++)
                        {
                         if($i==1)
                         {
                          $arr=$a_10th;
                         }
                         elseif ($i==2) {
                           $arr=$a_12th;
                          } 
                         elseif ($i==3) {
                           $arr=$graduatee;
                          }
                         elseif ($i==4) {
                            $arr=$post_graduatee;
                          }
                               $tableFieldsValues_send2[]=$id;
for ($j=0; $j <count($arr) ; $j++) {
 $tableFieldsValues_send2[]=$arr[$j];

 if($j==count($arr)-1)
 {
  //print_r($tableFieldsValues_send2);
  $useAVclass->insertQuery($tableName_send2,$tableFieldsName_send2,$tableFieldsValues_send2);
unset($tableFieldsValues_send2);

 }                         
}

          }

   //part 3

                        if (!empty($_POST['e_name'][0])) {
                          $tableName_send3="appform_experience";
                          $tableFieldsName_send3=array("app_id","e_name","e_address","e_post","e_from","e_to","j_d","e_type","experience","pay_type","pay_scale","gross_salary","month_salary");
                          for($i=0;$i<count($_POST['e_name']);$i++)
                          {
                             if (!empty($_POST['e_name'][$i]))
                          {
                            $e_name=$_POST['e_name'][$i];

                            $e_address=$_POST['e_address'][$i];               
                            $e_post=$_POST['e_post'][$i];
                            $e_from=$_POST['e_from'][$i];
                            $e_to=$_POST['e_to'][$i];
                            $j_d=$_POST['j_d'][$i];
                            $e_type=$_POST['e_type'][$i];
                            $experience=$_POST['experience'][$i];

                            $pay_type=$_POST['pay_type'][$i];

                            $pay_scale=$_POST['pay_scale'][$i];
                            $month_salary=$_POST['month_salary'][$i];
                            $gross_salary=$_POST['gross_salary'][$i];
                            $tableFieldsValues_send3=array("$id","$e_name","$e_address","$e_post","$e_from","$e_to","$j_d","$e_type"," $experience" ,"$pay_type","$pay_scale","$gross_salary","$month_salary");
                            $useAVclass->insertQuery($tableName_send3,$tableFieldsName_send3,$tableFieldsValues_send3);
}
                          }     
                        }


   //PART4

                            if (!empty($_POST['lang'][0])) {
                              $tableName_send4="appform_language";
                              $tableFieldsName_send4=array("app_id","language","status","certificate");
                              for($i=0;$i<count($_POST['lang']);$i++)
                              {
                                if (!empty($_POST['lang'][$i]))
                          {
                                $lang=$_POST['lang'][$i];

                                $status=$_POST['status'][$i];               
                                $certificate=$_POST['exam_pass'][$i];
                                $tableFieldsValues_send4=array("$id","$lang","$status","$certificate");
                                $useAVclass->insertQuery($tableName_send4,$tableFieldsName_send4,$tableFieldsValues_send4);

}
                              }    

                            }



            $email_from = "anil.dwivedi@netcreativemind.co.in"; // Who the email is from 
            $email_subject = "Application"; // The Subject of the email
            $email_to= $_POST[email];
            $headers.= "From: ".$email_from."\r\n"; 
            $headers.= "Content-type: text/html; charset=iso-8859-1\n"; 
            $email_message.="
            <table width='98%' border='0' align='center' cellpadding='2' cellspacing='2' class='normaltext'>
            <tr>
              <td colspan='3' align='left' valign='top'>Dear ".$_POST[name].",</td>
            </tr>
              <tr>
              <td colspan='3' align='left' valign='top'>&nbsp;</td>
            </tr>
            <tr>
              <td colspan='3' align='left' valign='top'>Your Application has been submitted successfully. Your application id is ".$applicationno."</td>
            </tr>
                <tr>
              <td colspan='3' align='left' valign='top'>Make The Payments Untill you are not Eligible</td>
            </tr>
            
        
              <tr>
              <td colspan='3' align='left' valign='top'>Regards,</td>
              </tr>
              <tr>
              <td colspan='3' align='left' valign='top'>EPIL</td>
              </tr>
        
            </table>";  
        
        
            $ok=@mail($email_to, $email_subject, $email_message, $headers);

//  mail to Admin Ends


    

                                            $msg=Application_Complete;
                                            $_SESSION['sess_msg']=$msg;
                                            echo $_SESSION['sess_msg'];
                                            $send=base64_encode($id);
                                            header("location:view-form.php?sid=$send");
                                            exit;

                                          }


                                        }
                                        ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Feedback" />
<meta name="description" content="Feedback" />
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>National Water Development Agency</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Bootstrap -->   
  <!--    <script type="text/javascript" src="<?php echo $HomeURL;?>/js/jsDatePick.js"></script> -->
      <script src="<?php echo $HomeURL;?>/js/jquery.min.js"></script>
    <!--   <link href="<?php echo $HomeURL;?>/css/jsDatePick.css" rel="stylesheet" type="text/css" /> -->
     <script src="<?php echo $HomeURL;?>/js/notify.min.js"></script>
      <script src="<?php echo $HomeURL;?>/js/bootstrap.js"></script>
      <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
      <script src="<?php echo $HomeURL;?>/js/swithcer.js"></script>
      <script type="text/javascript" src="<?php echo $HomeURL;?>/js/font-size.js"></script> 
      <script src="<?php echo $HomeURL;?>/js/jquery.treeview.js"></script>
      <script src="<?php echo $HomeURL;?>/js/bootstrap-datepicker.js"></script> 
 
      <script src="<?php echo $HomeURL;?>/js/swithcer.js"></script>
      <script type="text/javascript" src="<?php echo $HomeURL;?>/js/font-size.js"></script> 
         <script type="text/javascript" src="<?php echo $HomeURL;?>/js/validation.js"></script> 



     <link href="<?php echo $HomeURL;?>/css/datepicker.css" rel="stylesheet"> 
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
      <link rel="stylesheet" href="<?php echo $HomeURL;?>/css/lightbox.css" type="text/css" media="screen" />

<style>
table td {
    /*border: 1px solid #015198;*/ 
    font-size: 14px;
    text-align: left !important; 
  font-size:13px;
  width:200px;
}
</style>

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
        //            var date = new Date();
        // var d = new Date();        
        // d.setDate(date.getDate()); 
                    // When the document is ready
                    $(document).ready(function () {
         $('#example1').datepicker({ 
                       format: "yyyy-mm-dd"
                       //autoclose: true
         }); 
         
                              $('#example1').on('changeDate', function(ev){
                                                          //$(this).datepicker('hide');

                                                          var age = this.value;

                                                  var age_on=$("#fetch_age_on").val();
                                                          if(age!='')
{

  getAge(age,age_on);
  if($('#category').val()!='')
   {
$('#category').val('');

   }
}
                                       
                                                        
                       
        } );


       

                              
                              $('.date1').datepicker({

                        format: "yyyy/mm/dd"
                      });
        $('.date2').datepicker({

                        format: "yyyy/mm/dd",

 });

         $('.date1').on('changeDate', function(ev){
                                                          //$(this).datepicker('hide');
                                                           //getdate();

                                                          if(this.value!='')
{
  
 less_year_exp(this);

}
                                                           
                                               });


          $('.date2').on('changeDate', function(ev){
                                                          //$(this).datepicker('hide');
                                                           //getdate();

                                                          if(this.value!='')
{
  
 last_ex_ind(this);

}
                                                           
                                               });

});
                  </script>  



                </head>
        <body id="fontSize" onLoad="fetch_education(<?php  echo $ptid; ?>)">

         <section>
          <div class="container">
           <?php include("top-header.php");?>
         </div> 

         <div class="container">
           <div class="mobile-nav">
            <img src="<?php echo $HomeURL?>/images/toogle.png">
          </div>
          
<div class="col-sm-12 rith-part">

<!--div class="pull-right"> <strong>Usear Name: <?php echo $_SESSION['app_user'];?></strong> &nbsp; <?php echo $_SESSION['app_user_email'];?> &nbsp; <span class="btn btn-primary btn-sm ">
    <a href="<?php echo $HomeURL;?>/auth/logout.php"  onclick="return confirm('Do you really want to Logout?');" title="Logout" class="wcolor"><span class="glyphicon glyphicon-user"></span> Logout</a>
        </span></div-->
<div class="clearfix"></div>
  <ul  class="breadcrumb">

    <li><a href="<?php echo $HomeURL;?>/content/index.php">Home</a></li>
    <li class="active">Application Form</li>
    <li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button></li>
   </ul>
   

  <p class="pull-right">
   <span class="btn btn-default btn-sm">
    <a href="javascript: void(0);" title="Print" onClick="javascript:window.print();"> <span class="glyphicon glyphicon-print"></span> Print</a>
        </span>
  </p>
  <h2>Application Form</h2>
  <p>
 
   <form action="#" method="post" name="form1" autocomplete="off" id="feedback-form" enctype="multipart/form-data" onSubmit="return last_allow()">
    <?php if($errmsg!=""){?>
      <div  id="msgerror" class="status error">
        <div class="closestatus" style="float: none; background-image: url(../images/fade_red.png);">
          <p class="closestatus" style="float: right;"><img alt="Attention" src="<?php echo $HomeURL;?>/images/close1.png" class="margintop"></p>
          <p><img alt="error" src="<?php echo $HomeURL;?>/images/error.png"> <span>Attention! <br /></span>

            <?php echo $errmsg; ?></p>
          </div>
        </div>
        <?php }
        else if($_SESSION['sess_msg']!=''){?>
         <div  id="msgclose" class="status success">
           <div class="closestatus" style="float: none;">
             <p class="closestatus" style="float: right;"><img alt="Attention" src="<?php echo $HomeURL;?>/images/close.png" class="margintop"></p>
             <p><img alt="Attention" src="<?php echo $HomeURL?>/images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['sess_msg'];
               $_SESSION['sess_msg']=""; ?></p>
             </div>
           </div>
           <?php  } ?>
           <table class="table">
            <tr>
              <td></td>
              <td>
                
              </td>
              <td rowspan="6"><div class="col-md-4">
                <div class="text-center">
<span class="star">*</span>
                  <img src="<?php echo $HomeURL;?>/images/1.jpg" class="avatar img-circle img-thumbnail" alt="avatar">

                  <h6>Upload the latest photo</h6>
                  <input type="file" class="text-center center-block well well-sm" name="file" required>
                </div>
              </div></td>
            </tr>
<script type="text/javascript">
  function fetch_education(id)
  {
   var send=id;
    $.ajax({
            type:"post",
            url:"fetch_edu.php",
            data:{"id":send},
            success:function(msg){
            
              $("#grad_exam").html(msg);
 }

});



     $.ajax({
            type:"post",
            url:"fetch_age_ondate.php",
            data:{"id":send},
             dataType: "json",
            success:function(msg2){
           
           $("#fetch_age_on").val(msg2.age_on);
          $("#show_age_on").text(msg2.age_on);
          $("#percennt").val(msg2.percent);
 }

});


     $.ajax({
            type:"post",
            url:"fetch_pg_exp.php",
            data:{"id":send},
            dataType: "json",
            success:function(msg3){
               //alert(msg3.post+" "+msg3.exp)
           $("#post_qual").text(msg3.post);
           $("#post_exp").text(msg3.exp);
 }

});
}

function get_percent_ajax(argument) {
   var post_id=$("#select_post").val();
   var qualif=argument.value;
if(qualif.trim()!='' && qualif.trim()!='Select Graduation')
{
$.ajax({
            type:"post",
            url:"fetch_post_percent.php",
            data:{"id":post_id,"grad":qualif},
          success:function(msg3){
            //alert(msg3);
         $("#post_grad_exam").html(msg3);
          
 }

});


$.ajax({
            type:"post",
            url:"fetch_require_percent.php",
            data:{"id":post_id,"grad":qualif},
            dataType: "json",
            success:function(msg){
         
         if(msg.need==1)
         {
          $("#p_post_need").val(1);
         $('#graduation_min_percent').val(msg.req_perc);
$('#post_grad_exam').notify("For Your Graduation Post Qualification Is Mandatory",{position:"right",className: "warn" });
$(".post_exam_req").prop('required',true);
}

else
{
  $('#graduation_min_percent').val(msg.req_perc);
   $("#p_post_need").val(0);
$(".post_exam_req").prop('required',false);
  $('#post_grad_exam').notify("For Your Graduation Post Qualification Is Optional",{position:"right",className: "info" });
}
           
 }

 

});



$.ajax({
            type:"post",
            url:"fetch_exp_on_gradu.php",
            data:{"id":post_id,"grad":qualif},
            dataType: "json",
            success:function(msg3){
              //alert(msg3.year_field);
          $("#after_date_exp").val(msg3.year_field);
         
 }

});

$.ajax({
            type:"post",
            url:"fetch_for_other.php",
            data:{"grad":qualif},
            //dataType: "json",
            success:function(msg3){
              //alert(msg3);
              if(msg3==1)
              {
$("#alt_grad").remove();
                $("#other_graduation").append('<input type="text" name="grad_exam" required id="alt_grad" placeholder="Your Other Graduation">');
                $("#grad_exam").attr('name', 'grad_exam_alt'); 
              }
              else
              {
                $("#alt_grad").remove();
                $("#grad_exam").attr('name', 'grad_exam'); 
              }
          
         
 }

});



}
else
{
$("#alt_grad").remove();
}




}

function get_post_percent_ajax(arg)
{
 
if($("#p_post_need").val()==0)
{
if (arg.value!='') {
   $(".post_exam_req").prop('required',true);
    $("#loop").val(4);
  }
  else{
   $(".post_exam_req").prop('required',false);
   $("#loop").val(3);
  }
}

var post_id=$("#select_post").val();
   var post_qualif=arg.value;
   if(post_qualif.trim()!='')
{
$.ajax({
            type:"post",
            url:"fetch_require_percent.php",
            data:{"pid":post_id,"post_grad":post_qualif},
            //dataType: "json",
            success:function(msg){
           $("#post_graduation_min_percent").val(msg.trim());
       
 }

});



$.ajax({
            type:"post",
            url:"fetch_for_other.php",
            data:{"grad":post_qualif},
            //dataType: "json",
            success:function(msg3){
              //alert(msg3);
              if(msg3==1)
              {
$("#alt_post_grad").remove();
                $("#other_post_graduation").append('<input type="text" name="post_grad_exam" required id="alt_post_grad" placeholder="Your Other Post Graduation">');
                $("#post_grad_exam").attr('name', 'post_grad_exam_alt'); 
              }
              else
              {
                $("#alt_post_grad").remove();
                $("#post_grad_exam").attr('name', 'post_grad_exam'); 
              }
          
         
 }

});
}
else
{
  $("#alt_post_grad").remove();
}
}

</script>



            <tr><input type="hidden" name="loop" id="loop">
              <td>Post Applied For</td>
              <td><div class="col-md-12"><select  required id="select_post"  name="post" class=" form-control" >
              <option value="">Select</option>
<?php 
$p_query="SELECT `post_id`,`postname` FROM `post_mst` where  approve_status=1 ";
$p_res=mysql_query($p_query);
while($p_data = mysql_fetch_array($p_res, MYSQL_ASSOC))
  {
@extract($p_data);
?>
 
<option value="<?php echo $post_id;?>" <?php if($post_id=="$_REQUEST[pid]") {  echo "selected"; } ?>><?php echo $postname;?></option>
<?php
   }
              //echo $ageon;

?>


              </select></div></td>
            </tr>
            <tr>
              <td>1.Name of the Applicant (in Block Letter)<span class="star">*</span></td>
              <td><div class="col-md-12"><input class="form-control" type="text" name="name" id="name"  placeholder="Enter Name"  </div></td>
            </tr>
            <tr>
              <td>2.Email Id<span class="star">*</span></td>
              <td><div class="col-md-12"><input class="form-control" type="text" name="email" id="email"  placeholder="Enter Email"   </div></td>
            </tr>
			
            <tr>
              <td>Optional Email Id</td>
              <td><div class="col-md-12"><input class="form-control" onBlur="return emailValidation(this)"  type="text" name="opt_email" value="<?php echo $opt_email;?>"></div><span id="opt_email" class="validation_error"></td>
            </tr>
            <tr>
              <td>3.Gender</td>
              <td><div class="col-md-12"><select required name="gender" class=" form-control">
                <option value="">Select Gender</option>
                <option <?php if($gender=="Male") echo "selected";?>>Male</option>
                <option <?php if($gender=="Female") echo "selected";?>>Female</option>
                 <option <?php if($gender=="Other") echo "selected";?>>Other</option>

              </select></div></td>
            </tr>
            <tr>
              <td>4.Father's/Husband's Name<span class="star">*</span></td>
              <td colspan="2">
                <div class="col-md-6">
                  <input class="form-control" type="text" name="par_name" onBlur="return commanValidation(this)" value="<?php echo $par_name;?>" required>
                </div><span id="par_name" class="validation_error"></span></td>
              </tr>
              <tr>
             
                <td>5.Date of Birth<span class="star">*</span></td>
                <td colspan="2"><div class="col-md-6">
                  <input type="text"   name="dob" id="example1"  placeholder="click to show datepicker" class="form-control" value="<?php echo $dob;?>" readonly>

                </div></td>
              </tr>
              <tr>
                <td>6.Nationality<span class="star">*</span></td>
                <td colspan="2"><div class="col-md-6">
                  <input class="form-control" type="text" name="nation" onBlur="return commanValidation(this)" value="<?php if(isset($nation))echo $nation; else echo 'Indian'?>" >
                </div><span id="nation" class="validation_error"></span></td>
              </tr>
             <!-- <tr>
                <td><input type="hidden" value="" id="fetch_age_on" name="fetch_age_on">7.Age as on  <b><span id="show_age_on"></span></b>  (dd/mm/yyyy)</td>

                <td colspan="2"><div class="col-md-6">
                  <input class="form-control" type="text" id="age" name="age" value="<?php echo $_POST['age'];?>" readonly>
                  <input type="hidden" name="" id="hid_age">
                </div></td>
              </tr>-->
              <tr>
                <td>8.Marital Status</td>
                <td colspan="2">
                  <div class="col-md-6">
                    <select name="m_status"  class=" form-control" required>
                    <option value="">Select</option>
                      <option <?php if($m_status=="Married") echo "selected";?>>Married</option>
                      <option <?php if($m_status=="Unmarried") echo "selected";?>>Unmarried</option>
                    </select></div></td>
                  </tr>

<script type="text/javascript">
    function same_add()
    {
     $("#paddress").val($("#caddress").val());

    }

</script>
                  <tr>
                    <td>9.(i)Present Address<span class="star">*</span></td>
                    <td colspan="2"> <div class="form-group col-md-6">

                      <textarea class="form-control" rows="5" id="caddress" name="c_address"  onblur="return alphanumeric(this)" required ><?php echo $c_address;?></textarea><span id="c_address" class="validation_error"></span>
                    </div>
<input type="checkbox" onChange="same_add()"><span>check if both addresses are same.</span>

                    </td>
                  </tr>
                  <tr>
                    <td>(ii)Permanent Address</td>
                    <td colspan="2"><div class="form-group col-md-6">

                      <textarea class="form-control" onBlur="return alphanumeric(this)" rows="5" id="paddress" name="p_address"><?php echo $p_address;?></textarea><span id="p_address" class="validation_error"></span>
                    </div></td>
                  </tr>
                  <tr>
                    <td>10.Phone No.<span class="star">*</span></td>
                    <td colspan="2"><div class="col-md-6">
                      <input class="form-control" onBlur="return mobileValidation(this)" type="text" name="mobile" value="<?php echo $mobile;?>" maxlength=10 required>
                    </div><span id="mobile" class="validation_error"></td>
                  </tr>
                  <tr>
                    <td>11.Category<span class="star">*</span></td>
                    <td colspan="2"><span class="col-md-6">
<script type="text/javascript">
function fetch_age_fe(val)
  {
      var post=$("#select_post").val();
       var send=val;
        $.ajax({
            type:"post",
            url:"fetch_age_fe.php",
            data:{"post":post,"send":send},
            dataType: "json",
            success:function(msg){
              //alert(msg);
              //$.notify("For your post The Fees is "+msg.fee+" and The max Age is "+ msg.age, "info");
             //alert("For your post The Fees is "+msg.fee+" and The max Age is "+ msg.age);
             if($("#hid_age").val()>parseInt(msg.age))
                   {
                 $("#age").notify("Your age is greter than max age So you are not Eligible",{className: "error",hideDuration: 5000 });   
                 $.notify("Your age is greter than max age So you are not Eligible", "warn");
      var msg="You are not Eligible due to your age is Max ";
          //block(msg);
          $("#age_block_msg1").val(msg);
      
 }
  else{

$("#age_block_msg1").val('');

}
             
 }

});



  }

</script>


                      <select id="category" name="category"  class=" form-control" onChange="fetch_age_fe(this.value)" required>
                        <option value="">-Select-</option>
<?php 
$c_query="SELECT * FROM `category_master` where status=1";
$c_res=mysql_query($c_query);
while($data = mysql_fetch_array($c_res, MYSQL_ASSOC))
              {
@extract($data);
?>
<option value="<?php echo $c_id;?>" <?php if ($category==$c_name) echo 'selected="selected"';?>><?php echo $c_name;?></option>
<?php
              }


function make_year($b)
{
echo "<option value=''>Select</option>";
  for ($j=date('Y'); $j>=1960 ; $j--) { 

    ?>

    <option value="<?php echo $j;?>" <?php
if($j==$b)echo "selected";
    ?>><?php echo $j;?></option>
    <?php
  

  }

}


function make_month($a)
{
?>
<option value=''>Select Month</option>
                            <option value='1'<?php if($a==1) echo 'selected';?>>Janaury</option>
                            <option value='2' <?php if($a==2) echo 'selected';?> >February</option>
                            <option value='3' <?php if($a==3) echo 'selected';?> >March</option>
                            <option value='4' <?php if($a==4) echo 'selected';?> >April</option>
                            <option value='5'<?php if($a==5) echo 'selected';?> >May</option>
                            <option value='6' <?php if($a==6) echo 'selected';?> >June</option>
                            <option value='7' <?php if($a==7) echo 'selected';?> >July</option>
                            <option value='8' <?php if($a==8) echo 'selected';?> >August</option>
                            <option value='9' <?php if($a==9) echo 'selected';?> >September</option>
                            <option value='10' <?php if($a==10) echo 'selected';?> >October</option>
                            <option value='11' <?php if($a==11) echo 'selected';?> >November</option>
                            <option value='12' <?php if($a==12) echo 'selected';?> >December</option>

<?php

}

?>
</select>
                    </span></td>
                  </tr>
          <tr>
                    <td>Physical Handicap (Is More than 40%)<span class="star">*</span></td>
                    <td colspan="2"><div class="col-md-6">
                    <label><input type="radio" name="ph_percentage" value="yes" <?php if ($ph_percentage=="Yes") echo 'checked"';?>> Yes</label>
                    <label><input type="radio" name="ph_percentage" value="no" <?php if ($ph_percentage=="No") echo 'checked' ;else echo 'checked';?>>No</label>
                    </div><span id="ph" class="validation_error"></td>
                  </tr>
                  <tr>
                    <td colspan="3">12.Qualification (Matriculation onward) (10<sup>th</sup> and 12<sup>th</sup> Qualifications are mandatory) <span class="star">*</span></td>
                  </tr>

                  <tr>
                    <td colspan="3">


                    <input type="hidden" value="" id="p_post_need" name="post_need"> 
                    <table class="table table-striped" id="tab_logic">
                    <thead>
                      <tr>
                        <th>Examination Passed</th>
                        <th>Name of Universtiy Board</th>
                        <th>Month of Passing</th>
                        <th>Year of passing</th>
                        <th>Subjects</th>
                         <th>Division</th>
                         <th>% of Mark</th>
                        </tr>
                        </thead>
                        <tbody id='quali_row'>
                    <tr>
<td>
  <input type="text" name="exam_10th" value="10th"  class="form-control" readonly/><span id="exam_10th" class="validation_error"></span>

</td>
<td><input type="text" name="exam_board_10th"  onblur="return alphanumeric(this)" value="<?php echo $a_10th[1];?>"  class="form-control" required/><span id="exam_board_10th" class="validation_error"></span></td>
<td><select name="exam_month_10th" id='Month1' class="form-control" required>
                            <?php make_month($a_10th[2]);?>
                          </select></td>

                          <td>    <select name="exam_year_10th" id="year1" class="form-control" onChange="or_year(this)" required>
                            <?php make_year($a_10th[3]);?>
                          </select></td>

                          <td><input type="text" name="exam_subj_10th" onBlur="return alphanumeric(this)" value="<?php echo $a_10th[4];?>" class="form-control" required/><span id="exam_subj_10th" class="validation_error"></span></td>
                           <td>
             <select name="exam_div_10th" class="form-control"  id="div_1" required>          
<option value="">-Select-</option>
<option value="First" <?php if($a_10th[5]=="First") echo 'selected';?>>First</option>
<option value="Second" <?php if($a_10th[5]=="Second") echo 'selected';?>>Second</option>
<option value="Third" <?php if($a_10th[5]=="Third") echo 'selected';?>>Third</option>
</select> 
 </td>
<td><input type="text"  id="1" name="exam_perc_10th" onBlur="percentage(this)" value="<?php echo $a_10th[6];?>" class="form-control" maxlength=3  required/><span id="10th_exam_perc" class="10th_exam_perc" ></span></td>
</tr>


<tr>
<td>
  <input type="text" name="exam_12th" value="12th"  class="form-control" readonly/><span id="12th_exam" class="validation_error"></span>

</td>
<td><input type="text" name="exam_board_12th"  onblur="return alphanumeric(this)" value="<?php echo $a_12th[1];?>"  class="form-control" required/><span id="exam_board_12th" class="validation_error"></span></td>
<td><select name="exam_month_12th" id='Month2' class="form-control" required>
                        <?php make_month($a_12th[2]);?>
                          </select></td>

                          <td>    <select name="exam_year_12th" onChange="or_year(this)" class="form-control" id="year2" required>
                            <?php make_year($a_12th[3]);?>
                          </select></td>

                          <td><input type="text" name="exam_subj_12th" onBlur="return alphanumeric(this)" value="<?php echo $a_12th[4];?>" class="form-control" required/><span id="exam_subj_12th" class="validation_error"></span></td>
                           <td>
             <select name="exam_div_12th" class="form-control" id="div_2" required>          
<option value="">-Select-</option>
<option value="First" <?php if($a_12th[5]=="First") echo 'selected';?>>First</option>
<option value="Second" <?php if($a_12th[5]=="Second") echo 'selected';?>>Second</option>
<option value="Third" <?php if($a_12th[5]=="Third") echo 'selected';?>>Third</option>
</select> 
 </td>
<td><input type="text"  id="2" name="exam_perc_12th" onBlur="percentage(this)" value="<?php echo $a_12th[6];?>" class="form-control" maxlength=3  required/><span id="12th_exam_div" class="validation_error"></span></td>
</tr>
<tr><input type="hidden" name="graduation_min_percent" value="" id="graduation_min_percent">
<td id="other_graduation">
<select name="grad_exam" class="form-control" onChange="get_percent_ajax(this)" id="grad_exam">
<option value="">Select Graduation</option>

</select>
</td>
<td><input type="text" name="grad_exam_board"  onblur="return alphanumeric(this)" value=""  class="form-control"/><span id="grad_exam_board" class="validation_error"></span></td>
<td><select name="grad_exam_month" id='Month3' class="form-control">
                           <?php make_month();?>
                          </select></td>

                          <td>    <select name="grad_exam_year" onChange="or_year(this)" class="form-control" id="year3">
                            <?php make_year();?>
                          </select></td>

                          <td><input type="text" name="grad_exam_subj" onBlur="return alphanumeric(this)" value="" class="form-control"/><span id="grad_exam_subj" class="validation_error"></span></td>
                           <td>
             <select name="grad_exam_div" class="form-control" id="div_3">          
<option value="">-Select-</option>
<option value="First">First</option>
<option value="Second">Second</option>
<option value="Third">Third</option>
</select> 
 </td>
<td><input type="text"  id="3" name="grad_exam_perc" onBlur="percentage(this)" value="" class="form-control" maxlength=3 /><span id="grad_exam_div" class="validation_error"></span></td>
</tr>
<tr>
<td id="other_post_graduation"><input type="hidden" name="post_graduation_min_percent" value="" id="post_graduation_min_percent">
<select name="post_grad_exam" class="form-control post_exam_req" onChange="get_post_percent_ajax(this)" id="post_grad_exam">
<option value="">Select Post Graduation</option>
</select></td>
<td><input type="text" name="post_exam_board"  onblur="return alphanumeric(this)" value=""  class="form-control post_exam_req" /><span id="post_exam_board" class="validation_error"></span></td>
                          <td><select name="post_exam_month" id='Month4' class="form-control post_exam_req">
                             <?php make_month();?>
                            
                          </select></td>


<td>    <select name="post_exam_year" class="form-control post_exam_req" onChange="or_year(this)" id="year4">
                          <?php make_year();?>
                            
                          </select></td>
                          <td><input type="text" name="post_exam_subj" onBlur="return alphanumeric(this)" value="" class="form-control post_exam_req" /><span id="post_exam_subj" class="validation_error"></span></td>
                    <td>
             <select name="post_exam_div"  class="form-control post_exam_req" id="div_4">          
<option value="">-Select-</option>
<option value="First">First</option>
<option value="Second">Second</option>
<option value="Third">Third</option>

</select>  </td>


                    


                          <td><input type="text"  id="4" name="post_exam_perc" onBlur="percentage(this)" value="" class="form-control post_exam_req" maxlength=3 /><span id="post_exam_div" class="validation_error"></span></td>


</tr>


                        </tbody>
                       
                       
        </table>
         



 </td>
                    </tr>
                    <tr>
                    <td>Other Qualification :</td>
                    <td colspan="2"> <div class="form-group col-md-6">
<textarea placeholder="Other qualification" class="form-control"  onblur="return alphanumeric(this)" rows="5"  cols="245"id="comment" name="other_qualification"><?php echo $other_qualification;?></textarea>
                      <span id="other_qualification" class="validation_error"></span>
                    </div>
</td>
                      </tr>
					  
<?php
$sqllevel="select post_level from post_mst where post_id='".$_GET['pid']."'";
$ressql=mysql_query($sqllevel) or die(mysql_error());
$ressql=mysql_fetch_array($ressql);
$LevelName = $ressql['post_level'];
?>
					  
					   <tr>
                    <td><?php echo $LevelName;  ?>	       
</td>
                    <td colspan="2"> <div class="form-group col-md-6">
<textarea placeholder="<?php echo $LevelName;  ?>" class="form-control"  rows="5"  cols="245"id="comment" name="typeingspeed"><?php echo $typeingspeed;?></textarea>
                      <span id="typeingspeed" </span>
                    </div>
</td>
                      </tr>
                    <tr>
                    <input type="hidden" value="" id="after_date_exp">
                      <td colspan="3">13.Post Qualifcation Experience After(<span class="star" id="post_qual"></span>) (<span class="star" id="post_exp"></span>)(From Current Employment to Past Employment.)<span class="star">*</span></td>
                      <input type="hidden" name="" id="last_idv_exp">
                    </tr>
                    <tr>
                      <td colspan="3" width="100px">


                       <script>

                         $(document).ready(function(){
                          var i=1;
                          var j=0
                          $("#add_row1").click(function(){
                               var val1=$('#pay_1'+j).val();
                               //alert('#pay_1'+j);
                               var val2=$('#month_1'+j).val();
                               //alert(val2);
                               var val3=$('#gross_1'+j).val();
                               //alert(val3);
                               if( val1==""|| val2=="" || val3=="" )
                               {
                                $("#add_row1").notify("Kindly Fill the All Values Of Above row",{position:"right",className: "warn" });
                            return false;
                               }
                               else
                               {
                                j=j+1;
   $('#addr1'+i).html("<td><input type='text' id='username' name='e_name[]' value=''  class='form-control' required /></td><td><textarea required id='comment' rows='3' class='form-control' name='e_address[]' ></textarea> </td>\n\
                              <td><input  required type='text' class='form-control'  name='e_post[]'/></td><td><input required  name='e_from[]'  type='text' class='form-control date1' id='dfrom_"+i+"'/></td><td><input  required name='e_to[]'  type='text' class='form-control date2' id='dto_"+i+"'/></td>\n\
                              <td><textarea required  id='comment' rows='3' class='exp_valid' name='j_d[]'></textarea></td><td><select name='e_type[]' class='form-control'><option> Govt</option><option>PSU</option><option>Semi Govt.</option> <option>Autonomous Body</option><option>Private</option></select></td>\n\
                              <td><textarea  required onclick='getdate(this.id)' id='ex_coment"+i+"' rows='3' class='form-control totalexp' name='experience[]' readonly></textarea></td><td><select name='pay_type[]' class='form-control'><option>IDA</option><option>CDA</option><option>Grade Pay</option></select></td>\n\
                              <td><input required  name='pay_scale[]' id='pay_1"+j+"' onkeypress='return number_valid(event,this)' type='text' class='form-control ' /></td><td><input required name='month_salary[]'  id='month_1"+j+"' type='text' class='form-control' onkeypress='return number_valid(event,this)' /></td><td><input required name='gross_salary[]'  id='gross_1"+j+"' type='text' class='form-control' onkeypress='return number_valid(event,this)' /></td></tr>");

                               }
                         

                            $('#tab_logic1').append('<tr id="addr1'+(i+1)+'"></tr>');
                            i++; 

$('.date1').datepicker({

                format: "yyyy/mm/dd"

              });
$('.date2').datepicker({

                format: "yyyy/mm/dd"
              });

$('.date1').on('changeDate', function(ev){
                                                          //$(this).datepicker('hide');
                                                           //getdate();

                                                          if(this.value!='')
{
  
 less_year_exp(this);

}
                                                           
                                               });


          $('.date2').on('changeDate', function(ev){
                                                          //$(this).datepicker('hide');
                                                           //getdate();

                                                          if(this.value!='')
{
  
 last_ex_ind(this);

}
                                                           
                                               });







                          });
                          $("#delete_row1").click(function(){
                            if(i>1){
                             $("#addr1"+(i-1)).html('');
                             i--;
                           }
                         });

                        });
                      </script>
                      
                  <div style="overflow-x:scroll;width:1170px">
                      <table class="table table-striped" id="tab_logic1">
                        <tr>
                          <th>Employer Name</th>
                          <th>Address of employer</th>
                          <th>Post Held</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Jobs Handled (Job Description) &amp; Nature of Job (Contractual / Regular)</th>
                         <!-- <th>Mention Govt. / PSU / Semi Govt. / Autonomous Body / Private</th>-->
                          <th>Individual Exp</th>
                         <!-- <th>Mention IDA / CDA / Grade Pay</th>-->
                          <th>Pay Scale</th>
                          <th>Monthly CTC</th>
                          <th>Annual CTC</th>
                        </tr>
                        <tr id='addr0'>
                          <td><input type="text" onBlur="return alphanumeric(this)" name="e_name[]" value=""  class=""  required/><span id="e_name[]" class="validation_error"></td>
                          <td><textarea id="comment" onBlur="return alphanumeric(this)" rows="3" class="" name="e_address[]" required></textarea><span id="e_address[]" class="validation_error"></td>
                          <td><input type="text" name="e_post[]" onBlur="return alphanumeric(this)"  class="" required/><span id="e_post[]" class="validation_error"></td>
                          <td><input type="text"  name="e_from[]" placeholder="click to show datepicker" id="dfrom_1" class="date1" required></td>
                          <td><input type="text"  name="e_to[]" placeholder="click to show datepicker" id="dto_1" class="date2" required></td>
                       <td><textarea id="comment" rows="3" class="exp_valid"  onBlur="return alphanumeric(this)" name="j_d[]" required></textarea><span id="j_d[]" class="validation_error"></td>
                          
                          <td><textarea id="ex_coment1" rows="3" class="totalexp" name="experience[]" onClick="getdate(this.id)" readonly required></textarea></td>
                         
  <td><input type="text"  name="pay_scale[]" id="pay_10" class="" onKeyPress="return number_valid(event,this)"/></td>
  <td><input type="text" name="month_salary[]" id="month_10" class="" onKeyPress="return number_valid(event,this)" required/></td>
                          <td><input type="text" name="gross_salary[]" id="gross_10" class="" onKeyPress="return number_valid(event,this)"/></td>
                        </tr>
                        <tr id='addr1'> </tr>
                      </table>

 
</div>
<a id="add_row1" class="btn btn-primary pull-left">Add Row</a><a id='delete_row1' class="pull-right btn btn-primary">Delete Row</a>
                    </td>

  </tr>

                  <script type="text/JavaScript">

                                 

                  </script>
                  <tr>
                    <td><label for="total_exp">Total Experience</label> : (Y-m)</td>
                    <td colspan="2"><div class="col-md-6"><input type="text" name="total_exp" id="total_exp" class="form-control" onClick="total()" readonly  required/></div></td>
                  </tr> 
                  <tr>
                    <td colspan="3">14.Language Known:<span class="star">*</span></td>
                  </tr>
                  <tr>
                    <td colspan="3">

                     <script>

                       $(document).ready(function(){
                        var i=1;
                        var k=0;
                        $("#add_row2").click(function(){
                          var vall1=$('#add_lang_1'+k).val();
                          var vall2=$('#add_status_1'+k).val();

 if( vall1==""|| vall2=="")
                               {
                                 $("#add_row2").notify("Kindly Fill the All Values Of Above row",{position:"right",className: "warn" });
                                //alert("Kindly Fill the All Values Of Above row");
                                return false;
                               }
                     else
                     {
k=k+1;

                   
                          $('#addr2'+i).html("<td><input type='text' id='add_lang_1"+k+"' name='lang[]' value=''  class='form-control' /></td><td><select onBlur='return alphanumeric(this)' name='status[]' id='add_status_1"+k+"'><option value=''>-Select-</option><option>Read Only</option><option>Speak only</option><option>Read And Speak</option><option>Read, write And  speak</option></select></td><td><input  name='exam_pass[]' type='text' class='form-control' /></td></tr>");
}
                          $('#tab_logic2').append('<tr id="addr2'+(i+1)+'"></tr>');
                          i++; 
                        });

                        $("#delete_row2").click(function(){
                          if(i>1){
                           $("#addr2"+(i-1)).html('');
                           i--;
                         }
                       });

                      });
                    </script>
                    <table class="table table-striped" id="tab_logic2">
                      <tr>
                        <th>Language</th>
                        <th>Status</th>
                        <th>Examination Passed</th>
                      </tr>
                      <tr id='addr02'>
                        <td>
                          <input  type="text" id="add_lang_10" name="lang[]" onBlur="return alphanumeric(this)" value=""  class="form-control" required/><span id="lang[]" class="validation_error">
                        </td>
                        <td>
            <select onBlur="return alphanumeric(this)" name="status[]" id="add_status_10" required>
            <option value="">Select</option>
              <option>Read Only</option>
              <option>Speak only</option>
              <option>Read And Speak</option>
              <option>Read, write And speak</option>
            </select>
            <!--<input type="text" name="status[]" value="" onBlur="return alphanumeric(this)"class="form-control" />--><span id="status[]" class="validation_error">
            </td>
                        <td><input type="text" name="exam_pass[]" value="" onBlur="return alphanumeric(this)"class="form-control"required /><span id="exam_pass[]" class="validation_error"></td>
                      </tr>
                      <tr id='addr1'> </tr>
                    </table>

                    <a id="add_row2" class="btn btn-primary pull-left">Add Row</a><a id='delete_row2' class="pull-right btn btn-primary">Delete Row</a>

                  </td>
                </tr>
         <tr>
                      <td colspan="3">15.Extra Curricular activities/professional attainments:</td>
                    </tr>
                    <tr>
                      <td>Academic</td>
                      <td colspan="2"><div class="col-md-6">
                        <input class="form-control" onBlur="return alphanumeric(this)" type="text" name="academic" value="<?php echo $academic;?>">
                      </div></span>
                    </td>
                    </tr>
                    <!--<tr>
                      <td>Publications</td>
                      <!--<td colspan="2"><div class="col-md-6">
                        <input class="form-control" onBlur="return alphanumeric(this)" type="text" name="publication" value="<?php echo $publication;?>">
                      </div></td>
                    </tr>-->
                    <tr>
                      <td>Sports/literary/cultural activities</td>
                      <td colspan="2"><div class="col-md-6">
                        <input class="form-control"  onblur="return alphanumeric(this)"type="text" name="activities" value="<?php echo $activities;?>">
                      </div></td>
                    </tr>
          
         <!--  <tr>
                      <td>Membership of professional sicieties/organizations/Institutes</td>
                      <td colspan="2"><div class="col-md-6">
                        <input class="form-control"  onblur="return alphanumeric(this)"type="text" name="membership" value="<?php echo $membership;?>">
                      </div></td>
                    </tr>-->
        
        
                <tr>
                  <td>16.Why do you consider yourself<br>
                   suitable for the post !<span class="star">*</span></td>
                   <td colspan="2"><div class="form-group col-md-6">

                    <textarea required class="form-control"  onblur="return alphanumeric(this)" rows="5" id="comment" name="suitable"><?php echo $suitable;?></textarea>
                  </div><span id="suitable" class="validation_error"></span><!--<label>Only Pdf</label><input type="file" class="text-center  well well-sm" name="w_consider">--></td>
                </tr>
                <tr>
                <script type='text/javascript'>

jQuery(document).ready(function(){
$("#cmdsubmit").hide();
$("#rel_comment").hide();
$('input:radio[name="rel"]').change(function(){
    if($(this).val() == 'no'){
       $("#rel_comment").hide();
    }
    if($(this).val() == 'yes'){
       $("#rel_comment").show();
    }
});



});

// ]]>
</script>
                  <td>17.Have you any relative employed in <br>
                    this company before ? <br>
                    If so, name designation and relationship:<span class="star">*</span></td>
                    <td colspan="2">
                      <div>

                        <label><input type="radio" name="rel" value="yes" <?php if ($rel=="Yes") echo 'checked';?>> Yes</label>
                        <label><input type="radio" name="rel" value="no" <?php if ($rel=="No") echo 'checked'; else echo "checked";?>>No</label>

                      </div>
                      <div class="red box"></div>

                      <div class="form-group col-md-6 green box">

                        <textarea id="rel_comment" rows="5" class="form-control" onBlur="return alphanumeric(this)" name="relative_per"></textarea>
                      </div>
<span id="relative_per" class="validation_error"></span>
                    </tr>
                    <tr>
                      <td colspan="3">18.Any defect or impairment in :</td>
                    </tr>
                    <tr>
                      <td>Hearing</td>
                      <td colspan="2"><div class="col-md-6">
                        <!--<input class="form-control" onBlur="return alphanumeric(this)" type="text" name="def_h" value="<?php echo $def_h;?>">-->
            <div>

                        <label><input type="radio" name="def_h" value="yes" <?php if ($def_h=="Yes") echo 'selected="selected"';?>> Yes</label>
                        <label><input type="radio" name="def_h" checked value="no" <?php if ($def_h=="No") echo 'selected="selected"';?>>No</label>

                      </div>
            
            
            
                      </div><span id="def_h" class="validation_error"></span>
                    </td>
                    </tr>
                    <tr>
                      <td>Sight</td>
                      <td colspan="2"><div class="col-md-6">
                       <!-- <input class="form-control" onBlur="return alphanumeric(this)" type="text" name="def_s" value="<?php echo $def_s;?>">-->
            <div>

                        <label><input type="radio" name="def_s" value="yes" <?php if ($def_s=="Yes") echo 'selected="selected"';?>> Yes</label>
                        <label><input type="radio" name="def_s" checked value="no" <?php if ($def_s=="No") echo 'selected="selected"';?>>No</label>

                      </div>
            
            
                      </div><span id="def_s" class="validation_error"></span>
            </td>
                    </tr>
                    <tr>
                      <td>Limbs</td>
                      <td colspan="2"><div class="col-md-6">
                        <!--<input class="form-control"  onblur="return alphanumeric(this)"type="text" name="def_l" value="<?php echo $def_l;?>">-->
            <div>

                        <label><input type="radio" name="def_l" value="yes" <?php if ($def_l=="Yes") echo 'selected="selected"';?>> Yes</label>
                        <label><input type="radio" name="def_l" checked value="no" <?php if ($def_l=="No") echo 'selected="selected"';?>>No</label>

                      </div>
                      </div><span id="def_l" class="validation_error"></span></td>
                    </tr>
                    <tr>
                      <td colspan="3">19.Whether any disciplinary proceedings initiated against you or had you been called upon to explain your conduct in any manner by your previous employer:
                        <input type="radio" name="decipline"  value="yes" <?php if ($decipline=="yes") echo 'selected="selected"';?>><span>Yes</span>
                        <input type="radio" name="decipline" value="no" <?php if ($decipline=="no") echo 'selected="selected"';?>><span>No</span></td>
                      </tr>
                      <tr>
                        <td>Preferred Place of Interview :<span class="star">*</span></td>
                        <td colspan="2"><div class="col-md-6">
            
             <select name="inter_place"  class=" form-control" onBlur="return alphanumeric(this)" required>
                        <option value="">-Select-</option>
              <?php 
              $c_query="SELECT * FROM `preferred_master` where c_status=1";
              $c_res=mysql_query($c_query);
              while($data = mysql_fetch_array($c_res, MYSQL_ASSOC))
                      {
              @extract($data);
              ?>
              <option value="<?php echo $c_name;?>" <?php if ($inter_place==$c_name) echo 'selected="selected"';?>><?php echo $c_name;?></option>
              <?php
                      }
              
              ?>
              </select>
            <span id="inter_place" class="validation_error"></span>
            
            
            
                          <!--<input onBlur="return alphanumeric(this)"class="form-control" type="text" name="inter_place">-->
                        </div><span id="inter_place" class="validation_error"></span></td>
                      </tr>
                     
                      <tr>
                        <td>Place <span class="star">*</span></td>
                        <td colspan="2"><div class="col-md-6">
                          <input required onBlur="return alphanumeric(this)"class="form-control" type="text" name="place" value="<?php echo $place;?>" >
                        </div><span id="place" class="validation_error"></span></td>
                      </tr>
                      <tr>
                        <td>Date</td>
                        <td colspan="2"><div class="col-md-6">
                          <input class="form-control" type="text" name="i_date" value="<?php echo date('Y/m/d');?>" readonly>
                        </div></td>
                      </tr>
                      <tr>
                        <td>Signature<span class="star">*</span></td>
                        <td colspan="2"><div class="col-md-6"><input type="file" class="text-center  well well-sm" name="signature" required></div></td>
                      </tr>
                       <tr>
                   
                        <td  colspan=3 style="font-size:11px;"><input type="checkbox" onChange="declare(this)" id="conform_check"><span class="star">*</span>I solemnly declare that all the particulars furnished in this application are true and correct to the best of my knowledge and belief. I clearly understand that any misstatement of facts contained therein or wilful concealment of any material fact will render me liable to appropriate action as may be decided by the company.

                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><span id="confirm_cmd">To submit the Form Please check Declaration</span><input name="cmdsubmit" type="submit" class="btn btn-primary "  id="cmdsubmit" title="Submit" value="Submit" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                    </table>    
<script type="text/javascript">
function declare(a) {
  if(a.checked)
  {
    $("#cmdsubmit").show();
    $("#confirm_cmd").hide();
  }
  else{
   $("#cmdsubmit").hide();
    $("#confirm_cmd").show();
  }
}


</script>
<input type="hidden" name="age_block_msg1" id="age_block_msg1">
<input type="hidden" name="min_age_block_msg1" id="min_age_block_msg1">
<input type="hidden" name="per_block_msg1" id="per_block_msg1">
<input type="hidden" name="per_block_msg12" id="per_block_msg12">
<input type="hidden" name="w_12_10th_block_msg1" id="w_12_10th_block_msg1">
<input type="hidden" name="w_12_g_block_msg1" id="w_12_g_block_msg1">
<input type="hidden" name="w_pg_g_block_msg1" id="w_pg_g_block_msg1">
<input type="hidden" name="exp_date_block_msg1" id="exp_date_block_msg1">
<input type="hidden" name="exp_less_block_msg1" id="exp_less_block_msg1">


                  </form>
                </p>

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
function last_ex_ind(arg) {
  $("#last_idv_exp").val(arg.value);
    
}

 function percentage(a)
  {
    var id=a.id;
    var name_val=a.value;
    if(name_val<=100)
    {
var division=$("#div_"+id).val();
var max=0;min=0;
switch (division) {
    case 'First':
    max=100;
    min=60;
    break;

    case 'Second':
    max=59;
    min=45;
     break;

     case 'Third':
     max=44;
     min=30;
     break;
      }

if(name_val<=max && name_val>=min)
{

  if(id==3)
  {
var per_val= $("#graduation_min_percent").val();

if(name_val<per_val)
{
$('#'+id).notify("Your Graduation below than Required "+per_val,{position:"left",className: "error" });

  var msg="Your Graduation below than Required "+per_val;
  $("#per_block_msg1").val(msg);

}
else
{
  $("#per_block_msg1").val('');
}

}
  if(id==4)
  {
var per_val= $("#post_graduation_min_percent").val();

if(name_val<per_val)
{
$('#'+id).notify("Your Post Graduation Percentage below than Required "+per_val,{position:"left",className: "error" });

var msg="Your Post Graduation Percentage below than Required "+per_val;
  $("#per_block_msg12").val(msg);
}

else
{
  $("#per_block_msg12").val('');
}

  }

}
else
{
 $('#'+id).notify("Percentage Should match according to your Division ",{position:"left",className: "warn" });
}

 
}
    else
    {
       $('#'+id).notify("Percentage should not Blank and less than 100  ",{position:"left",className: "warn" });

    }


}

function or_year(b)
{
    var year_select_id=b.id;

    //var exam_name=$("#"+year_select_id).val();

   switch (year_select_id) {
    case 'year2':
    var exam_value=$("#"+year_select_id).val();
    var pre_exam_value=$("#year1").val();
    if(pre_exam_value=='')
    {
      $('#year1').notify("Please Select 10th Year)",{position:"top",className: "error" });
   
    }
if(exam_value<parseInt(pre_exam_value)+2)
     {
      $('#year2').notify("Please Enter correct year of 10th and 12th (10th should be minimum than 12th)",{position:"top",className: "error" });

       var msg="Please Enter correct year of 10th and 12th  ";
$("#w_12_10th_block_msg1").val(msg);
    
    }
    else
    {
      $("#w_12_10th_block_msg1").val('');
    }
   break;

    case 'year3':
    var exam_value=$("#"+year_select_id).val();
    var pre_exam_value=$("#year2").val();
    if(pre_exam_value=='')
    {
      $('#year2').notify("Please Select 12th Year)",{position:"top",className: "error" });
   
    }
if(exam_value<parseInt(pre_exam_value)+3)
     {
      $('#year3').notify("Please Enter correct year order of Graduation and  12th",{position:"top",className: "error" });
    var msg="Please Enter correct year order of Graduation and 12th  ";
$("#w_12_g_block_msg1").val(msg);
    }
    else
    {
      $("#w_12_g_block_msg1").val('');
    }
    break;


    case 'year4':
    var exam_value=$("#"+year_select_id).val();
    var pre_exam_value=$("#year3").val();
    if(pre_exam_value=='')
    {
      $('#year3').notify("Please Select Graduation Year)",{position:"top",className: "error" });

    }
if(exam_value<parseInt(pre_exam_value)+2)
     {
      $('#year4').notify("Please Enter correct year order of Post Graduation and  Graduation",{position:"top",className: "error" });
       var msg="Please Enter correct year order of Post Graduation and  Graduation";
$("#w_pg_g_block_msg1").val(msg);
    
    }
    else
    {
      $("#w_pg_g_block_msg1").val('');
    }
    break;

     }

 
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
 <script type="text/javascript">
 function less_year_exp(v)
 {
 	var rublock_id=v.id;
 	var ara=rublock_id.split("_");
 	var subling_id=parseInt(ara[1]);
 	var pre_to=subling_id-1;
 	//alert(subling_id+1);
  var d = new Date(v.value);
  //alert(d);
  var d2 = new Date($("#dto_"+pre_to).val());
  //alert(d2);
  var date_diff_from = Math.ceil((d-d2)/(365.25 * 24 * 60 * 60 * 1000));
  
var e_from = d.getFullYear();
gr_date_id=$("#after_date_exp").val() 
var else_year=parseInt($("#"+gr_date_id).val());
if(d!='Invalid Date')
{ //alert(date_diff_from);
  if (e_from<else_year) {

//$("#"+gr_date_id).notify("Experience should be start after This Degree",{position:"top",className: "error" });
    // $('#tab_logic1').notify("Experience should be start after Mantion Degree",{position:"top left",className: "warn" });

    //msg="Experience should be start after Mantion Degree";
     // block(msg);
   //$("#exp_date_block_msg1").val(msg);               
 }

else if(date_diff_from<=0 && rublock_id!=dfrom_1)
 {
   $("#dto_"+pre_to).notify("Experience should be start after Last Experience date",{position:"top left",className: "warn" });
    msg="Experience Start date and end date should be in order";
      //block(msg);
   $("#exp_date_block_msg1").val(msg); 
 }

 else
    {
    
      //allow();
       $("#exp_date_block_msg1").val(''); 
    }
}

 }
//function getAge(dob,as_on) 
function getAge(fromdate, todate)
                {
todate= new Date(todate);
     today= new Date();
     fromdate= new Date(fromdate);
    // alert(fromdate);
     min_age=fromdate.getFullYear()+12;
  if(min_age>today.getFullYear()) 
  {
    //$("#example1").notify("Your age should be Min. 12 Year",{position:"right",className: "error" });
   var msg="Your age should be Min. 12 Year";
    $("#min_age_block_msg1").val(msg);
  }
  else
  {
   $("#min_age_block_msg1").val('');

  }   
    var age= [],
    y= [todate.getFullYear(), fromdate.getFullYear()],
    ydiff= y[0]-y[1],
    m= [todate.getMonth(), fromdate.getMonth()],
    mdiff= m[0]-m[1],
    d= [todate.getDate(), fromdate.getDate()],
    ddiff= d[0]-d[1];
    if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
    if(mdiff<0) mdiff+= 12;
    if(ddiff<0){
        fromdate.setMonth(m[1]+1, 0);
        ddiff= fromdate.getDate()-d[1]+d[0];
        --mdiff;
    }
    if(ydiff> 0) age.push(ydiff+ ' year'+(ydiff> 1? 's ':' '));
    if(mdiff> 0) age.push(mdiff+ ' month'+(mdiff> 1? 's':''));
    if(ddiff> 0) age.push(ddiff+ ' day'+(ddiff> 1? 's':''));
    if(age.length>1) age.splice(age.length-1,0,' and ');    
    $('#age').val(age.join(''));
    var age_diff = Math.ceil((todate-fromdate)/(365.25 * 24 * 60 * 60 * 1000));
    // alert(age_diff);   
    // var age = age_diff.substring(1, 6);
    if(isNaN(age_diff) || age_diff<0){ 
     return false;
     }else{ 
     $('#hid_age').val(age_diff);
     }
    
}     
function getdate(d)
{
var id=d;
var pid=id.substring(9, 10);
var date1=$("#dfrom_"+pid).val();
var date2=$("#dto_"+pid).val();
experience(date1,date2,id);
}
function experience(fromdate,todate,id)
{
 todate= new Date(todate);
  

 var age= [], fromdate= new Date(fromdate),
    y= [todate.getFullYear(), fromdate.getFullYear()],
    ydiff= y[0]-y[1],
    m= [todate.getMonth(), fromdate.getMonth()],
    mdiff= m[0]-m[1],
    d= [todate.getDate(), fromdate.getDate()],
    ddiff= d[0]-d[1];

    if(mdiff < 0 || (mdiff=== 0 && ddiff<0))--ydiff;
    if(mdiff<0) mdiff+= 12;
    if(ddiff<0){
        fromdate.setMonth(m[1]+1, 0);
        ddiff= fromdate.getDate()-d[1]+d[0];
        --mdiff;
    }

//alert(ydiff + " years and " + mdiff+"month"+ ddiff+"days");
var total = ydiff + " years and " + mdiff+" month "+ ddiff+" days" ;
$("#"+id).val(total);


}

</script>
<script>
function total()
        {
          var y=0,m=0,d=0;
          $(".totalexp").each(function() {
 var date=$(this).val();
  var arr=date.split(" ");
 //alert(arr[0]+arr[3]+arr[5]);
//0 years and 0 month 14 days
// var year=parseInt(date.substring(0, 2));
// var month=parseInt(date.substring(12, 14));
// var date1=parseInt(date.substring(20, 22));
 var year=parseInt(arr[0]);
 var month=parseInt(arr[3]);
 var date1=parseInt(arr[5]);
y+=year;
m+=month;
d+=date1;
});
if(m>=12)
{

  y++;
  m=m-12;
}
if(d>=30)
{
  d=d-30
  m++;
  if(m>=12)
{

  y++;
  m=m-12;
}

}
$("#total_exp").val(y+" year and "+m+" month "+d+" day");
var exp_db= $("#post_exp").text();
if($("#total_exp").val()=='NaN year and NaN month NaN day')
{
  $("#total_exp").notify("Select Individual Experience",{position:"right",className: "error" });
   msg="Not eligible Experience less than Required";
      block(msg);
      $("#exp_less_block_msg1").val(msg);
}

else if(y<exp_db)
{
   $("#total_exp").notify("Your total experience minimum than "+" "+exp_db,{position:"right",className: "error" });
  msg="Not eligible Experience less than  Required"+" "+exp_db;
      block(msg);
       $("#exp_less_block_msg1").val(msg);
}
else
    {
      allow();
       $("#exp_less_block_msg1").val('');
    }
    
}




 function number_valid(evt,a)
  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 44 || charCode > 57))
    {
      $.notify("Please enter numbers only","error");

      return false;
    }
    else
    {
      return true;
    }
  }

function block(msg) {

           $("#confirm_cmd").text(msg);
           $("#confirm_cmd").show();
           $("#conform_check").hide();
           $("#cmdsubmit").hide();
//alert("helo")
 }

function allow()
{

$("#confirm_cmd").text("To submit the Form Please check Declaration");
$("#confirm_cmd").show();$("#cmdsubmit").hide();
$("#conform_check").show().prop('checked',false);

}


function last_allow() {
var error_string='';

if($("#age_block_msg1").val()!='')
{
error_string+=$("#age_block_msg1").val()+"  ";
}
if($("#min_age_block_msg1").val()!='')
{
error_string+=$("#min_age_block_msg1").val()+"  ";
}
if($("#per_block_msg1").val()!='')
{
error_string+=$("#per_block_msg1").val()+"  ";
}
if($("#per_block_msg12").val()!='')
{
error_string+=$("#per_block_msg12").val()+"  ";
}
if($("#w_12_10th_block_msg1").val()!='')
{
error_string+=$("#w_12_10th_block_msg1").val()+"  ";
}
if($("#w_12_g_block_msg1").val()!='')
{
error_string+=$("#w_12_g_block_msg1").val()+"  ";
}
if($("#w_pg_g_block_msg1").val()!='')
{
error_string+=$("#w_pg_g_block_msg1").val()+"  ";
}
if($("#exp_date_block_msg1").val()!='')
{
error_string+=$("#exp_date_block_msg1").val()+"  ";
}
if($("#exp_less_block_msg1").val()!='')
{
error_string+=$("#exp_less_block_msg1").val()+"  ";
}
if(error_string.trim()=='')
{
return confirm('Do you really want to submit the form?');
}
else
{
  alert(error_string);
  return false;
}
 
}

</script>

</script>
<script type="text/javascript">
$(".closestatus").click(function() {
$("#msgerror").addClass("hide").hide();
});
$(".closestatus").click(function() {
$("#msgclose").addClass("hide").hide();
});

</script>
          </body>
          </html>
