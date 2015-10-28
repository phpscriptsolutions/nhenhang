<div class="chapter-info">
    <div class="story-header">
        <div class="story-header-info">
            <h1><?php echo $story->story_name?></h1>
            <h2><?php echo $story->category_name;?></h2>
            <a href=""><h2><?php echo $story->lastest_chapter?></h2></a>
            <ul class="social">
                <li>Facebook</li>
                <li>Google+</li>
                <li>Bình Luận</li>
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
                <?php for($i = 0; $i<$total;$i++):
                    $chapter = $chapters[$i];
                    ?>
                <li>
                    <a href="">
                        <h4><?php echo $chapter['chapter_name'];?></h4>
                    </a>
                </li>

                <?php endfor;?>

            </ul>
        </div>
            <?php if(count($chapters)>25):?>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <ul>
                    <?php for($i = 25; $i<50;$i++):
                        $chapter = $chapters[$i];
                        ?>
                        <li>
                            <a href="">
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
        <ul class="pager" id="yw0"><li class="previous hidden"><a class="" href="http://nhacvn.vn/album/nhac-au-my-hot-grjA">«</a></li>
            <li class=" active"><a class="active" href="http://nhacvn.vn/album/nhac-au-my-hot-grjA">1</a></li>
            <li class=""><a class="" href="http://nhacvn.vn/album/nhac-au-my-hot-grjA?p=2">2</a></li>
            <li class="next"><a class="" href="http://nhacvn.vn/album/nhac-au-my-hot-grjA?p=2">»</a></li></ul>
    </div>
    <div class="box-relate">
        <div class="relate-header">
            <img width="60" src="images/author.jpg">
            <div class="relate-info">
                <a href=""><h3>Nguyễn Thành Tiến</h3></a>
                <a href=""><h4>Truyện Ngôn Tình</h4></a>
            </div>
        </div>
        <div class="relate-content">
            <ul class="box">
                <li class="story-item">
                    <div class="cover">
                        <a href="">
                            <img src="http://static.truyenfull.vn/poster/lh3/-55HGpltQybY/ViCBisUo4SI/AAAAAAAABsw/n3VauqiRf6Q/w129-h192-Ic42/dai-duong-tuu-do.jpg"/>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-name">
                            <a href=""><h4>Mùa hoa sen</h4></a>
                        </div>
                    </div>
                </li>
                <li class="story-item">
                    <div class="cover">
                        <a href="">
                            <img src="http://static.truyenfull.vn/poster/lh3/-55HGpltQybY/ViCBisUo4SI/AAAAAAAABsw/n3VauqiRf6Q/w129-h192-Ic42/dai-duong-tuu-do.jpg"/>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-name">
                            <a href=""><h4>Mùa hoa sen</h4></a>
                        </div>
                    </div>
                </li>
                <li class="story-item">
                    <div class="cover">
                        <a href="">
                            <img  src="http://static.truyenfull.vn/poster/lh3/-55HGpltQybY/ViCBisUo4SI/AAAAAAAABsw/n3VauqiRf6Q/w129-h192-Ic42/dai-duong-tuu-do.jpg"/>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-name">
                            <a href=""><h4>Mùa hoa sen</h4></a>
                        </div>
                    </div>
                </li>
                <li class="story-item">
                    <div class="cover">
                        <a href="">
                            <img src="http://static.truyenfull.vn/poster/lh3/-55HGpltQybY/ViCBisUo4SI/AAAAAAAABsw/n3VauqiRf6Q/w129-h192-Ic42/dai-duong-tuu-do.jpg"/>
                        </a>
                    </div>
                    <div class="info">
                        <div class="info-name">
                            <a href=""><h4>Mùa hoa sen</h4></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="story-chapter">
        <div class="story-chapter-title">
            <h3>Bình Luận</h3>
        </div>
        <div class="box-comment">
            <div data-width="100%" class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/" data-numposts="5"></div>
        </div>
    </div>
</div>