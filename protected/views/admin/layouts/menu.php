<?php

$controller1 = Yii::app()->controller;
$cId = $controller1->id;
$actionId = $controller1->getAction()->getId();
return array(
    "music" => array(
        "song" => array(
            "index" => array(
                'label' => 'Bài hát',
                'url' => array('/song/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Tất cả'),
                        'url' => array('/song/index'),
                        "active" => ($songType == AdminSongModel::ALL) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát chưa convert'),
                        'url' => array('/song/index', "AdminSongModel[status]" => AdminSongModel::NOT_CONVERT),
                        "active" => ($songType == AdminSongModel::NOT_CONVERT) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát convert lỗi'),
                        'url' => array('/song/index', "AdminSongModel[status]" => AdminSongModel::CONVERT_FAIL),
                        "active" => ($songType == AdminSongModel::CONVERT_FAIL) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát chờ duyệt'),
                        'url' => array('/song/index', "AdminSongModel[status]" => AdminSongModel::WAIT_APPROVED),
                        "active" => ($songType == AdminSongModel::WAIT_APPROVED) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát đã duyệt'),
                        'url' => array('/song/index', "AdminSongModel[status]" => AdminSongModel::ACTIVE),
                        "active" => ($songType == AdminSongModel::ACTIVE) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát chọn lọc'),
                        'url' => array('/songFeature/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát miễn phí'),
                        'url' => array('/collection/view&id=150'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát đã xóa'),
                        'url' => array('/song/index', "AdminSongModel[status]" => AdminSongModel::DELETED),
                        "active" => ($songType == AdminSongModel::DELETED) ? "active" : ""
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "create" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => array('#'), 'active' => 'active', 'linkOptions' => array('onclick' => 'return showGlobalForm(this)')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('onclick' => 'return showMetaForm(this)')),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', 'active' => 'active', 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('song/listFavourite', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "copy" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => array('#'), 'active' => 'active', 'linkOptions' => array('onclick' => 'return showGlobalForm(this)')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('onclick' => 'return showMetaForm(this)')),
                )
            ),
            "approved" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => "#", "active" => "active"),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => "#"),
                )
            ),
        ),
        "video" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Video'),
                'url' => array('/video/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Tất cả'),
                        'url' => array('/video/index'),
                        "active" => ($videoType == AdminVideoModel::ALL) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video chưa convert'),
                        'url' => array('/video/index', "AdminVideoModel[status]" => AdminVideoModel::NOT_CONVERT),
                        "active" => ($videoType == AdminVideoModel::NOT_CONVERT) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video convert lỗi'),
                        'url' => array('/video/index', "AdminVideoModel[status]" => AdminVideoModel::CONVERT_FAIL),
                        "active" => ($videoType == AdminVideoModel::CONVERT_FAIL) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video chờ duyệt'),
                        'url' => array('/video/index', "AdminVideoModel[status]" => AdminVideoModel::WAIT_APPROVED),
                        "active" => ($videoType == AdminVideoModel::WAIT_APPROVED) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video đã duyệt'),
                        'url' => array('/video/index', "AdminVideoModel[status]" => AdminVideoModel::ACTIVE),
                        "active" => ($videoType == AdminVideoModel::ACTIVE) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video chọn lọc'),
                        'url' => array('/videoFeature/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video xem miễn phí'),
                        'url' => array('/collection/view&id=148'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Video đã xóa'),
                        'url' => array('/video/index', "AdminVideoModel[status]" => AdminVideoModel::DELETED),
                        "active" => ($videoType == AdminVideoModel::DELETED) ? "active" : ""
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('video/listFavourite', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "create" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('video/listFavourite', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "copy" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "approved" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => "#", "active" => "active"),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => "#"),
                )
            ),
        ),
        "album" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Album'),
                'url' => array('/album/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Tất cả'),
                        'url' => array('/album/index'),
                        "active" => ($albumType == AdminAlbumModel::ALL) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Album chờ duyệt'),
                        'url' => array('/album/index', "AdminAlbumModel[status]" => AdminAlbumModel::WAIT_APPROVED),
                        "active" => ($albumType == AdminAlbumModel::WAIT_APPROVED) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Album đã duyệt'),
                        'url' => array('/album/index', "AdminAlbumModel[status]" => AdminAlbumModel::ACTIVE),
                        "active" => ($albumType == AdminAlbumModel::ACTIVE) ? "active" : ""
                    ),
                    array(
                        'label' => Yii::t('admin', 'Album chọn lọc'),
                        'url' => array('/albumFeature/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Album đã xóa'),
                        'url' => array('/album/index', "AdminAlbumModel[status]" => AdminAlbumModel::DELETED),
                        "active" => ($albumType == AdminAlbumModel::DELETED) ? "active" : ""
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('album/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('album/favList', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "create" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('album/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('album/favList', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
        ),
        "playlist" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Playlist'),
                'url' => array('/playlist/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách playlist'),
                        'url' => array('/playlist/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Thêm mới playlist'),
                        'url' => array('/playlist/create',),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Playlist chọn lọc'),
                        'url' => array('/playlistFeature/index',),
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('playlist/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('playlist/favList', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "create" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('playlist/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                    array('label' => Yii::t('admin', 'Danh sách yêu thích'), 'url' => array('playlist/favList', 'id' => $id), 'linkOptions' => array('id' => 'fav-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "copy" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
        ),
        "artist" => array(
            "index" => array(
                'index' => 'artist',
                'label' => Yii::t('admin', 'Nghệ sỹ'),
                'url' => array('/artist/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách nghệ sỹ'),
                        'url' => array('/artist/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Thêm mới nghệ sỹ'),
                        'url' => array('/artist/create',),
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "create" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                    array('label' => Yii::t('admin', 'DS bài hát'), 'url' => array('artist/songlist', 'id' => $id), 'linkOptions' => array('id' => '',)),
                    array('label' => Yii::t('admin', 'DS video'), 'url' => array('artist/videolist', 'id' => $id), 'linkOptions' => array('id' => '',)),
                    array('label' => Yii::t('admin', 'DS album'), 'url' => array('artist/albumlist', 'id' => $id), 'linkOptions' => array('id' => '',)),
                )
            ),
            "copy" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Meta data'), 'url' => '#', 'linkOptions' => array('id' => 'meta-info')),
                )
            ),
        ),
        "copyright" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Phụ lục'),
                'url' => array('/copyright/index'),
            )
        ),
        "genre" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thể loại'),
                'url' => array('/genre/index'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách thể loại'),
                        'url' => array('/genre/index'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Thêm mới thể loại'),
                        'url' => array('/genre/create',),
                    ),
                )
            ),
            "create" => array(
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách thể loại'),
                        'url' => array('/genre/index'),
                    ),
                )
            ),
            "view" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('genre/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                )
            ),
            "update" => array(
                'items' => array(
                    array('label' => Yii::t('admin', 'Thông tin cơ bản'), 'url' => '#', "active" => "active", 'linkOptions' => array('id' => 'basic-info')),
                    array('label' => Yii::t('admin', 'Danh sách bài hát'), 'url' => array('genre/songList', 'id' => $id), 'linkOptions' => array('id' => 'inlist-info',)),
                )
            ),
        ),
        "collection" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Bộ sưu tập'),
                'url' => array('/collection/index'),
                /* 'items' => array(
                  array(
                  'label' => Yii::t('admin', 'Index'),
                  'url' => array('/collection/index'),
                  ),
                  ), */
                'items' => AdminCollectionModel::getCollectionViewMenu()
            ),
            "create" => array(
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách'),
                        'url' => array('/collection/index'),
                    ),
                ),
            ),
            "view" => array(
            /* 'items' => array(
              array(
              'label' => Yii::t('admin', 'Cập nhật'),
              'url' => array('/collection/update&id='. Yii::app()->request->getParam('id',1)),
              ),
              ), */
//                'items' => AdminCollectionModel::getCollectionViewMenu()
            ),
            "update" => array(
            /* 'items' => array(
              array(
              'label' => Yii::t('admin', 'Xem'),
              'url' => array('/collection/view&id='. Yii::app()->request->getParam('id',1)),
              ),
              ), */
//                'items' => AdminCollectionModel::getCollectionViewMenu()
            ),
        ),
    		"event" => array(
    				"index" => array(
    						'label' => Yii::t('admin', 'Event'),
    						'url' => array('/event/gameEventThread'),    						
    						'items' => array(
			                    array(
			                        'label' => Yii::t('admin', 'Bộ câu hỏi'),
			                        'url' => array('/event/gameEventThread'),
			                    ),
			                    array(
			                        'label' => Yii::t('admin', 'DS câu hỏi'),
			                        'url' => array('/event/gameEventQuestion'),
			                    ),
			                )
    				),
    				"create" => array(
    						'items' => array(
    								array(
    										'label' => Yii::t('admin', 'Danh sách'),
    										'url' => array('/event/gameEventThread'),
    								),
    						),
    				),
    				"view" => array(
    						
    				),
    				"update" => array(
    						
    				),
    		),
        "contest" => array(
            "index" => array(
                'label' => Yii::t('admin', 'Chacha top hot'),
                'url' => array('/contest/contest'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Danh sách cuộc thi'),
                        'url' => array('/contest/contest'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Các vòng thi'),
                        'url' => array('/contest/topic'),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Bài hát BXH chacha hot'),
                        'url' => array('/contest/content'),
                    ),
                )
            ),
        ),
    ),
    'rt-rbt' => array(
        'ringtone' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Nhạc chuông'),
                'url' => array('/ringtone/index'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Tất cả'), 'url' => array('/ringtone/index'), "active" => ($rtType == AdminRingtoneModel::ALL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Nhạc chuông hot'), 'url' => array('/collection/view&id=116'), "active" => ($rtType == AdminRingtoneModel::ALL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Nhạc chuông mới'), 'url' => array('/collection/view&id=118'), "active" => ($rtType == AdminRingtoneModel::ALL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Chưa convert'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::NOT_CONVERT), "active" => ($rtType == AdminRingtoneModel::NOT_CONVERT) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Convert lỗi'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::CONVERT_FAIL), "active" => ($rtType == AdminRingtoneModel::CONVERT_FAIL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Chờ duyệt'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::WAIT_APPROVED), "active" => ($rtType == AdminRingtoneModel::WAIT_APPROVED) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Đã duyệt'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::ACTIVE), "active" => ($rtType == AdminRingtoneModel::ACTIVE) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Đã xóa'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::DELETED), "active" => ($rtType == AdminRingtoneModel::DELETED) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Thể loại nhạc chuông'), 'url' => array('/ringtoneCategory/index')),
                )
            ),
        ),
        'ringbacktone' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Nhạc chờ'),
                'url' => array('/ringbacktone/index'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Ringtunes Hot'), 'url' => array('/collection/view&id=113'),),
                    array('label' => Yii::t('admin', 'Ringtunes New'), 'url' => array('/collection/view&id=115')),
                    array('label' => Yii::t('admin', 'Ca sĩ nhạc chờ'), 'url' => array('/rbtArtist/index'),),
                    array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('/ringbacktone/index'),),
                    array('label' => Yii::t('admin', 'Bộ sưu tập nhạc chờ'), 'url' => array('/rbtCollection/index'),),
                    array('label' => Yii::t('admin', 'Thể loại nhạc chờ'), 'url' => array('/rbtCategory/index')),
                    array('label' => Yii::t('admin', 'Thống kê ringtunes'), 'url' => array('/rbtDownload/report')),)
            ),
        )
    ),
    'IVR' => array(
        "musicgift" => array(
            "index" => array(
                'label' => Yii::t('admin', 'MusicGift'),
                'url' => array('/mgChannel'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Channel'), 'url' => array('/mgChannel/index'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
                    array('label' => Yii::t('admin', 'Sms'), 'url' => array('/smsConfig/index'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
                    array('label' => Yii::t('admin', 'Danh sách quà tặng'), 'url' => array('/AdminMgGift/index')),
                    array('label' => Yii::t('admin', 'Tạo quà lẻ'), 'url' => array('/AdminMgGift/create')),
                    array('label' => Yii::t('admin', 'Thống kê User'), 'url' => array('/ReportsMg/subscribe'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
                    array('label' => Yii::t('admin', 'Thống kê quà tặng'), 'url' => array('/ReportsMg/giftsong')),
                    array('label' => Yii::t('admin', 'Thống kê nội dung'), 'url' => array('/ReportsMg/content')),
                    array('label' => Yii::t('admin', 'Thống kê cuộc gọi'), 'url' => array('/ReportsMg/dtmf'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
                    array('label' => Yii::t('admin', 'Thống kê hoạt động của khách hàng'), 'url' => array('/ReportsMg/msisdn'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
                    array('label' => Yii::t('admin', 'Thống kê doanh thu'), 'url' => array('/ReportsMg/revenue'), "visible" => UserAccess::checkAccess("MgChannelIndex", true)),
					array('label' => Yii::t('admin', 'Tra cứu log'), 'url' => array('/admin/viewlog'), "visible" => true),
                    array(
                        'label' => Yii::t('admin', 'Bộ sưu tập'),
                        'url' => array('/collection/view&id=108'),
                        'items' => array(
                            array(
                                'label' => Yii::t('admin', 'Top quà tặng'),
                                'url' => array('/collection/view&id=108'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Album hot'),
                                'url' => array('/collection/view&id=122',),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Quốc tế phụ nữ'),
                                'url' => array('/collection/view&id=124',),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Sinh nhật'),
                                'url' => array('/collection/view&id=126'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Bạn bè'),
                                'url' => array('/collection/view&id=128',),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Gia đình'),
                                'url' => array('/collection/view&id=130',),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Tình yêu'),
                                'url' => array('/collection/view&id=132'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Tỏ tình'),
                                'url' => array('/collection/view&id=134'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Hẹn hò'),
                                'url' => array('/collection/view&id=136'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Hạnh phúc'),
                                'url' => array('/collection/view&id=138'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Giận hờn'),
                                'url' => array('/collection/view&id=140'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Xin lỗi'),
                                'url' => array('/collection/view&id=142'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'Hối tiếc'),
                                'url' => array('/collection/view&id=144'),
                            ),
                            array(
                                'label' => Yii::t('admin', 'chúc mừng'),
                                'url' => array('/collection/view&id=146'),
                            ),
                        )
                    ),
                ),
            ),
        ),
        'obdPhoneGroup' => array(
            "index" => array(
                'label' => Yii::t('admin', 'OBD'),
                'url' => array('/ObdPhoneGroup'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Thuê bao'),
                        'url' => array('/ObdPhoneGroup'),
                        'items' => array(
                            array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('/ObdPhoneGroup/index')),
                            array('label' => Yii::t('admin', 'Tra cứu'), 'url' => array('/ObdActivity/index')),
                            array('label' => Yii::t('admin', 'Blacklist'), 'url' => array('/ObdBlacklist/index')),
                        ),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Kịch bản đăng ký'),
                        'url' => array('/ObdPhoneGroup/Subscribe'),
                        'items' => array(
                            array('label' => Yii::t('admin', 'Cài đặt'), 'url' => array('/ObdPhoneGroup/Subscribe')),
                            array('label' => Yii::t('admin', 'Thống kê'), 'url' => array('/ObdPhoneGroup/reportsb')),
                        ),
                    ),
                    array(
                        'label' => Yii::t('admin', 'Kịch bản mua nhạc chờ'),
                        'url' => array('/ObdPhoneGroup/Content'),
                        'items' => array(
                            array('label' => Yii::t('admin', 'Cài đặt'), 'url' => array('/ObdPhoneGroup/Content')),
                            array('label' => Yii::t('admin', 'Thống kê'), 'url' => array('/ObdPhoneGroup/reportct')),
                        )
                    ),
                ),
            ),
        )
    ),
    'user-log' => array(
        'user' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Danh sách thành viên'),
                'url' => array('/user/index'),
            ),
        ),
        'userSubscribe' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Danh sách thuê bao'),
                'url' => array('/userSubscribe/index'),
            ),
        ),
        'phoneBook' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Danh sách TB Miền Tây'),
                'url' => array('/phoneBook/index'),
            ),
        ),
        'userLog' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Tra cứu log người dùng'),
                'url' => array('/userLog/index'),
            ),
        ),
        'transLog' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Tra cứu log giao dịch'),
                'url' => array('/transLog/index'),
            ),
        )
    ),
    /*
      'report'=>array(
      'report1'=>array(
      "index"=>array(
      'label'=>Yii::t('admin','Tổng hợp'),
      'url'=>array('report/index'),
      ),
      ),
      'report2'=>array(
      "index"=>array(
      'label'=>Yii::t('admin','Thống kê doanh thu'),
      'url'=>array('report/revenue'),
      ),
      ),
      'report3'=>array(
      "index"=>array(
      'label'=>Yii::t('admin','Thống kê nội dung'),
      'url'=>array('report/content'),
      ),
      ),
      'report4'=>array(
      "index"=>array(
      'label'=>Yii::t('admin','Thống kê thuê bao'),
      'url'=>array('report/subscriber'),
      ),
      )
      ),
     */
    'report-rev' => array(
        'allindex' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Tổng thống kê'),
                'url' => array('/reports/allindex')
            ),
        ),
        'reports' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê nội dung'),
                'url' => array('/reports/'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Bài hát'), 'url' => array('/reports/song'),),
                    array('label' => Yii::t('admin', 'Theo từng bài hát'), 'url' => array('/reports/songDetail'),),
                    array('label' => Yii::t('admin', 'Video'), 'url' => array('/reports/video'),),
                    array('label' => Yii::t('admin', 'Theo từng video'), 'url' => array('/reports/videoDetail'),),
                )
            ),
        ),
        'rev' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê doanh thu'),
                'url' => array('/reports/daily'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Doanh thu trong ngày'), 'url' => array('/reports/daily'),),
                    array('label' => Yii::t('admin', 'Doanh thu thời gian'), 'url' => array('/reports/revenue'),),
                    array('label' => Yii::t('admin', 'Doanh thu Cp (Gói cước)'), 'url' => array('/reports/revenueCp'),),
                    array('label' => Yii::t('admin', 'Doanh thu Cp (Nội dung)'), 'url' => array('/reports/revenueContent'),),
                    array('label' => Yii::t('admin', 'Doanh thu chi tiết theo thời gian'), 'url' => array('/reports/dailyTime'),),
                )
            ),
        ),
        'usubs' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê thuê bao'),
                'url' => array('/reports/subscribeReport'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Danh sách thuê bao'), 'url' => array('/reports/subscribeReport'),),
                    array('label' => Yii::t('admin', 'Số lượt đăng ký'), 'url' => array('/reports/register'),),
                    array('label' => Yii::t('admin', 'Số lượt hủy'), 'url' => array('/reports/unregister'),),
                    array('label' => Yii::t('admin', 'Số lượt gia hạn'), 'url' => array('/reports/subscribeExt'),),
                    array('label' => Yii::t('admin', 'Gia hạn qua IVR'), 'url' => array('/reports/subscribeExtSuccess'),),
                    array('label' => Yii::t('admin', 'Thống kê chung'), 'url' => array('/reports/subscribeStatistic'),),
                )
            ),
        ),
        'trans' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê giao dịch'),
                'url' => array('/reports/detailByTrans'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Giao dịch theo thuê bao'), 'url' => array('/reports/detailByTrans'),),
                    array('label' => Yii::t('admin', 'Giao dịch theo ngày'), 'url' => array('/reports/detailByTime'),),
                )
            ),
        ),
        'detect' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê truy cập'),
                'url' => array('/reports/detailByTrans'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Truy cập theo nhận diện TB'), 'url' => array('/reports/detectLog'),),
                )
            ),
        ),
        'ads' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê Quảng cáo'),
                'url' => array('/reports/reportAdsClick'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Thống kê lượt Click'), 'url' => array('/reports/reportAdsClick'),),
                    array('label' => Yii::t('admin', 'Danh sách IP'), 'url' => array('/reports/reportAdsIp'),),
                )
            ),
        ),
        'app' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê app chacha'),
                'url' => array('/reports/Reportsms')
            ),
        ),
        'ccp' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê bản quyền'),
                'url' => array('/reports/copyrightCP'),
        		'items' => array(
                    array('label' => Yii::t('admin', 'Doanh thu nội dung từ gói '), 'url' => array('/reports/copyrightCP'),),
                    array('label' => Yii::t('admin', 'Doanh thu nôi dung bán lẻ'), 'url' => array('/reports/CCPRetail'),),
                    array('label' => Yii::t('admin', 'Thống kê chi tiết bài hát'), 'url' => array('/reports/CCPSongdetail'),),
                   //  array('label' => Yii::t('admin', 'Thống kê Video'), 'url' => array('/reports/CCPVideodetail'),),
                )
            ),
        ),
