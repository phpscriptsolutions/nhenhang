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
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");

$this->menu = array(
);

$orderCol = array(
    'header' => Yii::t('admin', 'Sắp xếp'),
    'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"disabled"=>"disabled"))',
    'type' => 'raw',
    'htmlOptions' => array('width' => 50, 'align' => 'center')
);

switch ($this->type) {
    case AdminSongModel::NOT_CONVERT:
        $title = "Danh sách bài hát - chưa convert";
        break;
    case AdminSongModel::WAIT_APPROVED:
        $title = "Danh sách bài hát - chờ duyệt";
        break;
    case AdminSongModel::ACTIVE:
        $title = "Danh sách bài hát - đang hoạt động";
        $orderCol = array(
            'header' => Yii::t('admin', 'Sắp xếp') . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("class" => "reorder", "rel" => $this->createUrl('song/reorder'))),
            'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
            'htmlOptions' => array(),
            'headerHtmlOptions' => array('width' => '62px', 'style' => 'text-align:left'),
        );
        break;
    case AdminSongModel::CONVERT_FAIL:
        $title = "Danh sách bài hát - convert lỗi";
        break;
    case AdminSongModel::DELETED:
        $title = "Danh sách bài hát - đã xóa";
        break;
    default:
        $title = "Danh sách bài hát - tất cả";
        break;
}
$this->pageLabel = Yii::t('admin', $title);
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm', '#', array('class' => 'search-button')); ?></div>

<div class="search-form">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
        'categoryList' => $categoryList,
        'cpList' => $cpList,
        'lyric' => $lyric,
		'is_composer'=>$is_composer,
		'copyright'=>$copyright,
		'copyrightType'=>$copyrightType
    ));
    ?>
</div><!-- search-form -->

<?php
/* $html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">' . Yii::t("admin", "Chọn trang này") . '()</a></li>
            <li><a href="javascript:void(0)" class="all-item">' . Yii::t("admin", "Chọn tất cả") . ' (' . $model->search()->getTotalItemCount() . ')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">' . Yii::t("admin", "Bỏ chọn tất cả") . '</a></li>
        </ul>
    </div>
'; */

$bulkAction = array('' => Yii::t("admin", "Hành động"), 'deleteAll' => Yii::t("admin", "Xóa"), '1' => Yii::t("admin", "Cập nhật"));
if ($this->type == AdminSongModel::WAIT_APPROVED) {
    $bulkAction['approvedAll'] = Yii::t('admin', 'Duyệt');
}
if ($this->type == AdminSongModel::ACTIVE) {
    $bulkAction['export'] = Yii::t('admin', 'Export Excel');
}
if ($this->type == AdminSongModel::DELETED) {
    $bulkAction = array('' => Yii::t("admin", "Hành động"), 'restore' => Yii::t("admin", "Khôi phục"));
}
if ($this->type == AdminSongModel::WAIT_APPROVED
        || $this->type == AdminSongModel::ACTIVE
        || $this->type == AdminSongModel::CONVERT_FAIL) {

    $bulkAction['reconvert'] = Yii::t('admin', 'Set convert lại');
}


$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform'),
        ));

echo '<div class="op-box">';
if ($this->type == AdminSongModel::NOT_CONVERT) {
    echo "<p>&nbsp;</p>";
} else {
    echo CHtml::dropDownList('bulk_action', '', $bulkAction, array('onchange' => 'return song_submit_form(this)')
    );
    echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

    $params = Yii::app()->request->getParam('AdminSongModel', null);
    $params = CJSON::encode($params);

    echo '<div style="display:none">'
    //. CHtml::checkBox("all-item", false, array("value" => $model->search()->getTotalItemCount(), "style" => "width:30px"))
    . CHtml::checkBox("all-item", false, array("value" =>0, "style" => "width:30px"))
    . CHtml::hiddenField("type", $this->type)
    . CHtml::hiddenField("params", $params)
    . '</div>';

    if (Yii::app()->user->hasFlash('Song')) {
        echo '<div class="flash-success">' . Yii::app()->user->getFlash('Song') . '</div>';
    }
}

