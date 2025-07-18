<?php
	if($_SERVER['REQUEST_URI']){
		$url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
		$val=explode('/', $url);
		$url=$val['4'];
		$open=$val['3'];
	}
	if($open=='circulars.php'){	
		$page_id='6';
	}

	if($open=='tenders.php'){	
		$page_id='7';
	}
	if($m_flag_id > 0){
		$page_id = $m_flag_id;
	}
	if($page_id==''){
		$page_id = 999999;
	}
	$page='content';
	if($page_id!='0' && $page_id!=''){
		$method="mapping";
	}
	
	$mm="select * from menu where  language_id='2' and approve_status='3' and menu_positions!='5' and menu_positions!='4' and m_id = '".$page_id."' order by page_postion asc";
	$sql_main_menu = $conn->query($mm);
	$row_main_menu = $sql_main_menu->num_rows;

	$nn="select * from menu where language_id='2' and approve_status='3' and menu_positions!='5' and menu_positions!='4' and  m_flag_id='".$page_id."' order by page_postion asc";
	$sql_submenu = $conn->query($nn);
	$sub_row2 = $sql_submenu->num_rows;
?>
<script language="javascript">
$(document).ready(function(){
  var lastid =  $(".last:last").text();
});
</script>


<div class="nav-side-menu">
	<div class="menu-list">
		<ul id="menu-content" class="menu-content">
			<?php  	
			while ($rows_mainmenu = $sql_main_menu->fetch_array()) 	{
				if($rows_mainmenu['m_url']==$url) 	{
					$class="active";
				}
			?>
			<li class="<?php  echo $class; ?>">
				<a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_mainmenu['m_url'];?>"> <?php echo $rows_mainmenu['m_name'];?></a>
			</li>
			<?php }
				while ($rows_submenu = $sql_submenu->fetch_array()) {
					if($rows_submenu['m_url']==$url) {
						$class="active";
					}else {
						$class="";
					}
					$sqldata="select * from menu where  language_id='2' and approve_status='3' and m_flag_id = '".$rows_submenu['m_id']."' order by page_postion asc";
					$sqlNew = $conn->query($sqldata);
					$numrows = $sqlNew->num_rows;

					if($numrows > 0){
						$class2="has-sub";
					}
					if($rows_submenu['m_type']=='1'){ $pageurlh1='<a title="'.$rows_submenu['m_name'].'" href="'.$HomeURL.'/contenthi/innerpage/'.$rows_submenu['m_url'].'">'.$rows_submenu['m_name'].'</a>'; }
					if($rows_submenu['m_type']=='2'){ $pageurlh1='<a title="'.$rows_submenu['m_name'].'" target="_blank" href="../upload/'.$rows_submenu['doc_uplode'].'">'.$rows_submenu['m_name'].'</a>'; }
					if($rows_submenu['m_type']=='3'){  $pageurlh1='<a title="'.$rows_submenu['m_name'].'" target="_blank" href="'.$rows_submenu['linkstatus'].'">'.$rows_submenu['m_name'].'</a>'; }
			?>
			<li data-toggle="collapse" data-target="#<?php echo $rows_submenu['m_id'];?>" class="collapsed <?php echo $class; ?>">
			<?php echo  $pageurlh1; ?>
			<?php  
			if($numrows > 0)
			{ ?>
			<span class="arrow"></span>
			<?php 
			} ?>
			</li>
			<?php if($numrows > 0) { 	?>
			<ul class="sub-menu collapse" id="<?php echo $rows_submenu['m_id'];?>">
				<?php
				}
				while ($rows_submenu2 = $sqlNew->fetch_array())	
				{
					$sqlquery22="select * from menu_publish where m_flag_id='".$rows_submenu2['m_id']."' and menu_positions!='5' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
					$sql_sub2 = $conn->query($sqlquery22);
					$row3 = $sql_sub2->num_rows;
				?>
				<li data-toggle="collapse" data-target="#<?php echo $rows_submenu2['m_id'];?>"  class="collapsed <?php echo $class; ?>"><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_submenu2['m_url'];?>" style="padding-left: 22px;"> <?php echo $rows_submenu2['m_name'];?></a>
				<?php  
				if($row3 > 0)
				{ ?>
				<span class="arrow"></span>
				<?php 
				} ?>
				</li>
				<?php if($row3>0) { ?>
				<ul class="sub-menu collapse" id="<?php echo $rows_submenu2['m_id'];?>">
				<?php } while ($rows_sub3 =  $sql_sub2->fetch_array()){ ?>
					<li  class="<?php  echo $class; ?>" ><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_sub3['m_url'];?>" style="padding-left: 22px;"> <?php echo $rows_sub3['m_name'];?></a></li>
				<?php	} if($row3>0){ ?>
				</ul>  
				<?php } }   if($numrows > 0){ ?>
			</ul>
			<?php } }?>
		</ul>
	</div>
