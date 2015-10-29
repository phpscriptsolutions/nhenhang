<div class="container content-container">
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
        $this->widget('application.widgets.web.story.ChapterDetailWidget',array(
            'story'=>$story,
            'chapter'=>$chapterInfo,
        ));
        ?>
    </div>
    <div id="slide-bar" class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        <?php $this->widget('application.widgets.web.story.RightContentWidget',array('story'=>$story));?>
    </div>
</div>

