<?php
if($_SERVER['REQUEST_URI'])
		{
		 $url=mysqli_real_escape_string($conn, $_SERVER['REQUEST_URI']);  
		 $val=explode('/', $url);
	     $url=$val['4'];
		 $open=$val['3'];
		}
 
  // $aaaaaa="select * from menu_publish where  language_id='1' and m_url = '".$url."'";
 //$sql_aaaa=mysql_query($aaaaaa);
//$row_aaaaa = mysql_fetch_array($sql_aaaa);
 //echo $row_aaaaa['m_id'];
if($m_flag_id > 0)
{
$page_id = $m_flag_id;
}
if($page_id==' ')
{
$page_id = 999999;
}

//echo $page_id;
  $mm="select * from menu_publish where  language_id='1' and menu_positions='2' and approve_status='3' order by page_postion asc";
$sql_main_menu = $conn->query($mm);
$row_main_menu = $sql_main_menu->num_rows;

$nn="select * from menu_publish where language_id='1' and menu_positions='2' and approve_status='3' order by page_postion asc";
$sql_submenu = $conn->query($nn);
$row2 = $sql_submenu->num_rows;

?>

<!--<div class="left-nav">-->
<div class="left-menu-curent">

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
			   	<li class="list-group-item <?php  echo $class; ?>"><a href="<?php echo $HomeURL?>/content/leftpage/<?php echo $rows_mainmenu['m_url'];?>" ><?php echo $rows_mainmenu['m_name'];?></a></li>
				 
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
