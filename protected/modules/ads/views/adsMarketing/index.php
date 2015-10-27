<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Ads Marketing Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách AdsMarketing");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-ads-marketing-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php

if(Yii::app()->user->hasFlash('AdsMarketing')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('AdsMarketing').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-ads-marketing-model-grid',
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
		'code',
		'name',
		'short_link',
		'dest_link',
		'action',
		/*
		'short_link',
		'dest_link',
		'package_id',
		'description',
		'created_datetime',
		'status',
		*/
		'id',
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-ads-marketing-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
			'template'=>'{report}{view}{update}{delete}',
			'buttons'=>array(
				'report'=>array(
						'label'=>'Thống kê',
						'url'=>'Yii::app()->createUrl("/reports/reportAdsClick", array("type"=>$data->code))',
						'options'=>array(
								'target'=>'_blank'
						)
			)	
			),


		),
	),
));

?>
