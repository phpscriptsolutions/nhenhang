<?php
header("Content-type: text/javascript");
// LOAD LANGUAGE AND FUNCTION FOR JAVASCRIPT
echo "var LANG = [] ;\n";
if(!empty($data)){
	foreach($data as $key=>$val){
		$key = addslashes($key);
		$val = addslashes($val);
		echo "LANG['$key']='$val';";
	}
}
echo "\n";
$script = "function __t(key) { if(LANG[key]){ return LANG[key]; }return key;}\n";
echo $script;
echo "\n";
echo AvatarHelper::getAvatarJs();
echo "\n";

// DEFINE URL FOR JAVASCRIPT
echo "var base_url = '".Yii::app()->homeUrl."'\n";
echo "var ajax_url = '".Yii::app()->createUrl("ajax")."'\n";
echo "var user_url = '".Yii::app()->createUrl("user/detail")."'\n";
echo "var popup_login_url = '".Yii::app()->createUrl("user/loginPopup")."'\n";
echo "var popup_promotion = '".Yii::app()->createUrl("user/promotion")."'\n";
echo "var ajax_loading='".Yii::app()->request->baseUrl."/web/images/content_loading.gif'\n";
echo "var time_play_loging='10000'\n";//10 giây
echo "var has_key='".Yii::app()->params["hash_url"]."'\n";
echo "var link_url='".Yii::app()->getBaseUrl(true)."'\n";

