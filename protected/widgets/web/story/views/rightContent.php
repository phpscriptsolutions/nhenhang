<div class="slidebar-group">
    <div class="info-story">
        <div class="info-story-header">
            <img src="<?php echo Yii::app()->getBaseUrl(true).'/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';?>"
                 onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/tien-hiep/Dan-Tu-md.jpg'" width="90"/>
            <div class="info-story-more">
                <h3><?php echo $story->story_name;?></h3>
                <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$story->story_slug))?>"><h4><?php echo $story->category_name;?></h4></a>
                <ul>
                    <li class="gp-icon">Android</li>
                    <li class="comment-li crollto" rel="box-comment">Bình Luận</li>
                </ul>
            </div>
        </div>

    </div>
    <div class="description">
        <div class="des-title">Giới Thiệu</div>
        <div class="des-info">
            <?php echo (!empty($story->description))?$story->description:'Đang cập nhật.';?>
        </div>
    </div>
</div>
<div class="slidebar-group" id="story-list-hot">
</div>
<div class="slidebar-group" id="story-list-full">
</div>

<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/web/js/story.js"></script>
<script>
    story.loadList('hot');
    story.loadList('full');
</script>