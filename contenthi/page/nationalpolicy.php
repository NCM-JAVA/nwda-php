<h2><?php echo $title;?></h2>

<?php  
$date=date('Y-m-d');
$sql_circular=mysql_query("select * from combine_publish where 1  and language_id='1' and cat_id='6' and approve_status='3' and date(end_date) >='$date'");
while($row_circular=mysql_fetch_array($sql_circular))
	{
	 if($row_circular['content_type']=='1'){  ?>
	 
	<?php  $body1=stripslashes(html_entity_decode($row_circular['m_content']));
	 $path='../../';
	    echo type_of_extention_size_file($body1,$HomeURL,$path);?></li>



	 <?php }


		if($row_circular['content_type']=='2'){

			if($row_circular['docs_file']!=''){
			$file='../../upload/'.$row_circular['docs_file'];
			$pdfsize='size:( '.formatFilebytes($file,'MB').')';
			}
			else { $pdfsize='No pdf File Exit' ;} ?>

			<li><?php echo $row_circular['m_short'];?><a href="<?php echo $HomeURL;?>/upload/<?php echo $row_circular['docs_file'];?>" target="_blank" title="<?php echo $row_circular['m_name'];?>">&nbsp;&nbsp;<img src="<?php echo $HomeURL;?>/images/pdf_icon.png" alt="Pdf" height="16"   border='0'/><?php echo $pdfsize;?></a>
			 </li><?php }
		
			if($row_circular['content_type']=='3'){
					
		?>
		<li><?php echo $row_circular['m_short'];?>
		<a href="<?php echo $row_circular['ext_url'];?>" target="_blank" title="Read&nbsp;More">&nbsp;Read&nbsp;More<img src="<?php echo $HomeURL;?>/images/external_link_icon.png" alt="Pdf" height="16"   border='0'/></a>
		 </li><?php }?>
		<?php }?>





