<?php
class Common {
    /**
     *
     * Load language message by category
     * @param STRING $category
     * @return ARRAY
     */
    public static function loadMessages($category) {
        $languageFile = Yii::app()->getBasePath().DIRECTORY_SEPARATOR."messages".DIRECTORY_SEPARATOR.Yii::app()->getLanguage().DIRECTORY_SEPARATOR."{$category}.php";
        if(!file_exists($languageFile)) $languageFile = Yii::app()->getBasePath().DIRECTORY_SEPARATOR."messages".DIRECTORY_SEPARATOR.Yii::app()->getLanguage().DIRECTORY_SEPARATOR."yii.php";
        if(file_exists($languageFile)) return require($languageFile);
        return;
    }

    public static  function getSavedName($itemId, $itemPerDir = 1024) {
        $dir1 = floor($itemId / ($itemPerDir * $itemPerDir * $itemPerDir));
        $dir2 = floor(($itemId - $dir1 * $itemPerDir * $itemPerDir * $itemPerDir) / ($itemPerDir * $itemPerDir));
        $temp = floor($itemId / ($itemPerDir * $itemPerDir));
        $dir3 = floor(($itemId - $temp * $itemPerDir * $itemPerDir) / $itemPerDir);
        $path = $dir1 . "/" . $dir2 . "/" . $dir3."/";
        return $path;
    }

    public static function getPathStorage($rootDir, $itemId, $itemPerDir = 1024, $makeDir = true)
    {
        $dir1 = floor($itemId / ($itemPerDir * $itemPerDir * $itemPerDir));
        $dir2 = floor(($itemId - $dir1 * $itemPerDir * $itemPerDir * $itemPerDir)/($itemPerDir * $itemPerDir));
        $temp = floor($itemId / ($itemPerDir * $itemPerDir));
        $dir3 = floor(($itemId -  $temp * $itemPerDir * $itemPerDir)/$itemPerDir);

        $path = $dir1 . "/" . $dir2 . "/" .$dir3;

        if (!file_exists($rootDir. "/" . $path) && ($makeDir))
        {
            if (!file_exists($rootDir. "/" . $dir1 . "/" . $dir2))
            {
                if (!file_exists($rootDir. "/" . $dir1))
                {
                    mkdir($rootDir. "/" . $dir1, true);
                }
                chmod($rootDir. "/" . $dir1, 0775 );
                mkdir($rootDir. "/" . $dir1 . "/" . $dir2, true);
            }
            //mkdir($rootDir. "/" . $dir1 . "/" . $dir2, true);
            chmod($rootDir. "/" . $dir1 . "/" . $dir2, 0775 );

            mkdir($rootDir. "/" . $dir1 . "/" . $dir2 . "/" . $dir3, true);
            chmod($rootDir. "/" . $dir1 . "/" . $dir2 . "/" . $dir3, 0775 );
        }
        return $path;
    }

	public static function storageSolutionEncode($objID, $isUrl = true)
	{
		return self::getSavedName($objID);
		
	    /* $step           = 13;    //so bit de ma hoa ten thu muc tren 1 cap
	    $max_bits       = PHP_INT_SIZE*8;
	    $separator      = $isUrl ? "/" : DIRECTORY_SEPARATOR;
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

	    return $result; */
	}


	public static function json2array($json){
		if (isset($json)){
			return json_decode($json, true);
		}
		else{
			return "";
		}
	}

	public static function endcoderPassword($password)
	{
		return md5($password);
	}
        
         

