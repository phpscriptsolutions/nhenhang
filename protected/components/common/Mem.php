<?php
class Mem {
	/**
	 *
	 * class for memcached
	 * @param STRING $key
	 * @param value $key
	 * @return $mem
	 */
	public static function set($key,$data,$timeout= 1800) {
		$mem = Yii::app()->cache->set($key, $data, $timeout);
		return $mem;
	}

	public static function get($key) {
		$mem = Yii::app()->cache->get($key);
		return $mem;
	}
	public static function clear($key) {
		$mem = Yii::app()->cache->delete($key);
		return $mem;
	}
}
?>
