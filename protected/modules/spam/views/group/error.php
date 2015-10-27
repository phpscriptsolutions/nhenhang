<!-- Hien thi Error -->
<?php if(isset($message)){ ?>
<p>&nbsp;</p>
<p class="note"><strong><?php echo $message; ?></strong></p><p>&nbsp;</p>
<?php
}
if (is_array($errorList) && count($errorList) > 0) {
    $str = implode("\n", $errorList);
    echo '<p class="note"><strong>Danh sách các số ĐT bị lỗi ('.count($errorList).'):</strong></p>';
    echo '<textarea cols="16" rows="6" style="float: none ! important; margin-top: 6px;">'.$str.'</textarea>';
}
if (is_array($dupList) && count($dupList) > 0) {
    $str2 = implode("\n", $dupList);
    echo '<p class="note"><strong>Danh sách các số ĐT đã tồn tại ('.count($dupList).'):</strong></p>';
    echo '<textarea cols="16" rows="6" style="float: none ! important; margin-top: 6px;">'.$str2.'</textarea>';
}
if (is_array($subscribeList) && count($subscribeList) > 0) {
    $str2 = implode("\n", $subscribeList);
    echo '<p class="note"><strong>Danh sách các số ĐT đã đăng ký ('.count($subscribeList).'):</strong></p>';
    echo '<textarea cols="16" rows="6" style="float: none ! important; margin-top: 6px;">'.$str2.'</textarea>';
}
?>