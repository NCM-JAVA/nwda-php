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
                $saltCookie                          =uniqid(rand(59999, 199999));
                $_SESSION['saltCookie'] =$saltCookie;
                $_SESSION['Temptest']=$_SESSION['saltCookie'];
                setcookie("Temp",$_SESSION['saltCookie']);
                $_SESSION['logtoken'] =md5(uniqid(mt_rand(), true));


                $blog_title       =     check_input($_POST['blog_title']);
                $language       =     check_input($_POST['txtlanguage']);
                $description    =     check_input($_POST['blog_description']);
                $status         =     check_input($_POST['status']);
                $youtube_video_url         =     check_input($_POST['video_url']);
                $errmsg="";

                if(trim($blog_title)=="")
                {
                        $errmsg .="Please Enter Blog Title."."<br>";
                }
                if(trim($language)=="")
                {
                        $errmsg .="Please Select Language."."<br>";
                }
                 if(trim($description)=="")
                {
                        $errmsg .="Please Enter Description."."<br>";
                }

                if(trim($status)=="")
                {
                        $errmsg .="Please select status."."<br>";
                }
                
                if($errmsg=='')
                {
                        
                        $tableName_send="tbl_blog";
                        $tableFieldsName_old=array("blog_title","language","description","status","created_by","created_date","youtube_video_url");
                        $tableFieldsValues_send=array("$blog_title","$language","$description","$status","$_SESSION[login_name]",DATE('Y-m-d'),"$youtube_video_url");
                        $value=$useAVclass->insertQuery($tableName_send,$tableFieldsName_old,$tableFieldsValues_send);
                        $page_id=mysql_insert_id();                        
                        $msg=CONTENTADD;
                        $_SESSION['SESS_MSG']=$msg;
                        header("location:blog_list.php");
                        exit;
                }		

        }

}
//	Update Record Start

else if(isset($_POST['Submit_g']) && $_GET['id']!='')
{
        $blog_title       =     check_input($_POST['blog_title']);
        $language       =     check_input($_POST['txtlanguage']);
        $description    =     check_input($_POST['blog_description']);
        $status         =     check_input($_POST['status']);
        $errmsg="";

        if(trim($blog_title)=="")
        {
                $errmsg .="Please Enter Blog Title."."<br>";
        }
        if(trim($language)=="")
        {
                $errmsg .="Please Select Language."."<br>";
        }
         if(trim($description)=="")
        {
                $errmsg .="Please Enter Description."."<br>";
        }

        if(trim($status)=="")
        {
                $errmsg .="Please select status."."<br>";
        }
        if($errmsg=='')
        { 
                $tableName_send="tbl_blog";
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

                $old =array("blog_title","language","description","status","youtube_video_url");
                $new =array("$blog_title","$language","$description","$status","$youtube_video_url");
                $useAVclass->UpdateQuery($tableName_send,$whereclause,$old,$new);



                $msg=CONTENTUPDATE;
                $_SESSION['SESS_MSG']=$msg;
                //$_SESSION['token'] = "";
                //$_SESSION['uniq'] = "";
                header("location:blog_list.php");
                exit;	

        }
}


 
 
 else if($_GET['id']!='')
{
        $rq = mysql_query("select * from tbl_blog where id='".$_GET['id']."'");
        //echo "select * from category where c_id='".$_GET['id']."'";
        $edit_record = mysql_fetch_assoc($rq);       
        //print_r($edit_record);
}



 
			
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Blog : <?php echo $sitename;?></title>
<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/demo.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
                                <h3 class="manageuser">Create New Blog </h3>
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
                                    
                                       
                                        <div class="frm_row">  <span class="label1"><label for="txtlanguage">Blog Language :</label><span class="star">*</span></span> 
                                        <span class="input1">
                                                <input type="radio" name="txtlanguage" id="txtlanguage" autocomplete="off"  value="1"<?php if($txtlanguage==1){ echo "checked"; } if($edit_record['language']==1){ echo 'checked="checked"';   }?>/ >English &nbsp;
                                                <input type="radio" name="txtlanguage" autocomplete="off" id="txtlanguage"  value="2"<?php if($txtlanguage==2){ echo "checked"; } if($edit_record['language']==2){ echo 'checked="checked"';   }?>/>Hindi
                                        </span>
                                        <div class="clear"></div>
                                                    <div class="loading"></div>
                                       </div>
                                        <div class="frm_row"> <span class="label1"><label for="blog_title"> Blog Title:</label><span class="star">*</span></span> 
                                                <span class="input1">
                                                        <input name="blog_title" type="text" size="50" class="input_class" id="blog_title" value="<?php echo $edit_record['blog_title']; ?>" />
                                                </span>
                                                <div class="clear"></div>
                                        </div>
                    
                                        <div class="frm_row"> <span class="label1"><label for="blog_description"> Description:</label><span class="star">*</span></span>                                               
                                                <span class="input_fck" id="">
                                                <?php
                                        $ckeditor = new CKEditor();
                                        $ckeditor->basePath = '/ckeditor/';
                                        $ckeditor->config['filebrowserBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html';
                                        $ckeditor->config['filebrowserImageBrowseUrl'] = '/auth/adminPanel/ckfinder/ckfinder.html?type=Images';
                                        $ckeditor->config['filebrowserUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
                                        $ckeditor->config['filebrowserImageUploadUrl'] = '/auth/adminPanel/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
                                        $ckeditor->editor('blog_description',stripslashes(html_entity_decode($edit_record['description'])));
                                        ?>        
                                                </span>
                                                <div class="clear"></div>
                                        </div>
                    
                                        <div class="frm_row"> <span class="label1"><label for="video_url"> Youtube Video URL:</label><span class="star">*</span></span> 
                                                <span class="input1">
                                                        <input name="video_url" type="text" size="50" class="input_class" id="video_url" value="<?php echo $edit_record['youtube_video_url']; ?>" />
                                                </span>
                                                <div class="clear"></div>
                                        </div>
	 
                                        <div class="frm_row"> <span class="label1"><label for="status">Status:</label><span class="star">*</span></span> 
                                                <span class="input1">
                                                        <select name="status" id="status" autocomplete="off">
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
                                                <input type="button" class="button" value="Back" onClick="javascript:location.href = 'add-blog.php';" />
                                          </span>
                                        </div>
                                        <div class="clear"></div>

                                </form>
                           
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

