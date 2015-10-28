<?php
$this->widget('application.widgets.web.story.StoryListWidget',
    array(
        'stories'=>$stories,
        'title'=>$category->category_name,
    ));
?>
<div class="paginagion">
    <?php
    $this->widget("application.widgets.web.common.VLinkPager", array (
        "pages" => $pager,
        "suffix"=>"gr",
        "object_link"=>array("category"=>$category->category_slug,'name'=>$category->category_name,'hot'=>$isHot),
        "maxButtonCount" => Yii::app()->params["paging"]["pager_max_button_count"],
        "header" => "",
        "htmlOptions" => array (
            "class" => "pager"
        )
    ) );
    ?>
</div>
