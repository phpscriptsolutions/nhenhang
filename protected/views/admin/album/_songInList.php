<a class="button" id="add-item" href="<?php echo $this->createUrl('album/addItems',array('album_id'=>$id)); ?>">
	<?php echo Yii::t('admin','Thêm bài hát'); ?>
</a> 

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-album-model-grid',
	'dataProvider'=>$songList->search(),
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
        array(
        	'header'=>'Bài hát',
            'name' => 'song.name',
		),
        array(
        	'header'=>'Ca sỹ',
            'name' => 'song.artist_name',
		),
		'song_id',
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),$this->createUrl('album/reorderItems',array('id'=>$id)),array("id"=>"reorder") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"class"=>"ordering"))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("album/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("album/publishItems",array("cid[]"=>$data->id))',
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