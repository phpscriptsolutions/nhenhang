<?php
class PlayController extends MController
{
	public function init()
	{
		parent::init();
		$userPhone = yii::app()->user->getState('msisdn');
		if(!$userPhone) $this->redirect('/event/register');
	}
	public function actionIndex()
	{
		//unset($_SESSION['qt_list']);
		//unset($_SESSION['thread']);
		$params = array();
		$completed = 0;
		$point=0;
		$sharePoint = false;
		$rankThread = null;
		$msg="";
		$userSub = $this->userSub;
		$currDate = date('Y-m-d');
		$userPhone = yii::app()->user->getState('msisdn');
		/* if($userSub){ */
			$countPlayByDate = GameEventThreadModel::countPlayByDate($userPhone, $currDate);
			if($countPlayByDate<=10){
				//tạo session câu hỏi lần đầu tiên tham gia
				//if(!isset($_SESSION['qt_list']) && !isset($_SESSION['thread']) && $countPlayByDate==0){
				if($countPlayByDate==0 && !isset($_SESSION['thread'])){
					$newThread = GameEventThreadModel::getNewRandomThread($userPhone);
					if($newThread){
						$questionList = GameEventThreadModel::getQuestionsByThread($newThread);
						$qtList = array();
						foreach ($questionList as $key => $value)
						{
							$qtList[]=$value['id'];
						}
						$_SESSION['qt_list']  = $qtList;
						$_SESSION['thread']  = $newThread;
						$_SESSION['count']  = 1;
					}else{
						//het 10 bo cau hoi
						$completed = 1;
						$msg = 'Bạn đã hoàn thành trả lời 10 bộ câu hỏi event 8/3.';
					}
					//echo '<pre>';print_r($questionList);
				}
				//tra loi tiep theo
				if(isset($_SESSION['qt_list']) && isset($_SESSION['thread'])){
					if(count($_SESSION['qt_list'])==0){
						$completed = 2;
						$msg = 'Bạn đã hoàn thành trả lời câu hỏi ngày hôm nay.';
						$sharePoint=true;
						$isShare = GameEventActivityModel::isShareOnDay($userPhone, date('Y-m-d'));
						if($isShare){
							$sharePoint=false;
						}
						$point=GameEventUserLogModel::model()->getPoint($userPhone, $_SESSION['thread']);
						$rankThread = GameEventReportDayModel::model()->getRankByThread($_SESSION['thread']);
					}else{
						$qtList = $_SESSION['qt_list'];
						$maxQt = count($qtList)-1;
						$indexRand = rand(0, $maxQt);
						$qtChosen = $qtList[$indexRand];
						if(isset($_GET['notrep']) && $_GET['notrep']==1 && isset($_GET['askid']) && $_GET['askid']>0){
							if(in_array($_GET['askid'], $qtList)){
								$qtChosen = $_GET['askid'];
							}
							
						}
						
						$question = GameEventQuestionModel::model()->findByPk($qtChosen);
						$answer = GameEventAnswerModel::model()->findAllByAttributes(array('ask_id'=>$qtChosen));
						$_SESSION['startTime'] = date('Y-m-d H:i:s');
						$params = array(
								'question'=>$question,
								'answer'=>$answer
						);
					}
				}else{
					$completed=3;
					$msg = 'Bạn đã tham gia trả lời câu hỏi ngày hôm nay.';
				}
				
			}else{
				//da choi ngay hom nay
				$completed=4;
				$msg = 'Bạn đã tham gia trả lời câu hỏi ngày hôm nay.';
			}
		/* }else{
			$this->redirect('/event/register');
			Yii::app()->end();
		} */
		$params['completed']=$completed;
		$params['sharePoint']=$sharePoint;
		$params['point']=$point;
		$params['userSub']=$userSub;
		$params['msg']=$msg;
		$params['rankThread']=$rankThread;
		$this->render('index', $params);
	}
	public function actionAnswer()
	{
		if(Yii::app()->request->isPostRequest){
			$userPhone = yii::app()->user->getState('msisdn');
			$ansId = $_POST['answer'];
			if(empty($ansId)){
				//khong chon cau tra loi
				$redirect = Yii::app()->createUrl('/event/play', array('notrep'=>1,'askid'=>$_POST['askid']));
				$this->redirect($redirect);
				Yii::app()->end();
			}
			$resAnswer = GameEventAnswerModel::model()->findByPk($ansId);
			if($resAnswer->is_true){
				$point = GameEventQuestionModel::model()->findByPk($_POST['askid'])->point;
			}else{
				$point = 0;
			}
			$completedTime = date('Y-m-d H:i:s');
			$gameEventLog = new GameEventUserLogModel();
			$gameEventLog->setAttribute('user_phone', $userPhone);
			$gameEventLog->setAttribute('ask_id', $_POST['askid']);
			$gameEventLog->setAttribute('answer_id', $ansId);
			$gameEventLog->setAttribute('thread_id', $_SESSION['thread']);
			$gameEventLog->setAttribute('point', $point);
			$gameEventLog->setAttribute('started_datetime', $_SESSION['startTime']);
			$gameEventLog->setAttribute('completed_datetime', $completedTime);
			$gameEventLog->save();
			$this->_removeQuestion($_POST['askid']);
			$_SESSION['count'] +=1;
		}
		$this->redirect('/event/play');
	}
	public function actionShare()
	{
		$userPhone = yii::app()->user->getState('msisdn');
		$isShare = GameEventActivityModel::isShareOnDay($userPhone, date('Y-m-d'));
		if($isShare){
			$this->redirect('/event/play/thank');
			Yii::app()->end();
		}
		$error=0;
		$isSend=false;
		if(Yii::app()->request->isPostRequest){
			$isSend=0;
			$phoneList = $_POST['phone_list'];
			if($phoneList!=''){
				$phoneArr = explode(',', $phoneList);
				if($phoneArr){
					foreach ($phoneArr as $key => $value){
						$phone = Formatter::formatPhone($value);
						if(Formatter::isVinaphoneNumber($phone)){
							$isSend++;
							$sms = new SmsClient();
							$content = 'DV Chacha - Vinaphone kinh chao Quy Khach. Quy Khach vua duoc thue bao '.$userPhone.' moi dua tai trong chuong trinh "Vui cung Chacha - Nhan qua nhu y" voi giai thuong hap dan len toi 20 trieu dong. Chi tiet moi Quy Khach xem tai day http://m.chacha.vn/event';
							$sms->sentMT("9234", $phone, 0, $content, 0, "", time(), 9234);
						}
					}
					if($isSend>0){
						//chia se it nhat duoc 1 so vinaphone
						$gameActivity = new GameEventActivityModel();
						$gameActivity->setAttribute('user_phone', $userPhone);
						$gameActivity->setAttribute('activity', 'share');
						$gameActivity->setAttribute('point', 1);
						$gameActivity->setAttribute('updated_time', date('Y-m-d H:i:s'));
						$gameActivity->setAttribute('note', $phoneList, PDO::PARAM_STR);
						$gameActivity->save();
						$this->redirect('/event/play/thank');
					}
				}
			}else{
				//ko có sô dt nao
				$error=1;
			}
		}
		$this->render('share', array(
				'isShare'=>$isShare,
				'error'=>$error,
				'isSend'=>$isSend
		));
	}
	public function actionThank()
	{
		$this->render('thank');
	}
	protected function _removeQuestion($qtId)
	{
		if($_SESSION['qt_list'] && count($_SESSION['qt_list'])>0){
			$data = array();
			foreach ($_SESSION['qt_list'] as $key => $value){
				if($value==$qtId){
					unset($_SESSION['qt_list'][$key]);
				}else{
					$data[]=$value;
				}
			}
			$_SESSION['qt_list'] = $data;
		}
	}
}