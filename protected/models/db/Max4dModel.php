<?php

class Max4dModel extends BaseMax4dModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Max4d the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getData($table,$no,$action){
		//try {
			$data = ['mega645'=>'','max4d'=>''];
			if(empty($no)){

				$command = Yii::app()->db->createCommand();
				$command->from('max4d');
				$command->order('day DESC');
				$data['max4d'] = $command->queryRow();

				$command = Yii::app()->db->createCommand();
				$command->from('mega645');
				$command->order('day DESC');
				$data['mega645'] = $command->queryRow();
			}else {
				$command = Yii::app()->db->createCommand();
				$command->from($table);
				if ($action == 'previous') {
					$command->where('day < :day', [':day' => $no]);
					$command->order('day DESC');

				} else {
					$command->where('day > :day', [':day' => $no]);
					$command->order('day ASC');
				}
				$data[$table]= $command->queryRow();
			}
			return $data;
		/*}catch (Exception $ex){
			return null;
		}*/
	}
}