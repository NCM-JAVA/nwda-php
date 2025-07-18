<?php ob_start();  
session_start();  
require_once "../includes/connection.php";  
require_once("../includes/frontconfig.inc.php");  
require_once "../includes/functions.inc.php"; 
include("../includes/def_constant.inc.php");  
include("../includes/useAVclass.php"); 
$useAVclass = new useAVclass();
$useAVclass->connection(); 
if($_SESSION['admin_auto'] == ''){ $_SESSION['IsAuthorized'] = false; $msg = "Login to Access Employee Corner";  		$_SESSION['sess_msg'] = $msg; header("Location:index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Employee status Details</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
</head>	
	<body>
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
						<ul class="breadcrumb" style="margin-top:6px;">
							<li><a href="<?php echo $HomeURL?>/auth/index.php">Home</a></li>
                            <li></li> 
							<li>Employee Login Status</li>
						</ul>
					</div>

                    <div class="inner_right_container">
                    	<div class="inner_right_container" style="width:129.5%; float: left; background: url(../images/Back-nav.jpg) repeat-x; border: 1px solid #686868; text-align: center; background-color:#17539a; color:white;">
                            <span><h3>Welcome&nbsp;<?php echo $_SESSION['login_user'];?><button style="background:#0b6ba5; margin-left:90%; margin-top:-21px;" onclick="goBack()">Back</button></h3>
							</span>
                        </div><br> 
						
                    	<?php if ($_SESSION['edit_prof'] != '') { ?>
                    	    <div  id="msgclose" class="status success">
                    	        <div class="closestatus" style="float: none;">
                    	            <p><span>Attention! </span><?php echo $_SESSION['edit_prof'];
                    	                $_SESSION['edit_prof'] = "";?>
                    	            </p>
                    	        </div>
                    	    </div>
                    	<?php } ?>
  
            			    <table width="135%" id="datatable"  class="display">
								<thead>
									<tr>
										<th style="text-align:left;">S. No.</th>
										<th style="text-align:left;">User name</th>
										<th style="text-align:left;">Login name</th>
										<th style="text-align:left;">Email</th>
										<th style="text-align:left;">Phone</th>
										<th style="text-align:left;">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$sqlq="select * from signup where user_status=1"; 
										$i=0;
										$sqlsub1 = $conn->query($sqlq);
										while($data=$sqlsub1->fetch_assoc()){
	
										$i++;	
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $data['user_name']?></td>
										<td><?php echo $data['login_name']?></td>
										<td><?php echo $data['user_email']?></td>
										<td><?php echo $data['user_phone']?></td>
										<?php if( $_SESSION['login_user']!=$data['user_email']){ ?>
												<td style="color:white;"><b>Inactive </b> </td>
											<?php } else{ ?>	
												<td style="color:white;"><b>Active <i class="fa fa-check"></i></b> </td>
											<?php }?>
									</tr>
										<?php } ?>
									
								</tbody>
							</table>
			<br>
							<div id="myModal" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
									    <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title"></h4>
										</div>
										<div class="modal-body">
											<h3 style="text-align:center;">Sorry ! You can view your payslip Only.</h3>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
            		  
           			</div>
           		</div> 
            </div>
        </div>
	</section>
<footer>
	<?php include("../content/footer.php");?>
</footer>
	<script>
		$(document).ready(function() {
		$('#datatable').DataTable({
			bFilter: false, 
			lengthChange: false
			
		});
		} );
	</script>	
	<script src="https://yogacertificationboard.nic.in/mis/assets/js/datatable/jszip.min.js"></script>
	<script src="https://yogacertificationboard.nic.in/mis/assets/js/datatable/pdfmake.min.js"></script>
	<script src="https://yogacertificationboard.nic.in/mis/assets/js/datatable/buttons.print.min.js"></script>
	
	<script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net/js/jquery.dataTables.min.js"> </script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="https://yogacertificationboard.nic.in/mis/assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
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
<script type="text/javascript"> 
        $(document).ready(function () { 
            $("#refresh").click(function () { 
                location.reload(true); 
            }); 
        }); 
</script>
</body>	
</html>
