<?php

class CopyrightInputFileModel extends BaseCopyrightInputFileModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CopyrightInputFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function isUtf8($string) {
		if (function_exists("mb_check_encoding") && is_callable("mb_check_encoding")) {
			return mb_check_encoding($string, 'UTF8');
		}
		return preg_match('%^(?:
			  [\x09\x0A\x0D\x20-\x7E]            # ASCII
			| [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
			|  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
			|  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			|  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			| [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
			|  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
		)*$%xs', $string);
	}

	public function my_encoding($string) {
		if (!$this->isUtf8($string)) {
			$string = utf8_encode($string);
		}
		return mysql_escape_string(trim($string));
	}
}