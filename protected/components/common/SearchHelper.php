<?php
$path = Yii::getPathOfAlias("application.vendors");

require_once($path . '/Apache/Solr/Service.php');
require_once($path  . '/Apache/Solr/HttpTransport/Curl.php');
class SearchHelper
{
    protected static $_instance = null;


    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	public function search($keyword,$type='song',$limit=10,$offset=0, $searchLike=false)
	{
		$keyword = Formatter::clean($keyword);
        // search params
        $params = array();
        $params['fq'] = 'type:'.$type;

        // Uu tien nhac cho cua Vega va Minh Phuc
        if($type=="rbt") {
			$searchLike = true;
			//$params['bq'] = array("code:80*^2", "code:81*^2", "code:84*^2", "code:64*");
			$params['bq'] = array("content_owner:VEGA^2");
		}

		//$keyword = Apache_Solr_Service::phrase($keyword);
		if($searchLike) {
			$params['qt'] = "/like";
		}
		$params['sort'] = "score desc, played_count desc";

		$solr = $this->_getSolr();
		$rs = $solr->search($keyword, $offset * $limit, $limit, $params);
		$response = $rs->response;
		return $response;
	}

	public function searchCustom($keyword,$pagesize=10,$option=array())
	{
		$keyword = Formatter::clean($keyword);
		//$keyword = Apache_Solr_Service::phrase($keyword);
		$solr = $this->_getSolr();
		$params = array('group' => 'true', 'group.limit' => $pagesize, 'group.field' => 'type');
		$params['sort'] = "score desc, played_count desc";

		$rs = $solr->search($keyword, 0, $pagesize, $params);
		return $rs;
	}

	private function _getSolr() {
		return new Apache_Solr_Service(
										yii::app()->params['solr.server.host'],
										yii::app()->params['solr.server.port'],
										yii::app()->params['solr.server.path'],
										new Apache_Solr_HttpTransport_Curl()
									);
	}

	public function copyAndCast($array, $mapping) {
		$rs = array();
		$prototype = array();
		foreach ($mapping as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $key2 => $index) {
					$prototype[$key2] = '';
				}
			}else
				$prototype[$value] = '';
		}
		foreach ($array as $item) {
			$cast = $prototype;
			foreach ($item as $key => $value) {
				if ($key == 'id') {
					$cast['id'] = substr($value, strlen($item->type));
				} elseif (array_key_exists($key, $mapping)) {
					$key = $mapping[$key];
					if (is_array($key)) {
						$value = explode('|', $value);
						foreach ($key as $key2 => $index) {
							$cast[$key2] = $value[$index];
						}
					}else
						$cast[$key] = $value;
				}else
					$cast[$key] = $value;
			}
			$rs[] = $cast;
		}

		return $rs;
	}
}
