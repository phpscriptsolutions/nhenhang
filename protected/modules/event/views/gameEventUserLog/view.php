<?php
$this->breadcrumbs=array(
	'Game Event User Log Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index')),
	//array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	//array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelUpdate')),
	//array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelDelete')),
	//array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin GameEventUserLog")."#".$model->id;
?>


<div class="content-body grid-view" style="padding-top: 20px;">
	<table width="100%" class="items">
		<tr>
			<th height="20" style="vertical-align: middle; color: #FFF">Thời gian bắt đầu chơi</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Số điện thoại</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Bộ cậu hỏi</th>
			<th height="20" style="vertical-align: middle; color: #FFF">Id bộ câu hỏi</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số điểm</th>
		</tr>
		<?php foreach ($data as $data):?>
		<tr>
			<td><?php echo $data['started_datetime']?></td>
			<td><?php echo $data['user_phone']?></td>
			<td><?php echo $data['thread_name']?></td>
			<td><?php echo $data['thread_id']?></td>
			<td><?php echo $data['total_point']?></td>			
		</tr>
		<?php endforeach;?>
	</table>
</div>


<div class="content-body">
<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'user_phone',
		'ask_id',
		'answer_id',
		'point',
		'thread_id',
		'started_datetime',
		'completed_datetime',
	),
)); */?>
</div>
