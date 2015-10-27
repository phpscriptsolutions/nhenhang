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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	'Update',
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Index')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Create')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>View')),
);
$this->pageLabel = Yii::t('admin', "Sao chép <?php echo str_replace(array("Admin","Models","Model"), "", $this->modelClass) ?>")."#".$model-><?php echo $this->tableSchema->primaryKey; ?>;
?>



<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>