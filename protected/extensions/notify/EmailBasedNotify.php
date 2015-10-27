<?php
class EmailBasedNotify implements INotify
{
    public $domain;
    public $hostname;
    public $registerCommand;
    public $unregisterCommand;
    public $smtp;
    private $inbox;
    private function getInbox($user_id){
        if(!$this->inbox){
            $this->inbox = imap_open($this->hostname,'u'.$user_id.'@'.$this->domain,$user_id) or die('Cannot connect to Notify system');
        }
        return $this->inbox;
    }
    
    public function register($user_id){
        //exec(strtr($registerCommand,array('{user_id}'=>'u'.$user_id.'@'.$this->domain,'{password}'=>$user_id)));
    }
    public function unregister($user_id){
        //exec(strtr($unregisterCommand,array('{user_id}'=>'u'.$user_id.'@'.$this->domain,'{password}'=>$user_id)));
    }
    public function check($user_id){
        $status = imap_status($this->getInbox($user_id),$this->hostname, SA_ALL);
        return array('total'=>$status->messages,'unseen'=>$status->unseen);
    }
    public function listAll($user_id,$filter,$offset=0,$limit=100){
        $inbox = $this->getInbox($user_id);
        if($filter==''){
            $filter='ALL';
        }else {
            $filter='CC "t'.$filter.'@'.$this->domain.'"';
        }
        $emails = imap_search($inbox,$filter);
        $msgs = array();
        $ids=array();
        for($start = count($emails)-$offset;$start>0&&$limit>0;$limit--){
            $start--;
            $ids[]=$emails[$start];
        }
        
        $overviews = imap_fetch_overview($inbox,implode(',',$ids));
        $index = count($overviews)-1;         
        foreach($overviews as $overview){
            $msg_no = $overview->msgno;
            $message=isset($overview->subject)?$overview->subject:imap_fetchbody($inbox,$msg_no,'1');
            $from = $this->decodeAddress($overview->from);
            if(($pos=strpos($from,'<'))!==FALSE){
                $sender_name=substr($from,0,$pos);
                $pos2=strpos($from,'@',$pos);
                $sender_id=substr($from,$pos+2,$pos2-$pos-2);
            }
            $msgs[$index]=array('id'=>$msg_no,'sender_id'=>$sender_id,'sender_name'=>$sender_name,'date'=>$overview->udate,'msg'=>json_decode($message),'seen'=>$overview->seen);
            $index--;
        }
        if($offset==0){
            $unreads = imap_search($inbox,"UNSEEN");
            if($unreads){
                imap_setflag_full( $inbox,implode(',',$unreads),'\\Seen');
            }
        }
        return array('total'=>count($emails),'msgs'=>$msgs);
    }
    public function listNew($user_id,$filter){
        $inbox = $this->getInbox($user_id);
        if($filter==''){
            $filter='UNSEEN';
        }else {
            $filter='UNSEEN CC "t'.$filter.'@'.$this->domain.'"';
        }
        $emails = imap_search($inbox,$filter);
        $msgs = array();
        $ids=array();
        for($start = count($emails);$start>0;){
            $start--;
            $ids[]=$emails[$start];
        }
        $overviews = imap_fetch_overview($inbox,implode(',',$ids));
        foreach($overviews as $overview){
            $msg_no = $overview->msgno;
            $message=isset($overview->subject)?$overview->subject:imap_fetchbody($inbox,$msg_no,'1');
            $from = $overview->from;            
            if(($pos=strpos($from,'<'))!==FALSE){
                $sender_name=substr($from,0,$pos);
                $pos2=strpos($from,'@',$pos);
                $sender_id=substr($from,$pos+2,$pos2-$pos-2);
            }            
            $msgs[]=array('id'=>$msg_no,'sender_id'=>$sender_id,'sender_name'=>$sender_name,'date'=>$overview->udate,'msg'=>json_decode($message),'seen'=>$overview->seen);
        }
        $unreads = imap_search($inbox,"UNSEEN");
        if($unreads){
            imap_setflag_full( $inbox,implode(',',$unreads),'\\Seen');
        }        
        return $msgs;
    }
    public function remove($user_id,$msg_id){
        imap_delete($this->getInbox($user_id),is_array($msg_id)?implode(',',$msg_id):$msg_id);
    }
    public function broadcast($user_id,$name,$receivers,$msg,$type=null){
        $msg = json_encode($msg);
        if(strlen($msg)<255){
            $subject=$msg;            
            $body=' ';
        }else {
            $subject='';
            $body=$msg;            
        }
        require_once(dirname(__FILE__) . '/../../vendors/phpmailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = $this->smtp;  // specify main and backup server
        $mail->SMTPAuth = false;     // turn on SMTP authentication
        $mail->Username = 'u'.$user_id;  // SMTP username
        $mail->Password = $user_id; // SMTP password
        $mail->From = 'u'.$user_id.'@'.$this->domain;
        $mail->FromName = $name;
        if($type){
            $mail->AddCC('t'.$type.'@'.$this->domain);
        }
        if(is_array($receivers)){
            foreach($receivers as $receiver){
                $mail->AddAddress('u'.$receiver.'@'.$this->domain);
            }
        }else{
            $mail->AddAddress('u'.$receivers.'@'.$this->domain);
        }
        $mail->Subject = $subject;
        $mail->Body    = $body;
        return $mail->Send();
    }
    public function close(){
        if($this->inbox)imap_close($this->inbox,CL_EXPUNGE);
    }
    private function decodeAddress($value)
	{
		$charset = null;
		$s = 0;
		$decoded = '';
		$l = strlen($value);
		while($s < $l)
		{
			if(GetType($q = strpos($value, '=?', $s)) != 'integer')
			{
				if($s == 0)
					return $value;
				if($s < $l)
					$decoded .= substr($value, $s);
				break;
			}
			if($s < $q)
				$decoded .= substr($value, $s, $q - $s);
			$q += 2;
			if(GetType($c = strpos($value, '?', $q)) != 'integer'
			|| $q == $c)
				return $value;
			if(IsSet($charset))
			{
				$another_charset = strtolower(substr($value, $q, $c - $q));
				if(strcmp($charset, $another_charset)
				&& strcmp($another_charset, 'ascii'))
					return $value;
			}
			else
			{
				$charset = strtolower(substr($value, $q, $c - $q));
				if(!strcmp($charset, 'ascii'))
					$charset = null;
			}
			++$c;
			if(GetType($t = strpos($value, '?', $c)) != 'integer'
			|| $c==$t)
				return $value;
			$type = strtolower(substr($value, $c, $t - $c));
			++$t;
			if(GetType($e = strpos($value, '?=', $t)) != 'integer')
				return($this->SetPositionedWarning('invalid Q-encoding encoded data', $p + $e));
			switch($type)
			{
				case 'q':
					for($s = $t; $s<$e;)
					{
						switch($b = $value[$s])
						{
							case '=':
								$h = HexDec($hex = strtolower(substr($value, $s + 1, 2)));
								if($s + 3 > $e
								|| strcmp(sprintf('%02x', $h), $hex))
									return $value;
								$decoded .= chr($h);
								$s += 3;
								break;

							case '_':
								$decoded .= ' ';
								++$s;
								break;

							default:
								$decoded .= $b;
								++$s;
						}
					}
					break;

				case 'b':
					if($e <= $t
					|| strlen($binary = base64_decode($data = substr($value, $t, $e - $t))) == 0
					|| GetType($binary) != 'string')
						return $value;
					$decoded .= $binary;
					$s = $e;
					break;

				default:
					return $value;
			}
			$s += 2;
			$s += strspn($value, " \t", $s);
		}
		$value = $decoded;
		return $value;
	}
}
