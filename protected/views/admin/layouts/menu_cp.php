<?php

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
    ),
    'rt-rbt' => array(
        'ringtone' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Nhạc chuông'),
                'url' => array('/ringtone/index'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Tất cả'), 'url' => array('/ringtone/index'), "active" => ($rtType == AdminRingtoneModel::ALL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Chưa convert'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::NOT_CONVERT), "active" => ($rtType == AdminRingtoneModel::NOT_CONVERT) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Convert lỗi'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::CONVERT_FAIL), "active" => ($rtType == AdminRingtoneModel::CONVERT_FAIL) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Chờ duyệt'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::WAIT_APPROVED), "active" => ($rtType == AdminRingtoneModel::WAIT_APPROVED) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Đã duyệt'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::ACTIVE), "active" => ($rtType == AdminRingtoneModel::ACTIVE) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Đã xóa'), 'url' => array('/ringtone/index', "AdminRingtoneModel[status]" => AdminRingtoneModel::DELETED), "active" => ($rtType == AdminRingtoneModel::DELETED) ? "active" : ""),
                    array('label' => Yii::t('admin', 'Thể loại nhạc chuông'), 'url' => array('/ringtoneCategory/index')),
                )
            ),
        ),
    ),
    'report-rev' => array(
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
                    //array('label'=>Yii::t('admin', 'Doanh thu trong ngày'), 'url'=>array('/reports/daily'),),
                    //array('label'=>Yii::t('admin', 'Doanh thu thời gian'), 'url'=>array('/reports/revenue'),),
                    array('label' => Yii::t('admin', 'Doanh thu Cp (Gói cước)'), 'url' => array('/reports/revenueCp'),),
                    array('label' => Yii::t('admin', 'Doanh thu Cp (Nội dung)'), 'url' => array('/reports/revenueContent'),),
                //array('label'=>Yii::t('admin', 'Doanh thu chi tiết theo thời gian'), 'url'=>array('/reports/dailyTime'),),
                )
            ),
        ),
        'ads' => array(
            "index" => array(
                'label' => Yii::t('admin', 'Thống kê Quảng cáo'),
                'url' => array('/reports/reportAdsClick'),
                'items' => array(
                    array('label' => Yii::t('admin', 'Thống kê lượt Click'), 'url' => array('/reports/reportAdsClick'),),
                    array('label' => Yii::t('admin', 'Thống kê IP'), 'url' => array('/reports/reportAdsIp'),),
                )
            ),
        ),
    ),
);
?>
