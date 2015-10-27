<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Create',
);\n";
?>

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('<?php echo $this->modelClass;?>Index')),	
);
$this->pageLabel = "Create <?php echo str_replace(array("Admin","Models","Model"), "", $this->modelClass) ?>";

?>


<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
