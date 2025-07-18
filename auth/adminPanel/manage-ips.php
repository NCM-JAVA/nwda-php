<?php ob_start();
include("../../includes/config.inc.php");
include("../../includes/connection.php");
include("../../includes/functions.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
require_once("../../includes/ps_pagination.php");
$useAVclass = new useAVclass();
$useAVclass->connection();

@extract($_GET);
@extract($_POST);
@extract($_SESSION);
$role_id=$_SESSION['dbrole_id'];
$user_id=$_SESSION['admin_auto_id_sess'];
$model_id= "16";
$role_map=role_permission($user_id,$role_id,$model_id);
$role_id_page=role_permission_page($user_id,$role_id,$model_id);
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
if($role_id_page==0)
{
        $msg = "Login to Access Admin Panel";
        $_SESSION['sess_msg'] = $msg ;
        header("Location:error.php");
        exit;	
}

if(isset($_POST['Submit_g']) && $_GET['id']=='')
{
        if($_SESSION['logtoken']!=$_POST['random'])
        {
                session_unset($admin_auto_id_sess);
                session_unset($login_name);
                session_unset($dbrole_id);
                $msg = "Login to Access Admin Panel";
                $_SESSION['sess_msg'] = $msg ;
                header("Location:error.php");
                exit();
        }
        else {
                $_COOKIE['Temp']                = "";
                $_SESSION['saltCookie']        ="";
                $_SESSION['Temptest']          ="";
                $saltCookie                             =uniqid(rand(59999, 199999));
                $_SESSION['saltCookie'] =$saltCookie;
                $_SESSION['Temptest']=$_SESSION['saltCookie'];
                setcookie("Temp",$_SESSION['saltCookie']);
                $_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));


                $ip_status       =     check_input($_POST['ip_status']);
                $ip_address    =     check_input($_POST['ip_address']);
                $remarks        =     check_input($_POST['remarks']);
                $errmsg="";

                if(trim($ip_address)=="")
                {
                        $errmsg .="Please Enter IP Address."."<br>";
                }
                 if(trim($remarks)=="")
                {
                        $errmsg .="Please Enter Remarks."."<br>";
                }

                if(trim($ip_status)=="")
                {
                        $errmsg .="Please select status."."<br>";
                }
                
                if($errmsg=='')
                {
                        $tableName_send="tbl_ip_address";
                        $tableFieldsName_old=array("ip_address","status","remarks");
                        $tableFieldsValues_send=array("$ip_address","$ip_status","$remarks");
                        $value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
                        $page_id=mysql_insert_id();                        
                        $msg=CONTENTADD;
                        $_SESSION['SESS_MSG']=$msg;
                        header("location:manage-ips.php");
                        exit;
                }		

        }

}
//	Update Record Start

