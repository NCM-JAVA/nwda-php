<?php
if($_SERVER['REQUEST_URI'])
		{
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']); 
		 $val=explode('/', $url);
	     $url=$val['4'];
		 $open=$val['3'];
		}

if($m_flag_id > 0)
{
$page_id = $m_flag_id;
}
if($page_id=='')
{
$page_id = 999999;
}

  $mm="select * from menu_publish where  language_id='2' and menu_positions='2' order by page_postion asc";
 $sql_main_menu = $conn->query($mm);
$row_main_menu = $sql_main_menu->num_rows;

$nn="select * from menu_publish where language_id='2' and menu_positions='2' order by page_postion asc";
$sql_submenu = $conn->query($nn);
$sub_row2 = $sql_submenu->num_rows;

?>

<div class="left-nav">
 <?php if($url!='view_all_news.php') { ?>

			<ul>
			
			
			<?php
			while ($rows_mainmenu = $sql_main_menu->fetch_array()) 
				{
				
				if($rows_mainmenu['m_url']==$url)
				{
				$class="selected";
				}
				//TopMost Menu
			?>
			   	<li class="list-group-item <?php  echo $class; ?>"><a href="<?php echo $HomeURL?>/contenthi/leftpage/<?php echo $rows_mainmenu['m_url'];?>" ><?php echo $rows_mainmenu['m_name'];?></a></li>
				 
			<?php
				}
			?>
			
			
			</ul>
			
			<?php  } ?>
			
</div>

<div class="top-main">
				<div class="main-menu">
				<?php include("../mainmenu.php");?>
				</div>
</div>
