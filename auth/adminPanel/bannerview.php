<?php ob_start();
 include("../../includes/config.inc.php");
  require_once "../../includes/connection.php";
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

$edit_contrator ="select * from banner where b_id='$page_id'";
$contrator_result = $conn->query($edit_contrator);
$res_rows = $contrator_result->num_rows;
$fetch_result = $contrator_result->fetch_array();
@extract($fetch_result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page :DDA</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<link href="style/popadmin.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>
<body>
   
       
<div class="right_col1">
          
		  <div class="clear"></div>

      	<div class="clear"></div>
 
        
	<div class="addmenu"> 
    <div class="internalpage_heading">
 <h3 class="manageuser"><?php echo $b_name;?></h3>
 <div class="right-section">
 
 </div>
 </div>		
         <div class="grid_view">
<div style="height:10px"></div>
<div class="heading-holder" style=" min-height:500px;">
          <div class="heading-area" >
            <h2></h2>
          </div>
		   <div class="clear"></div>
		   <div style="height:10px"></div>
        <div>
		 <table width="98%"  align="center" border="0" cellspacing="2" cellpadding="2" summary="" style="border:1px solid #cccccc">
 <tbody>

	
 <tr>
    <td colspan="3" align="left">&nbsp;</td>
  </tr>

  <tr>
    <td align="left" valign="top" width="35%" class="label2" >Short Description: </td><td width="1%">:</td>
    <td align="left" width="64%" class="label1"><label for="select"></label><label for="member">
    <?php  echo html_entity_decode($b_short_desc); ?>
    </label></td>
  </tr>
   <tr>
    <td align="left" valign="top" width="35%" class="label2" >Hindi Title: </td><td width="1%">:</td>
    <td align="left" width="64%" class="label1"><label for="select"></label><label for="member">
    <?php  echo html_entity_decode($sort_desc_hindi); ?>
    </label></td>
  </tr>

	<tr>
<td align="left" class="label2"  width="25%">
 <?php if($b_image_path	 !='') {?><div class="frm_row"> <span class="label1">
            <label for="txtuplode">Image:</label></td>
	<td width="1%">:</td>
            </span>   <td align="left" width="64%" class="label1"><label for="select"></label><label for="member">
		  	<img src="../../upload/banner/thumb/<?php echo $b_image_path;?>" alt="" title="" align="center" width="80" height="90" />
		       </span>
            <div class="clear"></div>
            </div>
			</label>
			   <?php }?> 
			</td>
			</tr>
			  <?php if($m_content !=''){?>
		<span align="left" colspan="2" class="label1"><?php echo  stripslashes(html_entity_decode($m_content)); ?></span>
        <?php } else if($docs_file !='') {?>
        <span align="left" colspan="2" class="label1"><a href="../../upload/<?php echo $docs_file; ?>">Download</a></span>
        <?php }
        else if($ext_url !='') {?>
        <span align="left" colspan="2" class="label1"><a href="<?php echo  $ext_url; ?>" target="_blank"><?php echo  $ext_url; ?></a></span>
        <?php }?>
		</tbody>
</table>
		
		
      
  </div>   
    	 <div align="center"><input type="button" class="button" value="Close" onclick="MM_callJS('window.close();')" >
   
 </div>
	
	</body>

</div>
</div>

</div><!-- right col -->
</body>
</html>
    