else if(isset($_POST['Submit_g']) && $_GET['id']!='')
{
        $ip_status=check_input($_POST['ip_status']);
        $ip_address= content_desc(check_input($ip_address));

        if(trim($ip_address)=="")
        {
                $errmsg .="Please Enter IP Address."."<br>";
        }
        
        if(trim($remarks)=="")
       {
               $errmsg .="Please Enter Remarks."."<br>";
       }

        if(trim($ip_status)=="")
        {
                $errmsg .="Please select status."."<br>";
        }
        if($errmsg=='')
        { 
                $tableName_send="tbl_ip_address";
                $whereclause="id='".$_GET['id']."'";
                if($_SESSION['logtoken']!=$_POST['random'])
                {
                        $msg = "Login to Access Admin Panel";
                        $_SESSION['SESS_MSG']= $msg ;
                        header("Location:error.php");
                        exit();
                }
                else {
                        $_COOKIE['Temp']="";
                        $_SESSION['saltCookie']="";
                        $_SESSION['Temptest']="";
                        $saltCookie =uniqid(rand(59999, 199999));
                        $_SESSION['saltCookie'] =$saltCookie;
                        $_SESSION['Temptest']=$_SESSION['saltCookie'];
                        setcookie("Temp",$_SESSION['saltCookie']);
                        $_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
                }

                $old =array("ip_address","status","remarks");
                $new =array("$ip_address","$ip_status","$remarks");
                $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);



                $msg=CONTENTUPDATE;
                $_SESSION['SESS_MSG']=$msg;
                //$_SESSION['token'] = "";
                //$_SESSION['uniq'] = "";
                header("location:manage-ips.php");
                exit;	

        }
}


 else if($_GET['did']!='')
 {
        if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($did))))
        {
                /*session_unset($admin_auto_id_sess);
                    session_unset($login_name);
                    session_unset($dbrole_id);*/
                $msg = "Login to Access Admin Panel";
                $_SESSION['sess_msg'] = $msg ;
                header("Location:error.php");
                exit();
        }
        else {
                $_COOKIE['Temp']="";
                $_SESSION['saltCookie']="";
                $_SESSION['Temptest']="";
                $saltCookie =uniqid(rand(59999, 199999));
                $_SESSION['saltCookie'] =$saltCookie;
                $_SESSION['Temptest']=$_SESSION['saltCookie'];
                setcookie("Temp",$_SESSION['saltCookie']);
                $_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));
                mysql_query("delete from tbl_ip_address where id='$did'");
                $_SESSION['SESS_MSG'] = " Record Successfully Delete";
                header("Location:manage-ips.php");
                exit;
        }
 	
 }
 
 else if($_GET['id']!='')
{
        $rq = mysql_query("select * from tbl_ip_address where id='".$_GET['id']."'");
        //echo "select * from category where c_id='".$_GET['id']."'";
        $edit_record = mysql_fetch_assoc($rq);       
        //print_r($edit_record);
}



 
			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage IP Address : <?php echo $sitename;?></title>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/demo.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script src="js/jquery.tinylimiter.js"></script>



<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="style/ie7.css">
<![endif]-->


