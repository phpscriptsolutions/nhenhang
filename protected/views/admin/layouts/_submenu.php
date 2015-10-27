<?php

return array(
    'song' => array(
        array(
            "url" => array("route" => "/song/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),        
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/song/index", 'params' => array('AdminSongModel[status]' => AdminSongModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),
        ),
    ),
    /* 'radio' => array(
        array(
            "url" => array("route" => "/radio/channel/create"),
            "label" => Yii::t('admin', 'Tạo mới kênh'),
            "visible" => UserAccess::checkAccess("Radio-ChannelCreate", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/radio/channel"),
            "label" => Yii::t('admin', 'Danh sách kênh'),
            "visible" => UserAccess::checkAccess("Radio-ChannelIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/weather/index"),
            "label" => Yii::t('admin', 'Thời tiết'),
            "visible" => UserAccess::checkAccess("WeatherIndex", Yii::app()->user->Id),
        ),
    ), */
    'video' => array(
        array(
            "url" => array("route" => "/video/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/video/index", 'params' => array('AdminVideoModel[status]' => AdminVideoModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id),
        ),
    ),
    'videoPlaylist' => array(
        array(
            "url" => array("route" => "/videoPlaylist/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("VideoPlaylistIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/videoPlaylist/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("VideoPlaylistCreate", Yii::app()->user->Id),
        ),
    ),
    'album' => array(
        array(
            "url" => array("route" => "/album/index"),
            "label" => Yii::t('admin', 'Tất cả'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::WAIT_APPROVED)),
            "label" => Yii::t('admin', 'Chờ duyệt'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::ACTIVE)),
            "label" => Yii::t('admin', 'Đã duyệt'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/index", 'params' => array('AdminAlbumModel[status]' => AdminAlbumModel::DELETED)),
            "label" => Yii::t('admin', 'Đã xóa'),
            "visible" => UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id),
        ),
    ),
    'album_detail' => array(
        array(
            "url" => array("route" => "/album/view", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Thông tin album'),
            "visible" => UserAccess::checkAccess("AlbumView", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/album/songList", "params" => array('id' => Yii::app()->request->getParam('id'))),
            "label" => Yii::t('admin', 'Danh sách bài hát'),
            "visible" => UserAccess::checkAccess("AlbumSongList", Yii::app()->user->Id),
        ),
    ),
    'artist' => array(
        array(
            "url" => array("route" => "/artist/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("ArtistIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/artist/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("ArtistCreate", Yii::app()->user->Id),
        ),
    ),
    'collection' => array(
        array(
            "url" => array("route" => "/Collection/index"),
            "label" => Yii::t('admin', 'Bộ sưu tập'),
            "visible" => UserAccess::checkAccess("CollectionIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/collection/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("CollectionCreate", Yii::app()->user->Id),
        ),
    ),
    'topContent' => array(
        array(
            "url" => array("route" => "/topContent/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("TopContentIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/topContent/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("TopContentCreate", Yii::app()->user->Id),
        ),
    ),
    'chart' => array(
        array(
            "url" => array("route" => "/Chart/index"),
            "label" => Yii::t('admin', 'Bảng xếp hạng'),
            "visible" => UserAccess::checkAccess("ChartIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/chart/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("ChartCreate", Yii::app()->user->Id),
        ),
    ),
    'genre' => array(
        array(
            "url" => array("route" => "/genre/index"),
            "label" => Yii::t('admin', 'Danh sách'),
            "visible" => UserAccess::checkAccess("GenreIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/genre/create"),
            "label" => Yii::t('admin', 'Tạo mới'),
            "visible" => UserAccess::checkAccess("GenreCreate", Yii::app()->user->Id),
        ),
    ),
    /* 'user' => array(
        array(
            "url" => array("route" => "/userSubscribe/index"),
            "label" => Yii::t('admin', 'Danh sách thuê bao'),
            "visible" => UserAccess::checkAccess("userSubscribeIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/userLog/index"),
            "label" => Yii::t('admin', 'Tra cứu log người dùng'),
            "visible" => UserAccess::checkAccess("UserLogIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/transLog/index"),
            "label" => Yii::t('admin', 'Tra cứu log giao dịch'),
            "visible" => UserAccess::checkAccess("TransLogIndex", Yii::app()->user->Id),
        ),
        array(
            "url" => array("route" => "/transLogUser/viewLog"),
            "label" => Yii::t('admin', 'Chăm sóc khách hàng'),
            "visible" => UserAccess::checkAccess("TransLogUserViewLog", Yii::app()->user->Id),
        ),
    ),   */  
    'cms' => array(
        array(
            "url" => array("route" => "/news"),
            "label" => Yii::t('admin', 'Tin tức'),
            "visible" => UserAccess::checkAccess("NewsIndex", Yii::app()->user->Id)
        ),
    	array(
    		"url" => array("route" => "/newsEvent/index"),
    		"label" => Yii::t('admin', 'SlideShow'),
    		"visible" => UserAccess::checkAccess("NewsEventIndex", Yii::app()->user->Id)
    	),
    	array(
    		"url" => array("route" => "/html/index"),
    		"label" => Yii::t('admin', 'HTML'),
    		"visible" => UserAccess::checkAccess("HtmlIndex", Yii::app()->user->Id)
		),
    	array(
    		"url" => array("route" => "/banner/index"),
    		"label" => Yii::t('admin', 'Banner'),
			"visible" => UserAccess::checkAccess("BannerIndex", Yii::app()->user->Id)
		),
        array(
            "url" => array("route" => "/seo/metaData/admin"),
            "label" => Yii::t('admin', 'Seo MetaData'),
            "visible" => UserAccess::checkAccess("seo-MetaDataAdmin", Yii::app()->user->Id)
        ),
    ),
    
    
    'system' => array(
        array(
            "url" => array("route" => "/adminUser/index"),
            "label" => Yii::t('admin', 'Admin User'),
            "visible" => UserAccess::checkAccess("AdminUserIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/cp/index"),
            "label" => Yii::t('admin', 'Quản lý CP'),
            "visible" => UserAccess::checkAccess("CpIndex", Yii::app()->user->Id)
        ),
        array(
            "url" => array("route" => "/config/index"),
            "label" => Yii::t('admin', 'Cấu hình hệ thống'),
            "visible" => UserAccess::checkAccess("ConfigIndex", Yii::app()->user->Id)
        ),
    	array(
    			"url" => array("route" => "/kpi/logAction"),
    			"label" => Yii::t('admin', 'Log tác động'),
    			"visible" => UserAccess::checkAccess("KpiLogAction", Yii::app()->user->Id)
    	),    		
    ),
    
    'report' => array(
        array(
            "url" => array("route" => "/reports/statistic/song"),
            "label" => Yii::t('admin', 'Nội dung'),
            "visible" => UserAccess::checkAccess("reports-StatisticSong", Yii::app()->user->Id),
        	array(
        				"url" => array("route" => "/reports/statistic/song"),
        				"label" => Yii::t('admin', 'Bài hát -  Theo ngày'),
        				"visible" => UserAccess::checkAccess("reports-StatisticSong", Yii::app()->user->Id)
        	),        		
        	array(
        				"url" => array("route" => "/reports/content/song"),
        				"label" => Yii::t('admin', 'Bài hát -  Chi tiết'),
        				"visible" => UserAccess::checkAccess("reports-ContentSong", Yii::app()->user->Id)
        	),        		
        	array(
        				"url" => array("route" => "/reports/statistic/video"),
        				"label" => Yii::t('admin', 'Video -  Theo ngày'),
        				"visible" => UserAccess::checkAccess("reports-StatisticVideo", Yii::app()->user->Id)
        	), 
        	array(
        				"url" => array("route" => "/reports/content/video"),
        				"label" => Yii::t('admin', 'Video -  Chi tiết'),
        				"visible" => UserAccess::checkAccess("reports-ContentVideo", Yii::app()->user->Id)
        	),
        	array(
        				"url" => array("route" => "/reports/statistic/album"),
        				"label" => Yii::t('admin', 'Album -  Theo ngày'),
        				"visible" => UserAccess::checkAccess("reports-StatisticAlbum", Yii::app()->user->Id)
        	),
        	array(
        				"url" => array("route" => "/reports/content/album"),
        				"label" => Yii::t('admin', 'Album -  Chi tiết'),
        				"visible" => UserAccess::checkAccess("reports-ContentAlbum", Yii::app()->user->Id)
        	),        		        		
        ),   		
    ),
);

