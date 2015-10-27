<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

$this->menu=array(	
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminAlbumModelCreate')),
);

					
$this->pageLabel = Yii::t('admin','Danh sách album của {artist}',array('{artist}'=>$artistName));

?>
<style>
<!--
	#basic-info,#meta-info{
		display: none!important;
	}
-->
</style>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-album-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'id',
		array(
			'name'=>'name',
			'value'=>'chtml::link($data->name,Yii::app()->createUrl("album/update",array("id"=>$data->id)))',
            'type'=>'raw',
		),                
        array(
        	'header'=>'Category',
            'name' => 'genre.name',
		),
		
        array(
        	'header'=>'Artist',
            'name' => 'artist_name',
		),
        array(
        	'header'=>'CP',
            'value' => '$data->cp->name',
		),
        array(
        	'header'=>'Lượt nghe',
            'value' => '$data->album_statistic->played_count',
		),
		//$orderCol,
		/*
		array(
    		'header'=>Yii::t('admin','Sắp xếp').CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("class"=>"reorder","rel"=>$this->createUrl('album/reorder')) ),
            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
		),*/
				
		/*
		'song_count',
		'publisher',
		'published_date',
		'description',
		'created_by',
		'approved_by',
		'updated_by',
		'cp_id',
		'created_time',
		'updated_time',
		'sorder',
		'status',
		*/
	),
));

?>
