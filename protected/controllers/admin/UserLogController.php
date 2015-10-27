<?php

class UserLogController extends Controller
{

    public function init()
	{
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  User Activity ") ;
        $this->slidebar=array(
            array('label'=>Yii::t('admin', 'Danh sách thành viên'), 'url'=>array('user/index')),
			array('label'=>Yii::t('admin', 'Tra cứu log'), 'url'=>array('userLog/index')),
        );
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        //$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        $pageSize = 10;
        Yii::app()->user->setState('pageSize',$pageSize);
        $userPhone = false;
        $user = false;
        $get = Yii::app()->request->getParam('AdminUserActivityModel');
        if(isset($get['user_phone'])){
        	$userPhone = $get['user_phone'];
        	$userPhone = Formatter::formatPhone($userPhone);
        	$user = AdminUserModel::model()->findByAttributes(array('phone'=>$userPhone));
        }

       $model=new AdminUserActivityModel('search');
        if($user){
        	$model->unsetAttributes();  // clear any default values
        	$model->setAttribute("user_id", $user->id);
        	if(isset($_GET['AdminUserActivityModel'])){
        		$model->attributes=$_GET['AdminUserActivityModel'];
        		$loged_time = trim($_GET['AdminUserActivityModel']['loged_time']);
        		$splited = explode("-",$loged_time);
        		if (count($splited)>1)
        		{
        			$fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
        			$toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');
        			// $model->setAttribute("loged_time", array(0=>$fromDate,1=>$toDate));
        			//
        			//$model->loged_time = ">= $fromDate and <= $toDate";
        			$model->loged_time = array($fromDate.' 0:0:0',$toDate.' 23:59:59');
        		}
        		else{
        			if ($loged_time!="")
        					$model->loged_time = DateTime::createFromFormat('m/j/Y', $loged_time)->format('Y-m-j');
        			}

        			}
        }


		$this->render('index',array(
			'model'=>$model,
            'user'=>$user,
            'pageSize'=>$pageSize,
		));
	}

}
