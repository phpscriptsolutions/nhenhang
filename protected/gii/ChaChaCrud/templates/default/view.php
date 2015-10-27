<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Index')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Update')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Delete')),
);
$this->pageLabel = Yii::t('admin', "Thông tin <?php echo str_replace(array("Admin","Models","Model"), "", $this->modelClass) ?>")."#".$model-><?php echo $this->tableSchema->primaryKey; ?>;
?>


<div class="content-body">
<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
</div>