</head>
<body>
<?php include('top_header.php'); ?>
    <div id="container">
 <!-- Header start -->  
  <?php include_once('main_menu.php'); ?>
  <!-- Header end -->
        <div class="main_con">
	<div class="right_col1">
                  <?php if($errmsg!=""){?>
                        <div  id="msgerror" class="status error">
                                <div class="closestatus" style="float: none;">
                                <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                                <p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
                                </div>
                        </div>
                  <?php }?>
	<?php if($_SESSION['SESS_MSG']!=""){?>
                        <div  id="msgclose" class="status success">
                                <div class="closestatus" style="float: none;">
                                <p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
                                <p><img alt="Attention" src="images/approve.png" class="margintop"> <span>Attention! </span><?php echo $_SESSION['SESS_MSG']; ?></p>
                                </div>
                      </div>
                <?php }?>	
      	<div class="clear"></div>     
        	<div class="addmenu"> 
                        <div class="internalpage_heading">
                                <h3 class="manageuser">Manage IP Address </h3>
                                        <div class="right-section">
                                                <!--<ul>
                                               <?php if($role_map['draft']=='DR' || $user_id=='101'){?><li  class="new-icon">
                                               <a href="gallery-category.php" title="New"><span class="icon-28-new"></span>New</a></li>
                                                             <li class="divider"> </li><?php }?>
                                                </ul>  -->
                                         </div>
                        </div>	
                        <div class="grid_view">
		<form action="" method="post" enctype="multipart/form-data" style="margin:0px; padding:0px;">
                                    
                                       <div class="frm_row"> <span class="label1"><label for="ip_address"> IP Address:</label><span class="star">*</span></span> 
                                                <span class="input1">
                                                        <input name="ip_address" type="text" size="50" class="input_class" id="ip_address" value="<?php echo $edit_record['ip_address']; ?>" />
                                                </span>
                                                <div class="clear"></div>
                                        </div>
                    
                                        <div class="frm_row"> <span class="label1"><label for="remarks"> Remarks:</label><span class="star">*</span></span> 
                                                <span class="input1">                                                   
                                                    <textarea name="remarks" row="40" cols="40" id="remarks" ><?php echo $edit_record['remarks']; ?></textarea>
                                                </span>
                                                <div class="clear"></div>
                                        </div>
	 
                                        <div class="frm_row"> <span class="label1"><label for="ip_status">Status:</label><span class="star">*</span></span> 
                                                <span class="input1">
                                                        <select name="ip_status" id="ip_status" autocomplete="off">
                                                                <option value=""> Select </option>
                                                                <?php foreach($status as  $key => $value) {  ?>
                                                                        <option value="<?php echo $key; ?>"<?php if($key==$edit_record['status']) echo 'selected="selected"';?>><?php echo $value; ?></option>
                                                                <?php } ?>
                                                        </select>
                                                </span>
                                                <div class="clear"></div>
                                        </div>
    
                                        <div class="frm_row"> 
                                            <span class="button_row">
                                                <input name="Submit_g" type="submit" class="button" id="cmdsubmit" value="Submit" />
                                                <input type="hidden" name="random" value="<?php echo $_SESSION['logtoken'];?>">
                                                <input name="cmdreset" type="reset" class="button" id="cmdreset" value="Reset" />
                                              
                                          </span>
                                        </div>
                                        <div class="clear"></div>

                                </form>
                                <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">
                                         <tr bgcolor="whitesmoke">
                                                <th width="2%" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">S.No</th>
                                                <th width="38%" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">IP Address</span></th>
                                                <th width="38%" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Remarks</span></th>
                                                <th width="10%" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Status</th>
                                                <th width="5%" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Edit</th>
                                                <th width="5%" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</th>
                                        </tr>
                                        <?php 
                                        $columns = "select * ";
                                        $sql = "from tbl_ip_address where 1 ";
                                        $order_by == '' ? $order_by = 'id' : true;
                                        $order_by2 == '' ? $order_by2 = 'DESC' : true;
                                        $sql .= "order by $order_by $order_by2 ";
                                        $sql_count = "select count(*) ".$sql; 
                                        $sql = $columns.$sql;

                                        $pager = new PS_Pagination($link, $sql,"");
                                        $rows = $pager->paginate();
                                        if($rows==0) { ?>
                                                        <tr><td style="color:#F00;" height="30" align="center" colspan="6"><b>Sorry.. No records available.</b></td></tr>
                                                <?php  } else {	?>

                                                <?php 
                                        while($data=mysql_fetch_array($rows)){
                                                if($data['status']=='1')
                                                {
                                                        $status="Active";
                                                }
                                                else
                                                {
                                                        $status="Inactive";
                                                }
                                        ?>
                                                <tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
                                                        <td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
                                                        <td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['ip_address']);?></td>
                                                        <td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['remarks']);?></td>
                                                         <td width="50" align="left" class="left-tdtext"><?php echo html_entity_decode($status);?></td>
                                                        <td width="47" align="center" class="left-tdtext"><a href="manage-ips.php?id=<?php echo $data['id'];?>" class="bluelink"><input type="image" border="0" alt="Edit" src="images/edit.png"  title="Edit" /></a></td>

                                                        <td width="63" align="center" class="left-tdtext"><a href="manage-ips.php?did=<?php echo $data['id'];?>&random=<?php echo $_SESSION['logtoken'];?>" class="bluelink" onClick="return confirm('Are you sure want to delete record')"><input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a></td>
                                                </tr>
                                                <?php	}?>
                                                <tr>
                                                        <td colspan="6" align="center"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                                <?php }	?> 
                                        </table>
                                        <div class="clear"></div>
                                </div>
                        </div>
                </div>
                <!-- right col -->
                <div class="clear"></div>

                <!-- Content Area end -->
                  </div>  <!-- main con-->

                <!-- Footer start -->
  
                <?php 
                include("footer.php");
              ?>
                <!-- Footer end -->
        </div> 
    <!-- Container div-->
</body>
</html>
<script type="text/javascript">
        $(".closestatus").click(function() {
                $("#msgerror").addClass("hide");
        });
</script>
	
<style>
.hide {display:none;}
</style>

