<?php
class ImageController extends Controller
{
	public function actionCrop()
	{
		$objId = Yii::app()->request->getParam('obj_id',0);
		$type = Yii::app()->request->getParam('img_type','video');
		$destW = Yii::app()->request->getParam('dest_width',320);
		$destH = Yii::app()->request->getParam('dest_height',320);

		$error = array("code"=>0,"message"=>"");
		$flag = true;
		$updateItem = "";
		$fileUrl = "";

		switch ($type){
			case "video":
				$itemId = Yii::app()->request->getParam('item_id',1);
				$updateItem = "AdminVideoModel_avatar_$itemId";
				$savePath = Common::storageSolutionEncode($objId);
				$filePath = Yii::app()->params['storage']['videoDir'] . "/output/". $savePath . "thumbs/$itemId.jpg";
				$fileUrl =  $path = Yii::app()->params['storage']['videoImageUrl'] . "/output/" . $savePath . "thumbs/$itemId.jpg";
				$fileUrl = str_replace('s2.chacha.vn', 'audio.chacha.vn:81', $fileUrl);
				break;
			default:
				$filePath = "";
				break;
		}

		if (Yii::app()->getRequest()->ispostRequest) {
			$flag = false;
			$fileSystem = new Filesystem();

			$fileName = end(explode("/", $fileUrl));
			$resizePath = $videoFile = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$fileName;

			$imgCrop = new ImageCrop($filePath,$_POST['x1'],$_POST['y1'], $_POST['w'],$_POST['h']);
			$imgCrop->cropImage($resizePath, $_POST['w'], $_POST['h'], 100);
			$fileSystem->remove($filePath);
			$fileSystem->rename($resizePath, $filePath);
			echo $fileUrl;
			Yii::app()->end();

		}

		if(!file_exists($filePath)){
			$error["code"] = 1;
			$error["message"] = "File nguồn {$filePath} không tồn tại";
		}else{
			/* $imgSize = getimagesize($filePath);
			$maxW = 600;
			$maxH = 400;
			if($imgSize[0] > $maxW || $imgSize[1] > $maxH){
				$fileName = time().".jpg";
				$resizeFile = Yii::getPathOfAlias("webroot").DS."data".DS."tmp".DS.$fileName;

				$imgCrop = new ImageCrop($filePath, 0, 0, $realW, $realH);
				$imgCrop->resizeRatio($resizeFile, $maxW, $maxH, 100);

				$fileSystem->remove($filePath);
				//$fileSystem->rename($resizeFile, $filePath);
			} */
		}


		if ($flag) {
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_cropImg', array(
					'error'=>$error,
					'fileUrl'=>$fileUrl,
					'updateItem'=>$updateItem,
			), false, true);
		}

	}

}