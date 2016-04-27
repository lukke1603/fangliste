<?php

namespace MVC\Library;


class Formular{
	
	private $regex;
	
	
	public function __construct(){
		$this->regex = $this->initRegex();
	}
	
	public function getRegex($feld){
		if(!isset($this->regex)){
			$this->regex = $this->initRegex();
		}
		$feld = trim(strtolower($feld));
		if(key_exists($feld, $this->regex)){
			return $this->regex[$feld];
		}
		
		return "";
	}
	
	
	private function initRegex(){
		return array(
			'zahl'		=> '[0-9]'	
		);
	}
	
	
	
	
	
	/**  private $name;
	private $model;
	private $felder;
	private $classAttribute = "form-feld";
	
	
	public function __construct($name, $model){
		$this->name = $name;
		$this->model = $model;
		
		$this->init();
	}
	
	
	private function init(){
		foreach($this->model as $name => $val){
			$config = $this->model->getFormConfig($name);
			if(is_array($config)){
				$this->felder[$name] = $config;
			}
		}
	}
	
	
	public function startForm($action, $method="POST"){
		return "<form action='".$action."' method='".$method."' name='".$this->name."' >";
	}
	
	public function endForm(){
		return "</form>";
	}
	
	
	public function get($name){
		$feld = $this->felder[$name];
		switch($feld["element"]){
			case "input":	
				$element = $this->prepareInputField($feld['options']);
				break;
			
			case "select":
				$element = $this->prepareSelectBox($feld['options']);
				break;
		}
		
		return $element;
	}
	
	
	public function prepareInputField($feld){
		$element = "<input class='".$this->classAttribute."' ";
		foreach($feld as $key => $val){
			$element .= $key."='".$val."' ";
		}
		
		$element .= "/>";
		
		return $element;
	}
	
	
	public function prepareSelectBox($feld){
		$element = "<select class='".$this->classAttribute."' ";
		$optionString = "";
		foreach($feld as $key => $val){
			if($key==="options"){
				if(strtolower(gettype($val)) === "string"){
					$optionString = $val;
				}elseif(strtolower(gettype($val)) === "array" ){
					foreach($val as $key => $wert){
						$optionString .= "<option value='".$wert["value"]."' >".$wert["label"]."</option>";
					}
				}elseif(strtolower(gettype($val)) === "object" ){
					$werte = $val();
					foreach($werte as $key => $wert){
						$optionString .= "<option value='".$wert["value"]."' >".$wert["label"]."</option>";
					}
				}else{
					throw new Exception("Unbekannter Datentyp des Parameters");
				}
			}else{
				$element .= $key."='".$val."' ";
			}
		}
		$element .= ">" . $optionString . "</select>";

		return $element;
	}  */
	
	
	
	
}
