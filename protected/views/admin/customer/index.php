<?php
Yii::import('application.components.common.Utility');
$js = Yii::app()->clientScript;
$js->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin/base.js', CClientScript::POS_END);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<div class="search-form">
<div class="filter form fft">
	<form action="" method="get" id="viewlog">
		<input type="hidden" value="customer/index" name="r">
		<div class="row">
		<label>Số điện thoại:</label>
			<input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" /><input type="submit" value="Tìm" />
		</div>
	</form>
</div>
</div>
    <div class="grid-view" id="menu-grid">       
        <!-- Gói PHIM-->
        <b>Gói AMUSIC (AM)</b><br/>
        <table class="items">
            <thead>
                <tr>
                    <th style="width: 130px;"><?php echo Yii::t('admin_customer', 'Phone number'); ?></th>
                    <th style="width: 100px;"><?php echo Yii::t('admin_customer', 'Status'); ?></th>
                    <th style="width: 100px;"><?php echo Yii::t('admin_customer', 'Package'); ?></th>
                    <th style="width: 60px;">Gia hạn</th>
                    <th style="width: 100px;">Kênh đăng ký</th>
                    <th style="width: 150px;"><?php echo Yii::t('admin_customer', 'Thời gian đăng ký'); ?></th>
                    <th style="width: 150px;"><?php echo Yii::t('admin_customer', 'Thời gian hết hạn'); ?></th>
                </tr>
            </thead>
        <tbody>
        <?php if (!empty($subscribe)) { ?>
            <tr class="odd">
                <td><?php echo $subscribe->user_phone; ?></td>
                <td><?php echo ($subscribe->status == 1) ? Yii::t('admin_customer', 'Subscribed') : Yii::t('admin_customer', 'Not subscribe'); ?></td>
                <td><?php echo AdminPackageModel::model()->findbyPk($subscribe->package_id)->name;?></td>
                <td><?php echo $subscribe->status == 1 ? 'Có' : 'Không';?></td>
                <td><?php echo $subscribe->source;?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($subscribe->created_time)); ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($subscribe->expired_time)); ?></td>
            </tr>
        <?php } elseif($msisdn != 0) { ?>
            <tr>
                <td colspan="7"><?php echo Yii::t('admin_customer', 'No match result'); ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="7"><?php echo Yii::t('admin_customer', 'No match result'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>      
    </div>
