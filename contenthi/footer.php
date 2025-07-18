<style>
.certification-cont {
	display: flex;
	align-items: center;
}
.certification-cont strong {
	color: #f1faff;
	font-weight: 600;
	display: block;
	max-width: 80px;
	font-size: 14px;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-2">
			<?php
				$sqlprofile="SELECT COUNT('visitors_id') as counter  FROM  visitors";
				$resprofile = $conn->query($sqlprofile);
				$row = $resprofile->fetch_array();
				$counter=$row['counter'];
			?>
			<p>आगन्‍तुक काउंटर :<?php echo $counter; ?></p>
		</div>
		<div class="col-md-8">
			<ul class="list-inline">
				<?php 
					$sqlq="select * from menu_publish where m_flag_id='0' and menu_positions='3' and language_id='2' and approve_status='3' ORDER BY page_postion ASC";
					$sqlsub1 = $conn->query($sqlq);
					while($data= $sqlsub1->fetch_array()){
						if($data['m_url']!=$m_url){
							$class='';
						}else{
							$class='selected';
						}
						if($data['doc_uplode']!=''){
				?>
				<li><a href="<?php  echo $HomeURL.'/upload/'.$data['doc_uplode']?>" target="_blank" title="External Link thats open in new window" class="<?php echo $class; ?>" ><?php echo $data['m_name'];?></a></li> 
				<?php }elseif($data['linkstatus']!=''){?>
				<li><a href="<?php  echo $data['linkstatus']?>"  class="<?php echo $class; ?>"><?php echo $data['m_name'];?></a></li> 
				<?php }else { ?>
				<li><a href="<?php echo $HomeURL.'/contenthi/innerpage/'.$data['m_url'];?>" title="<?php echo $data['m_name'];?>" class="<?php echo $class; ?>" ><?php echo $data['m_name'];?></a></li> 
				<?php } } ?> 
			</ul>
			<p>वेबसाइट रा.ज.वि.अ. के स्वामित्व में है और एनआईसी द्वारा होस्ट की गई है. रा.ज.वि.अ. द्वारा जानकारी उपलब्ध एवं उघतन की जाती है। <br>कॉपीराइट @ रा.ज.वि.अ</p>
		</div>
		<div class="col-md-2">
			<?php  
			$sqlq="SELECT page_action_date FROM  audit_trail ORDER BY  page_action_date DESC LIMIT 0,1";
			$sqlsub1 = $conn->query($sqlq);
			$row= $sqlsub1->fetch_array();
			$date=explode(' ',$row['page_action_date']);
			$m=explode('-',$date[0]);
			$d=$m[0];
			$d1=$m[1];
			$d2=$m[2];
			?>
			<p>आखिरी अपडेट : <?php echo $d2.'-'.$d1.'-'.$d;?></p>
			<div class="certification-cont">
				<a title="गुणवत्ता प्रमाणित वेबसाइट" href="https://nwda.gov.in/upload/uploadfiles/files/STQC.pdf" target="_blank" rel="noopener noreferrer">
					<img src="https://nwda.gov.in/assets/images/certified-logo.png" alt="गुणवत्ता प्रमाणित वेबसाइट" width="60">
				</a>
				<a title="गुणवत्ता प्रमाणित वेबसाइट" href="https://nwda.gov.in/upload/uploadfiles/files/STQC.pdf" target="_blank" rel="noopener noreferrer"><strong>गुणवत्ता प्रमाणित वेबसाइट</strong></a>
			</div> 
		</div>
	</div>
</div>
