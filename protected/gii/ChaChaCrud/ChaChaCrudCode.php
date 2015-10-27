<?php

Yii::import('system.gii.generators.crud.CrudCode');
class ChaChaCrudCode extends CrudCode
{
    	private $_modelClass;
	private $_table;

        
	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}


	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		$class=Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		else if(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			else if(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}



	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		else if(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "\$form->checkBox(\$model,'{$column->name}')";
		else if(stripos($column->dbType,'text')!==false)
			return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
			else
				$inputField='textField';

			if($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}
}