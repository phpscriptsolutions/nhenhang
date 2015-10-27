<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Admin User Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminUserCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách Admin User");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-admin-user-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'cpList'=>$cpList
)); ?>
</div><!-- search-form -->

<?php
$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">'. Yii::t("admin","Chọn trang này").'('.$model->search()->getItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="all-item">'.  Yii::t("admin","Chọn tất cả").' ('.$model->count().')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">'.  Yii::t("admin","Bỏ chọn tất cả").'</a></li>
        </ul>
    </div>
';

if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));

if(Yii::app()->user->hasFlash('User')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('User').'</div>';
}

?>
<script>
    var idf = 'admin-admin-user-model-grid';
    var modelf = 'AdminAdminUserModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-admin-user-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'id',
		array(
				'name'=>'username',
				'value'=>'Chtml::link($data->username,Yii::app()->createUrl("adminUser/update",array("id"=>$data->id)))',
                'type'=>'raw',
		),
         array(
         	'header'=>Yii::t('admin','Cp Name'),
         	'name'=>'cp.name',
         ),
		
		'email',
		'fullname',
		'phone',
		'company',
		array(
		'name'=>'status',
		'value'=>'str_replace(array(0,1),array("<span class=\"s_label s_2\">Không kích hoạt</span>","<span class=\"s_label s_1\">Đang kích hoạt</span>"), $data->status)',
		'type'=>'raw',
		'htmlOptions'=>array('align'=>'center')
		),
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-admin-user-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
