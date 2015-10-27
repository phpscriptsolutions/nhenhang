<?php
$this->menu = array(
    array('label' => Yii::t('admin', 'Kết thúc'), 'url' => array('song/returnApproved')),
);
$this->pageLabel = Yii::t("admin", "Duyệt bài hát {songname}", array('{songname}' => $song->name));

$songExtra = AdminSongExtraModel::model()->findByPk($song->id);
$lyrics = ($songExtra) ? nl2br($songExtra->lyrics) : "";
$this->widget('zii.widgets.CDetailView', array(
    'data' => $song,
    'attributes' => array(
        array(
            'label' => 'Nghe thử',
            'value' => '
                <object width="290" height="24" type="application/x-shockwave-flash" data="' . Yii::app()->request->baseUrl . '/flash/mini_player.swf" id="audioplayer1">
	                <param name="movie" value="' . Yii::app()->request->baseUrl . '/flash/mini_player.swf">
	                <param name="FlashVars" value="playerID=1&amp;soundFile=' . Yii::app()->params['storage']['staticUrl'] . "audio/" . $song->source_path . '">
	                <param name="quality" value="high">
	                <param name="menu" value="false">
	                <param name="wmode" value="transparent">
	            </object>',
            'type' => 'raw'
        ),
        'id',
        'code',
        array(
            'label' => 'Tên bài',
            'value' => $song->name,
        ),
        /* array(
            'label' => 'Danh mục',
            'value' => $song->genre_name,
        ), */
        'artist_name',
        'max_bitrate',
        'created_by',
        array(
            'label' => 'CP name',
            'value' => $song->cp->name,
        ),
        'created_time',
        'updated_time',
        'sorder',
        'status',
        array(
            'label' => 'Lời',
            'value' => $lyrics,
            'type' => 'html'
        )
    ),
));
?>

<form method="post" class="approve-form">
    <?php if (!empty($userSession) && $userSession->id != $this->userId): ?>
        <div class="wrr">
            <?php echo Yii::t("admin", "Bài hát này đang được duyệt bởi {user} Từ {time}", array('{user}' => "<b>" . $userSession['username'] . "</b>", '{time}' => "<b>" . date("h:i:s d-m-Y", strtotime($checkout['created_time'])) . "</b>")) ?>
            <input type="submit" name="next" value="<?php echo Yii::t("admin", "Bài tiếp theo") ?>" />
        </div>
    <?php else: ?>
        <input type="submit" name="approved" value="<?php echo Yii::t("admin", "Duyệt") ?>" />
        <?php
        echo CHtml::link(Yii::t("admin", "Từ chối"), '#', array(
            'onclick' => '$("#reason-reject").dialog("open"); return false;',
            'class' => 'button ui-corner-all'
        ));
        ?>	
        <input type="submit" name="next" value="<?php echo Yii::t("admin", "Bỏ qua") ?>" />

    <?php endif; ?>	
</form> 

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'reason-reject',
    'options' => array(
        'title' => 'Lý do từ chối (xóa) bài hát?',
        'autoOpen' => false,
        'modal' => 'true',
        'width' => '400px',
        'height' => 'auto',
    ),
));

$this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('song/Approved', array('id' => $song->id)),
    'method' => 'post',
    'htmlOptions' => array(),
));
echo CHtml::textArea("reason", "Chất lượng kém", array('class' => 'w300 h150'));
echo '<div class="row buttons pl50">';
echo CHtml::hiddenField("reject", '1');
echo '<input type="submit" name="reject" value="' . Yii::t('admin', 'Từ chối') . '" />';
echo " ";
echo CHtml::button(Yii::t('admin', 'Đóng lại'), array(
    "onclick" => '$("#reason-reject").dialog("close");',
    "class" => "ui-button ui-widget ui-state-default ui-corner-all"
));
echo '</div>';
$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

