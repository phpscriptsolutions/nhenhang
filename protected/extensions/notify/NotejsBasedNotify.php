<?php
class NotejsBasedNotify implements INotify
{
	
	public function register($user_id)
	{
		return;
	}
	public function unregister($user_id)
	{
		return;
	}

	public function check($user_id)
	{
		$url = Yii::app()->params['notify.server'];
		$data = $this->_getcontent("$url/get_unread.php?user_id=$user_id");
		$data = json_decode($data,true);
		return array('unseen'=>$data['unread_count']);
	}

	public function listAll($user_id,$filter,$offset=0,$limit=100){
		$url = Yii::app()->params['notify.server'];
		$url = "$url/get_lastest.php?user_id=$user_id&max_count=$limit&type=$filter&offset=$offset";
		$data = $this->_getcontent($url);
		$data = json_decode($data,true);
		$msgs = $data['data'];
		#echo "<pre>";print_r($msgs);exit(); 
		$rs = array();
		for($i=0;$i < count($msgs);$i++){
			$msg = json_decode($msgs[$i]['msg'],true);
			$msg['id']=$msgs[$i]['msg_id']; 
			if(!isset($msg["msg"])){
				$msg['msg']= new stdClass();
			}else{
				$msg['msg']=json_decode($msg["msg"]);
			}			
			$rs[]=$msg;
		}				 
		return array('total'=>$data['count'],'msgs'=>$rs);
	}

	public function listNew($user_id,$filter)
	{
		$server = Yii::app()->params['notify.server'];
		$url = "$server/get_unread.php?user_id=$user_id";
		$data = $this->_getcontent($url);
		$data = json_decode($data,true);
		
		$data = $this->_getcontent("$server/get_lastest.php?user_id=$user_id&max_count=".$data['unread_count']."&type=$filter");
		$data = json_decode($data,true);
		$msgs = $data['data'];
		$rs = array();
		for($i =count($msgs)-1;$i>=0;$i--){
			$msg = json_decode($msgs[$i]['msg'],true);
			$msg['id']=$msgs[$i]['msg_id'];
			$msg["msg"]=json_decode($msg["msg"]);
			$rs[]=$msg;
		}				 
		return $rs;
	}

	public function remove($user_id,$msg_id)
	{
		$url = Yii::app()->params['notify.server'];
		$url = "$url/delete_msgid.php?msg_id=$msg_id";
		$data = $this->_getcontent($url);
		$data = json_decode($data,true);
		return $data;
	}

	public function broadcast($user_id,$name,$receivers,$msg,$type){
		$url	= Yii::app()->params['notify.server'];
		$msg	= array('sender_id'=>$user_id,'sender_name'=>$name,'msg'=>json_encode($msg));
		$to		= implode(",", $receivers);
		$msg	= urlencode(json_encode($msg));
		$return	= $this->_getcontent("$url/push.php?from_id=$user_id&to_id=$to&notification=$msg&type=$type");
		return;
	}
	
	public function close(){
		return;
	}
	
	private function _getcontent($url){
		$ch = curl_init(); 
	 	curl_setopt($ch, CURLOPT_URL,$url);
	 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 	curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
	 	//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			$data = "";
		}
		curl_close($ch);
		return $data;
	}
}