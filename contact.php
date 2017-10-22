<?php

require_once './config.php';
require_once './vendor/autoload.php';

$status = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$status = sendMail($_POST);
}

function sendMail($params){
	$status = 'mail not sent';
	$mail = new \PHPMailer\PHPMailer\PHPMailer;
	
	//Enable SMTP debugging. 
	$mail->SMTPDebug = 0;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "smtp.gmail.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = Config::SITE_EMAIL;                 
	$mail->Password = Config::SITE_EMAIL_PASS;                           
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   
	
	$mail->SetFrom(Config::SITE_EMAIL, Config::SITE_EMAIL);
	
	$mail->addAddress(Config::SITE_EMAIL, "Info");
	
	$mail->isHTML(true);
	
	$mail->Subject = "Contact Form Enquiry";
	$mail->Body = 'name:' . $params['name'] . '<br>email:' . $params['email'] . '<br>messaage:<br>' . $params['body'];
	$mail->AltBody = "This is the plain text version of the email content";
	
	if(!$mail->send()) 
	{
	    $status = "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    $status = "Message has been sent successfully";
	}
	return $status;
}

?>
<html>
<head>
	<title>Contact</title>
</head>
<body>
	<p><a href="index.php">Home</a></p>
	<?php if($status):?>
		<p><?php echo $status ?></p>
	<?php endif ?>
	<h2>Contact Us</h2>
	<form method="post" action="">
	<label>Name</label>
	<input type="text" name="name" required><br>
	<label>Email</label>
	<input type="email" name="email" required><br>
	<label>Body</label>
	<textarea name="body" required></textarea>
	<input type="submit">
	<br>
</body>
</html>