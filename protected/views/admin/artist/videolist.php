<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Video Models'=>array('index'),
	'Manage',
);

$this->pageLabel = Yii::t('admin', "Danh sách video của {artist}",array('{artist}'=>$artistName));

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

<?php $this->renderPartial('_searchVideo',array(
	'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'artistId'=>$artistId,
)); ?>
</div><!-- search-form -->
<?php
 $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform', 'style' => $padding),
        ));

$bulkAction = array('' => Yii::t("admin", "Hành động"), 'deleteAll' => Yii::t("admin", "Xóa"), '1' => Yii::t("admin", "Cập nhật"));

echo CHtml::dropDownList('bulk_action', '', $bulkAction, array('onchange' => 'return video_submit_form(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";



$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-video-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
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
					'value'=>'chtml::link(Formatter::substring($data->name," ",12),Yii::app()->createUrl("video/update",array("id"=>$data->id)))',
				    'type'=>'raw',
				),
				'code',
		        'artist_name',
		        array(
			    	'header'=>'Cp',
			        'name' => 'cp.name',
		        ),
		        array(
			    	'header'=>'Category',
			        'name' => 'genre.name',
		        ),
                array(
		             'name'=>'Ngày tạo',
		             'value'=>'date("d/m/Y", strtotime($data->created_time))',
		        ),
                array(
		             'name'=>'Nghe',
		             'value'=>'isset($data->video_statistic->played_count)?$data->video_statistic->played_count:0',
		        ),
                array(
		             'name'=>'Down',
		             'value'=>'isset($data->video_statistic->downloaded_count)?$data->video_statistic->downloaded_count:0',
		        ),
		         
			),
));
$this->endWidget();
?>
