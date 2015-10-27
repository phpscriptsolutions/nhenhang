<?php 
$songExtra = AdminSongExtraModel::model()->findByAttributes(array("song_id"=>$model->id));
$lyrics = ($songExtra)?nl2br($songExtra->lyrics) :"";
?>
<h3>Thông tin chi tiết Bài hát</h3>
<div class="content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
		<?php 
		switch ($model->songstatus->convert_status){
			case AdminSongStatusModel::NOT_CONVERT:
				$convertStatus = Yii::t('admin','Chưa convert');
				break; 
			case AdminSongStatusModel::CONVERT_SUCCESS:
				$convertStatus = Yii::t('admin','Đã convert');
				break; 
			case AdminSongStatusModel::CONVERT_FAIL:
				$convertStatus = Yii::t('admin','Convert lỗi');
				break; 
			
		}
		
		switch ($model->songstatus->approve_status){
			case AdminSongStatusModel::WAIT_APPROVED:
				$approveStatus = Yii::t('admin','Chờ duyệt');
				break; 
			case AdminSongStatusModel::APPROVED :
				$approveStatus = Yii::t('admin','Đã duyệt');
				break; 
			case AdminSongStatusModel::REJECT:
				$approveStatus = Yii::t('admin','Từ chối(xóa)');
				break; 
			
		}
		switch ($model->status){
			case "0":
				$publist_status = Yii::t('admin','Unpublish');
				break;
			case "1":
				$publist_status = Yii::t('admin','Publish');
				break;
		}
      
        $listItems = array(
				'id',
				'code',
				'name',
				'url_key',
		        array(
		            'label'=>'Thể loại',
		            'value'=>$songCate,
		        ),
				'artist_name',
				'duration',
				'max_bitrate',
		        array(
		            'label'=>yii::t('admin','Người tạo'),
		            'value'=>$model->created_by?$model->user->username:yii::t('admin','Vô danh'),
		        ),        
		        array(
		            'label'=>yii::t('admin','Cp'),
		            'value'=>$model->cp_id?$model->cp->name:yii::t('admin','Vô danh'),
		        ),        
				'created_time',
				'updated_time',
		        array(
		            'label'=>yii::t('admin','Trạng thái convert'),
		            'value'=>$convertStatus,
		        ), 
		        array(
		            'label'=>yii::t('admin','Trạng thái duyệt'),
		            'value'=>$approveStatus,
		        ), 
		        array(
		            'label'=>Yii::t('admin','Trạng thái BH'),
 		            'value'=>$publist_status,

		        ), 
		        array(
		            'label'=>'Lời',
		            'value'=>$lyrics,
		            'type'=>'html'
		        ),);
        
        $className = get_class($model);            
        $suggestItems = MainContentModel::viewSuggestList($className,$model->id);
        $items = array_merge($listItems,$suggestItems);
        
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>$items
		)); ?>
		</div>
		<div class="row meta_field">
			<?php 
			if($metaModel){
				$this->widget('zii.widgets.CDetailView', array(
					'data'=>$metaModel,
					'attributes'=>array(
						'title',
						'keywords',
						'description',
					),
				));
			}
			 ?>			
		</div>
	</div>
</div>
