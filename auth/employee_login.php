<?php
    ob_start();
    session_start();
    error_reporting(0);

        require_once "../includes/connection.php";
        require_once("../includes/frontconfig.inc.php");
        require_once "../includes/functions.inc.php";
      //  require_once "../securimage/securimage.php";
        include("../includes/def_constant.inc.php");
        include('../design.php');
        include("../includes/useAVclass.php");

    $useAVclass = new useAVclass();
    $useAVclass->connection();
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
		<title>Employee Login</title>
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
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"></script>
	    <script type="text/javascript" language="javascript"></script>
		
<style>
/* Main CSS Here */
:root {
--one-use-color: #3f0097;
--two-use-color: #5500cb;
}

.main-container {
display: flex;
width: 100vw;
position: relative;
top: 70px;
z-index: 1;
}



.main::-webkit-scrollbar-thumb {
background-image:
		linear-gradient(to bottom, rgb(0, 0, 85), rgb(0, 0, 50));
}
.main::-webkit-scrollbar {
width: 5px;
}
.main::-webkit-scrollbar-track {
background-color: #9e9e9eb2;
}

.box-container {
display: flex;
justify-content: space-evenly;
float: left;
flex-wrap: wrap;
gap: 50px;
}


.box {
height: 130px;
width: 230px;
border-radius: 20px;
box-shadow: 3px 3px 10px rgba(0, 30, 87, 0.751);
padding: 20px;
display: flex;
align-items: center;
justify-content: space-around;
cursor: pointer;
transition: transform 0.3s ease-in-out;
}
.box:hover {
transform: scale(1.08);
}

.box:nth-child(1) {
background-color: var(--two-use-color);
}
.box:nth-child(2) {
background-color: var(--two-use-color);
}
.box:nth-child(3) {
background-color: var(--two-use-color);
}
.box:nth-child(4) {
background-color: var(--two-use-color);
}

.box img {
height: 50px;
}
.box .text {
color: white;
}
.topic-heading {
font-size: 17px;
font-family: verdana;
}

</style>

		
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
    						<li><a href="<?php echo $HomeURL?>auth/index.php">Home</a></li>
                            <li></li> 
    						<li>Employee Login Details</li>
							<li class="pull-right"><button class="bt90" title="Go Back" onclick="window.history.go(-1)"><strong>Back</strong></button> / <a href="javascript:void(0);" title="Print" onclick="javascript:window.print();"><span class="glyphicon glyphicon-print"></span></a> </li>
    					</ul>
					<!--	<div class="main">
							<div class="box-container">
								<div class="box box1">
									<div class="text">
										<h2 class="topic-heading">Employees Login Status</h2>
									</div>
								</div>
								<div class="box box2">
									<div class="text">
										<h2 class="topic-heading">Official Forms</h2>
									</div>
								</div>
								<div class="box box3">
									<div class="text">
										<h2 class="topic-heading">Employee Pay Slip</h2>
									</div>
								</div>
							</div>
						</div>-->
                      <div class="employee_login  inner_right_container" style="width:65%;">
							 <h1><a href="<?php echo $HomeURL;?>/auth/employee_status.php" style="color:white;">Employees Login Status</a></h1>
                            <h1><a href="<?php echo $HomeURL;?>/content/innerpage/official-form.php" style="color:white;">Official Forms</a></h1>
							<?php if($_SESSION['login_name']==$_SESSION['login_name']){ ?>
                            <h1><a href="https://rdsoft.in/nwda/" style="color:white;"  target="_blank">View Pay Slip</a>    (Only for HeaderQuarter Employees)</h1>
							<?php } ?>
                           <?php /*  <h1><a href="<?php echo $HomeURL;?>/content/circulars.php" style="color:white;">Official Circular Classified</a></h1>-->
                         <h1><a href="<?php echo $HomeURL;?>/content/seniority-list.php" style="color:white;">Seniority List</a></h1>
							<h1><a href="<?php echo $HomeURL;?>/content/innerpage/recruitment-rules.php" style="color:white;">Recruitment Rules</a></h1>
                            <h1><a href="<?php echo $HomeURL;?>/auth/discussion_forum.php" style="color:white;">Discussion Forum</a></h1> */ ?>
    				    </div> 
                    </div>
                </div> 
             </div> 
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
<script>
    function goBack(){
    window.history.back();
}
</script>
<!-- <script type="text/javascript">

var e = document.getElementById('parent');
e.onmouseover = function() {
  document.getElementById('popup').style.display = 'block';
}
e.onmouseout = function() {
  document.getElementById('popup').style.display = 'none';
}
</script> -->
</body>	
</html>
