<?php

class GameEventQuestionModel extends BaseGameEventQuestionModel
{
	const ALL = -1;
	const PUBLISHED = 1;
	const DELETED = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes() {
		return array(
				"published" => array(
						"condition" => "t.status = " . self::PUBLISHED,
				),
		);
	}
	public function getAllByIds($ids){
		$questions	= array();
		$arrIds = explode(",", $ids);
		
		$cr	= new CDbCriteria();		
		$cr->addInCondition('id', $arrIds);
		
		$questions = GameEventQuestionModel::model()->published()->findAll($cr);
		return $questions;
	}
}