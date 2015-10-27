<?php

class GameEventReportAllModel extends BaseGameEventReportAllModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventReportAll the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTotal()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		//$criteria->compare('date',$this->date,true);
		$criteria->compare('total_sub',$this->total_sub);
		$criteria->compare('total_unsub',$this->total_unsub);
		$criteria->compare('access_event',$this->access_event);
		$criteria->compare('access_play',$this->access_play);
		$criteria->compare('total_play_all',$this->total_play_all);
		$criteria->compare('total_msisdn_valid',$this->total_msisdn_valid);
		$criteria->compare('listen_music',$this->listen_music);
		$criteria->compare('download_music',$this->download_music);
		$criteria->compare('play_video',$this->play_video);
		$criteria->compare('download_video',$this->download_video);
		$criteria->compare('have_transaction',$this->have_transaction);
	
		if (is_array($this->date)){
			$criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
		}
		else
			$criteria->compare('date',$this->date,true);
		
		$data = GameEventReportAllModel::model()->findAll($criteria);
		return $data;
	}
}