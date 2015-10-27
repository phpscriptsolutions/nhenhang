<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/wap.php'), array(
                    'id' => 'wap',
                    'name' => 'wap touch',
                    'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "touch",
                    'viewPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "touch",
                    'defaultController'=>'index',
                    'theme' => 'grey',
                    'components' => array(
                        'errorHandler' => array(
                            'errorAction' => 'site/error',
                        ),
                        'mail' => array(
                            'class' => 'application.extensions.yii-mail.YiiMail',
                            'transportType'=>'smtp', /// case sensitive!
                            'transportOptions'=>array(
                                'host'=>'smtp.gmail.com',
                                'username'=>'noreply.nhac.vn@gmail.com',
                                'password'=>'VegaMusic2015!@#',
                                'port'=>'465',
                                'encryption'=>'tls',
                            ),
                            'viewPath' => 'application.views.mail',
                            'logging' => true,
                            'dryRun' => false
                        ),
                    ),
                    //Module
                    'modules' => array(
                    ),
                    // autoloading model and component classes
                    'import' => array(
                        'application.extensions.yii-mail.*',
                        'application.vendors.Hashids.*',
                    ),
                    'params' => array(
                        'defaultLanguage' => 'vi_vn',
                        'pageSize' => 10,
                    	'domain'=>array(
                    		'main_site' => '',
                    	),
                    	'limit_substring'=>15,
                    	'limit_substring_title'=>20,
                    	'numberPerPage' => 10,
                        'pageSizeAjax'  =>6,
                    	'MSG_NO_DETECT' => 'Please login to use this function. Thank you!',
                    	'MSG_ERR_CHARG' => 'An error occurred while processing. Please try again later.',
                        'cmd.listen.song' => 'play_song',
                        'cmd.listen.album' => 'play_album',
                        'cmd.listen.video' => 'play_video',
                        'cmd.listen.playlist' => 'play_playlits',
                    ),
                )
);
?>
