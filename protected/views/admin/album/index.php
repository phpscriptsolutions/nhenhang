<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

$this->menu=array(	
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AlbumCreate')),
);

$orderCol = array(
	    		'header'=>Yii::t('admin','Sắp xếp'),
	            	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"disabled"=>"disabled"))',
	            'type' => 'raw',
				'htmlOptions'=>array('width'=>50,'align'=>'center')
			);
					
switch ($this->type){
	case AdminAlbumModel::ALL:
		$title = "Danh sách album - Tất cả";
		break;
	case AdminAlbumModel::WAIT_APPROVED:
		$title = "Danh sách album - Chờ duyệt";
		break;
	case AdminAlbumModel::ACTIVE:
		$title = "Danh sách album - Đã duyệt";
		$orderCol = array(
			    		'header'=>Yii::t('admin','Sắp xếp').CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("class"=>"reorder","rel"=>$this->createUrl('album/reorder')) ),
			            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
			            'type' => 'raw',
						'htmlOptions'=>array('width'=>50,'align'=>'center')
					);
		break;
	case AdminAlbumModel::DELETED:
		$title = "Danh sách album - đã xóa";
		break;
}
$this->pageLabel = Yii::t('admin',$title);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(Yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'categoryList'=>$categoryList,
    'cpList' => $cpList,
	'description'=>$description
)); ?>
</div><!-- search-form -->

<?php

$bulkAction = array(''=>Yii::t("admin","Hành động"),'deleteAll'=>Yii::t("admin","Xóa"),'1'=>Yii::t("admin","Cập nhật"));
if($this->type == AdminAlbumModel::WAIT_APPROVED ){
    $bulkAction['approvedAll'] = Yii::t('admin','Duyệt');
}
if($this->type == AdminAlbumModel::ACTIVE){
    $bulkAction['export'] = Yii::t('admin','Export Excel');
}
if($this->type == AdminAlbumModel::DELETED){
	$bulkAction= array(''=>Yii::t("admin","Hành động"),'restore'=>Yii::t("admin","Khôi phục"));
    //$bulkAction= array(''=>Yii::t("admin","Hành động"),'massUpdate'=>Yii::t("admin","Cập nhật"));
}

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        $bulkAction,
                        array('onchange'=>'return album_submit_form(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'
	.CHtml::checkBox ("all-item",false,array("value"=>$model->search()->getTotalItemCount(),"style"=>"width:30px"))
	.CHtml::hiddenField("type",$this->type)
	.'</div>';
	
if(Yii::app()->user->hasFlash('Album')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Album').'</div>';
}	
echo '</div>';




switch ($this->type){
	/*
	case AdminAlbumModel::WAIT_APPROVED:
		$column = array(
				'class'=>'CButtonColumn',
				'template'=>'{approved}',
				'buttons'=>array(
							'approved'=>array(
										'label'=>'Duyệt',
										'imageUrl'=>Yii::app()->request->baseUrl.'/css/img/approved.png',
										'url'=>'Yii::app()->createUrl("song/approved", array("id"=>$data->id))',
										),
						),
				'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-video-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
				);
		break;
		*/
	case AdminAlbumModel::DELETED:
		$script= <<<EOD
			function() {
				$("input[name='cid\[\]']").each(function(){
			        this.checked = false;
			    });
			    
				$(this).parent().parent().find('td:first-child input').attr('checked',true);
				this.form.submit();
				return false;
			}
EOD;
		$column = 
		                    array(
								'class'=>'CButtonColumn',
								'buttons'=>array(
										'delete'=>array(
													'click'=> $script,
			                    					'title'=>Yii::t('admin','Khôi phục'),
												),
										),
								'deleteButtonLabel'=>Yii::t('admin','Khôi phục'),
								'deleteButtonImageUrl'=>Yii::app()->request->baseUrl."/css/img/revert.png",
								'deleteButtonUrl'=>'Yii::app()->createUrl("album/restore",array("cid[]"=>$data->id))',
								'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
				                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
				        				)),
				        );
		break;
	default:
		$url = Yii::app()->createUrl("/album/confirmDel");
		$script= <<<EOD
			function() {
				//if(!confirm('Xóa bản ghi này?')) return false;
				$("input[name='cid\[\]']").each(function(){
			        this.checked = false;
			    });
			    
				$(this).parent().parent().find('td:first-child input').attr('checked',true);
				deleteConfirm('yw1','$url');
				return false;
			}
EOD;
		$column = 
		                    array(
								'class'=>'CButtonColumn',
								'buttons'=>array(
										'delete'=>array(
												'click'=> $script,
												),
										),
								'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
				                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-album-model-grid',{ data:{pageSize: $(this).val() }})",
				        				)),
				        );
                    
		break;
	
}   

?>
<script>
    var idf = 'admin-album-model-grid';
    var modelf = 'AdminAlbumModel_page';
</script>
<?php

$this->widget('application.widgets.admin.grid.CGridView', array(
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

		array(
			'name'=>'name',
			'value'=>'chtml::link($data->name,Yii::app()->createUrl("album/update",array("id"=>$data->id)))',
            'type'=>'raw',
		),   
		array(
				'name'=>'Avatar',
				'value'=>'CHtml::image(AvatarHelper::getAvatar("album", $data->id, 50, strtotime($data->updated_time)), "Avatar", array("height"=>35))',
				'type'=>'raw',
		),
             
        array(
        	'header'=>'Category',
            //'value' => '$data->genre->name',
			'value'=>array($this,'getGenreName'),
		),
		
        array(
        	'header'=>'Artist',
            'name' => 'artist_name',
		),
		array(
				'header'=>'S-count',
				'name'=>'song_count',
		),
		
        /* array(
        	'header'=>'CP',
            'value' => '$data->cp->name',
		), */
        /* array(
        	'header'=>'Lượt nghe',
            'value' => 'isset($data->album_statistic->played_count)?$data->album_statistic->played_count:0',
		), */
       array(
			'header'=>'Time duyệt',
			'name'=>'updated_time'
		), 
        array(
			'header'=>'T',
			'value'=>'"<span class=\"s_label s_$data->status\">".substr($data->type,0,1)."</span>"',
			'type'=>'raw'
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
		'cmc_id',
		'id',
		$column,
		array(
			'header'=>'S',
			'value'=>'"<span class=\"s_label s_$data->status\">$data->status</span>"',
			'type'=>'raw'
		),
	),
));
$this->endWidget();

?>
