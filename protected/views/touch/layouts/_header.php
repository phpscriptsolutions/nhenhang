<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="/touch/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<meta name="robots" content="follow, index" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="vi" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<meta name="MobileOptimized" content="100" />

<?php Yii::app()->SEO->renderMeta();?>
<title><?php echo Yii::t('wap',(isset($this->htmlTitle))?$this->htmlTitle:'Nhac.vn');?></title>
<script type="text/javascript" src="<?php echo Yii::app()->createUrl("site/loadLang") ?>"></script>

<?php
$ie=false;
$iOS = false;
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
if (count($matches)>1){
	$ie=true;
}else if(stripos($_SERVER['HTTP_USER_AGENT'],"iPod") || stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")
	||stripos($_SERVER['HTTP_USER_AGENT'],"iPad")){
	$version = preg_replace("/(.*) OS ([0-9]*)_(.*)/","$2", $_SERVER['HTTP_USER_AGENT']);
	if($version<7) {
		$iOS = true;
	}
}
//$deviceInfo = $this->device->getBasicInfo();
$deviceInfo = array();
$deviceInfo['device_os_version'] = '10';
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/touch/css/style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/touch/css/main.css');
Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl.'/touch/css/default.css' );
if($ie){
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/jquery.min.js');
}else{
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/zepto/zepto.min.js');
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/common.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/web/js/hashids.min.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/swipe-page.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/base64.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/touch/js/base.js');



Yii::app()->clientScript->registerScript("main","
		var deviceOs = '". ($this->deviceOs?(strtoupper($this->deviceOs)):'')."';
		var userId	= ".((!Yii::app()->user->isGuest)?Yii::app()->user->getId():0).";
		var msgDetect = '".Yii::app()->params['MSG_NO_DETECT']."';
		var urlLimit = '".Yii::app()->createUrl('ajax/limit')."';

		var debug_mode = '".YII_DEBUG."';
		var page_id = '".Yii::app()->controller->id."-".$this->action->id."';
		var os = '".$this->deviceOs."';
		var os_version = '".$this->deviceOsVer."';
		var rootPath = '".Yii::app()->params['base_url']."';
        var has_key='".Yii::app()->params["hash_url"]."';
",CClientScript::POS_HEAD);

if($iOS) {
	Yii::app()->clientScript->registerScript('ios-fixed','

	jQuery(window).scroll(function() {
		//if ( focusing ) $("header").css({ "top": jQuery(document).scrollTop() });
	});
	',CClientScript::POS_READY);
}
?>

</head>
<body>
<?php include_once '_ga.php';?>
<?php include_once '_social_connect.php'?>
<a id="top"></a>
<?php echo $content;?>
<div id="popup_mask" class="none" style="height: 1500px;"></div>
<div id="vg_popup" class="none"></div>
<div id="overlay-bg"></div>
<?php //include '_ga.php'; ?>
<?php //include '_ads_marketing.php'; ?>
<?php /*
<script type="text/javascript">
	$(function() { $.smartbanner() } )
</script>
*/?>
<?php include_once '_bottom.php'?>
</body>
</html>