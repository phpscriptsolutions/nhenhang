<div class="box">
    <div class="box-title">
        <?php if(empty($link)):?>
            <h2><?php echo $title;?></h2>
        <?php else:?>
            <a href="<?php echo $link?>"><h2><?php echo $title;?></h2></a>
        <?php endif;?>

    </div>
    <?php if(!empty($stories) && count($stories)):?>
    <ul>
        <div class="row">
        <?php
        Yii::import("application.vendors.Hashids.*");
        $hashids = new Hashids(Yii::app()->params["hash_url"]);
        foreach($stories as $story):?>
        <li class="col-xs-6 col-md-3">
            <div class="story-item ">
                <a class="thumbnail" href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$story->story_slug))?>">
                    <img width="129" src="<?php echo Yii::app()->getBaseUrl(true).
                        '/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';?>" onerror="this.src='<?php echo Yii::app()->getBaseUrl(true)?>/public/images/tien-hiep/Dan-Tu-md.jpg'"/>
                </a>
            <div class="info">
                <div class="info-name">
                    <a href="<?php echo Yii::app()->createUrl('story/view',array('slug'=>$story->story_slug))?>"><h4 class="subtext"><?php echo $story->story_name?></h4></a>
                </div>
                <div class="info-author text-center">
                    <a href=""><h4 class="subtext"><span>By: </span><?php echo (!empty($story->author))?$story->author:'Truyện Full';?></h4></a>
                </div>
                <div class="info-category text-center">
                    <a href="<?php echo Yii::app()->createUrl('home/category',array(
                        'category'=>$story->category_slug,
                        'hot' => false,
                    ))?>"><h4 class="subtext"><span>Thể loại: </span><?php echo $story->category_name?></h4></a>
                </div>
                <div class="info-category text-center">
                    <?php
                    $encodeId = $hashids->encode($story["id"]);
                    ?>
                    <a href="<?php echo Yii::app()->createUrl('story/lastest',
                        array('slug'=>Common::makeFriendlyStoryUrl($story->lastest_chapter),'code'=>substr($story->story_slug,0,2).$encodeId));?>"><h4 class="subtext"><?php echo $story->lastest_chapter;?></h4></a>
                </div>
            </div>
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