<?php

// settings
$contact_email = 'your@email.com';


// actions
$error = $success = FALSE;
if(isset($_POST['contact'])){
	$contact = $_POST['contact'];

	if (!isset($contact['type'])) $contact['type'] = 'hi';

	// mail headers
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: Portfolio Contact Form\r\n";

	// subject
	$subject = str_replace(array("\n", "\r"), array(' ', ''), $contact['message']);
	$subject = substr($subject, 0, 20);
	$subject = "[portfolio][" . $contact['type'] . "] ". $subject;

	// message body
	$message = nl2br(htmlspecialchars($contact['message']));
	$date = date('Y-m-d H:i:s');
	$body = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
	Sender : {$contact['name']} <a href="mailto:{$contact['email']}">&lt;{$contact['email']}&gt;</a><br>
	<hr size="1"><br>
	$message
	<br><hr size="1"><br>
	Sent at $date from {$_SERVER['REMOTE_ADDR']}
</body>
</html>
EOF;

	// sending
	if(@mail($contact_email, $subject, $body, $headers)){
		$success = true;
	}else{
		$error = true;
	}
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Contact</title>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css">
	<script src="js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/contact.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div id="header">
		<div class="text contact">
			<h1>Contact with Me</h1>
			<h1>Say "Hi" to me!</h1>
			<h3>
				You can contact me with <a href="mailto:<?=$contact_email?>"><?=$contact_email?></a>
				email address or XX XXX XX XX mobile number.
			</h3>
		</div>
		<?php include('menu.php'); ?>
	</div>
	<div id="content">
		<div class="contact_content">
			<div class="top"></div>
			<div class="middle">
				<div class="contact_form">
					<?

					if( $error OR $success ){
						print '<div id="status">';
						if( $success ){
							print '
							<div class="success">
								<h1>Your message has been sent!</h1>
								Thanks for your interest<br>
								<a href="/">Back to the portfolio</a>
							</div>
							';
						}else{
							print '
							<div class="error">
								<h1>Cannot send the Message</h1>
								Try again<br>
								<a href="#back" onClick="history.back(-1);">Go Back</a>
							</div>
							';
						}
						print '</div>';

					}else{

					?>
					<center>
						<a href="./" style="font-size: 1.2em;">&laquo; Back to the portfolio</a>
					</center>
					<br><br>
					<form id="contact" method="post">
						<div class="row name">
							<label for="name" class="label">Name</label>
							<div class="input">
								<input type="text" id="name" name="contact[name]"
									value="<?=(isset($contact['name']) ? $contact['name'] : NULL);?>">
							</div>
							<div class="error">Name required!</div>
						</div>
						<div class="row email">
							<label for="email" class="label">E-mail</label>
							<div class="input">
								<input type="text" id="email" name="contact[email]" value="<?=(isset($contact['email']) ? $contact['email'] : NULL);?>">
							</div>
							<div class="error">E-mail required in correct format.</div>
						</div>
						<div class="row type">
							<div class="input nolabel">
								<div class="type_hi">
									<span class="radio"><input type="radio" id="type_hi" name="contac[type]" value="hi"></span>
									<label for="type_hi">Hello</label>
								</div>
								<div class="type_job">
									<span class="radio"><input type="radio" id="type_job" name="contac[type]" value="job"></span>
									<label for="type_job">Job Offer</label>
								</div>
								<div class="clear"></div>
							</div>
							<div class="error">Contact reason must be selected!</div>
						</div>
						<div class="row message">
							<label for="message" class="label">Message</label>
							<div class="input">
								<textarea id="message" name="contact[message]"><?=(isset($contact['email']) ? $contact['message'] : NULL);?></textarea>
							</div>
							<div class="error">Hasn't you got something to write? :)</div>
						</div>
						<div class="row">
							<div class="input nolabel">
								<a href="#send" onClick="$('#contact').submit();" class="send_button">Send</a>
							</div>
						</div>
					</form>
					<? } ?>
				</div>
			</div>
			<div class="bottom"></div>
		</div>
	</div>
</body>
</html>