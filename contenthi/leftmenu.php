<ul class="list-group">
<?php  
$sqlfront="select * from menu_publish where menu_positions='2' and approve_status='3' and language_id='2' order by page_postion asc limit 0,12";
$resfront = $conn->query($sqlfront);
$k=1;
while($rowfront= $resfront->fetch_array()) 
{
 ?>
					<li class="list-group-item"><a href="<?php echo $HomeURL;?>/contenthi/leftpage/<?php echo $rowfront['m_url']; ?>" title="<?php echo strtoupper($rowfront['m_name']);?>"><?php echo $rowfront['m_name'];?></a></li>
							
<?php   $k++; }  ?>								
								<!-- <li class="list-group-item"><a href="https://www.mygov.in/" target="_blank" title="mygov"><img src="<?php echo $HomeURL?>/images/mygov.png" alt="mygov"></a>
								<a href="https://india.gov.in/" target="_blank"><img src="<?php echo $HomeURL?>/images/india-gov-in.png" width="117px;" title="india-gov" alt="india-gov"></a></li> -->
							</ul>
