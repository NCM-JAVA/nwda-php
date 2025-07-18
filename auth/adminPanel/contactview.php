<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$useAVclass = new useAVclass();
$useAVclass->connection();
if($_SESSION['admin_auto_id_sess']=='')
	{		
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:index.php");
		exit;	
	}
if($_SESSION['saltCookie'] !=$_COOKIE['Temp'])
{
		session_unset($admin_auto_id_sess);
		session_unset($login_name);
		session_unset($dbrole_id);
		$msg = "Login to Access Admin Panel";
		$_SESSION['sess_msg'] = $msg ;
		header("Location:error.php");
		exit;	
}

$edit_contrator ="select * from contact_details where m_id='$page_id'";
$contrator_result = mysql_query($edit_contrator);
$res_rows=mysql_num_rows($contrator_result);
$fetch_result=mysql_fetch_array($contrator_result);
@extract($fetch_result);
//$sta=split('-',$content_start_dt);
//$content_start_dt=$sta['2']."-".$sta['1']."-".$sta['0'];
//$exp=split('-',$content_expairy_dt);
//$content_expairy_dt=$exp['2']."-".$exp['1']."-".$exp['0'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page:DDA</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>
<body>
<?php //include('top_header.php'); ?>
<div style="height:10px"></div>

<div class="heading-holder" style=" min-height:500px;">
          <div class="heading-area" >
            <h2><?php echo $m_name;?></h2>
          </div>
		   <div class="clear"></div>
		   <div style="height:10px"></div>
<div class="frm_row"> <span class="label1">
				<label>Designation:</label><span class="star">*</span>
				</span> 
			
						<?php  $sqlqury=mysql_query("Select * from designation where id='$page_id' ORDER BY id ASC");
						while($row=mysql_fetch_array($sqlqury))
						{
							?>
							<span class="input1">
						<input name="empname" autocomplete="off" type="text" class="input_class" id="empname" size="30"  readonly="readonly" value="<?php echo $row['d_name']; ?>"/>
						<?php }
						 ?>
					
				
				</span>
				<div class="clear"></div>
			</div>
        <div class="frm_row"> <span class="label1">
				<label>Name:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="empname" autocomplete="off" type="text" class="input_class" id="empname" size="30"  readonly="readonly" value="<?php if($emp_name!=""){ echo $emp_name;} ?>"/>
				
				</span>
				<div class="clear"></div>
				</div>
				<!--<div class="frm_row"> <span class="label1">
				<label>Designation:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="designation" autocomplete="off"  type="text" class="input_class" id="designation" size="30" value="<?php if($designation!=""){ echo $designation;} ?>"/>
				</span>
				<div class="clear"></div>
				</div>-->
				<div class="frm_row"> <span class="label1">
				<label>Division:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="division" autocomplete="off"  type="text" class="input_class" id="division" readonly="readonly" size="30" value="<?php if($division!=""){ echo $division;} ?>"/>
				</span>
				<div class="clear"></div>
				</div>
				<div class="frm_row"> <span class="label1">
				<label>phone:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="phone" autocomplete="off"  type="text" class="input_class" id="phone" readonly="readonly" size="30" value="<?php if($phone!=""){ echo $phone;} ?>"/>
				</span>
				<div class="clear"></div>
				</div>
				
				<div class="frm_row"> <span class="label1">
				<label>Inter Com:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="extention" autocomplete="off" type="text" class="input_class" id="extention" size="30" readonly="readonly"   value="<?php if($extention!=""){ echo $extention;} ?>"/>
				
				</span>
				<div class="clear"></div>
				</div>
				<div class="frm_row"> <span class="label1">
				<label>Email Id:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="email" autocomplete="off"  type="text" class="input_class" id="email" size="30"  readonly="readonly" value="<?php if($email!=""){ echo $email;} ?>"/>
				</span>
				<div class="clear"></div>
				</div>
				<div class="frm_row"> <span class="label1">
				<label>Room No.:</label>
				<span class="star">*</span></span> <span class="input1">
				<input name="room_no" autocomplete="off"  type="text" class="input_class" id="room_no" size="30" readonly="readonly" value="<?php if($room_no!=""){ echo $room_no;} ?>"/>
				</span>
				<div class="clear"></div>
				</div>
				
				
</div>        
      
  </div>   
    	 <div align="center"><input type="button" class="button" value="Close" onclick="MM_callJS('window.close();')" >
   
 </div>
	
	</body>
</html>