echo '</div>';
//echo $html_exp;
$extCold1 = array(
    'name' => 'Nghe',
    'value' => 'isset($data->songstatistic->played_count)?$data->songstatistic->played_count:0',
);
$extCold2 = array(
    'name' => 'Down',
    'value' => 'isset($data->songstatistic->downloaded_count)?$data->songstatistic->downloaded_count:0',
);
switch ($this->type) {
    case AdminSongModel::NOT_CONVERT:
        $column = array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'buttons' => array(
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        );

        break;
    case AdminSongModel::WAIT_APPROVED:
        $column = array(
            'class' => 'CButtonColumn',
            'template' => '{approved}',
            'buttons' => array(
                'approved' => array(
                    'label' => 'Duyệt',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/img/approved.png',
                    'url' => 'Yii::app()->createUrl("song/approved", array("id"=>$data->id))',
                ),
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        );
        break;
    case AdminSongModel::DELETED:
        $extCold1 = array(
            'name' => 'Lý do xóa',
            'value' => 'isset($data->songdeleted)?$data->songdeleted->deleted_reason:""',
        );

        $script = <<<EOD
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
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'delete' => array(
                            'click' => $script,
                            'title' => Yii::t('admin', 'Khôi phục'),
                        ),
                    ),
                    'deleteButtonLabel' => Yii::t('admin', 'Khôi phục'),
                    'deleteButtonImageUrl' => Yii::app()->request->baseUrl . "/css/img/revert.png",
                    'deleteButtonUrl' => 'Yii::app()->createUrl("song/restore",array("cid[]"=>$data->id))',
                    'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                        'onchange' => "$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
                    )),
        );
        break;

    default:
        $url = Yii::app()->createUrl("/song/confirmDel");
        $script = <<<EOD
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
        $script1 = "function() {
                            var url = $(this).attr('href');
                            editlyric(url);
                            return false;
			}";
        $column =
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'click' => $script,
                        ),
                    ),
                    'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                        'onchange' => "$.fn.yiiGridView.update('admin-song-model-grid',{ data:{pageSize: $(this).val() }})",
                    )),
        );

        break;

}
$lyric_filter = true;

?>
<script>
    var idf = 'admin-song-model-grid';
    var modelf = 'AdminSongModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
    'id' => 'admin-song-model-grid',
	'afterAjaxUpdate' => 'js:function(){loadCopyright();}',
    'dataProvider' => $model->search($lyric_filter,isset($_GET['AdminSongModel']['genre_id'])?$_GET['AdminSongModel']['genre_id']:null),
		'columns' => $columns = array(
		array(
			'class' => 'CCheckBoxColumn',
			'selectableRows' => 2,
			'checkBoxHtmlOptions' => array('name' => 'cid[]'),
			'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
			'id' => 'cid',
			'checked' => 'false'
		),
		'id',
		array(
			'name' => 'name',
			'value' => 'chtml::link(Formatter::substring(CHtml::encode($data->name)," ",12),Yii::app()->createUrl("song/update",array("id"=>$data->id)))',
			'type' => 'raw',
			'headerHtmlOptions' => array('width' => '130px', 'style' => 'text-align:left'),
			'htmlOptions' => array('width' => '130px', 'style' => 'text-align:left'),
		),
		'code',
		array(
				'name'=>'bitrate',
				'value'=>'"<div id=\"r_$data->id\">".CHtml::tag("span", array("class"=>"s_label s_1","id"=>$data->id), max(explode(",",str_replace(array("1,","2,",3,4,5),array("128,","128,","96","320","96"), $data->profile_ids.","))))."</div>"',
				'type'=>'raw',
				'htmlOptions'=>array('align'=>'center')
		),
		'artist_name',
		 //$orderCol,
		array(
			'name' => 'Ngày tạo',
			'value' => 'date("d/m/Y", strtotime($data->created_time))',
		),
		/* array(
			'name' => 'CP',
			'value' => 'isset($data->cp)?$data->cp->name:""',
		), */
		//$extCold1,
		//$extCold2,

		'cmc_id',
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
<script>
$(document).ready(function() {
	loadCopyright();
})
function loadCopyright(){
	var TQ = [];
	$(".TQ").each(function(){
			var id = $(this).attr("id");
			id = id.replace("TQ_","");
			TQ.push(id);
		});

	if(TQ.length > 0){
	    	jQuery.ajax({
				'url': '<?php echo Yii::app()->createUrl('/song/getCopyright')?>',
				'type':'POST',
				'data':{ids:TQ},
				'dataType':'json',
				'success': function(data){
					Object.keys(data).forEach(function(key) {
					    $("#"+key).html(data[key])
					});

					}
		    })
	}
}
</script>