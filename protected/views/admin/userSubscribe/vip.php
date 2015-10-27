<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
);
$this->pageLabel = Yii::t("admin","Danh sách thuê bao Vip");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-user-subscribe-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
		<table width="100%">
			<tr>
				<td style="vertical-align:middle; text-align: left;"><?php echo $form->label($model,'user_phone'); ?></td>
				<td style="vertical-align:middle; text-align: left;"><?php echo $form->textField($model,'user_phone',array('size'=>16,'maxlength'=>16)); ?></td>
				<td style="vertical-align:middle; text-align: left;"><?php echo CHtml::submitButton('Search'); ?></td>
			</tr>
		</table>
	<?php $this->endWidget(); ?>
	</div>
</div><!-- search-form -->

<div class="title-box">
    <?php echo CHtml::link(yii::t('admin','Thêm số'),'#',array('class'=>'search-button')); ?></div>

<div class="add-form" style="display:block;padding: 25px 5px; background: #FFF">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'post',
	));
	if(Yii::app()->user->hasFlash('uservip')){
	    echo '<div class="errorSummary">'.Yii::app()->user->getFlash('uservip').'</div>';
	}

	?>


		<table width="100%">
			<tr>
				<td style="vertical-align:middle; text-align: left;"><?php echo CHtml::label("Nhập số Vina", ""); ?></td>
				<td style="vertical-align:middle; text-align: left;"><?php echo CHtml::textField('phone','',array('size'=>16,'maxlength'=>16)); ?></td>
				<td style="vertical-align:middle; text-align: left;"><?php echo CHtml::submitButton('Add'); ?></td>
			</tr>
		</table>
	<?php $this->endWidget(); ?>
	</div>
</div><!-- search-form -->

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-user-subscribe-model-grid',
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

         array(
         	'header'=>'SDT',
         	'name'=>'user_phone',
         ),
         array(
         	'header'=>'Ngày tạo',
         	'name'=>'created_time',
         ),
         'id',
	),
));




?>
