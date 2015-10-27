<style>
    .login-wifi label{
        width: 200px;
    }
    #login-wifi{
        padding: 20px 10px;
    }
</style>
<div id="event">
    <div class="form">
        <form name="verify" method="post">
            <?php if ($error == 1): ?>
            	<div class="invalid"></div>
                <div class="error">
                    <p class="red"><?php echo $msg; ?></p>
                    <p>Mời Quý Khách nhập lại</p>
                </div>
            <?php else:?>
            <span class="label">Mã xác nhận đã được gửi đến số điện thoại: <b><?php echo $phone; ?></b></span>
            <div>Hãy nhập mã xác nhận vào ô bên dưới và nhấn nút <b>Xác nhận</b>.</div>
            <?php endif; ?>
            <div class="field"><input type="text" name="code"></div>
            <div class="clear"><input class="btn-event" type="submit" value="Xác nhận"/></div>
        </form>
    </div>
</div>