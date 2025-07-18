   
	<div id="main-nav" class="navigation-bg">
		<nav>
			<div>
				<ul class="clearfix sf-menu" id="example">
					<li><a href="<?php echo $HomeURL; ?>/content/index.php" title="home">Home</a></li>
				<?php
			  /*   $sqlquery="select * from menu_publish where m_flag_id='0'  and menu_positions='1' and language_id='1' and approve_status='3'  ORDER BY page_postion ASC limit 0,9";
				$sql = mysql_query($sqlquery); 
			$count=mysql_num_rows($sql); */
				 
			 	$sqlquery="select * from menu_publish where m_flag_id='0'  and menu_positions='1' and language_id='1' and approve_status='3'  ORDER BY page_postion ASC limit 0,10";
			$result = $conn->query($sqlquery);
				$i = 1;

				while($row = $result->fetch_array()) {
				$sqlquery11="select * from menu_publish where m_flag_id='".$row['m_publish_id']."' and menu_positions='1' and language_id='1' and approve_status='3' ORDER BY page_postion ASC";
				$sql1 = $conn->query($sqlquery11);
				 $row2 = $sql1->num_rows;
				$m_id=$row['m_id'];
				
				?>
					<li><a title="<?php echo $row['m_nfame'];?>" href="<?php echo $HomeURL;?>/content/innerpage/<?php echo $row['m_url']; ?>"><?php echo  $row['m_name'];?></a>
                     <?php if($row2>0 ) {  ?>
					<ul>
					 <?php while($rows = $sql1->fetch_array()) {
                $sqlquery22="select * from menu_publish where m_flag_id='".$rows['m_publish_id']."' and menu_positions='1' and language_id='1' and approve_status='3' ORDER BY page_postion ASC";
				$sql2 = $conn->query($sqlquery22);
			    $row3 = $sql2->num_rows;
				$m_id=$row2['m_id']; 
				
				if($rows['m_type']=='1'){ $pageurlh1='<a title="'.$rows['m_name'].'" href="'.$HomeURL.'/content/innerpage/'.$rows['m_url'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='2'){ $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="../upload/'.$rows['doc_uplode'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='3'){  $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="'.$rows['linkstatus'].'" onClick="return sitevisit()">'.$rows['m_name'].'</a>'; }
                   
                    
					 ?>
						<li class="<?php if($row3>0) { ?>has-sub<?php  } ?>"><?php echo $pageurlh1;?>
						<?php if($row3>0 ) {  ?>
						<ul>
						<?php while ($rowssub =$sql2->fetch_array()) {

if($rowssub['m_type']=='1'){ $pageurlh2='<a title="'.$rowssub['m_name'].'" href="'.$HomeURL.'/content/innerpage/'.$rowssub['m_url'].'">'.$rowssub['m_name'].'</a>'; }
		if($rowssub['m_type']=='2'){ $pageurlh2='<a title="'.$rowssub['m_name'].'" target="_blank" href="../upload/'.$rowssub['doc_uplode'].'">'.$rowssub['m_name'].'</a>'; }
		if($rowssub['m_type']=='3'){  $pageurlh2='<a title="'.$rowssub['m_name'].'" target="_blank" href="'.$rowssub['linkstatus'].'">'.$rowssub['m_name'].'</a>'; }
						?>
								<li><?php echo $pageurlh2;?></li>
						<?php }  ?>		
						</ul>
                        <?php  }  ?>							
						</li>
							
					<?php  } ?>
						
						
     
				    </ul>
					<?php  }  ?>
					</li>
					
			<?php $i++;} ?>
				</ul>
				
			</div>
		</nav>
	</div>
    <!-- Menu Part End --> 

	<script>

function sitevisit()
{
	var returnvalue = confirm("This is an external link.Do you want to continue.");
	if(returnvalue == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function sitevisit1()
{
	var returnvalue = confirm("If you want to access this link then you must have NIC Internet. If you have then click on Ok");
	if(returnvalue == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>