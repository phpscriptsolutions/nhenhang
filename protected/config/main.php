<?php
return CMap::mergeArray(
            require(dirname(__FILE__) . '/local.php'), array(
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'runtimePath' => _APP_PATH_ . DIRECTORY_SEPARATOR . "runtime",
            'sourceLanguage' => 'en_us',
            'language' => 'vi_vn',
            // preloading 'log' component
            'preload' => array('log'),
            // autoloading model and component classes

            'import' => array(
                'application.models.db._base.*',
                'application.models.db.*',
                'application.components.common.*',
                'application.vendors.utilities.*',
            ),
            // application components
            'components' => array(
                'coreMessages'=>array(
                    'basePath'=>null,
                ),
                "SEO"=>array(

                    'class'=>'application.components.common.SEO'
                ),
                // enable URLs in path-format
				"urlManager" => array (
						"urlFormat" => "path",
						"rules" => array (),
						"showScriptName" => false 
						// "urlSuffix"=>".html",
				),
				'request' => array(
			        'class' => 'application.components.common.HttpRequest',
			        'enableCsrfValidation' => true,
			    ),
                'cache_file'=>array(
                    'class' => 'system.caching.CFileCache'
                )
            ),

            // module config
            'modules' => array(              
            ),
            // application-level parameters that can be accessed
            'params' => array(
                'local_mode'=>0,
            	'hash_url'=>'VegaMusic',
                'hash_key_player'=>'=&**#VEGA_PLAYER_secrect8743%%',
                'cacheTime' => 3600,
                // this is used to support multi lanuages
                'languages' => array('en_us' => 'English', 'vi_vn' => 'Tiếng Việt'),
                'defaultLanguage' => 'vi_vn',
                'phone.country.code'=>'84',
                'imageSize' => array(// order tu thap len cao
                    's5' => 50, 's4' => 100, 's3' => 150, 's2' => 320, 's1' => 640, 's0' => '1024'
                ),
                'videoResolutionRate' => "16:9", // ty le width:height cua video
                "video.profile.default" => array(
                    'web' => array(6,7,8,9),
                    'iphone' => array(3),
                    'android' => array(3, 6, 7, 8),
                    'rtsp_mp4' => array(2, 5),
                    'rtsp_3gp' => array(1, 4),
                ),
                "song.profile.default" => array(
                    'web' => array(4,1),
                    'iphone' => array(2),
                    'rtsp_3gp' => array(3, 5),
                ),
                'genreType' => array('all' => 'all', 'song' => 'song', 'album' => 'album', 'video' => 'video'),
                'genre'=>array(
                    'VN'=>1,
                    'QTE'=>33,
                    'CA'=>60
                ),
                'collection_id'=>array(
                    'VIDEO_HOT'=>3,
                    'VIDEO_NEW'=>4,
                    'ALBUM_NEW'=>2,
                    'ALBUM_HOT'=>1,
                ),
                'password.min.length'=>8,
                'username.min.length'=>5,
                'username.max.length'=>32,
                'playlistname.max.length'=>160,
                'forgotpass.max'=>3,//so lan duoc request ma de cap lai mat khau
                'paging'=>array(
                    'pager_max_button_count'=>5,
                    'album_number_per_page'=>12,
                    'video_number_per_page'=>12,
                    'items_list_song'=>30,
                    'items_list_album'=>48,
                    'items_list_video'=>48,
                    'items_list_topcontent'=>12
                ),
                'social'=>array(
                    'facebook'=>array(
                        'id'=>'1656805361206325',
                        'secret'=>'a4a09e8d679c5a4e1971d653fdc2ee7b'
                    ),
                    'google'=>array(
                        'client_id'=>'268958024357-7ob4vv6rkn8giru5qidj3ncspst1rmah.apps.googleusercontent.com',
                        'client_secret'=>'LFWx-hnKffHwEfFGw21NIU5i',
                        'redirect_uri'=>'http://nhac.vn/google/login'
                    )
                ),
				'position' => array(
						'web' => array(
								"web_player"  => "640x60 Hiển thị trên player",
						),
						'wap' => array(
						)
				),
            	'alert_content_limited'=>'Xin lỗi Quý khách! {content} bị hạ tạm thời. Mong Quý khách vui lòng quay lại sau. Trân trọng cảm ơn!',
                'storage_path' => array(
                    'song' => array(
                        '' => array('min' => 0, 'max' => 9999999999999),
                    ),
                    'video' => array(
                        '' => array('min' => 0, 'max' => 9999999999999),
                    ),
                    'album' => array(
                        '' => array('min' => 0, 'max' => 9999999999999),
                    ),
                ),
                'token_renew_pass' => 'token_renew_pass',
            ),
		)
);
