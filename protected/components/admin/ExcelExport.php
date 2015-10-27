<?php
class ExcelExport
{
	public $dataSoure = array();
	public $attribute = array();
	public $title = "";
	
	public function __construct($data,$label,$title)
	{
		$this->dataSoure = $data;
		$this->attribute = $label;
		$this->title	= $title;
	}
	
	public function export()
	{
		spl_autoload_unregister(array('YiiBase','autoload'));
		
		$phpExcelPath = Yii::getPathOfAlias('application.vendors');
		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0);
		// Set style for column name
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
		$rows = 1;
		$totalColumn = count($this->attribute);
		
		
		$objPHPExcel->getActiveSheet()
		->setCellValueByColumnAndRow(0, $rows, $this->title)
		->mergeCellsByColumnAndRow(0, 1, $totalColumn - 1, 1);
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $rows)
									  ->getFont()->setBold(true)->setSize(14);
		
		
		$rows ++;
		$i=0;
		foreach($this->attribute as $key=>$value){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $rows, $value);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $rows)->getFont()->setBold(true)->setSize(10);
			$i++;
		}
		$rows ++;
		for($i = 0; $i <= $totalColumn; $i++) {
			$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		}
		
		foreach($this->dataSoure as $data){
			$i=0;
			foreach($this->attribute as $key=>$value){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $rows, $data[$key]);
				$i++;
			}
			$rows ++;
		}
		
		$fileName = $this->title."-".date('Ymd', time()).'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		Yii::app()->end();
		spl_autoload_register(array('YiiBase','autoload'));
	}
}
