<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->breadcrumbs = array(
    'Banner Models' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('BannerCreate')),
);
$this->pageLabel = Yii::t("admin", "Danh sách Banner");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
window.reorder = function()
{
   $.post('" . $this->createUrl('banner/reorder') . "',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('banner-model-grid', {
        data: $(this).serialize()
    });
    return false;
});


//$('#banner-model-grid table.items tr th:nth-child(4)').attr('style','width:300px!important;float:left;word-wrap: break-word;');
");
?>

<script>

jQuery(function($) {
    <?php
    if(!empty($_GET['channel']))
        $channel = $_GET['channel'];
    else
        $channel = !empty($_GET['BannerModel']['channel'])?$_GET['BannerModel']['channel']:'';
    if(!empty($channel)):?>
        $('#BannerModel_position option').hide();
        $('#BannerModel_position option.'+'<?php echo $channel?>').show();
    <?php endif;?>
    $('#BannerModel_channel').change(function(){
        var channel = $(this).val();
        $('#BannerModel_position option').hide();
        $('#BannerModel_position option.'+channel).show();
    });
});
</script>
<!-- SEARCH FORM -->
<div class="wide form search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="row">
<?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
    </div>
    <?php /*
    <div class="row">
        <?php echo $form->label($model, 'channel'); ?>
        <?php
        $channel = Yii::app()->params['bannerChannel'];
        $selectedChannel = Yii::app()->request->getParam('channel','');
        if($selectedChannel == ''){
            $selectedChannel = Yii::app()->request->getParam('BannerModel');
            $selectedChannel = $selectedChannel['channel'];
        }
        echo CHtml::dropDownList("BannerModel[channel]", $selectedChannel, $channel)
        ?>
    </div>
    */?>
    <div class="row">
        <?php echo $form->label($model, 'Position'); ?>
        <?php
        $position = Yii::app()->params['position'];
        ?>
        <select id="BannerModel_position" name="BannerModel[position]" style="width:300px">
            <?php
            foreach($position as $channel => $arr){
                foreach($arr as $key => $val){
                    echo "<option class='$channel' value='$key'>$val</option>";
                }
            }
            ?>
        </select>
    </div>
	<div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php
            $status = array(
                AdminBannerModel::ACTIVE => "Hoạt động",
                AdminBannerModel::INACTIVE => "Không hoạt động",
            );
            echo CHtml::dropDownList("BannerModel[status]", $model->status, $status, array('prompt'=>'Tất cả'))
            ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    <div class="row buttons">
<?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->


<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform',),
        ));
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action', '', array('' => Yii::t("admin", "Hành động"), 'deleteAll' => 'Delete', '1' => 'Update'), array('onchange' => 'return submitform(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">' . CHtml::checkBox("all-item", false, array("value" => $model->count(), "style" => "width:30px")) . '</div>';
echo '</div>';

if (Yii::app()->user->hasFlash('Banner')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('Banner') . '</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'banner-model-grid',
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
        'id',
        'name',
        array(
            'name' => 'banner',
            'value' => array($this,'genBanner'),
            'type' => 'raw'
        ),
        array(
            'name' => 'url',
            'value' => array($this,'genUrl'),
            'type' => 'raw'
        ),
        'channel',
        array(
            'header' => 'Sắp xếp' . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("onclick" => "reorder()")),
            'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
        ),
        array(
            'class' => 'CLinkColumn',
            'header' => 'Hiển thị',
            'labelExpression' => '($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data->status==1)?Yii::app()->createUrl("banner/unpublish",array("cid[]"=>$data->id)):Yii::app()->createUrl("banner/publish",array("cid[]"=>$data->id))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'name' => 'rate',
            'header' => 'Tỷ Lệ Hiển thị',
//            'value' => 'rate',
            'type' => 'raw'
        ),
		'position',
        array(
            'class' => 'CButtonColumn',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('banner-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
$this->endWidget();
?>
