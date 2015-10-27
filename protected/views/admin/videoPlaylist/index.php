<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");

$this->menu = array(
    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create'), 'visible' => UserAccess::checkAccess('VideoPlaylistCreate')),
);

$orderCol = array(
    'header' => Yii::t('admin', 'Sắp xếp'),
    'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"disabled"=>"disabled"))',
    'type' => 'raw',
    'htmlOptions' => array('width' => 50, 'align' => 'center')
);

switch ($this->type) {
    case AdminVideoPlaylistModel::ALL:
        $title = "Danh sách video playlist - Tất cả";
        break;
    case AdminVideoPlaylistModel::WAIT_APPROVED:
        $title = "Danh sách video playlist - Chờ duyệt";
        break;
    case AdminVideoPlaylistModel::ACTIVE:
        $title = "Danh sách video playlist - Đã duyệt";
        $orderCol = array(
            'header' => Yii::t('admin', 'Sắp xếp') . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("class" => "reorder", "rel" => $this->createUrl('videoPlaylist/reorder'))),
            'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
            'htmlOptions' => array('width' => 50, 'align' => 'center')
        );
        break;
    case AdminVideoPlaylistModel::DELETED:
        $title = "Danh sách video playlist - đã xóa";
        break;
}
$this->pageLabel = Yii::t('admin', $title);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(Yii::t('admin', 'Tìm kiếm'), '#', array('class' => 'search-button')); ?></div>

<div class="search-form" style="display:block">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
        'categoryList' => $categoryList,
        'cpList' => $cpList,
        'description' => $description
    ));
    ?>
</div><!-- search-form -->

<?php
//$html_exp = '
//    <div id="expand">
//        <p id="show-exp">&nbsp;&nbsp;</p>
//        <ul id="mn-expand" style="display:none">
//            <li><a href="javascript:void(0)" class="item-in-page">' . Yii::t("admin", "Chọn trang này") . '(' . $model->search()->getItemCount() . ')</a></li>
//            <li><a href="javascript:void(0)" class="all-item">' . Yii::t("admin", "Chọn tất cả") . ' (' . $model->search()->getTotalItemCount() . ')</a></li>
//            <li><a href="javascript:void(0)" class="uncheck-all">' . Yii::t("admin", "Bỏ chọn tất cả") . '</a></li>
//        </ul>
//    </div>
//';

$bulkAction = array('' => Yii::t("admin", "Hành động"), 'deleteAll' => Yii::t("admin", "Xóa"));

if ($model->search()->getItemCount() == 0) {
    $padding = "padding:26px 0";
} else {
    $padding = "";
}
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform', 'style' => $padding),
        ));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action', '', $bulkAction, array('onchange' => 'return submitform(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">'
 . CHtml::checkBox("all-item", false, array("value" => $model->search()->getTotalItemCount(), "style" => "width:30px"))
 . CHtml::hiddenField("type", $this->type)
 . '</div>';

if (Yii::app()->user->hasFlash('VideoPlaylist')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('VideoPlaylist') . '</div>';
}
echo '</div>';

?>
<script>
    var idf = 'admin-video-playlist-model-grid';
    var modelf = 'AdminVideoPlaylistModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
    'id' => 'admin-video-playlist-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('name' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
        array(
            'name' => 'id',
            'value' => 'chtml::link($data->id,Yii::app()->createUrl("videoPlaylist/update",array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        array(
            'name' => 'name',
            'value' => 'chtml::link(CHtml::encode($data->name),Yii::app()->createUrl("videoPlaylist/update",array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        array(
            'header' => 'Category',
            'value' => '(isset($data->genre->name))?$data->genre->name:""',
        ),
        array(
            'header' => 'Artist',
            'name' => 'artist_name',
        ),
        'video_count',
        array(
            'header' => 'Lượt nghe',
            'value' => 'isset($data->played_count)?$data->played_count:0',
        ),
        array(
            'header' => 'Ngày tạo',
            'name' => 'created_time'
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'New',
            'labelExpression' => '($data->new_release==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data->new_release==1)?Yii::app()->createUrl("videoPlaylist/unnew",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoPlaylist/new",array("cid[]"=>$data->id))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'Độc quyền',
            'labelExpression' => '($data->exclusive==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data->exclusive==1)?Yii::app()->createUrl("videoPlaylist/unexclusive",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoPlaylist/exclusive",array("cid[]"=>$data->id))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('admin', 'View'),
            'template' => '{view}{update}{delete}{list}',
            'htmlOptions'=>array('style'=>'width: 70px; text-align: center;'),
            'buttons' => array(
                'list' => array(
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/img/list.gif',
                    'url' => 'Yii::app()->controller->createUrl("videolist",array("id"=>$data->id))',
                ),
            ),
        ),
        array(
            'header' => 'S',
            'value' => '"<span class=\"s_label s_$data->status\">$data->status</span>"',
            'type' => 'raw'
        ),
    ),
));
$this->endWidget();
?>
