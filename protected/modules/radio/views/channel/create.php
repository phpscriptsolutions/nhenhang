<?php
$this->breadcrumbs=array(
	'Admin Radio Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminRadioModelIndex')),	
);

?>
<div class="submenu title-box xfixed">
                    <div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Tạo mới kênh</div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/channel')?>">Danh sách kênh</a></li>
</ul>
</div>
</div>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>