<?php
$this->breadcrumbs=array(
	'Admin Artist Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ArtistCreate')),
);
$this->pageLabel =yii::t('admin','Danh sách nghệ sỹ');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'description'=>$description,
	'categoryList'=>$categoryList
)); ?>

</div><!-- search-form -->

<?php

if($model->search($joinRbt)->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
if(Yii::app()->user->hasFlash('Artist')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Artist').'</div>';
}

echo '</div>';

?>
<script>
    var idf = 'admin-artist-model-grid';
    var modelf = 'AdminArtistModel_page';
</script>
<?php
$urlMerge = Yii::app()->createUrl('artist/merge');

$script2 = <<<EOD
			function() {
				var id = $(this).parent().parent().find('td:first-child input').val();
				var name = $(this).parent().parent().find('.artist_name_display').text();
				$("#org_id").val(id);
				$("#artist_name").text(name);
				$("#dialog").dialog("open"); return false;
			}
EOD;

$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-artist-model-grid',
	'dataProvider'=>$model->search($joinRbt),
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
			'value'=>'chtml::link($data->name,Yii::app()->createUrl("artist/update",array("id"=>$data->id)))',
            'type'=>'raw',
			'htmlOptions'=>array('class'=>'artist_name_display'),
		),
         array(
            'name'=>'Avatar',
            'value'=>'CHtml::image(AdminArtistModel::model()->getAvatarUrl($data->id,50), "Avatar", array("height"=>35))',
            'type'=>'raw',
         ),
		//'url_key',
		'song_count',
		'video_count',
		'artist_key',
		'album_count',
		/*'created_by',
		'updated_by',
		'created_time',
		'updated_time',
		'sorder',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
			//'template' => '{view}{update}{delete}',
			'buttons' => array(
					'delete' => array(
							'click' => $script2,
					),
			),

            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-artist-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));

$this->endWidget();

include_once '_merge.php';
?>
