<?php
$controller = Yii::app()->controller;
$cId = $controller->id;
$actionId = $controller->getAction()->getId();

if (($cId == "video") && $actionId == "view") {
    ?>
    <title><?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics, bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?></title>
    <meta name="title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics,  bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>" />
    <meta name="description" content="Listen <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, <?php echo ($controller->lyric); ?>" />
    <meta name="keywords" content="<?php echo $controller->itemName; ?>, <?php echo $controller->artist; ?>, <?php echo $controller->itemName; ?>, <?php echo $controller->artist; ?>, tải nhạc chờ ringtunes mobifone <?php echo $controller->itemName; ?> - tên ca sĩ, tải (download) bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, lời (lyric) <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>" />
    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'].$controller->url; ?>"/>
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'].$controller->url; ?>" />
    <meta property="og:title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics,  bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>">
    <meta property="og:description" content="Listen <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, <?php echo $controller->lyric; ?>" />
    <meta property="og:type" content="video.movie">
    <meta property="og:image" content="<?php echo $controller->thumb; ?>" />
    <meta property="og:site_name" content="Metfone" />       
    <?php
} else if (($cId == "song") && $actionId == "view") {
    ?>
    <title><?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics, bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?></title>
    <meta name="title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics,  bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>" />
    <meta name="description" content="Listen <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, <?php echo ($controller->lyric); ?>" />
    <meta name="keywords" content="<?php echo $controller->itemName; ?>, <?php echo $controller->artist; ?>, <?php echo $controller->itemName; ?>, <?php echo $controller->artist; ?>, tải nhạc chờ ringtunes mobifone <?php echo $controller->itemName; ?> - tên ca sĩ, tải (download) bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, lời (lyric) <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>" />
    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>"/>
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>" />
    <meta property="og:title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | Tải bài hát, lyrics,  bài hát <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>">
    <meta property="og:description" content="Listen <?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>, <?php echo $controller->lyric; ?>" />
    <meta property="og:type" content="music.song">
    <meta property="og:image" content="<?php echo $controller->thumb; ?>" />
    <meta property="og:site_name" content="Metfone" />
    <?php
} else if (($cId == "playlist" && $actionId == "view") ||
        ($cId == "album" && $actionId == "view")) {

    if ($cId == "album")
        $type = "music.album";
    else if ($cId == "playlist")
        $type = "music.playlist";
    ?>
    <title><?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | <?php echo Yii::app()->params['domain']['main_site'];?></title>
    <meta name="title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?>" />
    <meta name="description" content="Listen <?php echo $cId . " " . $controller->itemName . " " . strip_tags($controller->description); ?>" />
    <meta name="keywords" content="<?php echo $controller->itemName; ?>, album, playlist nghe, tai, download, nhạc chờ, mobifone, ringtunes, chat luong cao, ten bai hat, ten album" />

    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>"/>
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>" />
    <meta property="og:title" content="<?php echo $controller->itemName; ?> - <?php echo $controller->artist; ?> | <?php echo Yii::app()->params['domain']['main_site'];?>">
    <meta property="og:description" content="Listen <?php echo $cId . " " . $controller->itemName . " trên ".Yii::app()->params['domain']['main_site'] ." ". strip_tags($controller->description); ?>" />
    <meta property="og:type" content="<?php echo $type; ?>">
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:image" content="<?php echo $controller->thumb; ?>" />
    <meta property="og:site_name" content="Metfone" />
    <?php
} else if (($cId == "news") && $actionId == "index") {
    ?>
    <title>Tin tức | <?php echo Yii::app()->params['domain']['main_site'];?></title>
    <meta name="title" content="Tin tức" />
    <meta name="description" content="Website nghe nhạc, tải nhạc hàng đầu Việt Nam với đầy đủ nhất các thể loại, album, ca sĩ, bài hát, ca khúc, video clip mv hot nhất, hay nhất, nghe nhạc chất lượng cao có lời (lyric), tải (download) nhạc nhanh nhất, cài nhạc chờ Ringtunes của Mobifone" />
    <meta name="keywords" content="ringtunes, nhạc, nhac , music, nghe nhạc, nghe nhac, tìm nhạc, tim nhac, tải nhạc, tai nhac, nhạc chất lượng cao, nhac chat luong cao, nhạc hot nhất, nhac hot nhat, nhạc hay nhất, nhac hay nhat, lời bài hát, loi bai hat, lossless, lyric, download, upload, album, ca sĩ, ca si, nhạc chờ, nhac cho, nhạc chuông, nhac chuong, ringtunes, mobifone" />
    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'] . Yii::app()->request->requestUri; ?>" />
    <!-- Dành cho facebook -->
    <meta property="og:title"  name="title" content="Tin tức | <?php echo Yii::app()->params['domain']['main_site'];?>" />
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'] ?>/#!/news/" />
    <meta property="og:image" content="<?php echo Yii::app()->params['domain']['main_site'] ?>/images/imgv2/chacha_logo.png" />
    <meta property="og:site_name" content="Metfone" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="Website nghe nhạc, tải nhạc hàng đầu Việt Nam với đầy đủ nhất các thể loại, album, ca sĩ, bài hát, ca khúc, video clip mv hot nhất, hay nhất, nghe nhạc chất lượng cao có lời (lyric), tải (download) nhạc nhanh nhất của Mobifone" />
    <?php
} else if (($cId == "news") && $actionId == "detail") {
    ?>
    <title><?php echo $controller->itemName; ?> </title>
    <meta name="description" content="<?php echo strip_tags($controller->description); ?>" />
    <meta name="keywords" content="<?php echo $controller->keyword; ?>" />
    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'] . Yii::app()->request->requestUri; ?>" />
    <!-- Dành cho facebook -->
    <meta property="og:title"  name="title" content="<?php echo $controller->itemName; ?> | <?php echo Yii::app()->params['domain']['main_site'];?>" />
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>" />
    <meta property="og:image" content="<?php echo $controller->thumb; ?>" />
    <meta property="og:site_name" content="Metfone" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="<?php echo strip_tags($controller->description); ?>" />
    <?php
} else if (($cId == "artist") && $actionId == "view") {
    ?>
    <title><?php echo $controller->artist; ?> | <?php echo Yii::app()->params['domain']['main_site'];?></title>
    <meta name="title" content="<?php echo $controller->artist; ?>" />
    <meta name="description" content="Listen tất cả bài hát, album, playlist, đọc tin tức về ca sĩ <?php echo $controller->artist; ?> trên Metfone.vn" />
    <meta name="keywords" content="<?php echo $controller->artist; ?>, album, playlist nghe, tai, download, nhạc chờ, mobifone, ringtunes, chat luong cao, <?php echo $controller->artist; ?>" />

    <link rel="canonical" href="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>"/>
    <meta property="og:url" content="<?php echo Yii::app()->params['domain']['main_site'] . $controller->url; ?>" />
    <meta property="og:title" content="<?php echo $controller->artist; ?> | <?php echo Yii::app()->params['domain']['main_site'];?>">
    <meta property="og:description" content="Listen tất cả bài hát, album, playlist, đọc tin tức về ca sĩ <?php echo $controller->artist; ?> trên amusic" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="profile" />
    <meta property="og:image" content="<?php echo $controller->thumb; ?>" />
    <meta property="og:site_name" content="Metfone" />
    <?php
} else {
    if ($cId == "site" && $actionId == "index") {
        $link = Yii::app()->params['domain']['main_site'];
    }
    else
        $link = Yii::app()->params['domain']['main_site'] . Yii::app()->request->requestUri;
    ?>     
    <title><?php echo Yii::t('wap','Nhac.vn | Nghe, tải nhạc chất lượng cao nhanh nhất.');?></title>
    <meta name="title" content="The world of music" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="canonical" href="<?php echo $link; ?>" />
    <!-- Dành cho facebook -->
    <meta property="og:title"  name="title" content="The world of music" />
    <meta property="og:url" content="<?php echo $link; ?>" />
    <meta property="og:image" content="" />
    <meta property="og:site_name" content="Imuzik3G" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="" />
    <?php
}
?>
