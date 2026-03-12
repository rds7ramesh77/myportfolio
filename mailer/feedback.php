<?php 
require 'PHPMailerAutoload.php';
require 'form_setting.php';

if(isset($_POST)){
	$name = str_replace(array("\r", "\n"), '', $_POST['name']);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : '';
	$message = $_POST['message'];

	if(empty($email)){
	    print json_encode(array('status'=>0));
	    exit;
	}
	
	$messages  = "<h3>New message from the site " .$fromName. "</h3> \r\n";
	$messages .= "<ul>";
	$messages .= "<li><strong>Name: </strong>" .$name."</li>";
	$messages .= "<li><strong>Email: </strong>" .$email."</li>";
	$messages .= "<li><strong>Message: </strong>" .$message."</li>";
	$messages .= "</ul> \r\n";

	$mail = new PHPMailer;

	$mail->From = $from;
	$mail->FromName = $name;
	$mail->addAddress($to, 'Admin');
	$mail->addReplyTo($email, $name);

	$mail->isHTML(true); 
	$mail->CharSet = $charset;

	$mail->Subject = $subj;
	$mail->Body    = $messages;

	if(!$mail->send()) {
	    print json_encode(array('status'=>0));
	} else {
	    print json_encode(array('status'=>1));
	}

}
	
?>