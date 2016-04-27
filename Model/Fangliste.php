<?php


namespace MVC\Model;


class Fangliste extends ModelDB{
	
	public $id;
	public $benutzer;
	public $fischart;
	public $laenge;
	public $gewicht;
	public $gewaesser;
	public $datum;
	public $koeder;
	
	
	public function del(){
		if(!isset($this->id)){
			throw new Exception("leere Instanz");
		}
		
		self::delete((int)$this->id);
	}
	
	public function getSource(){
		return "fangliste";
	}
	
}
