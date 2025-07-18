<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";
if(isset($_POST['id']))
{
$id=$_POST['id'];
 echo $query="SELECT `Qualification_list`,`qualification_id` FROM `qualification_mst` WHERE `qualification_id`in(SELECT `qualification_id` FROM `post_qualification` WHERE `post_id`='$id' order by `Qualification_list`)";
$res=mysql_query($query);
echo "<option value='' >Select Graduation</option>";
while($data = mysql_fetch_array($res, MYSQL_ASSOC))
  {
@extract($data);

                              ?>
                               <option value="<?php echo $qualification_id;?>"><?php echo $Qualification_list;?></option>
                              <?php
   
   }
  } 

?>