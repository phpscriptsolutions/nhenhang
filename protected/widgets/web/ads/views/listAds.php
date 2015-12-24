<div class="box">
    <div class="box-title">
        <?php if(empty($link)):?>
            <h2><?php echo $title;?></h2>
        <?php else:?>
            <a href="<?php echo $link?>"><h2><?php echo $title;?></h2></a>
        <?php endif;?>

    </div>
    <?php if(!empty($data) && count($data)):?>
        <ul>
            <div class="row">
                <?php
                foreach($data as $ad):?>
                    <li class="col-xs-6 col-md-3">
                        <div class="ads-item ">
                            <?php echo $ad->content?>
                        </div>
                    </li>
                <?php endforeach;?>
            </div>
        </ul>
    <?php else:?>
        <div class="not-found">
            Không tìm thấy dữ liệu nào.
        </div>
    <?php endif;?>
</div>