    /**
     *
     * Create an url string
     * @staticvar ARRAY $charMap
     * @param STRING $string
     * @return STRING
     */
    public static function makeFriendlyUrl($string, $allowUnder = false)
    {
        static $charMap = array(
                    "à"=>"a","ả"=>"a","ã"=>"a","á"=>"a","ạ"=>"a","ă"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ắ"=>"a","ặ"=>"a","â"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ấ"=>"a","ậ"=>"a",
                    "đ"=>"d",
                    "è"=>"e","ẻ"=>"e","ẽ"=>"e","é"=>"e","ẹ"=>"e","ê"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ế"=>"e","ệ"=>"e",
                    "ì"=>'i',"ỉ"=>'i',"ĩ"=>'i',"í"=>'i',"ị"=>'i',
                    "ò"=>'o',"ỏ"=>'o',"õ"=>"o","ó"=>"o","ọ"=>"o","ô"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ố"=>"o","ộ"=>"o","ơ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ớ"=>"o","ợ"=>"o",
                    "ù"=>"u","ủ"=>"u","ũ"=>"u","ú"=>"u","ụ"=>"u","ư"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ứ"=>"u","ự"=>"u",
                    "ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ý"=>"y","ỵ"=>"y",
                    "À"=>"A","Ả"=>"A","Ã"=>"A","Á"=>"A","Ạ"=>"A","Ă"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ắ"=>"A","Ặ"=>"A","Â"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ấ"=>"A","Ậ"=>"A",
                    "Đ"=>"D",
                    "È"=>"E","Ẻ"=>"E","Ẽ"=>"E","É"=>"E","Ẹ"=>"E","Ê"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ế"=>"E","Ệ"=>"E",
                    "Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Í"=>"I","Ị"=>"I",
                    "Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ó"=>"O","Ọ"=>"O","Ô"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ố"=>"O","Ộ"=>"O","Ơ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ớ"=>"O","Ợ"=>"O",
                    "Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ú"=>"U","Ụ"=>"U","Ư"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ứ"=>"U","Ự"=>"U",
                    "Ỳ"=>"Y","Ỷ"=>"Y","Ỹ"=>"Y","Ý"=>"Y","Ỵ"=>"Y",
        );

        $string = strtr($string, $charMap);

        $string = self::CleanUpSpecialChars($string, $allowUnder);
        return strtolower($string);
    }
    public static function makeFriendlyStoryUrl($string, $allowUnder = false)
    {
        static $charMap = array(
            "à"=>"a","ả"=>"a","ã"=>"a","á"=>"a","ạ"=>"a","ă"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ắ"=>"a","ặ"=>"a","â"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ấ"=>"a","ậ"=>"a",
            "đ"=>"d",
            "è"=>"e","ẻ"=>"e","ẽ"=>"e","é"=>"e","ẹ"=>"e","ê"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ế"=>"e","ệ"=>"e",
            "ì"=>'i',"ỉ"=>'i',"ĩ"=>'i',"í"=>'i',"ị"=>'i',
            "ò"=>'o',"ỏ"=>'o',"õ"=>"o","ó"=>"o","ọ"=>"o","ô"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ố"=>"o","ộ"=>"o","ơ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ớ"=>"o","ợ"=>"o",
            "ù"=>"u","ủ"=>"u","ũ"=>"u","ú"=>"u","ụ"=>"u","ư"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ứ"=>"u","ự"=>"u",
            "ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ý"=>"y","ỵ"=>"y",
            "À"=>"A","Ả"=>"A","Ã"=>"A","Á"=>"A","Ạ"=>"A","Ă"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ắ"=>"A","Ặ"=>"A","Â"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ấ"=>"A","Ậ"=>"A",
            "Đ"=>"D",
            "È"=>"E","Ẻ"=>"E","Ẽ"=>"E","É"=>"E","Ẹ"=>"E","Ê"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ế"=>"E","Ệ"=>"E",
            "Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Í"=>"I","Ị"=>"I",
            "Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ó"=>"O","Ọ"=>"O","Ô"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ố"=>"O","Ộ"=>"O","Ơ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ớ"=>"O","Ợ"=>"O",
            "Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ú"=>"U","Ụ"=>"U","Ư"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ứ"=>"U","Ự"=>"U",
            "Ỳ"=>"Y","Ỷ"=>"Y","Ỹ"=>"Y","Ý"=>"Y","Ỵ"=>"Y",
        );

        $string = strtr($string, $charMap);

        $string = self::CleanUpSpecialChars($string, $allowUnder);
        return $string;
    }

