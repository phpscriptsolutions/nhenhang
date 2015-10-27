<?php
return CMap::mergeArray ( require (dirname ( __FILE__ ) . '/main.php'), array (
		'id' => 'wap',
		'name' => 'wap',
		'controllerPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "wap",
		'viewPath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "wap" . DIRECTORY_SEPARATOR . "default",
		// 'defaultController'=>'featured',
		'theme' => 'default',
		// autoloading model and component classes
		'import' => array (
				'application.models.wap.*',
				'application.components.wap.*' 
		),
		
		'components' => array (
				'urlManager' => array (
						'urlFormat' => 'path',
                        "rules" => array (
                            'search' =>'search/index',
							'u/<u:[a-zA-Z0-9-_]+>'=>'user/profile',
							'u/<u:[a-zA-Z0-9-_]+>/nhac-cua-toi'=>'account/myplaylist',
							'u/<title:[a-zA-Z0-9-_]+>/profile'=>'account/view',
							'u/<u:[a-zA-Z0-9-_]+>/nghe-gan-day'=>'user/recent',
							'u/<u:[a-zA-Z0-9-_]+>/nghe-gan-day/<type:(song|video|album)>'=>'user/recent',
                            'tag/<name:[a-zA-Z0-9-]+>-<id:[\d]+>' => 'tag/index',
							'nghe-si'=>'artist',
							'nghe-si/<genre_artist:(viet-nam|au-my|tat-ca|chau-a)>/<keyword:[a-zA-Z0-9-]+>'=>'site/UrlArtist',
							'hot-list'=>'hotlist',
							'hot-list/<title:[a-zA-Z0-9-]+>-<id:[\d]+>'=>'topContent/view',
							'html/<title:[a-zA-Z0-9-]+>-<id:[\d]+>'=>'html/view',
							'bang-xep-hang-am-nhac'=>'chart',
                            '<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url',
							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<gt:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/<action_sub:[a-zA-Z0-9-]+>'=>'site/url3'
                        ),
						'showScriptName' => false 
				),
				'user' => array (
						// enable cookie-based authentication
						'allowAutoLogin' => true,
						'authTimeout' => 3600 * 24 * 30,
						'loginUrl' => array (
								'account/login' 
						) 
				),
				'errorHandler' => array (
						'errorAction' => 'site/error' 
				),
				'clientScript' => array (
					'class' => 'ext.minScript.components.ExtMinScript',
					// 'minScriptRuntimePath'=>'protected/runtime/minScript',
					// 'minScriptController'=>'min',
					// 'minScriptDebug'=>false,
					// 'minScriptBaseUrl'=>'',
					// 'scriptMap'=>array(),

					'minScriptUrlMap' => array (
						'/loadJs/' => false,
						'/jwplayer/' => false,
						'/stylejwp/' => false
					)
				),
		),
		'controllerMap' => array (
				'min' => array (
					'class' => 'ext.minScript.controllers.ExtMinScriptController'
					//'minScriptComponent'=>'clientScript',
				),
				'mix' => array (
						'class' => 'application.components.common.MixController'
				)
		),
		'modules' => array (),
		'params' => array (
				'defaultLanguage' => 'vi_vn',
				'cacheTime' => 3600,
				
				// limit items on page
				'numberSongsPerPage' => 6,
				'htmlMetadata' => array (
						'title' => '',
						'keywords' => '',
						'description' => '' 
				) 
		) 
) );
?>
