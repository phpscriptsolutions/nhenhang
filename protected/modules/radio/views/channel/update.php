<?php
$this->breadcrumbs=array(
	'Admin Radio Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

?>
<div class="submenu title-box xfixed">
                    <div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Cập nhật Kênh Radio # <?php echo $model->id;?></div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/channel')?>">Danh sách kênh</a></li>
<li><a href="<?php echo Yii::app()->createUrl('/radio/collection', array('id'=>$model->id))?>">Danh sách Collection</a></li>
</ul>
</div>
</div>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>