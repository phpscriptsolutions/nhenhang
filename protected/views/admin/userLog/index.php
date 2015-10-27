<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin User Activity Models'=>array('index'),
	'Manage',
);


$this->pageLabel = Yii::t("admin","Tra cứu các hoạt động trên website");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
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

if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));


if(Yii::app()->user->hasFlash('UserActivity')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('UserActivity').'</div>';
}

$summaryText= CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array('onchange'=>"$.fn.yiiGridView.update('admin-user-activity-model-grid',{ data:{pageSize: $(this).val() }})", ))."&nbsp;".Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
?>
<script>
    var idf = 'admin-user-activity-model-grid';
    var modelf = 'AdminUserActivityModel_page';
</script>
<?php
if($user){
	$this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'admin-user-activity-model-grid',
		'dataProvider'=>$model->search(),
		'columns'=>array(
			'user_phone',
			'activity',
			'obj1_id',
			'obj1_name',
			'obj2_id',
	        'loged_time',
		),
	    'summaryText'=>$summaryText,
	));
}
$this->endWidget();

?>
