<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách video'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                    'style'=>'font-size: 11px !important;'
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-video-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Lọc trên danh sách','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form">

<?php $this->renderPartial('_searchPopup',array(
	'model'=>$videoModel,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
)); ?>
</div>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform', 'style'=>'font-size: 11px !important;'),
));
$columns = array(

                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   	=>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'code',
		        'name',
                'genre_id',
                'artist_name',
            );
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-video-model-grid',
	'dataProvider'=>$videoModel->simpleSearch(isset($_GET['AdminVideoModel']['genre_id'])?$_GET['AdminVideoModel']['genre_id']:null, 14),
	'columns'=> $columns,
));

echo CHtml::hiddenField("video_playlist_id",$video_playlist_id);

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('videoPlaylist/addItems','id'=>0)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        //inlistzone = false;
						//$("#inlist-info").click();
						window.location.reload(true);
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));


$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
