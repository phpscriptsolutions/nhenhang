<?php
$package = array(
		3=>'ChachaFun',
		5=>'RingtunePlus'
);
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH</title>
<style>
*{
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif
}
h4,.grid-view{
	margin: 0;
	padding:0
}
.box{
	margin-bottom: 30px;
	background-color: #EEE;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	padding: 10px;
}
.box .summary{
	text-align: left;
	background: #08C;
	padding: 5px;
	color: #FFF;
	overflow: hidden;
	margin: 0;
}
.grid-view table.items th {
color: #333;
background: #E4E2E2;
text-align: center;
}
.grid-view table.items th a {
color: #333;
font-weight: bold;
text-decoration: none;
}
.grid-view-loading{
	background-position: center bottom;
}
.grid-view table.items th{
	text-align: left;
}
.service_header h1{
	background: #1B1B1B;
	color: #CCC;
	font-size: 21px;
	padding: 10px;
	font-weight: normal;
}
.fft{
	overflow: hidden;
	background: #EEE;
	padding: 10px;
	border-radius: 6px;
}
</style>
<?php
$this->pageLabel = Yii::t("admin","Tra cứu log Thuê bao");
?>
<div class="service_header">
<h1>CSKH DỊCH VỤ </h1>
</div>
<div class="search-form">
<div class="filter form fft">
	<form action="" method="get" id="viewlog">
		<input type="hidden" value="admin/viewLog" name="r">
		<div class="row">
		<label>Số điện thoại:</label>
			<input type="text" name="phone" value="<?php echo $phone ?>" size="80" /><input type="submit" value="Tìm" />
		</div>
		<?php if($phone):?>
		<?php if($isAll!=1):?>
			<button style="float: left" name="all" value="1">Xem tất cả</button>
		<?php else:?>
			<button style="float: left" name="all" value="0">Xem 3 tháng gần đây</button>
		<?php endif;?>
		<?php endif;?>
	</form>
</div>
</div>
<div style="clear: both;height: 20px;"></div>
<?php if($phone):?>
<div class="box">
<div class="summary"><h4>Thông tin thuê bao <?php echo $phone ?></h4></div>
<div class="grid-view">

<table class="items">
<thead>
	<tr>
		<th>Số điện thoại</th>
		<th>Tình trạng</th>
		<th>Gói dịch vụ</th>
		<th>Ngày đăng ký</th>
		<th>Ngày hết hạn</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td><?php echo $phone ?></td>
		<td><?php echo ($subscribe->status==1)?"Đang hoạt động":"Không hoạt động"?></td>
		<td>
            <?php if($subscribe){
                $package = PackageModel::model()->findByPk($subscribe->package_id);
                if($package) echo $package->name;
            }?>
        </td>
		<td><?php if($subscribe){echo $subscribe->last_subscribe_time;}?></td>
		<td><?php if($subscribe){echo $subscribe->expired_time;}?></td>
	</tr>
</tbody>
</table>

</div>
</div>
<div class="box">
<div>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'log_dk_huy_all',
	'dataProvider'=>$modelDK->search(),
	'titleText'=>'<h4>Lịch sử đăng ký, huỷ dịch vụ của thuê bao <b>'.$phone.'</b></h4>',
	'columns'=>array(
			array(
					'header'=>'STT',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
			),
			array(
				'header'=>'Thời gian giao dịch',
				'value'=>'$data->created_time',
			),
			array(
				'header'=>'Loại giao dịch',
				'value'=>'$data->transaction=="subscribe"?"Đăng ký gói dịch vụ":"Hủy gói dịch vụ"',
			),
			array(
				'header'=>'Tên gói cước',
				'value'=>'PackageModel::model()->findByPk($data->package_id)->name',
			),
			array(
				'header'=>'Trạng thái',
				'value'=>'$data->return_code==0?"Thành công":"Không thành công"',
			),
			array(
				'header'=>'Nguồn',
				'value'=>'($data->channel=="vinaphone")?"api(vinaphone)":$data->channel',
			),
			array(
				'header'=>'Cước phí',
				'value'=>'$data->price',
			),
			/* array(
				'header'=>'Event',
				'type'=>'raw',
				'value'=>'($data->channel=="vinaphone")?$data->note:""',
			), */
		),
	));

