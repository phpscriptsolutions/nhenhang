<?php /*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="vi" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/global.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/login.css" />
		<style type="text/css">
		#error-box{
		   	background: #FFFFFF;
		    border: 1px solid #DFDFDF;
		    border-radius: 3px 3px 3px 3px;
		    color: #333333;
		    font-family: sans-serif;
		    margin: 2em auto;
		    max-width: 500px;
		    padding: 1em 2em;
		}		
		</style>
    </head>

    <body>
        <div id="page" class="container">
            <div class="wrapper" id="error-box">
            	<?php 
            		$duration = isset($_GET['rank'])? (ceil($_GET['rank']/60)):Yii::app()->params['login']['time_block'];
            	?>
            	Bạn đã nhập sai password quá 5 lần.
            	Tài khoản của bạn đã bị block, hãy quay lại đăng nhập sau <?php echo $duration ?> phút
            </div>
        </div>
    </body>
</html>
*/?>
<div class="errorSummary">
<?php 
	$duration = isset($_GET['rank'])? (ceil($_GET['rank']/60)):Yii::app()->params['login']['time_block'];
?>
Bạn đã nhập sai password quá 5 lần.
Tài khoản của bạn đã bị block, hãy quay lại đăng nhập sau <?php echo $duration ?> phút
</div>