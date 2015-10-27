<?php
return array(
    'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',
					'logFile' => 'error.log',
				),
				array(
						'class'=>'CFileLogRoute',
						'levels'=>'error',
						'categories' => 'system.db.CDbCommand',
						'logFile' => 'db.log',
				),
			),
		),
        'mongodb' => array(
            'class' => 'EMongoClient',
            'server' => 'mongodb://localhost:27011',
            //'server' => 'mongodb://10.0.9.194:27017',
            'db' => 'nhac_vn'
        ),
		'db' => array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=nhenhang',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'class'=>'CDbConnection',
			'enableProfiling'=>false,
			'enableParamLogging'=>false,
			'schemaCachingDuration' =>3600,
		),
		
		/*'cache'=>array(
                'class'=>'system.caching.CMemCache',
                'servers'=>array(
                    array('host'=>'10.0.9.194', 'port'=>11211),
                ),
        ),*/
    ),
    'params' => array (
    		'local_mode'=>1,
			'base_url'=>'http://nhenhang',
			'mobile_base_url'=>'http://192.168.42.89:1213',
            'mobile_touch_url'=>'http://192.168.42.89:1214',
            'price'=>array(
                            'songListen'=>'1000',
                            'songDownload'=>'2000',
                            'videoListen'=>'2000',
                            'videoDownload'=>'3000',
                            'rtDownload'=>'2000',
                            'albumListen' => '4000',
                            'songGiftListen'=>'600'
                        ),
            'smsClient'=>array(
                           // 'smsWsdl'=>'http://192.168.1.243:8080/api/soap',
			    			'smsWsdl'=>'http://192.168.241.67:8080/api/soap',
                            'username'=>'chacha1',
                            'password'=>'123chacha456',
                            'serviceName'=>'IMUZIK',
                        ),    							
 			'storage'=>array(
                'cdnUrlCache' => 'http://v2.cdn.nhac.vn/kv0puCNE4oNNfn7YhOpK/',
                'cdnUrlCrop' => 'http://v2.cdn.nhac.vn/ytVCKi1WUHxyrw78fRZG/',
                'cdnUrlResize' => 'http://v2.cdn.nhac.vn/jXitUPK9cvjCkkVYrFPL/',
                            'staticDir' => '/music_static/v1/',
                            'staticUrl' => 'http://nhacvn.vn/music_static/v1/',
 			    'baseStorage'=>'/music_static/v1/',

                            'albumDir' => '/music_static/v1/album',
                            'albumUrl' => 'http://s.nhac.vn/v1/album/',
			    'albumUrl3Gp' => '',
                            'albumUrlMp3' => '',

                            'artistDir' => '/music_static/v1/artists',
                            'artistUrl' => 'http://s.nhac.vn/v1/artists/',

                            'songDir' => '/music_static/v1/songs',
                            'songUrl' => 'http://s.nhac.vn/v1/songs/',
							'songUrlRTSP' => '',

                            'userDir' => '/music_static/v1/users/',
                            'userUrl' => 'http://s.nhac.vn/v1/users/',

                            'videoDir' => '/music_static/v1/videos',
                            'videoUrl' => 'http://s.nhac.vn/v1/videos/',
							'videoUrlRTSP' => '',
                            'videoImageUrl' => 'http://s.nhac.vn/v1/videos/',
							
			    			'videoPlaylistUrl'=>'http://s.nhac.vn/v1/videoplaylist/',
                            'videoPlaylistDir'=>'/music_static/v1/videoplaylist',

                            'newsDir' => '/music_static/v1/news',
                            'newsUrl' => 'http://s.nhac.vn/v1/news/',
							
		   	    			'playlistDir'=>'/music_static/v1/playlist',
                            'playlistUrl'=>'http://s.nhac.vn/v1/playlist/',
							
                            'ringtoneDir' => '/music_static/v1/ringtones',
                            'ringtoneUrl' => 'http://s.nhac.vn/v1/ringtones/',

						    'rbtDir' => '',
						    'rbtUrl' => '',
 					
					 	    'radioDir'=>'/music_static/v1/radio/icons',
					 	    'radioUrl'=>'http://s.nhac.vn/v1/radio/icons/',
			
						    'newsEventDir' => '/music_static/v1/event',
                            'newsEventUrl' => 'http://s.nhac.vn/v1/event/',
							'bannerDir'=>'/music_static/v1/banner',
                            'bannerUrl'=>'http://s.nhac.vn/v1/banner/' ,
                            'topContentDir'=>'E:\phuongnv\music_storage\music_portal\topcontent',
                            'topContentUrl'=>'http://192.168.42.89:3101/cdn_nhacvn/topcontent/' ,
							
                    ),
            
            // bm
            'bmConfig'=>array(
				'remote_wsdl'       => 'http://bm.metfone.local',
                'remote_username'	=> 'chacha',
                'remote_password'	=> 'chacha',
            ),

            // solr search
            'solr.server.host'	=> '192.168.1.53',
            'solr.server.port'	=> 8983,
            'solr.server.path'	=> '/solr/',
        )
);
?>
