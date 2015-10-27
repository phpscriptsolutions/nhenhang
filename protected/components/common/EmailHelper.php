<?php
class EmailHelper
{
	public static function send($code,$emailTo,$params=array())
	{	
		$emailModel = EmailTemplateModel::model()->find("code=:CODE",array(":CODE"=>$code));
		$saveParams = array();
		foreach ($params as $key=>$val){
			$saveParams["{{".$key."}}"]=$val;
		}


        $message = new YiiMailMessage;
        $message->setBody(strtr($emailModel->body,$saveParams), 'text/html');
        $message->subject = strtr($emailModel->subject,$saveParams);
        $message->addTo($emailTo);
        $message->from = (isset($emailModel->from) && $emailModel->from!="")?$emailModel->from:"noreply@nhenhang.com";

        if(Yii::app()->mail->send($message)){
            return true;
        }
        return false;

	}

    public static function sendEmail($subject, $msg,$emailTo,$fromEmail='')
    {
        $message = new YiiMailMessage;
        $message->setBody($msg, 'text/html');
        $message->subject = $subject;
        $message->addTo($emailTo);
        $message->from = ($fromEmail !="")?$fromEmail:"noreply@nhenhang.com";

        if(Yii::app()->mail->send($message)){
            return true;
        }
        return false;

    }


	
	public static function isEmailAddress($email){
        if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
            return true;
        }
        return false;
    }

    public static function verifyEmail($toemail, $fromemail='noreply@nhenhang.com', $getdetails = false){
        $email_arr = explode("@", $toemail);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];

        //pass with email  @live.com
        if($email_arr[1] == 'live.com'){
            return 'valid';
        }

        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");

        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }

        $mxhosts = array();
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);

        $details = '';

        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }

            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {

                $result   = "invalid";
                $details .= "No suitable MX records found.";

                return ( (true == $getdetails) ? array($result, $details) : $result );
            }
        }

        $connect = @fsockopen($mx_ip, 25);
        if($connect){
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n");
                $out = fgets ($connect, 1024);
                $details .= $out."\n";

                fputs ($connect , "MAIL FROM: <$fromemail>\r\n");
                $from = fgets ($connect, 1024);
                $details .= $from."\n";

                fputs ($connect , "RCPT TO: <$toemail>\r\n");
                $to = fgets ($connect, 1024);
                $details .= $to."\n";

                fputs ($connect , "QUIT");
                fclose($connect);

                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid";
                }
                else{
                    $result = "valid";
                }
            }
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($getdetails){
            return array($result, $details);
        }
        else{
            return $result;
        }
    }
}