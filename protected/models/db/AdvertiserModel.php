<?php

class AdvertiserModel extends BaseAdvertiserModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Advertiser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function countAdvertiser($cp = null){
		$criteria = new CDbCriteria();
		if(!empty($cp)){
			$criteria->condition = 'cp=:cp';
			$criteria->params = array(
				':cp' => $cp
			);
		}

		return self::model()->count($criteria);
	}

	public function getAdvertiser($cp = null, $limit = 10,$offset = 0, $order = 'created_time DESC'){
		$criteria = new CDbCriteria();
		if(!empty($cp)){
			$criteria->condition = 'cp=:cp';
			$criteria->params = array(
				':cp' => $cp
			);
		}

		$criteria->order = $order;

		$criteria->limit = $limit;
		$criteria->offset = $offset;


		return self::model()->findAll($criteria);
	}
}