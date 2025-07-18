<?php 

    function get_category_id_by_userid($userid){

        $qry="SELECT category from signup where user_status='1' and id='$userid' ";
        $result=$conn->query($qry);
        $numRows = $result->num_rows;
        if($numRows<1)
        {
            return 0;
        }else
        {
            $result = $result->fetch_assoc();
            return $result['category'];
        }
    }

?>

<ul class="list-group">
<li class="list-group-item"><a href='<?php echo $HomeURL;?>/auth/profile.php' title="Edit Profile">View Profile</a></li>
<li class="list-group-item"><a href='<?php echo $HomeURL;?>/auth/editprofile.php' title="Edit Profile">Edit Profile</a></li>
<?php /*
<li class="list-group-item"><a href='<?php echo $HomeURL;?>/auth/information.php' title="Edit Profile">Information</a></li>
*/ ?>
<li class="list-group-item"><a href='<?php echo $HomeURL;?>/auth/changepassword.php' title="Change Password" class="change-password">Change Password</a></li>
<li class="list-group-item"><a href='<?php echo $HomeURL;?>/auth/logout.php?random=<?php echo $_SESSION['logtoken']; ?>' title="Logout" class="logout">Logout</a></li>
</ul>
                