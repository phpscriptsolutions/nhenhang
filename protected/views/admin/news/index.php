<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->breadcrumbs = array(
    'Admin News Models' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('NewsCreate')),
);
$this->pageLabel = Yii::t("admin", "Danh sách News");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-news-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>
<?php /*
  <div class="title-box search-box">
  <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

  <div class="search-form" style="display:block">

  <?php $this->renderPartial('_search',array(
  'model'=>$model,
  )); ?>
  </div><!-- search-form -->
 */ ?>
<?php


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
/*
  echo '<div class="op-box">';
  echo CHtml::dropDownList('bulk_action','',
  array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','1'=>'Update'),
  array('onchange'=>'return submitform(this)')
  );
  echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

  echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
  echo '</div>';
  echo $html_exp;
 */
if (Yii::app()->user->hasFlash('News')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('News') . '</div>';
}

?>
<script>
    var idf = 'admin-news-model-grid';
    var modelf = 'AdminNewsModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
    'id' => 'admin-news-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('name' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
        'id',
        array(
            'name' => 'title',
            'value' => 'Chtml::link($data->title,Yii::app()->createUrl("news/update",array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        //'related_artists',
        'created_by',
        'created_time',
        /*
          'sorder',
          'status',
         */
        array(
            'header' => Yii::t('admin', 'Sắp xếp') . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("class" => "reorder", "rel" => $this->createUrl('news/reorder'))),
            'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
            'htmlOptions' => array(),
            'headerHtmlOptions' => array('width' => '62px', 'style' => 'text-align:left'),
        ),
        array(
                    'class'=>'CLinkColumn',
                    'header'=>'Hot',
                    'labelExpression'=>'($data->featured==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
                    'urlExpression'=>'($data->featured==1)?Yii::app()->createUrl("news/unhot",array("cid[]"=>$data->id)):Yii::app()->createUrl("news/hot",array("cid[]"=>$data->id))',
                    'linkHtmlOptions'=>array(
                                        ),

                ),    
        array(
            'class' => 'CButtonColumn',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-news-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
$this->endWidget();
?>
