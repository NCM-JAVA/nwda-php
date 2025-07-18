<?php 
 include_once 'fileconfig.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include("../../includes/config.inc.php");
include("../../includes/useAVclass.php");
include("../../includes/functions.inc.php");
include("../../includes/def_constant.inc.php");
include_once 'ckeditor/ckeditor.php';
include_once 'ckfinder/ckfinder.php';
//uploading


if(isset($_FILES['file']) && isset($_REQUEST['path'])) {
    $fileElement = "file"; //$_FILES['file'];
    //print_r($fileElement);
    //die();
    $path = urldecode($_REQUEST['path']);
    $response = upload($fileElement, 10 * 1024 * 1024, $path, "N");
    //$response = move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)
    //print_r($response);
    //die();

    if(!$response['error']) {
        echo "success";        
    }  
    exit();
}

$dir = "../../upload";

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//$errmsg = '';

if(isset($_REQUEST['path'])) {
    $dir = urldecode($_REQUEST['path']);
}

//folder create
if(isset($_REQUEST['createfolder'])) {
    $foldername = trim($_REQUEST['createfolder']);    
    if(mkdir($dir."/".$foldername, 0777, true)){        
        header("location: ?path=".$dir);
    }
}

//move
if(isset($_REQUEST['move']) && isset($_REQUEST['filenames']) && isset($_REQUEST['folder'])) {
    $filenames = $_REQUEST['filenames'];
    $folder = $_REQUEST['folder'];
    $currentdir = urldecode($_REQUEST['path']);
    $flag = true;
    foreach($filenames as $filename) {               
        //echo $currentdir . "/" . $filename . "=" . $folder . "/" . $filename;
        if (!rename($currentdir . "/" . $filename, $folder . "/" . $filename)) {
            $flag = false;
            break;
        }
    }   
    
    if($flag) {
        echo "success";        
    }    
    exit();
}

//delete
if(isset($_REQUEST['delete']) && isset($_REQUEST['filenames'])) {
    $filenames = $_REQUEST['filenames'];    
    $currentdir = urldecode($_REQUEST['path']);
    $flag = true;
    foreach($filenames as $filename) {    
        //delete if it is directory
        if(is_dir($currentdir . "/" . $filename)) {
            rmdir($currentdir . "/" . $filename);
        }
        if (is_file($currentdir . "/" . $filename) && !unlink($currentdir . "/" . $filename)) {
            $flag = false;
            break;
        }
    }   
    if($flag) {
        echo "success";        
    }    
    exit();
}

//files and folder list
$files = scan($dir, true);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add File :<?php echo $sitename;?></title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="style/admin.css" rel="stylesheet" type="text/css">
<link href="style/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script language="JavaScript" src="js/validation.js"></script>
        

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <style>
.selected {
	background-color: rgba(192, 192, 192, 0.6);
}
.file-upload {
	cursor: inherit;
	display: block;
	/*font-size: 999px;*/
	filter: alpha(opacity=0);
	min-height: 100%;
	min-width: 100%;
	opacity: 0;
	position: absolute;
	right: 0;
	text-align: right;
	top: 0;
}
.dashboard {
    width: 100%;
    float: left;
    margin-right: 1%;
    background: #FFF;
    padding-bottom: 10px;
}
.dashboard_heading {
    width: 100%;
    background: #3334cc;
    height: 50px;
}
.das-box {
    padding: 10px;
}
		.dashboard ul li {
    display: block;
    float: left;
    list-style-type: none;
    margin-bottom: 10px;
    margin-right: 15px;
    margin-top: 0px;
    min-height: 85px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.19);
    text-align: center;
    width: 160px;
    border-bottom: solid 1px #929fcf;
    border-left: solid 1px #ced5ed;
    border-right: solid 1px #ced5ed;
    border-top: solid 1px #ced5ed;
	    height: 120px;
    padding: 10px;
}
.dashboard ul {
    margin: 0px 0 0 15px;
    padding: 0px;
	    overflow-wrap: break-word;
}	
.dashboard ul li a {
    font-size: 75%;
    text-decoration: none;
    color: #333;
    margin-top: 12px;
    display: block;
}
        </style>
</head>
<body>	
<?php include('top_header.php'); ?>
<div id="container">
<?php include_once('main_menu.php'); ?>
	<div class="main_con">  
		<div class="admin-breadcrum">
			<div class="breadcrum">
				<span class="submenuclass"><a href="welcome.php">Dashboard </a> </span>
				<span class="submenuclass"> >> </span>
				<span class="submenuclass"><a href="#">CMS Page</a></span>
				<span class="submenuclass"> >> </span> 
				<span class="submenuclass">Manage Files</span>
			</div>
		</div> 
		<div class="right_col1">
			<?php if($errmsg!=""){?>
			<div  id="msgerror" class="status error">
				<div class="closestatus" style="float: none;">
					<p class="closestatus" style="float: right;"><img alt="Attention" src="images/close.png" class="margintop"></p>
					<p><img alt="error" src="images/error.png"> <span>Attention! <br /></span><?php echo $errmsg; ?></p>
				</div>
			</div>
			<?php }?>
			  <div class="container" style="margin-top: 20px;">
					<div class="panel panel-default">
						<div class="panel-heading" style="padding: 20px;background: #3334cc; color:white;    margin-top: 10px;">
							File Browser
							<div class="pull-right">
								<span id="uploading" style="display: none;">Uploading...</span>
								<div class="btn-group">                            
									<button class="btn btn-default btn-sm" title="Upload"><i class="fa fa-upload"></i> Upload<input type="file" class="file-upload"/></button>
								</div>                    
							</div>
						</div>
						<div class="panel-body">
							<div class="btn-group">
								<a href="javascript:void()" onclick="javascript:window.history.back()" class="btn btn-sm btn-default">Back</a>
								<a href="javascript:void()" onclick="javascript:window.history.forward()" class="btn btn-sm btn-default">Forward</a>                       
							</div>
							<div class="table-responsive">                    
								<div class="dashboard">
									<div class="das-box">
										<?php  //echo "<pre>"; print_r($files); die;
											foreach ($files as $file) {    
												$path = "?path=".urlencode($file['path']);
												if($file['type'] == "file") {
													$path = $file['path'];
												}  
										
												?>
												
												<ul>
													<li><a href="<?php echo $path; ?>" title="View File" 	>
													<?php if($file['type'] == "file") {?>
													<img src="<?php echo $HomeURL; ?>/assets/images/pdf.png" alt="View File" width="35" height="37" border="0">
													<?php }else{?>
													<img src="<?php echo $HomeURL; ?>/assets/images/folder.png" alt="View File" width="35" height="37" border="0">
													<?php } ?>
													<br>
													<?php echo $file['name']; ?><br></a></li>
												</ul>
										<?php } ?>                    
									</div>
								</div>                       
							</div>                       
						</div>                       
					</div>                        
				</div>                       
         </div><!-- right col -->
	</div>  <!-- area div-->
