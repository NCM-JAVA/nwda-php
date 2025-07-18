<ul class="list-inline" id="nav">
				<li><a href="<?php echo $HomeURL; ?>/content/index.php" title="home">Home</a></li>
				<?php
			    $sqlquery="select * from menu_publish where m_flag_id='0'  and menu_positions='1' and menu_positions!='5' and language_id='2' and approve_status='3'  ORDER BY page_postion ASC limit 0,8";
				$sql = mysql_query($sqlquery); 
			$count=mysql_num_rows($sql);
				$i = 1;
				while ($row = mysql_fetch_array($sql)) {
				$sqlquery11="select * from menu_publish where m_flag_id='".$row['m_publish_id']."' and menu_positions!='5' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
				$sql1 = mysql_query($sqlquery11);
				 $row2 = mysql_num_rows($sql1);
				$m_id=$row['m_id'];
				?>
					<li><a title="<?php echo $row['m_nfame'];?>" href="<?php echo $HomeURL;?>/content/innerpage/<?php echo $row['m_url']; ?>"><?php echo  $row['m_name'];?></a>
                     <?php if($row2>0 ) {  ?>
					<ul>
					 <?php while ($rows = mysql_fetch_array($sql1)) { 
                $sqlquery22="select * from menu_publish where m_flag_id='".$rows['m_publish_id']."' and menu_positions!='5' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
				$sql2 = mysql_query($sqlquery22);
			    $row3 = mysql_num_rows($sql2);
				$m_id=$row2['m_id']; 
				
				if($rows['m_type']=='1'){ $pageurlh1='<a title="'.$rows['m_name'].'" href="'.$HomeURL.'/content/innerpage/'.$rows['m_url'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='2'){ $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="../upload/'.$rows['doc_uplode'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='3'){  $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="'.$rows['linkstatus'].'">'.$rows['m_name'].'</a>'; }
                   
                    
					 ?>
						<li class="<?php if($row3>0) { ?>has-sub<?php  } ?>"><?php echo $pageurlh1;?>
						<?php if($row3>0 ) {  ?>
						<ul>
						<?php while ($rowssub = mysql_fetch_array($sql2)) { 

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
