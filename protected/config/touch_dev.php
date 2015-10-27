<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/touch.php'),
    array(
        'components'=>array(
                'log'=>array(
					'class'=>'CLogRouter',
					  'routes'=>array(
						array(
						  'class'=>'CFileLogRoute',
						  'levels'=>'error, warning, trace',
						),
						array( // configuration for the toolbar
						  'class'=>'ext.yiidebugtb.XWebDebugRouter',
						  'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
						  'levels'=>'error, warning, trace, profile, info',
                            'allowedIPs'=>array('::1','127.0.0.1','113.160.24.110','118.70.124.143','192\.168\.42\.[0-9]{1,3}','113\.160\.0[0-255]\.0[0-255]'),
						),
					  ),
				),
				'urlManager'=>array(
					'showScriptName'=>true,
				),
        		 'db' => array(
        				'enableProfiling'=>true,
        				'enableParamLogging'=>true,
        				//'schemaCachingDuration' =>0,
        		),
        ),
    )
)

?>

