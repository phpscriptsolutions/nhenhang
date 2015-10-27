<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

$this->menu=array(
);

$this->pageLabel = Yii::t('admin', "Danh sách bài hát của {artist}",array('{artist}'=>$artistName));


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
<style>
<!--
	#basic-info,#meta-info{
		display: none!important;
	}
-->
</style>
<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_searchSong',array(
	'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'artistId'=>$artistId,
)); ?>
</div><!-- search-form -->

<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));

$bulkAction = array(''=>Yii::t("admin","Hành động"),'deleteAll'=>Yii::t("admin","Xóa"),'1'=>Yii::t("admin","Cập nhật"));

echo CHtml::dropDownList('bulk_action','',
	                        $bulkAction,
	                        array('onchange'=>'return song_submit_form(this)')
	                );
	echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";



$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=> $columns = array(
                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
                array(
					 'name'=>'name',
					 'value'=>'chtml::link(Formatter::substring($data->name," ",12),Yii::app()->createUrl("song/update",array("id"=>$data->id)))',
                	 'type'=>'raw',
				 ),
                'code',
                array(
	                    'header'=>Yii::t('admin','Thể loại'),
	                    'name' => 'genre.name',
                    ),
                'artist_name',
                //$orderCol,
                array(
		             'name'=>'Ngày tạo',
		             'value'=>'date("d/m/Y", strtotime($data->created_time))',
		        ),
                array(
		             'name'=>'CP',
		             'value'=>'$data->cp->name',
		        ),
                array(
		             'name'=>'Nghe',
		             'value'=>'isset($data->song_statistic->played_count)?$data->song_statistic->played_count:0',
		        ),
                array(
		             'name'=>'Down',
		             'value'=>'isset($data->song_statistic->downloaded_count)?$data->song_statistic->downloaded_count:0',
		        ),
		         
                #$column 
            ),
));
$this->endWidget();
?>
