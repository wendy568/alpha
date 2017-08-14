<?php
header('Content-Type: text/html; charset=UTF-8');
    $content = $_POST['content'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $ssl = $_POST['ssl'];
    if($ssl == 'b22be9de8d21dccf')
{
	$Name = "Alpha Trader";
	$send_mail = "alphatrader@alphatrader.alphacoin.co.uk";
    $recipient = $email;
    $mail_body = html_entity_decode($content);
    $subject = $title;

// Additional headers
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= "From: ". $Name . " <" . $send_mail . ">\r\n";


    mail($recipient, $subject, $mail_body, $header);
}
