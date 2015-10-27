<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="vi" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/dropmenu.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery');   ?>
        <script type="text/javascript" src="<?php echo Yii::app()->createUrl("admin/loadLang") ?>"></script>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js?v=1.1"); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/stuHover.js"></script>
        <script type="text/javascript">
            $(document.body).ready(function(){
                $(window).scroll(function(){
                    if($('#marker').offset().top < $(window).scrollTop()){
                        $('.xfixed').each(function(){
                            var x = $(this);
                            var w = x.width();
                            x.css({'position':'fixed','top':'0px','width':w+"px",'margin-top':'0px'}).prev().css('height',x.height()+"px");
                        });
                    }else{
                        $('.xfixed').each(function(){
                            $(this).css({'position':'static','margin-top':'8px'}).prev().css('height',"0px");;
                        })
                    }
                });
            });
            var songUrlUpdate = '<?php echo Yii::app()->createUrl("/song/massUpdate")?>';
            var songUrlDelete = '<?php echo Yii::app()->createUrl("/song/confirmDel")?>';

            var videoUrlUpdate = '<?php echo Yii::app()->createUrl("/video/massUpdate")?>';
            var videoUrlDelete = '<?php echo Yii::app()->createUrl("/video/confirmDel")?>';

            var albumUrlUpdate = '<?php echo Yii::app()->createUrl("/album/massUpdate")?>';
            var albumUrlDelete = '<?php echo Yii::app()->createUrl("/album/confirmDel")?>';


        </script>

    </head>

    <body>
        <div id="top">
            <div class="wrapper">
                <div id="title"><img alt="Admin" src="<?php echo Yii::app()->request->baseUrl ?>/images/logo.png" /></div>
                <!-- Top navigation -->
                <div id="topnav">
                <?php if(!isset($this->module->id)): ?>
				<?php echo Yii::t('admin','Chào'); ?>: <b><?php echo Yii::app()->user->username?></b>
                    <span>|</span> <a href="<?php echo Yii::app()->createUrl('/admin/logout')?>">Logout</a><br />
                    <a href="<?php echo Yii::app()->createUrl('adminUser/profile'); ?>"><?php echo Yii::t('admin','Setting'); ?></a>
                <?php endif;?>
                </div>
                <!-- End of Top navigation -->

                <!-- Main navigation -->
                <div id="menu">
                </div>
                <!-- End of Main navigation -->
            </div>
        </div>
        <div id="pagetitle">
            <div class="wrapper">
                    <?php
                    $menuContent =   include ('menu.php') ;
                    $this->widget(
                      'application.widgets.VMenu', array(
                        'items'=> $menuContent,
                        'htmlOptions'=>array('id'=>'nav'),
                    ));



                    ?>
            </div>
        </div>

        <div id="page" class="container">
            <div class="wrapper">

                <div class="column-left fl" id="marker">
                    <div></div><div class="content-box xfixed">
                        <div class="title-box"><?php echo CHtml::link(ucfirst(Yii::t('admin',$this->getId())), Yii::app()->createUrl($this->getId()."/index"));?></div>
                        <?php
                        $this->beginWidget('zii.widgets.CPortlet', array(
                        ));
                        if (!empty($this->slidebar)) {
                            $this->widget('zii.widgets.CMenu', array(
                                                'items'=>$this->slidebar,
                                                'htmlOptions'=>array('class'=>'operations'),
                            ));
                        }
                        $this->endWidget();
                        ?>
               
                    </div>
                </div>

                <div class="column-right fr">
                    <div></div><div class="submenu box xfixed">
                        <?php
                        if(!isset($this->module->id)):
                        $this->beginWidget('zii.widgets.CPortlet', array(
                        ));
                        echo  "<div class='page-title'>".CHtml::encode($this->pageLabel)."</div>";
                        if (!empty($this->menu)) {
                            $this->widget('zii.widgets.CMenu', array(
                                                'items'=>$this->menu,
                                                'htmlOptions'=>array('class'=>'operations'),
                            ));
                        }
                        $this->endWidget();
                        endif;
                        ?>

                    </div>
                    <?php echo $content; ?>
                </div>

            </div>
        </div>
        <div id="jobDialog"></div>
    </body>
</html>