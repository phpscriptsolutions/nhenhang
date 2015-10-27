<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->menu = array(
    array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('index')),
    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create')),
    array('label' => Yii::t('admin', 'Cập nhật'), 'url' => array('update', 'id' => $mainmodel->id)),        
);


$id = Yii::app()->request->getParam('suggest');
if($id == "1"){
    $header = 'Nhạc miền tây';    
}
elseif($id == "2"){
    $header = 'Nhạc quốc tế';    
}
$suggest = "";
if(!empty($id))
    $suggest = "suggest_$id";

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-collection-modell-grid',
    'dataProvider' => $model,
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
        array(
            'name' => 'name',
            'value' => 'chtml::link(Formatter::substring($data->name," ",12),Yii::app()->createUrl("song/update",array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        'code',
        'artist_name',
        $arr,
    ),
));
?>
