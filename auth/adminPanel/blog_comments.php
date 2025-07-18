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

$blog_id = $_REQUEST['bid'];
$inactiveid = $_REQUEST['inactiveid'];
$comment_status = $_REQUEST['status'];
$blog_title = getBlogTitle($blog_id);


function getBlogTitle($blogid){
         $records = array();
         if($blogid !=''){
                 $select_qry = mysql_query("select blog_title from tbl_blog where id =".$blogid);       
                if(mysql_num_rows($select_qry) >0){
                        while($data = mysql_fetch_assoc($select_qry)){
                           $blog_title = $data['blog_title'];
                        }
                }      
         }
         return $blog_title;
}

//echo "fffffffffffffffffffffff ".$blog_id;//exit
if(($inactiveid !=''))
{
        if(($_SESSION['logtoken']!=$random) or (!is_numeric(trim($inactiveid))))	{
                session_unset($admin_auto_id_sess);
                session_unset($login_name);
                session_unset($dbrole_id);
                $msg = "Login to Access Admin Panel";
                $_SESSION['sess_msg'] = $msg ;
                header("Location:error.php");
                exit();
        }else {
                $_COOKIE['Temp']="";
                $_SESSION['saltCookie']="";
                $_SESSION['Temptest']="";
                $saltCookie =uniqid(rand(59999, 199999));
                $_SESSION['saltCookie'] =$saltCookie;
                $_SESSION['Temptest']=$_SESSION['saltCookie'];
                setcookie("Temp",$_SESSION['saltCookie']);
                $_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));

        }
        if($comment_status == 0){
                $status_update = 1;
        }else{
                $status_update = 0;
        }
   $sql="Update tbl_blog_comments set status='$status_update' where id='$inactiveid'"; 
 $res=mysql_query($sql);

	if($res)
	{	
	header("location:blog_comments.php?bid=".$blog_id);
	}
}


 if($_GET['did']!='')
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
                mysql_query("delete from tbl_blog_comments where id='$did'");
                $_SESSION['SESS_MSG'] = " Record Successfully Delete";
                header("Location:blog_comments.php");
                exit;
        }
 	
 }
 



 
			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blog Comments : <?php echo $sitename;?></title>
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
                                <h3 class="manageuser"> <?php echo $blog_title; ?> Comments </h3>
                                        <div class="right-section">
                                                <ul>
                                               <?php if($role_map['draft']=='DR' || $user_id=='101'){?><li  class="new-icon">
                                               <a href="add_blog.php" title="New"><span class="icon-28-new"></span>New</a></li>
                                                             <li class="divider"> </li><?php }?>
                                                </ul> 
                                         </div>
                        </div>	
                        <div class="grid_view">
		
                                <table width="100%" border="0" align="right" cellpadding="2" cellspacing="2" style="border:1px solid #cccccc">
                                         <tr bgcolor="whitesmoke">
                                                <th width="2%" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td">S.No</th>
                                                <th width="15%" align="left" valign="top" bgcolor="whitesmoke" class="topheader_td"><span class="left-text">Comments</span></th>
                                                <th width="10%" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Status</th>
                                                
                                                <th width="8%" align="center" valign="top" bgcolor="whitesmoke" class="topheader_td">Delete</th>
                                        </tr>
                                        <?php 
                                        $columns = "select * ";
                                        $sql = "from tbl_blog_comments where blog_id = ".$blog_id." ";
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
                                                        $upstatus = "Inactive";
                                                }
                                                else
                                                {
                                                        $status="Inactive";
                                                        $upstatus = "Active";
                                                }
                                        ?>
                                                <tr valign="top" onMouseMove="javascript: this.style.background='#ECF1F2'" onMouseOut="javascript: this.style.background='#FFFFFF'">
                                                        <td width="38" align="left"  class="left-tdtext"><?php echo ++$counter;?></td>
                                                        <td width="510" align="left" class="left-tdtext"><?php echo html_entity_decode($data['comment']);?></td>
                                                        
                                                         <td width="50" align="left" class="left-tdtext"><a href="blog_comments.php?bid=<?php echo $blog_id; ?>&inactiveid=<?php echo  $data['id']; ?>&status=<?php echo  $data['status']; ?>&random=<?php echo $_SESSION['logtoken'];?>" onclick="return confirm('Are you sure you want to <?php echo $upstatus; ?> this page?')"><?php echo $status; ?></a>
                            </td>
                                                        

                                                        <td width="63" align="center" class="left-tdtext"><a href="blog_comments.php?did=<?php echo $data['id'];?>&random=<?php echo $_SESSION['logtoken'];?>" class="bluelink" onClick="return confirm('Are you sure want to delete record')"><input type="image" border="0" alt="Delete" src="images/deletes-icon.png"  title="Delete" /></a></td>
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

