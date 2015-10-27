<?php
class AdminAccessAssignmentsModel extends BaseAdminAccessAssignmentsModel {
	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @return AdminAccessAssignments the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function getItems($userId) {
		$sql = "SELECT
		child
		FROM admin_access_itemchildren
		WHERE
		parent IN (SELECT child FROM admin_access_assignments t1
		INNER JOIN admin_access_itemchildren t2
		ON t1.itemname=t2.parent
		WHERE t1.userid = '{$userId}')";
		$data = Yii::app ()->db->createCommand ( $sql )->queryAll ();
		$return = array ();
		foreach ( $data as $data ) {
			$return [] = $data ['child'];
		}
		return $return;
	}
	public function getRoles($userId) {
		$c = new CDbCriteria ();
		$c->condition = "userid=:UID";
		$c->params = array (
				':UID' => $userId
		);
		$assign = self::model ()->findAll ( $c );
		$assign = CHtml::listData ( $assign, "itemname", "itemname" );
		return $assign;
	}
}