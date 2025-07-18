
<!--<caption><h2>Tender / Advertisement</h2></caption>

<ul>
<?php  
$date=date('Y-m-d');
$sql_tender=mysql_query("select * from combine_publish where cat_id='4' and language_id='1' and approve_status='3' and date(end_date) >='$date'");
$num_rows=mysql_num_rows($sql_tender);
if($num_rows>0)
{
while($row_tender=mysql_fetch_array($sql_tender))
	{
	if($row_tender['docs_file']!=''){
	$file='../../upload/'.$row_tender['docs_file'];
	$pdfsize='size:( '.formatFilebytes($file,'MB').')';
	}
	else { $pdfsize='No pdf File Exit' ;}
	?>
	 <li>
    <?php echo $row_tender['m_short'];?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>">&nbsp;&nbsp;<img src="<?php echo $HomeCss;?>/images/pdf_icon.png" alt="Pdf" height="16" /><?php echo $pdfsize;?></a></li>
    
 
  <?php }
  } else{ ?>
<li><td colspan="3" class="even" >No records found.</li>
<?php	}?>
 </ul>-->
 
<caption><h2>Tender / Advertisement</h2></caption>

<table>
  <tbody>

  <tr>
    <th class="tender-name">Title</th>
    <!--<th class="tender-startdate">Date</th>-->
    <th class="tender-expirydate">PDF</th>
  </tr>
<?php  
$date=date('Y-m-d');
$sql_tender=mysql_query("select * from combine_publish where cat_id='4' and language_id='1' and approve_status='3' and date(end_date) >='$date'");
$num_rows=mysql_num_rows($sql_tender);
if($num_rows>0)
{
while($row_tender=mysql_fetch_array($sql_tender))
	{
	$exten=substr($row_tender['docs_file'],-4);
	if($row_tender['docs_file']!=''){
	$file='../../upload/'.$row_tender['docs_file'];
	$pdfsize='size:( '.formatFilebytes($file,'MB').')';
	}
	else { $pdfsize='No pdf File Exit' ;}
	?>
	 <tr class="odd">
    <td valign="top"><?php echo $row_tender['m_short'];?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>">&nbsp;&nbsp;</td>
     <!--<td valign="top"><?php echo changeformate($row_tender['start_date']);?></td>-->
    <td valign="top">
	<?php if($exten=='.pdf') { ?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>"><img src="<?php echo $HomeCss;?>/images/pdf_icon.png" alt="Pdf" height="16" />&nbsp;&nbsp;<?php echo $pdfsize;?></a>
	<?php } else if($exten=='.doc' || $exten=='docx') {  ?>
	<a href="<?php echo $HomeURL;?>/upload/<?php echo $row_tender['docs_file'];?>" target="_blank" title="<?php echo $row_tender['m_name'];?>"><img src="<?php echo $HomeCss;?>/images/word.jpeg" alt="Doc" height="16" />&nbsp;&nbsp;<?php echo $pdfsize;?></a>
	<?php } ?>
	</td>
  </tr>
  <?php }} else{ ?>
<tr><td colspan="3" class="even" >No records found.</td></tr>	
<?php	}?>
  </tbody></table>

<span class="anchor-icon"><a href="<?php echo $HomeURL; ?>/content/archive.php?txtcatgory=4">Archive</a></span>




