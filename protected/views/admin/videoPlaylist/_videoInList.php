<a class="button" id="add-item" href="<?php echo $this->createUrl('videoPlaylist/addItems',array('video_playlist_id'=>$id)); ?>">
	<?php echo Yii::t('admin','Thêm video'); ?>
</a> 

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-video-playlist-model-grid',
	'dataProvider'=>$videoList->search(),	
	'columns'=>array(
            /*array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),*/

		'id',
		'video_id',
		
        array(
        	'header'=>'Video',
            'name' => 'video.name',
		),
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),$this->createUrl('videoPlaylist/reorderItems',array('id'=>$id)),array("id"=>"reorder") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"class"=>"ordering"))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==0)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==0)?Yii::app()->createUrl("videoPlaylist/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoPlaylist/publishItems",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
		
		),
	),
));
Yii::app()->user->setState('pageSize',30);
?>
<?php 
$this->endWidget();
?>