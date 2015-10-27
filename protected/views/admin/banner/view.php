<?php
$this->breadcrumbs = array(
    'Banner Models' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('index'), 'visible' => UserAccess::checkAccess('BannerIndex')),
    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create')),
    array('label' => Yii::t('admin', 'Cập nhật'), 'url' => array('update', 'id' => $model->id), 'visible' => UserAccess::checkAccess('BannerUpdate')),
    array('label' => Yii::t('admin', 'Xóa'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?'), 'visible' => UserAccess::checkAccess('BannerDelete')),
    array('label' => Yii::t('admin', 'Sao chép'), 'url' => array('copy', 'id' => $model->id), 'visible' => UserAccess::checkAccess('BannerCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Banner") . "#" . $model->id;
?>

<div class="content-body">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name',
            'url',
            'start_time',
            'expired_time',
            'image_file',
            'position',
            'type',
            'channel',
            'log_click',
            'rate',
            'status',
            'width',
            'height'
        ),
    ));
    ?>
</div>
