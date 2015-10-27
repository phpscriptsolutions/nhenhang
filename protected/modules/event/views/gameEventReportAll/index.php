<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Game Event Report All Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách GameEventReportAll");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('game-event-report-all-model-grid', {
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
)); ?>
</div><!-- search-form -->

<?php
/*
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
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','1'=>'Update'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';
echo $html_exp;

if(Yii::app()->user->hasFlash('GameEventReportAll')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('GameEventReportAll').'</div>';
}



$data = $model->search();
echo "<pre>"; print_r($model); echo "</pre>";
echo "<pre>"; print_r(json_decode(CJSON::encode($model))); echo "</pre>"; die();
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'game-event-report-all-model-grid',
	'dataProvider'=>$data,	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'date',
		'total_sub',
		'total_unsub',
		'access_event',
		'access_play',
		'total_play_all',		
		'total_msisdn_valid',
		'listen_music',
		'download_music',
		'play_video',
		'download_video',
		'have_transaction',
		
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('game-event-report-all-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();
*/

?>

<div class="content-body grid-view" style="padding-top: 20px;">
	<table width="100%" class="items">
		<tr>
			<th height="20" style="vertical-align: middle; color: #FFF">Ngày</th>
			<th height="20" style="vertical-align: middle; color: #FFF">TB đăng ký</th>
			<th height="20" style="vertical-align: middle; color: #FFF">TB hủy</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Truy cập landing page</th>
			<th height="20" style="vertical-align: middle; color: #FFF">TB tham dự</th>
			<th height="20" style="vertical-align: middle; color: #FFF">TB trả lời trọn bộ</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Đủ đk xét thưởng</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Lượt nghe nhạc</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Tải nhạc</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Play video</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Download video</th>
			<th height="20" style="vertical-align: middle; color: #FFF">TB sử dụng dịch vụ</th>
		</tr>
		<?php foreach ($data as $data):?>
		<tr>
			<td><?php echo $data['date']?></td>
			<td><?php echo $data['total_sub']?></td>
			<td><?php echo $data['total_unsub']?></td>
			<td><?php echo $data['access_event']?></td>			
			<td><?php echo $data['access_play']?></td>
			<td><?php echo $data['total_play_all']?></td>
			<td><?php echo $data['total_msisdn_valid']?></td>
			<td><?php echo $data['listen_music']?></td>
			<td><?php echo $data['download_music']?></td>
			<td><?php echo $data['play_video']?></td>
			<td><?php echo $data['download_video']?></td>
			<td><?php echo $data['have_transaction']?></td>			
		</tr>
		<?php endforeach;?>
		<tr>
			<td style="background-color: #5EC411 !important">Tổng số</td>
			<td style="background-color: #5EC411 !important"><?php echo $total['total_sub']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['total_unsub']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['access_event']?></td>			
			<td style="background-color: #5EC411 !important"><?php echo $total['access_play']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['total_play_all']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['total_msisdn_valid']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['listen_music']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['download_music']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['play_video']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['download_video']?></td>
			<td style="background-color: #5EC411 !important"><?php echo $total['have_transaction']?></td>			
		</tr>
	</table>
</div>

