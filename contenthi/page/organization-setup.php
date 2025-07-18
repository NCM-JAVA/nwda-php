<table width="100%" cellspacing="0" cellpadding="5" border="0" summary="">
  <tbody>
  <caption><?php echo $title;?></caption>
  <!--<tr>
    <th width="4%">S.No</th>
    <th width="48%">Bureau Head</th>
    <th width="48%">Work Allocation/Bureau</th>
  </tr>-->
<?php  
 $i=1;
$sql_tender=mysql_query("select * from organization_chart where approve_status='3' order by page_postion ASC");
while($row_tender=mysql_fetch_array($sql_tender))
	{
	?>
	<!-- <tr class="odd"><td><?php echo $i;?></td>
	 <td><a href="contact-us.php#us<?php echo $row_tender['id'];?>"><?php echo $row_tender['ename'];?>&nbsp;,&nbsp;<?php echo func_org_designation($row_tender['designation']);?></a></td>
    <td valign="top"><?php echo html_entity_decode($row_tender['eshort_desc']);?></td>

  </tr>-->
  <?php $i++; }?>  </tbody></table>


