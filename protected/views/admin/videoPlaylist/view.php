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
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoPlaylistIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoPlaylistUpdate')),
);

if($model->status != AdminVideoPlaylistModel::DELETED ){
	$this->menu = CMap::mergeArray($this->menu, array(
						array('label'=>yii::t('admin','Xóa'), 'url'=>array('/videoPlaylist/confirmDel'), 'visible'=>UserAccess::checkAccess('AdminSongModelIndex'),'linkOptions'=>array('class'=>'delete-obj')),
					));
}

$this->pageLabel =Yii::t('admin','VideoPlaylist {name}',array('{name}'=>$model->name)); 
?>

<?php if($model->status == AdminVideoPlaylistModel::DELETED ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','VideoPlaylist này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
<div class="clb m5"></div>
<a href="<?php echo Yii::app()->createUrl("videoPlaylist/restore",array("id"=>$model->id,'return'=>$return)) ?>">
	<?php echo Yii::t('admin','Khôi phục'); ?>
</a>
<?php echo Yii::t('admin','videoPlaylist này?'); ?>
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
            $listItems = array(
                'id',
                'name',
                'url_key',
                array(
                    'label' => Yii::t('admin', 'Thể loại'),
                    'value' => $model->genre->name ? $model->genre->name : Yii::t('admin', 'Chưa rõ'),
                ),
                array(
                    'label' => yii::t('admin', 'Ca sỹ'),
                    'value' => ArtistHelper::ArtistNamesByVideoPlaylist($model->id),
                ),
                'video_count',
                'description:html',
                array(
                    'label' => yii::t('admin', 'Người tạo'),
                    'value' => $model->created_by ? $model->user->username : yii::t('admin', 'Vô danh'),
                ),
                'created_time',
                'updated_time',
            );

            $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => $listItems
            ));
            ?>
        </div>		
    </div>

    <div class="form" id="inlist-zone" style="display: none;">
    </div>	
    <div class="form" id="fav-zone" style="display: none;">
    </div>
</div>
