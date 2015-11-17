<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getbaseUrl(true)."/web/css/bootstrap.min.css?v=".time()?>">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getbaseUrl(true)."/web/css/style.css?v=".time()?>">

<?php
$this->widget('application.widgets.web.ads.AdsWidget',
    array(
        'data'=>$ads,
    ));
?>