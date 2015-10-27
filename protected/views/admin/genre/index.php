<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
$this->breadcrumbs = array(
    'Admin Genre Models' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create'), 'visible' => UserAccess::checkAccess('GenreCreate')),
);
$this->pageLabel = Yii::t('admin', 'Quản lý thể loại');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-genre-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>
  <div class="title-box search-box">
  <?php echo CHtml::link(Yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>


  <div class="search-form" style="display:block">

  <?php 
  $this->renderPartial('_search',array(
  'model'=>$model,
  'categoryList'=>$categoryList,
  )); ?>
  </div><!-- search-form -->
<?php

$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">' . Yii::t("admin", "Chọn trang này") . '(' . $model->count() . ')</a></li>
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
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform', 'style' => $padding),
        ));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action', '', array('' => Yii::t("admin", "Hành động"),), array('onchange' => 'return submitform(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">' . CHtml::checkBox("all-item", false, array("value" => $model->count(), "style" => "width:30px")) . '</div>';
if (Yii::app()->user->hasFlash('Genre')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('Genre') . '</div>';
}

echo '</div>';
//echo $html_exp;

$this->widget('application.widgets.admin.grid.GGridView', array(
    'id' => 'admin-genre-model-grid',
    'enablePagination' => false,
    'treeData' => $treeData,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('name' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left;height:30px;padding-top:10px'),
            'id' => 'cid',
            'checked' => 'false'
        ),
        'id',
//        'name',
        array(
            'name' => 'name',
            'value' => 'chtml::link(Formatter::substring($data["name"]," ",12),Yii::app()->createUrl("genre/view",array("id"=>$data["id"])))',
            'type' => 'raw',
        ),
    	'type',
        #'sorder',	
        array(
            'header' => Yii::t('admin', 'Sắp xếp') . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), '', array("class" => "reorder", "rel" => Yii::app()->createUrl('genre/reorder'))),
            'value' => '($data["parent_id"]==0)?CHtml::textField(\'sorder[\'.$data["id"].\']\', $data["sorder"],array("size"=>1)):CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/uparrow.png"),Yii::app()->createUrl("genre/uplever",array("id"=>$data["id"])),array("class"=>"uplevel", ) ) . CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/downarrow.png"),Yii::app()->createUrl("genre/downlever",array("id"=>$data["id"])),array("class"=>"uplevel") )',
            'type' => 'raw',
            'htmlOptions' => array('align' => 'center'),
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'Hiển thị',
            'labelExpression' => '($data["status"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["status"]==1)?Yii::app()->createUrl("genre/unpublish",array("cid[]"=>$data["id"])):Yii::app()->createUrl("genre/publish",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'Hot',
            'labelExpression' => '($data["is_hot"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["is_hot"]==1)?Yii::app()->createUrl("genre/unhot",array("cid[]"=>$data["id"])):Yii::app()->createUrl("genre/hot",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'New',
            'labelExpression' => '($data["is_new"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["is_new"]==1)?Yii::app()->createUrl("genre/unnew",array("cid[]"=>$data["id"])):Yii::app()->createUrl("genre/new",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        ),
        
        array(
            'class' => 'CLinkColumn',
            'header' => 'Is_collection',
            'labelExpression' => '($data["is_collection"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["is_collection"]==1)?Yii::app()->createUrl("genre/uncollection",array("cid[]"=>$data["id"])):Yii::app()->createUrl("genre/collection",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'htmlOptions' => array('width' => '65px'),
        ),
    ),
));

$this->endWidget();
?>
