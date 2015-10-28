<?php
return CMap::mergeArray ( require (dirname ( __FILE__ ) . "/main.php"), array (
		"id" => "nhenhang",
		"name" => "nhenhang",
		"controllerPath" => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "web",
		"viewPath" => _APP_PATH_ . DIRECTORY_SEPARATOR . "protected" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "web",
		'theme' => 'default',
		'defaultController' => 'home',
		// autoloading model and component classes
		"import" => array (
				"application.models.web.*",
				"application.components.web.*",
                "application.vendors.FacebookSDK.*",
                //"application.vendors.Google.*"
				'application.extensions.yii-mail.*',
				'application.vendors.Hashids.*',
				'application.widgets.web.common.CPagination'
		),
		
		"components" => array (
				"errorHandler" => array (
						"errorAction" => "index/error" 
				),
				'user' => array(
					// enable cookie-based authentication
					'allowAutoLogin' => true,
					'class' => 'WebUser',
					'authTimeout' => 3600 * 24 * 30
				),
				"urlManager" => array (
						"urlFormat" => "path",
						"rules" => array (
							'sitemap/<t:(song|video|genre|artist|album)><p:\d+>' => array('sitemap/xml', 'urlSuffix'=>'.xml', 'caseSensitive'=>false) ,
							'sitemap.xml' => 'sitemap/xml',
							'search'=>'search/index',
							'the-loai/<category:[a-zA-Z0-9-_]+>'=>'home/category',
							'Truyen-<slug:[a-zA-Z0-9-_]+>'=>'story/view',
							'u/<u:[a-zA-Z0-9-_]+>'=>'user/detail',
							'u/<u:[a-zA-Z0-9-_]+>/nhac-cua-toi'=>'user/myMusic',
							'u/<u:[a-zA-Z0-9-_]+>/nghe-gan-day/<type:(song|video|album)>'=>'user/recent',
							'u/<u:[a-zA-Z0-9-_]+>/nghe-gan-day'=>'user/recent',
							'u/<u:[a-zA-Z0-9-_]+>/profile'=>'user/profile',
                            'tag/<name:[a-zA-Z0-9-]+>-<id:[\d]+>' => 'tag/index',
							'nghe-si'=>'artist',
							'nghe-si/<genre_artist:(viet-nam|au-my|tat-ca|chau-a)>/<keyword:[a-zA-Z0-9-]+>'=>'site/UrlArtist',
							'hot-list'=>'hotlist',
							'hot-list/<title:[a-zA-Z0-9-]+>-<id:[\d]+>'=>'topContent/view',
							'html/<title:[a-zA-Z0-9-]+>-<id:[\d]+>'=>'html/view',
							'bang-xep-hang-am-nhac'=>'chart',
							'<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/tuan-<week:[\d]+>'=>'site/url',
							'<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url',

							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<gt:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>'=>'site/url2',
							'<action:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>-<code:[a-zA-Z0-9-]+>/<action_sub:[a-zA-Z0-9-]+>'=>'site/url3',
						),
						"showScriptName" => false 
						// "urlSuffix"=>".html",
				),
				'clientScript' => array (
						//'class' => 'ext.minScript.components.ExtMinScript',
						
						/*'minScriptUrlMap' => array (
								'/loadJs/' => false,
								'/jwplayer/' => false 
						) */
				),
				'mail' => array(
						'class' => 'application.extensions.yii-mail.YiiMail',
						'transportType'=>'smtp', /// case sensitive!
						'transportOptions'=>array(
								'host'=>'smtp.gmail.com',
								'username'=>'noreply.vn@gmail.com',
								'password'=>'VegaMusic2015!@#',
								'port'=>'465',
								'encryption'=>'tls',
						),
						'viewPath' => 'application.views.mail',
						'logging' => true,
						'dryRun' => false
				),				
		),
		'controllerMap' => array (
				/*'min' => array (
							'class' => 'ext.minScript.controllers.ExtMinScriptController' 
							//'minScriptComponent'=>'clientScript',
						),*/
				'mix' => array (
						'class' => 'application.components.common.MixController'
				)
		),
		
		// Module
		"modules" => array (),
		
		"params" => array (
				'defaultLanguage' => 'vi_vn',
				// Login config
				'cacheTime' => 3600,
				'login' => array (
						'limit_block' => 5, // So lan login fail bi block
						'time_block' => 10  // Thoi gian block (phut)
            	),// Thoi gian block (phut)
            	'limit_chart_home_number'=>5,
				'htmlMetadata' => array (
						'title' => 'Nhenhang.com',
						'description' => 'Website đọc truyện hay nhất, nhanh nhất',
						'keywords' => 'nhạc, nhac , music, nghe nhạc, nghe nhac, tìm nhạc, tim nhac, tải nhạc, tai nhac, nhạc chất lượng cao, nhac chat luong cao, nhạc hot nhất, nhac hot nhat, nhạc hay nhất, nhac hay nhat, lời bài hát, loi bai hat, lossless, lyric, download, upload, album, ca sĩ, ca si...'
				),
                'album'=>array(
                    'number_per_page'=>20
                ),
                'video'=>array(
                    'number_per_page'=>20
                ),
                'constLimit' => array(
                    'max.button.search.number'=>5,
                    'search.number.of.items' => 12,
                    'search.number.of.songs' =>30,
                    'search.number.of.albums' =>40,
                    'search.number.of.videos' =>40,
                    'search.number.of.artists' =>10,
                    'search.number.of.playlists' =>40,
                    'numberArtistsPerPage'=>12,
                    'numberArtistsPerPage'=>10,
                    'numberNewsInArtistPage'=>10,
					'numberSongsPerPage'=>10
                ),
                'cmd.listen.song' => 'play_song',
                'cmd.listen.album' => 'play_album',
                'cmd.listen.video' => 'play_video',
                'cmd.listen.playlist' => 'play_playlits',
		)
) );
?>