</div>  <!-- main con-->
        <!-- Include our script files -->

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script>
            $("input[type=file]").change(function(){                    
                var action = "<?php echo basename($_SERVER['PHP_SELF']) . "?path=". urlencode($dir); ?>";
                
                if($(this).val() === "") {
                    return;
                }   
	
                $("#uploading").show();
                var data = new FormData();

                data.append("file", $('input[type=file]')[0].files[0]);     
                           
                $.ajax({
                    type: 'POST',
                    url: action,
				

                    data: data,
                    /*THIS MUST BE DONE FOR FILE UPLOADING*/
                    contentType: false,
                    processData: false,
                }).done(function(data){ 
                    $("#uploading").hide(); 
				
                    if(data ==="success") {
						window.location.href = "?path=<?php echo $dir; ?>";
                    }                    
                }).fail(function(data){
                    //any message
                    alert("Error: " + data);
                });  
            });          
            
            function createFolder() {
                var foldername = prompt("Enter Folder Name", "New Folder");
                if(foldername !== null) {
                    window.location.href = "?path=<?php echo $dir; ?>&createfolder=" + foldername;
                }
            }
            
            cntrlIsPressed = false;
            $(document).keydown(function(event){
                if(event.which=="17")
                    cntrlIsPressed = true;
            });

            $(document).keyup(function(){
                cntrlIsPressed = false;
            });
            $("table tbody tr").hover(function(){
               //$(this).addClass('active').siblings().removeClass('active');
            });
            
            $("table tbody tr").click(function(){
                if(cntrlIsPressed) {
                    $(this).addClass('selected');
                } else {
                    $(this).addClass('selected').removeClass('active').siblings().removeClass('selected');
                }               
            });

            $('.ok').on('click', function(e){
               alert($("#ul li.selected td:first").html());
               var selectedIDs = [];
               $("#ul li.selected").each(function(index, row) {
                  selectedIDs.push($(row).find("td:first").html());
               });
                
            });                       
                     
            function downloadSelected(){
                $("ul li a.selected").each(function () {
                    var url = $(this).find("a").attr("href");  
                    if($(this).find("td:eq(1)").html() === "file") {
                        var a = $("<a>").attr("href", url).attr("download", "").appendTo("body");
                        a[0].click();
                        a.remove();
                    }
                }); 
            }
            
            function moveSelected(){
                var action = "<?php echo basename($_SERVER['PHP_SELF']) . "?path=". urlencode($dir); ?>";
                if($("ul li a.selected").length <= 0) {
                    alert("Please select file/s");
                    return;
                }                
                var folder = prompt("Enter Folder Name to Move","<?php echo $dir; ?>");
                var data = new FormData();
                data.append("move", "1");
                data.append("folder", folder);
                $("ul li a.selected").each(function (index) {
                    var filename = $(this).find("td:eq(0)").text();  
                    data.append("filenames["+index+"]", filename);
                });                
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: data,
                    /*THIS MUST BE DONE FOR FILE UPLOADING*/
                    contentType: false,
                    processData: false,
                }).done(function(data){                                                
                    if(data.trim() === "success") {
                   // alert("success");
                        window.location.href = "?path=<?php echo $dir; ?>";
                    }                    
                }).fail(function(data){
                    //any message
                });  
            }
            
            function deleteSelected(){
                var action = "<?php echo basename($_SERVER['PHP_SELF']) . "?path=". urlencode($dir); ?>";
                if($("ul li a.selected").length <= 0) {
                    alert("Please select file/s");
                    return;
                }                                
                var data = new FormData();
                data.append("delete", "1");
                $("ul li a.selected").each(function (index) {
                    var filename = $(this).find("td:eq(0)").text();  
                    data.append("filenames["+index+"]", filename);
                });                
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: data,
                    /*THIS MUST BE DONE FOR FILE UPLOADING*/
                    contentType: false,
                    processData: false,
                }).done(function(data){                                                
                    if(data.trim() === "success") {
                        window.location.href = "?path=<?php echo $dir; ?>";
                    }                    
                }).fail(function(data){
                    //any message
                });  
            }
        </script>
<!-- Footer start -->
<?php include("footer.php"); ?>
<!-- Footer end -->
</body>
</html>
