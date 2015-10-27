<?php
define("CP_ID", 1);
define("ADMIN_ID", 1);
Yii::import('application.models.admin.*');
class SyncHelper {
	private static $errorLoger;

	private static function initLoger()
	{
		if(!self::$errorLoger){
			self::$errorLoger = new KLogger("_ERROR_SYNC_CMC", KLogger::INFO);
		}
		return self::$errorLoger;
	}

	public static function syncArtist($artistList,$loger = null)
	{
		$return = array();
		
		foreach($artistList as $artist){
			$return[] = $artist ['id'];
			$artistModel = ArtistModel::model ()->findByAttributes ( array ('cmc_id' => $artist ['id'] ) );
			if(!empty($artistModel)){
				continue;
				//self::_updateArtist($artist,$artistModel);
			}else{
				// Tìm ca sỹ trùng tên
				$c = new CDbCriteria();
				$c->condition = "name=:NAME AND cmc_id<>:CMCID";
				$c->params = array(":NAME"=>$artist['name'],":CMCID"=>$artist ['id']);
				$artistMap = ArtistModel::model()->findAll($c);
				
				if(empty($artistMap)){
					//Tao moi ca sy
					self::_createArtist($artist);
				}else{
					$flag = false;
					foreach ($artistMap as $artistModel){
						//Map chinh xác theo tên
						if(mb_strtolower($artistModel["name"], 'UTF-8') == mb_strtolower($artist['name'], 'UTF-8')){
							$flag = true;
							self::_updateArtist($artist,$artistModel);
							break;
						}
					}
					//Neu ko map dc chinh xac ten voi ca sy nao
					if(!$flag){
						//Tao moi ca sy
						self::_createArtist($artist);
					}
				}
			}
		}
		return $return;
	}

	public static function syncSong($songList,$detailUrl,  $loger = null)
	{
		$listSong = array();
		foreach($songList as $song){
			$ret = self::_synSongItem($detailUrl, $song['id'], $loger);
			if($ret) $listSong[] = $ret;
		}
		return $listSong;
	}


