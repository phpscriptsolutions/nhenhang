<?php
class Utils {
    public static function khongdau($str){

        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
                "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
                ,"ế","ệ","ể","ễ",
                "ì","í","ị","ỉ","ĩ",
                "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
                ,"ờ","ớ","ợ","ở","ỡ",
                "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
                "ỳ","ý","ỵ","ỷ","ỹ",
                "đ",
                "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
                ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
                "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
                "Ì","Í","Ị","Ỉ","Ĩ",
                "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
                ,"Ờ","Ớ","Ợ","Ở","Ỡ",
                "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
                "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
                "Đ");

                $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
                ,"a","a","a","a","a","a",
                    "e","e","e","e","e","e","e","e","e","e","e",
                    "i","i","i","i","i",
                    "o","o","o","o","o","o","o","o","o","o","o","o"
                    ,"o","o","o","o","o",
                    "u","u","u","u","u","u","u","u","u","u","u",
                    "y","y","y","y","y",
                    "d",
                    "A","A","A","A","A","A","A","A","A","A","A","A"
                    ,"A","A","A","A","A",
                    "E","E","E","E","E","E","E","E","E","E","E",
                    "I","I","I","I","I",
                    "O","O","O","O","O","O","O","O","O","O","O","O"
                    ,"O","O","O","O","O",
                    "U","U","U","U","U","U","U","U","U","U","U",
                    "Y","Y","Y","Y","Y",
                    "D");

                    $str = str_replace($marTViet,$marKoDau,$str);
                    return $str;
    }  

    public static function makeDir($path)
    {
    	$path = str_replace(DS, "/", $path);
    	$folders = explode('/',$path);
    	$tmppath = "/";
    	for($i=1;$i < count($folders); $i++){
    		if(!file_exists($tmppath.$folders[$i]) && !mkdir($tmppath.$folders[$i],0775)) {
    			return false;
    		}
    		@chmod($tmppath.$folders[$i], 0775);
    		$tmppath = $tmppath.$folders[$i].'/';
    	}
    	return true;
    }

    public static function emptyDir($dir, $DeleteMe = false) {
    	if(!$dh = @opendir($dir)) return;
    	while (false !== ($obj = readdir($dh))) {
    		if($obj=='.' || $obj=='..') continue;
    		if (!@unlink($dir.'/'.$obj)) self::emptyDir($dir.'/'.$obj, true);
    	}
    	closedir($dh);
    	if ($DeleteMe){
    		@rmdir($dir);
    	}
    }
    public static function getExtension($fileName)
    {
    	$FileExtension = strrpos($fileName, ".", 1) + 1;
    	if ($FileExtension != false)
    		return strtolower(substr($fileName, $FileExtension, strlen($fileName) - $FileExtension));
    	else
    		return "";
    }
    public static  function getCurentSite()
    {
    	return Yii::app()->request->baseUrl;
    }

    public static function priceFormat ($price) {
    	return number_format($price, 2, ',', ' ');

    	$price = sprintf('%.0f', $price);
    	$price = str_replace('.', ',', $price);
    	while (true) {
    		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $price);
    		if ($replaced != $price) {
    			$price = $replaced;
    		} else {
    			break;
    		}
    	}
    	$price = str_replace(',', '.', $price);
    	$price .= ' '.'đ';

    	return $price;
    }

    public static function getFirstDayOfWeek($year, $weeknr)
    {
    	$offset = date('w', mktime(0,0,0,1,1,$year));
    	$offset = ($offset < 5) ? 1-$offset : 8-$offset;
    	$monday = mktime(0,0,0,1,1+$offset,$year);
    	$date = strtotime('+' . ($weeknr - 1) . ' weeks', $monday);
    	return $date;
    }
    public static function getCdnStaticUrl($fileName,$path,$version=1)
    {
        $dir = $path;

        $url = Yii::app()->params['storage']['cdnUrlCache'].$version.'/v1/static/'.$dir.'/'.$fileName;
        return $url;
    }
    public static function getCdnLink($cmcId, $profile,$content='song')
    {
        $relativePath = self::makeRelativeUrl($cmcId, $profile, $content);
        return self::makeCdnLink($relativePath);
    }
    public static function getEncryptLink($link,$linkExt='.mp3')
    {
        $key = Yii::app()->params['hash_key_player'];
        Yii::import("application.vendors.Hashids.*");
        $hashids = new Hashids($key);
        $arrayUrl = explode("/",$link);
        $c = count($arrayUrl);
        $arrayUrl[$c-2] = $hashids->encode($arrayUrl[$c-2]);
        $arrayUrl[$c-1] = $hashids->encode(str_replace("$linkExt", "", $arrayUrl[$c-1]));

        $newUrl = implode("/", $arrayUrl)."$linkExt";
        return $newUrl;
    }
    /**
     * create link streaming song, video
     * @param $relativePath
     * @return string
     */
    public static function makeCdnLink($relativePath)
    {
        //$secretKey = "ifa0e8f3fd";
        $secretKey = "ifa0e82015";
        $time = sprintf("%08x", time());
        $encryptionString = md5($secretKey . $relativePath . $time);
        $encryptionString = substr($encryptionString, 0, 8);
        //return "http://st.media.chacha.vn/" . $encryptionString . '/' . $time . $relativePath;
        return "http://music.vegacdn.vn/" . $encryptionString . '/' . $time . $relativePath;
    }

    /**
     * create relativeUrl CDN
     * @param $cmcId
     * @param $profile
     * @param string $content
     * @return string
     */
    public static function makeRelativeUrl($cmcId, $profile,$content='song') {
        $id = $cmcId;
        /*$profile = array(
            'profile_name'=>'web1',
            'format'=>'mp3'
        );*/
        $fileName = $id.".".$profile['format'];
        $solutionPath = self::storageSolutionEncode($id);
        $path = $solutionPath.$fileName;
        $mediaPath = self::getMediaPath($id,$content);
        $path = '/'.$mediaPath.'/'.$content.'/'.$profile['profile_name'].'/'.$path;
        return $path;
    }

    /**
     * getMediaPath CDN
     * @param $id
     * @param string $object
     * @return int|string
     */
    public static function getMediaPath($id,$object='song'){
        $storagePath = array(
            'song'=>array(
                'media1'=>array('min'=>0,'max'=>9999999999999),
            ),
            'video'=>array(
                'media1'=>array('min'=>0,'max'=>9999999999999),
            ),
        );
        $storagePath = $storagePath[$object];
        foreach($storagePath as $key=>$val){
            if($id > $val['min'] && $id<= $val['max']){
                return $key;
            }
        }
        return "";
    }

    /**
     * @param $objID
     * @param bool $isUrl
     * @return string
     */
    public static function storageSolutionEncode($objID, $isUrl = true)
    {
        $step           = 13;    //so bit de ma hoa ten thu muc tren 1 cap
        $max_bits       = PHP_INT_SIZE*8;
        $separator      = $isUrl ? "/" : DS;
        $result         = "";

        // start caculate
        $level            = 0;
        while(true)
        {
            $shift   = $step*$level;
            $layerName  = $shift<=$max_bits?$objID >> $shift:0;

            if($layerName == 0) break;
            $result = $layerName.$separator.$result;
            $level++;
        }

        return $result;
    }
}
