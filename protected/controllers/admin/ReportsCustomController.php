<?php
class ReportsCustomController extends Controller
{
	public function actionIndex()
	{
            
            
		$result = null;
		$errors = array();
		
		if(Yii::app()->getrequest()->ispostrequest){
			$cmdId = Yii::app()->request->getParam('cmd_id',0);
			$newName = Yii::app()->request->getParam('cmd_new_name',null);
			$sqlString = Yii::app()->request->getParam('cmd_sql');
				
			if(!$cmdId || $newName){
				$sqlModel = new AdminSqlStatisticModel;
				$sqlModel->name = $newName?$newName:$sqlString;
			}else{
				$sqlModel = AdminSqlStatisticModel::model()->findByPk($cmdId);
			}
			
			if (strrpos(strtoupper($sqlString), "UPDATE ") !== false || strrpos(strtoupper($sqlString), "DELETE ") !== false) {
				$errors[] = "Query <b>{$sqlString}</b> không hợp lệ";
			}else{
				$sqlModel->sql_string = $sqlString;
				if($sqlModel->save()){
					$this->redirect(array('index','id'=>$sqlModel->id));
				}else{
					$errors = array_merge($errors,$sqlModel->getErrors());
				}
			}			
		} 
		
		$id = Yii::app()->request->getParam('id',0);
		$sqlObj =  AdminSqlStatisticModel::model()->findByPk($id);
		if(empty($sqlObj)){
			$errors[] = "Chưa chọn lệnh hoặc không tồn tại lệnh nào";
		}else{
			try {
				$result = Yii::app()->db->createCommand($sqlObj->sql_string)->queryAll();				
			}
			catch (Exception  $e){
				$errors[] = $e->getMessage();
			}			
		}

		$data = AdminSqlStatisticModel::model()->findAll();
                
                
                if(Yii::app()->request->getParam('export',false))
                {
                    $part = Yii::app()->request->getParam('part','');
                    $cols = array();
                    
                    foreach($result[0] as $k=>$v){
                            $cols[$k] = $k;
                    }
                    ini_set('display_errors','On');
                    $label = $cols;                                        
                    $title = Yii::t('admin','export');                   
                    
                    
                    $arr_result = array_chunk($result, 65000);
                    $arr_index = 0;
                    
                    if(!empty($part))
                        $arr_index = $part;
                    
                    $excelObj = new ExcelExport($arr_result[$arr_index], $label, $title);
                    $excelObj->export();                                        
                }
                
                $count_part = 0;                
                $arr_count_part = array_chunk($result, 65000);
                $count_part = count($arr_count_part);
                
		$this->render("index",
                        array(
                            'data'=>$data,
                            'sqlObj'=>$sqlObj,
                            'result'=>$result,
                            'errors'=>$errors,
                            'link'=>$count_part,
                        ));
                
                
               
	}
}