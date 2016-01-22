<?php

class QuotevStoryModel extends BaseQuotevStoryModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return QuotevStory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStoryWithLastId($lastId=0,$limit=12,$offset = 0,$select = null,$isHot = false,$isFull = null, $order = null){
			$criteria = new CDbCriteria();

			if(!empty($select)){
				$criteria->select = $select;
			}

			$criteria->condition = 'id > :lastId';
			$criteria->params = array(
				':lastId'=> $lastId
			);

			if($isHot){
				$criteria->addCondition('hot=1');
			}
			if($isFull){
				$criteria->addCondition('status="'.$isFull.'"');
			}

			if(empty($order)){
				$criteria->order = 'updated_time DESC';
			}else{
				$criteria->order = $order;
			}

			$criteria->limit = $limit;
			$criteria->offset = $offset;

			return self::model()->findAll($criteria);
		}
}
