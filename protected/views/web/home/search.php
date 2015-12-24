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
<div class="search-title">
    <p>Tìm thấy <b><?php echo $total;?></b> truyện với từ khóa <b><?php echo $q;?></b></p>
</div>
<?php
$this->widget('application.widgets.web.story.StoryListWidget',
    array(
        'stories'=>$stories,
        'title'=>'Danh Sách Truyện',
    ));
?>
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
