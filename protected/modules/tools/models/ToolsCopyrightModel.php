<?php
class ToolsCopyrightModel extends ChachaContentModel
{
	public static function getSongToUpdateCP($songId=0)
	{
		if($songId>0){
			$where = "WHERE song_id=$songId";
		}else{
			$where = "";
		}
		$sql = "SELECT song_id, GROUP_CONCAT(DISTINCT copryright_id ORDER BY copryright_id DESC SEPARATOR ',') as cps, count(*) as total
				FROM song_copyright
				$where
				GROUP BY song_id
				HAVING total > 1
				order by total desc";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
}