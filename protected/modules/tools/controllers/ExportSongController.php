<?php
class ExportSongController extends Controller
{
	public $type = AdminSongModel::ALL;
	public function actionIndex()
	{
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize', $pageSize);
		$model = new AdminSongModel('search');
		$copyrightType = Yii::app()->request->getParam('ccp_type',null);
		if (isset($_GET['AdminSongModel'])) {
			if (isset($_GET['AdminSongModel']['created_time']) && $_GET['AdminSongModel']['created_time'] != "") {
				// Re-setAttribute create datetime
				$createdTime = $_GET['AdminSongModel']['created_time'];
				if (strrpos($createdTime, "-")) {
					$createdTime = explode("-", $createdTime);
					$fromDate = explode("/", trim($createdTime[0]));
					$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
					$fromDate .=" 00:00:00";
					$toDate = explode("/", trim($createdTime[1]));
					$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
					$toDate .=" 23:59:59";
				} else {
					$fromDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time'])) . " 00:00:00";
					$toDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time'])) . " 23:59:59";
				}
			}
		}
		
		$is_composer="";
		if (isset($_GET['is_composer']) && $_GET['is_composer']>0) {
			$is_composer = $_GET['is_composer'];
		}
		
		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();
		
		if(isset($_GET['AdminSongModel'])){
			$limit=10;
			$offset=0;
			$where ="";
			if($_GET['AdminSongModel']['cp_id']!=''){
				$where .=" and t.cp_id = ".$_GET['AdminSongModel']['cp_id']." ";
			}
			if($_GET['AdminSongModel']['genre_id']!=''){
				$where .=" and sg.genre_id = ".$_GET['AdminSongModel']['genre_id']." ";
			}
			if($_GET['AdminSongModel']['name']!=''){
				$where .=" and t.name LIKE '%".$_GET['AdminSongModel']['name']."%' ";
			}
			if($_GET['AdminSongModel']['artist_name']!=''){
				$where .=" and t.artist_name LIKE '%".$_GET['AdminSongModel']['artist_name']."%' ";
			}
			if($_GET['is_composer']==1 || $_GET['is_composer']==2){
				if($_GET['is_composer']==1){
					$where .=" and t.composer_id > 0 ";
				}else{
					$where .=" and t.composer_id = 0 ";
				}
			}
			if($_GET['AdminSongModel']['max_bitrate']!=''){
				$where .=" and t.max_bitrate = ".$_GET['AdminSongModel']['max_bitrate'];
			}
			if($_GET['ccp_type']!=''){
				$where .=" and sc.type = ".$_GET['ccp_type'];
			}
			if($_GET['AdminSongModel']['created_time']!=''){
				$where .=" and t.created_time BETWEEN '$fromDate' AND '$toDate' ";
			}
			$sql = "SELECT count(DISTINCT `t`.`id`)
					FROM song t 
					INNER JOIN song_status st ON t.id = st.song_id
					LEFT JOIN artist a ON a.id=t.composer_id
					LEFT JOIN song_genre sg ON sg.song_id=t.id
					LEFT JOIN song_copyright sc ON sc.song_id=t.id
					LEFT JOIN copyright c ON c.id=sc.copryright_id
					WHERE t.status=1 $where
					";
			$count = Yii::app()->db->createCommand($sql)->queryScalar();
			$perPage = 10000;
			if ($count <= $perPage) {
				$numPage = 1;
			} elseif (($count % $perPage) == 0) {
				$numPage = ($count / $perPage) ;
			} else {
				$numPage = ($count / $perPage) + 1;
				$numPage = (int) $numPage;
			}
			if(isset($_GET['export'])){
				$page = Yii::app()->request->getParam('page',1);
				$limit = $perPage;
				$offset = ($page - 1) * $limit;
				$sql = "SELECT t.id, t.name, t.artist_name, a.name as composer_name, t.composer_id, sg.genre_name, sc.copryright_id as copyright_id,c.appendix_no,c.contract_no, cp.name as cc, '' as ccc  
				FROM song t
				INNER JOIN song_status st ON t.id = st.song_id
				LEFT JOIN cp ON t.cp_id = cp.id
				LEFT JOIN artist a ON a.id=t.composer_id
				LEFT JOIN song_genre sg ON sg.song_id=t.id
				LEFT JOIN song_copyright sc ON sc.song_id=t.id
				LEFT JOIN copyright c ON c.id=sc.copryright_id
				WHERE t.status=1 $where
				GROUP BY t.id
				ORDER BY t.id ASC
				LIMIT $limit
				OFFSET $offset
				";
				$data = Yii::app()->db->createCommand($sql)->queryAll();
				$label = array(
						'id'=>'ID',
						'name'=>'Bài Hát',
						'artist_name'=>'Ca sỹ',
						'composer_name'=>'Nhạc sỹ',
						'composer_id'=>'composer_id',
						'contract_no'=>'Số hợp đồng',
						'cc'=>'Tên CP, Ca sĩ, đại diện HĐ',
						'appendix_no'=>'Số phụ lục',
						'ccc'=>'STTPL',
						'copyright_id'=>'ID Hợp đồng'
				);
				$title = Yii::t('admin', 'Export_'.$page);
				$excelObj = new ExcelExport($data, $label, $title);
				$excelObj->export();
				exit;
			}
		}
		$this->render('index', array(
				'model' => $model,
				'categoryList' => $categoryList,
				'cpList' => $cpList,
				'pageSize' => $pageSize,
				'is_composer'=>$is_composer,
				'copyrightType'=>$copyrightType,
				'numPage'=>$numPage,
				'count'=>$count
		));
	}
	public function actionGetExport()
	{
		$sql = "SELECT t.id, t.name, t.artist_name, t.composer_id, sg.genre_name, sc.copryright_id as copyright_id
				FROM song t
				INNER JOIN song_status st ON t.id = st.song_id
				LEFT JOIN song_artist sa ON sa.song_id=t.id
				LEFT JOIN song_genre sg ON sg.song_id=t.id
				LEFT JOIN song_copyright sc ON sc.song_id=t.id
				WHERE t.status=1 $where
		";
	}
}
