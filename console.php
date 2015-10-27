<?php
include_once 'cons.php';

$config=_APP_PATH_.'/protected/config/console.php';
defined('YII_DEBUG') or define('YII_DEBUG',false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createConsoleApplication($config)->run();