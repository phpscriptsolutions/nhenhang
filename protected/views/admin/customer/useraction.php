<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu log Thuê bao");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
            <input type="hidden" value="customer/useraction" name="r">

            <div class="row">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'date',
                    'value' => (isset($_GET['date']) && $_GET['date'] != '') ? $_GET['date'] : '',
                ));
                ?>
                <input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" />
                <input type="submit" value="Tìm" />
            </div>
        </form>
    </div>
</div>
<div style="clear: both;height: 20px;"></div>
<div class="box_content">
    <div>
        <?php
        $this->widget('application.widgets.admin.grid.CGridView', array(
            'id' => 'log-content',
            'dataProvider' => $model->search(),
            'titleText' => '<h4>Lịch sử từ ' . $fromDate . ' đến ' . $toDate . '</h4>',
            'columns' => array(
                array(
                    'header' => 'STT',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'htmlOptions' => array('width' => 30)
                ),
                array(
                    'header' => 'Số điện thoại',
                    'value' => '$data->user_phone',
                ),
                array(
                    'header' => 'Thời gian giao dịch',
                    'value' => '$data->created_time',
                ),
                array(
                    'header' => 'Loại giao dịch',
                    'value' => array($this, 'getTransaction'),
                ),
                array(
                    'header' => 'Tên nội dung',
                    'value' => '$data->obj1_name',
                ),
                array(
                    'header' => 'Trạng thái',
                    'value' => '$data->return_code==0?"Thành công":"Thất bại"',
                ),
                array(
                    'header' => 'Kênh thực hiện',
                    'value' => '$data->channel',
                ),
                array(
                    'header' => 'Cước phí',
                    'value' => '$data->price',
                ),
            ),
        ));
        ?>
    </div>
</div>
</div>
