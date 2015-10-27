<?php
class UploadController extends Controller
{
    public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Upload Manager");
	}
	
	public function actionUploadFile()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		$allowedExtensions = Yii::app()->request->getParam('allowedExtensions', 'jpg');
		$allowedExtensions = explode(',', $allowedExtensions); //array("jpg","jpeg","gif","exe","mov" and etc...
	
		$sizeLimit = Yii::app()->request->getParam('sizeLimit', 100 * 1024 * 1024);		
		
		$pathUpload = Yii::app()->params['storage']['baseStorage'].DS."tmp".DS;
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($pathUpload);
		
		echo CJSON::encode($result);
		exit;
	}
}
