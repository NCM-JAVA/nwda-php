<h2><?php echo $title;?></h2>
<ul>
<?php  
$date=date('Y-m-d');
$sql_awards=mysql_query("select * from combine_publish where 1  and language_id='1' and cat_id='5' and approve_status='3' and date(end_date) >='$date'");
while($row_awards=mysql_fetch_array($sql_awards))
	{
	if($row_awards['image_file'] !=''){
$image=$HomeURL.'/upload/photogallery/'.$row_awards['image_file'];
 }else { $image=$HomeURL.'/images/no-image.jpg'; }
	 if($row_awards['content_type']=='1'){?> <li><?php  $body1=stripslashes(html_entity_decode($row_circular['m_content']));
	   echo type_of_extention_size_file($body1,$HomeURL);?></li>
	 <?php }
		if($row_awards['content_type']=='2'){
			if($row_awards['docs_file']!=''){
	$file='../../upload/'.$row_awards['docs_file'];
	$pdfsize='size:( '.formatFilebytes($file,'MB').')';
	}
	else { $pdfsize='No pdf File Exit' ;}	
		?>
			<li>
<div class="description-name"><?php echo $row_awards['m_short'];?><a href="<?php echo $HomeURL;?>/upload/<?php echo $row_awards['docs_file'];?>" target="_blank" title="<?php echo $row_awards['m_name'];?>">&nbsp;&nbsp;<img src="<?php echo $HomeURL;?>/images/pdf_icon.png" alt="Pdf" height="16"   border='0'/><?php echo $pdfsize;?></a></div>
<div class="v-all"><a href="<?php echo $HomeURL;?>/content/photo_gallery.php" title="Photo Gallery">Photo Gallery</a></div>
<div class="clear"> </div></li><?php }
		if($row_awards['content_type']=='3'){ ?>
		<li>
<div class="description-name"><?php echo $row_awards['m_short'];?></div>
<div class="v-all"><a href="<?php echo $row_awards['ext_url'];?>" target="_blank" title="Read&nbsp;More">&nbsp;Read&nbsp;More<img src="<?php echo $HomeURL;?>/images/external_link_icon.png" alt="Pdf" height="16"   border='0'/></a></div>
<div class="clear"> </div></li><?php }?>
  <?php 
	}?>
</ul>
