<?php
$menuAlbum = array(
    3=>'Nhạc Trẻ',
    6=>'Trữ Tình',
    9=>'Rock Việt',
    12=>'Rap/Hiphop Việt',
    15=>'Quê Hương',
    18=>'Cách Mạng',
    21=>'Dân Ca/Nhạc Cổ',
    24=>'Nhạc Trịnh',
    27=>'Thiếu Nhi',
    30=>'Việt Remix',
    33=>'Âu Mỹ',
    63=>'Nhạc Hoa',
    66=>'Nhạc Nhật',
    69=>'Nhạc Hàn',
    81=>'Nhạc Không Lời',
    75=>'Thể loại khác'
);
$menuVideo = array(
    3=>'Nhạc Trẻ',
    6=>'Trữ Tình',
    //9=>'Rock Việt',
    //12=>'Rap/Hiphop Việt',
    15=>'Quê Hương',
    18=>'Cách Mạng',
    //27=>'Thiếu Nhi',
    33=>'Âu Mỹ',
    63=>'Nhạc Hoa',
    69=>'Nhạc Hàn',
    75=>'Thể loại khác'
);
$curentId = Yii::app()->request->getParam('id', 0);
?>
<ul class="main_nav">
    <li><a class="<?php if($controller->id=='album') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/album'); ?>"><?php echo Yii::t('web', 'Album'); ?></a>
        <ul class="sub_nav1">
            <?php
                foreach($menuAlbum as $genreId => $genreName){
                    $active = '';
                    if($curentId==$genreId && $controller->id=='album' && $action=='list'){
                        $active = 'class="active_color"';
                    }
                    //$link = Yii::app()->createAbsoluteUrl("/album/list", array("id" => $genreId, "title" => Common::makeFriendlyUrl(trim($genreName))));
                    $link = URLHelper::makeUrlGenre(array("type"=>'album','name'=>$genreName,'id'=>$genreId));
                    echo '<li><a '.$active.' title="'.$genreName.'" href="'.$link.'">'.$genreName.'</a></li>';
                }
            ?>
        </ul>
    </li>
    <li><a class="<?php if($controller->id=='video') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/video'); ?>"><?php echo Yii::t('web', 'Video'); ?></a>
        <ul class="sub_nav1" style="width: 320px;">
            <?php
            foreach($menuVideo as $genreId => $genreName){
                $active = '';
                if($curentId==$genreId && $controller->id=='video' && $action=='list'){
                    $active = 'class="active_color"';
                }
                //$link = Yii::app()->createAbsoluteUrl("/video/list", array("id" => $genreId, "title" => Common::makeFriendlyUrl(trim($genreName))));
                $link = URLHelper::makeUrlGenre(array("type"=>'video','name'=>$genreName,'id'=>$genreId));
                echo '<li><a '.$active.' title="'.$genreName.'" href="'.$link.'">'.$genreName.'</a></li>';
            }
            ?>
        </ul>
    </li>
    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/hotlist')?>" <?php echo ($controller->id=='hotlist')?"class='active'":""?>>Hot List</a></li>
    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/chart')?>" <?php echo ($controller->id=='chart')?"class='active'":""?>>BXH</a>
        <ul class="sub_nav1" style="width: 480px">
            <li class="root"><a>Việt Nam</a>
                <ul class="sub_nav2">
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Bài hát Việt Nam')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'VN','type'=>'song'));?>">Bài hát</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Album Việt Nam')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'VN','type'=>'album'));?>">Album</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Video Việt Nam')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'VN','type'=>'video'));?>">Video</a></li>
                </ul>
            </li><li class="root"><a>Âu Mỹ</a>
                <ul class="sub_nav2">
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Bài hát Âu Mỹ')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'QTE','type'=>'song'));?>">Bài hát</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Album Âu Mỹ')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'QTE','type'=>'album'));?>">Album</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Video Âu Mỹ')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'QTE','type'=>'video'));?>">Video</a></li>
                </ul>
            </li><li class="root"><a>Hàn Quốc</a>
                <ul class="sub_nav2">
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Bài hát Hàn Quốc')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'KOR','type'=>'song'));?>">Bài hát</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Album Hàn Quốc')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'KOR','type'=>'album'));?>">Album</a></li>
                    <li><a title="<?php echo Yii::t('web','Bảng xếp hạng Video Hàn Quốc')?>" href="<?php echo URLHelper::makeUrlChart(array('genre' => 'KOR','type'=>'video'));?>">Video</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a class="<?php if($controller->id=='artist') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/artist'); ?>"><?php echo Yii::t('web', 'Artist'); ?></a>
        <ul class="sub_nav1" style="width: 160px;">
            <li>
            <ul class="sub_nav2">
                <li><a href="<?php
                    $object = array('object_type'=>'artist_index','type'=>'artist','name'=>Yii::t('web','Việt Nam'),'id'=>1);
                    $link = URLHelper::makeUrlMultiLevel($object);
                    echo $link;?>"><?php echo Yii::t('web','Việt Nam')?></a></li>
                <li><a href="<?php
                    $object = array('object_type'=>'artist_index','type'=>'artist','name'=>Yii::t('web','Âu Mỹ'),'id'=>33);
                    $link = URLHelper::makeUrlMultiLevel($object);
                    echo $link;?>"><?php echo Yii::t('web','Âu Mỹ')?></a></li>
                <li><a href="<?php
                    $object = array('object_type'=>'artist_index','type'=>'artist','name'=>Yii::t('web','Châu Á'),'id'=>60);
                    $link = URLHelper::makeUrlMultiLevel($object);
                    echo $link;?>"><?php echo Yii::t('web','Châu Á')?></a></li>
            </ul>
            </li>
        </ul>
    </li>
</ul>