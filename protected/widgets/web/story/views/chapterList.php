<div class="chapter-info">
    <div class="story-header">
        <div class="story-header-info">
            <h1><?php echo $story->story_name?></h1>
            <h2><span class="legend">Thể loại:</span> <?php echo $story->category_name;?></h2>
            <h2><span class="legend">Tình trạng:</span> <?php echo $story->status;?></h2>
            <?php
            Yii::import("application.vendors.Hashids.*");
            $hashids = new Hashids(Yii::app()->params["hash_url"]);
            $encodeId = $hashids->encode($story["id"]);
            ?>
            <a href="<?php echo Yii::app()->createUrl('story/lastest',
                array('slug'=>Common::makeFriendlyStoryUrl($story->lastest_chapter),'code'=>substr($story->story_slug,0,2).$encodeId));?>"><h2 class="chapter_name subtext"><span class="legend">Mới nhất:</span><?php echo $story->lastest_chapter?></h2></a>
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
            <h3>Danh Sách Chương</h3>
        </div>
        <?php if(!empty($chapters) && count($chapters)):
            $total = count($chapters);
            if($total>25){
                $total = 25;
            }
            ?>

        <div class="col-md-6 col-sm-12 col-xs-12">
            <ul>
                <?php
                $table = substr($story->story_slug,0,2);
                for($i = 0; $i<$total;$i++):
                    $chapter = $chapters[$i];
                    $obj = array('obj_type'=>'chapter','slug'=>$story['story_slug'].'-'.$chapter['chapter_slug'],'id'=>$chapter['id'],'table'=>$table);
                    $link = URLHelper::makeUrl($obj);
                    ?>
                <li>
                    <a href="<?php echo $link;?>">
                        <h4><?php echo $chapter['chapter_name'];?></h4>
                    </a>
                </li>

                <?php endfor;?>

            </ul>
        </div>
            <?php if(count($chapters)>25):?>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <ul>
                    <?php for($i = 25; $i<count($chapters);$i++):
                        $chapter = $chapters[$i];
                        $obj = array('obj_type'=>'chapter','slug'=>$story['story_slug'].'-'.$chapter['chapter_slug'],'id'=>$chapter['id'],'table'=>$table);
                        $link = URLHelper::makeUrl($obj);
                        ?>
                        <li>
                            <a href="<?php echo $link;?>">
                                <h4><?php echo $chapter['chapter_name'];?></h4>
                            </a>
                        </li>

                    <?php endfor;?>

                </ul>
            </div>
            <?php endif;?>
        <?php else:?>
            <div class="text-center">
                Truyện Đang Được Cập Nhật.
            </div>
        <?php endif;?>
        <div class="paginagion">
            <?php
            $this->widget("application.widgets.web.common.VLinkPager", array (
                "pages" => $pager,
                "suffix"=>"gr",
                "object_link"=>null,
                "maxButtonCount" => Yii::app()->params["paging"]["pager_max_button_count"],
                "header" => "",
                "htmlOptions" => array (
                    "class" => "pager"
                )
            ) );
            ?>
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
    <div class="ads-box"></div>
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