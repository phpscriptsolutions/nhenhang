<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="<?php echo Yii::app()->language?>" />
    <meta name="robots" content="follow, index" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php Yii::app()->SEO->renderMeta();?>
    <link href="/web/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <!--[if IE]>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/web/css/style-ie.css" type="text/css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/web/css/pie.css" type="text/css" rel="stylesheet">
    <![endif]-->
</head>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/bootstrap.min.css?v=".time());
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/css/style.css?v=".time());
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery.mousewheel.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery.jscrollpane.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/hashids.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_common.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/main.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/fb.js");

$userId = 0;
if (!Yii::app()->user->isGuest){
    $userId = Yii::app()->user->Id;
}

$controller = Yii::app()->controller;
$action = $this->action->id;
$categories = CategoryModel::model()->findAll();
?>
<div id="header">
    <header>
        <div class="logo">
            <a href="<?php echo Yii::app()->getBaseUrl(true);?>"><h1>Nhenhang.com</h1></a>
        </div>
        <ul class="menu">
            <li class="menu-li">
                <a href="#"><h2>Danh sách</h2></a>
                <ul class="sub-menu">
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-moi',
                            'hot' => false,
                            's'=>'Đang ra'
                        ))?>"><h3>Truyện mới cập nhật</h3></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-hot',
                            'hot' => true
                        ))?>"><h3>Truyện HOT</h3></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-full',
                            'hot' => false,
                        ))?>"><h3>Truyện FULL</h3></a></li>
                </ul>
            </li>
            <li class="menu-li">
                <a href="#"><h2>Thể loại</h2></a>
                <ul class="sub-menu">
                    <?php foreach($categories as $category):?>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>$category->category_slug,
                            'hot' => false,
                        ))?>"><h3><?php echo $category->category_name;?></h3></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
            <li class="menu-li">|</li>
            <li class="menu-li li-social">
                <div class="gg-social">Google+</div>
                <div class="fb-social">Facebook</div>
            </li>
        </ul>
        <ul class="menu-search">
            <form action="" method="">
                <li class="li-text">
                    <input type="text" name="ten-truyen" placeholder="Tìm kiếm truyện" size="40"/>
                </li>
                <li class="li-submit">
                    <button type="submit" name="tim-kiem">Tìm</button>
                </li>
            </form>
        </ul>
    </header>

    <!-- menu-category-->
    <div class="menu-category">
        <ul>
            <li><a href=""><h3>Truyện Ngôn tình</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Kiếm Hiệp</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Tiên Hiệp</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Võng Du</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Trinh Thám</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Kinh Dị</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Ma</h3></a></li>
            <li>|</li>
            <li><a href=""><h3>Truyện Teen</h3></a></li>
        </ul>
    </div>
</div>
