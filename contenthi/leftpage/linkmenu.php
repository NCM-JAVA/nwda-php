<div class="main-button">
													
												<ul class="list-group">
									<?php 
							// echo $HomeURL;
									$sqlquery11="select * from menu_publish where menu_positions='4' and language_id='1' and approve_status='3' ORDER BY page_postion ASC limit 0,3";
				$sql1 = mysql_query($sqlquery11);
				 $row2 = mysql_num_rows($sql1);
				$m_id=$row['m_id'];
				$k=0;
									while ($rows = mysql_fetch_array($sql1)) { 

				if($rows['m_type']=='1'){ $pageurlh1='<a title="'.$rows['m_name'].'" href="'.$HomeURL.'/content/innerpage/'.$rows['m_url'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='2'){ $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="../upload/'.$rows['doc_uplode'].'">'.$rows['m_name'].'</a>'; }
		if($rows['m_type']=='3'){  $pageurlh1='<a title="'.$rows['m_name'].'" target="_blank" href="'.$rows['linkstatus'].'">'.$rows['m_name'].'</a>'; }
                   
				   if($k==0)
				   {
				   $class="orange";
				   }
				   elseif($k==1)
				   {
				    $class="blue";
				   }
				   elseif($k==2)
				   {
				    $class="yellow";
				   }
				   elseif($k==3)
				   {
				    $class="green";
				   }
				   else
				   {
				    $class="orange";
				   }
                    
					 ?>
											<li class="<?php echo $class;  ?>"><?php echo $pageurlh1;?></li>
											<!--<li class="blue"><a href="#" title="#">ILR in Parliament</a></li>
											<li class="yellow"><a href="#" title="#">ILR in Parliament</a></li>
											<li class="green"><a href="#" title="#">ILR in Parliament</a></li>-->
					<?php $k++; }   ?>						
										</ul>
										
										
										
										
						<a href="#" style="float:right; color:#fff;">View All</a>				
										
										
						
							<li class="list-group-item"><a href="https://www.mygov.in/" target="_blank" title="mygov"><img src="<?php echo $HomeURL?>/images/mygov.png" alt="mygov"></a>
								<a href="https://india.gov.in/" target="_blank"><img src="<?php echo $HomeURL?>/images/india-gov-in.png" width="117px;" title="india-gov" alt="india-gov"></a></li>		
										
										
										
										
										
										
										
										
										
										
									</div>
							