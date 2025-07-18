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

$edit_contrator ="select * from home_page where m_id='$page_id'";
$contrator_result = mysql_query($edit_contrator);
$res_rows=mysql_num_rows($contrator_result);
$fetch_result=mysql_fetch_array($contrator_result);
@extract($fetch_result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page :DDA</title>
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

        <div>
        <?php if($content !=''){?>
		<span align="left" colspan="2" class="label1"><?php echo  stripslashes(html_entity_decode($content)); ?></span>
        <?php } else if($doc_uplode !='') {?>
        <span align="left" colspan="2" class="label1"><a href="../../upload/<?php echo $doc_uplode; ?>">Download</a></span>
        <?php }
        else if($linkstatus !='') {?>
        <span align="left" colspan="2" class="label1"><a href="<?php echo  $linkstatus; ?>" target="_blank"><?php echo  $linkstatus; ?></a></span>
        <?php }?>
        
        </div>
      
  </div>   
    	 <div align="center"><input type="button" class="button" value="Close" onclick="MM_callJS('window.close();')" >
   
 </div>
	
	</body>
</html>
