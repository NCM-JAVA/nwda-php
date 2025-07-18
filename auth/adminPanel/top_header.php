<?php

 $s_user_id=$_SESSION['admin_auto_id_sess']; 
//log out user if it is inactive for last two minutes
	$qry = "SELECT id,last_access,last_sess from admin_login where id='$s_user_id'";
	$result = $conn->query($qry);
	while($s_data = $result->fetch_array()) {

        if( $s_data['last_access'] <= (time()-180) || $s_data['last_sess']!=session_id())
        {
            //$msg="Sorry! You are Inactive for last 2 minute.";
            //$_SESSION['sess_msg'] = $msg;
            //header("Location: index.php");
            //exit;
        }
}
?>

<script>
var log_token = "<?php echo $_SESSION['logtoken']; ?>"; 
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
  
  <div class="logo_row">
        <div class="admin">
			<img src="https://nwda.gov.in/images/emblem.png" style="width:50px;margin-bottom:7px; margin-left: 25px;">
        </div>
		<div class="admin">
            <h1><?php echo $sitename;?> Administration</h1>
        </div>

         <div class="right-links">
                <div class="dates">
                        <div class="date-box">
                                <div class="date-icon"> </div>
                                <div class="date-text"> <?php echo date('d, M y'); ?> </div>
                        </div>
                        <div class="time-box">
                                <div class="time-icon">   </div>
                                <div class="date-text"> <?php echo date('H:i A'); ?> </div>
                        </div>
                        <div class="clear"> </div>
                 </div>
             
                <div class="settings">
                        <ul id="nav">
                                <li class='MenuLi MenuLi1'><a href="#" class='menuFirstNode'><?php echo ucfirst($_SESSION['user_name']); ?> </a>
                                        <ul class='menuSubUl'>
                                                <li class="firstMenuLi editprofile"><a class='firstMenuLiA editprofile' href="editProfile.php" title="Edit Profile">Edit Profile</a></li>
                                                <li class="changepassword"><a href="editpassword.php" title="Change Password" class="change-password">Change Password</a></li>
                                                <li class="logout"><a href="logout.php?random=<?php echo $_SESSION['logtoken']; ?>" title="Logout" class="logouts">Logout</a></li>
                                        </ul>
                                </li>
                        </ul>
                  </div>
         </div>   
        <div class="clear"> </div>
</div>
                    
