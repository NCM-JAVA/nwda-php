<?php
	ob_start();
	session_start();
	error_reporting(0);

		require_once "../includes/connection.php";
		require_once("../includes/frontconfig.inc.php");
		require_once "../includes/functions.inc.php";
		require_once "../securimage/securimage.php";
		include("../includes/def_constant.inc.php");
		include('../design.php');
		include("../includes/useAVclass.php");

	$useAVclass = new useAVclass();
	$useAVclass->connection();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Official Form Details</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		<script src="<?php echo $HomeURL?>/js/modern-ticker.js" type="text/javascript"></script>
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
							<li>Employee Login Official Forms Details</li>
						</ul>
					</div>

                    <div class="inner_right_container">
                    	<div class="inner_right_container" style="width:100%; float: left; background: url(../images/Back-nav.jpg) repeat-x; border: 1px solid #686868; text-align: center; background-color:#17539a; color:white;">
                            <span><h3>Welcome&nbsp;<?php echo $_SESSION['login_user'];?><button style="background:#0b6ba5; margin-left:90%; margin-top:-21;" onclick="goBack()">Back</button></h3></span> 
                        </div>                               

                    	<?php 
	                    	//include('menu.php');
                        	$edit="select user_name,user_email,user_phone,address from signup where id='$admin_auto'";
                        	$result = mysql_query($edit);
                        	$res_rows=mysql_num_rows($result);
                        	$fetch_result=mysql_fetch_array($result);
                        	@extract($fetch_result);
                    	?>

                    	<?php if ($_SESSION['edit_prof'] != '') { ?>
                    	    <div  id="msgclose" class="status success">
                    	        <div class="closestatus" style="float: none;">
                    	            <p><span>Attention! </span><?php echo $_SESSION['edit_prof'];
                    	                $_SESSION['edit_prof'] = "";?>
                    	            </p>
                    	        </div>
                    	    </div>
                    	<?php } ?>

                    	<?php 
         					$sqlq="select * from menu_publish where m_flag_id='0' and m_id='295' and menu_positions='3' and language_id='1' and approve_status='4' ORDER BY page_postion ASC";
         
        					$sqlsub1 = mysql_query($sqlq);
        

                			while($data=mysql_fetch_assoc($sqlsub1)){
                    		//echo '<pre>'; print_r($data);                   
            			?>
            			<div style="width:100%;">    
            			    <table>
            			        <thead>
            			            <tr>
            			                <th colspan="3" style="background-color:#0074bc;">Official Forms</th>
            			            </tr>
            			        </thead>
            			        <tbody>
            			            <tr>
            			                <td><?php echo html_entity_decode($data['content']); ?></td>
            			            </tr>
            			           
            			        </tbody>
            			    </table><br>
            			</div>    
            			<?php }?>
           			</div>
           		</div> 
            </div>
        </div>
	</section>

<footer>
	<?php include("../content/footer.php");?>
</footer>

<script>
    function goBack(){
    window.history.back();
}
</script>
</body>	
</html>
