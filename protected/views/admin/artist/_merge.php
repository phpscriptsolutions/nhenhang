<?php
$linkSubmit = Yii::app()->createUrl('artist/merge');
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>"dialog",
                'options'=>array(
                    'title'=>Yii::t('admin','Xóa ca sỹ'),
                    'autoOpen'=>false,
                    'modal'=>'true',
                    'width'=>'450px',
                    'height'=>'auto',
                		'buttons' => array(
                				'Close'=>'js:function(){$(this).dialog("close")}',
                				'Xác nhận'=>'js:function(){
                					var artists = $("#a_ids").val();
                					if(artists == ""){
                						alert("Chua chon ca sỹ"); return false;
									}
                					var orgId = $("#org_id").val();
								    $.ajax({
								        url: "'.$linkSubmit.'",
								        data: {org_id:orgId,change_id:artists},
                						beforeSend:function(){
											$("#ajax-loadding").show();
                                        },
								        success: function(data) {
                							 if($.trim(data) == "success"){
                								window.location.reload( true );
											 }else if($.trim(data)=="fail"){
                								alert("Ca sỹ này đang có album chưa xóa được");
                    						 }else{
                								alert("Lỗi khi chuyển đổi dữ liệu cho ca sỹ");
											 }
                							$("#ajax-loadding").hide();
								        }
								    });
                					return false;
			                    	$(this).dialog("close");

			                    }'

                		),
                ),
                ));


$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl('artist/merge'),
    'method'=>'post',
    'htmlOptions'=>array('id'=>'merge_artist_form'),
));
?>
<div class="form">
	<div>Bạn đang xóa ca sỹ <b id="artist_name"></b>
	<p>Toàn bộ bài hát, video thuộc ca sỹ này sẽ được chuyển sang các ca sỹ:</p>
	<div id="ajax-loadding" style="display: none;"><img src="<?php echo Yii::app()->request->baseUrl?>/images/ajax-process.gif" /></div>
	</div>
	<br />
	<input type="hidden" id="org_id" />
	<input type="hidden" id="url_merge" value="<?php echo Yii::app()->createUrl('artist/getByName')?>" />
	<input type="hidden" id="a_ids" />
	<div>
		<table width="100%">
			<tr>
				<td valign="top">
					<span>Danh sách ca sỹ</span>
					<input type="text" id="artist-search" class="artist_list" placeholder="<?php echo Yii::t('admin','Nhập tên ca sỹ'); ?>" style="width: 150px" />
					<select id="artist_list" size ="4" style="width: 156px">

					</select>
				</td>
				<td valign="top" style="vertical-align:top">
					<button onclick="left2right();" type="button" style="margin-top: 25px;">>></button>
	                <button onclick="right2left();" type="button"><<</button>
				</td>
				<td valign="top">
					<span>Ca sỹ được chọn</span>
					<select id="artist_ids" size ="5" style="width: 150px">

					</select>
				</td>
			</tr>
		</table>
		<?php /*
		<div class="clb"></div>
		<hr />
		<p>Album sẽ được chuyển sang ca sỹ:</p>
		 <?php
                $artist = CHtml::listData(AdminArtistModel::model()->published()->findAll(), 'id', 'name');
                echo CHtml::dropDownList("album_artist_id", "", $artist,array('style'=>"width:250px"))
           ?>
           */?>

	</div>
 </div>
<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
