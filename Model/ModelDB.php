<?php

namespace MVC\Model;

abstract class ModelDB {
	
	private static $pdo;
	
	public function getPdo(){
		if(self::$pdo === null){
			self::$pdo = new \PDO('mysql:host=localhost;charset=utf8;dbname=mvc', 'root', '1234');
		}
		
		return self::$pdo;
	}
	
	
	public function delete($options){
		$table = $this->getSource();
		$pdo = $this->getPdo();
		
		if (is_array($options) && isset($options['criteria'])) {
			$stmt = $pdo->prepare('DELETE FROM `'.$table.'` WHERE '.$options["criteria"]);
			$options['bind'] = (isset($options["bind"])) ? $options["bind"] : array();
			$stmt->execute($options["bind"]);
		}
		
		if (is_int($options)) {
//			var_dump('DELETE FROM `'.$table.'` WHERE id = '.$options);
			$stmt = $pdo->prepare('DELETE FROM `'.$table.'` WHERE id = ?');
			$stmt->execute([$options]);
		} elseif (is_array($options) && isset($options['criteria'])) {
			$stmt = $pdo->prepare('DELETE FROM `'.$table.'` WHERE '.$options["criteria"]);
			$options['bind'] = (isset($options["bind"])) ? $options["bind"] : array();
			$stmt->execute($options["bind"]);
		} else {
		   throw new \UnexpectedValueException('you need to specify the criteria');
		}
	}
	
	
	public static function findFirst($options){
		$model = new static();
		$table = $model->getSource();

		$pdo = $model->getPdo();

		if (is_int($options)) {
			$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE id = ? LIMIT 1');
			$stmt->execute([$options]);
		} elseif (is_array($options) && isset($options['criteria'])) {
			$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria'].' LIMIT 1');
			$options['bind'] = (isset($options["bind"])) ? $options["bind"] : array();
			$stmt->execute($options['bind']);
		} else {
			throw new \UnexpectedValueException('you need to specify the criteria');
		}

		return $stmt->fetchObject(get_class($model));
	}
	
	
	public static function find(array $options){
		$model = new static();
		$table = $model->getSource();

		$pdo = $model->getPdo();

		if (!isset($options['criteria'])) {
		   throw new \UnexpectedValueException('you need to specify the criteria');
		}
		
		$options['bind'] = (isset($options["bind"])) ? $options["bind"] : array();
		
		$stmt = $pdo->prepare('SELECT * FROM `'.$table.'` WHERE '.$options['criteria']);
		$stmt->execute($options['bind']);

		return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
	}
	
	
	public function save(){
		$table = $this->getSource();
		$pdo = $this->getPdo();

		$fields = [];
		foreach ($this as $name => $val) {
			if ($val === null) {
				$fields[] = "`$name`=null";
			} elseif (is_int($val)) {
				$fields[] = "`$name`=".$val;
			} else {
				$fields[] = "`$name`=".$pdo->quote($val);
			}
		}

		if ($this->id === null) {
			if (!$pdo->exec('INSERT INTO `'.$table.'` SET '.implode(',', $fields))) {
				throw new \RuntimeException('Could not create '.get_class($this).': '.$pdo->errorInfo()[2]);
			}
			$this->id = $pdo->lastInsertId();
		} else {
			if ($pdo->exec('UPDATE `'.$table.'` SET '.implode(',', $fields).' WHERE `id` = '.((int)$this->id)) === FALSE) {
				throw new \RuntimeException('Could not update '.get_class($this).': '.$pdo->errorInfo()[2]);
			}
		}
	}
	
	
	public static function loadFromArray($arr=array()){
		$model = new Static();
		foreach($model as $key => $val){
			if(array_key_exists($key, $arr)){
				$model->{$key} = $arr[$key];
			}
		}
		
		return $model;
	}
	
	
	private function getFields(){
		$pdo = $this->getPdo();
		$fields = [];
		foreach ($this as $name => $val) {
			if ($val === null) {
				$fields[] = "`$name`=null";
			} elseif (is_int($val)) {
				$fields[] = "`$name`=".$val;
			} else {
				$fields[] = "`$name`=".$pdo->quote($val);
			}
		}
		return $fields;
	}
	
	
	public function getConfig(){
		
	}

	
 
	abstract public function getSource();
	
}