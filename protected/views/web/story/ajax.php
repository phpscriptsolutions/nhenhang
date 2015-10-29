<div class="description">
    <div class="des-title"><a href=""><h3><?php echo $title;?></h3></a></div>
    <div class="des-info">
        <ul class="list-story">
            <?php foreach($stories as $story):?>
            <li>
                <a href="">
                    <img src="<?php echo Yii::app()->getBaseUrl(true).'/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';?>"
                         onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/tien-hiep/Dan-Tu-md.jpg'" width="38"/>
                </a>
                <a href="" class="hot-title">
                    <h4 class="subtext"><?php echo $story->story_name;?></h4>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>