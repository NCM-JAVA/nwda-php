<h2><?php echo $title;?></h2>
<p class="notification_shadow"><strong>Department of Empowerment of Persons with Disabilities</strong><br>
Ministry of Social Justice & Empowerment<br>
5th Floor<br>
Paryavaran Bhawan, CGO Complex, Lodhi Road<br>
New Delhi - 110003 (India)</p>

<?php 
$sql_tender=mysql_query("select * from organizationchart where approve_status='3' and language_id='1' and (level='0' or level='1' or level='2' or level='3' or level='4') and name!='*'  order by page_postion ASC");
while($row_tender=mysql_fetch_array($sql_tender)) {?>
<div id="us<?php echo $row_tender['id'];?>" class="contatc-us">
<!--<strong><?php echo $row_tender['ename'];?>&nbsp;</strong>-->

<?php //echo func_org_designation($row_tender['designation']);?> 

<?php  
//$body=html_entity_decode($row_tender['eaddress']);

 $name=html_entity_decode($row_tender['name']);
$designation=func_org_designation($row_tender['designation']);
$phone=html_entity_decode($row_tender['phone']);
$room=html_entity_decode($row_tender['room']);
$email=html_entity_decode($row_tender['email']);

$mobile=html_entity_decode($row_tender['mobile']);
$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

								if(preg_match_all("/$regexp/siU", $email, $matches, PREG_SET_ORDER))
								{
									foreach($matches as $match)
									{

										$phrase  = $match[2];
										$extenM1=substr($match[2],7);
										$healthy = array("_","@",".");
										$yummy   = array("[underscore]","[at]","[dot]");
										$newphrase = str_replace($healthy, $yummy, $extenM1);
										$extenM=substr($match[2],0,6);

										
											$email=str_replace($match[0],$newphrase,$email);
										

										$exten=substr($match[2],-4);
										$startstr=substr($match[2],0,4);

									} // foreach
								}
 //echo $body; ?> 
 <strong><?php echo $name;?></strong><br />
 <?php echo $designation;?><br />
Department of Empowerment of Persons With Disabilities,<br/>
 Ministry of Social Justice Empowerment,<br />
 <?php if($room!='') { ?>
  <strong>Room No. : </strong><?php echo $room;?><br />
  <?php } ?>
  New Delhi - 110003 (India)<br />
  <?php if($phone!='' || $mobile!='') { ?>
  <strong>Phone : </strong> <?php echo $phone;?>(Off.)<br />
 <?php } ?>
  <?php if($email!='') { ?>
  <strong>Email : </strong> <?php echo $email;?>
 <?php } ?>
 

</div>
<?php }?>
<a href="<?php echo $HomeURL;?>/upload/uploadfiles/files/Contactdetailsofofficers.pdf" target="_blank">Department of Empowerment of Persons with Disabilities - Telephone Directory&nbsp;<img alt="Pdf" src="<?php echo $HomeURL;?>/upload/uploadfiles/images/pdf_icon.png"></a>

