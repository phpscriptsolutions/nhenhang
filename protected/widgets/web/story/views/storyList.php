<div class="box">
    <div class="box-title">
        <a href=""><h2><?php echo $title;?></h2></a>
    </div>
    <?php if(!empty($stories) && count($stories)):?>
    <ul>
        <?php foreach($stories as $story):?>
        <li class="story-item col-md-3">
            <div class="cover">
                <a href="">
                    <img width="129" src="<?php echo Yii::app()->getBaseUrl(true).
                        '/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';?>"/>
                </a>
            </div>
            <div class="info">
                <div class="info-name">
                    <a href=""><h4><?php echo $story->story_name?></h4></a>
                </div>
                <div class="info-author">
                    <a href=""><h4><?php echo $story->author;?></h4></a>
                </div>
                <div class="info-category">
                    <a href=""><h4><?php echo $story->category_name?></h4></a>
                </div>
                <div class="info-category">
                    <a href=""><h4><?php echo $story->lastest_chapter;?></h4></a>
                </div>
            </div>
        </li>
        <?php endforeach;?>
    </ul>
    <?php else:?>
    <div class="not-found">
        Không tìm thấy dữ liệu nào.
    </div>
    <?php endif;?>
</div>