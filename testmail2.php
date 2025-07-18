<?php

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

  $mail->SMTPDebug = 0;                                // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
//$mail->Host = '164.100.14.95';  // Specify main and backup SMTP servers  164.100.14.95
$mail->Host = 'relay.nic.in';  // Specify main and backup SMTP servers  164.100.14.95
$mail->SMTPAuth = false;                               // Enable SMTP authentication
//$mail->Username = 'arogyashiksha.help@';                 // SMTP username
//$mail->Password = '';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->From = 'ddadmn-nwda@gov.in';
$mail->FromName = 'Jeetesh';
$mail->addAddress('jeetesh.akalinfosys@gmail.com', 'Jeetesh');    
$mail->addAddress('jeetesh.askonline@gmail.com', 'Jeetesh');    
//$mail->addAddress('ellen@example.com');              
//$mail->addReplyTo('hariom.mishra@supportgov.in','Hariom');

//$mail->addBCC('xyz@gmail.com');




$mail->WordWrap = 50;                                 // Set word wrap to 50 characters 
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b> local';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}