//        'gift' => array(
//            "index" => array(
//                'label' => Yii::t('admin', 'Music Gift'),
//                'url' => array('/reports/giftsong'),
//                'items' => array(
//                    array('label' => Yii::t('admin', 'Thống kê'), 'url' => array('/reports/giftsong'),),
//                    array('label' => Yii::t('admin', 'Quản lý'), 'url' => array('/AdminMgGift/index'),),
//                )
//            ),
//        ),
    ),
    'cms' => array(
        'news' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Tin tức'),
                'url' => array('/news/index'),
            ),
        ),
        'web' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Web'),
                'url' => array('/html/index&channel=web'),
                'items' => array(
                    array('label' => Yii::t('admin', 'HTML'), 'url' => array('/html/index&channel=web'),),
                    array('label' => Yii::t('admin', 'Banner'), 'url' => array('/banner/index&channel=web'),),
                )
            ),
        ),
        'html' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Wap'),
                'url' => array('/html/index&channel=wap'),
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'HTML'),
                        'url' => array('/html/index&channel=wap'),
                        'active' => ($cId == 'html' && $actionId == 'index') ? 'active' : ''
                    ),
                    array(
                        'label' => Yii::t('admin', 'Banner'),
                        'url' => array('/banner/index&channel=wap'),
                        'active' => ($cId == 'banner' && $actionId == 'index') ? 'active' : ''
                    ),
                    array(
                        'label' => Yii::t('admin', 'Sự kiện'),
                        'url' => array('/newsEvent/index'),
                        'active' => ($cId == 'newsEvent' && $actionId == 'index' && (!isset($_SESSION['channel']) || $_SESSION['channel'] == 'wap')) ? 'active' : ''
                    ),
                    array(
                        'label' => Yii::t('admin', 'Tin nổi bật'),
                        'url' => array('/newsEvent/index&channel=vinaportal'),
                        'active' => ($cId == 'newsEvent' && $actionId == 'index' && (isset($_SESSION['channel']) && $_SESSION['channel'] == 'vinaportal')) ? 'active' : ''
                    ),
                )
            ),
        ),
        'ringtune' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Ringtune'),
                'url' => array('/html/index&channel=ringtune'),
                'items' => array(
                    //array('label' => Yii::t('admin', 'HTML'), 'url' => array('/html/index&channel=web'),),
                    array('label' => Yii::t('admin', 'Banner'), 'url' => array('/banner/index&channel=ringtune'),),
                )
            ),
        ),
        'app' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Apps'),
                'url' => array('/banner/index&channel=app'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Banner'), 'url' => array('/banner/index&channel=app'),),
                )
            ),
        ),
