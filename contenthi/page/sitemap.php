
<div class="about-us-heading">

<div id="sitemap">
		  <h2>Top Navigation</h2>
          <ul>

            <li id="Link1"><a title="Home" href="<?php echo $HomeURL.'/content';?>"><span><strong>Home</strong></span></a></li>

			<?php  $sql=mysql_query("select * from menu_publish where m_flag_id='0' and menu_positions='1' and language_id='1' and approve_status='3'  ORDER BY page_postion ASC limit 0,10");
$i=2;
while($row=mysql_fetch_array($sql))
	{
		$sql1=mysql_query("select * from menu_publish where m_flag_id='".$row['m_publish_id']."' and menu_positions='1' and language_id='1' and approve_status='3' ORDER BY page_postion ASC");
		 $row2=mysql_num_rows($sql1);
		?>
		<li class="trigger" id="Link<?php echo $i;?>"><a title="<?php echo $row['m_name'];?>" class="<?php echo $act;?>" href="<?php echo $HomeURL.'/content/page/'.$row['m_url'];?>"><span><strong><?php echo $row['m_name'];?></strong></span></a>
        <?php if($row2 > 0)
		{
		?>
  <ul class='menuSubUl'><?php  while($rows=mysql_fetch_array($sql1))
		{
			$sql2=mysql_query("select * from menu_publish where m_flag_id='".$rows['m_publish_id']."' and menu_positions='1' and language_id='1' and approve_status='3' ORDER BY page_postion ASC");
		 $row3=mysql_num_rows($sql2);
		?>
<li><a title="<?php echo $rows['m_name'];?>" href="<?php echo $HomeURL.'/content/page/'.$rows['m_url'];?>"><?php echo $rows['m_name'];?></a>
 <?php if($row3 > 0)
		{
		?>
  <ul class='menuSubUl'><?php  while($rowss=mysql_fetch_array($sql2))
		{
		?>
<li><a title="<?php echo $rowss['m_name'];?>" href="<?php echo $HomeURL.'/content/page/'.$rowss['m_url'];?>"><?php echo $rowss['m_name'];?></a></li>
<?php }?>
            </ul>
            <?php }?>
</li>
<?php }?>
            </ul>
            <?php }?>
            </li>
        <?php 
	$i++;  } ?>           

	</ul>
  <h2>Middle Menu</h2>
				<ul>
					<?php  $sql=mysql_query("select * from menu_publish where m_flag_id='0' and menu_positions='2' and language_id='1' and approve_status='3'  ORDER BY page_postion ASC limit 0,10");
$i=2;
while($row=mysql_fetch_array($sql))
	{
	if($row['m_type']=='1'){ $pageurlm='<a title="'.$row['m_name'].'" href="'.$HomeURL.'/content/page/'.$row['m_url'].'">'.$row['m_name'].'</a>'; }
	if($row['m_type']=='3'){  $pageurlm='<a title="'.$row['m_name'].'" target="_blank" href="'.$row['linkstatus'].'">'.$row['m_name'].'</a>'; }?>
		<li><?php echo $pageurlm;?> </li>
		<?php }?>
	</ul>

  <h2>Left Menu</h2>
				<ul>
		<li><a href="<?php echo $HomeURL;?>/content/circular.php" title="Important Circular">Important Circular</a></li>
		<li><a href="<?php echo $HomeURL;?>/content/events.php" title="Events">Events</a></li>
		<li><a href="<?php echo $HomeURL;?>/content/feedback.php" title="Feedback">Feedback</a></li>
		<li><a href="<?php echo $HomeURL;?>/content/photo_gallery.php" title="Photo Gallery">Photo Gallery</a></li>
		<li><a href="<?php echo $HomeURL;?>/content/video_gallery.php" title="Video Gallery">Video Gallery</a></li>
		<li><a href="<?php echo $HomeURL;?>/content/important_links.php" title="Important Links">Important Links</a></li>
	</ul>
          <h2>Footer Menu</h2>
				<ul>
			<?php  $sql=mysql_query("select * from menu_publish where m_flag_id='0' and menu_positions='3' and language_id='1' and approve_status='3'  ORDER BY page_postion ASC limit 0,8 ");
$i=2;
while($row=mysql_fetch_array($sql))
	{
		if($row['m_type']=='1'){ $pageurlm='<a title="'.$row['m_name'].'" href="'.$HomeURL.'/content/page/'.$row['m_url'].'">'.$row['m_name'].'</a>'; }
	if($row['m_type']=='3'){  $pageurlm='<a title="'.$row['m_name'].'" target="_blank" href="'.$row['linkstatus'].'">'.$row['m_name'].'</a>'; }
		?>
		<li><?php echo  $pageurlm;?></li>

	<?php } ?>
     
	</ul>
</div>
<div class="clear"> </div>
</div>
            

           