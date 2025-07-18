<?php
   ob_start();
   session_start();
   error_reporting(0);
   
   require_once "../includes/connection.php";
   require_once("../includes/frontconfig.inc.php");
   require_once "../includes/functions.inc.php";
   //   require_once "../securimage/securimage.php";
   include("../includes/def_constant.inc.php");
   // include('../design.php');
   include("../includes/useAVclass.php");
   
   $useAVclass = new useAVclass();
   $useAVclass->connection();
   
   @extract($_POST);
   $_SESSION['salt'] == "";
   $_SESSION['saltCookie'] == "";
   $admin_auto = $_SESSION['admin_auto'];
   
   
	if($_SESSION['admin_auto'] == ''){
		$_SESSION['IsAuthorized'] = false;
		$msg = "Login to Access Employee Corner";
		$_SESSION['sess_msg'] = $msg;
		header("Location:index.php");
	exit;
	}
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>NWDA</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="<?php echo $HomeURL?>/css/style.css" rel="stylesheet">
      <link href="<?php echo $HomeURL?>/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo $HomeURL?>/css/responsive.css" rel="stylesheet">
      <link href="<?php echo $HomeURL?>/css/print.css" rel="stylesheet" media="print">
	  <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/change.css" media="screen" title="change" />
      <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/green.css" media="screen" title="green" />
      <link rel="alternate stylesheet" href="<?php echo $HomeURL?>/css/orange.css" media="screen" title="orange" />
      <script src="<?php echo $HomeURL?>/js/styleswitcher.js" ></script>  
      <script src="<?php echo $HomeURL?>/js/superfish.js"></script>
      <script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
      <script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
      <script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
      <script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
      <script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>
	  
      <script type="text/javascript" language="javascript">
         function getPass()
         {
         
         var salt ="<?php echo $_SESSION['salt']; ?>"; 
         
         var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
            
         var value = document.getElementById('<?php echo 'txtpassword'; ?>').value;
         if (value=='')
             {
                /* alert('Enter username and password');
                 return false;*/
             }
             else
             {
                 if (value.search(exp)==-1) 
                 {
                   
                   //  return false;
                 }
                 if (value!='')
                 {
                     var hash=hex_sha512(hex_sha512(value)+salt);
                     document.getElementById('<?php echo 'txtpassword'; ?>').value=hash;
         
                 }
         
         
             }
         }
         
         
         
      </script>
      <script type="text/javascript">
         $(document).ready(function () {
         $('#txtusername').keypress(function(event){
         $('#msg-txtuser').html('Valid user Name')
         });
         $('#txtpassword').keypress(function(event){
         $('#msg-txtpass').html('Valid Password')
         });
          $('#code').keypress(function(event){
         $('#msg-txtcode').html('Valid Captcha code')
         });
         });
         	
      </script>
      <style>
         #register-form label.errors{
         color: #FB3A3A;
         display: inline-block;
         margin: 0px;;
         padding: 0px;
         text-align:right;
         }
      </style>
      <script>
         function ClearFields() {
              document.getElementById("code").value = "";
         
         }
      </script>
   </head>
   <body id="fontSize">
      <header>
         <?php include("../content/top_bar.php");?>
      </header>
      <div class="mobile-nav">
         <img src="images/toogle.png" alt="toogle" title="toogle">
      </div>
      <nav>
         <div class="container">
            <?php include("../content/header.php");?>
         </div>
      </nav>
      <section>
         <div class="container">
         <div class="row">
         <div class="col-sm-3 left-navigation">
            <?php include("user_menu.php");?>
         </div>
         <div class="col-sm-9 main-content inner">
            <div class="">
               <ul class="breadcrumb">
                  <li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a></li>
                  <li></li>
                  <li>Profile</li>
               </ul>
            </div>
			   <?php if ($_SESSION['edit_prof'] != '') { ?>
				<div  class="alert alert-success">
				   <div class="closestatus" style="float: none;">
					  <p><span>Attention! </span><?php echo $_SESSION['edit_prof'];
						 $_SESSION['edit_prof'] = "";?>
					  </p>
				   </div>
				</div>
            <?php } ?>

			
			
            <div class="employee_login" style="">
               <a href="<?php echo $HomeURL?>/auth/employee_login.php" style="color: white; padding: 10px 10px 10px 10px; border: 1px solid #7e57c2; border-radius: 26px;    background-image: linear-gradient(to bottom, #41bc76 0%, #41bc76 100%);">Employee Dashboard</a>
            </div>
            <?php 
               $edit="select user_name,user_email,user_phone,address from signup where id='$admin_auto'";
               $result = $conn->query($edit);
               $res_rows=$result->num_rows;
               $fetch_result=$result->fetch_array();
               @extract($fetch_result);
               
               ?>
         
            <section id="login-right" class="profiles" style="margin-top:2%;">
               <table>
                  <thead>
                     <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td><?php echo $user_name;?></td>
                        <td><?php echo $user_email;?></td>
                        <td><?php echo $user_phone;?></td>
                        <td><?php echo $address;?></td>
                     </tr>
                  </tbody>
               </table>
            </section>
         </div>
      </section>
      <footer>
         <?php include("../content/footer.php");?>
      </footer>
	   <script type="text/javascript">
         // initialise plugins
         if(getCookie("mysheet") == "change" ) {
         setStylesheet("change") ;
         }else if(getCookie("mysheet") == "style" ) {
         setStylesheet("style") ;
         }else if(getCookie("mysheet") == "green" ) {
         setStylesheet("green") ;
         } else if(getCookie("mysheet") == "orange" ) {
         setStylesheet("orange") ;
         }else   {
         setStylesheet("") ;
         }
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