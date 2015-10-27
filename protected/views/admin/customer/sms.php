<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu log Thuê bao");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
            <input type="hidden" value="customer/sms" name="r">

            <div class="row">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'date',
                    'value' => (isset($_GET['date']) && $_GET['date'] != '') ? $_GET['date'] : '',
                ));
                ?>
                <input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" /><input type="submit" value="Tìm" />
            </div>
        </form>
    </div>
</div>
<div style="clear: both;height: 20px;"></div>
<?php if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))): ?>
    <div class="box_content">
        <div>
            <?php
            $this->widget('application.widgets.admin.grid.CGridView', array(
                'id' => 'log-content',
                'dataProvider' => $smsMo->search(),
                'titleText' => '<h4>Lịch sử tin nhắn MO của thuê bao <b>' . $msisdn . '</b> từ ' . $fromDate . ' đến ' . $toDate . '</h4>',
                'columns' => array(
                    array(
                        'header' => 'STT',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions' => array('width' => 30)
                    ),
                    array(
                        'header' => 'Thời gian nhận',
                        'value' => '$data->receive_time',
                    ),
                    array(
                        'header' => 'MO',
                        'value' => '$data->keyword',
                    ),
                    array(
                        'header' => 'Nội dung',
                        'value' => '$data->content',
                    ),
                ),
            ));
            ?>
        </div>
    </div>

    <div class="box_content">
        <div>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'admin-user-mt-model-grid',
                'dataProvider' => $smsMt->search(),
                'titleText' => '<h4>Lịch sử tin nhắn MT của thuê bao <b>' . $msisdn . '</b> từ ' . $fromDate . ' đến ' . $toDate . '</h4>',
                'columns' => array(
                    array(
                        'header' => 'STT',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions' => array('width' => 30)
                    ),
                    array(
                        'header' => 'Thời gian gửi',
                        'value' => '$data->send_datetime',
                        'htmlOptions' => array('width' => 150)
                    ),
                    array(
                        'header' => 'Nội dung',
                        'value' => '$data->content',
                    ),
                ),
            ));
            ?>
        </div>
    </div>

    </div>
<?php else: ?>
    <h3>Số điện thoại không hợp lệ hoặc không phải Mobifone.</h3>
<?php endif; ?>