//        'newsEvent' => array(
//            "index" => array(
//                'label' => Yii::t('admin', 'Sự kiện'),
//                'url' => array('/newsEvent/index'),
//            ),
//        ),
//        'banner' => array(
//            "index" => array(
//                'label' => Yii::t('admin', 'Banner wap/web'),
//                'url' => array('/banner/index'),
//            ),
//        ),
//                    "spam"=>array(
//						"index"=>array(
//								'label'=>Yii::t('admin','Quản lí Spam'),
//								'url'=>array('/spam/AdminSpamSmsGroupModel/index'),
//								'items'=>array(
//										array(
//											'label'=>Yii::t('admin','Quản lí nhóm tin spam'),
//											'url'=>array('/spam/AdminSpamSmsGroupModel/index'),
//										),
//										array(
//											'label'=>Yii::t('admin','Quản lí lịch bắn tin'),
//											'url'=>array('/spam/AdminSpamSmsCldModel/index',),
//										),
//								)
//							),
//                        ),
    ),
    'systemmanager' => array(
        'adminUser' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Người sử dụng'),
                'url' => array('/adminUser/index'),
            ),
        ),
        'cp' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Quản lý CP'),
                'url' => array('/cp/index'),
            ),
        ),
        'ccp' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Quản lý CCP'),
                'url' => array('/ccp/index'),
            ),
        ),
        /* 'srbac'=>array(
          "index"=>array(
          'label'=>Yii::t('admin','Phân quyền người dùng'),
          'url'=>array('/srbac/authitem/frontpage'),
          ),
          ), */
        'device' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Quản lý thiết bị-profile'),
                'url' => array('/device/index'),
            ),
        ),
        'package' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Quản lý gói cước'),
                'url' => array('/package/index'),
            ),
        ),
        /* 'smsConfig' => array(
          "index" => array(
          'label' => Yii::t('admin', 'Cấu hình SMS'),
          'url' => array('/smsConfig/index'),
          ),
          ),
         */
        'emailTemplate' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Cấu hình email template'),
                'url' => array('/emailTemplate/index'),
            ),
        ),
        'config' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Cấu hình hệ thống'),
                'url' => '/admin.php?r=config/index',
                'items' => array(
                    array(
                        'label' => Yii::t('admin', 'Cơ bản'),
                        'url' => array('/config/index'),
                        'active' => ($cId == 'config' && $actionId == 'index' && Yii::app()->request->getParam('category', 'basic') == 'basic') ? 'active' : ''
                    ),
                    array(
                        'label' => Yii::t('admin', 'Nâng cao'),
                        'url' => array('/config/supper_index'),
                        'active' => ($cId == 'config' && $actionId == 'index' && Yii::app()->request->getParam('category') == 'advance') ? 'active' : ''
                    )
                )
            ),
        ),
        'syslog' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Tra cứu log hệ thống'),
                'url' => '#',
            ),
        ),
        'notif' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Push Notifications'),
                'url' => '/admin.php?r=pushNotifSetting/index',
            ),
        ),
    ),
);
?>
