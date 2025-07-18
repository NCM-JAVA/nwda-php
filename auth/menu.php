<div class="welcome-page">
       <!-- <span><h3>Welcome <?php echo $_SESSION['login_user'];?></h3></span>  -->
</div>

<div id="parent" class="welcome_menu">
<a  class="setting_button" href="profile.php" title="Profile"><img src="<?php echo $HomeURL;?>/images/setting-icon.png" width="15" height="14" alt="Setting-Icon" style="margin-top: 20px; margin-left:45px;"></a>
         <ul id="popup" style="display: none" class="pop_memu">
           <li><a href='<?php echo $HomeURL;?>/auth/editprofile.php' title="Edit Profile">Edit Profile</a></li>
           <li><a href='<?php echo $HomeURL;?>/auth/changepassword.php' title="Change Password" class="change-password">Change Password</a></li>
           <li><a href='<?php echo $HomeURL;?>/auth/logout.php?random=<?php echo $_SESSION['logtoken']; ?>' title="Logout" class="logout">Logout</a></li>
         </ul>
</div>


<script type="text/javascript">

var e = document.getElementById('parent');
e.onmouseover = function() {
  document.getElementById('popup').style.display = 'block';
}
e.onmouseout = function() {
  document.getElementById('popup').style.display = 'none';
}

</script>