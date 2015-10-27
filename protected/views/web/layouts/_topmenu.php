<?php
/*$genreRoot = array(
    Yii::app()->params['VNGenreParent']=>Yii::t('web','Khmer'),
    Yii::app()->params['QTEGenreParent']=>Yii::t('web','US-UK'),
    Yii::app()->params['CAGenreParent']=>Yii::t('web','Korean')
);*/
$genreRoot = WebGenreModel::model()->getParentGenre();
$menuType = array('video','album','artist');
$html = array();
$curentId = Yii::app()->request->getParam('id', 0);
$currentPage = Yii::app()->controller->id;
foreach($menuType as $type) {
    if($currentPage==$type && $curentId>0){
        $cache_code = "top_menu_{$type}_{$curentId}";
    }else{
        $cache_code = "top_menu_{$type}";
    }
    $html[$type] = Yii::app()->cache->get($cache_code);
    if($html[$type]===false) {
        foreach ($genreRoot as $rootGen) {

            $crit = new CDbCriteria();
            $crit->condition = "status = 1 AND parent_id = :id";
            $crit->params = array(':id' => $rootGen['id']);
            $genreVN = WebGenreModel::model()->findAll($crit);
            $rootLink = Yii::app()->createUrl($type . "/list", array("id" => $rootGen['id'], "title" => Common::makeFriendlyUrl(trim($rootGen['name']))));
            $html[$type]['root'][$rootGen['id']]= '<li class="root"><a href="' . $rootLink . '" ' . (($controller->id == $type && ($action == "index" || $action == "list") && (int)$curentId == (int)$rootGen['id']) ? 'class="active_color"' : '') . '>' . $rootGen['name'] . '</a>';
            $i=0;
            foreach ($genreVN as $genre) {
                $link = Yii::app()->createUrl($type . "/list", array("id" => $genre->id, "title" => Common::makeFriendlyUrl(trim($genre->name))));
                $html[$type]['sub_'.$rootGen['id']][$i] = '<li><a href="' . $link . '" ' . (($controller->id == $type && ($action == "index" || $action == "list") && $curentId == $genre->id) ? 'class="active_color"' : '') . '>' . $genre->name . '</a></li>';
                $i++;
            }
            if($rootGen['id']>0) {
                $html[$type]['_total'][$rootGen['id']] = $i;
            }
        }
        Yii::app()->cache->set($cache_code,$html[$type],Yii::app()->params['cacheTime']);
    }
}

$maxSubAlbum = max($html['album']['_total']);
$maxSubVideo = max($html['video']['_total']);
?>
<ul class="main_nav">
    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/hotlist')?>" <?php echo ($controller->id=='hotlist')?"class='active'":""?>>Hot List</a></li>
    <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/chart')?>" <?php echo ($controller->id=='chart')?"class='active'":""?>>BXH</a></li>

    <li><a class="<?php if($controller->id=='album') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/album'); ?>"><?php echo Yii::t('web', 'Album'); ?></a>
        <ul class="sub_nav1">
            <?php if($html['album']){
                foreach($html['album']['root'] as $genreId => $genRoot){
                    echo $genRoot;
                    if($html['album']['sub_'.$genreId]){
                        echo '<ul class="sub_nav2">';
                        for($i=0; $i<$maxSubAlbum; $i++){
                            echo isset($html['album']['sub_'.$genreId][$i])?$html['album']['sub_'.$genreId][$i]:'<li><a>&nbsp;</a></li>';
                        }
                        echo '</ul>';
                    }
                }
            }
            ?>
        </ul>
    </li>
    <li><a class="<?php if($controller->id=='video') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/video'); ?>"><?php echo Yii::t('web', 'MV'); ?></a>
        <ul class="sub_nav1">
            <?php if($html['video']){
                foreach($html['video']['root'] as $genreId => $genRoot){
                    echo $genRoot;
                    if($html['video']['sub_'.$genreId]){
                        echo '<ul class="sub_nav2">';
                        for($i=0; $i<$maxSubVideo; $i++){
                            echo isset($html['video']['sub_'.$genreId][$i])?$html['video']['sub_'.$genreId][$i]:'<li><a>&nbsp;</a></li>';
                        }
                        echo '</ul>';
                    }
                }
            }
            ?>
        </ul>
    </li>
    <li>
        <a class="<?php if($controller->id=='artist') echo 'active';?>" href="<?php echo Yii::app()->createUrl('/artist'); ?>"><?php echo Yii::t('web', 'Artist'); ?></a>
        <ul class="sub_nav1" style="width: 160px;left: -10px;">
            <li>
            <ul class="sub_nav2">
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/artist/index/', array('id'=>1,'ketword'=>'viet-nam'));?>"><?php echo Yii::t('web','Việt Nam')?></a></li>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/artist/index/', array('id'=>33,'ketword'=>'au-my'));?>"><?php echo Yii::t('web','Âu Mỹ')?></a></li>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl('/artist/index/', array('id'=>60,'ketword'=>'chau-a'));?>"><?php echo Yii::t('web','Châu Á')?></a></li>
            </ul>
            </li>
        </ul>
    </li>
</ul>