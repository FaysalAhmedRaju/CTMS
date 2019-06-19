
<?php
class sendEmailController extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation','email'));
            $this->load->model(array('CI_auth'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
		//	$this->load->model('signUpProcess', 'bm', TRUE);
			
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
	}
    
	function sendEmail($subject,$body,$emailClient,$pdfFilePath_cartTicket,$pdfFilePath_Bill,$pdfFilePath_releaseorder)
	{
		require_once 'mailer/PHPMailerAutoload.php';
		require_once 'mailer/class.phpmailer.php';
	  
		$this->CI =& get_instance();
		$email =$this->CI->config->item('email');		
		$password = $this->CI->config->item('password');
		$SMTPAuth = $this->CI->config->item('SMTPAuth');
		$SMTPSecure = $this->CI->config->item('SMTPSecure');
		$Host = $this->CI->config->item('Host');
		$Port = $this->CI->config->item('Port');
	//	$file_name="admin_20160716103021.xls";
	  
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		//$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = $SMTPAuth; // authentication enabled
		$mail->SMTPSecure = $SMTPSecure; // secure transfer enabled REQUIRED for GMail
		$mail->Host = $Host;
		$mail->Port = $Port; // or 587
		$mail->IsHTML(true);
		$mail->FromName = "Shedbill";
		//$mail->SetFrom('name@yourdomain.com', 'Rupert Bear');
		//$mail->Username = "ctms.igm@gmail.com";
		//$mail->Password = "ctmsadmin";
	  
		$mail->Username = $email;
		$mail->Password = $password;
		$mail->SetFrom($email,'Shedbill');
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($emailClient);

	//	$mail->addAttachment("resources/uploadfile/admin_20160716103021.xls",$file_name);  //worked
	//	$mail->addAttachment("resources/uploadfile/admin_20160716103021.xls");  //worked
	//	$mail->addAttachment("resources/uploadfile/".$pdfFilePath_cartTicket);   //worked
	//	$mail->addAttachment("resources/uploadfile/".$pdfFilePath_Bill);   //worked
		$mail->addAttachment($pdfFilePath_Bill);   //done
		$mail->addAttachment($pdfFilePath_cartTicket);	//done
		$mail->addAttachment($pdfFilePath_releaseorder);	//done
		
		if(!$mail->Send())
			{
				echo "Not sent";
				echo "<br>";
				echo "Mailer Error: " . $mail->ErrorInfo; 
				$rtnmsg =  "There has been some error. Please try again...";
				
				date_default_timezone_set('America/New_York');

				$newYorkDate=date("Y-m-d H:i:s");

				date_default_timezone_set('Asia/Dhaka');

				$bangladeshDate= date("Y-m-d H:i:s");

				//$datetime=date("Y-m-d H:i:s")

				$ip_add=$_SERVER['REMOTE_ADDR'];;

				$fp=fopen("EmailNotSendLog.txt","a");

				$datawrite="IP: $ip_add | NewYork Time: $newYorkDate | BangladeshTime: $bangladeshDate | $mail->AddAddress($emailClient)\r\n";

				$fp=fwrite($fp,$datawrite);	

				$fp=fclose($fp);
			}
			else
			{
				echo "Sent";
				 $rtnmsg =  "Email has been successfully sent to $emailClient";
			}
	  return $rtnmsg;
			
        }
}

?>