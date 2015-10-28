<div class="options-plus" id="op-<?php echo $this->content_id; ?>">
    <a href="javascript: void(0);" class="btn-plus" onclick="OpenOptionsMenu('<?php echo $this->content_id; ?>');"><span class="icon icon-setting"></span></a>
    <div class="options-dialog">
        <ul>
            <!--<li><a href="javascript:void(0);" class="facebook-share fb-share" onclick="shareFacebook('Nhac.vn','<?php /* echo $this->url_share; */ ?>');" ><i class="icon icon-facebook-share"></i>Chia sẻ Facebook</a></li>-->
            <li><a href="https://plus.google.com/share?url=<?php echo $this->url_share; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                    return false;" class="google-share"><i class="icon icon-gplus"></i>Chia sẻ Google+</a></li>
                   <?php if (!$this->disReport) { ?>
                <li><a href="javascript: void(0);" onclick="{
                            addDialogreport_dialog();
                            jQuery('#report_dialog').dialog('open');
                        }" class="report"><i class="icon icon-report"></i>Báo lỗi</a></li>
                   <?php } ?>
                   <?php if ($this->content_type == 'song' || $this->content_type == 'video' || $this->content_type == 'album' || $this->content_type == 'playlist'): ?>
                <li><a id="embed" href="javascript: void(0);"><i class="icon icon-embed"></i>Mã nhúng</a></li>
            <?php endif; ?>
        </ul>
        <span class="ticker"></span>
    </div>
</div>