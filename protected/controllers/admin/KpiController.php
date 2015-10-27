<?php
class KpiController extends  Controller
{
	public $time;
	
	public function init() {
		parent::init();
		if (isset($_GET['time']) && $_GET['time'] != "") {
			$createdTime = $_GET['time'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate, 'to' => $toDate);
			} else {
				$time = explode("/", trim($_GET['time']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = $time;
			}
		} else {
			$fromDate = $toDate = date("Y-m-d");
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
	}
	
	public function actionLogAction()
	{
		$model = new AdminLogActionModel("search");
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['AdminLogActionModel'])){
			$model->attributes = $_GET['AdminLogActionModel'];
		}
		$action = AdminLogActionModel::model()->getList();
		$this->render('logAction',compact("model","action"));
	}
	
	public function actionViewLogAction($id)
	{
		$model = AdminLogActionModel::model()->findByAttributes(array("id"=>$id));
		$this->render('viewLogAction',compact("model"));
	}
}

