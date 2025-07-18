<?php 
	ob_start();
	include("../../includes/config.inc.php");
	require_once "../../includes/connection.php";
	include("../../includes/useAVclass.php");
	include("../../includes/def_constant.inc.php");
	include("../../includes/functions.inc.php");
	require_once("../../includes/ps_pagination.php");
	@extract($_GET);
	@extract($_POST);
	@extract($_SESSION);
	$useAVclass = new useAVclass();
	$useAVclass->connection();
	$role_id=$_SESSION['dbrole_id'];
	$user_id=$_SESSION['admin_auto_id_sess'];
	$model_id='4';
   
	if($_SESSION['admin_auto_id_sess']==''){		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
	if($_SESSION['saltCookie']!=$_COOKIE['Temp']){
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
	}
	if($_SESSION['lname'] ==""){
		$_SESSION['lname']='English';
	}
	if($_SESSION['lname']=='English'){
		$language='1';
	}else if($_SESSION['lname']=='Hindi'){
		$language='2';
	}
   
	if($deleteid !=''){
		if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($deleteid)))){
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
		}else{
			$_COOKIE['Temp']="";
			$_SESSION['saltCookie']="";
			$_SESSION['Temptest']="";
			$saltCookie =uniqid(rand(59999, 199999));
			$_SESSION['saltCookie'] =$saltCookie;
			$_SESSION['Temptest']=$_SESSION['saltCookie'];
			setcookie("Temp",$_SESSION['saltCookie']);
			$_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
		}
		$check_status=check_delete($role_id,$txtstatus,$model_id);
		if($check_status >0){
			$sql	 				= "Delete From feedback_form where id='$deleteid'";
			$res	 				= mysql_query($sql);
			$page_id 				= mysql_insert_id();
			$SQL1 	 				= "SELECT * FROM audit_trail where page_id='$deleteid'";
			$Query 	 				= mysql_query($SQL1);
			$pagename  				= mysql_result($Query,0,'page_name');
			$txtlanguage  			= mysql_result($Query,0,'lang');
			$txtstatus  			= mysql_result($Query,0,'approve_status');
			$gallery_categoryname  	= mysql_result($Query,0,'page_title');
			$user_id				= $_SESSION['admin_auto_id_sess'];			
			$page_id				= mysql_insert_id();
			$action					= "Delete";
			$categoryid				= '1'; //mol_content
			$date					= date("Y-m-d h:i:s");
			$ip						= $_SERVER['REMOTE_ADDR'];
			$model_id				= '4';
	   
			$tableName				=	"audit_trail";
			$tableFieldsName_send	= array("user_login_id","page_id","page_name","page_action","page_category","page_action_date","ip_address","lang","page_title","approve_status");
			$tableFieldsValues_send = array("$user_id","$deleteid","$pagename","$action","$model_id","$date","$ip","$txtlanguage","$gallery_categoryname","$txtstatus");
			$useAVclass->insertQuery($tableName,$tableFieldsName_send,$tableFieldsValues_send);
	   
			if($res){	
				header("location:delete.php?status=deletefeedback");
			}
		}else{
			$msg = "Login to Access Admin Panel";
			$_SESSION['sess_msg'] = $msg ;
			header("Location:error.php");
			exit();
		}	
	}
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<title>Manage Feedback : <?php echo $sitename; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="style/admin.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jsDatePick.js"></script>
		<link href="style/jsDatePick.css" rel="stylesheet" type="text/css" />

		<script type = "text/javascript" >
			function burstCache(){
				if (!navigator.onLine) {
					document.body.innerHTML = 'Loading...';
					window.location = 'index.php';
				}
			}
		</script>
		<script>
			var a=navigator.onLine;
			if(a){}else{
				alert('ofline');
				window.location='index.php';
			} 
		</script>
		<script type="">
			var delete_id = '';
			var searchUrl = '?';
			var search_q = '';
			function doSearch(){
				var searchParam = '';
				var btneng = $.trim($('#btneng').val());
				var startdate = $.trim($('#startdate').val());
				var expairydate = $.trim($('#expairydate').val());
				console.log(btneng);
				if(btneng !=''){
					searchParam += '&btneng='+btneng;
				}
				if(startdate != ''){
					searchParam += '&startdate='+startdate;
				}
				if(expairydate != ''){
					searchParam += '&expairydate='+expairydate;
				}
				console.log( searchUrl+searchParam);
				window.location = searchUrl+searchParam;
			}
		</script>
		<style>
			.hide {display:none;}
			table {
				font-family: verdana;
				border-collapse: collapse;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<?php include('top_header.php'); ?>
		<div id="container">
			<?php include_once('main_menu.php'); ?>
			<div class="main_con">
				<div id="validterror" style="color:#F00" align="center"></div>
				<div class="right_col1">
					<div class="clear"></div>
					<?php if($_SESSION['content']!=""){?>
						<div  id="msgclose" class="status success">
							<div class="closestatus" style="float: none;">
								<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
								<p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['content'];
								$_SESSION['content']=""; ?>.</p>
							</div>
						</div>
					<?php } if($_SESSION['errors']!=""){ ?> 
						<div  id="msgerror" class="status error">
							<div class="closestatus" style="float: none;">
								<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
								<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $_SESSION['errors']; $_SESSION['errors']="";?></p>
							</div>
						</div>
					<?php } 
					$querywhere ='';
					if($btnsubmit=="Search"){
						if($btneng!=''){
							$datef ='';
							if($_POST['startdate']!='' && $_POST['expairydate']!=''){
								$fromdate_old=$_POST['startdate'];
								$fromdate_new = date('Y-m-d', strtotime($startdate));
								$todate_old=$_POST['expairydate'];
								$todate_new = date('Y-m-d', strtotime($expairydate));
								$datef .=" AND create_date BETWEEN '$fromdate_new' AND '$todate_new'";
							}
							unset($_SESSION['lname']); 
							$_SESSION['lname']=$btneng;
							if($_SESSION['lname']=='English'){ 
								$language='1';
							}else{ 
								$language='2';
							}
						}
						if($errmsg==''){
							$query ="select id,name,email,phone,review_comment,review_date,create_date from feedback_form  where review_comment IS NULL $querywhere $datef ORDER BY id DESC";
						}
					}else{
						$query ="select id,name,email,phone,review_comment,review_date,create_date from feedback_form  where review_comment IS NULL $querywhere $datef ORDER BY id DESC";
					}
					$result = $conn->query($query);
                  ?> 
					<div class="internalpage_heading">
						<h3 class="manageuser">Manage Feedback</h3>
						<div class="right-section">
							<ul>
								<?php if($_SESSION['admin_auto_id_sess']=='101'){ ?>
									<li><a href="archive_feedback.php" title="Replied Feedback"><span class="icon-28-new"></span>Replied Feedback</a></li>
									<li id="editer" class="edit-icon"> <a href="#" onclick="checkEmpty($(this).attr('href'));" id="edit" title="Reply"><span class="icon-28-edit"></span>Reply</a></li>
									<li class="divider"> </li>
								<?php }?>
							</ul>
						</div>
					</div>
					<script type="">
						function checkEmpty(href) {
							if(href=='#'){
								alert('Please select record which you want to reply');
								return false;
							}else {
								return true;
							}
						}
					</script>
					<div class="tab-container" id="outer-container"  style="padding:5px 5px -12px  0px">
						<div class="grid_view">
							<div class="new-gried">
								<form id="manage_feedback" name="manage_feedback" method="post" action="">
									<div class="filter-select fltrt">
										<label>Date from</label>
										<input type="text" name="startdate"  class="datepicker" readonly="readonly" id="startdate" value="<?php echo $startdate;?>"/>
										<label>Date To</label> 
										<input  type="text" class="datepicker" name="expairydate" id="expairydate" readonly="readonly"   value="<?php echo $expairydate;?>"/>
										<select class="inputbox" name="btneng" id="btneng">
											<option value="English"<?php if($btneng=='English') echo 'selected=selected'?>>English</option>
											<option value="Hindi"<?php if($btneng=='Hindi') echo 'selected=selected'?>>Hindi</option>
										</select>
										<input type="submit" name="btnsubmit" onclick="doSearch();" value="Search" class="button_m"/>		
									</div>
									<div class="clear"></div>
								</form>
							</div>
							<table width="100%" border="1" cellspacing="2" cellpadding="2" summary="" >
								<thead>
								   <tr>
									  <th width="1%"></th>
									  <th width="10%">Name</th>
									  <th width="9%">Email</th>
									  <th width="7%">Phone</th>
									  <th width="7%">Submission Date <br><i style="font-size: 10px;">(dd-mm-yyyy)</i></th>
									  <th width="0.5%">Options</th>
								   </tr>
								</thead>
								<tbody style="text-align: left;">
									<?php	
										if($btneng !=''){
											$string_url = "btneng=".$btneng;
										}
										if($startdate !=''){
											$string_url .= "&startdate=".$startdate;
										}
										if($expairydate !=''){
											$string_url .= "&expairydate=".$expairydate;
										}

										$pagn=$_GET['page'];
										if($pagn!=''){
											$pagnn="&page=".$pagn;
										}

										$pager = new PS_Pagination($link, $result,$string_url);
										$rs = $pager->paginate();
										$result->num_rows;
										if($result->num_rows > 0){
											while($data = $result->fetch_array()){ 
											@extract($data);
											if($class=="odd"){
												$class="even";
											}else{
												$class="odd";
											}
									?>
									<tr class="<?php echo $class;?>">
									  <td><input type="radio"  name="radio1" id="<?php echo $id; ?>"  value="<?php echo $id; ?>" onclick="getUrl(this.id)" /></td>
									  <td><?php echo $name; 
										 if($review_comment==NULL){
											echo " "."<strong><i>(Waiting for reply)</i><strong>";
										 }?></td>
									  <td><?php echo $email; ?></td>
									  <td><?php echo $phone; ?></td>
									  <td><?php echo date('d-m-Y',strtotime($create_date)); ?></td>
									  <td><a href="" class="cat_link" title="View" onclick="MM_openBrWindow('feedbackview.php?page_id=<?php echo $id;?>','window','width=900,height=400,scrollbars=yes')">View </a></td>
									</tr>
								

									<?php }}else { ?>
									<tr>
										<td colspan="4">No Record Found !</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function getUrl(id) {
				document.getElementById('edit').href='edit_feedback.php?editid='+id+'<?php echo $pagnn; echo '&'.$string_url;?>';
			}
		</script>
		<?php include("footer.php");  ?>
		<!-- Footer end --> 
		<script src="http://code.jquery.com/jquery-1.9.0.js"></script> 
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script> 
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.colorbox.js"></script>
		<script src="js/jquery.cookie.js" type="text/javascript"></script>
		<script src="js/jquery.treeview.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/validation.js"></script>
		<script src="js/demo.js" type="text/javascript"></script> 
		<script>
			function MM_openBrWindow(theURL,winName,features){ 
				window.open(theURL,winName,features);
			}
		</script>
		<script type="text/javascript">
         jQuery(document).ready(function(){ 	
         	function slideout(){
         		setTimeout(function(){
         			jQuery("#response").slideUp("slow", function () {});
         		}, 2000);
         	}
         	jQuery("#response").hide();
         	jQuery(function() {
         		jQuery("#list ul").sortable({ 
         			opacity: 0.8, cursor: 'move', update: function() {
         				var order = jQuery(this).sortable("serialize") + '&update=update' + '&tab=manage'; 
         				jQuery.post("updateList.php", order, function(theResponse){
         					jQuery("#response").html(theResponse);
         					jQuery("#response").slideDown('slow');
         					slideout();
         				}); 															 
         			}								  
         		});
         	});
         });	
         
         $(function(){ 
         	$("#start").datepicker({
         		dateFormat:'yy-mm-dd',
         		onSelect: function(selected) {
         			$("#end").datepicker("option","minDate", selected)
         		}
         	});
         	$("#end").datepicker({
         		dateFormat:'yy-mm-dd',
         		onSelect: function(selected) {
         			$("#start").datepicker("option","maxDate", selected)
         		}
         	});
         });
         jQuery(".closestatus").click(function() {
         	jQuery("#msgclose").addClass("hide");
         });
         
         jQuery(".closestatus").click(function() {
         	jQuery("#msgerror").addClass("hide");
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
	</body>
</html>