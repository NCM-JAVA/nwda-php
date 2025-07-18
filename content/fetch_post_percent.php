<?php
require_once "../includes/connection.php";
require_once("../includes/config.inc.php");
include("../includes/useAVclass.php");
require_once "../includes/functions.inc.php";

if(isset($_POST['id']) && isset($_POST['grad']))
{
$id=$_POST['id'];
$qual=$_POST['grad'];
echo $data="SELECT * FROM `post_qualification` WHERE `post_id`='$id' and `qualification_id`='$qual'";
$qur1=mysql_query($data);
$data = mysql_fetch_array($qur1, MYSQL_ASSOC);
if($data['percentage']>0)
{
	//echo "SELECT * FROM `p_post_qualification` where `percentage`=0 and `post_id`='$id'";
$query2=mysql_query("SELECT * FROM `p_post_qualification` where `percentage`=0 and `post_id`='$id'");
}
else
{
	//echo "SELECT * FROM `p_post_qualification` where `percentage`<>0 and `post_id`='$id'";
 $query2=mysql_query("SELECT * FROM `p_post_qualification` where `percentage`!=0 and `post_id`='$id'");
}

echo "<option value=''>Select Post Graduation</option>";	 	
while($data2 = mysql_fetch_array($query2, MYSQL_ASSOC))
  {
@extract($data2);
$query3=mysql_query("SELECT `Qualification_list`,`qualification_id` FROM `qualification_mst` WHERE `qualification_id`='$post_qualification_id'");
$data3 = mysql_fetch_array($query3, MYSQL_ASSOC);
@extract($data3);



	?>

<option value="<?php echo $qualification_id;?>" ><?php echo $Qualification_list;?></option>
                              <?php


                          }
}
 

?>