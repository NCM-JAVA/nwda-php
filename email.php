<?php 
$user_name = "Anil";
                    $email_subject = "JDA Transfer Demand Letter Notification"; // The Subject of the email
                   // $email_to = "dwivedianil007@gmail";
                    $email_to = "jeetesh.askonline@gmail.com";
					
                    $eol = "\n";
                    $headers = "MIME-Version: 1.0" . $eol;
                    $headers .= "Content-Type: text/html; charset=UTF-8" . $eol;
                    $headers .= "From: ddadmn-nwda@gov.in" . $eol;
                    $headers .= "Reply-To: ddadmn-nwda@gov.in" . $eol;

                    $email_message .= "<table width='100%'  border='0' cellspacing='0' cellpadding='0' align='left'>
					<tr><td colspan='3' align='left' class='text_mail' >Dear  $user_name,</td></tr>
					<tr><td colspan='3' class='text_mail'>&nbsp;</td></tr>
					<tr> <td colspan='3' align='left' class='text_mail'>You are requested to clear your outstanding dues for Transfer of Property under application no. : <b>$registration_no</b>. Kindly visit your account at $websiteurl for payment and further updates. </td></tr>
					<tr><td  colspan='3'>&nbsp;</td></tr>
					
					<tr><td class='text_mail' colspan='3' align='left'>Regards,</td></tr>
					<tr><td class='text_mail' colspan='3' align='left'>JDA</td></tr>
					<tr><td  colspan='3'>&nbsp;</td></tr>
					<tr><td  colspan='3'>&nbsp;</td></tr>
					<tr><td class='text_mail' colspan='3' align='left'>This is system generated email do not reply.</td></tr>
					</table>";

                    try {
                    mail($email_to, $email_subject, $email_message, $headers);
						echo "<pre>"; print(mail($email_to, $email_subject, $email_message, $headers)); die;
                    } catch (Exception $exc) {
                        echo "failed";
					}
					
					?>