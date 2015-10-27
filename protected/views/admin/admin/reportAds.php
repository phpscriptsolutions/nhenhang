<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="vi" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/login.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery');   ?>

    </head>

    <body>
    <?php 
    $curentUrl =  Yii::app()->request->getRequestUri();
    $link1 = $curentUrl."&s=1&export=1";
    $link2 = $curentUrl."&s=2&export=1";
    ?>
        <div id="page" class="container">
            <div class="wrapper" style="margin:10px auto; width: 80%!important;">
            	<div id="slg">
            	</div>
            	<div class="box-t-l">
            		<div class="box-t-r">
            			<div class="box-t">
            				<h3 style="text-align: center;color: #FFF;line-height: 40px;margin: 0">
            				<?php if(Yii::app()->request->getParam('date',false)):?>
            				<a href="<?php echo Yii::app()->createUrl("admin/reportAds",array('type'=>strtolower($ads)))?>"  style="float: left; color: #FFF; text-decoration: none;">
            				&laquo;&laquo; Xem tất cả</a>
            				<?php endif;?>
            				Thống kê banner <?php echo $ads?>
            				<a href="<?php echo $link1?>" style="float: right; color: #FFF; text-decoration: none;"> Export &raquo;&raquo; </a>
            				</h3>
            			</div>
            		</div>
            	</div>
            	<div class="box-m">
            	
            	
            	   <!-- BEGIN CONTENT -->
            	   <?php
					$this->pageLabel = Yii::t("admin","Thống kê banner");
					$cs=Yii::app()->getClientScript();
					$cs->registerCoreScript('jquery');
					$cs->registerCoreScript('bbq');
					
					$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
					$cssFile=$baseScriptUrl.'/styles.css';
					$cs->registerCssFile($cssFile);
					$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
					$cs->registerCssFile(Yii::app()->theme->baseUrl."/css/report.css");
					$date = Yii::app()->request->getParam('date',null);
					$click_total=$click_unique=$click_detect=$click_detect_unique=$total_subs_success=$total_subs_fail;
					?>
					<div class="content-body grid-view">
					<div class="clearfix"></div>
					<table width="100%" class="items">
						<tr>
							<th>Ngày</th>
							<th>Tổng số click</th>
							<th>Số click ko trùng IP</th>
							<th>Số click Nhận diện được</th>
							<th>Số click Nhận diện Ko trùng Ip</th>
							<th>Số đăng ký thành công</th>
							<th>Số đăng ký thất bại</th>
						</tr>
						<?php if(!$date):
							$inday = $inday[0];
							$click_total += $inday['click_total'];
							$click_unique += $inday['click_unique'];
							$click_detect += $inday['click_detect'];
							$click_detect_unique += $inday['click_detect_unique'];
							$total_subs_success += $inday['total_subs_success'];
							$total_subs_fail += $inday['total_subs_fail'];						
						?>
						<tr class="even">
							<td><?php echo $inday['date']?></td>
							<td><?php echo $inday['click_total']?></td>
							<td><?php echo $inday['click_unique']?></td>
							<td><?php echo $inday['click_detect']?></td>
							<td><?php echo $inday['click_detect_unique']?></td>
							<td><?php echo $inday['total_subs_success']?></td>
							<td><?php echo $inday['total_subs_fail']?></td>
						</tr>
						<?php 
						endif;
						$i=0;
						foreach ($data as $data):
						?>
						<tr class="<?php echo ($i%2==0)?"odd":"even";?>">
							<td><a href="<?php echo Yii::app()->createUrl("admin/reportAds",array('type'=>strtolower($ads),'date'=>$data['date']))?>"><?php echo $data['date']?></a></td>
							<td><?php echo $data['click_total']?></td>
							<td><?php echo $data['click_unique']?></td>
							<td><?php echo $data['click_detect']?></td>
							<td><?php echo $data['click_detect_unique']?></td>
							<td><?php echo $data['total_subs_success']?></td>
							<td><?php echo $data['total_subs_fail']?></td>
						</tr>
						<?php 
							$click_total += $data['click_total'];
							$click_unique += $data['click_unique'];
							$click_detect += $data['click_detect'];
							$click_detect_unique += $data['click_detect_unique'];
							$total_subs_success += $data['total_subs_success'];
							$total_subs_fail += $data['total_subs_fail'];
							$i++;
							endforeach;
						?>
						<tr>
							<td style="background: #D54E21!important;"><b>Tổng số</b></td>
							<td style="background: #5ec411!important;"><?php echo $click_total ?></td>
							<td style="background: #5ec411!important;"><?php echo $click_unique ?></td>
							<td style="background: #5ec411!important;"><?php echo $click_detect ?></td>
							<td style="background: #5ec411!important;"><?php echo $click_detect_unique ?></td>
							<td style="background: #5ec411!important;"><?php echo $total_subs_success ?></td>
							<td style="background: #5ec411!important;"><?php echo $total_subs_fail ?></td>
						</tr>
					</table>
					</div>
            	   <!-- END CONTENT -->
            	   
            	   
            	   
            	</div>
                <div class="box-f-l">
                	<div class="box-f-r">
                		<div class="box-f">
                		</div>
                	</div>
                </div>
            </div>
            
            
            <div class="wrapper" style="margin:10px auto; width: 80%!important;">
            	<div id="slg">
            	</div>
            	<div class="box-t-l">
            		<div class="box-t-r">
            			<div class="box-t">
            				<h3 style="text-align: center;color: #FFF;line-height: 40px;margin: 0">Danh sách IP click trùng
            				<a href="<?php echo $link2?>" style="float: right; color: #FFF; text-decoration: none;"> Export &raquo;&raquo;</a>
            				</h3>
            			</div>
            		</div>
            	</div>
            	<div class="box-m">
            	   <!-- BEGIN CONTENT -->
					<div class="content-body grid-view">
					<div class="clearfix"></div>
					<table width="100%" class="items">
						<tr>
							<th>Ngày</th>
							<th>Ip</th>
							<th>Số click</th>
						</tr>
						<?php $i=0; foreach ($listIP as $data):
							if($data['total'] <= 1) continue;
						?>						
						<tr class="<?php echo ($i%2==0)?"odd":"even";?>">
							<td><?php echo $data['m']?></td>
							<td><?php echo $data['user_ip']?></td>
							<td><?php echo $data['total']?></td>
						</tr>
						<?php $i++;endforeach;?>
					</table>
					</div>
            	   <!-- END CONTENT -->
            	   
            	   
            	   
            	</div>
                <div class="box-f-l">
                	<div class="box-f-r">
                		<div class="box-f">
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </body>
</html>



