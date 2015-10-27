<?php
$this->breadcrumbs = array(
    'Quản lí nhóm SMS' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'Danh sách', 'url' => array('index'), 'visible' => UserAccess::checkAccess('spam-GroupIndex')),
);
$this->pageLabel = "Create SpamSmsGroup";
?>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>