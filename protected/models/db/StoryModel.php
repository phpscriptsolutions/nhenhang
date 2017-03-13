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

	public function countStoryByCategoryId($cateId=null,$select = null,$isHot = false,$isFull = null){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_id=:categoryId';
			$criteria->params = array(
				':categoryId'=> $cateId
			);
		}

		if($isHot){
			$criteria->addCondition('hot=1');
		}

		if($isFull){
			$criteria->addCondition('status="'.$isFull.'"');
		}

		return self::model()->count($criteria);
	}

	public function getStoryByCategoryId($cateId=null,$limit=12,$offset = 0,$select = null,$isHot = false,$isFull = null, $order = null){
		$criteria = new CDbCriteria();

		if(!empty($select)){
			$criteria->select = $select;
		}

		if(!empty($categorySlug)){
			$criteria->condition = 'category_id=:categoryId';
			$criteria->params = array(
				':categoryId'=> $cateId
			);
		}
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

	public function countStoryByCategory($categorySlug=null,$select = null,$isHot = false, $isFull = null){
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
		if($isFull){
			$criteria->addCondition('status="'.$isFull.'"');
		}
		return self::model()->count($criteria);
	}

	public function getStoryByCategory($categorySlug=null,$limit=12,$offset = 0,$select = null,$isHot = false,$isFull = null, $order = null){
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

	public function getFullStoryByCategory($categorySlug=null,$limit=12,$offset = 0,$select = null,$isHot = false, $order = null){
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

		if(empty($order)){
			$criteria->order = 'updated_time DESC';
		}else{
			$criteria->order = $order;
		}
		$criteria->limit = $limit;
		$criteria->offset = $offset;

		return self::model()->findAll($criteria);
	}

	public function getStoryBySlug($slug){
		$criteria = new CDbCriteria();
		$criteria->condition = 'story_slug=:slug';
		$criteria->params = array(
			':slug'=> $slug
		);

		return self::model()->find($criteria);
	}

	public function getStoryByAuthor($author,$limit = 4){
		$criteria = new CDbCriteria();
		$criteria->condition = 'author=:author';
		$criteria->params = array(
			':author'=> $author
		);
		$criteria->limit = $limit;
		$criteria->order = 'RAND()';

		return self::model()->findAll($criteria);
	}

	public function countSearchByName($q){
		$crit = new CDbCriteria();
		$crit->condition = 'story_name like :q';
		$crit->params = array(
			':q'=>'%'.$q.'%'
		);

		return self::model()->count($crit);
	}

	public function getSearchByName($q,$limit,$offset){
		$crit = new CDbCriteria();
		$crit->select = 'id,category_name,category_slug,story_name,story_slug,lastest_chapter,hot,status';
		$crit->condition = 'story_name like :q';
		$crit->params = array(
			':q'=>'%'.$q.'%'
		);
		$crit->limit = $limit;
		$crit->offset = $offset;

		return self::model()->findAll($crit);
	}

	public function getStoryWithLastId($lastId=0,$limit=12,$offset = 0,$select = null,$isHot = false,$isFull = null, $order = null,$categoryId = null){
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

		if(!empty($categoryId)){
			if(!is_array($categoryId)){
			  $criteria->addCondition('category_id='.$categoryId);
			}else{
			  $criteria->addInCondition('category_id',$categoryId);	
			}
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
