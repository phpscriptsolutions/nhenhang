<?php
$submenu = include  '_submenu.php';
$controller = $this->getId();
$action = $this->action->id;
switch ($controller){
	case "setting":
	case "authitem":
	case "users":
	case "config":
	case "pushNotifSetting":
	case "package":
	case "emailTemplate":
	case "cp":
	case "ccp":
	case "adminUser":
	case "kpi":
		$group = "system";
		if("profile" == $action){			
			$group = "admin-user";
		}
		break;
	case "webuser":
		$group = "report";
		break;
	case "songFeature":
		$group = "song";
		break;
	case "news":
	case "html":
	case "banner":
	case "newsEvent":
		$group = "cms";
		break;
	case "userSubscribe":
	case "userLog":
	case "transLog":
		$group = "user";
		break;
	case "album":
		$group = 'album';
		if($action == "view" || $action=="update"){
			$group = "album_detail";
		}
		break;

	case "importUpload":
	case "importSongFile":
	case "importSong":
		$module = $this->module->id;
		if($module=='tools'){
			$group = "tools";
		}
		break;
	case "admin":
	default:
		$group = $controller;
		break;
}
$module = isset($this->module) ? $this->module->id : '';

$links = isset($submenu[$group])?$submenu[$group]:array();
if($group == 'reports'){
	$menu =  include '_menu.php';
	foreach($menu as $menu){
		if(isset($menu['key']) && $menu['key'] =='reports'){
			$links = $menu;
			break;
		}
	}
}

echo '<h6 id="h-menu-products" class="selected">
<a href="#"><span>'. ucfirst($this->getId()). '</span></a>
</h6>';
if(!empty($links) && $group != "admin-user")
{	
		$this->widget('application.widgets.admin.menu.SMenu',
								array(
								"menu"=>$links,
								"stylesheet"=>"menu_blue.css",
								"menuID"=>"sub_menu",
								"delay"=>3,
								"isSub"=>true
								)
		);

}
?>

