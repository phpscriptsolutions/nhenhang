<?php

class StoryModel extends BaseStoryModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Story the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function countStoryByCategory($categorySlug=null,$select = null,$isHot = false){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_slug=:categorySlug';
			$criteria->params = array(
				':categorySlug'=> $categorySlug
			);
		}

		if($isHot){
			$criteria->addCondition('hot=1');
		}

		return self::model()->count($criteria);
	}

	public function getStoryByCategory($categorySlug=null,$limit=12,$offset = 0,$select = null,$isHot = false){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_slug=:categorySlug';
			$criteria->params = array(
				':categorySlug'=> $categorySlug
			);
		}
		if($isHot){
			$criteria->addCondition('hot=1');
		}

		$criteria->limit = $limit;
		$criteria->offset = $offset;

		return self::model()->findAll($criteria);
	}

	public function countFullStoryByCategory($categorySlug=null,$select = null,$isHot = false){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_slug=:categorySlug AND status=:status';
			$criteria->params = array(
				':categorySlug'=> $categorySlug,
				':status' => 'Full'
			);
		}else{
			$criteria->condition = 'status=:status';
			$criteria->params = array(
				':status' => 'Full'
			);
		}

		if($isHot){
			$criteria->addCondition('hot=1');
		}

		return self::model()->count($criteria);
	}

	public function getFullStoryByCategory($categorySlug=null,$limit=12,$offset = 0,$select = null,$isHot = false){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_slug=:categorySlug AND status=:status';
			$criteria->params = array(
				':categorySlug'=> $categorySlug,
				':status' => 'Full'
			);
		}else{
			$criteria->condition = 'status=:status';
			$criteria->params = array(
				':status' => 'Full'
			);
		}
		if($isHot){
			$criteria->addCondition('hot=1');
		}
		$criteria->limit = $limit;
		$criteria->offset = $offset;

		return self::model()->findAll($criteria);
	}
}