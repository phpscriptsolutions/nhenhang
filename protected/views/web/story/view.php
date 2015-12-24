<?php
$friendlyName = Common::strNormal($story->story_name);
$metaTitle = $story->story_name.' '.$story->author.' | đọc truyện NHENHANG.COM';
$metaKeyword = $story->story_name.', '.$friendlyName.', '.$story->story_name.' Full,'.$story->story_name.' '.$story->author.', đọc truyện '.$story->story_name.
', truyện '.$story->category_name;
$url = Yii::app()->createAbsoluteUrl('story/view',array('slug'=>$story->story_slug));
$description = $story->description;
$imageShare = Yii::app()->getBaseUrl(true).
    '/public/images/'.$story->category_slug.'/'.$story->story_slug.'-md.jpg';

Yii::app()->SEO->setInitialize($story->id,'');
Yii::app()->SEO->setMetaTitle($metaTitle);
Yii::app()->SEO->setMetaDescription($metaTitle.' - '.$description);
Yii::app()->SEO->setMetaKeyword($metaKeyword);
Yii::app()->SEO->setMetaNewsKeywords($metaKeyword);
Yii::app()->SEO->setCanonical($url);
Yii::app()->SEO->addMetaProp('og:url',$url);
Yii::app()->SEO->addMetaProp('og:title',$metaTitle);
Yii::app()->SEO->addMetaProp('og:description',$description);
Yii::app()->SEO->addMetaProp('og:type',"website");
Yii::app()->SEO->addMetaProp('og:image',$imageShare);
Yii::app()->SEO->addMetaProp('og:site_name',Yii::app()->name);
Yii::app()->SEO->addMetaProp('og:updated_time',time());
?>


<div class="container content-container">
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
    <?php
    if($this->breadcrumbs){
        echo '<div id="breadcrumb">';
        $this->widget('application.widgets.VBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'htmlOptions'=>array('class'=>'wapper'),
        ));
        echo '</div>';
    }
    ?>
    <div id="main-content" class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <?php
        $this->widget('application.widgets.web.story.ChapterListWidget',array(
            'story'=>$story,
            'chapters'=>$chapters,
            'storyAuthor'=>$storyAuthor,
            'pager'=>$pager,
        ));
        ?>
    </div>
    <div id="slide-bar" class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        <?php $this->widget('application.widgets.web.story.RightContentWidget',array('story'=>$story));?>
    </div>
</div>
