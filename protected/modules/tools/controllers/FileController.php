<?php
class FileController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionReadFile()
	{
		$this->layout=false;
		$line = '';
		$filePath = Yii::app()->request->getParam('file_path');
		$lineCount = Yii::app()->request->getParam('line_count',10);;
		if(file_exists($filePath)){
			$fsize = round(filesize($filePath)/1024/1024,2);
			
			$header = "<strong>".$filePath."</strong>\n\n";
			$header .= "File size is {$fsize} megabytes\n\n";
			$header .= "Last ".$lineCount." lines of the file:\n\n";
			$lines = $this->read_file($filePath, $lineCount);
			$html = '<div>';
			$i=1;
			foreach ($lines as $line) {
				$html .= $line;
				$html .= '<br />';
				$i++;
			}
			$html .= '</div>';
		}else{
			$header = "";
			$html = "<div style='color: #F00;'>File path not exists!</div>";
		}
		
		$this->renderPartial('read_file', compact('html','header'));
	}
	protected function read_file($file, $lines) {
		//global $fsize;
		try{
			$handle = fopen($file, "r");
			$linecounter = $lines;
			$pos = -2;
			$beginning = false;
			$text = array();
			while ($linecounter > 0) {
				$t = " ";
				while ($t != "\n") {
					if(fseek($handle, $pos, SEEK_END) == -1) {
						$beginning = true;
						break;
					}
					$t = fgetc($handle);
					$pos --;
				}
				$linecounter --;
				if ($beginning) {
					rewind($handle);
				}
				$text[$lines-$linecounter-1] = fgets($handle);
				if ($beginning) break;
			}
			fclose ($handle);
			return array_reverse($text);
		}catch (Exception $e)
		{
			return $e->getMessage();
		}
	}
}