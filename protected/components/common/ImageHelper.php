<?php
if(!defined("DS")) define("DS", DIRECTORY_SEPARATOR);

class ImageHelper
{
	private static $_instance;

	public $imgDomain = "/";
	public $imgOrgPath = "";
	public $imgResizeUrl = "";
	public $imgResizePath = "";
	public $logoPath = "data/images/logo.png";

	public static function getInstance()
	{
		if (null == self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function __construct()
	{
		$this->imgDomain = Yii::app()->params['storage']['baseUrl'];
		$this->imgOrgPath = Yii::app()->params['storage']['baseStorage'];
		$this->imgResizePath = Yii::app()->params['storage']['baseStorage']."/resized";
		$this->imgResizeUrl = Yii::app()->params['storage']['baseUrl']."/resized/";
	}

	public function get($source,$width,$height,$options=array())
	{

		$fullPathSource = $source;
		if(!file_exists($fullPathSource) || !is_file($fullPathSource)){
			return "/images/no-image.jpg";
		}

		if(isset($options['logo']) && $options['logo']){
			if(!isset($options['resize']) || !$options['resize']){
				$img = getimagesize($fullPathSource);
				$width = $img[0];
				$height = $img[1];
			}
			return $this->imgResizeUrl.$this->resizeImageLogo($source, $width, $height,$options['resize_type']);
		}

		if(isset($options['resize']) && !$options['resize']){
			return $this->imgDomain.$source;
		}
		if(!isset($options['resize_type']))
		{
			$options['resize_type'] = 'ratio';
		}
		$imgResize = $this->resizeImage($source, $width, $height,$options['resize_type']);
		if(!$imgResize) return "/data/images/no-image.png";
		return $this->imgResizeUrl.$imgResize;

	}

	public function resizeImage($source,$width,$height,$type='ratio')
	{
		$assetPath = $this->imgResizePath;

		$fullPathSource = $source;
		if(!file_exists($fullPathSource) || !is_file($fullPathSource)){
			return false;
		}
		$ext = strtolower(substr(strrchr($source, '.'), 1));
		$fileName = strtolower(substr(strrchr($source, '/'), 1));
		$folderType = substr($type, 0,1);

		$source= str_replace($this->imgOrgPath, "", $source);

		//$rzname = strtolower(substr($source, 0, strpos($source,'.')))."_{$width}_{$height}.{$ext}";
		$rzname = strtolower(substr($source, 0, strrpos($source,'/')))."/{$width}_{$height}_{$folderType}/{$fileName}";
		$rzname = strtolower(substr($rzname, 0, strpos($rzname,'.')))."/".md5_file($fullPathSource).".jpg";

		if(file_exists($assetPath.DS.$rzname)){
			return $rzname;
		}
		//empty dir first
		Utils::emptyDir(dirname($assetPath.DS.$rzname));
		Utils::makeDir($assetPath);

		if(!file_exists($assetPath) && !mkdir($assetPath,0775)) return $source;
		//$folders = explode('/',$source);
		$folders = explode('/',$rzname);
		$tmppath = $assetPath.DS;
		for($i=0;$i < count($folders)-1; $i++){
			if(!file_exists($tmppath.$folders[$i]) && !mkdir($tmppath.$folders[$i],0775)) return $source;
			$tmppath = $tmppath.$folders[$i].'/';
		}
		if(!file_exists($assetPath."/tmp")) mkdir($assetPath."/tmp",0775);

		list($r_width, $r_height) = getimagesize($fullPathSource);
		$imgCrop = new ImageCrop($fullPathSource, 0, 0, $r_width, $r_height,$assetPath."/tmp");
		switch ($type){
			case "fix":
				$imgCrop->resizeFix($assetPath.DS.$rzname, $width, $height,90);
				break;
			case "ratio":
				$imgCrop->resizeRatio($assetPath.DS.$rzname, $width, $height,90);
				break;
			case "crop":
			default:
				$imgCrop->resizeCrop($assetPath.DS.$rzname, $width, $height,90);
				break;
		}
		@chmod($assetPath.DS.$rzname, 0775);
		return $rzname;
	}

	public function resizeImageLogo($source,$width,$height,$type='ratio')
	{
		$fileName = strtolower(substr(strrchr($source, '/'), 1));
		$fileName = md5($fileName);
		$folderType = substr($type, 0,1);

		$rzname = strtolower(substr($source, 0, strrpos($source,'/')))."/{$width}_{$height}_{$folderType}/{$fileName}.jpg";
		//$rzname = strtolower(substr($rzname, 0, strpos($rzname,'.'))).".jpg";

		if(file_exists($this->imgResizePath.DS.$rzname)){
			return $rzname;
		}

		$resizeImg = $this->resizeImage($source,$width,$height,$type);

		//Merge images
		$logo_file = $this->imgOrgPath."/".$this->logoPath;
		$image_file = $this->imgResizePath.DS.$resizeImg;
		$targetfile = $this->imgResizePath.DS.$rzname;

		$photo = imagecreatefromjpeg($image_file);
		$fotoW = imagesx($photo);
		$fotoH = imagesy($photo);
		$logoImage = imagecreatefrompng($logo_file);
		$logoW = imagesx($logoImage);
		$logoH = imagesy($logoImage);
		$photoFrame = imagecreatetruecolor($fotoW,$fotoH);
		$dest_x = $fotoW - $logoW;
		$dest_y = $fotoH - $logoH;
		imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH);
		imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH);
		//imagecopy($photoFrame, $logoImage, $dest_x, 0, 0, 0, $logoW, $logoH);
		imagejpeg($photoFrame, $targetfile);
		return $rzname;
	}

