<?php
return CMap::mergeArray(
		require(dirname(__FILE__) . "/main.php"), 
		array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'NhacVN Console',
        'import'=>array(
            'application.models.db.*',
            'application.components.common.*',
            'application.extensions.yii-mail.*',
            'application.vendors.utilities.*',
        ),
        'components'=>array(
			'session' => array(
            	'class'=>'CHttpSession',
		    ),
        ),
        'params' => array(
        ),
	)
);
?>
