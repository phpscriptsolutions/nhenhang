<?php
$submenu = include '_submenu.php';

return  array(
        array(
                "url"=>array("route"=>"/song/index"),
                "label"=>Yii::t('admin','Nội dung'),
                "visible"=>UserAccess::checkAccess("MusicMenuView", Yii::app()->user->Id),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/song/index"),
                "label"=>Yii::t('admin','Bài hát'),
                "visible"=>UserAccess::checkAccess("SongIndex", Yii::app()->user->Id),

                ),$submenu['song']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/video"),
                "label"=>Yii::t('admin','Video'),
                "visible"=>UserAccess::checkAccess("VideoIndex", Yii::app()->user->Id)
                ),$submenu['video']),
                
                CMap::mergeArray(
                    array(
                    "url"=>array("route"=>"/videoPlaylist"),
                    "label"=>Yii::t('admin','Video Playlist'),
                    "visible"=>UserAccess::checkAccess("VideoPlaylistIndex", Yii::app()->user->Id)
                    ),$submenu['videoPlaylist']),
            
                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/album"),
                "label"=>Yii::t('admin','Album'),
                "visible"=>UserAccess::checkAccess("AlbumIndex", Yii::app()->user->Id)
                ),$submenu['album']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/artist"),
                "label"=>Yii::t('admin','Nghệ sỹ'),
                "visible"=>UserAccess::checkAccess("ArtistIndex", Yii::app()->user->Id)
                ),$submenu['artist']),
        		CMap::mergeArray(
        		array(
        		"url"=>array("route"=>"/genre"),
        		"label"=>Yii::t('admin','Thể loại'),
        		"visible"=>UserAccess::checkAccess("GenreIndex", Yii::app()->user->Id)
        		),$submenu['genre']),

                CMap::mergeArray(
                array(
                "url"=>array("route"=>"/collection"),
                "label"=>Yii::t('admin','Bộ sưu tập'),
                "visible"=>UserAccess::checkAccess("CollectionIndex", Yii::app()->user->Id)
                ),$submenu['collection']),
            
            
                array(
                "url"=>array("route"=>"/chart"),
                "label"=>Yii::t('admin','Bảng xếp hạng'),
                "visible"=>UserAccess::checkAccess("ChartIndex", Yii::app()->user->Id)
                ),
                CMap::mergeArray(
                array(
                    "url"=>array("route"=>"/topContent"),
                    "label"=>Yii::t('admin','Top Content'),
                    "visible"=>UserAccess::checkAccess("TopContentIndex", Yii::app()->user->Id)
                ),$submenu['topContent']),

        ),

        CMap::mergeArray(
        array(
        "url"=>array("route"=>"/news"),
        "label"=>Yii::t('admin','CMS'),
        "visible"=>UserAccess::checkAccess("CMSMenuView", Yii::app()->user->Id),
        ),$submenu['cms']),

		CMap::mergeArray(
		array(
		"url"=>array("route"=>"#"),
		"label"=>Yii::t('admin','Report'),
		"visible"=>UserAccess::checkAccess("ReportMenuView", Yii::app()->user->Id),
		),$submenu['report']),
				
        CMap::mergeArray(
        array(
        "url"=>array("route"=>"/adminUser/index"),
        "label"=>Yii::t('admin','Hệ thống'),
        "visible"=>UserAccess::checkAccess("SystemMenuView", Yii::app()->user->Id),
        ),$submenu['system']),
		
		array(
				"url"=>array("route"=>"user"),
				"label"=>Yii::t('admin','WebUser'),
				"visible"=>UserAccess::checkAccess("UserIndex", Yii::app()->user->Id),
		)
);
