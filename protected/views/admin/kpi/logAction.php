<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
		<div class="row">
			<?php echo $form->label($model,'adminName'); ?>
			<?php echo $form->textField($model,'adminName'); ?>
		</div>
		<div class="row">
			<?php echo $form->label($model,'Hành động'); ?>
			<?php
			$category = CMap::mergeArray(
				array(''=> "Tất cả"),
				CHtml::listData($action, 'action', 'action')
			);
			echo CHtml::dropDownList("AdminLogActionModel[action]", $model->action, $category )
			?>

		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Tìm kiếm'); ?>
		</div>
	<?php $this->endWidget(); ?>
	</div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-html-model-grid',
		'dataProvider'=>$model->search(),
		'columns'=>array(
				'adminName',
				array(
						'header'=> 'Loại nội dung',
						'name'=>'controller',
				),

			array(
				'header'=> 'Hành động',
				'name'=>'action',
			),
			array(
				'header'=> 'Thời gian',
				'name'=>'created_time',
			),
			'ip',
				'id',
				array(
						'name'=>'Xem',
						'value'=>'Chtml::link("Xem",Yii::app()->createUrl("kpi/viewLogAction",array("id"=>$data->id)))',
						'type'=>'raw',
				),
		),
));

