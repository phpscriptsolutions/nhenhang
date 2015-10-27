<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->breadcrumbs = array(
    'Quản lí số điện thoại' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Danh sách', 'url' => array('index'), 'visible' => UserAccess::checkAccess('spam-GroupIndex')),
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('spam-GroupCreate')),
    array('label' => Yii::t("admin", "Clone"), 'url' => array('clone&id='.Yii::app()->request->getParam("id")), 'visible' => UserAccess::checkAccess('spam-GroupClone')),
    array('label' => Yii::t("admin", "Sao chép Filter"), 'url' => array('cloneFilter&id='.Yii::app()->request->getParam("id")), 'visible' => UserAccess::checkAccess('spam-GroupClone')),
);
$this->pageLabel = Yii::t("admin", "Danh sác nhóm Spam");
?>
<div class="submenu title-box xfixed">
    <div id="yw5" class="portlet">
        <div class="portlet-content">

            <div class="page-title">Danh sách số điện thoại</div><ul id="yw6" class="operations">
                <li><a href="javascript:void(0);" onclick="toggleUpload()">Thêm mới</a></li>
            </ul></div>
    </div>				</div>
<?php
Yii::app()->clientScript->registerScript('search2', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-spam-sms-group-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<script type="text/javascript">
    function toggleUpload(){
        $('#upload-form').toggle();
        $('#search-form').toggle();
    }    
</script>

<div class="search-form" id="search-form" style="display:block">
    <?php
    $this->renderPartial('_searchPhone', array(
        'group_id' => $group_id
    ));
    ?>
</div><!-- search-form -->

<div class="form" id="upload-form" style="display:none">
    <p>&nbsp;</p>
    <?php
    $this->renderPartial('_upload', array(
        'model' => $model, 'group_id' => $group_id, 'uploadModel' => $uploadModel, 'message' => $message, 'errorList' => $errorList,
    ));
    ?>
</div><!-- upload-form --> 

<?php
$this->renderPartial('error', array(
    'message' => $message, 'errorList' => $errorList, 'dupList' => $dupList, 'subscribeList' => $subscribeList
));


$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">' . Yii::t("admin", "Chọn trang này") . '(' . $model->search()->getItemCount() . ')</a></li>
            <li><a href="javascript:void(0)" class="all-item">' . Yii::t("admin", "Chọn tất cả") . ' (' . $model->count() . ')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">' . Yii::t("admin", "Bỏ chọn tất cả") . '</a></li>
        </ul>
    </div>
';

if ($model->search()->getItemCount() == 0) {
    $padding = "padding:26px 0";
} else {
    $padding = "";
}
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl("spam/" . $this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform', 'style' => $padding),
        ));

if (Yii::app()->user->hasFlash('SpamSmsGroup')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('SpamSmsGroup') . '</div>';
}
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-spam-sms-group-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('phone' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
        'id',
        'phone',
        'group_id',
        'status',
        'created_time',
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("Group/deletep",array("id"=>$data["id"],"group_id" => ' . $group_id . '))',
        ),
//		array(
//			'class'=>'CButtonColumn',
//            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
//                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-spam-sms-group-model-grid',{ data:{pageSize: $(this).val() }})",
//                                                                                )),
//
//
//		),
    ),
));
$this->endWidget();
?>