	private static function _synSongItem($detailUrl,$cmcId, $loger = null)
	{
		$return = false;
		//Get Songdetail
		$contentDetail = self::_getContentCurl($detailUrl.$cmcId);
		$songDetail = json_decode($contentDetail,true);
		$songDetail = $songDetail['data'];

		$cpId = CP_ID; //VEGA CP ID
		$songCode = time();


		// Map data
		/* $composerId = $songDetail['composer'];
		$composerName = '';
		if($songDetail['composer']){
			$composerModel = ArtistModel::model()->findByAttributes(array('cmc_id'=>$songDetail['composer']));
			if(!empty($composerModel)){
				$composerId = $composerModel->id;
				$composerName = $composerModel->name;
			}
		} */
		
		$composerId = 0;
		$composerName = '';
		$composerIds = self::_convertArtist(array($songDetail['composer']),array($songDetail['composer_obj']));
		if(!empty($composerIds)){
			$composerId = $composerIds[0];
			$composerName = $songDetail['composer_obj']["name"];
		}
		

		$artistList = self::_convertArtist($songDetail['artist_ids'],$songDetail['song_artist_obj']);
		if(empty($artistList)){
			$msg = "CMC Song {$cmcId} Khong map duoc ca sy";
			self::initLoger()->logError($msg);
			echo $msg."\n";
			return false;
		}
		$genreList = self::_convertGenre($songDetail['genre_ids']);
		if(empty($genreList)){
			$msg = "CMC Song {$cmcId} Khong map duoc genre";
			self::initLoger()->logError($msg);
			echo $msg."\n";
			return false;
		}
		// End Map data

		$songModel = SongModel::model ()->findByAttributes ( array ('cmc_id' => $songDetail ['id'] ) );
		

		$transaction = Yii::app()->db->beginTransaction();
		try {			
			if(empty($songModel)){
				$songModel = new SongModel();
				$songModel->lyrics = $songDetail['lyric_content'];
				$songModel->cmc_id =  $songDetail ['id'];
				$songModel->code = $songCode;
				$songModel->name = $songDetail['name'];
				$songModel->url_key = Common::makeFriendlyUrl($songDetail['name']);
				$songModel->composer_id = (int)$composerId;
				$songModel->composer_name = $composerName;
				//$songModel->artist_id = $artistId;
				//$songModel->artist_name = $artistName?$artistName:"Unknow";
				$songModel->owner = $songDetail['owner'];
				$songModel->source = $songDetail['source'];
				$songModel->source_link = $songDetail['source_link'];
				$songModel->national = $songDetail['national'];
				$songModel->language = $songDetail['language_code'];
				$songModel->duration = $songDetail['duration'];
				$songModel->max_bitrate = $songDetail['bitrate'];
				$songModel->created_by = $songDetail['added_by'];
				$songModel->approved_by = $songDetail['approved_by'];
				$songModel->updated_by = $songDetail['updated_by'];
				$songModel->cp_id = $cpId;
				$songModel->source_path = "";
				//$songModel->download_price = Yii::app()->params['price']['songDownload'];
				//$songModel->listen_price = Yii::app()->params['price']['songListen'];
				$songModel->created_time = new CDbExpression("NOW()");
				$songModel->updated_time = new CDbExpression("NOW()");
				$songModel->copyright = $songDetail['copyright'];				
			}

			$songModel->profile_ids = $songDetail['profile_ids'];
			$ret = $songModel->save();

			if($ret){
				// Update song_genre
				SongGenreModel::model()->updateSongCate($songModel->id,$genreList);
				
				//Update song_artist
				SongArtistModel::model()->updateArtist($songModel->id,$artistList);
				
				$songModel->artist_name = SongArtistModel::model()->getArtistBySong($songModel->id,"name");
				$songModel->code = $songModel->id;
				$songModel->save();
				
				//Update song status
				$statusModel = SongStatusModel::model()->findByPk($songModel->id);
				$statusModel->convert_status = SongStatusModel::CONVERT_SUCCESS;
				$statusModel->approve_status = SongStatusModel::APPROVED;
				$statusModel->artist_status = SongStatusModel::APPROVED;
				$statusModel->save();
				
				//Update Tag
				$tags = self::_convertTag($songDetail["tag"]);
				TagContentModel::model()->updateTag($songModel->id,$tags,"song");					
				
				$transaction->commit();
				$return = $cmcId;
				$loger->logInfo("Sync success SONG ID:".$cmcId);

			}else{
				$msg = "SyncSong ID {$cmcId} FAIL: Ko luu duoc du lieu: ". var_export($songModel->getErrors());
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				$transaction->rollback();
			}

		}catch (Exception $e){
			$msg = "SyncSong ID {$cmcId} FAIL: DB Exception: ". $e->getMessage();
			self::initLoger()->LogError($msg);
			echo $msg."\n";
			$transaction->rollback();
		}
		return $return;
	}

