<div class="chapter-info">
    <div class="story-header">
        <div class="story-header-info">
            <h1><?php echo 'Truyện: '.$story->story_name?></h1>
            <h2 class="chapter_name subtext">Đang đọc: <?php echo $chapter['chapter_name'];?></h2>
            <?php $linkFb =  Yii::app()->createAbsoluteUrl('story/view',array('slug'=>$story->story_slug));?>
            <ul class="social">
                <li>
                    <?php $this->widget("application.widgets.web.common.FBLike", array(
                        "url" => $linkFb,
                    ));?>
                </li>
                <li class="comment-li crollto" rel="box-comment">Bình Luận</li>
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
        <div class="other-chapter text-center">
            <?php $table = substr($story->story_slug,0,2); if(!empty($previous)):
                $obj = array('obj_type'=>'chapter','slug'=>$story['story_slug'].'-'.$previous['chapter_slug'],'id'=>$previous['id'],'table'=>$table);
                $link = URLHelper::makeUrl($obj);
                ?>
                <a href="<?php echo $link;?>">Chương Trước</a>
            <?php endif;?>
            <?php if(!empty($next)):
                $obj = array('obj_type'=>'chapter','slug'=>$story['story_slug'].'-'.$next['chapter_slug'],'id'=>$next['id'],'table'=>$table);
                $link = URLHelper::makeUrl($obj);
                ?>

                <a href="<?php echo $link;?>">Chương Sau</a>
            <?php endif;?>
        </div>
    </div>
    <div class="box-relate">
        <div class="relate-header">
            <img width="60" src="<?php echo Yii::app()->getBaseUrl(true);?>/web/images/author.jpg">
            <div class="relate-info">
                <a href="javascript:void(0);"><h3><?php echo $story->author?></h3></a>
                <a href="<?php echo Yii::app()->createUrl('home/category',array(
                    'category'=>$story->category_slug,
                ))?>"><h4><?php echo $story->category_name;?></h4></a>
            </div>
        </div>
        <div class="relate-content">
            <ul class="box">
                <?php foreach($storyAuthor as $item):?>
                    <li class="col-xs-6 col-md-3">
                        <div class="story-item ">
                            <a class="thumbnail" href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$item->story_slug))?>">
                                <img width="129" src="<?php echo Yii::app()->getBaseUrl(true).
                                    '/public/images/'.$item->category_slug.'/'.$item->story_slug.'-md.jpg';?>" onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/ngon-tinh/Ga-Cho-Tong-Giam-Doc-Phai-Can-Than-md.jpg'"/>
                            </a>
                            <div class="info">
                                <div class="info-name">
                                    <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$item->story_slug))?>"><h4 class="subtext"><?php echo $item->story_name?></h4></a>
                                </div>
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
        <div class="box-comment" id="box-comment">
            <?php
                $this->widget('application.widgets.web.common.FBComments',array('url'=>$linkFb));
            ?>
        </div>
    </div>
</div>