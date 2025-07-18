<?php ob_start();
include("../../includes/config.inc.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page:<?=$sitename;?></title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>










<script>
var log_token = '<?php echo $_SESSION['logtoken']; ?>'; 
checkSessionOnDiffTabs();

function checkSessionOnDiffTabs(){             
        if(typeof(Storage) !== "undefined") {              
                //alert (sessionStorage.random_session_id);
                   if (sessionStorage.random_session_id) {
                          //sessionStorage.random_session_id = Number(sessionStorage.random_session_id)+1;
                   } else {
                           //sessionStorage.random_session_id = 1;
                           //window.location.href = 'logout.php?random='+log_token;
                   }
           } else {
                   
           }
} 
  </script>
  
  <div class="logo_row" style="min-height:80px;">
        <div class="admin">
             <h1><?php echo $sitename;?> Administration</h1>
         </div>
        <div class="clear"> </div>
</div>
                    







<div id="container">
<!--<div class="logo_row">
    <div class="logo_row_lft">
      <div class="logo_row_rgt">
        <div class="logo_row_content">
          <div class="admin">
            <h1>Error Page</h1>
          </div>
          <div class="client-name">
            <h2>Disability</h2>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
-->


  
  <div class="error_con">
  <div class="admin_errorpage">
	
			<h2>Sorry! Error 404 - Page Not Found </h2>
			<div>&nbsp;</div>
			
				The page you are attempting to access cannot be found. It may have been moved / renamed or may no longer exist.
				We have recently redesigned our website to make it easier and faster for you to find the information you need. This means the bookmarks and addresses you have used in the past may no longer work.
				To find the information you are looking for please try one of the following.
				
				<ol type="i">
					 <li>If you typed the page URL, check the spelling.</li>
					 <li> Go to our <a href="index.php"> Home </a> page and browse through our topics for the information you want.</li>
					  <li> Go to our <a href="#" onclick="history.go(-1);return (!true) ? false : true
;"> previous </a> page and browse through our topics for the information you want.</li>
				</ol>
		</div>
	


</div>  
  <div class="footer"></div>

</body>
</html>
