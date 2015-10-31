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
