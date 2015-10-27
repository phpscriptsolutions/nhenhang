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
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'collection-model-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <div class="row">
        <?php
        $metaData = array();
        if(!empty($collectionMetaData)){
            foreach($collectionMetaData as $meta){
                if(!empty($meta))
                    $metaData[$meta->meta_key] = $meta->meta_value;
            }
        }
        ?>
        <fieldset>
            <legend>SEO Meta Data</legend>
            <div class="row meta_field">
                <?php echo CHtml::label("Tiêu đề", ""); ?>
                <?php echo CHtml::textField("collectionMeta[title]", isset($metaData['title']) ? $metaData['title'] : "", array('style' => 'width:400px;', 'maxlength' => 100)); ?>
            </div>
            <div class="row meta_field">
                <?php echo CHtml::label("Từ khóa", ""); ?>
                <?php echo CHtml::textArea("collectionMeta[keywords]", isset($metaData['keywords']) ? $metaData['keywords'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 500)); ?>
            </div>
            <div class="row meta_field">
                <?php echo CHtml::label("Mô tả", ""); ?>
                <?php echo CHtml::textArea("collectionMeta[description]", isset($metaData['description']) ? $metaData['description'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 255)); ?>
            </div>
        </fieldset>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
