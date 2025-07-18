<?php
					@extract($_GET);
					@extract($_POST);
					@extract($_SESSION);
//dealer
$sql_email = "SELECT * from feedback_form";
$re_email=mysql_query($sql_email);
while($line_email=mysql_fetch_array($re_email))
{
@extract($line_email);
}


$email_body="<tr>
    <td align='left' valign='top'>
      
      <table width='98%' border='0' align='center' cellpadding='2' cellspacing='2' class='normaltext'>
        <tr>
          <td colspan='3' align='left' valign='top'>Dear Admin,</td>
        </tr>
        <tr>
          <td colspan='3' align='left' valign='top'>Please find below an enquiry submitted . </td>
        </tr>
        

		 <tr>
          <td width='30%' align='left' valign='top'><strong>Name</strong></td>
          <td width='1%' align='left' valign='top'><strong>:</strong></td>
          <td width='69%' align='left' valign='top'>$title $firstname $lastname  </td>
        </tr>
        


		<tr>
		<td align='left' valign='top'><strong>Address</strong></td>
		<td align='left' valign='top'><strong>:</strong></td>
		<td align='left' valign='top'>$address&nbsp;$address1&nbsp;$town</td>
		</tr>

	
		<tr>
		<td align='left' valign='top'><strong>Can be contacted by</strong></td>
		<td align='left' valign='top'><strong>:</strong></td>
		<td align='left' valign='top'>$contactby</td>
		</tr>

		<tr>
		<td align='left' valign='top'><strong>Council</strong></td>
		<td align='left' valign='top'><strong>:</strong></td>
		<td align='left' valign='top'>$council</td>
		</tr>

?>