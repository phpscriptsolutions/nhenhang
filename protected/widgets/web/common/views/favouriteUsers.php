<div class="box_title clb">
    <h2 class="name font20"><?php echo $this->boxName;?></h2>
</div>
<?php if(isset($users) && count($users) > 0):?>
<div class="box_content">
    <ul class="user_list_artist_page" >
        <?php
        $max = min(count($users), $limit);
        for ($i = 0; $i < $max; $i++):
            $user = $users[$i];
            if(isset($user) && isset($user->id)):
                $link = Yii::app()->createUrl("user/detail", array("id" => $user->id));
                ?>
                <?php if($type == 'right-box'):?>
                <li class="<?php if($i%3 == 2) echo 'marr_0'; else echo '';?>">
                <?php else:?>
                <li class="<?php if($i%9 == 8) echo 'marr_0'; else echo '';?>">
                <?php endif; ?>
                <a href="<?php echo $link;?>">
                    <img style="width: 90px; height: 90px;"
                         src="<?php echo WebUserModel::model()->getThumbnailUrl(90, $user->id); ?>" alt="<?php echo $user->fullname;?>" />
                </a>
                <p class="over-text"><a href="<?php echo $link;?>" title="<?php echo $user->fullname;?>"><?php echo $user->fullname; ?></a></p>
                </li>
            <?php endif;?>
        <?php endfor; ?>
    </ul>
</div>
<?php else:?>
    <p class="pt10"><?php echo Yii::t('web','Not found anything!');?></p>
<?php endif;?>