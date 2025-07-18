<?php
ob_start();
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
include('../design.php');
include("../counter.php");


?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<title>National Water Development Agency</title>
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
		
		
			     <link rel="stylesheet" type="text/css"  href="<?php echo $HomeURL;?>/jquery-ui/jquery-ui.min.css" media="all">
    <script type="text/javascript" src="<?php echo $HomeURL;?>/jquery-ui/jquery-ui.js"></script>
	 
	
		
<script>
  $(function() {
	$( "#startdate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate:0,
	  dateFormat: "dd-mm-yy"
	});
});

$(function() {
	$( "#expairydate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate:0,
	  dateFormat: "dd-mm-yy"
	});
});
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
							<li>Employee Portal</li>
						</ul>
					</div>
					
					
						<h2>Employee Portal</h2>
									
								<div class="col-sm-12">

<div class="welcome-page">
       <span><h3>Welcome  to <?php echo $_SESSION['login_user'];?></h3></span> 
</div>

<div class="inner_right_container">    
	<a href='<?php echo $HomeURL;?>/auth/logout.php?random=<?php echo $_SESSION['logtoken']; ?>' title="Logout" class="logout"><b>Logout</b></a>
 
</div>

<?php
    
  
        $query="SELECT * from module_master where  `status`=1";
         $res=mysql_query($query) or die(mysql_error());

        while($row=mysql_fetch_array($res)) 
        {

?>
             <li class="list-group-item"><a href="total_detail.php?id=<?php echo $row['c_id'] ;?>"><?php echo $row['c_name'] ;?></a></li>
        
            <?php


        }

?>

</div>
					</div>
				</div>
				</div>
			
		
		
		</section>
	<footer>
			<?php include("../content/footer.php");?>
		</footer>
	

	</body>
	
</html>
