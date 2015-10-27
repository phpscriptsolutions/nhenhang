<?php
$controller = Yii::app()->controller->id;
?>
<?php
$newEvents = NewsEventModel::model()->getEvent('custom','wap');
if ($newEvents) {
    echo '<div id="text_link">';
    foreach ($newEvents as $newEvent) {
        ?>
        <p>
            <a class="c_orange" href="<?php echo $newEvent->custom_link;?>">
                <?php echo $newEvent->name; ?>
            </a>
        </p>
    <?php }
}?>


<script>
function ClosePopup(type)
{
	$.ajax({
        type: "GET",
        url: '<?php echo Yii::app()->createUrl('/ajax/setCookies')?>',
        data: {type:type,day:1},
        beforeSend: function() {
        },
        success: function(data) {
            //alert()
        },
        complete: function() {
        },
        statusCode: {
            404: function() {
                alert("Lỗi kết nối");
                return false;
            }
        }
    });
    
	Popup.close()
}
</script>