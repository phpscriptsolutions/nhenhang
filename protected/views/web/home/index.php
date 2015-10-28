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
        $this->widget('application.widgets.web.story.StoryListWidget',
            array(
                'stories'=>$hotStories,
                'title'=>'Truyện HOT',
            ));

        $this->widget('application.widgets.web.story.StoryListWidget',
            array(
                'stories'=>$fullStories,
                'title'=>'Truyện FULL',
            ));
        ?>
    </div>
    <div id="slide-bar" class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        <div class="slide-box">
            <div class="box-title">
                <h2>Thể Loại Truyện</h2>
            </div>
            <ul>
                <li><a href=""><h3>Truyện Ngôn tình</h3></a></li>
                <li><a href=""><h3>Truyện Kiếm Hiệp</h3></a></li>
                <li><a href=""><h3>Truyện Tiên Hiệp</h3></a></li>
                <li><a href=""><h3>Truyện Võng Du</h3></a></li>
                <li><a href=""><h3>Truyện Trinh Thám</h3></a></li>
                <li><a href=""><h3>Truyện Kinh Dị</h3></a></li>
                <li><a href=""><h3>Truyện Ma</h3></a></li>
                <li><a href=""><h3>Truyện Teen</h3></a></li>
            </ul>
        </div>
    </div>
</div>
