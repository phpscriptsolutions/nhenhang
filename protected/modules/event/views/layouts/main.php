<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/normal_phone.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/noel_style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/8_3_2014/css/style.css" />
        <?php include(dirname(Yii::app()->getViewPath() ). DIRECTORY_SEPARATOR . 'meta_tag.php'); ?>
    </head>
    <?php 
// /include(Yii::app()->getViewPath() . DIRECTORY_SEPARATOR . 'body.php');
    Yii::app()->controller->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR .'modules/event/views/layouts/body.php',
            array('cId'=>$cId,
                'actionId' => $actionId,
                'content' => $content,
                'layout' => 'normal'
                )
            );
    ?>
</html>