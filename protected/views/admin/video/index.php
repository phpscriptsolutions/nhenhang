<style>
    .button-column{
        width: 65px!important;
    }
    .link-column{
        width: 30px;
        text-align: center;
    }
</style>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Video Models'=>array('index'),
	'Manage',
);

$this->menu=array(
);
switch ($this->type){
	case AdminVideoModel::NOT_CONVERT:
		$title = "Danh sách video - chưa convert";
		break;
	case AdminVideoModel::WAIT_APPROVED:
		$title = "Danh sách video - Chờ duyệt";
		break;
	case AdminVideoModel::ACTIVE:
		$title = "Danh sách video - đang hoạt động";
		break;
	case AdminVideoModel::CONVERT_FAIL:
		$title = "Danh sách video - convert lỗi";
		break;
	case AdminVideoModel::DELETED:
		$title = "Danh sách video - đã xóa";
		break;
	default:
		$title = "Danh sách video - tất cả";
		break;
}
$this->pageLabel = Yii::t('admin', $title);

?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'categoryList'=>$categoryList,
	'cpList'=>$cpList,
    'lyric' => $lyric
)); ?>
</div><!-- search-form -->

<?php
/* $html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">'. Yii::t("admin","Chọn trang này").'('.$model->search()->getItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="all-item">'.  Yii::t("admin","Chọn tất cả").' ('.$model->search()->getTotalItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">'.  Yii::t("admin","Bỏ chọn tất cả").'</a></li>
        </ul>
    </div>
'; */

$bulkAction = array(''=>Yii::t("admin","Hành động"),'deleteAll'=>Yii::t("admin","Xóa"),'1'=>Yii::t("admin","Cập nhật"));
if($this->type == AdminVideoModel::WAIT_APPROVED){
    $bulkAction['approvedAll'] = Yii::t('admin','Duyệt');
}
if($this->type == AdminVideoModel::ACTIVE){
    $bulkAction['export'] = Yii::t('admin','Export Excel');
}
if($this->type == AdminVideoModel::DELETED){
    $bulkAction = array(''=>Yii::t("admin","Hành động"),'restore'=>'Khôi phục');
}

if($this->type == AdminVideoModel::WAIT_APPROVED
	|| $this->type == AdminVideoModel::ACTIVE
	|| $this->type == AdminVideoModel::CONVERT_FAIL){

		$bulkAction['reconvert'] = Yii::t('admin','Set convert lại');
}

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
echo '<div class="op-box">';
if($this->type == AdminSongModel::NOT_CONVERT){
	echo "<p>&nbsp;</p>";
}else{
	echo CHtml::dropDownList('bulk_action','',
	                        $bulkAction,
	                        array('onchange'=>'return video_submit_form(this)')
	                );
	echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

	echo '<div style="display:none">'
		//.CHtml::checkBox ("all-item",false,array("value"=>$model->search()->getTotalItemCount(),"style"=>"width:30px"))
		.CHtml::checkBox ("all-item",false,array("value"=>0,"style"=>"width:30px"))
		.CHtml::hiddenField("type",$this->type)
		.'</div>';
	if(Yii::app()->user->hasFlash('Video')){
	    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Video').'</div>';
	}
}

echo '</div>';
//echo $html_exp;

$columns = array(
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
			'value'=>'chtml::link($data->name,Yii::app()->createUrl("video/update",array("id"=>$data->id)))',
		    'type'=>'raw',
		),
		'code',
        'artist_name',
        array(
	    	'header'=>'Cp',
	        'name' => 'cp.name',
        ),
        array(
	    	'header'=>'Category',
	        'name' => 'genre.name',
        ),
	);
switch ($this->type){
	case AdminVideoModel::WAIT_APPROVED:
		$column = array(
				'class'=>'CButtonColumn',
				'template'=>'{approved}',
				'buttons'=>array(
							'approved'=>array(
										'label'=>Yii::t('admin','Duyệt'),
										'imageUrl'=>Yii::app()->request->baseUrl.'/css/img/approved.png',
										'url'=>'Yii::app()->createUrl("video/approved", array("id"=>$data->id))',
										),
						),
				'deleteButtonUrl'=>'#',
				'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-video-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
				);
		break;
	case AdminVideoModel::DELETED:
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
								'deleteButtonUrl'=>'Yii::app()->createUrl("video/restore",array("cid[]"=>$data->id))',
								'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
				                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
				        				)),
				        );
		break;
	default:
		$url = Yii::app()->createUrl("/video/confirmDel");
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

		$column = array(
				'class'=>'CButtonColumn',
				'buttons'=>array(
						'delete'=>array(
								'click'=> $script,
								),
						),
				'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-video-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
				);
		break;

}
?>
<script>
    var idf = 'admin-video-model-grid';
    var modelf = 'AdminVideoModel_page';
</script>
<?php

$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-video-model-grid',
	'dataProvider'=>$model->search(true),
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
					'value'=>'chtml::link(Formatter::substring($data->name," ",12),Yii::app()->createUrl("video/update",array("id"=>$data->id)))',
				    'type'=>'raw',
				),
				'code',
				array(
					'name'=>'quality name',
					'value'=>'$data->profile_ids ? "<div id=\"r_$data->id\">".CHtml::tag("span", array("class"=>"s_label s_1","id"=>$data->id), max(explode(",",str_replace(array("1,","2,","3,","4,","5,","6,","7,","8,"),array("","","","","","240p,","360p","480p,"), $data->profile_ids.","))))."</div>" : ""',
					'type'=>'raw',
					'htmlOptions'=>array('align'=>'center')
			),
		        'artist_name',
		        array(
			    	'header'=>'Cp',
			        'name' => 'cp.name',
		        ),
		        array(
			    	'header'=>'Category',
			       // 'name' => 'videogenre.genre_name',
                    'value'=>'AdminVideoModel::getGenreName($data->videogenre)'
		        ),
                array(
		             'name'=>'Created date',
		             'value'=>'date("d/m/Y", strtotime($data->created_time))',
		        ),
                array(
		             'name'=>'Nghe',
		             'value'=>'isset($data->video_statistic->played_count)?$data->video_statistic->played_count:0',
		        ),
                array(
		             'name'=>'Down',
		             'value'=>'isset($data->video_statistic->downloaded_count)?$data->video_statistic->downloaded_count:0',
		        ),
		        array(
                'class'=>'CLinkColumn',
                'header'=>'Lyrics',
                'labelExpression'=>'(!isset($data->videoextra) || $data->videoextra->description=="")?CHtml::image(Yii::app()->request->baseUrl."/css/img/lyric.png", "#", array("id"=>$data->id)):CHtml::image(Yii::app()->request->baseUrl."/css/img/lyric_new.png", "#", array("id"=>$data->id))',
                'urlExpression'=>'Yii::app()->createUrl("/video/lyric", array("id"=>$data->id))',
                'linkHtmlOptions'=>array('onclick'=>'
                        var url = $(this).attr("href");
                        editlyric(url);
                        return false;
                    '),
                ),
				'cmc_id',
		        $column
			),
));
$this->endWidget();

?>
