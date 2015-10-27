<?php

class DefaultController extends Controller
{
	const _PATH_ICONS_UPLOAD = '/music_storage/chacha2.0/radio/icons/';
	//const _PATH_ICONS_UPLOAD = 'E:\phuongnv\Vega\chacha_cloud\src\trunk\chacha\data\tmp\\';
	const _URL_ICONS_RADIO = 'http://s2.chacha.vn/radio/icons/';
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionUploadAvartar()
	{
		$id = Yii::app()->request->getParam('id',0);
		$type = Yii::app()->request->getParam('type','channel');
		if($type=='genre'){
			$pathUpload = self::_PATH_ICONS_UPLOAD."genre".DS;
		}elseif($type=='collection'){
			$pathUpload = self::_PATH_ICONS_UPLOAD."collection".DS;
		}elseif($type=='playlist'){
			$pathUpload = self::_PATH_ICONS_UPLOAD."playlist".DS;
		}elseif($type=='album'){
			$pathUpload = self::_PATH_ICONS_UPLOAD."album".DS;
		}else{
			$pathUpload = self::_PATH_ICONS_UPLOAD."channel".DS;
		}
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$allowedExtensions = array("png");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 100 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUploadRadio($pathUpload, $id);
		if($result['success']){
			$result['data'] = self::_URL_ICONS_RADIO.$type.'/'.$result['filename'];
		}else{
			$result['data']='';
		}
		echo CJSON::encode($result);
	}
}