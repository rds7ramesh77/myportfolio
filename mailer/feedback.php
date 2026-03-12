<?php
require 'PHPMailerAutoload.php';
require 'form_setting.php';

header('Content-Type: application/json');

if (isset($_POST) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
	$name    = htmlspecialchars(strip_tags($_POST['name']));
	$email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$message = htmlspecialchars(strip_tags($_POST['message']));

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		print json_encode(array('status' => 0, 'error' => 'Invalid email'));
		exit;
	}

	$body  = "<h3>New message from your portfolio site</h3>\r\n";
	$body .= "<ul>";
	$body .= "<li><strong>Name:</strong> " . $name . "</li>";
	$body .= "<li><strong>Email:</strong> " . $email . "</li>";
	$body .= "<li><strong>Message:</strong><br>" . nl2br($message) . "</li>";
	$body .= "</ul>\r\n";

	$mail = new PHPMailer;

	$mail->From     = $from;
	$mail->FromName = 'Portfolio Contact - ' . $name;
	$mail->addAddress($to, 'Ramesh Sapkota');
	$mail->addReplyTo($email, $name);

	$mail->isHTML(true);
	$mail->CharSet = $charset;

	$mail->Subject = $subj . ' from ' . $name;
	$mail->Body    = $body;

	if (!$mail->send()) {
		print json_encode(array('status' => 0));
	} else {
		print json_encode(array('status' => 1));
	}
} else {
	print json_encode(array('status' => 0, 'error' => 'Missing fields'));
}
?>