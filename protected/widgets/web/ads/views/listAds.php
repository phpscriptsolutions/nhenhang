<div class="box">
    <div class="box-title">
        <?php if(empty($link)):?>
            <h2><?php echo $title;?></h2>
        <?php else:?>
            <a href="<?php echo $link?>"><h2><?php echo $title;?></h2></a>
        <?php endif;?>

    </div>
    <div class="gg-ads">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- item-ads -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7746462635786238"
             data-ad-slot="1078062902"
             data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
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