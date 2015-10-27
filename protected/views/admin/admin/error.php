<?php $this->layout=false;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="vi" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style_fixed.css" />
        <link id="color" rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style_mobiclip.css" />
        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>

        <script type="text/javascript" src="<?php echo Yii::app()->createUrl("admin/loadLang") ?>"></script>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js"); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/stuHover.js"></script>

        <script type="text/javascript">
        <?php if(strrpos( $_SERVER['HTTP_USER_AGENT'],"Chrome") === false):?>
            $(document.body).ready(function(){
                $(window).scroll(function(){
                    if($('#header-outer').offset().top < $(window).scrollTop()){
                        $('#header-inner').each(function(){
                            var x = $(this);
                            var w = x.width();
                            x.css({'position':'fixed','top':'0px','z-index':'999','width':w+"px",'margin-top':'0px'}).prev().css('height',x.height()+"px");
                            $('#submenu-scroll').html($(".menu-toolbar").html());
                        });
                    }else{
                        $('#header-inner').each(function(){
                            /* $(this).css({'position':'static','margin-top':'0px'}).prev().css('height',"0px"); */
                        	$(this).css({'position':'relative','margin-top':'0px'});
                            $('#submenu-scroll').html("");
                        })
                    }
                });
            });
            <?php endif;?>
            var songUrlUpdate = '<?php echo Yii::app()->createUrl("/song/massUpdate") ?>';
            var songUrlDelete = '<?php echo Yii::app()->createUrl("/song/confirmDel") ?>';

            var videoUrlUpdate = '<?php echo Yii::app()->createUrl("/video/massUpdate") ?>';
            var videoUrlDelete = '<?php echo Yii::app()->createUrl("/video/confirmDel") ?>';

            var albumUrlUpdate = '<?php echo Yii::app()->createUrl("/album/massUpdate") ?>';
            var albumUrlDelete = '<?php echo Yii::app()->createUrl("/album/confirmDel") ?>';

            var ringtoneUrlUpdate = '<?php echo Yii::app()->createUrl("/ringtone/massUpdate") ?>';
            var ringtoneUrlDelete = '<?php echo Yii::app()->createUrl("/ringtone/confirmDel") ?>';


        </script>

    </head>

    <body>
        <!-- header -->
        <div id="header">
            <div id="header-outer">
                <!-- logo -->
                <div id="logo">
                    <h1><a href="<?php echo Yii::app()->request->baseUrl ?>/" title="admin"><img alt="Admin" src="<?php echo Yii::app()->request->baseUrl ?>/images/logo.png" /></a></h1>
                </div>
                <!-- end logo -->
                <!-- user -->
                <?php if (!Yii::app()->user->isGuest): ?>
                <ul id="user">
                        <li>
                            <?php echo Yii::t('admin', 'Chào'); ?>: <b><?php echo Yii::app()->user->username ?></b>
                        </li>

                    <li class="first"><a href="<?php echo Yii::app()->createUrl('adminUser/profile'); ?>"><?php echo Yii::t("admin", "Account") ?></a></li>
                    <li><a href="<?php echo Yii::app()->createUrl('/admin/logout') ?>"><?php echo Yii::t("admin", "Logout") ?></a></li>
                    <li class="last highlight"><a href="/" target="_blank"><?php echo Yii::t("admin", "View Site") ?></a></li>
                </ul>
                <?php endif;?>
                <!-- end user -->
                <div id="header-inner">
                    <div id="home">
                        <a href="<?php echo Yii::app()->request->baseUrl ?>/"></a>
                    </div>

                    <?php
                    $path = Yii::getPathOfAlias("application.views.admin.layouts.");
					$menu = include_once $path.'/_menu.php';
					$this->widget('application.widgets.admin.menu.SMenu',
							array(
									"menu"=>$menu,
									"stylesheet"=>"menu_blue.css",
									"menuID"=>"myMenu",
									"delay"=>3
							)
					);
                    ?>
                    <ul id="submenu-scroll">
                    </ul>
                </div>
            </div>
        </div>
        <!-- end header -->
        <!-- content -->
        <div id="content">
            <div id="left">
                <div id="menu">
                </div>
            </div>
            <div id="right">
            <div class="adminform pt30">
			<?php
			echo "Lỗi: ".$errCode;
			echo '<div>'.CHtml::encode($errorMsg).'</div>';
			if(YII_DEBUG){
				echo "<pre>";print_r(Yii::app()->errorHandler->error);echo "<pre>";
			}
			?>
			</div>
            </div>
        </div>
        <div id="footer">
            <p>Copyright &copy; 2011 <a href="http://vega.com.vn/">Vega Corporation</a> . All Rights Reserved.</p>
        </div>
        <div id="jobDialog"></div>
        <div id="loading"></div>

        <div class="box" id="box">
			<img id="stop" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/stop.png" />
		</div>
		<div class="overlay" id="overlay" style="display:none;"></div>
    </body>
</html>
