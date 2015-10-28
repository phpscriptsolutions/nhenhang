<?php if(!empty($content)){?>
    <div class="ct-desc">
    <?php
        $intro = Formatter::smartCut($content, $this->intro_size);
        if(strlen($content)>$this->intro_size && strlen($intro)<strlen($content)){
            ?>
            <div class="desc_short">
                <?php echo Formatter::smartCut($content, $this->intro_size);?>
                <a href="javascript:;" class="excoll see_full">Xem toàn bộ</a>
            </div>
            <div class="desc_full hide">
                <?php echo $content;?>
                <a href="javascript:;" class="excoll see_intro">Rút gọn</a>
            </div>
            <?php
        }else{
            ?>
            <div class="desc_full">
                <?php echo $content;?>
            </div>
        <?php
        }
    ?>
    </div>
<?php }?>
