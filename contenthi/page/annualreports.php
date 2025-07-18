<h2><?php echo $title;?></h2>
<ul>
<?php  
$date=date('Y');
$sql_annual=mysql_query("select * from annual_report_publish where 1  and language_id='1' and approve_status='3' and year(end_date) >='$date'");
while($row_annual=mysql_fetch_array($sql_annual))
	{
	if($row_annual['docs_file']!=''){
	$file='../../upload/'.$row_annual['docs_file'];
	$pdfsize='size:( '.formatFilebytes($file,'MB').')';
	}
	else { $pdfsize='No pdf File Exit' ;}
	?>
	<li><?php echo $row_annual['m_short'];?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_annual['docs_file'];?>" target="_blank" title="<?php echo $row_annual['m_name'];?>">&nbsp;&nbsp;<img src="<?php echo $HomeURL;?>/images/pdf_icon.png" alt="Pdf" height="16"   border='0'/><?php echo $pdfsize;?></a></li>
	
  <?php }?>
</ul>


