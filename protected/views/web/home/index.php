<?php
$metaTitle = 'Nhenhang.com - Truyện Kiếm Hiệp, Ngôn Tình, Sắc Hiệp, Tiên Hiệp, Trinh Thám, Truyện Online, Truyện Hay Nhất, Truyện Mới nhất, Wap Truyện, Đọc truyện trên Mobile';
$title = 'Thế giới truyện!';
$metaKeyword = 'doc truyen, doc truyen online, truyen hay, truyen chu, ngon tinh, kiem hiep, tien hiep, sac hiep, kinh di, trinh tham, vong du, xuyen khong, truyen teen..';
$metaDescription = 'Nghe nhạc mp3 online CỰC HOT, tải nhạc chất lượng cao CỰC NHANH. Dịch vụ nghe nhạc trực tuyến trên mọi thiết bị';
$description = 'Website đọc truyện hay nhất, nhanh nhất. truyện Mobile, wap truyện, Đọc truyện online, đọc truyện chữ, truyện hay, truyện full. Truyện Full luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.';
$imageShare = Yii::app()->request->getBaseUrl(true)."/public/images/ngon-tinh/Ga-Cho-Tong-Giam-Doc-Phai-Can-Than-md.jpg";
$url = Yii::app()->createAbsoluteUrl('/');
Yii::app()->SEO->setMetaTitle($metaTitle);
Yii::app()->SEO->setMetaDescription($metaDescription);
Yii::app()->SEO->setMetaKeyword($metaKeyword);
Yii::app()->SEO->setMetaNewsKeywords($metaKeyword);
Yii::app()->SEO->setCanonical($url);
Yii::app()->SEO->addMetaProp('og:url',$url);
Yii::app()->SEO->addMetaProp('og:title',$title);
Yii::app()->SEO->addMetaProp('og:description',$description);
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
        $link = Yii::app()->createUrl('home/category',array('category'=>'truyen-hot','hot'=>true));
        $this->widget('application.widgets.web.story.StoryListWidget',
            array(
                'stories'=>$hotStories,
                'title'=>'Truyện HOT',
                'link'=>$link
            ));
        $link = Yii::app()->createUrl('home/category',array('category'=>'truyen-full','hot'=>false,'s'=>'Full'));
        $this->widget('application.widgets.web.story.StoryListWidget',
            array(
                'stories'=>$fullStories,
                'title'=>'Truyện FULL',
                'link' => $link
            ));
        ?>
    </div>
    <div id="slide-bar" class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        <?php include_once '_rightMenu.php';?>
    </div>
</div>
