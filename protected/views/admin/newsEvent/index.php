<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('NewsEventCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách NewsEvent");

?>

  <div class="title-box search-box">
  <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

  <div class="search-form" style="display:block">

  <?php $this->renderPartial('_search',array(
  'model'=>$model,
  )); ?>
  </div><!-- search-form -->
  
<?php

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));

if(Yii::app()->user->hasFlash('NewsEvent')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('NewsEvent').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-news-event-model-grid',
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

			'name',
			'type',            
			'object_id',
			//'sorder',
			array(
	              'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"", array("class"=>"reorder","rel"=>$this->createUrl('newsEvent/reorder'))  ),
	              'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	              'type' => 'raw',
              ),
			array(
					'class'=>'CLinkColumn',
					'header'=>'Status',
					'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
					//'urlExpression'=>'($data->featured==1)?Yii::app()->createUrl("news/unhot",array("cid[]"=>$data->id)):Yii::app()->createUrl("news/hot",array("cid[]"=>$data->id))',
					'linkHtmlOptions'=>array(
					),
			
			),

            'id',
            //'channel',
            //'created_time',
			array(
				'class'=>'CButtonColumn',
			),
	),
));
$this->endWidget();

?>