    public static function CleanUpSpecialChars($string, $allowUnder = false){
        //$string = preg_replace( array("`[^a-zA-Z0-9\$_+*'()]`i","`[-]+`") , "-", $string);
        $regExpression = "`\W`i";
        if($allowUnder) $regExpression = "`[^a-zA-Z0-9-]`i";

        $string = preg_replace( array($regExpression, "`[-_]+`",) , "-", $string);

        $symbol = array(',',';');
        $string = str_replace("--", "-", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace("_", "-", $string);
        $string = str_replace($symbol, " ", $string);
        return trim($string, '-');
    }

	public static function strNormal($str)
	{
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
                "Đ",
                '“','”');

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
                    "D",
                    '"','"');

                    $str = str_replace($marTViet,$marKoDau,$str);
                    return $str;
	}
    public static function checkValidPattern($str, $pattern='')
    {
        $regexPattern = empty($pattern)?'/[\ \'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/':$pattern;
        if(preg_match($regexPattern,$str)){
            return false;
        }else{
            return true;
        }
    }
	public static function url_friendly($str,$type="")
	{
		$str = self::strNormal($str);
		$str = str_replace('.','', $str);
		$str = str_replace('%','',$str);
		$str = str_replace('#','',$str);
		$str = str_replace('?','',$str);
		$str = str_replace('/','',$str);
		$str = str_replace('(','',$str);
		$str = str_replace(')','',$str);
		$str = str_replace('[','',$str);
		$str = str_replace(']','',$str);
		$str = str_replace('{','',$str);
		$str = str_replace('}','',$str);
		$str = str_replace('+','-',$str);
		$str = str_replace('_','-',$str);
		$str = str_replace(' ','-',$str);
        $str = str_replace('&','-',$str);
        $str = str_replace("--", "-", $str);
		$str = mb_strtolower($str, 'UTF-8');
		return $str;
	}

	public static function _player($fileUrl){
		return <<<EOD
		<object width="290" height="24" type="application/x-shockwave-flash" data="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf" id="audioplayer1">
			                <param name="movie" value="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf">
			                <param name="FlashVars" value="playerID=1&amp;soundFile='.$fileUrl.'">
			                <param name="quality" value="high">
			                <param name="menu" value="false">
			                <param name="wmode" value="transparent">
			            </object>

EOD;

	}

    /**
     * get song profile, store in the session
     * @param INT $profileId
     * @return SongProfile[]
     */
    public static function getSongProfile($profileId) {
        if(!isset($_SESSION['songProfiles'][$profileId]))
        {
            $songProfile = SongProfileModel::model()->findByAttributes(array('profile_id' => $profileId));
            $_SESSION['songProfiles'][$profileId] = array(
                'id'    		=> $songProfile->id,
                'profile_id'    => $songProfile->profile_id,
                'format'    	=> $songProfile->format,
                'http_support'  => $songProfile->http_support,
                'rtsp_support'  => $songProfile->rtsp_support,
                'rtmp_support'  => $songProfile->rtmp_support,
                'name'  		=> $songProfile->name,
            );
        }

        return $_SESSION['songProfiles'][$profileId];
    }

    /**
     * get video profile, store in the session
     * @param INT $profileId
     * @return VideoProfile[]
     */
    public static function getVideoProfile($profileId) {
        if(!isset($_SESSION['videoProfiles'][$profileId]))
        {
            $profile = VideoProfileModel::model()->findByAttributes(array('profile_id' => $profileId));
            $_SESSION['videoProfiles'][$profileId] = array(
                'id'    		  => $profile->id,
                'name'    		  => $profile->profile_name,
                'profile_id'      => $profile->profile_id,
                'format'    	  => $profile->format,
                'http_support'    => $profile->http_support,
                'rtsp_support'    => $profile->rtsp_support,
                'rtmp_support'    => $profile->rtmp_support,
                'quality_name'    => $profile->quality_name
            );
        }

        return $_SESSION['videoProfiles'][$profileId];
    }


    public static function genLinkStream($domain, $relativePath)
	{
		$time = time();
		$time = sprintf("%08x", $time);
		$secretKey = "885be4c5bc8998";
		
		$encryptionString = md5($secretKey . $relativePath . $time);
		$encryptionString = substr($encryptionString, 0, 8);
		
		return $domain."/" . $encryptionString . '/' . $time . $relativePath ;
	}
	

	public static function getMediaPath($id,$object='song'){
		$storagePath = Yii::app()->params['storage_path'][$object];
		foreach($storagePath as $key=>$val){
			if($id > $val['min'] && $id<= $val['max']){
				return $key;
			}
		}
		return "";
	}

	public static function iever($compare=false, $to=NULL){
		if(!preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $m)
		|| preg_match('#Opera#', $_SERVER['HTTP_USER_AGENT']))
			return false === $compare ? false : NULL;

		if(false !== $compare
		&& in_array($compare, array('<', '>', '<=', '>=', '==', '!='))
		&& in_array((int)$to, array(5,6,7,8,9,10))){
			return eval('return ('.$m[1].$compare.$to.');');
		}
		else{
			return (int)$m[1];
		}
	}

	public static function getLinkIconsRadio($id, $type="channel")
	{
		$id = intval($id);
		$radioUrl = Yii::app()->params['storage']['radioUrl'];
		return $url = $radioUrl.$type.'/'.$id.'.png?t='.time();
	}
	public static function randomPassword($length=6) {
		$str = "0123456789abcdefghijklmopqrstuxyz";
		$min = 0;
		$max = strlen($str)-1;
		$password = "";
		for($i=0; $i<$length; $i++)
		{
		$char = $str[mt_rand($min, $max)];
		$password .= $char;
		}
		return array("realPass"=>$password,'encoderPass'=>md5($password));
	}
        
     public static function getTime(){
        $time = time();
        $dayOfWeek = date('N', $time);
        switch ($dayOfWeek) {
            case 1:
                $dayOfWeek = Yii::t('web', 'Monday');
                break;
            case 2:
                $dayOfWeek = Yii::t('web', 'Tuesday');
                break;
            case 3:
                $dayOfWeek = Yii::t('web', 'Wednesday');
                break;
            case 4:
                $dayOfWeek = Yii::t('web', 'Thursday');
                break;
            case 5:
                $dayOfWeek = Yii::t('web', 'Friday');
                break;
            case 6:
                $dayOfWeek = Yii::t('web', 'Saturday');
                break;
            default:
                $dayOfWeek = Yii::t('web', 'Sunday');
                break;
        }
        $timePoint = date('H:i:s', $time);
        if ($timePoint >= '00:00:00' && $timePoint <= '12:00:00') {
            //sang
            $timePoint = Yii::t('web', 'Morning');
        } elseif ($timePoint > '12:00:00' && $timePoint <= '19:00:00') {
            //chieu
            $timePoint = Yii::t('web', 'Afternoon');
        } else {
            //toi
            $timePoint = Yii::t('web', 'Noon');
        }
        $array = array('dayOfWeek'=>$dayOfWeek,
                    'timePoint'=>$timePoint);
        return $array;
    }
    public static function ieVersionError($compare=false, $to=NULL)
    {
        if(!preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $m)
            || preg_match('#Opera#', $_SERVER['HTTP_USER_AGENT']))
            $ieVersion = false === $compare ? false : NULL;

        if(false !== $compare
            && in_array($compare, array('<', '>', '<=', '>=', '==', '!='))
            && in_array((int)$to, array(5,6,7,8,9,10))){
            $ieVersion = eval('return ('.$m[1].$compare.$to.');');
        }
        else{
            $ieVersion = isset($m[1])?(int)$m[1]:false;
        }

        if($ieVersion && $ieVersion<=9) return true;
        return false;
    }
}
?>
