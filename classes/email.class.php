<?php
defined('_VALID') or die('Restricted Access!');

use PHPMailer\PHPMailer\PHPMailer;
if ( !class_exists('PHPMailer') ) {
    require $config['BASE_DIR']. '/include/phpmailer/PHPMailer.php';
}
if ( !class_exists('SMTP') ) {
    require $config['BASE_DIR']. '/include/phpmailer/SMTP.php';
}
require $config['BASE_DIR']. '/include/phpmailer/Exception.php';



class VMail extends PHPMailer
{
    public function __construct()
    {
        $this->config();
        $this->IsHTML(true);
    }
    
    public function config()
    {
        global $config;
        if ( $config['mailer'] == 'mail' ) {
            $this->Mailer       = 'mail';
        } elseif ( $config['mailer'] == 'sendmail' ) {
			$this->isSendmail();
        } elseif ( $config['mailer'] == 'smtp' ) {
            $this->isSMTP();
			if ($config['smtp_autotls'] == 'true') {
			$this->SMTPAutoTLS  = true;
			} else {
			$this->SMTPAutoTLS  = false;	
			}
            $this->Host         = $config['smtp'];
            $this->Port         = $config['smtp_port'];
			if ($config['smtp_prefix'] == 'false') {
            $this->SMTPSecure   = false;
			} else {
			$this->SMTPSecure   = $config['smtp_prefix'];	
			}
			$this->SMTPDebug 	= $config['smtp_debug']; 
            if ( $config['smtp_auth'] ) {
                $this->SMTPAuth = true;
                $this->Username = $config['smtp_username'];
                $this->Password = $config['smtp_password'];
            }
			
        } else {
            $config['mailer']   = 'mail';
            $this->config();
        }
        
        $this->WordWrap = 75;
    }
    
    public function set($name='', $value = '')
    {
        global $config;
    
        $this->From     = $config['admin_email'];
        $this->FromName = $config['site_name'];
        $this->Sender   = $config['admin_email'];
        $this->AddReplyTo($config['admin_email'], $config['site_name']);
    }
    
    public function setNoReply()
    {
        global $config;
    
        $this->From     = $config['noreply_email'];
        $this->FromName = $config['site_name'];
        $this->Sender   = $config['noreply_email'];
        $this->AddReplyTo($config['noreply_email'], $config['site_name']);
    }
    
    public function sendPredefined($email, $email_id, $search=array(), $replace=array())
    {
        global $config, $conn;
        
		if ( !class_exists('VFile') ) {
			require $config['BASE_DIR']. '/classes/file.class.php';
		}
		
        $sql            = "SELECT email_subject, email_path FROM emailinfo WHERE email_id = '" .$email_id. "' LIMIT 1";
        $rs             = $conn->execute($sql);
        $email_subject  = str_replace($search, $replace, $rs->fields['email_subject']);
        $email_path     = $config['BASE_DIR']. '/templates/' .$rs->fields['email_path'];
        $body           = VFile::read($email_path);
        $body           = str_replace($search, $replace, $body);
                
        $this->setNoReply();
        $this->Subject  = $email_subject;
        $this->AltBody  = $body;
        $this->Body     = nl2br($body);
        if (is_array($email)) {
            foreach($email as $email_address) {
                $this->AddAddress($email_address);
                $this->Send();
                $this->ClearAddresses();
            }
        } else {        
            $this->AddAddress($email);
            $this->Send();
        }
    }
}
?>
