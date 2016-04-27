<?php


namespace MVC\Model;


class Fischarten extends ModelDB{
	
	public $id;
	public $name;
	public $latName;
	public $art;
	
	public function getSource(){
		return "fischarten";
	}
}
