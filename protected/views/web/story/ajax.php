<div class="description">
    <div class="des-title"><a href=""><h3><?php echo $title;?></h3></a></div>
    <div class="des-info">
        <ul class="list-story">
            <?php foreach($stories as $story):?>
            <li>
                <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$story->story_slug))?>">
                    <img src="<?php echo Yii::app()->getBaseUrl(true).'/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';?>"
                         onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/ngon-tinh/Ga-Cho-Tong-Giam-Doc-Phai-Can-Than-md.jpg'" width="38"/>
                </a>
                <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$story->story_slug))?>" class="hot-title">
                    <h4 class="subtext"><?php echo $story->story_name;?></h4>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>