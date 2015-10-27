<?php $this->beginContent('application.views.touch.layouts._header'); ?>
<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<div id="wrr-page">
    <section class="cpage">
        <div class='container'>
            <header>
            	<div class="wrr-header">
                    <span class="ih1"></span>
                    <span class="ih2"></span>
                    <a href='<?php echo Yii::app()->getBaseUrl(true) ?>' class='haslogo'><h1 class='logo-project'></h1></a>
                    <div class="menu-action">
                        <a href='javascript:void(0);' class='icon-menu search-n active left'></a>
                        <?php if(!Yii::app()->user->isGuest):?>
                            <a href='<?php echo Yii::app()->createUrl('/user/profile',array('u'=>Yii::app()->user->getState('username')));?>' class='icon-menu menu-u left'></a>
                        <?php else:?>
                            <?php $back = Yii::app()->createUrl('/user/profile');?>
                            <a href='<?php echo Yii::app()->createUrl('/account/login',array('back'=>urlencode($back)));?>' class='icon-menu menu-u left'></a>
                        <?php endif;?>
                        <a href='javascript:void(0);' class='icon-menu menu-n left'></a>
                    </div>
                </div>
            </header>
            <div class="form-search hide">
                <form id="frm-search" action='<?php echo Yii::app()->createUrl('/search/index'); ?>' method='get' class='' onsubmit="return checkInput();">
                    <input type='text' name="q" id="txt-content"  placeholder="<?php echo Yii::t("wap","Từ khóa tìm kiếm");?>"/>
                </form>
            </div>

            <nav>
                <ul>
                    <li>
                        <a class=' <?php if ($controller == 'album'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/album') ?>' ><?php echo Yii::t("wap","Album");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'video'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/video') ?>' ><?php echo Yii::t("wap","Video");?></a>
                    </li>
                    <li>
                        <a class='<?php if ($controller == 'hotlist'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/hotlist') ?>'><?php echo Yii::t("wap","Hot List");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'chart'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/chart') ?>' ><?php echo Yii::t("wap","Charts");?></a>
                    </li>
                    <li>
                        <a class=' <?php if ($controller == 'artist'): ?> active<?php endif; ?>' href='<?php echo Yii::app()->createUrl('/artist') ?>' ><?php echo Yii::t("wap","Nghệ sĩ");?></a>
                    </li>
                </ul>
            </nav>
            <?php include '_google_ads.php'; ?>
            <div id="adv10" class="vg_ads">
                <?php
                $arr = array();
                $rate = array();
                foreach ($this->banners as $banner) {
                    if ($banner['position'] == 10) {
                        $arr[] = $banner;
                        $ra = $banner['rate'] ? $banner['rate'] : 1;
                        $ra = (int) $ra;
                        for ($i = 0; $i < $ra; $i++) {
                            $rate[] = $banner;
                        }
                    }
                }
                shuffle($rate);
                $item = rand(0, count($rate) - 1);
                if (isset($rate[$item]) && $rate[$item]) {
                    $ban = $rate[$item];
                    echo $ban['content'];
                }
                ?>
            </div>
            <div class="vg_contentBody">
                <?php echo $content; ?>
                <div id="fuccload" class="load-more-page" style="display: none"><img src="/touch/images/ajax_loading.gif" /></div>
            </div>
        </div><!-- End .container-->
    </section><!-- End .cpage-->
    <?php include_once '_menu_side.php'; ?>
    <?php include_once '_remarketing.php'; ?>

</div>
<?php $this->endContent(); ?>
<script>
    $(function() {
        $("form input#txt-content").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                document.form.submit();
            } else {
                return true;
            }
        });
    });
</script>

