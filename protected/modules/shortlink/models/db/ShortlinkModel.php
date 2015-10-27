<?php
Yii::import('application.modules.shortlink.models.db._base.BaseShortlinkModel');
class ShortlinkModel extends BaseShortlinkModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Shortlink the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}