<h3>Thông tin chi tiết video</h3>

<div class="content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
			<?php
			
		switch ($model->videostatus->convert_status){
			case AdminVideoStatusModel::NOT_CONVERT:
				$convertStatus = Yii::t('admin','Chưa convert');
				break; 
			case AdminVideoStatusModel::CONVERT_SUCCESS:
				$convertStatus = Yii::t('admin','Đã convert');
				break; 
			case AdminVideoStatusModel::CONVERT_FAIL:
				$convertStatus = Yii::t('admin','Convert lỗi');
				break; 
			
		}
		
		switch ($model->videostatus->approve_status){
			case AdminVideoStatusModel::WAIT_APPROVED:
				$approveStatus = Yii::t('admin','Chờ duyệt');
				break; 
			case AdminVideoStatusModel::APPROVED :
				$approveStatus = Yii::t('admin','Đã duyệt');
				break; 
			case AdminVideoStatusModel::REJECT:
				$approveStatus = Yii::t('admin','Từ chối(xóa)');
				break; 
			
		}
					
        $listItems = array(
					'id',
					array(
						'label'=>yii::t('admin', 'Ảnh đại diện'),
						'value'=>CHtml::image($model->getAvatarUrl(),"avatar"),
						'type'=>'raw'
					),
					'code',
					'name',
					'url_key',
					'duration',
			        array(
			            'label'=>'Category',
			            'value'=>$model->genre->name,
			        ),
					'artist_name',
			        array(
			            'label'=>yii::t('admin','Người tạo'),
			            'value'=>$model->created_by?$model->user->username:yii::t('admin','Vô danh'),
			        ),
			        array(
			            'label'=>yii::t('admin','Cp'),
			            'value'=>$model->cp_id?$model->cp->name:yii::t('admin','Vô danh'),
			        ),
					'download_price',
					'listen_price',
					'max_bitrate',
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
				);
		
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
	<div class="form" id="fav-zone" style="display: none;">	</div>
</div>