		<h2 class="fixed_menu_head"></h2>
        <ul>
		<?php 
				//$sqlsub1 = mysql_query("select * from menu_publish where m_flag_id='0' and menu_positions='2' and language_id='1' and approve_status='3' ORDER BY page_postion ASC");
				/*while($data=mysql_fetch_array($sqlsub1))
				{
				if($data['m_url']!=$m_url)
				{
				$class='';
				}
				else
				{
				$class='selected';
				}
				if($data['doc_uplode']!='')
				{
		  	?>
	<li><a href="<?php  echo $HomeURL.'/upload/'.$data['doc_uplode']?>" target="_blank" title="External Link thats open in new window" class="<?php echo $class; ?>" ><?php echo $data['m_name'];?></a></li> 
	
	<?php }

	elseif($data['linkstatus']!='')
				{
		  	?>
	<li><a href="<?php  echo $data['linkstatus']?>"  class="<?php echo $class; ?>"><?php echo $data['m_name'];?></a></li> 
	
	<?php }
	
	else { ?>
	
	<li><a href="<?php echo $HomeURL.'/content/page/'.$data['m_url'];?>" title="<?php echo $data['m_name'];?>" class="<?php echo $class; ?>" ><?php //echo $data['m_name'];?></a></li> 
	*/
	
	 //} } ?>
 <li><a href="<?php echo $HomeURL;?>/auth/discussion_forum.php" title="Discussion Forum">Discussion Forum</a></li>
<li><a href="<?php echo $HomeURL;?>/content/whatsnew.php" title="What's New">What's New</a></li>
<li><a href="<?php echo $HomeURL;?>/content/feedback.php" title="Feedback">Feedback</a></li>

<li><a href="<?php echo $HomeURL;?>/content/gallery.php" title="Photo Gallery">Photo Gallery</a></li>
<li><a href="<?php echo $HomeURL;?>/content/video_gallery.php" title="Video Gallery">Video Gallery</a></li>


             </ul>
              
