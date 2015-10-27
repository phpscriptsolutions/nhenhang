<aside class='menu-list hidden'>
    <div class="menu-right">
        <?php if(!Yii::app()->user->isGuest):?>
        <style>
            .avatar-menu{
                background: url('<?php echo AvatarHelper::getAvatar("user", Yii::app()->user->getId(), 's3', strtotime(Yii::app()->user->getState('updated_time')));?>') no-repeat;
                background-size:100%;
                border-radius: 100%;
                -webkit-border-radius:100%;
                -moz-border-radius:100%;
                -o-border-radius:100%;
            }
        </style>
        <div class='m-title clearfix' style="background: url('<?php echo AvatarHelper::getAvatar("user",Yii::app()->user->getId(),'cover',strtotime(Yii::app()->user->getState('updated_time')),'resize','400x117');?>') no-repeat;background-size:cover;">
            <a href="<?php echo Yii::app()->createUrl('/user/profile', array('u'=>Yii::app()->user->getState('username')))?>">
            <div class="avatar-menu"></div>
            </a>
            <div class="menu-username">
                    <?php
                    $linkU = Yii::app()->createUrl('/user/profile', array('u'=>Yii::app()->user->getState('username')));
                    echo Yii::t('wap','<b><a href="'.$linkU.'">').Yii::app()->user->getState('fullname').'</a></b>';?>
            </div>
        </div>
        <?php endif;?>
        <?php if (Yii::app()->user->isGuest):?>
            <div class="m-login-register">
                <a class="btn btn-white" href='<?php echo Yii::app()->createUrl('/account/create')?>'><?php echo Yii::t("wap","Đăng ký");?></a>
                <?php
                if(preg_match('/account\/login/',Yii::app()->request->url) || preg_match('/account\/create/',Yii::app()->request->url)){
                    $backLink = Yii::app()->getBaseUrl(true);
                }else{
                    $backLink = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
                }
                Yii::app()->user->setState('backLink',$backLink);
                ?>
                <a class="btn btn-white" href='<?php echo Yii::app()->createUrl('/account/login?back='.urlencode($backLink))?>'><?php echo Yii::t("wap","Đăng nhập");?></a>
            </div>

        <?php else:?>
            <p class='m-label'>
                <?php echo Yii::t("wap","Cá nhân");?>
            </p>
            <ul>
                <li class="<?php if($controller=='account' && $action == 'myplaylist') echo 'active'?> hover-my-playlist">
                    <a href='<?php echo Yii::app()->createUrl('/account/myplaylist',array('u'=>Yii::app()->user->getState('username')))?>' class='clearfix'>
                        <span class='ic my-playlist'></span>
                        <span class='text'><?php echo Yii::t("wap","Nhạc của tôi");?></span>
                    </a>
                </li>
                <li class="<?php if($controller=='user' && $action == 'recent') echo 'active'?> hover-my-playlist">
                    <a href='<?php echo Yii::app()->createUrl('/user/recent',array('u'=>Yii::app()->user->getState('username')))?>' class='clearfix'>
                        <span class='ic my-recent'></span>
                        <span class='text'><?php echo Yii::t("wap","Nghe gần đây");?></span>
                    </a>
                </li>
                <li class="<?php if($controller=='account' && $action=='view') echo 'active'?> hover-my-profile">
                    <a href='<?php echo Yii::app()->createUrl('/account/view',array('title'=>Common::makeFriendlyUrl(Yii::app()->user->getState('username'))))?>' class='clearfix'>
                        <span class='ic my-profile'></span>
                        <span class='text'><?php echo Yii::t("wap","Thông tin cá nhân");?></span>
                    </a>
                </li>

                <li class="<?php if($controller=='account' && $action=='logout') echo 'active'?> hover-logout">
                    <a href='<?php echo Yii::app()->createUrl('/account/logout')?>' class='clearfix'>
                        <span class='ic logout'></span>
                        <span class='text'><?php echo Yii::t("wap","Đăng xuất");?></span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        <p class='m-label'>
            <?php echo Yii::t("wap","Nhạc trực tuyến");?>
        </p>

        <ul>
            <li class="<?php if($controller=='hotlist') echo 'active'?> hover-hotlist">
                <a href='<?php echo Yii::app()->createUrl('/hotlist')?>' class='clearfix'>
                    <span class='ic hotlist'></span>
                    <span class='text'><?php echo Yii::t("wap","Hot list");?></span>
                </a>
            </li>
            <li class="li-bxh <?php if($controller=='chart') echo 'active'?> hover-hotlist">
                <a href='<?php echo Yii::app()->createUrl('/chart')?>' class='clearfix'>
                    <span class='ic bxh'></span>
                    <span class='text'><?php echo Yii::t("wap","BXH");?></span>
                </a>
            </li>
            <li class="<?php if($controller=='album') echo 'active'?> hover-album">
                <a href='<?php echo Yii::app()->createUrl('/album')?>' class='clearfix'>
                    <span class='ic album'></span>
                    <span class='text'><?php echo Yii::t("wap","Album");?></span>
                </a>
            </li>
            <li class="<?php if($controller=='video') echo 'active'?> hover-video-n">
                <a href='<?php echo Yii::app()->createUrl('/video')?>' class='clearfix'>
                    <span class='ic video-n'></span>
                    <span class='text'><?php echo Yii::t("wap","Video");?></span>
                </a>
            </li>

            <li class="<?php if($controller=='artist') echo 'active'?> hover-artist">
                <a href='<?php echo Yii::app()->createUrl('/artist')?>' class='clearfix'>
                    <span class='ic artist'></span>
                    <span class='text'><?php echo Yii::t("wap","Nghệ sỹ");?></span>
                </a>
            </li>

        </ul>
        <?php if ($this->userPhone):?>
            <p class='m-label'>
                <?php echo Yii::t("wap","Personal");?>
            </p>
            <ul>
                <li class="<?php if($controller=='playlist') echo 'active'?> hover-playlist">
                    <a href='<?php echo Yii::app()->createUrl('/playlist/myPlaylist')?>' class='clearfix'>
                        <span class='ic playlist'></span>
                        <span class='text'><?php echo Yii::t("wap","My playlist");?></span>
                    </a>
                </li>
                <li class="<?php if($controller=='favourite') echo 'active'?> hover-fav">
                    <a href='<?php echo Yii::app()->createUrl('/favourite/list')?>' class='clearfix'>
                        <span class='ic fav'></span>
                        <span class='text'><?php echo Yii::t("wap","Favourite");?></span>
                    </a>
                </li>
                <li class="<?php if($controller=='account' && $action=='index') echo 'active'?> hover-myinfo">
                    <a href='<?php echo Yii::app()->createUrl('/account/view')?>' class='clearfix'>
                        <span class='ic myinfo'></span>
                        <span class='text'><?php echo Yii::t("wap","User Infomation");?></span>
                    </a>
                </li>
                <?php
                $cIP = isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$_SERVER["SERVER_ADDR"];
                $cIP = explode(".", $cIP);
                if($cIP != "10"):
                    ?>
                    <li class="hover-logout">
                        <a href='<?php echo Yii::app()->createUrl('/account/logout')?>' class='clearfix'>
                            <span class='ic logout'></span>
                            <span class='text'><?php echo Yii::t("wap","Logout");?></span>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
        <?php endif;?>
        <p class='m-label'>
            <?php echo Yii::t("wap","Thông tin dịch vụ");?>
        </p>
        <ul>
            <li class="li-guide <?php if($controller=='account' && $action=='guide') echo 'active'?> hover-intro">
                <a href='<?php
                $obj = array("obj_type"=>'html_view','name'=>'Giới thiệu','id'=>4);
                $link = URLHelper::makeUrl($obj);
                echo $link;
                ?>' class='clearfix'>
                    <span class='ic intro'></span>
                    <span class='text'><?php echo Yii::t("wap","Giới thiệu");?></span>
                </a>
            </li>
        </ul>
        <div class="menu-footer">
            <p>
                Cơ quan chủ quản: Công ty Cổ phần Bạch Minh (Vega Corporation).
            </p>
            <p>
                Địa chỉ: P804, tầng 8, tòa nhà V.E.T, 98 Hoàng Quốc Việt, Nghĩa Đô, Cầu Giấy, Hà Nội.
            </p>
            <p>DDKD: 0101380911 do Sở KH Hà Nội cấp 20/06/2003</p>
            <p>Email: 043 7554190</p>
            <p>Người chịu trách nhiệm nội dung: Bà Nguyễn Thị Thu Dung</p>
        </div>
    </div>
</aside>
