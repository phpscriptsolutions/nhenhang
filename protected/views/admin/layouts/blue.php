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



        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>

        <script type="text/javascript" src="<?php echo Yii::app()->createUrl("admin/loadLang") ?>"></script>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js"); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/stuHover.js"></script>
        <script type="text/javascript">
            $(document.body).ready(function(){
                $(window).scroll(function(){
                    if($('#right').offset().top < $(window).scrollTop()){
                        $('.xfixed').each(function(){
                            var x = $(this);
                            var w = x.width();
                            x.css({'position':'fixed','top':'0px','z-index':'999','width':w+"px",'margin-top':'0px'}).prev().css('height',x.height()+"px");
                        });
                    }else{
                        $('.xfixed').each(function(){
                            $(this).css({'position':'static','margin-top':'8px'}).prev().css('height',"0px");;
                        })
                    }
                });
            });
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
                    <h1><a href="<?php echo Yii::app()->request->baseUrl ?>/" title="chacha-admin"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/head_chacha_logo.png" alt="Chacha CMS" /></a></h1>
                </div>
                <!-- end logo -->
                <!-- user -->
                <ul id="user">
                    <?php if (!isset($this->module->id)): ?>
                        <li>
                            <?php echo Yii::t('admin', 'Chào'); ?>: <b><?php echo $this->username ?></b>
                        </li>
                    <?php endif; ?>

                    <li class="first"><a href="<?php echo Yii::app()->createUrl('adminUser/profile'); ?>"><?php echo Yii::t("admin", "Account") ?></a></li>
                    <li><a href="<?php echo $this->createUrl('admin/logout') ?>"><?php echo Yii::t("admin", "Logout") ?></a></li>
                    <li class="last highlight"><a href="http://mobiclip.vn/amusic" target="_blank"><?php echo Yii::t("admin", "View Site") ?></a></li>
                </ul>
                <!-- end user -->
                <div id="header-inner">
                    <div id="home">
                        <a href="<?php echo Yii::app()->request->baseUrl ?>/"></a>
                    </div>

                    <?php
                    $this->widget('application.widgets.admin.Slidebar', array(
                        'module' => isset($this->module) ? $this->module->id : 0,
                        'controller' => $this->getId(),
                        'action' => $this->action->id,
                        'type' => "menu",
                    ));
                    /*
                      $menuContent =   include ('menu.php') ;
                      $this->widget(
                      'application.widgets.VMenu', array(
                      'items'=> $menuContent,
                      'htmlOptions'=>array('id'=>'quick'),
                      ));
                     */
                    ?>

                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                </div>
            </div>
        </div>
        <!-- end header -->
        <!-- content -->
        <div id="content">
            <div id="left">
                <div id="menu">
                    <?php if (!isset($this->module->id)): ?>
                    <h6 id="h-menu-products" class="selected">
                        <?php echo CHtml::link(Yii::t('admin', "<span>" . ucfirst($this->getId()) . "</span>"), Yii::app()->createUrl($this->getId() . "/index")); ?>
                    </h6>
                    <?php else:
                        $module = $this->module->id;
                        $controller= $this->getId();
                        $action= $this->getId();
                        $link = Yii::app()->createUrl("/{$module}/{$controller}/index");
                        ?>
                    <h6 id="h-menu-products" class="selected">
                        <a href="<?php echo $link;?>"><span><?php echo ucfirst($this->getId());?></span></a>
                    </h6>
                    <?php endif;?>
                        <?php
                        $this->beginWidget('zii.widgets.CPortlet', array(
                        ));

                        $this->widget('application.widgets.admin.Slidebar', array(
                            'module' => isset($this->module->id) ? $this->module->id : "",
                            'controller' => $this->getId(),
                            'action' => $this->action->id,
                            'type' => "slidebar",
                        ));
                        /*
                          if (!empty($this->slidebar)) {
                          $this->widget('zii.widgets.CMenu', array(
                          'items'=>$this->slidebar,
                          'htmlOptions'=>array('class'=>'operations'),
                          ));
                          }
                         */
                        $this->endWidget();
                        ?>
                </div>
            </div>
                    <?php
                    if ($this->route == "rbtDownload/report")
                        echo "<style>#yw4 li:nth-child(1){display:none;}</style>";
                    ?>
            <div id="right">
            <?php if (!isset($this->module->id) || $this->module->id == 'spam'|| $this->module->id == 'contest'|| $this->module->id == 'event'): ?>
                    <div class="submenu title-box xfixed">
                    <?php
                    $this->beginWidget('zii.widgets.CPortlet', array(
                    ));
                    echo "<div class='page-title'>" . CHtml::encode($this->pageLabel) . "</div>";
                    if (!empty($this->menu)) {
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => $this->menu,
                            'htmlOptions' => array('class' => 'operations'),
                        ));
                    }
                    $this->endWidget();
                    ?>
                    </div>
                    <?php endif; ?>

                <?php echo $content; ?>
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