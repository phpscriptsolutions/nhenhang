<?php
/**
 * unauthorized.php
 *
 * @author Spyros Soldatos <spyros@valor.gr>
 * @link http://code.google.com/p/srbac/
 */

/**
 * Default page shown when a not authorized user tries to access a page
 *
 * @author Spyros Soldatos <spyros@valor.gr>
 * @package srbac.views.authitem
 * @since 1.0.2
 */
?>


<div class="title-box search-box">
	<a href="#" class="search-button">Thông báo</a>
</div>
<div class="content-body pt20 pl10 pb10 h220">
	<h2 style="color: red">
	<?php //echo "Error:".$error["code"]." '".$error["title"]."'" ?>
	<?php echo Yii::t('admin','Bạn không có quyền truy cập module này'); ?>
	</h2>
	<p>
	<?php //echo $error["message"] ?>
	</p>
</div>