	public function getImgFromUrl($url)
	{
		$savePath = 'data'.DS.'images'.DS.'gallery'.DS.date("Y-m").DS.date("d");
		$returnPath =str_replace(DS, "/", $savePath);
		$tmppath = $this->imgOrgPath.DS;
		$folders = explode(DS,$savePath);
		for($i=0;$i < count($folders); $i++){
			if(!file_exists($tmppath.$folders[$i]) && !mkdir($tmppath.$folders[$i],0775)) return "";
			$tmppath = $tmppath.$folders[$i].'/';
		}
		$urlArr = explode("/",$url);
		$fileName = $urlArr[count($urlArr)-1];
		$savePath = $this->imgOrgPath.DS.$savePath.DS.$fileName;

		if(file_exists($savePath) && is_file($savePath)){
			$savePath = str_replace(DS.$fileName, "", $savePath);
			$savePath =  $savePath.DS."v2_".$fileName;
			$fileName = "v2_".$fileName;
		}

		$allowed = array('jpg','gif','png');
		$pos = strrpos($url, ".");
		$str = substr($url,($pos + 1));

		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		// Getting binary data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

		$image = curl_exec($ch);
		curl_close($ch);
		// output to browser
		$im = @imagecreatefromstring($image);

		$tw = @imagesx($im);
		if(!$tw){
			//die("here");
			return "";
		}else{
			/*
			 if($str == 'jpg' || $str == 'jpeg')
			 header("Content-type: image/jpeg");
			 if($str == 'gif')
			 header("Content-type: image/gif");
			 if($str == 'png')
			 header("Content-type: image/png");
			 */

			$th = imagesy($im);
			$thumbImg = imagecreatetruecolor($tw, $th);
			if($str == 'gif'){
				$colorTransparent = imagecolortransparent($im);
				imagefill($thumbImg, 0, 0, $colorTransparent);
				imagecolortransparent($thumbImg, $colorTransparent);
			}
			if($str == 'png'){
				imagealphablending($thumbImg, false);
				imagesavealpha($thumbImg,true);
				$transparent = imagecolorallocatealpha($thumbImg, 255, 255, 255, 127);
				imagefilledrectangle($thumbImg, 0, 0, $tw, $th, $transparent);
			}
			imagecopyresampled($thumbImg, $im, 0, 0, 0, 0, $tw, $th, $tw, $th);


			if($str == 'jpg' || $str == 'jpeg'){
				imagejpeg($thumbImg, $savePath, 100);
			}
			if($str == 'gif'){
				imagegif($thumbImg,$savePath);
			}
			if($str == 'png'){
				imagealphablending($thumbImg,TRUE);
				imagepng($thumbImg, $savePath, 9, PNG_ALL_FILTERS);
			}
			imagedestroy($thumbImg);
			return $this->imgDomain. $returnPath."/".$fileName;
		}
	}
}