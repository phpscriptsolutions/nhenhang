<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="vi" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/login.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery');   ?>

    </head>

    <body>
        <div id="page" class="container">
            <div class="wrapper">
            	<div id="slg">
            		<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/text.png" alt="Chacha Admin" width="300" /></a>
            	</div>
            	<div id="login">
            	    <?php echo $content; ?>
            	</div>
            </div>
        </div>
    </body>
</html>