	public static function syncVideo($videoList,$detailUrl,  $loger = null)
	{
		$return = array();
		foreach($videoList as $video){
			
			$cmcId = $video['id'];
			$contentDetail = self::_getContentCurl($detailUrl.$video['id']);
			$videoDetail = json_decode($contentDetail,true);
			$videoDetail = $videoDetail['data'];

			$cpId = CP_ID; //VEGA CP ID
			$videoCode = time();

			// Map data
			$composerId = 0;
			$composerIds = self::_convertArtist(array($videoDetail['composer']),array($videoDetail['composer_obj']));
			if(!empty($composerIds)){
				$composerId = $composerIds[0];
			}
			
			
			$artistList = self::_convertArtist($videoDetail['artist_ids'],$videoDetail['video_artist_obj']);
			if(empty($artistList)){
				$msg = "CMC Video {$cmcId} Khong map duoc ca sy";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			$genreList = self::_convertGenre($videoDetail['genre_ids']);
			if(empty($genreList)){
				$msg = "CMC Video {$cmcId} Khong map duoc genre";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End Map data
			$videoModel = VideoModel::model ()->findByAttributes ( array ('cmc_id' => $video ['id'] ) );

			$transaction = Yii::app()->db->beginTransaction();
			try {			
				if(empty($videoModel)){
					$videoModel = new VideoModel();
					$videoModel->lyrics = $videoDetail['lyric_content'];
					$videoModel->code = $videoCode;
					$videoModel->cmc_id = $video['id'];
					$videoModel->name = $video['name'];
					$videoModel->url_key = Common::makeFriendlyUrl($video['name']);
					$videoModel->composer_id = (int) $composerId;
					$videoModel->owner = $video['owner'];
					$videoModel->source = $video['source'];
					$videoModel->source_link = $video['source_link'];
					$videoModel->national = "";
					$videoModel->language = $video['language_code'];
					$videoModel->duration = $video['duration'];
					$videoModel->max_bitrate = $video['bitrate'];
					$videoModel->created_by = $video['added_by'];
					$videoModel->approved_by = $video['approved_by'];
					$videoModel->updated_by = $video['updated_by'];
					$videoModel->cp_id = $cpId;
					$videoModel->source_path = "";
					//$videoModel->download_price = Yii::app()->params['price']['videoDownload'];
					//$videoModel->listen_price = Yii::app()->params['price']['videoListen'];
					$videoModel->created_time = new CDbExpression("NOW()");
					$videoModel->updated_time = new CDbExpression("NOW()");
					$videoModel->copyright = $video['copyright'];
				}

				$videoModel->profile_ids = $videoDetail['profile_ids'];
				
				$ret = $videoModel->save();
				if($ret){

					//get avartar
					if(isset($videoDetail['avatar_url'])){
						$avatarList = $videoDetail['avatar_url'];						
						$sourceAvatar = $avatarList[0];
						$videoAvatar = $videoModel->getAvatarPath();
						
						// Neu chua co avatar thi tao moi
						if (!file_exists($videoAvatar)){
							$tmpPath =  Yii::app()->getRuntimePath()."/{$videoModel->id}_sync_video_".time().".jpg";
							$download = self::_downloadFileCurl($sourceAvatar, $tmpPath);
							if($download){
								self::processAvatar($videoModel, $tmpPath, 'video');
							}else{
								$msg = "Cannot download avatar FROM {$sourceAvatar} to {$tmpPath}";
								$loger->logInfo($msg);
							}
						}
					}
					
					//Update video_genre
					$genreList = self::_convertGenre($videoDetail['genre_ids']);
					VideoGenreModel::model()->updateVideoCate($videoModel->id,$genreList);
						
					//update video_artist
					VideoArtistModel::model()->updateArtist($videoModel->id,$artistList);
					$videoModel->artist_name = VideoArtistModel::model()->getArtistByVideo($videoModel->id,"name");
						
					$videoModel->code = $videoModel->id;
					$videoModel->save();
						
					//Update Video status
					$statusModel = VideoStatusModel::model()->findByPk($videoModel->id);
					$statusModel->convert_status = VideoStatusModel::CONVERT_SUCCESS;
					$statusModel->approve_status = VideoStatusModel::APPROVED;
					$statusModel->save();
						
					//Update Tag
					$tags = self::_convertTag($videoDetail["tag"]);
					TagContentModel::model()->updateTag($videoModel->id,$tags,"video");
					
					$transaction->commit();

					$loger->logInfo("Sync success VIDEO ID:".$video ['id']);
					$return[] = $video ['id'];
				}else{
					$msg = "SyncVideo id {$video['id']} FAIL: Ko luu duoc du lieu: ". var_export($videoModel->getErrors());
					self::initLoger()->LogError($msg);
					echo $msg;
					$transaction->rollback();
				}

			}catch (Exception $e){
				$msg = "SyncVideo id {$video['id']} FAIL:DB Exception: ". $e->getMessage();
				self::initLoger()->LogError($msg);
				echo $msg;
				$transaction->rollback();
			}
		}
		return array_unique($return);
	}

	public static function syncAlbum($albumList,$detailUrl,  $loger = null, $apiSongUrl)
	{
		$return = array();
		foreach($albumList as $album){
			//Get Albumdetail
			$cmcId = $album['id'];
			$contentDetail = self::_getContentCurl($detailUrl.$album['id']);
			$albumDetail = json_decode($contentDetail,true);
			$albumDetail = $albumDetail['data'];

			$cpId = CP_ID; //VEGA CP ID

			// Map data
			$artistList = self::_convertArtist($albumDetail['artist_ids'],$albumDetail['album_artist_obj']);
			if(empty($artistList)){
				$msg = "CMC Album {$cmcId} Khong map duoc ca sy";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			$genreList = self::_convertGenre(array($albumDetail['genre_id']));
			if(empty($genreList)){
				$msg = "CMC Album {$cmcId} Khong map duoc genre";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End Map data

			// Khong sync cac album rong
			if(count($albumDetail['album_song']) == 0){
				$msg = "Album {$album['id']} khong co bai hat nao";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}

			// Sync cac bai hat trong album truoc
			$listSongCmc = array();
			$songAlbumOrder = array();
			foreach($albumDetail['album_song'] as $song){
				$listSongCmc[] = $song['song_id'];
				$songAlbumOrder[$song['song_id']] = $song['sorder'];
				$songExist = SongModel::model()->findByAttributes(array("cmc_id"=>$song['song_id']));
				if(empty($songExist)){
					self::_synSongItem($apiSongUrl, $song['song_id'],$loger);
				}
			}
			$c = new CDbCriteria();
			$c->condition = "status=1";
			$c->addInCondition("cmc_id", $listSongCmc);
			$c->group = "cmc_id";
			$songSynced = SongModel::model()->findAll($c);
			if(count($songSynced) < count($listSongCmc)){
				$msg = "Cac bai hat trong CMC album {$album['id']} chua dc sync ve";
				self::initLoger()->LogError($msg);
				echo $msg."\n";
				continue;
			}
			// End sync song
			
			$albumModel = AlbumModel::model ()->findByAttributes ( array ('cmc_id' => $album['id'] ) );
			/* if(!empty($albumModel)){
				$return[] = $album ['id'];
				continue;
				// Khong update cac album da ton tai tren he thong
			} */
			

			$transaction = Yii::app()->db->beginTransaction();
			try {				
				if(empty($albumModel)){
					$albumModel = new AlbumModel();
					$albumModel->description = $album['description'];
					$albumModel->cmc_id = $album['id'];
					$albumModel->name = $album['name'];
					$albumModel->url_key = Common::makeFriendlyUrl($album['name']);
					$albumModel->genre_id = $genreList[0];
					//$albumModel->price = Yii::app()->params['price']['albumListen'];
					$albumModel->publisher = $album['publisher'];
					$albumModel->published_date = $album['published_date'];
					$albumModel->created_by = ADMIN_ID;
					$albumModel->updated_by = ADMIN_ID;
					$albumModel->cp_id = CP_ID;
					$albumModel->created_time = new CDbExpression("NOW()");
					$albumModel->updated_time = new CDbExpression("NOW()");
					$albumModel->type = $albumDetail['type'];
				}

				$ret = $albumModel->save();
				if($ret){
					//update album_artist
					AlbumArtistModel::model()->updateArtist($albumModel->id,$artistList);
					$albumModel->artist_name = AlbumArtistModel::model()->getArtistByAlbum($albumModel->id,"name");

					$ablumAvatar = $albumModel->getAvatarPath();
					if(!file_exists($ablumAvatar)){
						//get avatar
						$avatarSource = $albumDetail['avatar_url'];
						$tmpPath =  Yii::app()->getRuntimePath()."/{$albumModel->id}_sync_album_".time().".jpg";
						$downloadAvatar = self::_downloadFileCurl($avatarSource, $tmpPath);
						if($downloadAvatar){
							self::processAvatar($albumModel, $tmpPath, 'album');
						}else{
							echo "__cannot download file from {$avatarSource} to {$tmpPath}"."\n";
						}
					}
					
					//Reset album_song
					$sql = "DELETE FROM album_song WHERE album_id=".$albumModel->id;
					Yii::app()->db->createCommand($sql)->execute();

					//Create album_song
					foreach ($songSynced as $item){
						$albumSong = AlbumSongModel::model()->findByAttributes(array("album_id"=>$albumModel->id,"song_id"=>$item['id']));
						if(empty($albumSong)){
							$albumSong = new AlbumSongModel();
							$albumSong->song_id = $item['id'];
							$albumSong->album_id = $albumModel->id;
						}						
						$albumSong->status = 1;
						$albumSong->sorder = isset($songAlbumOrder[$item['cmc_id']])?$songAlbumOrder[$item['cmc_id']]:0;
						$albumSong->insert();
					}
					$albumModel->save();
					
					//Update album status
					$albumStatusModel = AlbumStatusModel::model()->findByPk($albumModel->id);
					$albumStatusModel->approve_status = AlbumStatusModel::APPROVED;
					$albumStatusModel->artist_status = AlbumStatusModel::APPROVED;
					$albumStatusModel->save();

					
					//Update Tag
					$tags = self::_convertTag($albumDetail["tag"]);
					TagContentModel::model()->updateTag($albumModel->id,$tags,"album");
					
					$transaction->commit();

					$loger->logInfo("Sync success ALBUM ID:".$album ['id']);
					$return[] = $album ['id'];
				}else{
					$msg = "Sync FAIL ALBUM id {$album['id']} FAIL: Ko luu duoc du lieu: ". var_export($albumModel->getErrors());
					self::initLoger()->LogError($msg);
					echo $msg;
					$transaction->rollback();
				}

			}catch (Exception $e){
				$msg = "Sync FAIL ALBUM  id {$album['id']} FAIL:DB Exception: ". $e->getMessage();
				self::initLoger()->LogError($msg);
				echo $msg;
				$transaction->rollback();
			}
		}
		return array_unique($return);
	}

	static function _convertGenre($ids)
	{
		$return = array();
		foreach ($ids as $id){
			$sql = "SELECT * FROM genre_map WHERE cmc_id=:CID";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(":CID", $id);
			$mapGenre = $command->queryAll();
			foreach($mapGenre as $genre){
				$return[] = $genre["genre_id"];
			}			
		}
		array_unique($return);
		if(empty($return)){
			$return[] = 87; // Thể Loại Khác
		}
		
		return array_unique($return);
	}

	static function _convertArtist($ids,$songArtistObj = array())
	{
		$c = new CDbCriteria();
		$c->condition = "cmc_id <>0";
		$c->addInCondition("cmc_id", $ids);
		$ret = array();
		$artistList = ArtistModel::model()->findAll($c);
		
		//Nếu không tìm thấy ca sỹ tương ứng với cmc_id
		if(empty($artistList)){
			foreach($songArtistObj as $obj){
				// Map ca sỹ theo tên
				$artistObj = ArtistModel::model()->findAllByAttributes(array("name"=>addslashes($obj['name'])));
				if(!empty($artistObj)){
					$exactArtist = array();
					foreach($artistObj as $aObj){
						//Map chinh xac ten
						if(mb_strtolower($aObj["name"], 'UTF-8') == mb_strtolower($obj['name'], 'UTF-8')){
							$artistId = $aObj->id;
							$aObj->cmc_id =$obj['id'];
							$result = $aObj->save(false);
							if(!$result){
								$error =  CHtml::errorSummary($aObj);
								self::initLoger()->LogError($error);
							}
							$ret[] = $artistId;
							$exactArtist[] = $artistId;
							break;
						}
					}
					// Nếu không tìm đc ca sỹ nào có tên chính xác => Tạo mới ca sỹ
					if(empty($exactArtist)){
						$ret[] = self::_createArtist($obj);
					}					
				}else{
					// Không tìm được ca sỹ nào theo tên tương ứng => Tạo mới ca sỹ
					$ret[] = self::_createArtist($obj);
				}
			}
		}else{
			foreach ($artistList as $artist){
				$ret[] = $artist->id;
			}
		}
		return $ret;
	}
	
	static function _createArtist($obj)
	{
		//tao moi ca sy tren he thong client
		$newArtist = new ArtistModel();
		$newArtist->name = trim($obj['name']);
		$newArtist->url_key = Common::makeFriendlyUrl($obj['name']);
		$newArtist->cmc_id = $obj['id'];
		$newArtist->created_time = date('Y-m-d H:i:s');
		$newArtist->updated_time = date('Y-m-d H:i:s');
		$newArtist->status = ArtistModel::ACTIVE;
		$newArtist->description = $obj["description"];
		$newArtist->type = $obj["type"];
		$genreId = self::_convertGenre(array($obj["genre_id"]));
		$newArtist->genre_id = $genreId[0];
		if($newArtist->save()){
			//Tao avatar
			$tmpPath = 	Yii::app()->getRuntimePath()."/{$newArtist->id}_sync_img_".time().".jpg";
			$downloadAvatar = self::_downloadFileCurl($obj["avatar"], $tmpPath);
			if($downloadAvatar){
				AvatarHelper::processAvatar($newArtist, $tmpPath, 'artist');
			}
				
			self::initLoger()->LogError("Success create new artist {$obj['name']}");
			return $newArtist->id;
		}else{
			$error =  CHtml::errorSummary($newArtist);
			self::initLoger()->LogError("Can't create artist {$obj['name']}: $error","ERROR");
			return 0;
		}
	}
	
	static function _updateArtist($obj,$artistModel)
	{
		if(!isset($artistModel->cmc_id) || $artistModel->cmc_id==0){
			$artistModel->cmc_id = $obj["id"];
			$artistModel->save(false);
		}
		return $artistModel->id;
		
		$artistModel->name = trim($obj['name']);
		$artistModel->url_key = Common::makeFriendlyUrl($obj['name']);
		$artistModel->updated_time = date('Y-m-d H:i:s');
		$artistModel->description = $obj["description"];
		$artistModel->type = $obj["type"];
		$artistModel->cmc_id = $obj["id"];
		$genreId = self::_convertGenre(array($obj["genre_id"]));
		$artistModel->genre_id = $genreId[0];
		if($artistModel->save(false)){
			$avatarPath = $artistModel->getAvatarPath();
			if(!file_exists($avatarPath)){
				// Neu ca sy chua co avatar => Tao avatar
				$tmpPath = 	Yii::app()->getRuntimePath()."/{$artistModel->id}_sync_img_".time().".jpg";
				$downloadAvatar = self::_downloadFileCurl($obj["avatar"], $tmpPath);
				if($downloadAvatar){
					AvatarHelper::processAvatar($artistModel, $tmpPath, 'artist');
				}
			}
			self::initLoger()->LogError("Success Update artist {$obj['name']}");
			return $artistModel->id;
		}else{
			$error =  CHtml::errorSummary($newArtist);
			self::initLoger()->LogError("Can't Update artist {$obj['name']}: $error","ERROR");
			return 0;
		}
	}
		

	static function _getArtistName($ids)
	{
		$c = new CDbCriteria();
		$c->addInCondition("cmc_id", $ids);
		$ret = array();
		foreach (ArtistModel::model()->findAll($c) as $artist){
			$ret[] = $artist->name;
		}
		return $ret;
	}
	
	static function _convertTag($tagObjs)
	{
		$return = array();
		foreach($tagObjs as $tag){
			$tagModel = TagModel::model()->findByAttributes(array("cmc_id"=>$tag["id"]));
			if(!empty($tagModel)){
				$return[] = $tagModel->id; 
			}else{
				//Tim theo ten
				$c = new CDbCriteria();
				$c->condition = "name=:NAME AND cmc_id<>:CID";
				$c->params = array(":NAME"=>$tag["name"],":CID"=>$tag["id"]);
				$tagModel = TagModel::model()->find($c);
				if(!empty($tagModel)){
					$return[] = $tagModel->id;
				}else{
					//Ko tim dc tag nao co san => tao tag moi
					$tagModel = new TagModel();
					$tagModel->name = $tag["name"];
					$tagModel->description = $tag["description"];
					$tagModel->custom_url = $tag["custom_url"];
					$tagModel->cmc_id = $tag["id"];
					$tagModel->save();
					$return[] = $tagModel->id;
				}	
			}
		}
		return $return;
	} 
	
	public static function _getContentCurl($url)
	{
		// timeout in seconds
		$timeOut = 5;
		
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_BINARYTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeOut );
		$rawdata = curl_exec ( $ch );		
		
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($httpcode!=200){
			curl_close ( $ch );
			return false;
		}		
		
		if (! curl_errno ( $ch )) {
			if ($rawdata) {
				curl_close ( $ch );
				return $rawdata;
			}
		}
		
		curl_close ( $ch );
		return false;
	}

	public static function _postUrl($url,$data){

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 3);
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$response  = curl_exec($curl);
		if(curl_errno( $curl )) {
		}else{
		}
		curl_close($curl);
		return $response;
	}


	public static function _downloadFileCurl($url, $target) {
		$result = false;
		$rawdata = self::_getContentCurl($url);
		
		if($rawdata)
		{
			//save to file
			if(file_exists($target)){
				@unlink($target);
			}
			$fp = fopen($target,'w');
			fwrite($fp, $rawdata);
			fclose($fp);
			if(@md5_file($url) == md5_file($target)) $result = true;
		}else{
			$result = false;
		}
		return $result;
	}
	public static function processAvatar($model, $source, $type = "artist") {

		$fileSystem = new Filesystem();

		$alowSize = Yii::app()->params['imageSize'];
		$maxSize = max($alowSize);
		$folderMax = "s0";

		foreach ($alowSize as $folder => $size) {
			// Create folder by ID
			$avatarPath = $model->getAvatarPath($model->id, $folder, true);
			//$avatarPath = str_replace('music_storage', 'vega_storage', $avatarPath);
			$fileSystem->mkdirs($avatarPath);
			@chmod($avatarPath, 0775);

			// Get link file by ID
			$savePath[$folder] = $model->getAvatarPath($model->id, $folder);
			
			if ($size == $maxSize) {
				$folderMax = $folder;
			}
		}
		// Delete file if exists
		if (file_exists($savePath[$folder])) {
			$fileSystem->remove($savePath);
		}

		if (file_exists($source)) {
			list($width, $height) = getimagesize($source);
			$imgCrop = new ImageCrop($source, 0, 0, $width, $height);

			// aspect ratio for image size
			$aspectRatioW = $aspectRatioH = 1;
			if ($type == "video") {
				$videoAspectRatio = Yii::app()->params['videoResolutionRate'];
				list($aspectRatioW, $aspectRatioH) = explode(":", $videoAspectRatio);
			}

			foreach ($savePath as $k => $v) {
				$desWidth = $alowSize[$k];
				$desHeight = round($alowSize[$k] * intval($aspectRatioH) / intval($aspectRatioW));
				if (file_exists($v) && is_file($v)) {
					@unlink($v);
				}

				if ($k == $folderMax) {
					$imgCrop->resizeRatio($v, $desWidth, $desHeight, 70);
				} else {
					$imgCrop->resizeCrop($v, $desWidth, $desHeight, 70);
				}
			}
			//if ($type != "video") {
				$fileSystem->remove($source);
			//}
		}
	}

}