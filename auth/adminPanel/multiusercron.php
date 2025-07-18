<?php ob_start();
require_once "../../includes/connection.php";

//update flag_id to 0 if user is inactive till last five minutes
$s_current_active_user=mysql_query("SELECT id,last_access from admin_login where user_status='1' and flag_id='1'");
while($s_data = mysql_fetch_assoc($s_current_active_user))
{
        
        if( $s_data['last_access'] == NULL || $s_data['last_access'] <= (time()-120) )
        {
            mysql_query(" UPDATE admin_login SET `flag_id` = '0' WHERE `id` = '".$s_data['id']."'");
        }
}

