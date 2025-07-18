<?php if($_SERVER['REQUEST_URI'])
		{
		 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
		 $url=$val['4'];
		$open=$val['3'];
		}
?>
<?php if($open=='viewpage') { ?>
<h2>What's News</h2>
<?php } else if($open=='page') { ?>
<h2><?php echo $m_name;?></h2>

<?php } else { }?>
<?php if($position==1) { ?>
<ul>
<?php 
$sql=mysql_query("SELECT * FROM menu_publish where language_id='2' and  m_flag_id='".$rootid2."' and approve_status='3' and menu_positions='1' and menu_positions!='3' ORDER BY page_postion ASC");
$numrows=mysql_num_rows($sql);
				while($data=mysql_fetch_array($sql))
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
	
	<li><a href="<?php echo $HomeURL.'/content/page/'.$data['m_url'];?>" title="<?php echo $data['m_name'];?>" class="<?php echo $class; ?>" ><?php echo $data['m_name'];?></a></li> 
	
	
	
	<?php } } ?>
 <!--</ul>-->
<?php } else  {
		
	if($_SERVER['REQUEST_URI'])
		{
			 $url=mysql_real_escape_string($_SERVER['REQUEST_URI']); 
			 $val=explode('/', $url);
			 $open=$val['3'];
	
			if($open=='skill.php')
	
			{?>

<!--			<h4>Skill Development for PwDs</h4> -->

			<?php }
		}
	}
	?>
		
	
	
