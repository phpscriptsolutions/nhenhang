<?php

class Slidebar extends CWidget {

    public $controller;
    public $action;
    public $module;
    public $type;

    public function run() {
        $data = $this->_getdata($this->type, $this->controller, $this->action, $this->module);
        if ($this->type == "menu") {
            $this->widget(
                    'application.widgets.VMenu', array(
                'items' => $data,
                'htmlOptions' => array('id' => 'quick'),
            ));
        } else {
            $this->widget('zii.widgets.CMenu', array(
                'items' => $data,
                'htmlOptions' => array('class' => 'operations'),
            ));
        }
    }

    private function _getdata($type, $controller, $action = "index", $module = null) {
        $songType = Yii::app()->request->getParam('AdminSongModel');
        $songType = (isset($songType['status']) && $songType['status'] != "") ? $songType['status'] : AdminSongModel::ALL;

        $videoType = Yii::app()->request->getParam('AdminVideoModel');
        $videoType = (isset($videoType['status']) && $videoType['status'] != "" ) ? $videoType['status'] : AdminVideoModel::ALL;

        $albumType = Yii::app()->request->getParam('AdminAlbumModel');
        $albumType = (isset($albumType['status']) && $albumType['status'] != "" ) ? $albumType['status'] : AdminAlbumModel::ALL;

        $rtType = Yii::app()->request->getParam('AdminRingtoneModel');
        $rtType = (isset($rtType['status']) && $rtType['status'] != "" ) ? $rtType['status'] : AdminRingtoneModel::ALL;

        $id = Yii::app()->request->getParam('id');

        $path = Yii::getPathOfAlias('application.views.admin.layouts');
        /*if (isset($this->getController()->cpId) && $this->getController()->cpId == 0) {
            $data = include($path . DIRECTORY_SEPARATOR . 'menu.php');
        } else if(isset($this->getController()->cpId)) {
            $data = include($path . DIRECTORY_SEPARATOR . 'menu_cp.php');
        }else{
        	return array();
        }*/

        if (isset(Yii::app()->user->cp_id) && Yii::app()->user->cp_id == 0) {
            $data = include($path . DIRECTORY_SEPARATOR . 'menu.php');
        } else if(isset(Yii::app()->user->cp_id)) {
            $data = include($path . DIRECTORY_SEPARATOR . 'menu_cp.php');
        }else{
        	return array();
        }

        $menu = array();
        if ($type == "menu") {
            foreach ($data as $key => $val) {
                $sub1 = array();
                foreach ($val as $v) {
                    $sub1[] = array(
                        'label' => $v['index']['label'],
                        'url' => $v['index']['url'],
                        'items' => isset($v['index']['items']) ? $v['index']['items'] : "",
                    	"visible"=>isset($v['index']['visible'])?$v['index']['visible']:true
                    );
                }
                $first = array_shift($val);

                $menu[] = array(
                    'label' => Yii::t('admin', $key),
                    'url' => $first['index']['url'],
                    'items' => $sub1
                );
            }
        } else {
            $menu = array(
                array(
                    'label' => Yii::t('admin', 'Về trang chủ'),
                    'url' => array('/'),
                ),
            );

            foreach ($data as $key => $val) {
                // fake controller name
                $controllerfak = $this->_fakename($controller, $action, $module);

                if ($controller == "artist" && ($action == "songlist" || $action == "videolist" || $action == "albumlist")) {
                    $action = "update";
                }
                if($controllerfak == 'musicgift'){
                	$action = "index";
                }

                if (!empty($val[$controllerfak][$action]['items'])) {
                    $menu = $val[$controllerfak][$action]['items'];
                    break;
                } else {
                    if (!empty($val[$controllerfak])) {
                        $sl = array();
                        foreach ($val as $rel) {
                            $sl[] = $rel['index'];
                        }
                        $menu = $sl;
                        break;
                    }
                }
            }
        }
        //echo "<pre>";print_r($menu);exit();
        return $menu;
    }

    function _fakename($controller, $action, $module) {
        if ($controller == "report") {
            switch ($action) {
                case "index":
                    $controller = "report1";
                    break;
                case "revenue":
                    $controller = "report2";
                    break;
                case "content":
                    $controller = "report3";
                    break;
                case "subscriber":
                    $controller = "report4";
                    break;
            }
        }

        if ($controller == "ringtoneCategory")
            $controller = "ringtone";
        if ($controller == "ringbacktoneCategory")
            $controller = "ringbacktone";
        if ($controller == "songFeature")
            $controller = "song";
        if ($controller == "playlistFeature")
            $controller = "playlist";
        if ($controller == "videoFeature")
            $controller = "video";
        if ($controller == "albumFeature")
            $controller = "album";
        if ($controller == "rbtFeature")
            $controller = "ringbacktone";
        if ($controller == "featureRingtone")
            $controller = "ringtone";
        if ($controller == "rbtCollection")
            $controller = "ringbacktone";
        if ($controller == "rbtArtist")
            $controller = "ringbacktone";
        if ($controller == "rbtNew")
            $controller = "ringbacktone";
        if ($controller == "rbtDownload")
            if ($action == "report")
                $controller = "ringbacktone";
        if ($controller == "rbtCategory")
            $controller = "ringbacktone";

        if ($controller == "banner")
            if ($action == "index")
                $controller = "html";

        if ($controller == "newsEvent")
            if ($action == "index")
                $controller = "html";

        if(isset($_GET['channel']) && $_GET['channel'] == 'web')
            $controller = "web";

        if (in_array(strtolower($controller), array('mgchannel','smsconfig','adminmggift','reportsmg')))
            $controller = "musicgift";

        if ($module == "srbac")
            $controller = "srbac";
        return $controller;
    }

    /* /// Khong dung
      function _getsubmenu($item,$group="")
      {
      $path = Yii::getPathOfAlias('application.views.admin.layouts');
      $data =  include($path . DIRECTORY_SEPARATOR . 'menu.php');
      foreach($data as $data){
      if($group!="" && $data['index']==$group){
      foreach($data['items'] as $subData){
      if($subData['index'] == $item){
      return 	$subData['items'];
      }
      }
      }else{
      if($data['index']==$item)
      return 	$data['items'];
      }
      }
      return array();
      }
     */
}

