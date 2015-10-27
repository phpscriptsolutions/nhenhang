<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu log Thuê bao");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
            <input type="hidden" value="customer/subscriber" name="r">
            
            <div class="row">
            <?php
	            $this->widget('ext.daterangepicker.input', array(
	                'name' => 'songreport[date]',
	                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
	            ));
            ?>
            <select name="type" id="t" style="vertical-align: middle;" class="textbox">
                <optgroup label="<?php echo Yii::t('admin_customer', 'Customer info'); ?>">
                    <option value="0" <?php if ($type==0) echo ' selected'; ?>><?php echo Yii::t('admin', 'Tất cả'); ?></option>                
                    <option value="1" <?php if ($type==1) echo ' selected'; ?>><?php echo Yii::t('admin', 'Đăng ký'); ?></option>
                    <option value="2" <?php if ($type==2) echo ' selected'; ?>><?php echo Yii::t('admin', 'Hủy'); ?></option>
                </optgroup>
            </select>
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
                'id' => 'log_dk_huy_all',
                'dataProvider' => $model->search(),
                'titleText' => '<h4>Lịch sử đăng ký, huỷ dịch vụ của thuê bao <b>' . $msisdn . '</b></h4>',
                'columns' => array(
                    array(
                        'header' => 'STT',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    array(
                        'header' => 'Thời gian giao dịch',
                        'value' => '$data->created_time',
                    ),
                    array(
                        'header' => 'Loại giao dịch',
                        'value' => '$data->transaction=="subscribe"?"Đăng ký gói dịch vụ":"Hủy gói dịch vụ"',
                    ),
                    array(
                        'header' => 'Tên gói cước',
                        'value' => 'str_replace("success_","",$data->obj1_name)',
                    ),
                    array(
                        'header' => 'Trạng thái',
                        'value' => '$data->return_code==0?"Thành công":"Không thành công"',
                    ),
                    array(
                        'header' => 'Nguồn',
                        'value' => '($data->channel=="vinaphone")?"api(vinaphone)":$data->channel',
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
<?php else: ?>
    <h3>Số điện thoại không hợp lệ hoặc không phải Mobifone.</h3>
<?php endif; ?>