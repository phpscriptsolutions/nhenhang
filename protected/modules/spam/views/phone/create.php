<?php
$this->breadcrumbs = array(
    'Quản lí số điện thoại' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List', 'url' => array('index'), 'visible' => UserAccess::checkAccess('spam-GroupIndex')),
);
$this->pageLabel = "Create SpamSmsGroup";
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'uploadModel' => $uploadModel, 'message' => $message,  'errorList' => $errorList,'smsGroup' => $smsGroup,)); ?>