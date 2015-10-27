<?php
$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);

$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GenreIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GenreCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GenreView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('GenreCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật Genre")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList,'genreMetaData'=>$genreMetaData)); ?>