<div class="main-button">
	<ul class="list-group">
	<?php 
	$sqlquery11="select * from menu_publish where menu_positions='4' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
	$sql1 = $conn->query($sqlquery11);
	$row2 = $sql1->num_rows;
	$m_id=$row['m_id'];
	$k=0;
	while ($rows = $sql1->fetch_array()) { 
		if($rows['m_type']=='1'){ $pageurlh1='<a title="'.$rows['m_name'].'" href="'.$HomeURL.'/contenthi/innerpage/'.$rows['m_url'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='2'){ $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="../upload/'.$rows['doc_uplode'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='3'){ $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="'.$rows['linkstatus'].'">'.$rows['m_name'].'</a>'; }
		if($k==0){
			$class="orange";
		}
		elseif($k==1){
			$class="blue";
		}
		elseif($k==2){
			$class="yellow";
		}
		elseif($k==3){
			$class="green";
		}
		else{
			$class="orange";
		}
	?>
		<li class="<?php echo $class;  ?>"><?php echo $pageurlh1;?></li>
	<?php $k++; }   ?>						
		<li class="list-group-item-2"><a href="https://www.mygov.in/" target="_blank" title="mygov" onclick="return confirm('This is external link, Are you sure you want to continue?');"><img src="<?php echo $HomeURL?>/images/mygov.png" alt="mygov"></a>
		<a href="https://www.india.gov.in/" target="_blank" title="India Gov"  onclick="return confirm('This is external link, Are you sure you want to continue?');"><img src="<?php echo $HomeURL?>/images/india-gov-in.png" width="117px;" title="india-gov" alt="india-gov"></a></li>		
	</ul>
</div>
