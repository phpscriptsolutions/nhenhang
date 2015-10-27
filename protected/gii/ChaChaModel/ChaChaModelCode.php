<?php
/**
-------------------------
AUTO GENERATOR MODEL FOR CHACHA PROJECT
@Author: ThangTv
@Date: 2011-09-07
-------------------------
*/



Yii::import('system.gii.generators.model.ModelCode');
class ChaChaModelCode extends ModelCode
{
    public function prepare()
    {
        $this->files=array();
        $templatePath=$this->templatePath;

        if(($pos=strrpos($this->tableName,'.'))!==false)
        {
            $schema=substr($this->tableName,0,$pos);
            $tableName=substr($this->tableName,$pos+1);
        }
        else
        {
            $schema='';
            $tableName=$this->tableName;
        }
        if($tableName[strlen($tableName)-1]==='*')
            $tables=Yii::app()->db->schema->getTables($schema);
        else
            $tables=array($this->getTableSchema($this->tableName));

        $relations=$this->generateRelations();

        foreach($tables as $table)
        {
            $tableName=$this->removePrefix($table->name);
            $className=$this->generateClassName($table->name);
            $params=array(
                'tableName'=>$schema==='' ? $tableName : $schema.'.'.$tableName,
                'modelClass'=>$className,
                'columns'=>$table->columns,
                'labels'=>$this->generateLabels($table),
                'rules'=>$this->generateRules($table),
                'relations'=>isset($relations[$className]) ? $relations[$className] : array(),
            );

            $this->files[] = new CCodeFile(
                    Yii::getPathOfAlias($this->modelPath) . '/db/_base/Base' . $className . 'Model.php',
                    $this->render($templatePath . '/model-base.php', $params)
            );
            
            $this->files[] = new CCodeFile(
                    Yii::getPathOfAlias($this->modelPath) . '/db/' . $className . 'Model.php',
                    $this->render($templatePath . '/model.php', $params)
            );
            
            $this->files[] = new CCodeFile(
                    Yii::getPathOfAlias($this->modelPath) . '/admin/Admin' . $className . 'Model.php',
                    $this->render($templatePath . '/model-admin.php', $params)
            );
        }
    }
}