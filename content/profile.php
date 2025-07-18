<?php
 $sqlprofile="select * from home_page_publish  where approve_status='3' and m_type='1' and language_id='1' order by m_id asc";
$resprofile=$conn->query($sqlprofile) or die(mysql_error());
$Totalrows=$resprofile->num_rows;
if($Totalrows>=2)
{
while($rowprofile = $resprofile->fetch_array())
{
$newimg_uplode = $rowprofile['image_file'];
 $image_path = $HomeURL.'/upload/profile/'.$newimg_uplode;
?>

<div class="profile">
								<a href="https://jalshakti-dowr.gov.in/" target="_blank"><img src="<?php echo $image_path?>" width="83" height="103" style="border:2px solid #ddd; border-radius:5px;" alt="image of <?php echo $rowprofile['m_name']; ?>" title="<?php echo $rowprofile['m_name']; ?>">
								<p><b><?php echo $rowprofile['m_name']; ?></b></p>
								<p><?php echo $rowprofile['designation'];    ?>
<?php  //echo substr($rowprofile['short_desc'],0,60);  ?></p></a>
								</div>
<?php } 
} else {
 	
while($rowprofile = $resprofile->fetch_array())
{
$newimg_uplode = $rowprofile['img_uplode'];
 $image_path = $HomeURL.'/upload/profile/'.$newimg_uplode;
?>

<div class="profile">
								<img src="<?php echo $image_path?>" width="83" height="103" alt="iage of <?php echo $rowprofile['m_name'];    ?>" title="<?php echo $rowprofile['m_name'];    ?>">
								<p><b><?php echo $rowprofile['m_name'];    ?></b>
								<p><?php echo $rowprofile['designation'];    ?><br>
<?php  echo substr($rowprofile['content'],0,350);  ?></p>
								</div>
<?php } 
}  ?>							