<?php


namespace MVC\Model;

use MVC\Model\ModelDB;

class FanglisteBilder extends ModelDB{
	
	public $id;
	public $fangliste;
	public $name;
	public $pfad;
	public $type;
	
	
	public function del(){
		if(!isset($this->id)){
			throw new Exception("leere Instanz");
		}
		
		self::delete((int)$this->id);
	}
	
	public function getSource(){
		return "fangliste_bilder";
	}
}
