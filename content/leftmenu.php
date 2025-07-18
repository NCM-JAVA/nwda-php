<ul class="list-group">
  <?php  
$sqlfront="select * from menu_publish where menu_positions='2' and approve_status='3' and language_id='1' order by page_postion asc limit 0,15";
$resfront=$conn->query($sqlfront) or die(mysql_error());
$k=1;
while($rowfront=$resfront->fetch_array())
{
 ?>
  <li class="list-group-item"><a href="<?php echo $HomeURL;?>/content/leftpage/<?php echo $rowfront['m_url']; ?>" title="<?php echo strtoupper($rowfront['m_name']);?>"><?php echo $rowfront['m_name'];?></a></li>
  <?php   $k++; }  ?>
</ul>
