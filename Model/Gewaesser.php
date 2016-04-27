<?php

namespace MVC\Model;

use \MVC\Library\NotFoundException;

class Gewaesser extends ModelDB{
	public $id;
	public $bezeichnung;
	public $typ;
	
	
	
	public function getSource(){
		return 'gewaesser';
	}
	
	
	public function del(){
		if(!isset($this->id)){
			throw new Exception("leere Instanz");
		}
		
		self::delete((int)$this->id);
	}
	
	
//	public function getFormConfig($name){
//		if(!  property_exists(get_class($this), $name)){
//			echo "here";
//			throw new NotFoundException;
//		}
//		
//		$config = $this->getConfig()["form"];
//		if(array_key_exists($name, $config)){
//			return $config[$name];
//		}
//		
//		return false;
//	}
//	
//	public function getConfig(){
//		return array(
//			"form"	=> array(
//				'bezeichnung'	=> array(
//					'element'	=> 'input',
//					'options'	=> array(
//						'type'		=> 'text',
//						'maxlength'	=> 128,
//						'name'		=> 'id'
//					)
//				),
//				'typ'	=> array(
//					'element'	=> 'select',
//					'options'	=> array(
//						'name'		=> 'typ',
//						'options'	=> function(){
//							$felder = GewaesserTyp::find(array('criteria' => 1));
//							$options = array();
//							foreach($felder as $key => $val){
//								array_push($options, ["value"=>$val->id, "label"=>$val->bezeichnung]);
//							}
//							
//							return $options;
//						}
//					)
//				)
//			)
//		);
//	}
	
}