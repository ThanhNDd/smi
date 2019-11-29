<?php
include ("PHPMailer/PHPMailer.php");

/**
 * 
 */
class SendMail 
{
	private $host = 'smtp.gmail.com';
	private $port = 587;
	private $smtp_secure = 'tls';
	private $smtp_auth = true;
	private $from_email = 'thanhit228@gmail.com';
	private $password = 'wkwomwzmatrrxhes';
	private $to_email = 'thanhit228@gmail.com';
	private $message;
	private $subject;
	
	// function __construct(argument)
	// {
	// 	# code...
	// }

	function send()
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = $this->host;
		$mail->Port = $this->port;
		$mail->SMTPSecure = $this->smtp_secure;
		$mail->SMTPAuth = $this->smtp_auth;
		$mail->Username = $this->from_email;
		$mail->Password = $this->password;

		// Email Sending Details
		$mail->addAddress($to_email);
		$mail->Subject = subject();
		$mail->msgHTML(message());
		// Success or Failure
		if (!$mail->send()) {
			$error = "Mailer Error: " . $mail->ErrorInfo;
			return false;
		}
		return true;
	}	

	function message()
	{
		return "Hello World! This is the first email send by php";
	}

	function subject() {
		return "[Shop Mẹ Ỉn] Đơn hàng tại cửa hàng";
	}
}
