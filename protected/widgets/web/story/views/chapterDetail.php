<div class="chapter-info">
    <div class="story-header">
        <div class="story-header-info">
            <h1><?php echo $story->story_name?></h1>
            <h2><?php echo $story->category_name;?></h2>
            <a href=""><h2><?php echo $story->lastest_chapter?></h2></a>
            <ul class="social">
                <li>Facebook</li>
                <li>Google+</li>
                <li>Bình Luận</li>
            </ul>
        </div>
        <i class="icon icon-star"></i>
    </div>
    <div class="story-chapter">
        <div class="story-chapter-title">
            <h3>Nội dung truyện</h3>
        </div>
        <div class="detail-chapter">
        <?php if(!empty($chapter)):?>
            <?php echo $chapter['content'];?>
        <?php else:?>
            <div class="text-center">
                Truyện Đang Được Cập Nhật.
            </div>
        <?php endif;?>
        </div>
    </div>
    <div class="box-relate">
        <div class="relate-header">
            <img width="60" src="<?php echo Yii::app()->getBaseUrl(true);?>/web/images/author.jpg">
            <div class="relate-info">
                <a href=""><h3><?php echo $story->author?></h3></a>
                <a href=""><h4><?php echo $story->category_name;?></h4></a>
            </div>
        </div>
        <div class="relate-content">
            <ul class="box">
                <?php foreach($storyAuthor as $item):?>
                <li class="story-item">
                    <div class="cover">
                        <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$item->story_slug))?>">
                            <img width="129" src="<?php echo Yii::app()->getBaseUrl(true).
                                '/public/images/'.$item->category_slug.'/'.$item->story_slug.'-md.jpg';?>"
                                 onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/tien-hiep/Dan-Tu-md.jpg'"/>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-name">
                            <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$item->story_slug))?>"><h4><?php echo $item->story_name;?></h4></a>
                        </div>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="story-chapter">
        <div class="story-chapter-title">
            <h3>Bình Luận</h3>
        </div>
        <div class="box-comment">
            <?php
                $link =  Yii::app()->createAbsoluteUrl('story/view',array('slug'=>$story->story_slug));
                $this->widget('application.widgets.web.common.FBComments',array('url'=>$link));
            ?>
        </div>
    </div>
</div>