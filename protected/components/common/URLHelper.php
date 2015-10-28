<?php
class URLHelper {
    /**
     * @param string $controller
     * @param integer $id
     * @param string $url_key
     *
     * Ex: 	buildFriendlyURL('song',1,'hello') -> /song/hello,1.html
     * 		buildFriendlyURL('song',1) -> /song/detail/1
     */
    static function buildFriendlyURL($controller, $id, $url_key = null) {
        if ($url_key == 'list')
            return "/{$controller}/$url_key";
        if ($url_key == "list/artist")
            return "/$controller/$url_key/$id";
        if ($controller == 'user')
            return '/user/profile/' . $id;

        return '/' . $controller . ($url_key ? "/$url_key,$id.html" : "/detail/$id");
    }

    static function buildXmlURL($table, $page = null) {
        if ($page)
            return Yii::app()->createUrl("sitemap/xml", array('t' => $table, 'p' => $page));
        else
            return Yii::app()->createUrl("sitemap/xml", array('t' => $table));
    }
    
    public static function  makeUrl($object)
    {
    	Yii::import("application.vendors.Hashids.*");
    	$hashids = new Hashids(Yii::app()->params["hash_url"]);
    	
    	$prefix = $sufix = "";
		$id = $hashids->encode($object["id"]);

    	if(isset($object["obj_type"])){
    		switch ($object["obj_type"]) {
    			/*case "album":
    				$prefix = "album-";
    				$suffix = "ab";
    				break;
    			case "playlist":
    				$prefix = "playlist-";
    				$suffix = "pl";
    				break;
				case "user_playlist":
					$prefix = "playlist-";
					$suffix = "pu";
					break;
    			case "song":
    				$suffix = "so";
    				break;
    			case "video":
    				$suffix = "mv";
    				break;
				case "playall_song_bxh":
					$prefix = "";
					$suffix = "cs";
					break;
				case "playall_song_artist":
					$prefix = "nhung-bai-hat-hay-nhat-cua-";
					$suffix = "ca";
					break;
				case "html_view":
					$prefix = "html-";
					$suffix = "hl";
					break;
				case "bxh":
					$prefix = "bang-xep-hang-";
					$suffix = "bx";
					break;*/

				case "category":
					$prefix = "truyen-";
					$suffix = "tr";
					break;
    		}
    	}
		$urlKey = $prefix.$object["slug"];
		$params = array("url_key" => $urlKey,"code"=>$suffix.$id);
		if(isset($object['other'])){
			foreach($object['other'] as $key => $ac){
				$params[$key]=$ac;
			}
		}
    	$link = Yii::app()->createAbsoluteUrl("site/url", $params);
    	return $link;
    }
	public static function makeUrlChart($object)
	{
		$dataBxhId = array(
			'song_VN'=>1,
			'song_KOR'=>2,
			'song_QTE'=>3,
			'video_VN'=>4,
			'video_KOR'=>5,
			'video_QTE'=>6,
			'album_VN'=>7,
			'album_KOR'=>8,
			'album_QTE'=>9
		);
		Yii::import("application.vendors.Hashids.*");
		$hashids = new Hashids(Yii::app()->params["hash_url"]);
		$prefix = 'bang-xep-hang-';
		if($object['type']=='song'){
			$s = 'bai-hat';
		}elseif($object['type']=='video'){
			$s = 'video';
		}else{
			$s = 'album';
		}
		switch($object['genre'])
		{
			case 'VN':
				$urlKey = 'bang-xep-hang-'.$s.'-viet-nam';
				break;
			case 'QTE':
				$urlKey = 'bang-xep-hang-'.$s.'-au-my';
				break;
			case 'KOR':
				$urlKey = 'bang-xep-hang-'.$s.'-han-quoc';
				break;
		}
		$suffix = 'bx';
		$code = $hashids->encode($dataBxhId[$object['type'].'_'.$object['genre']]);
		$code = $suffix.$code;
		$link = Yii::app()->createAbsoluteUrl("site/url", array("url_key" => $urlKey,"code"=>$code));
		return $link;
	}
	public static function makeUrlGenre($object)
	{
		Yii::import("application.vendors.Hashids.*");
		$hashids = new Hashids(Yii::app()->params["hash_url"]);
		$type = $object['type'];
		$name = $object['name'];
		$id = $object['id'];
		$gt = isset($object['gt'])?$object['gt']:'';
		$suffix = 'gr';
		$code = $hashids->encode($id);
		$code = $suffix.$code;
		$prefix = 'nhac-';
		$urlKey = $prefix.Common::makeFriendlyUrl($name);
		if($type=='song'){
			$type='bai-hat';
		}
		$params = array("action"=>$type,"url_key" => $urlKey,"code"=>$code);
		if(!empty($gt)){
			if($gt=='new') $gt='moi';
			$params['gt']=$gt;
		}
		if(isset($object['other'])){
			foreach($object['other'] as $key => $ac){
				$params[$key]=$ac;
			}
		}
		$link = Yii::app()->createAbsoluteUrl("site/url2", $params);
		return $link;
	}
	public static function makeUrlMultiLevel($object)
	{
		Yii::import("application.vendors.Hashids.*");
		$hashids = new Hashids(Yii::app()->params["hash_url"]);
		$params = array();
		$params['action'] = '';
		if(isset($object['type'])){
			$params['action'] = $object['type'];
		}
		$name = $object['name'];
		$id = $object['id'];
		$gt = isset($object['gt'])?$object['gt']:'';
		$objectType = isset($object['object_type'])?$object['object_type']:"genre";
		$route = "site/url2";
		switch($objectType)
		{
			case 'artist_view':
				$prefix = '';
				$suffix = 'at';
				$params['action'] = 'nghe-si';
				if(isset($object['other']['tab'])) {
					if($object['other']['tab']=='song'){
						$ac = 'bai-hat';
					}elseif($object['other']['tab']=='mv'){
						$ac = 'video';
					}elseif($object['other']['tab']=='info'){
						$ac = 'tieu-su';
					}else{
						$ac = $object['other']['tab'];
					}
					$params['action_sub'] = $ac;
					unset($object['other']['tab']);
					$route = "site/url3";
				}
				break;
			case 'artist_index':
				$prefix = '';
				$suffix = 'ai';
				$params['action'] = 'nghe-si';
				break;
			case 'topcontent_view':
				$prefix = '';
				$suffix = 'tv';
				$params['action'] = 'hot-list';
				break;
			case 'topcontent_tag':
				$prefix = '';
				$suffix = 'tt';
				$params['action'] = 'hot-list';
				$params['action_sub'] = $object['type'];
				$route = "site/url3";
				break;
			case 'tag_index':
				$prefix = '';
				$suffix = 'ti';
				$params['action'] = 'tag';
				if(isset($object['type'])) {
					if($object['type']=='song'){
						$ac = 'bai-hat';
					}elseif($object['type']=='mv'){
						$ac = 'video';
					}elseif($object['type']=='info'){
						$ac = 'tieu-su';
					}else{
						$ac = $object['type'];
					}
					$params['action_sub'] = $ac;
					$route = "site/url3";
				}
				break;
			default://genre
				$suffix = 'gr';
				if(!empty($gt) && $gt=='new'){
					$gt='moi';
				}
				break;
		}
		$code = $hashids->encode($id);
		$code = $suffix.$code;
		$urlKey = Common::makeFriendlyUrl($name);
		$params['url_key'] = $urlKey;
		$params['code'] = $code;
		if(!empty($gt)){
			$params['gt']=$gt;
		}
		if(isset($object['other'])){
			foreach($object['other'] as $key => $ac){
				$params[$key]=$ac;
			}
		}
		//echo '<pre>';print_r($params);exit;

		$link = Yii::app()->createAbsoluteUrl($route, $params);
		return $link;
	}
	public static function makeUrlArtistKey($object)
	{
		$genreId=$object['genreId'];
		$genreArtist = array(
			0=>'tat-ca',
			1=>'viet-nam',
			33=>'au-my',
			60=>'chau-a'
		);
		$keyword = $object['keyword'];
		$params = array(
			'genre_artist'=>$genreArtist[$genreId],
			'keyword'=>$keyword
		);
		$link = Yii::app()->createAbsoluteUrl('/site/UrlArtist', $params);
		return $link;
	}
}
