<?php 
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongIndex')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongUpdate')),
);
if($model->songstatus->approve_status != AdminSongStatusModel::REJECT ){
	$this->menu = CMap::mergeArray($this->menu, array(
						array('label'=>yii::t('admin','Xóa'), 'url'=>array('/song/confirmDel'), 'visible'=>UserAccess::checkAccess('SongIndex'),'linkOptions'=>array('class'=>'delete-obj')),
					));
}

$this->pageLabel = yii::t('admin','Bài hát: {name}',array('{name}'=>$model->name)); 
$lyrics = $model->lyrics;

?>
<?php
if($model->songstatus->approve_status == AdminSongStatusModel::REJECT ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','Bài hát này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
<div class="clb m5"></div>
<a href="<?php echo Yii::app()->createUrl("song/restore",array("cid[]"=>$model->id,'return'=>'view'  )) ?>">
	<?php echo Yii::t('admin','Khôi phục'); ?>
</a>
<?php echo Yii::t('admin','bài hát này?'); ?>
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
		$song = SongModel::model()->findByPk($model->id);
		$source = SongModel::model()->builDataPlayerSong($model->id,$model);
		$link = json_decode($source,true);
		$link = $link[0]["file"];
		
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
		        array(
		            'label'=>'Nghe thử',
		            'value'=>'
		                <object width="290" height="24" type="application/x-shockwave-flash" data="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf" id="audioplayer1">
			                <param name="movie" value="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf">
			                <param name="FlashVars" value="playerID=1&amp;soundFile='.$link.'">
			                <param name="quality" value="high">
			                <param name="menu" value="false">
			                <param name="wmode" value="transparent">
			            </object>',
		            'type'=>'raw'
		        ),        
				'id',
				'code',
				'name',
				'url_key',
		        array(
		            'label'=>'Thể loại',
		            'value'=>$this->songCate,
		        ),
				'artist_name',
				'duration',
				'max_bitrate',
		        array(
		            'label'=>yii::t('admin','Người tạo'),
		            'value'=>$model->created_by?$model->user->username:yii::t('admin','Vô danh'),
		        ),
				'video_id',
				'video_name',        
		        array(
		            'label'=>yii::t('admin','Cp'),
		            'value'=>$model->cp_id,
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
		       'cmc_id',
		        array(
		            'label'=>'Lời',
		            'value'=>nl2br($lyrics),
		            'type'=>'html'
		        ),);

        $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>$listItems
        ));
        ?>
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
