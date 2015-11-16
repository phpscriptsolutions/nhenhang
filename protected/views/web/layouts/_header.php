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
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery.js");
$cs->registerCoreScript('jquery.ui');
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery.mousewheel.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery.jscrollpane.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/bootstrap.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/hashids.min.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/_common.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/main.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/fb.js");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/js/facebook_box.js");

$userId = 0;
if (!Yii::app()->user->isGuest){
    $userId = Yii::app()->user->Id;
}

$controller = Yii::app()->controller;
$action = $this->action->id;
$categories = CategoryModel::model()->findAll();
?>
<div id="header">
    <nav id="nav-first" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a title="Truyện Kiếm Hiệp, Ngôn Tình, Sắc Hiệp, Tiên Hiệp, Trinh Thám, Truyện Online, Truyện hay , Truyện Mới nhất" alt="Truyện Kiếm Hiệp, Ngôn Tình, Sắc Hiệp, Tiên Hiệp, Trinh Thám, Truyện Online, Truyện Hay Nhất, Truyện Mới nhất, Wap Truyện, Đọc truyện trên Mobile" class="navbar-brand" href="<?php echo Yii::app()->getBaseUrl(true);?>">Nhenhang.com</a>
                <h1 style="text-indent: -9999px; display: none;"><a href="<?php echo Yii::app()->getBaseUrl(true);?>">Truyện Kiếm Hiệp, Ngôn Tình, Sắc Hiệp, Tiên Hiệp, Trinh Thám, Truyện Online, Truyện Hay Nhất, Truyện Mới nhất, Wap Truyện, Đọc truyện trên Mobile</a> </h1>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" aria-expanded="true">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-hot',
                            'hot' => true
                        ))?>">Truyện HOT</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-full',
                            'hot' => false,
                        ))?>">Truyện FULL</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-moi',
                            'hot' => false,
                            's'=>'Đang ra'
                        ))?>">Truyện mới cập nhật</a></li>
                    <li><a href="javascript:void(0);">|</a></li>
                    <li class="li-social">
                        <a href="javascript:void(0);">
                        <?php $this->widget("application.widgets.web.common.FBLike", array(
                            "url" => Yii::app()->getBaseUrl(true),
                        ));?>
                        </a>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" method="get" role="search" action="<?php echo Yii::app()->createUrl('home/search')?>">
                    <div class="form-group">
                        <input type="text" name="q" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Tìm kiếm</button>
                </form>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <nav id="nav-second" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="true">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Yii::app()->getBaseUrl(true);?>">Danh Mục</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2" aria-expanded="true">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'ngon-tinh',
                        ))?>">Ngôn Tình</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'kiem-hiep',
                        ))?>">Kiếm Hiệp</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'tien-hiep',
                        ))?>">Tiên Hiệp</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'xuyen-khong',
                        ))?>">Xuyên Không</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'do-thi',
                        ))?>">Đô Thị</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'vong-du',
                        ))?>">Võng Du</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'huyen-huyen',
                        ))?>">Huyền Huyễn</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'truyen-teen',
                        ))?>">Truyện Teen</a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                            'category'=>'di-gioi',
                        ))?>">Dị Giới</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Truyện Khác <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'lich-su',
                                ))?>">Lịch Sử</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'trong-sinh',
                                ))?>">Trọng Sinh</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'trinh-tham',
                                ))?>">Trinh Thám</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'khoa-huyen',
                                ))?>">Khoa Huyền</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'di-nang',
                                ))?>">Dị Năng</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'quan-su',
                                ))?>">Quân Sự</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'tham-hiem',
                                ))?>">Thám Hiểm</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'linh-di',
                                ))?>">Linh Dị</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'sac',
                                ))?>">Sắc</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'cung-dau',
                                ))?>">Cung Đấu</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'nu-cuong',
                                ))?>">Nữ Cường</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'gia-dau',
                                ))?>">Gia Đấu</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'dong-phuong',
                                ))?>">Đông Phương</a></li>

                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'dam-my',
                                ))?>">Đam Mỹ</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'bach-hop',
                                ))?>">Bách Hợp</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'hai-huoc',
                                ))?>">Hài Hước</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'dien-van',
                                ))?>">Điền Văn</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'co-dai',
                                ))?>">Cổ Đại</a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('home/category',array(
                                    'category'=>'mat-the',
                                ))?>">Mạt Thế</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>