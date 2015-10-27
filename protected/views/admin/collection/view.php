<?php
$this->pageLabel = Yii::t('admin', "") . "#" . $model->name;
?>


<div class="content-body">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name',
            'code',
            'type',
            'mode',
            'sql_query',
        ),
    ));
    ?>
</div>


<?php
$type = $model->type;

/**
$suggest_id = Yii::app()->request->getParam('suggest');
if($suggest_id == "1")
    $header = 'Nhạc miền tây';    
elseif($suggest_id == "2")
    $header = 'Nhạc quốc tế';
$suggest = "";
if(!empty($suggest_id)){
    if($mode == "auto")
        $suggest = "suggest_$suggest_id";
    else
        $suggest = $type."->suggest_$suggest_id";
}
if($mode == "auto")
    $item_id = 'id';
else
    $item_id = 'item_id';
$arr = 'created_time';
if(!empty($suggest)){
    $arr = array(
            'class' => 'CLinkColumn',
            'header' => $header,
            'labelExpression' => '($data->'.$suggest.'==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data->'.$suggest.'==1)?Yii::app()->createUrl("collection/unsuggest",array("cid[]"=>$data->'.$item_id.',"suggest" => "' . $suggest_id . '", "type" => "'.$type.'")):Yii::app()->createUrl("collection/suggest",array("cid[]"=>$data->'.$item_id.',"suggest" => "' . $suggest_id . '", "type" => "'.$type.'"))',
            'linkHtmlOptions' => array(
            ),
        );
}
*/$arr = 'created_time';


if($mode == "auto"){
    $this->renderPartial('autoItemList', array(
        'model' => $itemModel,
        'mainmodel' => $model,
        'type' => $type,
        'arr' => $arr
    ));
}
else{
    
    if ($type == "song") {
        $addItemLink = "song/list";
    } elseif ($type == "video") {
        $addItemLink = "videoFeature/addVideo";
    } elseif ($type == "album") {
        $addItemLink = "albumFeature/addAlbum";
    } elseif ($type == "playlist") {
        $addItemLink = "playlistFeature/addItems";
    } elseif ($type == "rbt") {
        $addItemLink = "ringbacktone/list";
    } elseif ($type == "rt") {
        $addItemLink = "ringtone/list";
    } elseif ($type == "video_playlist") {
        $addItemLink = "videoPlaylist/add2Collection";
    }

    $this->renderPartial('manualItemList', array(
        'model' => $itemModel,
        'mainmodel' => $model,
        'collect_id' => $model->id,
        'pageSize' => $pageSize,
        'addItemLink' => $addItemLink,
        'type' => $type,
        'arr' => $arr
    ));
}
?>