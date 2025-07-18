<?php
ob_start();
session_start();
error_reporting(0);
 require_once "../includes/connection.php";
 require_once("../includes/frontconfig.inc.php");
 require_once "../includes/functions.inc.php";
 // require_once "../securimage/securimage.php";
 // include("../includes/def_constant.inc.php");
// include('../design.php');
// include("../includes/useAVclass.php");
// $useAVclass = new useAVclass();
// $useAVclass->connection();

$_GET['view'] = trim($_GET['view']);
$getview = $_GET['view'];
$_GET['view'] = $_GET['view'];

if($getview != $_GET['view'])
{
	header("Location:".$HomeURL."/content/error.php");
	exit();
}
@extract($_POST);
$_SESSION['salt'] == "";
$_SESSION['saltCookie'] == "";
$m_name = "Disability Encyclopedia"; 
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
	
		
		<script src="<?php echo $HomeURL?>/js/jquery.min.js"></script>
		<script src="<?php echo $HomeURL?>/js/font-size.js"></script> 
		<script src="<?php echo $HomeURL?>/js/bootstrap.min.js"></script> 
		<script src="<?php echo $HomeURL?>/js/jquery.easy-ticker.js"></script> 
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"> </script>

<script type="text/javascript" language="javascript">
    function getPass()
    {
		
	
		var salt ="<?php echo $_SESSION['salt']; ?>"; 
		var salt1 ="<?php echo $_SESSION['salt1']; ?>"; 
		var salt2 ="<?php echo $_SESSION['salt2']; ?>"; 
		var exp=/((?=.*\d)(?=.*[a-z])(?=.*[@#$%]).{6,10})/;
       
		var txtpwd = document.getElementById('<?php echo "txtpwd"; ?>').value;
		var txtnpwd = document.getElementById('<?php echo "txtnpwd"; ?>').value;
		var txtcpwd = document.getElementById('<?php echo "txtcpwd"; ?>').value;
     
	  
		if (txtpwd=='')
        {
          /*  alert('Please Enter old password');
            return false;*/
        }
		else if (txtnpwd=='') 
        {
            /*alert('Please enter new password');
            return false;*/
        }

		else if (txtcpwd=='') 
        {
           /* alert('Please re-enter new password');
            return false;*/
        }
	
	
		 else
        {  
		
		if (txtnpwd.search(exp)==-1) 
            {
				alert('Password must 8 characters long, contain at least 1 number, at least 1 lower case letter, at least 1 upper case letter.');
					 return false;

            }
			if (txtcpwd.search(exp)==-1) 
            {
					 alert('Password must 8 character long, include at least one special character.');
					 return false;

            }

            if ((txtpwd!='') && (txtnpwd!='') & (txtcpwd!='') )
            {
         
				var hash=hex_sha512(txtpwd);
				var hash1=hex_sha512(txtnpwd);
				var hash2=hex_sha512(txtcpwd);
				
                 document.getElementById('<?php echo "txtpwd"; ?>').value=hash;
				document.getElementById('<?php echo "txtnpwd"; ?>').value=hash1;
				document.getElementById('<?php echo "txtcpwd"; ?>').value=hash2;
				
            }


        }
    }
</script>

<style>
#register-form label.errors{
    color: #FB3A3A;
    display: inline-block;
    margin: 0px;;
    padding: 0px;
    text-align: left;
    width: 220px;
}
	#msgerror label{
	color: #FB3A3A;
	display: inline-block;
	margin: 0px;;
	padding: 0px;
	text-align: left;
	}
	
#ul_top_hypers li {
	display: inline;
	border: 1px solid #f7b24b;
	padding: 2px 5px;
	margin-top: 10px;
}

	   
</style>

<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
				 txtpwd:{
						required: true
								},
						txtnpwd: {
						required: true,
						minlength: 8
						},
						txtcpwd: {
						required: true,
						minlength: 8,
						equalTo: "#txtnpwd"
						}
					
                },
                messages: {
                    txtpwd: { required:"Please Enter Old Passweord"
					},
					txtnpwd: {
				required: "Please  Enter New Password",
				minlength: "Your Password must be 8 characters long, contains one digit, a lower case letter , one upper case letter and a special character.Example:Super@123"
			},
			txtcpwd: {
				required: "Please Enter Confirm Password",
				minlength: "Your Password must be 8 characters long, contains one digit, a lower case letter , one upper case letter and a special character.Example:Super@123",
				equalTo: "Please enter the same password as above"
			}
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
						
							<?php include("../content/leftmenu.php");?>
						
					</div>
					<div class="col-sm-9 main-content inner">
					<div class="">
						<ul class="breadcrumb">
							<li><a href="<?php echo $HomeURL?>/content/index.php">Home</a></li>
							<li>Glossary</li>
						</ul>
					</div>
            
        <div class="inner_right_container">
      <h1>Glossary</h1>
 <div class="filter-alphabet">
	  <?php
	   foreach($alppha as $letter){?>
	  <a href="disability.php?view=<?php echo $letter;?>" title="<?php echo $letter;?>"><?php echo $letter;?></a>&nbsp;
	  <?php }?>
	  <a href="disability.php?view=<?php echo 'ALL';?>" title="<?php echo 'ALL';?>"><?php echo 'ALL';?></a>
 </div>
 
 <div class="filter-item">
	<p class="filter-one"><?php if($_GET['view']=='ALL' || $_GET['view']=='') { foreach($alppha as $letter){?>
	<?php if(in_array($_GET['view'],$alppha)){ echo $letter; }?></p>
		<ul id="ul_top_hypers">
		<?php  $query = "SELECT * FROM encyclopedia_threadlist where t_status='1' and Title LIKE '$letter%' ORDER BY Title ASC";
	$result1 = $conn->query($query);
	if($result1->num_rows > 0) {
	while($line = $result1->fetch_array()){?>
		<li><a title="<?php echo $line[1];?>" href="<?php echo $HomeURL;?>/auth/disability_encyclopedia.php?cmd=show&amp;thread=<?php echo $line[0];?>&amp;posts=<?php echo $line[5];?>"><?php echo $line[1];?></a></li>
		<?php } }?>
		</ul>        
               
		 <p class="filter-one"> <?php } } else { ?>
		  <?php if(in_array($_GET['view'],$alppha)){ echo $letters =$_GET['view']; }?></p>
		<ul id="ul_top_hypers">
		<?php  $query = "SELECT * FROM encyclopedia_threadlist where t_status='1' and Title LIKE '$letters%' ORDER BY Title ASC";
	$result2 = $conn->query($query);
	if ($result2->num_rows > 0) {
	while($line = $result2->fetch_array()){?>
		<li><a title="<?php echo $line[1];?>" href="<?php echo $HomeURL;?>/auth/disability_encyclopedia.php?cmd=show&amp;thread=<?php echo $line[0];?>&amp;posts=<?php echo $line[5];?>"><?php echo $line[1];?></a></li>
		<?php } }else{?>
		<li>No Record Found</li>	
		<?php }?>
		</ul>
		<?php }?>
	


</div>
    </div>
   </section>

      </div>
    </div> 
		</section>
	<footer>
			<?php include("../content/footer.php");?>
		</footer>
	
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
