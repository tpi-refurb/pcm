<?php
//require 'mailer/PHPMailerAutoload.php';

class Email
{
    private $dbh;
    private $config;
	private $email;
	private $html_head ='<html><head> <meta charset="utf-8"></head><body>';
    private $html_foot ='</body></html>';
	
    public function __construct(\PDO $dbh, $config)
    {
        $this->dbh = $dbh;
		$this->config = $config;
		
		$this->email = new PHPMailer();
		//$mail->SMTPDebug = 3;                               			// Enable verbose debug output
		$this->email->isSMTP();                                      	// Set mailer to use SMTP
		$this->email->Host = $this->config->smtp_host;
		$this->email->SMTPAuth =true;    
		$this->email->Username = $this->config->smtp_username;
		$this->email->Password = $this->config->smtp_password;
		$this->email->Port = $this->config->smtp_port;
		if($this->config->smtp_security != NULL) {
			$this->email->SMTPSecure = $this->config->smtp_security;
		}else{
			$this->email->SMTPSecure = 'tls';
		}
		$this->email->From = $this->config->site_email;
		$this->email->FromName = $this->config->site_name;
		
		$this->email->addReplyTo('support@telcomtrix.com', 'Telcomtrix Support');		
		$this->email->isHTML(true); 

    }
	
	public function sendEmail($subject, $message, $recepients, $cc, $bcc, $attachments){
		if(is_array($recepients) && count($attachments) >0){
			foreach($recepients as $r){
				$this->email->addAddress($r);
			}
		}else{
			if(!empty($recepients)){
				$this->email->addAddress($recepients);
			}
		}
				
		if(is_array($cc) && count($attachments) >0){
			foreach($cc as $c){
				$this->email->addCC($c);
			}
		}else{
			if(!empty($cc)){
				$this->email->addCC($cc);
			}
		}
		
		if(is_array($bcc) && count($attachments) >0){
			foreach($bcc as $b){
				$this->email->addBCC($b);
			}
		}else{
			if(!empty($bcc)){
				$this->email->addBCC($bcc);
			}
		}
		
		if(is_array($attachments) && count($attachments) >0){
			foreach($attachments as $a){
				$this->email->addAttachment($a);
			}
		}else{
			if(!empty($attachments)){
				$this->email->addAttachment($attachments);
			}
		}
		
		$this->email->Subject = $subject;
		
		$this->email->Body    =  $message;
		//$this->email->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		$this->email->isHTML(true); 
		if($this->email->send()) {
			return true;
		} 
		return false;
	}
	

}

?>
