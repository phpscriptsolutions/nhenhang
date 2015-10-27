<body>
    <div id="header">
        <div class="fll" id="chachalogo"><a href="<?php echo Yii::app()->params['mobile_base_url'];?>/"><img alt="logo" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/Logo.png"></img></a></div>
        <div class="flr" id="header-nav">
            <?php
            if(!function_exists("checkCurrentMenu")){
            	function checkCurrentMenu($menu, $cId, $actionId){
            		if(($menu == $cId && $actionId != "grid") || ($menu == $cId . '/' . $actionId)){
            			return 'selected';
            		}
            		return '';
            	}
            }

            $menu_per_items = array();
            $menu_per_items[] = array('class'=>'icon_home','href'=>'site/grid');
            $menu_per_items[] = array('class'=>'icon_user','href'=>'account');
            foreach($menu_per_items as $menu){
                echo "<div class='{$menu['class']} nav_icon ".checkCurrentMenu($menu['href'], $cId, $actionId)."'><a href='/{$menu['href']}'></a></div>";
            }
            ?>
        </div>
    </div>
    <div class="clb" id="menu_top">
            <table>
                <tr>
                    <?php  $menu_items = array();
                    $menu_items[] = array('title'=>'site','href'=>'','text'=>'<img class="home-icon" alt="Home" src="'.Yii::app()->theme->baseUrl.'/images/home.png"></img>');
                    //$menu_items[] = array('title'=>'genre','href'=>'genre','text'=>'Thể loại');
                    $menu_items[] = array('title'=>'song','href'=>'song','text'=>'BÀI HÁT');
                    $menu_items[] = array('title'=>'video','href'=>'video','text'=>'VIDEO');
                    $menu_items[] = array('title'=>'album','href'=>'album','text'=>'ALBUM');
                    $menu_items[] = array('title'=>'bxh','href'=>'bxh','text'=>'BXH');

                    foreach($menu_items as $menu){
                        echo "<td class='".checkCurrentMenu($menu['title'], $cId, $actionId)."'><a title='{$menu['title']}' href='/{$menu['href']}'>{$menu['text']}</a></td>";
                    }
                    ?>
                </tr>
            </table>
    </div>
	<?php echo $content;?>

        <div class="clb nav_bottom" id="footer">
            <center>
                <table class="table0" style="text-align: center">
                    <tr>
                        <td class="border-right"><a class="smallText" href="/account">Tài khoản&nbsp;</a></td>
                        <td class="border-right"><a class="smallText" href="/account/guide?id=7">Giới thiệu&nbsp;</a></td>
                        <td class="border-right"><a class="smallText" href="/account/guide?id=8">Hướng dẫn&nbsp;</a></td>
                        <td><a class="smallText" href="/account/apptdcation">Tải PM</a></td>
                    </tr>
                </table>
                <p style="color:#fff;" class="m0 smallText">&copy; 2009 - 2012 Vinaphone</p>
            </center>
        </div>

    <?php
        GAWap::$GA_ACCOUNT = Yii::app()->params['GA_ACCOUNT'];
        $googleAnalyticsImageUrl = GAWap::googleAnalyticsGetImageUrl();
        echo '<img style="display:none" src="' . $googleAnalyticsImageUrl . '" />';
    ?>
</body>