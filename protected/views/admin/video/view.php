<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);

	$this->menu=array(
		array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoIndex')),
		array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoUpdate')),
	);
	
	if($model->videostatus->approve_status != AdminSongStatusModel::REJECT ){
		$this->menu = CMap::mergeArray($this->menu, array(
							array('label'=>yii::t('admin','Xóa'), 'url'=>array('/video/confirmDel'), 'visible'=>UserAccess::checkAccess('AdminSongModelIndex'),'linkOptions'=>array('class'=>'delete-obj')),
						));
	}

	$this->pageLabel = Yii::t('admin', 'Video {name}',array('{name}'=>": ".$model->name));
?>
<div class="player-video talignc">
	<object width="360" height="150" type="application/x-shockwave-flash" data="<?php yii::app()->request->baseUrl ?>/flash/player-full.swf" id="video_embed">
	<param name="file" value="<?php echo $model->getVideoOriginUrl() ?>" />
	<param name="autostart" value="true" />
	<param name="allowfullscreen" value="true" />
	<param name="wmode" value="transparent" />
	<param name="bgcolor" value="#ffffff" />
	<param name="flashvars" value="file=<?php echo $model->getVideoOriginUrl() ?>&amp;autostart=true&amp;allowfullscreen=true&amp;fullscreen=true"></object>
</div>

<?php if($model->videostatus->approve_status == AdminVideoStatusModel::REJECT ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','Video này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
	<div class="clb m5"></div>
	<a href="<?php echo Yii::app()->createUrl("video/restore",array("cid[]"=>$model->id,'return'=>'view' )) ?>">
		<?php echo Yii::t('admin','Khôi phục'); ?>
	</a>
	<?php echo Yii::t('admin','video này?'); ?>
</div>
<?php else:?>
<div class="form-delete hide">
	<form id="delete-obj-form">
		<input type="checkbox" checked="checked" name="cid[]" value="<?php echo $model->id ?>" />
		<input type="hidden" name="reqsource" value="viewlayout" />
	</form>
</div>
<?php endif;?>

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
        $genre = $model->videogenre;
        $genreName = array();
        if($genre) {
            foreach ($genre as $g) {
                $genreName[]= $g->genre_name;
            }
        }
        $urlThumb = AvatarHelper::getAvatar("video", $model->id, 150, strtotime($model->updated_time));
        
        $listItems = array(
					'id',
					array(
						'label'=>yii::t('admin', 'Ảnh đại diện'),
						'value'=>CHtml::image($urlThumb,"avatar"),
						'type'=>'raw'
					),
					'code',
					'name',
					'url_key',
					'duration',
			        array(
			            'label'=>'Category',
			            'value'=>implode(', ',$genreName)
			        ),
					'artist_name',
			        array(
			            'label'=>yii::t('admin','Người tạo'),
			            'value'=>isset($model->user)?$model->user->username:yii::t('admin','Vô danh'),
			        ),
			        array(
			            'label'=>yii::t('admin','Cp'),
			            'value'=>isset($model->cp)?$model->cp->name:yii::t('admin','Không xác định'),
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
			        array(
			            'label'=>yii::t('admin','Trạng thái video'),
			            'value'=>$model->status,
			        ),			        
				);
		
            $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>$listItems
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