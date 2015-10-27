<?php
//session_start();
include_once 'cons.php';
//require_once _APP_PATH_.DS.'protected'.DS.'vendors'.DS.'Google'.DS.'autoload.php';
defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

$deviceTypes  = array('computer','tablet', 'phone','normal');
if(isset($_GET['layout']) && in_array($_GET['layout'], $deviceTypes)){
	$_SESSION['deviceType'] = $_GET['layout'];
}
if(isset($_SESSION['deviceType'])){
	$deviceType = $_SESSION['deviceType'];
}else{
	include_once _APP_PATH_."/protected/components/common/Mobile_Detect.php";
	$detect = new Mobile_Detect;
	$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
	$_SESSION['deviceType'] = $deviceType;
}
if ( !in_array($deviceType, $deviceTypes) ) { $deviceType = 'computer'; }

if('computer'==$deviceType){
	ini_set('session.name', 'WEB');
	$config=_APP_PATH_.'/protected/config/web.php';
}else{
	ini_set('session.name', 'MOBILE');
	$config=_APP_PATH_.'/protected/config/touch.php';
}
require_once($yii);
Yii::createWebApplication($config)->run();

