<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách video'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-song-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform', 'style'=>'font-size:11px;'),
));
echo CHtml::hiddenField("video_playlist_id",$video_playlist_id);

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('videoPlaylist/addSong','id'=>0)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        window.location.reload( true );
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));

$columns = array(
    
                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left;font-size:11px;'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'code',
		        'name',
                array(
	                    'header'=>'category',
	                    'name' => 'genre.name',
                    ),
                'artist_name',
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$songModel->search(),	
	'columns'=> $columns,
));

$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