?>
</div>
</div>
<div class="box">
<div>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'log_dk_huy',
	'dataProvider'=>$modelDKViNA->search(),
	'titleText'=>'<h4>Lịch sử đăng ký, hủy dịch vụ qua API của thuê bao <b>'.$phone.'</b></h4>',
	'columns'=>array(
			array(
				'header'=>'STT',
				'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
				'htmlOptions'=>array('width'=>30)
			),
			array(
					'header'=>'Thời gian giao dịch',
					'value'=>'$data->created_datetime',
			),
			array(
					'header'=>'Loại giao dịch',
					'value'=>'$data->type=="subscribe"?"Đăng ký gói dịch vụ":"Hủy gói dịch vụ"',
			),
			'application',
			array(
					'header'=>'UserName',
					'value'=>'$data->username',
			),
			array(
					'header'=>'UserIP',
					'value'=>'$data->clientip',
			),
			array(
					'header'=>'Nguồn',
					'value'=>'$data->channel',
			),
			array(
					'header'=>'Tên gói cước',
					'value'=>'$data->package_name',
			),
			array(
					'header'=>'Event',
					'type'=>'raw',
					'value'=>'$data->note',
			),
			array(
					'header'=>'Trạng thái',
					'value'=>'$data->error_id==0 || $data->error_id==4 || $data->error_id==3?"Thành công":"Không thành công"',
			),
			array(
					'header'=>'Cước phí',
					'type'=>'raw',
					'value'=>'($data->type=="subscribe" && ($data->error_id==0 || $data->error_id==4))?5000:0',
			),
			/* 'error_id',
			'error_desc', */
	),
));
?>
</div>
</div>
<div class="box">
<div>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'log-gia-han',
		'dataProvider'=>$modelRenew->search(),
		'titleText'=>'<h4>Lịch sử gia hạn của thuê bao <b>'.$phone.'</b></h4>',
		'columns'=>array(
				array(
					'header'=>'STT',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
				),
				array(
						'header'=>'Thời gian giao dịch',
						'value'=>'$data->created_time',
				),
				array(
						'header'=>'Loại giao dịch',
						'value'=>'"gia hạn gói cước"',
						'type'=>'raw'
				),
				array(
						'header'=>'Tên gói cước',
						'value'=>'$data->obj1_name',
				),
				array(
						'header'=>'Trạng thái',
						'value'=>'$data->return_code==0?"Thành công":"Thất bại"',
				),
				array(
						'header'=>'Kênh thực hiện',
						'value'=>'$data->channel',
				),
				array(
						'header'=>'Cước phí',
						'value'=>'$data->price',
				),
			),
		));
?>
</div>
</div>
<div class="box">
<div>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
				'id'=>'log-content',
				'dataProvider'=>$modelContent->search(),
				'titleText'=>'<h4>Lịch sử mua và tặng nội dung của thuê bao <b>'.$phone.'</b></h4>',
				'columns'=>array(
						array(
							'header'=>'STT',
							'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
							'htmlOptions'=>array('width'=>30)
						),
						array(
								'header'=>'Thời gian giao dịch',
								'value'=>'$data->created_time',
						),
						array(
								'header'=>'Loại giao dịch',
								'value'=>array($this,'getTransaction'),
						),
						array(
								'header'=>'Tên nội dung',
								'value'=>'$data->obj1_name',
						),
						array(
								'header'=>'Thể loại',
								'value'=>array($this,'getGenreName'),
						),
						array(
								'header'=>'Trạng thái',
								'value'=>'$data->return_code==0?"Thành công":"Thất bại"',
						),
						array(
								'header'=>'Kênh thực hiện',
								'value'=>'$data->channel',
						),
						array(
								'header'=>'Cước phí',
								'value'=>'$data->price',
						),
					),
				));
				?>
</div>
</div>
<div class="box">
<div>
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-user-mo-model-grid',
	'dataProvider'=>$smsMo->search(),
	'titleText'=>'<h4>Lịch sử tin nhắn MO của thuê bao <b>'.$phone.'</b></h4>',
	'columns'=>array(
			array(
					'header'=>'STT',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'htmlOptions'=>array('width'=>30)
			),
			array(
					'header'=>'Thời gian nhận',
					'value'=>'$data->receive_time',
			),
			array(
					'header'=>'MO',
					'value'=>'$data->keyword',
			),
			array(
					'header'=>'Nội dung',
					'value'=>'$data->content',
			),
		),
	));
?>
</div>
</div>
<div class="box">
<div>
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-user-mt-model-grid',
	'dataProvider'=>$smsMt->search(),
	'titleText'=>'<h4>Lịch sử tin nhắn MT của thuê bao <b>'.$phone.'</b></h4>',
	'columns'=>array(
			array(
					'header'=>'STT',
					'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'htmlOptions'=>array('width'=>30)
			),
			array(
					'header'=>'Thời gian gửi',
					'value'=>'$data->send_datetime',
					'htmlOptions'=>array('width'=>150)
			),
			array(
					'header'=>'Nội dung',
					'value'=>'$data->content',
			),
		),
	));
?>
</div>
</div>
<?php else:?>
<h3>Số điện thoại không hợp lệ.</h3>
<?php endif;?>