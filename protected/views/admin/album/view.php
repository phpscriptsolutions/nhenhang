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
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumUpdate')),
);

if($model->albumstatus->approve_status != AdminAlbumStatusModel::REJECT ){
	$this->menu = CMap::mergeArray($this->menu, array(
						array('label'=>yii::t('admin','Xóa'), 'url'=>array('/album/confirmDel'), 'visible'=>UserAccess::checkAccess('AdminSongModelIndex'),'linkOptions'=>array('class'=>'delete-obj')),
					));
}

$this->pageLabel =Yii::t('admin','Album {name}',array('{name}'=>$model->name)); 
?>

<?php if($model->albumstatus->approve_status == AdminAlbumStatusModel::REJECT ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','Album này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
<div class="clb m5"></div>
<a href="<?php echo Yii::app()->createUrl("album/restore",array("cid[]"=>$model->id,'return'=>'view'  )) ?>">
	<?php echo Yii::t('admin','Khôi phục'); ?>
</a>
<?php echo Yii::t('admin','album này?'); ?>
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
			switch ($model->albumstatus->approve_status){
				case AdminAlbumStatusModel::WAIT_APPROVED:
					$status = Yii::t('admin','chờ duyệt');
					break; 
				case AdminAlbumStatusModel::APPROVED:
					$status = Yii::t('admin','Đã duyệt');
					break; 
				case AdminAlbumStatusModel::REJECT:
					$status = Yii::t('admin','Đã xóa');
					break; 
			}
		$listItems = array(
				'id',
				'name',
				'url_key',
		        array(
		            'label'=>Yii::t('admin','Thể loại'),
		            'value'=>$model->genre->name?$model->genre->name:Yii::t('admin','Chưa rõ'),
		        ),		
				array(
						'label'=>yii::t('admin','Ca sỹ'),
						'value'=>ArtistHelper::ArtistNamesByAlbum($model->id),
				),
				//'artist_name',
				'song_count',
				'publisher',
				'published_date',
				'description:html',
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
		            'label'=>yii::t('admin','Trạng thái'),
		            'value'=>$status,
		        ), 
			);	
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=> $listItems
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
	
	<div class="form" id="inlist-zone" style="display: none;">
	</div>	
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>