</div>











<div class="left-menu-curent">
	<ul>
	<?php
	while ($rows_mainmenu = $sql_main_menu->fetch_array()){
		if($rows_mainmenu['m_url']==$url){
			$class="selected";
		}
	?>
		<li class="list-group-item <?php  echo $class; ?>" align="center"><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_mainmenu['m_url'];?>" ><?php echo $rows_mainmenu['m_name'];?>  </a></li>
		<?php }
			while ($rows_submenu = $sql_submenu->fetch_array()){
				if($rows_submenu['m_url']==$url){
					$class="selected";
				}else{
					$class="";
				}
			$sqldata="select * from menu where  language_id='2' and approve_status='3' and m_flag_id = '".$rows_submenu['m_id']."' order by page_postion asc";
			$sqlsub1 = $conn->query($sqlq);
			$numrows = $sqlsub1->num_rows;

			if($numrows > 0){
				$class2="has-sub";
			}
		?>
		<li class="list-group-item  <?php  echo $class; ?> <?php if($numrows>0) { ?>has-sub<?php  } ?>" ><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_submenu['m_url'];?>"><?php echo $rows_submenu['m_name'];?></a>
	<?php
	if($numrows > 0)
	{
	?>
	<ul>
	<?php
	}
	while ($rows_submenu2 = $sqlNew->fetch_array())	
	{
	$sqlquery22="select * from menu_publish where m_flag_id='".$rows_submenu2['m_id']."' and menu_positions!='5' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
	$sql_sub2 = mysqli_query($conn, $sqlquery22);
	$row3 = mysqli_num_rows($sql_sub2);
	?>
	<li  class="list-group-item  <?php  echo $class; ?> <?php if($row3>0) { ?>has-sub<?php  } ?>"><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_submenu2['m_url'];?>" style="padding-left: 22px;"> <?php echo $rows_submenu2['m_name'];?></a>
	<ul>
	<?php 
	while ($rows_sub3 = mysqli_fetch_array($sql_sub2)) { 
	?>
	<li  class="list-group-item <?php  echo $class; ?>" ><a href="<?php echo $HomeURL?>/contenthi/innerpage/<?php echo $rows_sub3['m_url'];?>" style="padding-left: 22px;"> <?php echo $rows_sub3['m_name'];?></a></li>
	<?php	}  ?>
	</ul>  
	<?php   }   ?> 
	</li>
	<?php	if($numrows > 0)
	{
	?>
	</ul>
	<?php
	}
	?>	
	</li>

	<?php		
	}
	?>
	</ul>
</div>

























<ul class="list-group">
<?php  
$sqlfront="select * from menu_publish where menu_positions='2' and approve_status='3' and language_id='2' order by page_postion asc";
$resfront = $conn->query($sqlfront);
$k=1;
while($rowfront = $resfront->fetch_array())	
{
 ?>
					<li class="list-group-item"><a href="<?php echo $HomeURL;?>/contenthi/leftpage/<?php echo $rowfront['m_url']; ?>" title="<?php echo strtoupper($rowfront['m_name']);?>"><?php echo $rowfront['m_name'];?></a></li>
							
<?php   $k++; }  ?>								
								<li class="list-group-item"><a href="https://www.mygov.in/" target="_blank" title="mygov"><img src="<?php echo $HomeURL?>/images/mygov.png" alt="mygov"></a>
								<a href="https://india.gov.in/" target="_blank"><img src="<?php echo $HomeURL?>/images/india-gov.png" title="india-gov" alt="india-gov"></a></li>
							</ul>
