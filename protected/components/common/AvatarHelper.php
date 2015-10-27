<?php

class AvatarHelper {

    public static function processAvatar($model, $source, $type = "artist") {
		try{
	        $fileSystem = new Filesystem();
	
	        $alowSize = Yii::app()->params['imageSize'];
	        $maxSize = max($alowSize);
	        $folderMax = "s0";
	
	        foreach ($alowSize as $folder => $size) {
	            // Create folder by ID
	            $fileSystem->mkdirs($model->getAvatarPath($model->id, $folder, true));
	            @chmod($model->getAvatarPath($model->id, $folder, true), 0775);
	
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
	            $res = array();
	            foreach ($savePath as $k => $v) {
	                $desWidth = $alowSize[$k];
	                $desHeight = round($alowSize[$k] * intval($aspectRatioH) / intval($aspectRatioW));
	                if (file_exists($v) && is_file($v)) {
	                    @unlink($v);
	                }
	                if($width>4000){
	                	self::ImageCropPro($v, $source, $desWidth, $desHeight, 70);
	                }else{
		                if ($k == $folderMax) {
		                    //$imgCrop->resizeRatio($v, $desWidth, $desHeight, 70);
		                	$fileSystem->copy($source, $v);
		                } else {
		                    $imgCrop->resizeCrop($v, $desWidth, $desHeight, 70);
		                }
	                }
	            }
	            if ($type != "video") {
	                $fileSystem->remove($source);
	            }
	        }
		}catch (Exception $e)
		{
			$error = $e->getMessage();
		}
    }
    public static function ImageCropPro($destFile, $sourceFile, $width=50, $height=50, $quality=100)
    {
    	$desWidth = $width;
    	$desHeight = $height;
    	//$destFile = "/srv/www/htdocs/chacha2.0/chacha/data/tmp/test_crop.jpg";
    	//$sourceFile = "/srv/www/htdocs/chacha2.0/chacha/data/tmp/test.jpg";
    	list($_cropWidth, $_cropHeight) = getimagesize($sourceFile);
    	
    	$ratio=min($_cropWidth/$desWidth,$_cropHeight/$desHeight);
    	$srcW = $desWidth*$ratio;
    	$srcH = $desHeight*$ratio;
    	$srcX = ($_cropWidth-$srcW)/2; // Crop From top center
    	//$srcY = ($this->_cropHeight-$srcH)/2; // Crop center center
    	
    	$srcY = min(($_cropHeight-$srcH)/2,0);
    	
    	$_imgFinal = @imagecreatetruecolor($desWidth, $desHeight);
    	$image = imagecreatefromjpeg($sourceFile);
    	
    	$res = imagecopyresampled($_imgFinal, $image,0,0,$srcX,$srcY,$desWidth, $desHeight,$srcW,$srcH);
    	imagejpeg($_imgFinal, $destFile, $quality);
    }
    public static function ImageFlip ( $imgsrc, $mode )
    {
    
    	$width                        =    imagesx ( $imgsrc );
    	$height                       =    imagesy ( $imgsrc );
    
    	$src_x                        =    0;
    	$src_y                        =    0;
    	$src_width                    =    $width;
    	$src_height                   =    $height;
    
    	switch ( $mode )
    	{
    
    		case '1': //vertical
    			$src_y                =    $height -1;
    			$src_height           =    -$height;
    			break;
    
    		case '2': //horizontal
    			$src_x                =    $width -1;
    			$src_width            =    -$width;
    			break;
    
    		case '3': //both
    			$src_x                =    $width -1;
    			$src_y                =    $height -1;
    			$src_width            =    -$width;
    			$src_height           =    -$height;
    			break;
    
    		default:
    			return $imgsrc;
    
    	}
    
    	$imgdest                    =    imagecreatetruecolor ( $width, $height );
    
    	if ( imagecopyresampled ( $imgdest, $imgsrc, 0, 0, $src_x, $src_y , $width, $height, $src_width, $src_height ) )
    	{
    		return $imgdest;
    	}
    	return $imgsrc;
    }
	public static function RotateFlipImage($source, $distPath, $rotate=0, $flip='')
	{
		$ext  = @strtolower(@substr($source, (@strrpos($source, ".") ? @strrpos($source, ".") + 1 : @strlen($source)), @strlen($source)));
		$ext = ($ext == 'jpg') ? 'jpeg' : $ext;
		$func = "imagecreatefrom$ext";
		$original = $func($source);
		if($flip!=''){
			$original = self::ImageFlip($original,$flip);
		}
		$rotate = $rotate.'.0';
		$angle = -$rotate;//-90.0
		$rotated = imagerotate($original, $angle, 0);
		//header('Content-type: image/'.$ext);
		$funci = "image$ext";
		$funci($rotated, $distPath);
	}
    public static function getAvatar($type, $id, $size = null, $version = null, $cdnType='cache', $sizeC='200x200') {
        $src = Common::storageSolutionEncode($id) . $id . ".jpg";
        $dir = "s0";
        $alowSize = Yii::app()->params['imageSize'];

        if(is_numeric($size)){
        	foreach ($alowSize as $folder => $s) {
        		$dir = $folder;
        		if ($s >= $size)
        			break;
        	}
        }else{
        	$dir = $size;
        }


        if ($type == "video") {
            $dir = "img/" . $dir;
            $configName = "videoImageUrl";
        } else {
            $configName = $type . "Url";
        }
		$v="1";
		if($version){
			$v = "$version";
		}
		switch($cdnType)
		{
			case 'resize':
				$p = $sizeC.'x'.$v;
				$urlCdn = Yii::app()->params['storage']['cdnUrlResize'];
				break;
			case 'crop':
				$p = $sizeC.'x'.$v;
				$urlCdn = Yii::app()->params['storage']['cdnUrlCrop'];
				break;
			default://cache
				$p = $v;
				$urlCdn = Yii::app()->params['storage']['cdnUrlCache'];
				break;
		}

		switch($type)
		{
			case 'artist':
				$folder = 'artists';
				break;
			case 'newsEvent':
				$folder = 'event';
				break;
			case 'video':
				$folder = 'videos';
				break;
			case 'user':
				$folder = 'users';
				break;
			case 'topContent':
				$folder = 'topcontent';
				break;
			default:
				$folder = $type;
		}
        //return Yii::app()->params['storage'][$configName] . $dir . "/" . $src.$v;
        return $urlCdn.$p.'/v1/'.$folder.'/' . $dir . "/" . $src;
    }

    public static function getAvatarJs() {
        $rs = 'var avatarPrefixUrl={};';

        foreach (Yii::app()->params['storage'] as $type => $prefix) {
            if (!strpos($type, 'Dir')){
                $rs.='avatarPrefixUrl["' . $type . '"]="' . $prefix . '";';
            }
        }
        $rs.='function avatarObject(type,id){
                    if(type === "video"){
                        type = "videoImage";
                    }
    	            var result="",level= 0;
    	    		while(true){
    	                var shift   = 13*level;
    	                var layerName  = shift<=32?id >> shift:0;
    	        		if(layerName == 0) break;
    	                result = layerName+"/"+result;
    	                level++;
    	    		}
                    return avatarPrefixUrl[type+"Url"]+(type=="videoImage" ? "/img/s3/" : "s3/") + result+id + ".jpg";
        	}';
        return $rs;
    }

}